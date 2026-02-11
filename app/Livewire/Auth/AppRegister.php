<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Notifications\LoginCodeRequested;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('components.layouts.auth.applayout')]

#[Title('App Register')]

class AppRegister extends Component
{
  #[Url]
  public $ref;

  public string $name = '';

  public string $email = '';

  public string $password = '';

  public string $password_confirmation = '';

  public $ref_code = '';

  public function mount()
  {
    $this->ref_code = $this->ref;
  }

  /**
   * Handle an incoming registration request.
   */
  public function register()
  {
    try {
      $validated = $this->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
        'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
      ]);

      $refCode = $this->ref ?? $this->ref_code;
      if ($refCode && ! User::where('referral_code', $refCode)->exists()) {
        $this->dispatch('signup-error', message: 'Invalid referral code.')->self();

        return;
      }

      /**
       * Attempt to send login code to user's email.
       */
      $loginCode = substr(str_shuffle('0123456789'), 0, 6);
      Notification::route('mail', $validated['email'])->notify(new LoginCodeRequested($loginCode));

      $this->redirectRoute('appregister.verifylogincode', [
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => $validated['password'],
        'hash' => Hash::make($loginCode),
        'ref' => $this->ref
      ]);
    } catch (\Exception $e) {
      $this->dispatch('signup-error', message: $e->getMessage())->self();
    }
  }
}
