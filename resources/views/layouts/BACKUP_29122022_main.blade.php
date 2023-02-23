<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{env('APP_NAME')}}</title>
    <!-- plugins:css -->
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
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    <link rel="stylesheet" type="text/css" href="{{asset('datetime/daterangepicker.css')}}" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script> --}}
    <script type="text/javascript" src="{{asset('datetime/moment.min.js')}}" ></script>
    <script type="text/javascript" src="{{asset('datetime/daterangepicker.js')}}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />


    <!-- endinject -->



    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
</head>

<body class="bg-light antialiased  ">
    <div class="container-scroller">

        <!-- partial:partials/_navbar.html -->

        @include('layouts.navbar')

        <!-- partial -->
        <div class="container-fluid page-body-wrapper">

            {{-- @include('job.layouts.themebar') --}}
            {{-- @include('job.layouts.rightbar') --}}

            @include('layouts.sidebar')
            <!-- partial -->
            <div class="main-panel bg-light" data-aos="fade-right" data-aos-delay="500" data-aos-offset="300"
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



    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/fixedheader/3.1.9/js/dataTables.fixedHeader.min.js"></script> --}}
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('theme/js/off-canvas.js') }}"></script>
    <script src="{{ asset('theme/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('theme/js/template.js') }}"></script>
    <script src="{{ asset('theme/js/settings.js') }}"></script>
    <script src="{{ asset('theme/js/todolist.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    {{-- <script src="{{asset('theme/js/dashboard.js')}}"></script> --}}

    {{-- <script src="{{ asset('theme/js/Chart.roundedBarCharts.js') }}"></script> --}}
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
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //jQuery.support.cors = true;

            $(document).on("click", ".load-popup", function() {
                //e.preventDefault();
                var param = $(this).data('param');
                var url = $(this).data('url');
                var size = $(this).data('size');
              //  console.log(param);
                //  $(".page-loader").show();
                $.ajax({
                    url: url,
                    type: "get",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: {
                        'param': param,
                        'size': size
                    },
                    success: function(data) {
                       //  console.log(data);
                        //console.log(ko.toJSON(response));
                        if (!data.error) {
                            $("#modal-popup").html(data['html']);
                            $("#modal-popup").modal('show');
                        } else {
                        //    console.log(data);
                        }

                        //  $(".page-loader").hide();
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        //$(".page-loader").hide();
                        //console.log(arguments);
                        /*  var msg =
                              '<div id="inner-message" class="alert alert-error shadow"><button type="button" class="close" data-dismiss="alert">&times;</button>' +
                              error + '</div>';
                          $("#message").html(msg);*/
                    }

                });

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
    <script>
        var x=localStorage.getItem('lights');
        //console.log(x);
     if (x=='on') {
     document.body.classList.remove('lights-off')

    } else {
      document.body.classList.add('lights-off')
    }
    </script>
    <script>
        // $('input[name="daterange"]').daterangepicker();
    </script>
</body>

</html>
