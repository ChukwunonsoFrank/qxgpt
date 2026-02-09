<div x-data="{ loginError: null }">
    <section class="single-page bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12 mx-auto">
                    <div class="w-full h-full px-2">
                        <div class="flex justify-center w-full h-screen rounded items-center">
                            <div class="container-md bg-custom text-white py-5 rounded-4 shadow">
                                <h3 class="text-center fw-bold text-light" id="page-title">
                                    Login
                                </h3>

                                <div class="px-4 mt-4" x-show="loginError" x-cloak>
                                    <div class="alert alert-danger" role="alert" x-text="loginError"></div>
                                </div>

                                <form wire:submit="login" class="px-4 mt-4" id="loginForm">
                                    <div class="mb-3">
                                        <div class="form-floating">
                                            <input wire:model="email" type="email" id="email" placeholder="Email"
                                                class="form-control" required>
                                            <label for="email" class="text-dark">Email</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-floating">
                                            <input wire:model="password"
                                                x-bind:type="$store.loginPage.isPasswordVisible ? 'text' : 'password'"
                                                id="password" placeholder="Password" class="form-control" required>
                                            <label for="password" class="text-dark">Password</label>
                                        </div>
                                    </div>

                                    <div class="d-flex text-light fw-semibold my-4">
                                        <div class="text-center">
                                            <span style="font-size: 13px;"><a class="text-underline text-primary"
                                                    href="{{ route('password.request') }}">Forgot password?</a></span>
                                        </div>
                                    </div>

                                    <div class="mb-3" style="overflow: hidden;">
                                        <div wire:ignore class="g-recaptcha mt-4"
                                            style="transform: scale(0.9); transform-origin: 0 0;"
                                            data-sitekey="{{ config('services.recaptcha.key') }}"
                                            data-callback="onRecaptchaSuccess"></div>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" id="loginBtn"
                                            class="btn btn-primary text-white py-3 fw-bold">Login</button>
                                    </div>

                                    <div class="d-flex justify-content-center text-light fw-semibold my-4">
                                        <div class="text-center">
                                            <span class="text-light" style="font-size: 13px;">Don't have account? <a
                                                    href="{{ route('register') }}"
                                                    class="text-underline text-primary">Register</a></span>
                                        </div>
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

<script>
    function onRecaptchaSuccess(token) {
        @this.set('gRecaptchaResponse', token);
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
            Alpine.$data($wire.el).loginError = event.message;
        });
    </script>
@endscript
