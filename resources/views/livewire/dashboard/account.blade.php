<div x-data class="px-4 lg:px-0 h-full">
    <div class="lg:flex lg:h-full">
        <livewire:dashboard.partials.desktop-navbar />
        <div class="lg:h-full lg:flex-1 lg:px-96 lg:pt-6">
            <div class="py-2 lg:h-full lg:pb-24 lg:overflow-scroll scrollbar-hide">
                <div class="flex flex-col gap-y-2 px-2 py-3 md:px-4 md:p-4 bg-dim rounded-lg border border-[#323335]">
                    <div class="flex items-start space-x-4">
                        <div class="flex-none flex justify-center mb-3 lg:justify-start">
                            <a x-on:click="$store.accountPage.toggleProfilePictureModal();">
                                <div
                                    class="relative bg-[#232323] size-16 rounded-full flex items-center justify-center lg:size-20">
                                    @if (auth()->user()->profile_image_path === null)
                                        <svg class="absolute" xmlns="http://www.w3.org/2000/svg" width="48"
                                            height="48" viewBox="0 0 48 48" fill="none">
                                            <g clip-path="url(#clip0_49_26)">
                                                <path
                                                    d="M6 24C6 26.3638 6.46558 28.7044 7.37017 30.8883C8.27475 33.0722 9.60062 35.0565 11.2721 36.7279C12.9435 38.3994 14.9278 39.7252 17.1117 40.6298C19.2956 41.5344 21.6362 42 24 42C26.3638 42 28.7044 41.5344 30.8883 40.6298C33.0722 39.7252 35.0565 38.3994 36.7279 36.7279C38.3994 35.0565 39.7252 33.0722 40.6298 30.8883C41.5344 28.7044 42 26.3638 42 24C42 21.6362 41.5344 19.2956 40.6298 17.1117C39.7252 14.9278 38.3994 12.9435 36.7279 11.2721C35.0565 9.60062 33.0722 8.27475 30.8883 7.37017C28.7044 6.46558 26.3638 6 24 6C21.6362 6 19.2956 6.46558 17.1117 7.37017C14.9278 8.27475 12.9435 9.60062 11.2721 11.2721C9.60062 12.9435 8.27475 14.9278 7.37017 17.1117C6.46558 19.2956 6 21.6362 6 24Z"
                                                    stroke="white" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M18 20C18 21.5913 18.6321 23.1174 19.7574 24.2426C20.8826 25.3679 22.4087 26 24 26C25.5913 26 27.1174 25.3679 28.2426 24.2426C29.3679 23.1174 30 21.5913 30 20C30 18.4087 29.3679 16.8826 28.2426 15.7574C27.1174 14.6321 25.5913 14 24 14C22.4087 14 20.8826 14.6321 19.7574 15.7574C18.6321 16.8826 18 18.4087 18 20Z"
                                                    fill="white" stroke="white" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path
                                                    d="M12.3359 37.698C12.831 36.0505 13.8439 34.6064 15.2244 33.58C16.605 32.5535 18.2796 31.9995 19.9999 32H27.9999C29.7225 31.9994 31.3992 32.5548 32.7807 33.5836C34.1623 34.6123 35.1749 36.0596 35.6679 37.71"
                                                    stroke="white" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_49_26">
                                                    <rect width="48" height="48" fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    @else
                                        <img class="absolute size-16 rounded-full"
                                            src="{{ asset('storage/' . auth()->user()->profile_image_path) }}"
                                            alt="">
                                    @endif
                                    <svg class="absolute right-0.5 bottom-0.5" width="17" height="17"
                                        viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_1453_20)">
                                            <path
                                                d="M9.95396 2.53906C10.1849 2.53922 10.4087 2.61931 10.5873 2.76573L10.6606 2.8324L11.702 3.8724H13.4253C13.7617 3.87229 14.0857 3.99933 14.3323 4.22806C14.579 4.45679 14.7301 4.77029 14.7553 5.10573L14.7586 5.20573V13.2057C14.7587 13.5421 14.6317 13.8661 14.403 14.1128C14.1742 14.3594 13.8607 14.5105 13.5253 14.5357L13.4253 14.5391H2.75863C2.42224 14.5392 2.09825 14.4121 1.85159 14.1834C1.60494 13.9547 1.45386 13.6412 1.42863 13.3057L1.42529 13.2057V5.20573C1.42519 4.86934 1.55223 4.54535 1.78096 4.2987C2.00968 4.05204 2.32319 3.90096 2.65863 3.87573L2.75863 3.8724H4.48263L5.52263 2.8324C5.68602 2.66867 5.90112 2.56666 6.13129 2.54373L6.22996 2.53906H9.95396ZM8.09196 5.53906C7.2079 5.53906 6.36006 5.89025 5.73494 6.51537C5.10982 7.14049 4.75863 7.98834 4.75863 8.8724C4.75863 9.75645 5.10982 10.6043 5.73494 11.2294C6.36006 11.8545 7.2079 12.2057 8.09196 12.2057C8.97601 12.2057 9.82386 11.8545 10.449 11.2294C11.0741 10.6043 11.4253 9.75645 11.4253 8.8724C11.4253 7.98834 11.0741 7.14049 10.449 6.51537C9.82386 5.89025 8.97601 5.53906 8.09196 5.53906ZM8.09196 6.8724C8.3546 6.8724 8.61467 6.92413 8.85733 7.02464C9.09998 7.12515 9.32046 7.27246 9.50617 7.45818C9.69189 7.6439 9.83921 7.86438 9.93972 8.10703C10.0402 8.34968 10.092 8.60975 10.092 8.8724C10.092 9.13504 10.0402 9.39511 9.93972 9.63776C9.83921 9.88041 9.69189 10.1009 9.50617 10.2866C9.32046 10.4723 9.09998 10.6196 8.85733 10.7202C8.61467 10.8207 8.3546 10.8724 8.09196 10.8724C7.56153 10.8724 7.05282 10.6617 6.67775 10.2866C6.30267 9.91154 6.09196 9.40283 6.09196 8.8724C6.09196 8.34196 6.30267 7.83325 6.67775 7.45818C7.05282 7.08311 7.56153 6.8724 8.09196 6.8724Z"
                                                fill="white" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1453_20">
                                                <rect width="16" height="16" fill="white"
                                                    transform="translate(0.0917969 0.539062)" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                            </a>
                        </div>
                        <div class="text-start grow">
                            <div class="flex items-center gap-x-0.5">
                                <div class="flex-none">
                                    <p class="text-white text-base font-bold">{{ auth()->user()->name }}</p>
                                </div>
                                @if ($this->kycStatus === 'Verified')
                                    <div class="flex-none">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_793_3)">
                                                <path
                                                    d="M8.00662 1.34067C8.52514 1.3407 9.0259 1.52958 9.41528 1.872L9.51795 1.96867L9.98328 2.434C10.111 2.56088 10.2778 2.64097 10.4566 2.66133L10.5466 2.66667H11.2133C11.7581 2.66664 12.2823 2.87505 12.6783 3.24916C13.0744 3.62327 13.3123 4.13474 13.3433 4.67867L13.3466 4.8V5.46667C13.3466 5.64667 13.4079 5.822 13.5186 5.962L13.5786 6.02867L14.0433 6.494C14.4284 6.87697 14.653 7.39241 14.6712 7.93525C14.6894 8.47808 14.4999 9.00742 14.1413 9.41533L14.0446 9.518L13.5793 9.98333C13.4524 10.111 13.3723 10.2778 13.3519 10.4567L13.3466 10.5467V11.2133C13.3466 11.7581 13.1382 12.2823 12.7641 12.6784C12.39 13.0744 11.8785 13.3123 11.3346 13.3433L11.2133 13.3467H10.5466C10.3669 13.3467 10.1924 13.4073 10.0513 13.5187L9.98462 13.5787L9.51928 14.0433C9.13632 14.4285 8.62087 14.6531 8.07804 14.6713C7.5352 14.6895 7.00586 14.4999 6.59795 14.1413L6.49528 14.0447L6.02995 13.5793C5.90224 13.4525 5.73548 13.3724 5.55662 13.352L5.46662 13.3467H4.79995C4.25514 13.3467 3.73096 13.1383 3.3349 12.7642C2.93885 12.3901 2.70094 11.8786 2.66995 11.3347L2.66662 11.2133V10.5467C2.66656 10.3669 2.60597 10.1924 2.49462 10.0513L2.43462 9.98467L1.96995 9.51933C1.5848 9.13637 1.36023 8.62092 1.34202 8.07809C1.32381 7.53526 1.51333 7.00592 1.87195 6.598L1.96862 6.49533L2.43395 6.03C2.56082 5.90229 2.64092 5.73553 2.66128 5.55667L2.66662 5.46667V4.8L2.66995 4.67867C2.69972 4.15563 2.9209 3.66183 3.29134 3.29139C3.66178 2.92095 4.15558 2.69977 4.67862 2.67L4.79995 2.66667H5.46662C5.64636 2.66661 5.82085 2.60602 5.96195 2.49467L6.02862 2.43467L6.49395 1.97C6.69217 1.77059 6.92786 1.61234 7.18746 1.50433C7.44706 1.39633 7.72545 1.34071 8.00662 1.34067ZM10.4713 6.19533C10.3463 6.07035 10.1767 6.00014 9.99995 6.00014C9.82317 6.00014 9.65363 6.07035 9.52862 6.19533L7.33328 8.39L6.47128 7.52867L6.40862 7.47333C6.27462 7.36973 6.10621 7.32101 5.9376 7.33707C5.76898 7.35313 5.6128 7.43277 5.50078 7.55982C5.38876 7.68686 5.32929 7.85178 5.33446 8.02108C5.33963 8.19038 5.40905 8.35136 5.52862 8.47133L6.86195 9.80467L6.92462 9.86C7.05289 9.9595 7.21305 10.0088 7.37507 9.99859C7.53709 9.98841 7.68982 9.91945 7.80462 9.80467L10.4713 7.138L10.5266 7.07533C10.6261 6.94706 10.6754 6.7869 10.6652 6.62488C10.655 6.46286 10.5861 6.31013 10.4713 6.19533Z"
                                                    fill="#05DF72" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_793_3">
                                                    <rect width="16" height="16" fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <p class="text-xs text-[#a4a4a4] mb-2">@maskEmail(auth()->user()->email)</p>
                            {{-- <div class="flex items-start gap-x-1 mb-3">
                                <div class="flex-none">
                                    <p class="text-xs text-white font-bold">Referral Link:</p>
                                </div>
                                <div class="flex-1">
                                    <input id="uid" type="text" class="hidden"
                                        value="{{ 'https://yfxai.com/register?ref=' . auth()->user()->referral_code }}">
                                    <p class="text-[10px] text-[#a4a4a4]">
                                        {{ 'https://yfxai.com/register?ref=' . auth()->user()->referral_code }}</p>
                                </div>
                                <div class="flex-none text-end">
                                    <button type="button" x-on:click="$store.accountPage.copyUID()"
                                        class="py-0.5 px-2 cursor-pointer inline-flex items-center justify-center text-[10px] font-semibold rounded-md bg-[#282828] border border-[#323335] text-white focus:outline-hidden">
                                        Copy
                                    </button>
                                </div>
                            </div> --}}
                            <div class="flex items-center gap-x-2 mb-2">
                                <div class="grow">
                                    <span class="text-xs text-white font-bold">KYC: </span>
                                    @if (!$this->isKycPending && $this->kycStatus === 'Not verified')
                                        <div
                                            class="px-1.5 py-1 cursor-pointer inline-flex items-center justify-center gap-x-1 text-[10px] rounded-lg bg-[#282828] text-white">
                                            <span class="text-white font-bold">Not verified</span>
                                        </div>
                                    @endif
                                    @if ($this->isKycPending && $this->kycStatus === 'Not verified')
                                        <div
                                            class="px-1.5 py-1 cursor-pointer inline-flex items-center justify-center gap-x-1 text-[10px] rounded-lg bg-[#F59E0B] text-white">
                                            <span class="text-white font-bold">Pending Review</span>
                                        </div>
                                    @endif
                                    @if ($this->kycStatus === 'Verified')
                                        <div
                                            class="px-1.5 py-0.5 cursor-pointer inline-flex items-center border border-green-300 justify-center gap-x-1 text-[10px] rounded-lg">
                                            <span class="text-green-300 font-bold mt-0.5">Verified</span>
                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8.33366 2.5L3.75033 7.08333L1.66699 5" stroke="#7bf1a8"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                {{-- <div>
                                    <p class="text-[10px] text-white">
                                        Email verified
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="inline lucide lucide-check-icon lucide-check">
                                            <path d="M20 6 9 17l-5-5" />
                                        </svg>
                                    </p>
                                </div> --}}
                                <div class="flex-none">
                                    @if (!$this->isKycPending && $this->kycStatus === 'Not verified')
                                        <a href="{{ route('dashboard.identityverification') }}">
                                            <button type="button"
                                                class="w-full px-3 py-2 cursor-pointer inline-flex items-center justify-center gap-x-1 text-xs font-semibold rounded-lg bg-[#F59E0B] text-white focus:outline-hidden">
                                                {{ $this->isKycPending ? 'Pending Review' : 'Verify Now' }}
                                            </button>
                                        </a>
                                    @endif
                                    @if ($this->isKycPending && $this->kycStatus === 'Not verified')
                                        <button type="button"
                                            class="w-full px-3 py-2 cursor-pointer inline-flex items-center justify-center gap-x-1 text-xs font-semibold rounded-lg bg-[#F59E0B] text-white focus:outline-hidden">
                                            Pending Review
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="flex-1">
                            <a href="{{ route('dashboard.withdraw') }}">
                                <button type="button"
                                    class="w-full py-2 px-6 lg:px-10 cursor-pointer inline-flex items-center justify-center gap-x-1 text-sm font-semibold rounded-lg bg-accent text-black focus:outline-hidden">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8 2V10" stroke="black" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M11.3332 5.33333L7.99984 2L4.6665 5.33333" stroke="black"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M14 10V12.6667C14 13.0203 13.8595 13.3594 13.6095 13.6095C13.3594 13.8595 13.0203 14 12.6667 14H3.33333C2.97971 14 2.64057 13.8595 2.39052 13.6095C2.14048 13.3594 2 13.0203 2 12.6667V10"
                                            stroke="black" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                    Withdraw
                                </button>
                            </a>
                        </div>
                        <div class="flex-1">
                            <a href="{{ route('dashboard.deposit') }}">
                                <button type="button"
                                    class="w-full py-2 px-6 lg:px-10 cursor-pointer inline-flex items-center justify-center gap-x-1 text-sm font-semibold rounded-lg bg-accent text-black focus:outline-hidden">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_1669_24)">
                                            <path
                                                d="M16.5 7.5V12C16.5 12.7956 16.1839 13.5587 15.6213 14.1213C15.0587 14.6839 14.2956 15 13.5 15H4.5C3.70435 15 2.94129 14.6839 2.37868 14.1213C1.81607 13.5587 1.5 12.7956 1.5 12V7.5H16.5ZM5.2575 10.5H5.25C5.15151 10.5005 5.05408 10.5204 4.96327 10.5585C4.87247 10.5967 4.79006 10.6523 4.72077 10.7223C4.58082 10.8637 4.50276 11.0548 4.50375 11.2538C4.50424 11.3522 4.52413 11.4497 4.56228 11.5405C4.60042 11.6313 4.65608 11.7137 4.72607 11.783C4.79606 11.8523 4.87902 11.9071 4.9702 11.9443C5.06138 11.9816 5.15901 12.0005 5.2575 12C5.45641 12 5.64718 11.921 5.78783 11.7803C5.92848 11.6397 6.0075 11.4489 6.0075 11.25C6.0075 11.0511 5.92848 10.8603 5.78783 10.7197C5.64718 10.579 5.45641 10.5 5.2575 10.5ZM9.75 10.5H8.25C8.05109 10.5 7.86032 10.579 7.71967 10.7197C7.57902 10.8603 7.5 11.0511 7.5 11.25C7.5 11.4489 7.57902 11.6397 7.71967 11.7803C7.86032 11.921 8.05109 12 8.25 12H9.75C9.94891 12 10.1397 11.921 10.2803 11.7803C10.421 11.6397 10.5 11.4489 10.5 11.25C10.5 11.0511 10.421 10.8603 10.2803 10.7197C10.1397 10.579 9.94891 10.5 9.75 10.5ZM13.5 3C14.2956 3 15.0587 3.31607 15.6213 3.87868C16.1839 4.44129 16.5 5.20435 16.5 6H1.5C1.5 5.20435 1.81607 4.44129 2.37868 3.87868C2.94129 3.31607 3.70435 3 4.5 3H13.5Z"
                                                fill="black" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1669_24">
                                                <rect width="18" height="18" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    Deposit
                                </button>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-x-2 p-3 my-3 bg-dim rounded-lg border border-[#323335]">
                    <div class="grow">
                        <h2 class="text-white text-sm font-bold mb-1">Withdrawal Limits</h2>
                        <p class="text-xs text-[#a4a4a4]">Daily Withdrawal Limit:
                            @if (auth()->user()->is_kyc_verified)
                                <span>$10,000,000</span>
                            @else
                                <span>$10,000</span>
                            @endif
                        </p>
                    </div>
                    <div class="flex-none">
                        <a href="{{ route('dashboard.identityverification') }}">
                            @if ($this->kycStatus === 'Not verified')
                                <button type="button"
                                    class="w-full px-3 py-2 cursor-pointer inline-flex items-center justify-center gap-x-1 text-xs font-semibold rounded-lg bg-[#F59E0B] text-white focus:outline-hidden">
                                    {{-- <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M13.3333 8.66664C13.3333 12 11 13.6666 8.22663 14.6333C8.0814 14.6825 7.92365 14.6802 7.77996 14.6266C4.99996 13.6666 2.66663 12 2.66663 8.66664V3.99997C2.66663 3.82316 2.73686 3.65359 2.86189 3.52857C2.98691 3.40355 3.15648 3.33331 3.33329 3.33331C4.66663 3.33331 6.33329 2.53331 7.49329 1.51997C7.63453 1.39931 7.8142 1.33301 7.99996 1.33301C8.18572 1.33301 8.36539 1.39931 8.50663 1.51997C9.67329 2.53997 11.3333 3.33331 12.6666 3.33331C12.8434 3.33331 13.013 3.40355 13.138 3.52857C13.2631 3.65359 13.3333 3.82316 13.3333 3.99997V8.66664Z"
                                            fill="white" stroke="black" stroke-width="1.33333" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M6 8.00008L7.33333 9.33341L10 6.66675" stroke="#FF6900"
                                            stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg> --}}
                                    Increase Limits
                                </button>
                            @endif
                        </a>
                    </div>
                </div>


                <div class="mb-3 grid grid-cols-1 gap-1 lg:grid-cols-2 lg:gap-2 lg:mb-2">
                    <a href="{{ route('dashboard.transactions') }}">
                        <div
                            class="bg-dim w-full rounded-lg flex items-center space-x-2 p-3 mb-1 border border-[#323335] lg:mb-0">
                            <div class="flex-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-right-left-icon lucide-arrow-right-left">
                                    <path d="m16 3 4 4-4 4" />
                                    <path d="M20 7H4" />
                                    <path d="m8 21-4-4 4-4" />
                                    <path d="M4 17h16" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-sm text-white">Transactions</p>
                            </div>
                            <div class="flex-none text-end">
                                <p class="font-medium text-xs text-[#a4a4a4]">Deposits & Withdrawals</p>
                            </div>
                            <div class="flex-none text-end">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-right-icon lucide-chevron-right">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('dashboard.security.setup') }}">
                        <div
                            class="bg-dim w-full rounded-lg flex items-center space-x-2 p-3 mb-1 border border-[#323335] lg:mb-0">
                            <div class="flex-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-lock-icon lucide-lock">
                                    <rect width="18" height="11" x="3" y="11" rx="2"
                                        ry="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-sm text-white">Security</p>
                            </div>
                            <div class="flex-none text-end">
                                <p class="font-medium text-xs text-[#a4a4a4]">2FA Authenticator</p>
                            </div>
                            <div class="flex-none text-end">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-right-icon lucide-chevron-right">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('dashboard.identityverification') }}">
                        <div
                            class="bg-dim w-full rounded-lg flex items-center space-x-2 p-3 mb-1 border border-[#323335] lg:mb-0">
                            <div class="flex-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-id-card-icon lucide-id-card">
                                    <path d="M16 10h2" />
                                    <path d="M16 14h2" />
                                    <path d="M6.17 15a3 3 0 0 1 5.66 0" />
                                    <circle cx="9" cy="11" r="2" />
                                    <rect x="2" y="5" width="20" height="14" rx="2" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-sm text-white">Identity Verification</p>
                            </div>
                            <div class="flex-none text-end">
                                @if (!$this->isKycPending && $this->kycStatus === 'Not verified')
                                    <p class="text-xs font-bold text-[#a4a4a4]">Not verified</p>
                                @endif
                                @if ($this->isKycPending && $this->kycStatus === 'Not verified')
                                    <p class="text-xs font-bold text-[#F59E0B]">Pending Review</p>
                                @endif
                                @if ($this->kycStatus === 'Verified')
                                    <div class="flex items-center gap-x-1">
                                        <span class="text-xs font-bold text-[#a4a4a4]">Verified</span>
                                        <svg class="mt-0.5" width="12" height="12" viewBox="0 0 12 12"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10 3L4.5 8.5L2 6" stroke="#a4a4a4" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-none text-end">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-right-icon lucide-chevron-right">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('dashboard.referrals') }}">
                        <div
                            class="bg-dim w-full rounded-lg flex items-center space-x-2 p-3 mb-1 border border-[#323335] lg:mb-0">
                            <div class="flex-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-users-icon lucide-users">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                    <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                    <circle cx="9" cy="7" r="4" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-sm text-white">Referrals</p>
                            </div>
                            <div class="flex-none text-end">
                                <p class="font-medium text-xs text-[#a4a4a4]">Your Link & Earnings</p>
                            </div>
                            <div class="flex-none text-end">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-right-icon lucide-chevron-right">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('dashboard.connectedexchanges') }}">
                        <div
                            class="bg-dim w-full rounded-lg flex items-center space-x-2 p-3 mb-1 border border-[#323335] lg:mb-0">
                            <div class="flex-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-unplug-icon lucide-unplug">
                                    <path d="m19 5 3-3" />
                                    <path d="m2 22 3-3" />
                                    <path d="M6.3 20.3a2.4 2.4 0 0 0 3.4 0L12 18l-6-6-2.3 2.3a2.4 2.4 0 0 0 0 3.4Z" />
                                    <path d="M7.5 13.5 10 11" />
                                    <path d="M10.5 16.5 13 14" />
                                    <path d="m12 6 6 6 2.3-2.3a2.4 2.4 0 0 0 0-3.4l-2.6-2.6a2.4 2.4 0 0 0-3.4 0Z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-sm text-white">Connected Brokers</p>
                            </div>
                            <div class="flex-none -mt-0.5 text-end"><img class="inline w-8 align-middle"
                                    src="{{ asset('assets/icons/bybit.svg') }}" alt="bybit-logo"> <img
                                    class="inline align-middle" src="{{ asset('assets/icons/xtb.svg') }}"
                                    alt="xtb-logo">
                            </div>
                            <div class="flex-none text-end">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-right-icon lucide-chevron-right">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('dashboard.accountinformation') }}">
                        <div
                            class="bg-dim w-full rounded-lg flex items-center space-x-2 p-3 mb-1 border border-[#323335] lg:mb-0">
                            <div class="flex-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-user-icon lucide-user">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-sm text-white">Account Information</p>
                            </div>
                            <div class="flex-none text-end">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-right-icon lucide-chevron-right">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('dashboard.faqs') }}">
                        <div
                            class="bg-dim w-full rounded-lg flex items-center space-x-2 p-3 mb-1 border border-[#323335] lg:mb-0">
                            <div class="flex-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-message-circle-question-mark-icon lucide-message-circle-question-mark">
                                    <path
                                        d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719" />
                                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" />
                                    <path d="M12 17h.01" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-sm text-white">FAQs</p>
                            </div>
                            <div class="flex-none text-end">
                                <p class="font-medium text-xs text-[#a4a4a4]"></p>
                            </div>
                            <div class="flex-none text-end">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-right-icon lucide-chevron-right">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a x-on:click="$store.accountPage.toggleSupportModal()">
                        <div
                            class="bg-dim w-full rounded-lg flex items-center space-x-2 p-3 mb-1 border border-[#323335] lg:mb-0">
                            <div class="flex-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-message-square-icon lucide-message-square">
                                    <path
                                        d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-sm text-white">Support</p>
                            </div>
                            <div class="flex-none text-end">
                                <p class="font-medium text-xs text-[#a4a4a4]">Help Center & Live Chat</p>
                            </div>
                            <div class="flex-none text-end">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-right-icon lucide-chevron-right">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="lg:grid lg:grid-cols-2 lg:gap-4">
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <a class="cursor-pointer" onclick="this.closest('form').submit()">
                            <div
                                class="bg-dim w-full rounded-lg flex items-center space-x-2 p-3 mb-1 border border-[#323335] lg:mb-0">
                                <div class="flex-none text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="#fb2c36" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-log-out-icon lucide-log-out">
                                        <path d="m16 17 5-5-5-5" />
                                        <path d="M21 12H9" />
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-sm text-red-500">Sign Out</p>
                                </div>
                                <div class="flex-none text-end">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-chevron-right-icon lucide-chevron-right">
                                        <path d="m9 18 6-6-6-6" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </form>
                </div>
            </div>

            <div x-cloak x-transition x-show="$store.accountPage.isProfilePictureModalOpen"
                class="fixed top-0 left-0 h-svh w-full px-4 lg:px-96 pt-6 z-20">
                <div class="absolute inset-0 h-svh w-full px-4 lg:px-96 pt-6 z-20 bg-dashboard opacity-85"></div>
                <div class="relative w-full h-full flex items-center justify-center z-30">
                    <div
                        class="max-w-sm mx-auto flex flex-col bg-dashboard border border-[#26252a] rounded-2xl pointer-events-auto">
                        <div class="py-6 px-32 overflow-y-auto text-center">
                            <div class="flex justify-center mb-4">
                                <div
                                    class="relative bg-[#232323] size-16 rounded-full flex items-center justify-center lg:size-20">
                                    @if (is_null(auth()->user()->profile_image_path) && !$this->profilePicture)
                                        <svg class="absolute" xmlns="http://www.w3.org/2000/svg" width="48"
                                            height="48" viewBox="0 0 48 48" fill="none">
                                            <g clip-path="url(#clip0_49_26)">
                                                <path
                                                    d="M6 24C6 26.3638 6.46558 28.7044 7.37017 30.8883C8.27475 33.0722 9.60062 35.0565 11.2721 36.7279C12.9435 38.3994 14.9278 39.7252 17.1117 40.6298C19.2956 41.5344 21.6362 42 24 42C26.3638 42 28.7044 41.5344 30.8883 40.6298C33.0722 39.7252 35.0565 38.3994 36.7279 36.7279C38.3994 35.0565 39.7252 33.0722 40.6298 30.8883C41.5344 28.7044 42 26.3638 42 24C42 21.6362 41.5344 19.2956 40.6298 17.1117C39.7252 14.9278 38.3994 12.9435 36.7279 11.2721C35.0565 9.60062 33.0722 8.27475 30.8883 7.37017C28.7044 6.46558 26.3638 6 24 6C21.6362 6 19.2956 6.46558 17.1117 7.37017C14.9278 8.27475 12.9435 9.60062 11.2721 11.2721C9.60062 12.9435 8.27475 14.9278 7.37017 17.1117C6.46558 19.2956 6 21.6362 6 24Z"
                                                    stroke="black" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M18 20C18 21.5913 18.6321 23.1174 19.7574 24.2426C20.8826 25.3679 22.4087 26 24 26C25.5913 26 27.1174 25.3679 28.2426 24.2426C29.3679 23.1174 30 21.5913 30 20C30 18.4087 29.3679 16.8826 28.2426 15.7574C27.1174 14.6321 25.5913 14 24 14C22.4087 14 20.8826 14.6321 19.7574 15.7574C18.6321 16.8826 18 18.4087 18 20Z"
                                                    fill="white" stroke="black" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path
                                                    d="M12.3359 37.698C12.831 36.0505 13.8439 34.6064 15.2244 33.58C16.605 32.5535 18.2796 31.9995 19.9999 32H27.9999C29.7225 31.9994 31.3992 32.5548 32.7807 33.5836C34.1623 34.6123 35.1749 36.0596 35.6679 37.71"
                                                    stroke="black" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_49_26">
                                                    <rect width="48" height="48" fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    @endif
                                    @if ($this->profilePicture && !is_null(auth()->user()->profile_image_path))
                                        <img class="absolute size-16 rounded-full"
                                            src="{{ $this->profilePicture->temporaryUrl() }}" alt="">
                                    @endif
                                    @if ($this->profilePicture && is_null(auth()->user()->profile_image_path))
                                        <img class="absolute size-16 rounded-full"
                                            src="{{ $this->profilePicture->temporaryUrl() }}" alt="">
                                    @endif
                                </div>
                            </div>

                            <div class="relative mb-8">
                                <div class="flex flex-col gap-y-1">
                                    <div>
                                        <label for="file-upload"
                                            class="inline-flex items-center gap-x-1 bg-[#40FFDD] text-black text-xs p-2 rounded-lg cursor-pointer">
                                            <div class="-mt-0.5">
                                                <svg width="14" height="14" viewBox="0 0 14 14"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M8.16494 2.33337C8.3754 2.33337 8.58194 2.3903 8.76269 2.49813C8.94343 2.60596 9.09163 2.76067 9.1916 2.94587L9.4751 3.47087C9.57507 3.65608 9.72328 3.81079 9.90402 3.91862C10.0848 4.02645 10.2913 4.08338 10.5018 4.08337H11.6667C11.9761 4.08337 12.2729 4.20629 12.4916 4.42508C12.7104 4.64388 12.8334 4.94062 12.8334 5.25004V10.5C12.8334 10.8095 12.7104 11.1062 12.4916 11.325C12.2729 11.5438 11.9761 11.6667 11.6667 11.6667H2.33335C2.02393 11.6667 1.72719 11.5438 1.5084 11.325C1.2896 11.1062 1.16669 10.8095 1.16669 10.5V5.25004C1.16669 4.94062 1.2896 4.64388 1.5084 4.42508C1.72719 4.20629 2.02393 4.08337 2.33335 4.08337H3.49827C3.70852 4.08339 3.91486 4.02658 4.09548 3.91897C4.27609 3.81136 4.42428 3.65694 4.52435 3.47204L4.8096 2.94471C4.90968 2.75981 5.05786 2.60539 5.23848 2.49778C5.4191 2.39017 5.62544 2.33336 5.83569 2.33337H8.16494Z"
                                                        stroke="black" stroke-width="1.33333" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path
                                                        d="M7 9.33337C7.9665 9.33337 8.75 8.54987 8.75 7.58337C8.75 6.61688 7.9665 5.83337 7 5.83337C6.0335 5.83337 5.25 6.61688 5.25 7.58337C5.25 8.54987 6.0335 9.33337 7 9.33337Z"
                                                        stroke="black" stroke-width="1.33333" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </div>
                                            <span>Upload Image</span>
                                        </label>
                                    </div>
                                    <div wire:loading wire:target="profilePicture">
                                        <i class="fa-solid fa-circle-notch fa-spin text-gray-400"></i>
                                        <span class="text-xs text-gray-400">Uploading...</span>
                                    </div>
                                </div>

                                <input id="file-upload" type="file" wire:model.live="profilePicture"
                                    class="hidden" />

                                <div class="mt-2 text-xs text-gray-400">
                                    <span x-text="$wire.profilePicture?.name || ''"></span>
                                </div>
                            </div>

                            <div class="flex items-center justify-center gap-x-2">
                                <div>
                                    <a wire:click="saveProfilePicture()"
                                        x-on:click="$store.accountPage.toggleProfilePictureModal();">
                                        <button type="button" type="button"
                                            class="py-2 px-6 w-full text-center text-sm font-semibold rounded-lg border border-transparent bg-accent text-black cursor-pointer hover:bg-accent focus:outline-hidden focus:bg-accent disabled:opacity-50 disabled:pointer-events-none">
                                            <i wire:loading class="fa-solid fa-circle-notch fa-spin"></i>
                                            <span wire:loading.remove>Save</span>
                                        </button>
                                    </a>
                                </div>
                                <div>
                                    <button x-on:click="$store.accountPage.toggleProfilePictureModal()" type="button"
                                        class="py-2 px-4 w-full text-center text-sm font-semibold rounded-lg border border-white text-white shadow-2xs cursor-pointer focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div x-cloak x-show="$store.accountPage.isSupportModalOpen" x-transition
                class="fixed top-0 left-0 h-svh w-full bg-dashboard z-20 flex flex-col">
                <div class="flex items-center px-4 py-4 border-y border-[#26252a]">
                    <div class="flex-1">
                        <h1 class="text-white text-base font-bold">Support</h1>
                    </div>
                    <div class="flex-none">
                        <svg x-on:click="$store.accountPage.toggleSupportModal()" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-x-icon lucide-x">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </div>
                </div>
                <div class="grow">
                    <iframe frameborder="0" width="100%" height="100%"
                        src="https://tawk.to/chat/693d5de40981ca197f7a915d/1jcbrdhu4"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('accountPage', {
            isProfilePictureModalOpen: false,

            isSupportModalOpen: false,
            toggleSupportModal() {
                this.isSupportModalOpen = !this.isSupportModalOpen;
            },

            toggleProfilePictureModal() {
                this.isProfilePictureModalOpen = !this.isProfilePictureModalOpen;
            },

            toast() {
                const toastMarkup = `
                <div class="flex items-start p-4">
                    <div class="shrink-0">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info-icon lucide-info"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                        </svg>
                    </div>
                    <div class="ms-3 flex-1">
                        <p class="text-xs font-semibold text-white">Copied referral link</p>
                    </div>
                </div>
            `;
                Toastify({
                    text: toastMarkup,
                    className: "hs-toastify-on:opacity-100 opacity-0 absolute top-0 start-1/2 -translate-x-1/2 z-90 w-4/5 md:w-1/2 lg:w-1/4 transition-all duration-300 bg-dim border border-[#26252a] text-sm text-white rounded-xl shadow-lg [&>.toast-close]:hidden",
                    duration: 4000,
                    close: true,
                    escapeMarkup: false
                }).showToast();
            },

            copyUID() {
                var copyText = document.getElementById("uid");
                copyText.select();
                copyText.setSelectionRange(0, 99999); // For mobile devices
                navigator.clipboard.writeText(copyText.value);
                this.toast();
            }
        })
    })
