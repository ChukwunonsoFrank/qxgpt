<div x-data="{ signupError: null }">
    <section class="single-page bg-dark text-white py-5">
        <div class="container py-5" style="margin-top: 5rem;">
            <div class="row">
                <div class="col-lg-6 col-12 mx-auto">
                    <div class="w-full h-full px-2">
                        <div class="flex justify-center w-full h-screen rounded items-center">
                            <div class="container-md bg-custom text-white py-5 px-4 rounded-4 shadow">
                                <h3 class="text-center fw-bold text-light" id="page-title">
                                    Register
                                </h3>

                                <div class="mt-4" x-show="signupError" x-cloak>
                                    <div class="alert alert-danger" role="alert" x-text="signupError"></div>
                                </div>

                                <form wire:submit="register" id="registerForm">
                                    <div class="row gy-2 mt-3 text-white">
                                        <div class="col-12 mb-3">
                                            <div class="form-floating">
                                                <input wire:model="name" type="text" id="name"
                                                    class="form-control" required placeholder="Full Name" autofocus>
                                                <label for="name" class="text-dark">Full Name</label>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="form-floating">
                                                <input wire:model="email" type="email" id="email"
                                                    class="form-control" required placeholder="Email">
                                                <label for="email" class="text-dark">Email</label>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="form-floating">
                                                <input wire:model="password"
                                                    x-bind:type="$store.registerPage.isPasswordVisible ? 'text' : 'password'"
                                                    id="password1" class="form-control" placeholder="Password" required>
                                                <label for="password1" class="text-dark">Password</label>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="form-floating">
                                                <input wire:model="password_confirmation"
                                                    x-bind:type="$store.registerPage.isConfirmPasswordVisible ? 'text' : 'password'"
                                                    id="password2" class="form-control" placeholder="Confirm Password"
                                                    required>
                                                <label for="password2" class="text-dark">Confirm Password</label>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="form-floating">
                                                <input wire:model="ref_code" type="text" id="ref_code"
                                                    class="form-control" placeholder="Referral Code (optional)">
                                                <label for="ref_code" class="text-dark">Referral Code
                                                    (optional)</label>
                                            </div>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <div class="d-flex align-items-start">
                                                <input wire:model="termsAndPrivacyPolicyAccepted" type="checkbox"
                                                    class="form-check-input me-2" id="hs-default-checkbox">
                                                <label for="hs-default-checkbox" style="font-size: 13px;">I confirm
                                                    that I am 18 years old or older and accept the <a
                                                        class="text-primary fw-bold" href="/terms">Terms &
                                                        Conditions</a> and <a class="text-primary fw-bold"
                                                        href="/privacy">Privacy Policy</a></label>
                                            </div>
                                        </div>

                                        <div class="col-12" style="overflow: hidden;">
                                            <div wire:ignore class="g-recaptcha mt-4"
                                                data-sitekey="{{ config('services.recaptcha.key') }}"
                                                data-callback="onRecaptchaSuccess"></div>
                                        </div>

                                        <div class="col-12 py-3">
                                            <button type="submit" id="registerBtn"
                                                class="btn btn-primary text-white py-3 fw-bold"
                                                style="width: 100%;">Register</button>
                                        </div>
                                        <div class="d-flex justify-content-center text-light fw-semibold my-4">
                                            <div class="text-center">
                                                <span class="text-light" style="font-size: 13px;">Already have
                                                    account?
                                                    <a href="{{ route('login') }}"
                                                        class="text-underline text-primary">Login</a></span>
                                            </div>
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
        Alpine.store('registerPage', {
            isPasswordVisible: false,

            isConfirmPasswordVisible: false,

            togglePassword() {
                this.isPasswordVisible = !this.isPasswordVisible;
            },

            toggleConfirmPassword() {
                this.isConfirmPasswordVisible = !this.isConfirmPasswordVisible;
            },
        })
    })
</script>

@script
    <script>
        $wire.on('signup-error', (event) => {
            Alpine.$data($wire.el).signupError = event.message;
        });
    </script>
@endscript
