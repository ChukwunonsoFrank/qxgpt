<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qxgpt - AI Trading bot</title>

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">

    <style>
        * {
            font-family: "Inter", serif;
        }

        .btn-disabled {
            background: #2c917e;
            border-radius: 0.375rem;
            border: none;
            cursor: not-allowed;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('homeassets/css/main.css') }}">

    <!--Bootstrap icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <script async src="https://www.google.com/recaptcha/api.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    @vite('resources/js/app.js')

</head>

<body>
    <header class="fixed-top">
        <nav class="navbar navbar-expand-lg bg-custom py-2">
            <div class="container">
                <a class="navbar-brand d-flex flex-row align-items-center gap-2 justify-content-center" href="/">
                    <img src="{{ asset('homeassets/img/qxgpt.svg') }}" alt="Logo" width="40"
                        class="d-inline-block align-text-top">
                    <h3 class="text-white fs-5 pb-0 mb-0 px-1 d-none d-sm-none d-lg-block"
                        style="letter-spacing: 1px!important;"><b>Qxgpt</b> <span class="text-success"
                            style="color:#40ffdd!important;"><b>BOT</b></span></h3>

                </a>

                {{-- mobile --}}
                <a href="{{ route('register') }}"
                    class="btn btn-primary btn-lg w-50 text-white d-flex align-items-center justify-content-center d-lg-none d-sm-block float-end fw-bold text-uppercase"
                    style="font-size: 13px;" type="button">Start Trading
                </a>
                <div class="gtranslate_wrapper d-lg-none d-sm-block"></div>
                <div class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="bi bi-list text-white fs-1"></i>
                </div>
                <div class="collapse navbar-collapse justify-content-start justify-content-lg-center d-hidden d-lg-block"
                    id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item animated-border">
                            <a class="nav-link active" aria-current="page" href="/">Home</a>
                        </li>
                        <li class="nav-item  animated-border">
                            <a class="nav-link" href="/#features">Features</a>
                        </li>
                        <li class="nav-item  animated-border">
                            <a class="nav-link" href="/#faq">FAQ</a>
                        </li>
                        <li class="nav-item  animated-border">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item  animated-border">
                            <a class="nav-link" href="{{ route('register') }}">Sign up</a>
                        </li>
                    </ul>
                    <!-- <div class="header-buttons d-flex flex-row gap-3 d-lg-none d-sm-block justify-content-center">
                        <a class="btn btn-outline-success text-white"href="/signup">Login</a>
                        <a class="btn btn-success" href="/signup">Get started</a>
                    </div> -->
                </div>
                {{-- mobile --}}
                <!-- <div class="gtranslate_wrapper"></div> -->
                <div class="gtranslate_wrapper d-none d-sm-none d-lg-block pe-3"></div>
                <div class="header-buttons d-flex flex-row gap-3 d-none d-sm-none d-lg-block justify-content-center">

                    <!-- <a class="btn btn-outline-success text-white"href="/signup">Login</a> -->
                    <a class="btn btn-lg btn-primary fw-bold text-uppercase" href="{{ route('register') }}"
                        type="button" style="font-size: 13px;">Start trading</a>
                </div>
            </div>
        </nav>
    </header>

    {{ $slot }}

    <footer class="bg-custom-dark py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <a class="navbar-brand d-flex flex-row align-items-center gap-2 justify-content-start"
                        href="#">
                        <img src="{{ asset('homeassets/img/qxgpt.svg') }}" alt="Logo" width="40"
                            class="d-inline-block align-text-top">
                        <h3 class="text-white fs-5 pb-0 mb-0 px-1 d-none d-sm-none d-lg-block"
                            style="letter-spacing: 1px!important;"><b>Qxgpt</b> <span class="text-success"
                                style="color:#40ffdd!important;"><b>BOT</b></span></h3>

                    </a>
                    <p class="py-3" style="font-size: 12px;">Qxgpt bot is suitable for both newbie traders and
                        experienced traders, you don’t need to
                        have any technical knowledge in cryptocurrency or forex trading to earn from Qxgpt. Anyone can
                        earn
                        from Qxgpt.</p>
                    <div class="d-flex flex-row gap-4 text-white">
                        <a style="font-size: 12px;" class="text-decoration-none text-white" aria-current="page"
                            href="/service">Service Agreement</a>
                        <a style="font-size: 12px;" class="text-decoration-none text-white" aria-current="page"
                            href="/privacy">Privacy Policy</a>
                        <a style="font-size: 12px;" class="text-decoration-none text-white" aria-current="page"
                            href="/terms">Terms of use</a>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="d-flex flex-row gap-2 justify-content-start py-5">
                        <div>
                            <div class="d-flex flex-row justify-content-center gap-2">
                                <i class="bi bi-check-circle text-primary fs-3"></i>
                                <div class="d-flex flex-column">
                                    <h6 style="font-size: 12px;">FREE ACCOUNT</h5>
                                        <p style="font-size: 12px;" class="text-secondary">NO CREDIT CARD REQUIRED</p>
                                </div>
                            </div>
                            <a class="btn btn-lg btn-primary fw-bold w-100 text-uppercase mt-4"
                                style="font-size: 13px;" href="#" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasRight_deposit" id="login-btn02"
                                aria-controls="offcanvasRight">Start
                                Trading</a>
                        </div>

                        <div>
                            <div class="d-flex flex-row justify-content-center gap-2">
                                <i class="bi bi-shield-check text-primary fs-3"></i>
                                <div class="d-flex flex-column">
                                    <h6 style="font-size: 12px;">SAFE AND SECURE</h5>
                                        <p style="font-size: 12px;" class="text-secondary">
                                            ONLINE PAYMENT</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 style="font-size: 13px;">Get the app</h5>
                    <div class="d-flex flex-row gap-3 justify-content-start py-1">
                        <a class="btn btn-outline-light bg-black btn-lg text-white fw-bold d-flex flex-column justify-content-center"
                            href="/Qxgptapp.apk">
                            <img src="{{ asset('homeassets/img/google.svg') }}" width="100%" alt="">
                        </a>
                        <a class="btn btn-outline-light bg-black btn-lg text-white fw-bold d-flex flex-column justify-content-center"
                            href="#">
                            <img src="{{ asset('homeassets/img/apple.svg') }}" width="100%" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-12 mt-4">
                    <p class="mb-4" style="font-size: 12px;"><i class="bi bi-geo-alt-fill"></i> 127, Grinzinger
                        Street, 1130 Vienna, Austria.</p>
                    <p style="font-size: 12px;">Copyright © 2025 Qxgpt, Inc.</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        const togglePassword1 = document.querySelector('#togglePassword1');
        const password1 = document.querySelector('#password1');
        togglePassword1.addEventListener('click', () => {
            // Toggle the type attribute using
            // getAttribure() method
            const type = password1
                .getAttribute('type') === 'password' ?
                'text' : 'password';
            password1.setAttribute('type', type);
            // Toggle the eye and bi-eye icon
            this.classList.toggle('bi-eye-fill');
        });

        const togglePassword2 = document.querySelector('#togglePassword2');
        const password2 = document.querySelector('#password2');
        togglePassword2.addEventListener('click', () => {
            // Toggle the type attribute using
            // getAttribure() method
            const type = password2
                .getAttribute('type') === 'password' ?
                'text' : 'password';
            password2.setAttribute('type', type);
            // Toggle the eye and bi-eye icon
            this.classList.toggle('bi-eye-fill');
        });
    </script>

    <!-- <div class="gtranslate_wrapper"></div>
    <script>
        window.gtranslateSettings = {
            "default_language": "en",
            "wrapper_selector": ".gtranslate_wrapper"
        }
    </script>
    <script src="https://cdn.gtranslate.net/widgets/latest/dwf.js" defer></script> -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        $("[id^=login-btn]").each(function() {
            $(this).click(function() {
                let stateObj = {
                    id: "100"
                };

                window.history.replaceState(stateObj, "Page", "{{ route('login') }}");
            });
        });

        $("[id^=register-btn]").each(function() {
            $(this).click(function() {
                let stateObj = {
                    id: "100"
                };

                window.history.replaceState(stateObj, "Page", "{{ route('register') }}");
            });
        });

        $(document).ready(function() {
            $('.gt_switcher-popup').find('span').hide();
        })
    </script>


    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 3,
            spaceBetween: 20,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                "@0.00": {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                "@0.75": {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                "@1.00": {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                "@1.50": {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
            },
        });
    </script>

    <script>
        window.gtranslateSettings = {
            "default_language": "en",
            "detect_browser_language": true,
            "wrapper_selector": ".gtranslate_wrapper",
            "flag_size": 24,
            "flag_style": "3d"
        }
    </script>
    <script src="https://cdn.gtranslate.net/widgets/latest/popup.js" defer></script>
    @yield('footer')

    <script src="//code.jivosite.com/widget/16gjtRWVEp" async></script>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const loginButton = document.getElementById('loginBtn');

            // Disable button immediately on submit
            loginButton.disabled = true;
            loginButton.classList.remove('btn-primary', 'btn', 'text-white');
            loginButton.classList.add('btn-disabled', 'text-black');
        });

        // Check for errors after page load
        document.addEventListener('DOMContentLoaded', function() {
            const loginButton = document.getElementById('loginBtn');

            // Check if there are any errors (Laravel adds .errors to the session)
            @if ($errors->any())
                loginButton.disabled = false;
                loginButton.classList.remove('btn-disabled', 'text-black');
                loginButton.classList.add('btn-primary', 'btn', 'text-white');
            @endif
        });
    </script>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const registerButton = document.getElementById('registerBtn');

            // Disable button immediately on submit
            registerButton.disabled = true;
            registerButton.classList.remove('btn-primary', 'btn', 'text-white');
            registerButton.classList.add('btn-disabled', 'text-black');
        });

        // Check for errors after page load
        document.addEventListener('DOMContentLoaded', function() {
            const registerButton = document.getElementById('registerBtn');

            // Check if there are any errors (Laravel adds .errors to the session)
            @if ($errors->any())
                registerButton.disabled = false;
                registerButton.classList.remove('btn-disabled', 'text-black');
                registerButton.classList.add('btn-primary', 'btn', 'text-white');
            @endif
        });
    </script>
</body>

</html>
