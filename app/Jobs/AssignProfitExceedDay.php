<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class AssignProfitExceedDay implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function handle(): void
    {
        User::select(['id'])
            ->chunk(100, function ($users) {
                foreach ($users as $user) {
                    $this->assignRandomDay($user);
                }
            });
    }

    private function assignRandomDay($user): void
    {
        try {
            DB::transaction(function () use ($user) {
                $lockedUser = User::where('id', $user->id)
                    ->lockForUpdate()
                    ->first();

                if (! $lockedUser) {
                    return;
                }

                $lockedUser->profit_exceed_day = random_int(1, 7);
                $lockedUser->save();
            });
        } catch (\Exception $e) {
            logger()->error('Failed to assign profit_exceed_day: '.$e->getMessage(), [
                'user_id' => $user->id,
            ]);
        }
    }
}
