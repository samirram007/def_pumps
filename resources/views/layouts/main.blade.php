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
    @yield('styles')

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

    <script>
        function date_format(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [day, month, year].join('-');
        }
        $(function() {
            $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                var link = $(this).attr("href");
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
            $(document).on("click", ".load-popup-post", function(e) {

                var param = $(this).data('param');
                var url = $(this).data('url');
                var size = $(this).data('size');
                var token = $(this).data('token');
               // alert(token);

                $.ajax({
                    url: url,
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    data: {
                        '_token':token,
                        'param': param,
                        'size': size
                    },
                    success: function(data) {

                        if (!data.error) {
                            // console.log(window.atob(data['html']));
                            $("#modal-popup").html(window.atob(data['html']));
                            // $("#modal-popup").modal('show');
                            //increase modal height 0 to 100 % animated
                            var init_height = 0;

                            var interval = setInterval(() => {
                                init_height = (init_height + 0.2);
                                $("#modal-popup").css('opacity', init_height);
                                $("#modal-popup").modal('show');

                                if (init_height >= 1) {
                                    clearInterval(interval);

                                }

                            }, 50);

                        } else {

                        }


                    },
                    error: function(xhr, status, error) {


                    }

                });

            });
            $(document).on("click", ".load-popup", function(e) {

                var param = $(this).data('param');
                var url = $(this).data('url');
                var size = $(this).data('size');

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

                        if (!data.error) {
                            $("#modal-popup").html(data['html']);
                            // $("#modal-popup").modal('show');
                            //increase modal height 0 to 100 % animated
                            var init_height = 0;

                            var interval = setInterval(() => {
                                init_height = (init_height + 0.2);
                                $("#modal-popup").css('opacity', init_height);
                                $("#modal-popup").modal('show');

                                if (init_height >= 1) {
                                    clearInterval(interval);

                                }

                            }, 50);

                        } else {

                        }


                    },
                    error: function(xhr, status, error) {


                    }

                });

            });
        });
        //         const myInterval = setInterval(myTimer, 1000);

        // function myTimer() {
        //   const date = new Date();
        //   document.getElementById("demo").innerHTML = date.toLocaleTimeString();
        // }

        // function myStop() {
        //   clearInterval(myInterval);
        // }
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
        AOS.init();
    </script>

    <script>
        $(document).ready(function() {
            // $('.script_active').click(function() {
            //     $('.nav-item').removeClass('active');
            //     $(this).toggleClass('active');
            // });
            setTimeout(() => {
                $('.preloader').fadeOut();
            }, 500);

        });
    </script>
    @stack('scripts')
</body>

</html>
