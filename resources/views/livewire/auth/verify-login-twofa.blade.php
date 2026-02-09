<div x-data="{ loginError: null, codeResent: null }">
    <section class="single-page bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12 mx-auto">
                    <div class="w-full h-full px-2">
                        <div class="flex justify-center w-full h-screen rounded items-center">
                            <div class="container-md bg-custom text-white py-5 rounded-4 shadow">
                                <h3 class="text-center fw-bold text-light" id="page-title">
                                    Enter the 6-digit authentication code generated on the app
                                </h3>

                                <div class="px-4 mt-4" x-show="loginError" x-cloak>
                                    <div class="alert alert-danger" role="alert" x-text="loginError"></div>
                                </div>

                                <div class="px-4 mt-4">
                                    <div class="mb-3">
                                        <input wire:model="code" type="text" class="form-control py-3" required
                                            placeholder="Enter code">
                                    </div>

                                    <div class="d-grid">
                                        <flux:button wire:click="verify2fa()" variant="primary"
                                            class="w-full! h-12! rounded-md! p-2! bg-accent! text-black!">
                                            {{ __('Log In') }}</flux:button>
                                    </div>
                                </div>
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
            data.codeResent = null;
            data.loginError = event.message;
        });
    </script>
@endscript
