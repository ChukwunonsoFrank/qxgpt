<div x-data>
    <section style="padding-top: 0 !important;"
        class="elementor-section elementor-top-section elementor-element elementor-element-a126101 tl-section-padding  elementor-section-boxed elementor-section-height-default elementor-section-height-default"
        data-id="a126101" data-element_type="section" id="contact"
        data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
        <div class="px-3 md:px-48 lg:px-[32rem]">
            <div class="mb-6">
                <div class="elementor-widget-wrap elementor-element-populated" style="padding-top: 8rem;">
                    <div class="elementor-element elementor-element-f3b0803 elementor-widget elementor-widget-heading"
                        data-id="f3b0803" data-element_type="widget" data-widget_type="heading.default"
                        style="margin-bottom: 1rem !important;">
                        <div class="elementor-widget-container" style="text-align: center;">
                            <a>
                                <img class="w-32 text-center inline"
                                    src="{{ asset('wp-content/uploads/2023/05/yfxai-logo.png') }}" alt="Logo" />
                            </a>
                        </div>
                    </div>
                    <div class="elementor-element elementor-element-f3b0803 elementor-widget elementor-widget-heading"
                        data-id="f3b0803" data-element_type="widget" data-widget_type="heading.default">
                        <div class="elementor-widget-container" style="text-align: center;">
                            <h5 class="elementor-heading-title elementor-size-default"
                                style="margin-bottom: 0 !important; margin-top: 0 !important; font-weight: 500;">Login
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="elementor-widget-wrap elementor-element-populated">
                    <div class="elementor-element elementor-element-fb8ad16 elementor-widget elementor-widget-html">
                        <div class="elementor-widget-container">
                            <!-- Session status -->
                            <x-auth-session-status class="text-center" :status="session('status')" />

                            <form wire:submit="login" class="flex flex-col mt-2 gap-y-4">
                                <!-- Email Address -->
                                <input wire:model="email" type="email"
                                    class="py-6 h-14 px-4 block w-full border font-medium text-gray-600 border-gray-200 rounded-sm text-sm disabled:opacity-50 disabled:pointer-events-none"
                                    style="background-color: #161616;" autocomplete="email" required
                                    placeholder="Email">

                                <!-- Password -->
                                <div class="w-full space-y-3">
                                    <div>
                                        <div class="relative">
                                            <input wire:model="password"
                                                x-bind:type="$store.loginPage.isPasswordVisible ? 'text' : 'password'"
                                                id="hs-trailing-icon" name="hs-trailing-icon"
                                                class="py-6 h-14 px-4 block w-full border font-medium text-gray-600 border-gray-200 rounded-sm text-sm disabled:opacity-50 disabled:pointer-events-none"
                                                style="background-color: #161616;" autocomplete="current-password"
                                                placeholder="Password">
                                            <div x-on:click="$store.loginPage.togglePassword()"
                                                class="absolute inset-y-0 end-0 flex items-center z-20 pe-4">
                                                <template x-if="!$store.loginPage.isPasswordVisible">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-eye-closed-icon lucide-eye-closed">
                                                        <path d="m15 18-.722-3.25" />
                                                        <path d="M2 8a10.645 10.645 0 0 0 20 0" />
                                                        <path d="m20 15-1.726-2.05" />
                                                        <path d="m4 15 1.726-2.05" />
                                                        <path d="m9 18 .722-3.25" />
                                                    </svg>
                                                </template>
                                                <template x-if="$store.loginPage.isPasswordVisible">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-eye-icon lucide-eye">
                                                        <path
                                                            d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                                        <circle cx="12" cy="12" r="3" />
                                                    </svg>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-full">
                                    <flux:button variant="primary" type="submit"
                                        class="w-full! h-12! mt-4! rounded-md! p-2! bg-accent! text-black!">
                                        {{ __('Log In') }}</flux:button>
                                </div>
                            </form>

                            @if (Route::has('password.request'))
                                <div class="space-x-1 rtl:space-x-reverse mt-6 text-center text-sm font-medium">
                                    <flux:link class="text-accent" :href="route('password.request')">
                                        {{ __('Forgot your password?') }}</flux:link>
                                </div>
                            @endif

                            @if (Route::has('register'))
                                <div
                                    class="space-x-1 rtl:space-x-reverse mt-4 text-center text-sm text-zinc-500 font-medium mb-3">
                                    {{ __('Don\'t have an account?') }}
                                    <flux:link class="text-accent" :href="route('appregister')">{{ __('Sign Up') }}
                                    </flux:link>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    let lastToast = null;

    function toast(message) {
        if (lastToast) {
            lastToast.hideToast();
        }

        const copiedToastMarkup = `
            <div class="flex items-center p-4">
                <div class="shrink-0">
                    <svg class="shrink-0 size-4 text-red-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-alert-icon lucide-shield-alert"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>
                </div>
                <div class="ms-3 flex-1">
                    <p class="text-xs font-semibold text-white" style="margin-bottom: 0 !important;">${message}</p>
                </div>
            </div>
        `;

        lastToast = Toastify({
            text: copiedToastMarkup,
            className: "hs-toastify-on:opacity-100 opacity-0 absolute top-0 start-1/2 -translate-x-1/2 z-90 w-4/5 md:w-1/2 lg:w-1/4 transition-all duration-300 bg-dim border border-[#26252a] text-sm text-white rounded-xl shadow-lg [&>.toast-close]:hidden",
            duration: 4000,
            close: false,
            escapeMarkup: false
        });

        lastToast.showToast();
    }

    document.addEventListener('alpine:init', () => {
        Alpine.store('loginPage', {
            isPasswordVisible: false,

            togglePassword() {
                this.isPasswordVisible = !this.isPasswordVisible;
            }
        })
    })
</script>

@script
    <script>
        $wire.on('login-error', (event) => {
            toast(event.message)
        });
    </script>
@endscript
