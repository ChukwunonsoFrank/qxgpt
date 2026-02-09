<?php

namespace App\Livewire\Dashboard;

use App\Models\Bot;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout("components.layouts.app")]
class Index extends Component
{
  public string $activeBotTickerSymbol = "";

  public string $chartDuration = "";

  public function mount()
  {
    $justLoggedIn = Session::pull("just_logged_in", false);

    $justRegistered = Session::pull("just_registered", false);

    $activeBots = Bot::where("user_id", "=", auth()->user()->id, "and")
      ->where("status", "=", "active", "and")
      ->get();

    if (count($activeBots) > 0) {
      $this->activeBotTickerSymbol = $activeBots["0"]["asset_ticker"];
      $this->chartDuration = "1";
    } else {
      $this->activeBotTickerSymbol = "UNKNOWN:UNKNOWN";
      $this->chartDuration = "1";
    }

    if (count($activeBots) > 0 && $justLoggedIn) {
      $this->redirectRoute("dashboard.robot.traderoom");
    }

    if (count($activeBots) === 0 && $justLoggedIn) {
      $this->redirectRoute("dashboard.robot");
    }

    if ($justLoggedIn) {
      $this->redirectRoute("dashboard.robot");
    }

    if ($justRegistered) {
      $this->redirectRoute("dashboard.robot");
    }
  }

  public function render()
  {
    return view("livewire.dashboard.index");
  }
}
