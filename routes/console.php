<?php

use App\Jobs\AssignProfitExceedDay;
use App\Jobs\RefreshActiveBots;
use App\Jobs\RemoveTradeLockout;
use App\Jobs\ResetProfitExceedDay;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new RefreshActiveBots)->everyFiveSeconds()->withoutOverlapping();
Schedule::job(new RemoveTradeLockout)->everyFiveSeconds()->withoutOverlapping();
Schedule::job(new AssignProfitExceedDay)->saturdays()->at('00:00')->withoutOverlapping();
Schedule::job(new ResetProfitExceedDay)->daily()->at('00:00')->withoutOverlapping();