</script>

@script
    <script>
        $wire.on('error-message', (event) => {
            const toastMarkup = `
                <div class="flex items-start p-4">
                    <div class="shrink-0">
                        <svg class="shrink-0 size-4 text-red-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-alert-icon lucide-shield-alert"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>
                    </div>
                    <div class="ms-3 flex-1">
                        <p class="text-xs font-semibold text-white">${event.message}</p>
                    </div>
                </div>
            `;

            Toastify({
                text: toastMarkup,
                className: "hs-toastify-on:opacity-100 opacity-0 absolute top-0 start-1/2 -translate-x-1/2 z-90 w-4/5 md:w-1/2 lg:w-1/4 transition-all duration-300 bg-dim border border-[#26252a] text-sm text-white rounded-xl shadow-lg [&>.toast-close]:hidden",
                duration: 4000,
                close: true,
                escapeMarkup: false
            }).showToast();
        });

        $wire.on('success-message', (event) => {
            const toastMarkup = `
                <div class="flex items-center p-4">
                    <div class="shrink-0">
                        <svg class="shrink-0 size-4 text-teal-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-big-icon lucide-circle-check-big"><path d="M21.801 10A10 10 0 1 1 17 3.335"/><path d="m9 11 3 3L22 4"/></svg>
                    </div>
                    <div class="ms-3 flex-1">
                        <p class="text-xs font-semibold text-white">${event.message}</p>
                    </div>
                </div>
            `;

            Toastify({
                text: toastMarkup,
                className: "hs-toastify-on:opacity-100 opacity-0 absolute top-0 start-1/2 -translate-x-1/2 z-90 w-4/5 md:w-1/2 lg:w-1/4 transition-all duration-300 bg-dim border border-[#26252a] text-sm text-white rounded-xl shadow-lg [&>.toast-close]:hidden",
                duration: 8000,
                close: true,
                escapeMarkup: false
            }).showToast();
        });
    </script>
@endscript
