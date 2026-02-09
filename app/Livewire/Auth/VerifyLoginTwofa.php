<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use PragmaRX\Google2FA\Google2FA;

#[Layout("components.layouts.auth.layout")]
#[Title("Login")]
class VerifyLoginTwofa extends Component
{
    #[Url]
    #[Validate("required|string|email")]
    public $email;

    #[Url]
    #[Validate("required")]
    public $password;

    public bool $remember = false;

    public $code;

    public function verify2fa()
    {
        try {
            $google2fa = new Google2FA();
            $user = User::where("email", "=", $this->email, "and")->first();
            $valid = $google2fa->verifyKey(
                $user["google2fa_secret"],
                $this->code,
            );

            if ($valid) {
                $this->validate();

                if (
                    !Auth::attempt(
                        [
                            "email" => $this->email,
                            "password" => $this->password,
                        ],
                        $this->remember,
                    )
                ) {
                    throw ValidationException::withMessages([
                        "email" => __("auth.failed"),
                    ]);
                }

                Session::regenerate();

                session()->flash("just_logged_in", true);

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

                $this->redirectIntended(
                    default: route("dashboard.robot", absolute: false),
                );
            } else {
                $this->reset("code");
                $this->dispatch("login-error", message: "Invalid code")->self();
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

    public function render()
    {
        return view("livewire.auth.verify-login-twofa");
    }
}
