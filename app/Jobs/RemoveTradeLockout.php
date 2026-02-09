<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\LockoutRemoved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class RemoveTradeLockout implements ShouldQueue
{
  use Queueable;

  /**
   * Create a new job instance.
   */
  public function __construct()
  {
    //
  }

  /**
   * Execute the job.
   */
  public function handle(): void
  {
    /**
     * Fetch all users with the is_lockout_active set to true and batch process.
     */
    User::select(['id', 'is_lockout_active', 'lockout_ends_in', 'lockout_two_ends_in', 'name'])
      ->where("is_lockout_active", 1)
      ->chunk(100, function ($users) {
        foreach ($users as $user) {
          $lockoutEndsInCheckpoint = intval($user["lockout_ends_in"]);
          $lockoutTwoEndsInCheckpoint = intval($user["lockout_two_ends_in"]);
          $now = now()->getTimestampMs();

          /**
           * Get the current datetime and compare this with the timer_checkpoint
           * of each bot.
           */
          if ($lockoutEndsInCheckpoint && ! $lockoutTwoEndsInCheckpoint) {
            if ($now > $lockoutEndsInCheckpoint) {
              $this->removeLockoutOne($user);
            }
          }

          if (! $lockoutEndsInCheckpoint && $lockoutTwoEndsInCheckpoint) {
            if ($now > $lockoutTwoEndsInCheckpoint) {
              $this->removeLockoutTwo($user);
            }
          }

          if ($lockoutEndsInCheckpoint && $lockoutTwoEndsInCheckpoint) {
            if ($now > $lockoutEndsInCheckpoint) {
              $this->removeLockoutOneCheckpoint($user);
            }
          }
        }
      });
  }

  private function removeLockoutOne($user): void
  {
    try {
      DB::transaction(function () use (
        $user,
      ) {
        // Lock user record
        $lockedUser = User::where("id", "=", $user["id"], "and")
          ->lockForUpdate()
          ->first();

        if (!$lockedUser || !$lockedUser->is_lockout_active) {
          return; // Already processed/unlocked
        }

        $lockedUser->is_lockout_active = !$lockedUser->is_lockout_active;
        $lockedUser->lockout_ends_in = '';
        $lockedUser->save();

        // Send email to notify user when limit has lifted
        // $user->notify(
        //   new LockoutRemoved(
        //     $user["name"],
        //   ),
        // );
      });
    } catch (\Exception $e) {
      logger()->error("User update failed: " . $e->getMessage(), [
        'user_id' => $user["id"],
      ]);
    }
  }

  private function removeLockoutTwo($user): void
  {
    try {
      DB::transaction(function () use (
        $user,
      ) {
        // Lock user record
        $lockedUser = User::where("id", "=", $user["id"], "and")
          ->lockForUpdate()
          ->first();

        if (!$lockedUser || !$lockedUser->is_lockout_active) {
          return; // Already processed/unlocked
        }

        $lockedUser->is_lockout_active = !$lockedUser->is_lockout_active;
        $lockedUser->lockout_two_ends_in = '';
        $lockedUser->save();

        // Send email to notify user when limit has lifted
        // $user->notify(
        //   new LockoutRemoved(
        //     $user["name"],
        //   ),
        // );
      });
    } catch (\Exception $e) {
      logger()->error("User update failed: " . $e->getMessage(), [
        'user_id' => $user["id"],
      ]);
    }
  }

  private function removeLockoutOneCheckpoint($user): void
  {
    try {
      DB::transaction(function () use (
        $user,
      ) {
        // Lock user record
        $lockedUser = User::where("id", "=", $user["id"], "and")
          ->lockForUpdate()
          ->first();

        $lockedUser->lockout_ends_in = '';
        $lockedUser->save();

        // Send email to notify user when limit has lifted
        // $user->notify(
        //   new LockoutRemoved(
        //     $user["name"],
        //   ),
        // );
      });
    } catch (\Exception $e) {
      logger()->error("User update failed: " . $e->getMessage(), [
        'user_id' => $user["id"],
      ]);
    }
  }
}
