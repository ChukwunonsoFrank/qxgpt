<?php

namespace App\Livewire\Admin;

use App\Models\Bonus;
use App\Models\Bot;
use App\Models\Deposit;
use App\Models\Referral;
use App\Models\Strategy;
use App\Models\User;
use App\Models\Withdrawal;
use App\Notifications\BroadcastSent;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
class UsersDetails extends Component
{
    use WithPagination;

    protected $queryString = ['id'];

    #[Url]
    public $id;

    public $email;

    public $country;

    public $liveBalance;

    public $activeBotCount;

    public $bonusAmount;

    public $subject;

    public $message;

    public $strategies;

    public function mount()
    {
        $this->strategies = Strategy::all();
    }

    public function getStatusIndicatorColor(string $status)
    {
        if (
            $status === 'active' ||
            $status === 'completed' ||
            $status === 'confirmed'
        ) {
            return 'bg-success-50 text-success-600';
        }

        if ($status === 'pending') {
            return 'bg-warning-50 text-warning-600';
        }

        if (
            $status === 'closed' ||
            $status === 'expired' ||
            $status === 'declined'
        ) {
            return 'bg-error-50 text-error-600';
        }

        if ($status === 'unredeemed') {
            return 'bg-error-50 text-error-600';
        }

        if ($status === 'redeemed') {
            return 'bg-success-50 text-success-600';
        }
    }

    public function getStrategyName(int $strategyId)
    {
        $filtered = $this->strategies->filter(
            fn (Strategy $value) => $value['id'] === intval($strategyId),
        );

        return $filtered->first()['name'];
    }

    public function getReferralAmountRedeemable(string $code)
    {
        $referralData = Referral::where(
            'referral_code',
            '=',
            $code,
            'and',
        )->first();
        if (! $referralData) {
            return 0;
        }

        return $referralData->amount;
    }

    public function getReferralStatus(string $code)
    {
        $referralData = Referral::where(
            'referral_code',
            '=',
            $code,
            'and',
        )->first();
        if (! $referralData) {
            return 'unredeemed';
        }

        return 'redeemed';
    }

    public function convertTimestampToDateTime(string $timestamp): string
    {
        return toBali(Carbon::createFromTimestampMs($timestamp))->format('Y-m-d H:i:s');
    }

    public function addBonus()
    {
        try {
            // Validate bonus amount
            if (! isset($this->bonusAmount) || $this->bonusAmount <= 0) {
                throw new \Exception('Invalid bonus amount');
            }

            DB::transaction(function () {
                // Lock the user record
                $user = User::where('id', '=', $this->id, 'and')
                    ->lockForUpdate()
                    ->first();

                if (! $user) {
                    throw new \Exception('User not found');
                }

                $bonusAmountInCents = $this->bonusAmount * 100;

                // Update balance atomically
                $user->live_balance += $bonusAmountInCents;
                $user->save();

                // Create a new bonus record
                Bonus::create([
                    'user_id' => $user->id,
                    'amount' => $bonusAmountInCents,
                    'type' => 'add',
                ]);
            });

            session()->flash('success-message', 'Bonus added successfully');

            // Reset form
            $this->reset(['bonusAmount']);
        } catch (\Exception $e) {
            session()->flash('error-message', $e->getMessage());
        }
    }

    public function removeBonus()
    {
        try {
            // Validate bonus amount
            if (! isset($this->bonusAmount) || $this->bonusAmount <= 0) {
                throw new \Exception('Invalid bonus amount');
            }

            DB::transaction(function () {
                // Lock the user record
                $user = User::where('id', '=', $this->id, 'and')
                    ->lockForUpdate()
                    ->first();

                if (! $user) {
                    throw new \Exception('User not found');
                }

                if ($this->bonusAmount > $user->live_balance) {
                    throw new \Exception(
                        'Insufficient balance for bonus removal',
                    );
                }

                $bonusAmountInCents = $this->bonusAmount * 100;

                // Update balance atomically
                $user->live_balance -= $bonusAmountInCents;
                $user->save();

                // Create a new bonus record
                Bonus::create([
                    'user_id' => $user->id,
                    'amount' => $bonusAmountInCents,
                    'type' => 'remove',
                ]);
            });

            session()->flash('success-message', 'Bonus removed successfully');

            // Reset form
            $this->reset(['bonusAmount']);
        } catch (\Exception $e) {
            session()->flash('error-message', $e->getMessage());
        }
    }

    public function sendBroadcast()
    {
        try {
            $user = User::with('bots')->where('id', $this->id)->first();
            $user->notify(
                new BroadcastSent($user->name, $this->subject, $this->message),
            );
            session()->flash('success-message', 'Email sent successfully');
        } catch (\Exception $e) {
            session()->flash('error-message', $e->getMessage());
        }
    }

    public function displayProfitMinusFee($profit)
    {
        $fee = intval(round($profit * (5 / 100)));
        $displayProfit = $profit - $fee;

        return $displayProfit / 100;
    }

    public function render()
    {
        $user = User::with('bots')->where('id', $this->id)->first();
        $this->liveBalance = $user->live_balance;
        $this->email = $user->email;
        $this->country = $user->country;
        $this->activeBotCount = $user->bots->where('status', 'active')->count();
        $deposits = Deposit::with('user')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10, ['*'], 'deposits_page');
        $withdrawals = Withdrawal::with('user')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10, ['*'], 'withrawals_page');
        $bots = Bot::with('user')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10, ['*'], 'bots_page');
        $referrals = User::where(
            'referred_by',
            '=',
            $user->referral_code,
            'and',
        )->paginate(10, ['*'], 'referrals_page');

        return view('livewire.admin.users-details', [
            'deposits' => $deposits,
            'withdrawals' => $withdrawals,
            'bots' => $bots,
            'referrals' => $referrals,
        ]);
    }
}
