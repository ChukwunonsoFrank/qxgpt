<?php

namespace App\Livewire\Dashboard;

use App\Models\PaymentMethod;
use App\Models\Withdrawal;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout("components.layouts.app")]
class Withdraw extends Component
{
  public string $accountStatus = "";

  public bool $isBanned;

  // public string $country;

  public string $amount = "";

  public int $minimumWithdrawAmount = 25;

  public $paymentMethod;

  public $paymentMethods;

  public $selectedPaymentMethodSlug = "";

  public function mount()
  {
    $this->isBanned = auth()->user()->is_banned;
    // $this->country = auth()->user()->country;
    $this->paymentMethods = PaymentMethod::all();
    $this->accountStatus = auth()->user()->account_status;
  }

  public function selectPaymentMethod(string $slug): void
  {
    $filtered = $this->paymentMethods->filter(
      fn(PaymentMethod $value) => $value["slug"] === $slug,
    );

    $this->paymentMethod = $filtered->first();
    $this->selectedPaymentMethodSlug = $slug;
  }

  public function normalizeAmount(int $amount): int|float
  {
    return $amount / 100;
  }

  public function serializeAmount(float $amount): int
  {
    return $amount * 100;
  }

  public function proceedToAddressStep()
  {
    try {
      $pendingWithdrawals = Withdrawal::where(
        "user_id",
        "=",
        auth()->user()->id,
        "and",
      )
        ->where("status", "=", "pending", "and")
        ->first();

      if ($pendingWithdrawals) {
        $this->dispatch(
          "withdraw-error",
          message: "You have a pending withdrawal. Please wait for confirmation before requesting another.",
        )->self();
        return;
      }

      // if ($this->country === "Brazil") {
      //   $this->dispatch(
      //     "withdraw-error",
      //     message: "Brazil Region Upgrade in Progress. Trades and withdrawals are temporarily paused while we complete a system upgrade. Services will resume shortly",
      //   )->self();
      //   return;
      // }

      if ($this->accountStatus === "inactive") {
        $this->dispatch(
          "withdraw-error",
          message: "This account has been disabled and unable to perform any transactions. Kindly contact support for more details.",
        )->self();
        return;
      }

      if ($this->amount === "") {
        $this->dispatch(
          "withdraw-error",
          message: "Amount field is empty",
        )->self();
        return;
      }

      if (floatval($this->amount) < $this->minimumWithdrawAmount) {
        $message =
          'Minimum withdrawal is $' .
          strval($this->minimumWithdrawAmount);
        $this->dispatch("withdraw-error", message: $message)->self();
        return;
      }

      if (intval($this->amount) === 0) {
        $this->dispatch(
          "withdraw-error",
          message: "Amount must be greater than 0",
        )->self();
        return;
      }

      $balance = $this->normalizeAmount(auth()->user()->live_balance);
      if (floatval($this->amount) > $balance) {
        $this->dispatch(
          "withdraw-error",
          message: "Insufficient balance",
        )->self();
        return false;
      }

      $this->redirectRoute("dashboard.withdraw.addressstep", [
        "amount" => $this->serializeAmount(floatval($this->amount)),
        "method" => $this->paymentMethod["name"],
        "iconUrl" => $this->paymentMethod["icon_url"],
        "slug" => $this->paymentMethod["slug"],
      ]);
    } catch (\Exception $e) {
      $this->dispatch(
        "withdraw-error",
        message: $e->getMessage(),
      )->self();
    }
  }

  public function render()
  {
    return view("livewire.dashboard.withdraw");
  }
}
