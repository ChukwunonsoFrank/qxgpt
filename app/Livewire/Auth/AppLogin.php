<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout("components.layouts.auth.layout")]
#[Title("App Login")]
class AppLogin extends Component
{
  #[Validate("required|string|email")]
  public string $email = "";

  #[Validate("required|string")]
  public string $password = "";

  public bool $remember = false;

  /**
   * Handle an incoming authentication request.
   */
  public function login()
  {
    try {
      $user = User::where("email", "=", $this->email, "and")->first();

      if ($user["is_banned"]) {
        $this->dispatch(
          "login-error",
          message: "Your account has been banned. Reach out to support at support@yfxai.com.",
        )->self();
        return;
      }

      if ($user && $user["two_factor_enabled"]) {
        $this->redirectRoute("applogin.verifylogintwofa", [
          "email" => $this->email,
          "password" => $this->password,
        ]);
      } else {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (
          !Auth::attempt(
            [
              "email" => $this->email,
              "password" => $this->password,
            ],
            $this->remember,
          )
        ) {
          RateLimiter::hit($this->throttleKey());

          throw ValidationException::withMessages([
            "email" => __("auth.failed"),
          ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        session()->flash("just_logged_in", true);

        session(["device" => "app"]);

        $loggedInUser = User::find(Auth::id(), ["*"]);

        if (
          $loggedInUser->country === null ||
          $loggedInUser->country === "N/A"
        ) {
          $ipApiEndpoint =
            "http://ip-api.com/json/" . $this->getClientIPV4();

          $ipApiResponse = Http::get($ipApiEndpoint);

          $ipApiResult = $ipApiResponse->json();

          $loggedInUser->country =
            $ipApiResponse->successful() &&
            $ipApiResult["status"] === "success"
            ? $ipApiResult["country"]
            : "N/A";

          $loggedInUser->ip_address = $this->getClientIPV4();
        }

        $loggedInUser->last_login_at = now();
        $loggedInUser->save();

        if (Auth::user()->is_admin) {
          return redirect("/admin/dashboard");
        }

        $this->redirectIntended(
          default: route("dashboard.robot", absolute: false),
        );
      }
    } catch (\Exception $e) {
      $this->dispatch("login-error", message: $e->getMessage())->self();
    }
  }

  public function getClientIPv4()
  {
    $request = request();

    // Check headers in order of reliability
    $headers = [
      "HTTP_CF_CONNECTING_IP", // Cloudflare
      "HTTP_X_REAL_IP", // Nginx
      "HTTP_X_FORWARDED_FOR", // Standard proxy header
      "HTTP_CLIENT_IP", // Less common
      "REMOTE_ADDR", // Direct connection
    ];

    foreach ($headers as $header) {
      $ip = $request->server($header);

      if ($ip) {
        // Handle comma-separated IPs
        if (strpos($ip, ",") !== false) {
          $ips = array_map("trim", explode(",", $ip));
          $ip = $ips[0]; // First IP is the real client
        }

        // Skip private/local IPs (Docker internal IPs)
        if ($this->isValidPublicIP($ip)) {
          return $this->convertToIPv4($ip);
        }
      }
    }

    // Fallback
    return $this->convertToIPv4($request->ip());
  }

  private function isValidPublicIP($ip)
  {
    // Validate IP format
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
      return false;
    }

    // Exclude private and reserved ranges
    return filter_var(
      $ip,
      FILTER_VALIDATE_IP,
      FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE,
    );
  }

  private function convertToIPv4($ip)
  {
    if ($ip === "::1") {
      return "127.0.0.1";
    }

    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
      return $ip;
    }

    // Return IPv6 as-is for geolocation services that support it
    return $ip;
  }

  /**
   * Ensure the authentication request is not rate limited.
   */
  protected function ensureIsNotRateLimited(): void
  {
    if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
      return;
    }

    event(new Lockout(request()));

    $seconds = RateLimiter::availableIn($this->throttleKey());

    throw ValidationException::withMessages([
      "email" => __("auth.throttle", [
        "seconds" => $seconds,
        "minutes" => ceil($seconds / 60),
      ]),
    ]);
  }

  /**
   * Get the authentication rate limiting throttle key.
   */
  protected function throttleKey(): string
  {
    return Str::transliterate(
      Str::lower($this->email) . "|" . $this->getClientIPV4(),
    );
  }

  public function render()
  {
    if (!Cookie::has("device")) {
      Cookie::queue(Cookie::forever("device", "app"));
    }
    return view("livewire.auth.app-login");
  }
}
