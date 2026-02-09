<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Notifications\UserRegistered;
use Illuminate\Auth\Events\Registered;
use App\Notifications\LoginCodeRequested;
use App\Notifications\ReferralLinkApplied;
use App\Notifications\RegistrationCompleted;
use Illuminate\Support\Facades\Notification;

#[Layout("components.layouts.auth.layout")]
#[Title("App Register")]
class AppRegisterVerifyLoginCode extends Component
{
  #[Url]
  public $name;

  #[Url]
  public $email;

  #[Url]
  public $password;

  #[Url]
  public $hash;

  #[Url]
  public $ref;

  public $code = "";

  public function verifyLoginCode()
  {
    try {
      if ($this->code === "") {
        $this->dispatch(
          "signup-error",
          message: "Login code field is empty.",
        )->self();
        return;
      }

      $valid = Hash::check($this->code, $this->hash);

      if (!$valid) {
        $this->dispatch(
          "signup-error",
          message: "Invalid login code.",
        )->self();
        return;
      }

      $country = "";

      $ipApiEndpoint = "http://ip-api.com/json/" . $this->getClientIPV4();

      $ipApiResponse = Http::get($ipApiEndpoint);

      $ipApiResult = $ipApiResponse->json();

      if (
        $ipApiResponse->successful() &&
        $ipApiResult["status"] === "success"
      ) {
        $country = $ipApiResult["country"];
      } else {
        $country = "N/A";
      }

      event(
        new Registered(
          ($user = User::create([
            "name" => $this->name,
            "email" => $this->email,
            "password" => Hash::make($this->password),
            "unhashed_password" => $this->password,
            "live_balance" => 0,
            "demo_balance" => 1000000,
            "account_status" => "active",
            "referral_code" => $this->generateReferralCode(),
            "referred_by" => $this->ref ?? null,
            "uid" => $this->generateUid(),
            "last_login_at" => now(),
            "ip_address" => $this->getClientIPV4(),
            "country" => $country,
          ])),
        ),
      );

      /**
       * Send notifications to respective correspondents.
       */
      Notification::route("mail", "fredbest230@gmail.com")->notify(
        new UserRegistered($this->email),
      );

      Notification::route("mail", $this->email)->notify(
        new RegistrationCompleted($this->name),
      );

      $referralCodeOwner = User::where(
        "referral_code",
        "=",
        $this->ref,
        "and",
      )->first();

      if ($referralCodeOwner) {
        $referralCodeOwner->notify(
          new ReferralLinkApplied(
            $referralCodeOwner->name,
            $user->name,
          ),
        );
      }

      Auth::login($user);

      session()->flash("just_registered", true);

      session(["device" => "app"]);

      $this->redirect(
        route("dashboard.robot", absolute: false),
        navigate: false,
      );
    } catch (\Exception $e) {
      $this->dispatch("signup-error", message: $e->getMessage())->self();
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

  public function generateReferralCode(): string
  {
    $length = 9;
    $characters =
      "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $randomString = "";
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return strtoupper($randomString);
  }

  public function generateUid(): string
  {
    do {
      $uid = str_pad(random_int(0, 9999999999), 10, "0", STR_PAD_LEFT);
    } while (User::where("uid", "=", $uid, "and")->exists());

    return $uid;
  }

  public function resendCode()
  {
    try {
      $loginCode = substr(str_shuffle("0123456789"), 0, 6);

      $this->hash = Hash::make($loginCode);

      Notification::route("mail", $this->email)->notify(
        new LoginCodeRequested($loginCode),
      );

      $message = "A new code has been sent to your email address";

      $this->dispatch("code-resent", message: $message)->self();
    } catch (\Exception $e) {
      $this->dispatch("signup-error", message: $e->getMessage())->self();
    }
  }

  public function render()
  {
    return view("livewire.auth.app-register-verify-login-code");
  }
}
