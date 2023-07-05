<link rel="stylesheet" href="{{ asset('theme/vendors/feather/feather.css') }}">
<link rel="stylesheet" href="{{ asset('theme/vendors/ti-icons/css/themify-icons.css') }}">
<link rel="stylesheet" href="{{ asset('theme/vendors/css/vendor.bundle.base.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('theme/vendors/mdi/css/materialdesignicons.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('theme/vendors/flag-icon-css/css/flag-icon.min.css') }}">

<link rel="stylesheet" href="{{ asset('theme/vendors/select2/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('theme/js/select.dataTables.min.css') }}">

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
<link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<!-- endinject -->
<!-- Plugin css for this page -->
<link rel="stylesheet" href="{{ asset('theme/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('theme/vendors/ti-icons/css/themify-icons.css') }}">
<link rel="stylesheet" href="{{ asset('theme/vendors/select2/select2.min.css') }}">
{{-- <link rel="stylesheet" type="text/css" href="{{asset('theme/js/select.dataTables.min.css')}}">  --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.9/css/fixedHeader.dataTables.min.css"> --}}
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">


<!-- End plugin css for this page -->
<!-- inject:css -->
<link rel="stylesheet" href="{{ asset('theme/css/vertical-layout-light/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/theme.css') }}">
<!-- endinject -->
<!-- fonts-->
<link rel="stylesheet"
    href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.1.1/css/all.min.css') }}">
<!-- custom-->
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" />
@vite(['resources/css/app.css', 'resources/js/app.js'])
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
<link rel="stylesheet" type="text/css" href="{{ asset('datetime/daterangepicker.css') }}" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script> --}}
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script> --}}
<script type="text/javascript" src="{{ asset('datetime/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('datetime/daterangepicker.js') }}" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
<script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />


<!-- endinject -->
<link rel="stylesheet" href="{{asset('landing/dist/css/switch.css')}}">
{{-- <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"  ></script> --}}



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="shortcut icon" href="{{ asset('theme/images/logo.png') }}" />
<style>
    .antialiased {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale
    }

    .navbar {
        box-shadow: none !important;
        height: 5rem;
    }

    .navbar .navbar-brand-wrapper,
    .navbar .navbar-menu-wrapper {
        background: rgba(255, 255, 255, 0) !important;
    }

    .card {
        background: rgba(0, 0, 0, 0);
    }

    .btn {
        padding: 10px 25px !important;
    }

    .content-wrapper {
        background: rgba(255, 255, 255, 0) !important;
    }
</style>
<link rel="stylesheet" href="{{ asset('css/bn/bn-style.css') }}">

{{-- <script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("elements", "1", {
    packages: "inputtools"
    });
  </script>
  <script>
    function onLoad() {
      var inputFields = document.querySelectorAll('input[type=text], textarea');
      inputFields.forEach(function(inputField) {
        inputField.addEventListener('focus', function() {
          google.language.translate.setLanguagePair('', 'hi');
        });
      });
    }
    google.setOnLoadCallback(onLoad);
  </script> --}}
  <style>
    .preloader{
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(37, 35, 35, 0.664);
        z-index: 99;
    }
    .preloader .loader{
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%,-50%);
        font-size: 10px;
    }
    .preloader .loader .loader__figure{
        display: inline-block;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #f00;
        animation: loader 0.5s infinite ease-in-out;
    }
    @keyframes loader{
        0%{
            transform: scale(0);
            background: rgba(50, 59, 73, 0.678);
        }
        55%{
            transform: scale(3);
            background: rgba(55, 98, 134, 0.5);
        }

        100%{
            transform: scale(0);
            background: rgba(219, 211, 216, 0.171);
            /* opacity: 0; */
        }
    }
    @keyframes loader2{
        0%{
            transform: scale(0);
            background: #f00;
        }
        25%{
            transform: scale(3);
            background: rgb(29, 125, 204);
        }
        50%{
            transform: scale(0);
            background: #0f0;
        }
        75%{
            transform: scale(3);
            background: rgb(6, 131, 104);
        }
        100%{
            transform: scale(0);
            background: rgb(255, 91, 200);
            /* opacity: 0; */
        }
    }
  </style>
