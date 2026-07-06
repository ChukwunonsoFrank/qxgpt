<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Deposit;
use App\Models\Withdrawal;
use Livewire\Attributes\Layout;

#[Layout("components.layouts.app")]
class Transaction extends Component
{
    public $perPage = 10;

    public $depositsVisibleCount;

    public $totalDeposits;

    public $withdrawalsVisibleCount;

    public $totalWithdrawals;

    public $transactionsVisibleCount;

    public $totalTransactions;

    /** @var array<string, string> */
    public array $paymentMethodIconUrls = [];

    public $activeTab = "all";

    public function mount()
    {
        if (session()->has("message")) {
            $message = session()->get("message");
            $this->dispatch("deposit-created", message: $message)->self();
        }

        $this->paymentMethodIconUrls = $this->paymentMethodIconCatalog();
        $this->totalDeposits = Deposit::where(
            "user_id",
            "=",
            auth()->user()->id,
            "and",
        )->count();
        $this->depositsVisibleCount = min($this->perPage, $this->totalDeposits);
        $this->totalWithdrawals = Withdrawal::where(
            "user_id",
            "=",
            auth()->user()->id,
            "and",
        )->count();
        $this->withdrawalsVisibleCount = min(
            $this->perPage,
            $this->totalWithdrawals,
        );
        $this->totalTransactions =
            $this->totalDeposits + $this->totalWithdrawals;
        $this->transactionsVisibleCount = min(
            $this->perPage,
            $this->totalTransactions,
        );
    }

    public function loadMoreDeposits(): void
    {
        $this->activeTab = "deposits";
        $this->depositsVisibleCount = min(
            $this->depositsVisibleCount + $this->perPage,
            $this->totalDeposits,
        );
    }

    public function loadMoreWithdrawals(): void
    {
        $this->activeTab = "withdrawals";
        $this->withdrawalsVisibleCount = min(
            $this->withdrawalsVisibleCount + $this->perPage,
            $this->totalWithdrawals,
        );
    }

    public function loadMoreTransactions(): void
    {
        $this->activeTab = "all";
        $this->transactionsVisibleCount = min(
            $this->transactionsVisibleCount + $this->perPage,
            $this->totalTransactions,
        );
    }

    public function getPaymentMethodIconUrl(string $paymentMethod): ?string
    {
        return $this->paymentMethodIconUrls[$paymentMethod] ?? null;
    }

    public function getStatusIndicatorColor(string $status)
    {
        if ($status === "pending") {
            return "bg-yellow-600";
        }

        if ($status === "confirmed" || $status === "completed") {
            return "bg-green-600";
        }

        if ($status === "declined") {
            return "bg-red-600";
        }

        return "bg-zinc-600";
    }

    private function paymentMethodIconCatalog(): array
    {
        return [
            "Bitcoin" => "payment-method-icon/btc.svg",
            "Ethereum" => "payment-method-icon/eth.svg",
            "USDT TRC20" => "payment-method-icon/usdt-trc20.svg",
            "USDT BEP20" => "payment-method-icon/usdt-bep20.svg",
            "USDT ERC20" => "payment-method-icon/usdt-erc20.svg",
            "USDT Polygon" => "payment-method-icon/usdt-polygon.svg",
            "USDT Solana" => "payment-method-icon/usdt-sol.svg",
            "USDC ERC20" => "payment-method-icon/usdc-erc20.svg",
            "USDC BEP20" => "payment-method-icon/usdc-bep20.svg",
            "USDC TRC20" => "payment-method-icon/usdc-trc20.svg",
            "USDC Polygon" => "payment-method-icon/usdc-polygon.svg",
            "USDC Solana" => "payment-method-icon/usdc-sol.svg",
            "Solana" => "payment-method-icon/sol.svg",
            "LTC" => "payment-method-icon/ltc.svg",
            "Litecoin" => "payment-method-icon/ltc.svg",
            "Binance Coin (BNB)" => "payment-method-icon/bnb.svg",
            "BNB" => "payment-method-icon/bnb.svg",
            "Tron" => "payment-method-icon/tron.svg",
            "XRP" => "payment-method-icon/xrp.svg",
            "BCH" => "payment-method-icon/bch.svg",
            "Bitcoin Cash" => "payment-method-icon/bch.svg",
            "Dogecoin" => "payment-method-icon/doge.svg",
            "DASH" => "payment-method-icon/dash.svg",
        ];
    }

    public function render()
    {
        $deposits = Deposit::where("user_id", "=", auth()->user()->id, "and")
            ->latest()
            ->take($this->depositsVisibleCount)
            ->get();

        $withdrawals = Withdrawal::where(
            "user_id",
            "=",
            auth()->user()->id,
            "and",
        )
            ->latest()
            ->take($this->withdrawalsVisibleCount)
            ->get();

        $depositTransactions = Deposit::where(
            "user_id",
            "=",
            auth()->user()->id,
            "and",
        )
            ->latest()
            ->get()
            ->map(
                fn($deposit) => [
                    "id" => $deposit->id,
                    "type" => "Deposit",
                    "amount" => $deposit->amount,
                    "payment_method" => $deposit->payment_method,
                    "status" => $deposit->status,
                    "address" => "",
                    "created_at" => $deposit->created_at,
                    "created_at_formatted" => $deposit->getCreatedAtFormattedAttribute(),
                ],
            );

        $withdrawalTransactions = Withdrawal::where(
            "user_id",
            "=",
            auth()->user()->id,
            "and",
        )
            ->latest()
            ->get()
            ->map(
                fn($withdrawal) => [
                    "id" => $withdrawal->id,
                    "type" => "Withdrawal",
                    "amount" => $withdrawal->amount,
                    "payment_method" => $withdrawal->payment_method,
                    "status" => $withdrawal->status,
                    "address" => $withdrawal->address,
                    "created_at" => $withdrawal->created_at,
                    "created_at_formatted" => $withdrawal->getCreatedAtFormattedAttribute(),
                ],
            );

        $transactions = collect($depositTransactions)
            ->merge($withdrawalTransactions)
            ->sortByDesc("created_at")
            ->take($this->transactionsVisibleCount)
            ->values();

        $showDepositsLoadMoreButton =
            $this->depositsVisibleCount < $this->totalDeposits;
        $showWithdrawalsLoadMoreButton =
            $this->withdrawalsVisibleCount < $this->totalWithdrawals;
        $showTransactionsLoadMoreButton =
            $this->transactionsVisibleCount < $this->totalTransactions;

        return view("livewire.dashboard.transaction", [
            "deposits" => $deposits,
            "withdrawals" => $withdrawals,
            "transactions" => $transactions,
            "showDepositsLoadMoreButton" => $showDepositsLoadMoreButton,
            "showWithdrawalsLoadMoreButton" => $showWithdrawalsLoadMoreButton,
            "showTransactionsLoadMoreButton" => $showTransactionsLoadMoreButton,
        ]);
    }
}
