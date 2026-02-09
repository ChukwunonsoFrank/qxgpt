<div class="lg:px-0 h-full">
    <div class="md:hidden h-full relative">
        @if ($this->activeBotTickerSymbol !== 'UNKNOWN:UNKNOWN')
            <div class="tradingview-widget-container absolute mb-2 z-10">
                <div class="tradingview-widget-container__widget" style="height:100%;width:100%"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
                    {
                        "autosize": true,
                        "symbol": "{{ $this->activeBotTickerSymbol }}",
                        "interval": "{{ $this->chartDuration }}",
                        "timezone": "Etc/UTC",
                        "theme": "dark",
                        "style": "3",
                        "locale": "en",
                        "allow_symbol_change": true,
                        "backgroundColor": "rgba(22, 22, 22, 1)",
                        "calendar": false,
                        "hide_top_toolbar": true,
                        "hide_volume": true,
                        "support_host": "https://www.tradingview.com"
                    }
                </script>
            </div>
            <a class="absolute right-4 bottom-11 z-20" href="{{ route('dashboard.robot.traderoom') }}">
                <button type="button"
                    class="px-3 py-2 cursor-pointer inline-flex items-center justify-center gap-x-0.5 text-xs font-semibold rounded-lg bg-dashboard border border-accent text-white focus:outline-hidden">
                    Back to trade
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                </button>
            </a>
        @else
            <div class="px-12 flex items-center justify-center h-full">
                <div
                    class="max-w-sm mx-auto flex flex-col bg-dim border border-[#26252a] rounded-2xl pointer-events-auto">
                    <div class="p-6 overflow-y-auto text-center">
                        <div class="flex justify-center mb-4">
                            <div class="size-18 flex items-center justify-center rounded-full border-3 border-accent">
                                <svg width="48" height="48" viewBox="0 0 48 48" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M21.026 9.71196L26.24 4.33996C26.3885 4.16852 26.5909 4.05267 26.814 4.01143C27.037 3.97018 27.2674 4.00598 27.4675 4.11297C27.6675 4.21995 27.8252 4.39175 27.9147 4.60018C28.0042 4.8086 28.0202 5.04126 27.96 5.25996L25.206 13.894M31.312 20H40C40.3785 19.9987 40.7495 20.1048 41.0701 20.306C41.3906 20.5072 41.6475 20.7952 41.8109 21.1366C41.9743 21.478 42.0374 21.8588 41.993 22.2346C41.9486 22.6105 41.7984 22.966 41.56 23.26L38.12 26.806M32.546 32.546L21.76 43.66C21.6115 43.8314 21.4091 43.9472 21.186 43.9885C20.963 44.0297 20.7326 43.9939 20.5325 43.887C20.3325 43.78 20.1748 43.6082 20.0853 43.3997C19.9958 43.1913 19.9798 42.9587 20.04 42.74L23.88 30.7C23.9932 30.3969 24.0313 30.0709 23.9908 29.7499C23.9504 29.429 23.8327 29.1226 23.6478 28.8571C23.463 28.5916 23.2165 28.3749 22.9294 28.2256C22.6424 28.0763 22.3235 27.9989 22 28H8C7.62153 28.0013 7.25046 27.8951 6.92991 27.6939C6.60935 27.4927 6.35247 27.2047 6.1891 26.8633C6.02573 26.5219 5.96259 26.1411 6.007 25.7653C6.05141 25.3894 6.20156 25.0339 6.44 24.74L15.454 15.454M4 3.99996L44 44"
                                        stroke="white" stroke-width="3" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>
                        </div>
                        <h1 class="text-white font-bold text-base mb-3">
                            No Active Trades
                        </h1>
                        <p class="text-sm text-[#a4a4a4] mb-6">Start a trade and watch it on the live chart.
                        </p>
                        <div>
                            <div>
                                <a href="{{ route('dashboard.robot') }}">
                                    <button type="button"
                                        class="p-3 w-full text-center text-sm font-semibold rounded-lg bg-accent text-white shadow-2xs cursor-pointer focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none">
                                        Start Trade
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="hidden md:block lg:hidden h-full relative">
        @if ($this->activeBotTickerSymbol !== 'UNKNOWN:UNKNOWN')
            <div class="tradingview-widget-container absolute mb-2 z-10">
                <div class="tradingview-widget-container__widget" style="height:100%;width:100%"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
                    {
                        "autosize": true,
                        "symbol": "{{ $this->activeBotTickerSymbol }}",
                        "interval": "{{ $this->chartDuration }}",
                        "timezone": "Etc/UTC",
                        "theme": "dark",
                        "style": "3",
                        "locale": "en",
                        "allow_symbol_change": true,
                        "backgroundColor": "rgba(22, 22, 22, 1)",
                        "calendar": false,
                        "hide_top_toolbar": true,
                        "hide_volume": true,
                        "support_host": "https://www.tradingview.com"
                    }
                </script>
            </div>
            <a class="absolute right-4 bottom-11 z-20" href="{{ route('dashboard.robot.traderoom') }}">
                <button type="button"
                    class="px-3 py-2 cursor-pointer inline-flex items-center justify-center gap-x-0.5 text-xs font-semibold rounded-lg bg-dashboard border border-accent text-white focus:outline-hidden">
                    Back to trade
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                </button>
            </a>
        @else
            <div class="px-12 flex items-center justify-center h-full">
                <div
                    class="max-w-sm mx-auto flex flex-col bg-dim border border-[#26252a] rounded-2xl pointer-events-auto">
                    <div class="p-6 overflow-y-auto text-center">
                        <div class="flex justify-center mb-4">
                            <div class="size-18 flex items-center justify-center rounded-full border-3 border-accent">
                                <svg width="48" height="48" viewBox="0 0 48 48" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M21.026 9.71196L26.24 4.33996C26.3885 4.16852 26.5909 4.05267 26.814 4.01143C27.037 3.97018 27.2674 4.00598 27.4675 4.11297C27.6675 4.21995 27.8252 4.39175 27.9147 4.60018C28.0042 4.8086 28.0202 5.04126 27.96 5.25996L25.206 13.894M31.312 20H40C40.3785 19.9987 40.7495 20.1048 41.0701 20.306C41.3906 20.5072 41.6475 20.7952 41.8109 21.1366C41.9743 21.478 42.0374 21.8588 41.993 22.2346C41.9486 22.6105 41.7984 22.966 41.56 23.26L38.12 26.806M32.546 32.546L21.76 43.66C21.6115 43.8314 21.4091 43.9472 21.186 43.9885C20.963 44.0297 20.7326 43.9939 20.5325 43.887C20.3325 43.78 20.1748 43.6082 20.0853 43.3997C19.9958 43.1913 19.9798 42.9587 20.04 42.74L23.88 30.7C23.9932 30.3969 24.0313 30.0709 23.9908 29.7499C23.9504 29.429 23.8327 29.1226 23.6478 28.8571C23.463 28.5916 23.2165 28.3749 22.9294 28.2256C22.6424 28.0763 22.3235 27.9989 22 28H8C7.62153 28.0013 7.25046 27.8951 6.92991 27.6939C6.60935 27.4927 6.35247 27.2047 6.1891 26.8633C6.02573 26.5219 5.96259 26.1411 6.007 25.7653C6.05141 25.3894 6.20156 25.0339 6.44 24.74L15.454 15.454M4 3.99996L44 44"
                                        stroke="white" stroke-width="3" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>
                        </div>
                        <h1 class="text-white font-bold text-base mb-3">
                            No Active Trades
                        </h1>
                        <p class="text-sm text-[#a4a4a4] mb-6">Start a trade and watch it on the live chart.
                        </p>
                        <div>
                            <div>
                                <a href="{{ route('dashboard.robot') }}">
                                    <button type="button"
                                        class="p-3 w-full text-center text-sm font-semibold rounded-lg bg-accent text-white shadow-2xs cursor-pointer focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none">
                                        Start Trade
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="hidden lg:flex h-full">
        <livewire:dashboard.partials.desktop-navbar />
        <div class="h-full flex-1 relative">
            @if ($this->activeBotTickerSymbol !== 'UNKNOWN:UNKNOWN')
                <div class="tradingview-widget-container absolute mb-2 z-10">
                    <div class="tradingview-widget-container__widget" style="height:100%;width:100%"></div>
                    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
                        {
                            "autosize": true,
                            "symbol": "{{ $this->activeBotTickerSymbol }}",
                            "interval": "{{ $this->chartDuration }}",
                            "timezone": "Etc/UTC",
                            "theme": "dark",
                            "style": "3",
                            "locale": "en",
                            "allow_symbol_change": true,
                            "backgroundColor": "rgba(22, 22, 22, 1)",
                            "calendar": false,
                            "hide_top_toolbar": true,
                            "hide_volume": true,
                            "support_host": "https://www.tradingview.com"
                        }
                    </script>
                </div>
                <a class="absolute right-4 bottom-11 z-20" href="{{ route('dashboard.robot.traderoom') }}">
                    <button type="button"
                        class="px-3 py-2 cursor-pointer inline-flex items-center justify-center gap-x-0.5 text-xs font-semibold rounded-lg bg-dashboard border border-accent text-white focus:outline-hidden">
                        Back to trade
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </button>
                </a>
            @else
                <div class="px-12 flex items-center justify-center h-full">
                    <div
                        class="max-w-sm mx-auto flex flex-col bg-dim border border-[#26252a] rounded-2xl pointer-events-auto">
                        <div class="p-6 overflow-y-auto text-center">
                            <div class="flex justify-center mb-4">
                                <div
                                    class="size-18 flex items-center justify-center rounded-full border-3 border-accent">
                                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M21.026 9.71196L26.24 4.33996C26.3885 4.16852 26.5909 4.05267 26.814 4.01143C27.037 3.97018 27.2674 4.00598 27.4675 4.11297C27.6675 4.21995 27.8252 4.39175 27.9147 4.60018C28.0042 4.8086 28.0202 5.04126 27.96 5.25996L25.206 13.894M31.312 20H40C40.3785 19.9987 40.7495 20.1048 41.0701 20.306C41.3906 20.5072 41.6475 20.7952 41.8109 21.1366C41.9743 21.478 42.0374 21.8588 41.993 22.2346C41.9486 22.6105 41.7984 22.966 41.56 23.26L38.12 26.806M32.546 32.546L21.76 43.66C21.6115 43.8314 21.4091 43.9472 21.186 43.9885C20.963 44.0297 20.7326 43.9939 20.5325 43.887C20.3325 43.78 20.1748 43.6082 20.0853 43.3997C19.9958 43.1913 19.9798 42.9587 20.04 42.74L23.88 30.7C23.9932 30.3969 24.0313 30.0709 23.9908 29.7499C23.9504 29.429 23.8327 29.1226 23.6478 28.8571C23.463 28.5916 23.2165 28.3749 22.9294 28.2256C22.6424 28.0763 22.3235 27.9989 22 28H8C7.62153 28.0013 7.25046 27.8951 6.92991 27.6939C6.60935 27.4927 6.35247 27.2047 6.1891 26.8633C6.02573 26.5219 5.96259 26.1411 6.007 25.7653C6.05141 25.3894 6.20156 25.0339 6.44 24.74L15.454 15.454M4 3.99996L44 44"
                                            stroke="white" stroke-width="3" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                            <h1 class="text-white font-bold text-base mb-3">
                                No Active Trades
                            </h1>
                            <p class="text-sm text-[#a4a4a4] mb-6">Start a trade and watch it on the live chart.
                            </p>
                            <div>
                                <div>
                                    <a href="{{ route('dashboard.robot') }}">
                                        <button type="button"
                                            class="p-3 w-full text-center text-sm font-semibold rounded-lg bg-accent text-white shadow-2xs cursor-pointer focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none">
                                            Start Trade
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@script
    <script>
        $wire.on('message', (event) => {
            const toastMarkup = `
                <div class="flex items-center p-4">
                    <div class="shrink-0">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info-icon lucide-info"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                        </svg>
                    </div>
                    <div class="ms-3 flex-1">
                        <p class="text-xs font-semibold text-white">${event.message}</p>
                    </div>
                </div>
            `;

            Toastify({
                text: toastMarkup,
                className: "hs-toastify-on:opacity-100 opacity-0 absolute top-0 start-1/2 -translate-x-1/2 z-90 w-4/5 md:w-1/2 lg:w-1/4 transition-all duration-300 bg-dim  border border-[#26252a] text-sm text-white rounded-xl shadow-lg [&>.toast-close]:hidden",
                duration: 6000,
                close: true,
                escapeMarkup: false
            }).showToast();
        });
    </script>
@endscript
