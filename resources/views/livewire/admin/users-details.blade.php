<!-- ===== Content Area Start ===== -->
<div class="relative flex flex-1 flex-col overflow-x-hidden overflow-y-auto">
    <!-- Small Device Overlay Start -->
    <div :class="sidebarToggle ? 'block lg:hidden' : 'hidden'" class="fixed z-9 h-screen w-full bg-gray-900/50">
    </div>
    <!-- Small Device Overlay End -->

    <!-- ===== Main Content Start ===== -->
    <main>
        <livewire:admin.partials.header :key="'header-' . now()" />
        <div class="mx-auto max-w-(--breakpoint-2xl) p-4 md:p-6">
            <!-- Flash messages -->
            @if (session()->has('success-message'))
                <div wire:key="success-{{ time() }}" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => { show = false }, 4000)"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90"
                    class="rounded-xl border border-success-500 bg-success-50 p-4 mb-4 dark:border-success-500/30 dark:bg-success-500/15">
                    <div class="flex items-start gap-3">
                        <div class="-mt-0.5 text-success-500">
                            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M3.70186 12.0001C3.70186 7.41711 7.41711 3.70186 12.0001 3.70186C16.5831 3.70186 20.2984 7.41711 20.2984 12.0001C20.2984 16.5831 16.5831 20.2984 12.0001 20.2984C7.41711 20.2984 3.70186 16.5831 3.70186 12.0001ZM12.0001 1.90186C6.423 1.90186 1.90186 6.423 1.90186 12.0001C1.90186 17.5772 6.423 22.0984 12.0001 22.0984C17.5772 22.0984 22.0984 17.5772 22.0984 12.0001C22.0984 6.423 17.5772 1.90186 12.0001 1.90186ZM15.6197 10.7395C15.9712 10.388 15.9712 9.81819 15.6197 9.46672C15.2683 9.11525 14.6984 9.11525 14.347 9.46672L11.1894 12.6243L9.6533 11.0883C9.30183 10.7368 8.73198 10.7368 8.38051 11.0883C8.02904 11.4397 8.02904 12.0096 8.38051 12.3611L10.553 14.5335C10.7217 14.7023 10.9507 14.7971 11.1894 14.7971C11.428 14.7971 11.657 14.7023 11.8257 14.5335L15.6197 10.7395Z"
                                    fill="" />
                            </svg>
                        </div>

                        <div>
                            <h4 class="mb-1 text-sm font-semibold text-gray-800 dark:text-white/90">
                                {{ session('success-message') }}
                            </h4>
                        </div>
                    </div>
                </div>
            @endif

            @if (session()->has('error-message'))
                <div wire:key="success-{{ time() }}" x-data="{ show: true }" x-show="show"
                    x-init="setTimeout(() => { show = false }, 4000)" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90"
                    class="rounded-xl border border-error-500 bg-error-50 mb-4 p-4 dark:border-error-500/30 dark:bg-error-500/15">
                    <div class="flex items-start gap-3">
                        <div class="-mt-0.5 text-error-500">
                            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M20.3499 12.0004C20.3499 16.612 16.6115 20.3504 11.9999 20.3504C7.38832 20.3504 3.6499 16.612 3.6499 12.0004C3.6499 7.38881 7.38833 3.65039 11.9999 3.65039C16.6115 3.65039 20.3499 7.38881 20.3499 12.0004ZM11.9999 22.1504C17.6056 22.1504 22.1499 17.6061 22.1499 12.0004C22.1499 6.3947 17.6056 1.85039 11.9999 1.85039C6.39421 1.85039 1.8499 6.3947 1.8499 12.0004C1.8499 17.6061 6.39421 22.1504 11.9999 22.1504ZM13.0008 16.4753C13.0008 15.923 12.5531 15.4753 12.0008 15.4753L11.9998 15.4753C11.4475 15.4753 10.9998 15.923 10.9998 16.4753C10.9998 17.0276 11.4475 17.4753 11.9998 17.4753L12.0008 17.4753C12.5531 17.4753 13.0008 17.0276 13.0008 16.4753ZM11.9998 6.62898C12.414 6.62898 12.7498 6.96476 12.7498 7.37898L12.7498 13.0555C12.7498 13.4697 12.414 13.8055 11.9998 13.8055C11.5856 13.8055 11.2498 13.4697 11.2498 13.0555L11.2498 7.37898C11.2498 6.96476 11.5856 6.62898 11.9998 6.62898Z"
                                    fill="#F04438" />
                            </svg>
                        </div>

                        <div>
                            <h4 class="mb-1 text-sm font-semibold text-gray-800 dark:text-white/90">
                                {{ session('error-message') }}
                            </h4>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Metric Group One -->
            <div class="flex flex-col lg:flex-row gap-4 mb-4">
                <!-- Metric Item Start -->
                <div
                    class="grow rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                        <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M8.80443 5.60156C7.59109 5.60156 6.60749 6.58517 6.60749 7.79851C6.60749 9.01185 7.59109 9.99545 8.80443 9.99545C10.0178 9.99545 11.0014 9.01185 11.0014 7.79851C11.0014 6.58517 10.0178 5.60156 8.80443 5.60156ZM5.10749 7.79851C5.10749 5.75674 6.76267 4.10156 8.80443 4.10156C10.8462 4.10156 12.5014 5.75674 12.5014 7.79851C12.5014 9.84027 10.8462 11.4955 8.80443 11.4955C6.76267 11.4955 5.10749 9.84027 5.10749 7.79851ZM4.86252 15.3208C4.08769 16.0881 3.70377 17.0608 3.51705 17.8611C3.48384 18.0034 3.5211 18.1175 3.60712 18.2112C3.70161 18.3141 3.86659 18.3987 4.07591 18.3987H13.4249C13.6343 18.3987 13.7992 18.3141 13.8937 18.2112C13.9797 18.1175 14.017 18.0034 13.9838 17.8611C13.7971 17.0608 13.4132 16.0881 12.6383 15.3208C11.8821 14.572 10.6899 13.955 8.75042 13.955C6.81096 13.955 5.61877 14.572 4.86252 15.3208ZM3.8071 14.2549C4.87163 13.2009 6.45602 12.455 8.75042 12.455C11.0448 12.455 12.6292 13.2009 13.6937 14.2549C14.7397 15.2906 15.2207 16.5607 15.4446 17.5202C15.7658 18.8971 14.6071 19.8987 13.4249 19.8987H4.07591C2.89369 19.8987 1.73504 18.8971 2.05628 17.5202C2.28015 16.5607 2.76117 15.2906 3.8071 14.2549ZM15.3042 11.4955C14.4702 11.4955 13.7006 11.2193 13.0821 10.7533C13.3742 10.3314 13.6054 9.86419 13.7632 9.36432C14.1597 9.75463 14.7039 9.99545 15.3042 9.99545C16.5176 9.99545 17.5012 9.01185 17.5012 7.79851C17.5012 6.58517 16.5176 5.60156 15.3042 5.60156C14.7039 5.60156 14.1597 5.84239 13.7632 6.23271C13.6054 5.73284 13.3741 5.26561 13.082 4.84371C13.7006 4.37777 14.4702 4.10156 15.3042 4.10156C17.346 4.10156 19.0012 5.75674 19.0012 7.79851C19.0012 9.84027 17.346 11.4955 15.3042 11.4955ZM19.9248 19.8987H16.3901C16.7014 19.4736 16.9159 18.969 16.9827 18.3987H19.9248C20.1341 18.3987 20.2991 18.3141 20.3936 18.2112C20.4796 18.1175 20.5169 18.0034 20.4837 17.861C20.2969 17.0607 19.913 16.088 19.1382 15.3208C18.4047 14.5945 17.261 13.9921 15.4231 13.9566C15.2232 13.6945 14.9995 13.437 14.7491 13.1891C14.5144 12.9566 14.262 12.7384 13.9916 12.5362C14.3853 12.4831 14.8044 12.4549 15.2503 12.4549C17.5447 12.4549 19.1291 13.2008 20.1936 14.2549C21.2395 15.2906 21.7206 16.5607 21.9444 17.5202C22.2657 18.8971 21.107 19.8987 19.9248 19.8987Z"
                                fill="" />
                        </svg>
                    </div>

                    <div class="mt-5 flex items-end justify-between">
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Live Balance</span>
                            <h4 class="mt-2 text-title-sm font-bold text-gray-800 dark:text-white/90">
                                @money($this->liveBalance / 100)
                            </h4>
                        </div>
                    </div>
                </div>
                <!-- Metric Item End -->

                <!-- Metric Item Start -->
                <div
                    class="grow rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                        <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.665 3.75618C11.8762 3.65061 12.1247 3.65061 12.3358 3.75618L18.7807 6.97853L12.3358 10.2009C12.1247 10.3064 11.8762 10.3064 11.665 10.2009L5.22014 6.97853L11.665 3.75618ZM4.29297 8.19199V16.0946C4.29297 16.3787 4.45347 16.6384 4.70757 16.7654L11.25 20.0365V11.6512C11.1631 11.6205 11.0777 11.5843 10.9942 11.5425L4.29297 8.19199ZM12.75 20.037L19.2933 16.7654C19.5474 16.6384 19.7079 16.3787 19.7079 16.0946V8.19199L13.0066 11.5425C12.9229 11.5844 12.8372 11.6207 12.75 11.6515V20.037ZM13.0066 2.41453C12.3732 2.09783 11.6277 2.09783 10.9942 2.41453L4.03676 5.89316C3.27449 6.27429 2.79297 7.05339 2.79297 7.90563V16.0946C2.79297 16.9468 3.27448 17.7259 4.03676 18.1071L10.9942 21.5857L11.3296 20.9149L10.9942 21.5857C11.6277 21.9024 12.3732 21.9024 13.0066 21.5857L19.9641 18.1071C20.7264 17.7259 21.2079 16.9468 21.2079 16.0946V7.90563C21.2079 7.05339 20.7264 6.27429 19.9641 5.89316L13.0066 2.41453Z"
                                fill="" />
                        </svg>
                    </div>

                    <div class="mt-5 flex items-end justify-between">
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Active Bots</span>
                            <h4 class="mt-2 text-title-sm font-bold text-gray-800 dark:text-white/90">
                                {{ $this->activeBotCount }}
                            </h4>
                        </div>
                    </div>
                </div>
                <!-- Metric Item End -->

                <!-- Metric Item Start -->
                <div
                    class="grow rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                        <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.665 3.75618C11.8762 3.65061 12.1247 3.65061 12.3358 3.75618L18.7807 6.97853L12.3358 10.2009C12.1247 10.3064 11.8762 10.3064 11.665 10.2009L5.22014 6.97853L11.665 3.75618ZM4.29297 8.19199V16.0946C4.29297 16.3787 4.45347 16.6384 4.70757 16.7654L11.25 20.0365V11.6512C11.1631 11.6205 11.0777 11.5843 10.9942 11.5425L4.29297 8.19199ZM12.75 20.037L19.2933 16.7654C19.5474 16.6384 19.7079 16.3787 19.7079 16.0946V8.19199L13.0066 11.5425C12.9229 11.5844 12.8372 11.6207 12.75 11.6515V20.037ZM13.0066 2.41453C12.3732 2.09783 11.6277 2.09783 10.9942 2.41453L4.03676 5.89316C3.27449 6.27429 2.79297 7.05339 2.79297 7.90563V16.0946C2.79297 16.9468 3.27448 17.7259 4.03676 18.1071L10.9942 21.5857L11.3296 20.9149L10.9942 21.5857C11.6277 21.9024 12.3732 21.9024 13.0066 21.5857L19.9641 18.1071C20.7264 17.7259 21.2079 16.9468 21.2079 16.0946V7.90563C21.2079 7.05339 20.7264 6.27429 19.9641 5.89316L13.0066 2.41453Z"
                                fill="" />
                        </svg>
                    </div>

                    <div class="mt-5 flex items-end justify-between">
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Email Address</span>
                            <h5 class="mt-2 text-xl font-bold text-gray-800 dark:text-white/90">
                                {{ $this->email }}
                            </h5>
                        </div>
                    </div>
                </div>
                <!-- Metric Item End -->

                <!-- Metric Item Start -->
                <div
                    class="grow rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                        <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.665 3.75618C11.8762 3.65061 12.1247 3.65061 12.3358 3.75618L18.7807 6.97853L12.3358 10.2009C12.1247 10.3064 11.8762 10.3064 11.665 10.2009L5.22014 6.97853L11.665 3.75618ZM4.29297 8.19199V16.0946C4.29297 16.3787 4.45347 16.6384 4.70757 16.7654L11.25 20.0365V11.6512C11.1631 11.6205 11.0777 11.5843 10.9942 11.5425L4.29297 8.19199ZM12.75 20.037L19.2933 16.7654C19.5474 16.6384 19.7079 16.3787 19.7079 16.0946V8.19199L13.0066 11.5425C12.9229 11.5844 12.8372 11.6207 12.75 11.6515V20.037ZM13.0066 2.41453C12.3732 2.09783 11.6277 2.09783 10.9942 2.41453L4.03676 5.89316C3.27449 6.27429 2.79297 7.05339 2.79297 7.90563V16.0946C2.79297 16.9468 3.27448 17.7259 4.03676 18.1071L10.9942 21.5857L11.3296 20.9149L10.9942 21.5857C11.6277 21.9024 12.3732 21.9024 13.0066 21.5857L19.9641 18.1071C20.7264 17.7259 21.2079 16.9468 21.2079 16.0946V7.90563C21.2079 7.05339 20.7264 6.27429 19.9641 5.89316L13.0066 2.41453Z"
                                fill="" />
                        </svg>
                    </div>

                    <div class="mt-5 flex items-end justify-between">
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Country</span>
                            <h5 class="mt-2 text-xl font-bold text-gray-800 dark:text-white/90">
                                {{ $this->country }}
                            </h5>
                        </div>
                    </div>
                </div>
                <!-- Metric Item End -->
            </div>
            <!-- Metric Group One -->

            <div class="mb-4" x-data="{ activeTab: 'addBonus' }">
                <div class="rounded-t-xl border border-gray-200 p-3 dark:border-gray-800">
                    <nav
                        class="flex overflow-x-auto rounded-lg bg-gray-100 p-1 dark:bg-gray-900 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-thumb]:bg-gray-200 dark:[&::-webkit-scrollbar-thumb]:bg-gray-600 [&::-webkit-scrollbar-track]:bg-white dark:[&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar]:h-1.5">
                        <button
                            class="inline-flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors duration-200 ease-in-out"
                            x-bind:class="activeTab === 'addBonus' ?
                                'bg-white text-gray-900 shadow-theme-xs dark:bg-white/[0.03] dark:text-white' :
                                'bg-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'"
                            x-on:click="activeTab = 'addBonus'">
                            Add Bonus
                        </button>
                        <button
                            class="inline-flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors duration-200 ease-in-out"
                            x-bind:class="activeTab === 'removeBonus' ?
                                'bg-white text-gray-900 shadow-theme-xs dark:bg-white/[0.03] dark:text-white' :
                                'bg-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'"
                            x-on:click="activeTab = 'removeBonus'">
                            Remove Bonus
                        </button>
                        <button
                            class="inline-flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors duration-200 ease-in-out"
                            x-bind:class="activeTab === 'notification' ?
                                'bg-white text-gray-900 shadow-theme-xs dark:bg-white/[0.03] dark:text-white' :
                                'bg-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'"
                            x-on:click="activeTab = 'notification'">
                            Send Email
                        </button>
                    </nav>
                </div>
                <div class="rounded-b-xl border border-t-0 border-gray-200 p-6 pt-4 dark:border-gray-800">
                    <div x-show="activeTab === 'addBonus'">
                        <div
                            class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                            <div class="p-5 space-y-6 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                                <form wire:submit.prevent="addBonus()">
                                    <div class="-mx-2.5 flex flex-wrap gap-y-5">
                                        <div class="w-full px-2.5">
                                            <input wire:model="bonusAmount" type="text" placeholder="Amount"
                                                class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10" />
                                        </div>

                                        <div class="w-full px-2.5">
                                            <button type="submit" wire:loading.attr="disabled"
                                                class="w-full p-3 text-sm font-medium text-white transition-colors rounded-lg bg-brand-500 hover:bg-brand-600 disabled:opacity-50 disabled:pointer-events-none">
                                                Add Bonus
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div x-show="activeTab === 'removeBonus'">
                        <div
                            class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                            <div class="p-5 space-y-6 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                                <form wire:submit.prevent="removeBonus()">
                                    <div class="-mx-2.5 flex flex-wrap gap-y-5">
                                        <div class="w-full px-2.5">
                                            <input wire:model="bonusAmount" type="text" placeholder="Amount"
                                                class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10" />
                                        </div>

                                        <div class="w-full px-2.5">
                                            <button type="submit" wire:loading.attr="disabled"
                                                class="w-full p-3 text-sm font-medium text-white transition-colors rounded-lg bg-brand-500 hover:bg-brand-600 disabled:opacity-50 disabled:pointer-events-none">
                                                Remove Bonus
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div x-show="activeTab === 'notification'">
                        <div
                            class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                            <div class="p-5 space-y-6 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                                <form wire:submit.prevent="sendBroadcast">
                                    <div class="-mx-2.5 flex flex-wrap gap-y-5">
                                        <div class="w-full px-2.5">
                                            <input wire:model="subject" type="text" placeholder="Subject"
                                                class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
                                                required />
                                        </div>

                                        <div class="w-full px-2.5">
                                            <textarea wire:model="message" placeholder="Enter your message" rows="6"
                                                class="dark:bg-dark-900 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
                                                required></textarea>
                                        </div>

                                        <div class="w-full px-2.5">
                                            <button type="submit" wire:loading.attr="disabled"
                                                class="flex items-center justify-center w-full gap-2 p-3 text-sm font-medium text-white transition-colors rounded-lg bg-brand-500 hover:bg-brand-600 disabled:opacity-50 disabled:pointer-events-none">
                                                Send Message

                                                <svg class="fill-current" width="20" height="20"
                                                    viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M4.98481 2.44399C3.11333 1.57147 1.15325 3.46979 1.96543 5.36824L3.82086 9.70527C3.90146 9.89367 3.90146 10.1069 3.82086 10.2953L1.96543 14.6323C1.15326 16.5307 3.11332 18.4291 4.98481 17.5565L16.8184 12.0395C18.5508 11.2319 18.5508 8.76865 16.8184 7.961L4.98481 2.44399ZM3.34453 4.77824C3.0738 4.14543 3.72716 3.51266 4.35099 3.80349L16.1846 9.32051C16.762 9.58973 16.762 10.4108 16.1846 10.68L4.35098 16.197C3.72716 16.4879 3.0738 15.8551 3.34453 15.2223L5.19996 10.8853C5.21944 10.8397 5.23735 10.7937 5.2537 10.7473L9.11784 10.7473C9.53206 10.7473 9.86784 10.4115 9.86784 9.99726C9.86784 9.58304 9.53206 9.24726 9.11784 9.24726L5.25157 9.24726C5.2358 9.20287 5.2186 9.15885 5.19996 9.11528L3.34453 4.77824Z"
                                                        fill="" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 mb-4 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
                    <!-- Table Five -->
                    <div
                        class="rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div
                            class="mb-4 flex flex-col gap-2 px-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                    Deposits
                                </h3>
                            </div>
                        </div>

                        <div class="custom-scrollbar max-w-full overflow-x-auto overflow-y-visible px-5 sm:px-6">
                            <table class="min-w-full">
                                <thead class="border-y border-gray-100 py-3 dark:border-gray-800">
                                    <th class="py-3 pr-5 font-normal whitespace-nowrap sm:pr-6">
                                        <div class="flex items-center">
                                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">User</p>
                                        </div>
                                    </th>
                                    <th class="px-5 py-3 font-normal whitespace-nowrap sm:px-6">
                                        <div class="flex items-center">
                                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">Payment Method
                                            </p>
                                        </div>
                                    </th>
                                    <th class="px-5 py-3 font-normal whitespace-nowrap sm:px-6">
                                        <div class="flex items-center">
                                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">Amount</p>
                                        </div>
                                    </th>
                                    <th class="px-5 py-3 font-normal whitespace-nowrap sm:px-6">
                                        <div class="flex items-center">
                                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">Status</p>
                                        </div>
                                    </th>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                    @forelse ($deposits as $deposit)
                                        <tr wire:key="deposit-{{ $deposit['id'] }}" x-data="{ isActionDropdownOpen: false }">
                                            <td class="py-3 pr-5 whitespace-nowrap sm:pr-5">
                                                <div class="flex items-center">
                                                    <p
                                                        class="text-theme-sm block font-medium text-gray-700 dark:text-gray-400">
                                                        {{ $deposit['user']['name'] }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 whitespace-nowrap sm:px-6">
                                                <div class="flex items-center">
                                                    <p class="text-theme-sm text-gray-700 dark:text-gray-400">
                                                        {{ $deposit['payment_method'] }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 whitespace-nowrap sm:px-6">
                                                <div class="flex items-center">
                                                    <p class="text-theme-sm text-gray-700 dark:text-gray-400">
                                                        @money($deposit['amount'] / 100)
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 whitespace-nowrap sm:px-6">
                                                <div class="flex items-center">
                                                    <p
                                                        class="text-theme-xs {{ $this->getStatusIndicatorColor($deposit['status']) }} rounded-full px-2 py-0.5 font-medium">
                                                        {{ ucfirst($deposit['status']) }}
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4 text-theme-sm text-gray-500">
                                                No deposits found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex justify-center mt-8">
                        <div>
                            {{ $deposits->appends(['deposits_page' => $deposits->currentPage()])->links('livewire::tailwind') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 mb-4 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
                    <!-- Table Five -->
                    <div
                        class="rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div
                            class="mb-4 flex flex-col gap-2 px-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                    Withdrawals
                                </h3>
                            </div>
                        </div>

                        <div class="custom-scrollbar max-w-full overflow-x-auto overflow-y-visible px-5 sm:px-6">
                            <table class="min-w-full">
                                <thead class="border-y border-gray-100 py-3 dark:border-gray-800">
                                    <th class="py-3 pr-5 font-normal whitespace-nowrap sm:pr-6">
                                        <div class="flex items-center">
                                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">User</p>
                                        </div>
                                    </th>
                                    <th class="px-5 py-3 font-normal whitespace-nowrap sm:px-6">
                                        <div class="flex items-center">
                                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">Payment Method
                                            </p>
                                        </div>
                                    </th>
                                    <th class="px-5 py-3 font-normal whitespace-nowrap sm:px-6">
                                        <div class="flex items-center">
                                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">Amount</p>
                                        </div>
                                    </th>
                                    <th class="px-5 py-3 font-normal whitespace-nowrap sm:px-6">
                                        <div class="flex items-center">
                                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">Status</p>
                                        </div>
                                    </th>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                    @forelse ($withdrawals as $withdrawal)
                                        <tr wire:key="withdrawal-{{ $withdrawal['id'] }}" x-data="{ isActionDropdownOpen: false }">
                                            <td class="py-3 pr-5 whitespace-nowrap sm:pr-5">
                                                <div class="flex items-center">
                                                    <p
                                                        class="text-theme-sm block font-medium text-gray-700 dark:text-gray-400">
                                                        {{ $withdrawal['user']['name'] }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 whitespace-nowrap sm:px-6">
                                                <div class="flex items-center">
                                                    <p class="text-theme-sm text-gray-700 dark:text-gray-400">
                                                        {{ $withdrawal['payment_method'] }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 whitespace-nowrap sm:px-6">
                                                <div class="flex items-center">
                                                    <p class="text-theme-sm text-gray-700 dark:text-gray-400">
                                                        @money($withdrawal['amount'] / 100)
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 whitespace-nowrap sm:px-6">
                                                <div class="flex items-center">
                                                    <p
                                                        class="text-theme-xs {{ $this->getStatusIndicatorColor($withdrawal['status']) }} rounded-full px-2 py-0.5 font-medium">
                                                        {{ ucfirst($withdrawal['status']) }}
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4 text-theme-sm text-gray-500">
                                                No withdrawals found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex justify-center mt-8">
                        <div>
                            {{ $withdrawals->appends(['withdrawals_page' => $withdrawals->currentPage()])->links('livewire::tailwind') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 mb-4 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
                    <!-- Table Five -->
                    <div
                        class="rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div
                            class="mb-4 flex flex-col gap-2 px-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                    Bots
                                </h3>
                            </div>
                        </div>

                        <div class="custom-scrollbar max-w-full overflow-x-auto overflow-y-visible px-5 sm:px-6">
                            <table class="min-w-full">
                                <thead class="border-y border-gray-100 py-3 dark:border-gray-800">
                                    <th class="py-3 pr-5 font-normal whitespace-nowrap sm:pr-6">
                                        <div class="flex items-center">
                                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">Strategy</p>
                                        </div>
                                    </th>
                                    <th class="px-5 py-3 font-normal whitespace-nowrap sm:px-6">
                                        <div class="flex items-center">
                                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">Amount</p>
                                        </div>
                                    </th>
                                    <th class="px-5 py-3 font-normal whitespace-nowrap sm:px-6">
                                        <div class="flex items-center">
                                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">
                                                Profit
                                            </p>
                                        </div>
                                    </th>
                                    <th class="px-5 py-3 font-normal whitespace-nowrap sm:px-6">
                                        <div class="flex items-center">
                                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">
                                                Account Type
                                            </p>
                                        </div>
                                    </th>
                                    <th class="px-5 py-3 font-normal whitespace-nowrap sm:px-6">
                                        <div class="flex items-center">
                                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">Status</p>
                                        </div>
                                    </th>
                                    <th class="px-5 py-3 font-normal whitespace-nowrap sm:px-6">
                                        <div class="flex items-center">
                                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">Start</p>
                                        </div>
                                    </th>
                                    <th class="px-5 py-3 font-normal whitespace-nowrap sm:px-6">
                                        <div class="flex items-center">
                                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">End</p>
                                        </div>
                                    </th>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                    @forelse ($bots as $bot)
                                        <tr wire:key="bot-{{ $bot['id'] }}" x-data="{ isActionDropdownOpen: false }">
                                            <td class="py-3 pr-5 whitespace-nowrap sm:pr-5">
                                                <div class="flex items-center">
                                                    <p
                                                        class="text-theme-sm block font-medium text-gray-700 dark:text-gray-400">
                                                        {{ $this->getStrategyName($bot['strategy']) }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 whitespace-nowrap sm:px-6">
                                                <div class="flex items-center">
                                                    <p class="text-theme-sm text-gray-700 dark:text-gray-400">
                                                        @money($bot['amount'] / 100)
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 whitespace-nowrap sm:px-6">
                                                <div class="flex items-center">
                                                    <p class="text-theme-sm text-gray-700 dark:text-gray-400">
                                                        @money($this->displayProfitMinusFee($bot['profit']))
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 whitespace-nowrap sm:px-6">
                                                <div class="flex items-center">
                                                    <p class="text-theme-sm text-gray-700 dark:text-gray-400">
                                                        {{ ucfirst($bot['account_type']) }} Account
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 whitespace-nowrap sm:px-6">
                                                <div class="flex items-center">
                                                    <p
                                                        class="text-theme-xs {{ $this->getStatusIndicatorColor($bot['status']) }} rounded-full px-2 py-0.5 font-medium">
                                                        {{ ucfirst($bot['status']) }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 whitespace-nowrap sm:px-6">
                                                <div class="flex items-center">
                                                    <p class="text-theme-sm text-gray-700 dark:text-gray-400">
                                                        {{ $this->convertTimestampToDateTime($bot['start']) }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 whitespace-nowrap sm:px-6">
                                                <div class="flex items-center">
                                                    <p class="text-theme-sm text-gray-700 dark:text-gray-400">
                                                        {{ $this->convertTimestampToDateTime($bot['end']) }}
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4 text-theme-sm text-gray-500">
                                                No active bots found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex justify-center mt-8">
                        <div>
                            {{ $bots->appends(['bots_page' => $bots->currentPage()])->links('livewire::tailwind') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
                    <div
                        class="rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div
                            class="mb-4 flex flex-col gap-2 px-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                    Referrals
                                </h3>
                            </div>
                        </div>

                        <div class="custom-scrollbar max-w-full overflow-x-auto overflow-y-visible px-5 sm:px-6">
                            <table class="min-w-full">
                                <thead class="border-y border-gray-100 py-3 dark:border-gray-800">
                                    <th class="py-3 pr-5 font-normal whitespace-nowrap sm:pr-6">
                                        <div class="flex items-center">
                                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">User</p>
                                        </div>
                                    </th>
                                    <th class="px-5 py-3 font-normal whitespace-nowrap sm:px-6">
                                        <div class="flex items-center">
                                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">Amount</p>
                                        </div>
                                    </th>
                                    <th class="px-5 py-3 font-normal whitespace-nowrap sm:px-6">
                                        <div class="flex items-center">
                                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">
                                                Status
                                            </p>
                                        </div>
                                    </th>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                    @forelse ($referrals as $referral)
                                        <tr wire:key="referral-{{ $referral['id'] }}" x-data="{ isActionDropdownOpen: false }">
                                            <td class="py-3 pr-5 whitespace-nowrap sm:pr-5">
                                                <div class="flex items-center">
                                                    <p
                                                        class="text-theme-sm block font-medium text-gray-700 dark:text-gray-400">
                                                        {{ $referral['name'] }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 whitespace-nowrap sm:px-6">
                                                <div class="flex items-center">
                                                    <p class="text-theme-sm text-gray-700 dark:text-gray-400">
                                                        @money($this->getReferralAmountRedeemable($referral['referral_code']) / 100)
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 whitespace-nowrap sm:px-6">
                                                <div class="flex items-center">
                                                    <p
                                                        class="text-theme-xs {{ $this->getStatusIndicatorColor($this->getReferralStatus($referral['referral_code'])) }} rounded-full px-2 py-0.5 font-medium">
                                                        {{ ucfirst($this->getReferralStatus($referral['referral_code'])) }}
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4 text-theme-sm text-gray-500">
                                                No referrals found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex justify-center mt-8">
                        <div>
                            {{ $referrals->appends(['referrals_page' => $referrals->currentPage()])->links('livewire::tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- ===== Main Content End ===== -->
</div>
<!-- ===== Content Area End ===== -->
