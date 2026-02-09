<?php

namespace App\Jobs;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class ResetProfitExceedDay implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function handle(): void
    {
        $currentDayOfWeek = Carbon::now()->dayOfWeek;

        User::select(['id', 'profit_exceed_day'])
            ->where('profit_exceed_day', $currentDayOfWeek)
            ->where('profit_exceed_day', '!=', 0)
            ->chunk(100, function ($users) {
                foreach ($users as $user) {
                    $this->resetProfitExceedDay($user);
                }
            });
    }

    private function resetProfitExceedDay($user): void
    {
        try {
            DB::transaction(function () use ($user) {
                $lockedUser = User::where('id', $user->id)
                    ->lockForUpdate()
                    ->first();

                if (! $lockedUser) {
                    return;
                }

                $lockedUser->profit_exceed_day = 0;
                $lockedUser->save();
            });
        } catch (\Exception $e) {
            logger()->error('Failed to reset profit_exceed_day: '.$e->getMessage(), [
                'user_id' => $user->id,
            ]);
        }
    }
}
