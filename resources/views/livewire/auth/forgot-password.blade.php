<div x-data="{ loginError: null }">
    <section class="single-page bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12 mx-auto">
                    <div class="w-full h-full px-2">
                        <div class="flex justify-center w-full h-screen rounded items-center">
                            <div class="container-md bg-custom text-white py-5 rounded-4 shadow">
                                <h4 class="text-center fw-bold text-light" id="page-title">
                                    Enter your email to receive a password reset link.
                                </h4>

                                <x-auth-session-status class="text-center px-4 mt-4" :status="session('status')" />

                                <div class="px-4 mt-4" x-show="loginError" x-cloak>
                                    <div class="alert alert-danger" role="alert" x-text="loginError"></div>
                                </div>

                                <form wire:submit="sendPasswordResetLink" class="mt-4">
                                    <div class="mb-3">
                                        <input wire:model="email" type="email" class="form-control py-3" required
                                            placeholder="Email">
                                    </div>

                                    <div class="d-grid">
                                        <flux:button variant="primary" type="submit"
                                            class="w-full! h-12! rounded-md! p-2! bg-accent! border-none! text-white!">
                                            {{ __('Email Password Reset Link') }}</flux:button>
                                    </div>

                                    <div class="text-center mt-4">
                                        {{ __('Or, return to') }}
                                        <flux:link class="text-accent!" :href="route('login')">{{ __('log in') }}
                                        </flux:link>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@script
    <script>
        $wire.on('login-error', (event) => {
            const data = Alpine.$data($wire.el);
            data.loginError = event.message;
        });
    </script>
@endscript
