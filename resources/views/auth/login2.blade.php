<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ env('APP_NAME')}}</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('theme/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    {{-- bootstrap link --}}

    <link rel="stylesheet" href="{{ asset('theme/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/js/select.dataTables.min.css') }}">

    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('theme/css/vertical-layout-light/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <!-- endinject -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <link rel="shortcut icon" href="{{ asset('theme/images/logo.png') }}" />
    <link rel="stylesheet" href="{{asset('css/welcome.css')}}">
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.sitekey') }}"></script>
    <style>
        .navbar {
            box-shadow: none !important;
            height: 5rem;
        }

        .navbar .navbar-brand-wrapper,
        .navbar .navbar-menu-wrapper {
            background: rgba(255, 255, 255, 0) !important;
        }

        .card {
            background: rgba(158, 45, 45, 0);
        }

        .btn {
            padding: 10px 25px !important;
        }

        .content-wrapper {
            background: rgba(255, 255, 255, 0) !important;
        }
    </style>
</head>

<body class="bg-light"> 
    <div class="container-scroller">

        <!-- partial:partials/_navbar.html -->

        {{-- @include('layouts.navbar') --}}

        <!-- partial -->
        <div class="container-fluid ">

            {{-- @include('job.layouts.themebar') --}}
            {{-- @include('job.layouts.rightbar') --}}

            {{-- @include('layouts.sidebar') --}}
            <!-- partial -->
            <div class="w-100 bg-light" style="height: 100vh;" data-aos="fade-right" data-aos-delay="500"
                data-aos-offset="300" data-aos-easing="ease-in-sine">
                {{-- @include('flash-message') --}}
                <div class="bg-backdrop h-100  d-flex align-items-center justify-content-center"
                    style="width: 100%; overflow:hidden;">

                    <div class="w-100">
                        <div class="row ">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="card bg-white">
                                    <div
                                        class="card-header bg-maroon shadow-primary border-radius-lg p-3 mt-n5  toastsDefaultMaroon">
                                        <h4 class="my-auto ">Welcome, <small>Please sign in to your account.</small>
                                        </h4>
                                        <a href="{{ route('welcome') }}" type="button" class="close text-light "
                                            style="position: absolute; top:0; right:0; margin:0.7rem">
                                            <span aria-hidden="true">&times;</span>
                                        </a>
                                    </div>
                                    <!-- Session Status -->
                                    <x-auth-session-status class="mb-4" :status="session('status')" />

                                    <!-- Validation Errors -->
                                    {{-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> --}}

                                    <div class=" card-body  mx-auto p-4 w-100 ">
                                        @if (Session::has('message'))
                                            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">
                                                {{ Session::get('message') }}</p>
                                        @endif
                                        @if (Session::has('success'))
                                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                                        @endif
                                        @if (Session::has('fail'))
                                            <div class="alert alert-danger">{{ Session::get('fail') }}</div>
                                        @endif
                                        <form method="POST" action="{{ route('signin') }}">
                                            @csrf
                                            <input type="hidden" name="recaptcha" id="recaptcha">
                                            <div class="form-group">
                                                <label for="userName" class="text-primary">User Name</label>
                                                <input id="userName" type="text"
                                                    class="form-control @error('userName') is-invalid @enderror"
                                                    name="userName" value="{{ old('userName') }}" required
                                                    autocomplete="userName" autofocus>
                                                @error('userName')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="password" class="text-primary">Password</label>
                                                <input id="password" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" required autocomplete="current-password">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="d-flex items-center justify-content-end mt-4">
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('Log in') }}

                                                </button>



                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- main-panel ends -->
        </div>

        <!-- page-body-wrapper ends -->
    </div>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('{{ config('services.recaptcha.sitekey') }}', {
                action: 'contact'
            }).then(function(token) {
                if (token) {
                    document.getElementById('recaptcha').value = token;
                }
            });
        });
    </script>
    {{-- @include('layouts.footer') --}}
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="{{ asset('theme/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('theme/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('theme/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('theme/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('theme/vendors/select2/select2.min.js') }}"></script>
    <script src="{{ asset('theme/js/dataTables.select.min.js') }}"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('theme/js/off-canvas.js') }}"></script>
    <script src="{{ asset('theme/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('theme/js/template.js') }}"></script>
    <script src="{{ asset('theme/js/settings.js') }}"></script>
    <script src="{{ asset('theme/js/todolist.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{ asset('theme/js/dashboard.js') }}"></script>
    <script src="{{ asset('theme/js/Chart.roundedBarCharts.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
        $(function() {
            $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                var link = $(this).attr("href");
                console.log(link);
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = link
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            });
            $(document).on('click', '.item-delete', function(e) {
                e.preventDefault();
                var link = $(this).attr("href");
                console.log(link);
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = link
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            });
        });
    </script>
    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info("{{ Session::get('message') }}");
                    break;
                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                    break;
                case 'warning':
                    toastr.warning("{{ Session::get('message') }}");
                    break;
                case 'error':
                    toastr.error("{{ Session::get('message') }}");
                    break;

            }
        @endif
    </script>
    <!-- End custom js for this page-->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        //AOS.init();
        //window.AOS = require('AOS');
        AOS.init();
    </script>
   
</body>

</html>
