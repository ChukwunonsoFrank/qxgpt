<?php

namespace App\Livewire\Admin;

use App\Models\Bot;
use App\Models\Deposit;
use App\Models\Kyc;
use App\Models\OtpToken;
use App\Models\Trade;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
class Users extends Component
{
    use WithPagination;

    #[Url(as: 'search', keep: true)]
    public string $query = '';

    public function getStatusIndicatorColor(string $status)
    {
        if ($status === 'active') {
            return 'bg-success-50 text-success-600';
        }

        if ($status === 'inactive') {
            return 'bg-error-50 text-error-600';
        }
    }

    public function deactivateUser(int $userId)
    {
        try {
            User::where('id', '=', $userId, 'and')->update([
                'account_status' => 'inactive',
            ]);

            $activeBot = Bot::where('user_id', '=', $userId, 'and')
                ->where('status', '=', 'active', 'and')
                ->first();

            if ($activeBot) {
                $this->stopRobot($activeBot->id);
            }

            session()->flash('success-message', 'Deactivation successful.');
        } catch (\Exception $e) {
            session()->flash('error-message', $e->getMessage());
        }
    }

    public function banUser(int $userId)
    {
        try {
            User::where('id', '=', $userId, 'and')->update([
                'is_banned' => true,
            ]);

            $activeBot = Bot::where('user_id', '=', $userId, 'and')
                ->where('status', '=', 'active', 'and')
                ->first();

            if ($activeBot) {
                $this->stopRobot($activeBot->id);
            }

            $this->terminateUserSession($userId);

            session()->flash('success-message', 'Ban successful.');
        } catch (\Exception $e) {
            session()->flash('error-message', $e->getMessage());
        }
    }

    public function terminateUserSession(int $userId)
    {
        // Get all session IDs for this user from Redis SET
        $sessionIds = Redis::connection()->smembers("user:{$userId}:sessions");

        if (empty($sessionIds)) {
            return;
        }

        // Get the Redis prefix
        $prefix = config('database.redis.options.prefix', 'yfxai_database_');

        // Delete each session from Redis
        foreach ($sessionIds as $sessionId) {
            Redis::connection()->del("{$prefix}{$sessionId}");
        }

        // Delete the tracking set
        Redis::connection()->del("user:{$userId}:sessions");
    }

    public function unbanUser(int $userId)
    {
        try {
            User::where('id', '=', $userId, 'and')->update([
                'is_banned' => false,
            ]);

            session()->flash('success-message', 'Unban successful.');
        } catch (\Exception $e) {
            session()->flash('error-message', $e->getMessage());
        }
    }

    public function calculateFees(int $profit): int
    {
        $fee = intval(round(($profit * 5) / 100));

        return $fee;
    }

    public function stopRobot(int $botId)
    {
        try {
            DB::transaction(function () use ($botId) {
                // Lock the bot record first to prevent concurrent stops
                $bot = Bot::where('id', '=', $botId, 'and')
                    ->lockForUpdate()
                    ->first();

                if (! $bot) {
                    throw new \Exception('Bot not found');
                }

                // Check if already stopped/closed
                if ($bot->status === 'closed') {
                    throw new \Exception('Bot already stopped');
                }

                // Only allow stopping active bots
                if ($bot->status !== 'active') {
                    throw new \Exception('Only active bots can be stopped');
                }

                $userId = $bot->user_id;
                $accountType = $bot->account_type;
                $amount = $bot->amount;
                $profit = $bot->profit;
                $fee = $this->calculateFees($profit);
                $netProfit = $profit - $fee;

                // Lock the user record for balance update
                $user = User::where('id', '=', $userId, 'and')
                    ->lockForUpdate()
                    ->first();

                if (! $user) {
                    throw new \Exception('User not found');
                }

                if ($accountType === 'demo') {
                    $currentBalance = $user->demo_balance;
                    $newBalance = $currentBalance + $amount + $netProfit;

                    // Update user balance
                    $user->demo_balance = $newBalance;
                    $user->save();
                } elseif ($accountType === 'live') {
                    $currentBalance = $user->live_balance;
                    $newBalance = $currentBalance + $amount + $netProfit;

                    // Update user balance
                    $user->live_balance = $newBalance;
                    $user->save();
                } else {
                    throw new \Exception('Invalid account type');
                }

                // Update bot status
                $bot->status = 'closed';
                $bot->save();
            });

            session()->flash('success-message', 'Robot stopped successfully.');
        } catch (\Exception $e) {
            session()->flash('error-message', $e->getMessage());
        }
    }

    public function destroyUser(int $userId)
    {
        try {
            DB::transaction(function () use ($userId) {
                // Delete related KYC records
                Kyc::where('user_id', '=', $userId, 'and')->delete();

                // Delete related deposit records
                Deposit::where('user_id', '=', $userId, 'and')->delete();

                // Delete related withdrawal records
                Withdrawal::where('user_id', '=', $userId, 'and')->delete();

                // Delete related bot trades records
                Trade::where('user_id', '=', $userId, 'and')->delete();

                // Delete related bot records
                Bot::where('user_id', '=', $userId, 'and')->delete();

                // Delete related bot trades records
                OtpToken::where('user_id', '=', $userId, 'and')->delete();

                // Delete the user account
                $user = User::findOrFail($userId);
                $user->delete($userId);
            });

            session()->flash('success-message', 'User deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error-message', $e->getMessage());
        }
    }

    public function activateUser(int $userId)
    {
        try {
            User::where('id', '=', $userId, 'and')->update([
                'account_status' => 'active',
            ]);
            session()->flash('success-message', 'Activation successful.');
        } catch (\Exception $e) {
            session()->flash('error-message', $e->getMessage());
        }
    }

    public function search()
    {
        // Reset to first page when searching
        $this->resetPage();
    }

    public function updatedQuery()
    {
        // Reset to first page when query changes
        $this->resetPage();
    }

    public function render()
    {
        $query = User::from('users as u')
            ->leftJoin(
                'users as referrers',
                'u.referred_by',
                '=',
                'referrers.referral_code',
            )
            ->select('u.*', 'referrers.name as referrer_name')
            ->where('u.is_admin', 0);

        if (! empty($this->query)) {
            $searchTerm = $this->query;
            $query = $query->where(function ($q) use ($searchTerm) {
                $q->whereRaw(
                    'MATCH(u.name, u.email) AGAINST(? IN BOOLEAN MODE)',
                    [$this->prepareSearchTerm($searchTerm)],
                )->orWhere('u.unhashed_password', 'LIKE', '%'.$searchTerm.'%');
            });
        }

        $users = $query->latest()->paginate(20);

        return view('livewire.admin.users', [
            'users' => $users,
        ]);
    }

    protected function prepareSearchTerm(string $term): string
    {
        $sanitized = preg_replace('/[+\-><*~"()@.]/', ' ', $term);
        $words = array_filter(explode(' ', trim($sanitized)), fn ($word) => strlen($word) > 3);

        $preparedWords = array_map(fn ($word) => '+'.$word.'*', $words);

        return implode(' ', $preparedWords);
    }
}
