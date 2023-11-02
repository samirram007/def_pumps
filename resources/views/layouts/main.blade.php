<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --}}
    <title>{{ env('APP_NAME') }}</title>
    <!-- plugins:css -->
    
    @include('layouts.css_js')
    @yield('style')
{{-- @vite(['resources/js/app.js']) --}}

</head>

<body class="bg-light antialiased   ">

    {{-- @dd($light) --}}
    {{-- pageload animation --}}
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label"></p>
        </div>
    </div>

    <div class="container-scroller">
        @include('layouts.partial._lang')
        <!-- partial:partials/_navbar.html -->

        @include('layouts.navbar')


        <!-- partial -->
        <div class="container-fluid page-body-wrapper">

            {{-- @include('job.layouts.themebar') --}}
            {{-- @include('job.layouts.rightbar') --}}

            @include('layouts.sidebar')
            <!-- partial -->
            <div class="main-panel" data-aos="fade-right" data-aos-delay="500" data-aos-offset="300"
                data-aos-easing="ease-in-sine">
                {{-- @include('flash-message') --}}
                {{-- <div class="bg-primary position-absolute w-100" style="height: 15rem;">
          </div> --}}
                {{-- <div class="content-wrapper mt-4" style="z-index: 1000;">
           --}}
                @yield('content')
                <div class="modal fade" id="modal-popup" data-backdrop="static" role="dialog"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">

                </div>
                <div class="modal fade" id="modal-wizard" data-backdrop="static" role="dialog"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">

                </div>

                {{-- </div> --}}
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->

                <!-- partial -->
            </div>

            <!-- main-panel ends -->
        </div>

        <!-- page-body-wrapper ends -->
    </div>

    @include('layouts.footer')
    @include('layouts.css_js_2')

<!-- This is yield script begin -->


    @stack('script')
    @yield('modal_script')

   <!-- This is yield script end -->
    {{-- @stack('scripts') --}}
    @vite('resources/js/app.js')
</body>

</html>
