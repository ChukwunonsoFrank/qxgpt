<?php

namespace App\Livewire\Dashboard;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Deposit extends Component
{
    private const BITCOIN_ADDRESS = 'bc1qmwkt3vc7fkpt4f7zyr7233dz9l6lf8as3adn7l';

    private const ETHEREUM_FAMILY_ADDRESS = '0x2236517D8837e697E056a0e99c871843D232dc3f';

    private const TRON_FAMILY_ADDRESS = 'TV8e1EPe1CafxsZNBchE1XYYTnv1L1GmU6';

    private const SOLANA_FAMILY_ADDRESS = '9EPZez98iL6VpafB89iot8TrjjrrNcN1fMF25tR52ygq';

    private const LITECOIN_ADDRESS = 'ltc1qpdnml044u65pctyjczq99ppmsnvlukpds5ee9a';

    private const XRP_ADDRESS = 'rhthWrsBdMHxtk5y77ojmvHsmJEk4eFpnR';

    public string $accountStatus = '';

    public bool $isBanned;

    public string $amount = '';

    public int $minimumDepositAmount = 100;

    /** @var array{name: string, slug: string, address: string, icon_url: string}|null */
    public ?array $paymentMethod = null;

    /** @var array<string, array{name: string, slug: string, address: string, icon_url: string}> */
    public array $paymentMethods = [];

    public $selectedPaymentMethodSlug = '';

    public function mount(): void
    {
        $this->isBanned = auth()->user()->is_banned;
        $this->paymentMethods = $this->paymentMethodsCatalog();
        $this->accountStatus = auth()->user()->account_status;
    }

    public function selectPaymentMethod(string $slug): void
    {
        $paymentMethod = $this->paymentMethods[$slug] ?? null;

        if (! is_array($paymentMethod)) {
            $this->paymentMethod = null;
            $this->selectedPaymentMethodSlug = '';

            return;
        }

        $this->paymentMethod = $paymentMethod;
        $this->selectedPaymentMethodSlug = $paymentMethod['slug'];
    }

    public function serializeAmount(float $amount): int
    {
        return $amount * 100;
    }

    public function confirmDeposit(): void
    {
        if ($this->amount === '') {
            $this->dispatch(
                'deposit-error',
                message: 'Amount field is empty',
            )->self();

            return;
        }

        if (intval($this->amount) === 0) {
            $this->dispatch(
                'deposit-error',
                message: 'Amount must be greater than 0',
            )->self();

            return;
        }

        if (floatval($this->amount) < $this->minimumDepositAmount) {
            $message =
              'Minimum deposit is $'.strval($this->minimumDepositAmount);
            $this->dispatch('deposit-error', message: $message)->self();

            return;
        }

        if ($this->paymentMethod === null) {
            $this->dispatch(
                'deposit-error',
                message: 'Please select a payment method',
            )->self();

            return;
        }

        $this->redirectRoute('dashboard.deposit.confirm', [
            'amount' => $this->serializeAmount(floatval($this->amount)),
            'method' => $this->paymentMethod['name'],
            'address' => $this->paymentMethod['address'],
            'iconUrl' => $this->paymentMethod['icon_url'],
            'slug' => $this->paymentMethod['slug'],
        ]);
    }

    /**
     * @return array<string, array{name: string, slug: string, address: string, icon_url: string}>
     */
    private function paymentMethodsCatalog(): array
    {
        return [
            'bitcoin' => [
                'name' => 'Bitcoin',
                'slug' => 'bitcoin',
                'address' => self::BITCOIN_ADDRESS,
                'icon_url' => 'payment-method-icon/btc.svg',
            ],
            'ethereum' => [
                'name' => 'Ethereum',
                'slug' => 'ethereum',
                'address' => self::ETHEREUM_FAMILY_ADDRESS,
                'icon_url' => 'payment-method-icon/eth.svg',
            ],
            'usdt-trc20' => [
                'name' => 'USDT TRC20',
                'slug' => 'usdt-trc20',
                'address' => self::TRON_FAMILY_ADDRESS,
                'icon_url' => 'payment-method-icon/usdt-trc20.svg',
            ],
            'usdt-bep20' => [
                'name' => 'USDT BEP20',
                'slug' => 'usdt-bep20',
                'address' => self::ETHEREUM_FAMILY_ADDRESS,
                'icon_url' => 'payment-method-icon/usdt-bep20.svg',
            ],
            'usdt-erc20' => [
                'name' => 'USDT ERC20',
                'slug' => 'usdt-erc20',
                'address' => self::ETHEREUM_FAMILY_ADDRESS,
                'icon_url' => 'payment-method-icon/usdt-erc20.svg',
            ],
            'usdt-polygon' => [
                'name' => 'USDT Polygon',
                'slug' => 'usdt-polygon',
                'address' => self::ETHEREUM_FAMILY_ADDRESS,
                'icon_url' => 'payment-method-icon/usdt-polygon.svg',
            ],
            'usdt-sol' => [
                'name' => 'USDT Solana',
                'slug' => 'usdt-sol',
                'address' => self::SOLANA_FAMILY_ADDRESS,
                'icon_url' => 'payment-method-icon/usdt-sol.svg',
            ],
            'usdc-erc20' => [
                'name' => 'USDC ERC20',
                'slug' => 'usdc-erc20',
                'address' => self::ETHEREUM_FAMILY_ADDRESS,
                'icon_url' => 'payment-method-icon/usdc-erc20.svg',
            ],
            'usdc-bep20' => [
                'name' => 'USDC BEP20',
                'slug' => 'usdc-bep20',
                'address' => self::ETHEREUM_FAMILY_ADDRESS,
                'icon_url' => 'payment-method-icon/usdc-bep20.svg',
            ],
            'usdc-sol' => [
                'name' => 'USDC Solana',
                'slug' => 'usdc-sol',
                'address' => self::SOLANA_FAMILY_ADDRESS,
                'icon_url' => 'payment-method-icon/usdc-sol.svg',
            ],
            'usdc-polygon' => [
                'name' => 'USDC Polygon',
                'slug' => 'usdc-polygon',
                'address' => self::ETHEREUM_FAMILY_ADDRESS,
                'icon_url' => 'payment-method-icon/usdc-polygon.svg',
            ],
            'solana' => [
                'name' => 'Solana',
                'slug' => 'solana',
                'address' => self::SOLANA_FAMILY_ADDRESS,
                'icon_url' => 'payment-method-icon/sol.svg',
            ],
            'litecoin' => [
                'name' => 'LTC',
                'slug' => 'litecoin',
                'address' => self::LITECOIN_ADDRESS,
                'icon_url' => 'payment-method-icon/ltc.svg',
            ],
            'binance-coin' => [
                'name' => 'Binance Coin (BNB)',
                'slug' => 'binance-coin',
                'address' => self::ETHEREUM_FAMILY_ADDRESS,
                'icon_url' => 'payment-method-icon/bnb.svg',
            ],
            'tron' => [
                'name' => 'Tron',
                'slug' => 'tron',
                'address' => self::TRON_FAMILY_ADDRESS,
                'icon_url' => 'payment-method-icon/tron.svg',
            ],
            'ripple' => [
                'name' => 'XRP',
                'slug' => 'ripple',
                'address' => self::XRP_ADDRESS,
                'icon_url' => 'payment-method-icon/xrp.svg',
            ],
        ];
    }

    public function render(): View
    {
        return view('livewire.dashboard.deposit');
    }
}
