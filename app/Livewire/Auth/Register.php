<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Notifications\LoginCodeRequested;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('components.layouts.auth.layout')]
#[Title('Register')]
class Register extends Component
{
  #[Url]
  public $ref;

  public string $name = '';

  public string $email = '';

  public string $password = '';

  public string $password_confirmation = '';

  public $ref_code = '';

  public bool $termsAndPrivacyPolicyAccepted = false;

  public $gRecaptchaResponse;

  public function mount()
  {
    $this->ref_code = $this->ref;
  }

  /**
   * Custom validation error messages.
   */
  protected function messages(): array
  {
    return [
      'termsAndPrivacyPolicyAccepted.accepted' => 'Please accept the Terms & Conditions and Privacy Policy to proceed.',
    ];
  }

  /**
   * Handle an incoming registration request.
   */
  public function register()
  {
    try {
      if ($this->gRecaptchaResponse === null) {
        $this->dispatch(
          "signup-error",
          message: "Please confirm you are not a robot.",
        )->self();
      }

      $recatpchaResponse = Http::get(
        "https://www.google.com/recaptcha/api/siteverify",
        [
          "secret" => config("services.recaptcha.secret"),
          "response" => $this->gRecaptchaResponse,
        ],
      );

      $result = $recatpchaResponse->json();

      if (
        $recatpchaResponse->successful() &&
        $result["success"] == true
      ) {
        $validated = $this->validate([
          'name' => ['required', 'string', 'max:255'],
          'email' => [
            'required',
            'string',
            'lowercase',
            'email',
            'max:255',
            'unique:' . User::class,
          ],
          'password' => [
            'required',
            'string',
            'confirmed',
            Rules\Password::defaults(),
          ],
          'termsAndPrivacyPolicyAccepted' => 'accepted',
        ]);

        unset($validated['termsAndPrivacyPolicyAccepted']);

        $refCode = $this->ref ?? $this->ref_code;
        if ($refCode && ! User::where('referral_code', $refCode)->exists()) {
          $this->dispatch('signup-error', message: 'Invalid referral code.')->self();

          return;
        }

        /**
         * Attempt to send login code to user's email.
         */
        $loginCode = substr(str_shuffle('0123456789'), 0, 6);
        Notification::route('mail', $validated['email'])->notify(
          new LoginCodeRequested($loginCode),
        );

        $this->redirectRoute('register.verifylogincode', [
          'name' => $validated['name'],
          'email' => $validated['email'],
          'password' => $validated['password'],
          'hash' => Hash::make($loginCode),
          'ref' => $this->ref ?? $this->ref_code,
        ]);
      } else {
        $this->dispatch(
          "signup-error",
          message: "Please confirm you are not a robot.",
        )->self();
        return redirect()->back();
      }
    } catch (\Exception $e) {
      $this->dispatch('signup-error', message: $e->getMessage())->self();
    }
  }
}
