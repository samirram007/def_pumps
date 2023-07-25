<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('landing/dist/css/style.css') }}">
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>

</head>

<body class="is-boxed has-animations ">

    <div class="body-wrap boxed-container">
        <header class="site-header">
            <div class="container">
                <div class="site-header-inner">
                    <div class="brand header-brand">
                        <h1 class="m-0">
                            <a href="#">
                                <img class="header-logo-image asset-light"
                                    src="{{ asset('landing/dist/images/logo.png') }}" alt="Logo">
                                <img class="header-logo-image asset-dark"
                                    src="{{ asset('landing/dist/images/logo-white.png') }}" alt="Logo">
                            </a>
                        </h1>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <section class="hero">
                <div class="container">
                    <div class="hero-inner">
                        <div class="hero-copy">
                            {{-- {{ env('APP_DEBUG') ? (Session::has('_refreshtoken') ? Session::get('_refreshtoken') : 'expire') : '' }} --}}
                            <h1 class="hero-title mt-0">Welcome To<br><span>{{ ENV('APP_NAME') }}</span> </h1>
                            <p class="hero-paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam
                                consectetur in sem in feugiat. Mauris a sapien sed felis eleifend tincidunt. Integer
                                quis metus est. Phasellus at vulputate sapien.</p>
                            <div class="hero-cta">
                                <a class="button button-primary" href="{{ route('login') }}">Enter</a>
                                <div class="lights-toggle">
                                    <input id="lights-toggle" type="checkbox" name="lights-toggle" class="switch"
                                        checked="checked">
                                    <label for="lights-toggle" class="text-xs"><span>Turn me <span
                                                class="label-text">dark</span></span></label>
                                </div>
                            </div>
                        </div>
                        <div class="hero-media">
                            <div class="header-illustration">
                                <img class="header-illustration-image asset-light"
                                    src="{{ asset('landing/dist/images/header-illustration-light.svg') }}"
                                    alt="Header illustration">
                                <img class="header-illustration-image asset-dark"
                                    src="{{ asset('landing/dist/images/header-illustration-dark.svg') }}"
                                    alt="Header illustration">
                            </div>
                            <div class="hero-media-illustration">
                                <img class="hero-media-illustration-image asset-light"
                                    src="{{ asset('landing/dist/images/hero-media-illustration-light.svg') }}"
                                    alt="Hero media illustration">
                                <img class="hero-media-illustration-image asset-dark"
                                    src="{{ asset('landing/dist/images/hero-media-illustration-dark.svg') }}"
                                    alt="Hero media illustration">
                            </div>
                            <div class="hero-media-container">
                                <img class="hero-media-image asset-light"
                                    src="{{ asset('landing/dist/images/hero-media-light.png') }}" alt="Hero media">
                                <img class="hero-media-image asset-dark"
                                    src="{{ asset('landing/dist/images/hero-media-dark.png') }}" alt="Hero media">
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="features section">
                <div class="container">
                    <div class="features-inner section-inner has-bottom-divider">
                        <div class="features-header text-center">
                            <div class="container-sm">
                                <h2 class="section-title mt-0">The Product</h2>
                                <p class="section-paragraph">Lorem ipsum is common placeholder text used to demonstrate
                                    the graphic elements of a document or visual presentation.</p>
                                <div class="features-image">
                                    <img class="features-illustration asset-dark"
                                        src="{{ asset('landing/dist/images/features-illustration-dark.svg') }}"
                                        alt="Feature illustration">
                                    <img class="features-box asset-dark"
                                        src="{{ asset('landing/dist/images/features-box-dark.svg') }}"
                                        alt="Feature box">
                                    <img class="features-illustration asset-dark"
                                        src="{{ asset('landing/dist/images/features-illustration-top-dark.png') }}"
                                        alt="Feature illustration top">
                                    <img class="features-illustration asset-light"
                                        src="{{ asset('landing/dist/images/features-illustration-light.svg') }}"
                                        alt="Feature illustration">
                                    <img class="features-box asset-light"
                                        src="{{ asset('landing/dist/images/features-box-light.svg') }}"
                                        alt="Feature box">
                                    <img class="features-illustration asset-light"
                                        src="{{ asset('landing/dist/images/features-illustration-top-light.png') }}"
                                        alt="Feature illustration top">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="cta section">
                <div class="container-sm">
                    <div class="cta-inner section-inner">
                        <div class="cta-header text-center">
                            <h2 class="section-title mt-0">Get it </h2>
                            <p class="section-paragraph">Lorem ipsum is common placeholder text used to demonstrate the
                                graphic elements of a document or visual presentation.</p>
                            <div class="cta-cta">
                                <a class="button button-primary" href="{{ route('login') }}">Enter</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="site-footer has-top-divider">
            <div class="container">
                <div class="site-footer-inner">
                    <div class="footer-copyright">&copy; {{ date('Y') }} {{ ENV('APP_NAME') }}, all rights
                        reserved</div>
                </div>
            </div>
        </footer>
    </div>

    <script src="{{ asset('landing/dist/js/main.min.js') }}"></script>
    <script src="{{ asset('landing/src/js/main.js') }}"></script>
</body>

</html>
