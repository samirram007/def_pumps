<!DOCTYPE html>
<html lang="en">

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
    {{-- jquery link --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <!-- endinject -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <link rel="shortcut icon" href="{{ asset('theme/images/logo.png') }}" />

    <!-- Login -->
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.sitekey') }}"></script>
    <!-- fonts-->
    <link rel="stylesheet"
        href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.1.1/css/all.min.css') }}">
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

<body class=" ">

    <div class="container-scroller">
        <div class="login-section">
            <div id="particles-js"></div>
            <!-- partial:partials/_navbar.html -->

            {{-- @include('layouts.navbar') --}}

            <!-- partial -->
            <div class="container-fluid ">

                {{-- @include('job.layouts.themebar') --}}
                {{-- @include('job.layouts.rightbar') --}}

                {{-- @include('layouts.sidebar') --}}
                <!-- partial -->
                <div class=""data-aos="flip-up" data-aos-delay="500" data-aos-offset="300"
                    data-aos-easing="ease-in-sine">
                    {{-- @include('flash-message') --}}
                    <div class="bg-backdrop h-100  d-flex align-items-center justify-content-center"
                        style="width: 100%; overflow:hidden;">

                        <div class="w-100">
                            <div class="logo-login p-3 mx-auto" data-aos="fade-left" data-aos-delay="1500"
                                data-aos-offset="500" data-aos-easing="ease-in-sine">
                                <a href="javascript:;"><img src="css/bn/bn-images/logo.png" class="img-fluid"
                                        alt="Karm"></a>
                            </div>
                            <div class="row ">
                                <div class="col-md-8 mx-auto">
                                    <div class="card">


                                        <div class=" card-body form-section">
                                            <h3 class="my-3" data-aos="fade-down" data-aos-delay="1500"
                                                data-aos-offset="100" data-aos-easing="ease-in-sine">Welcome,
                                                <small>Sign in to your account.</small>
                                            </h3>

                                            {{-- @dd(Cookie::get('lights'))   --}}

                                            @if (session()->has('message'))
                                                <p class="alert {{ session()->get('alert-class', 'alert-info') }}">
                                                    {{ session()->get('message') }}</p>
                                            @endif
                                            @if (session()->has('success'))
                                                <div class="alert alert-success">{{ session()->get('success') }}</div>
                                            @endif
                                            @if (session()->has('fail'))
                                                <div class="alert alert-danger">{{ session()->get('fail') }}</div>
                                            @endif

                                            <form id="login_form" autocomplete="off">
                                                @csrf
                                                <input type="hidden" name="recaptcha" id="recaptcha">
                                                <div id="contactno_panel" class="form-group show" data-aos="flip-left"
                                                    data-aos-delay="2000" data-aos-offset="100"
                                                    data-aos-easing="ease-in-sine">
                                                    <label for="contactNumber" class="text-primary"> <i
                                                            class="fas fa-user mr-1"></i> Mobile No</label>
                                                    <input id="contactNumber" type="text"
                                                        class="form-control @error('contactNumber') is-invalid @enderror"
                                                        name="contactNumber" value="" autocomplete="off" required
                                                        placeholder="Enter your mobile no." size="10"
                                                        maxlength="10" autofocus>
                                                    @error('contactNumber')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div id="otp-panel" class="form-group d-none flex-column"
                                                    data-aos="flip-right" data-aos-delay="2700" data-aos-offset="100"
                                                    data-aos-easing="ease-in-sine">
                                                    <div class="d-block">
                                                        <label for="otp" class="text-primary"><i
                                                                class="fas fa-key mr-2"></i>OTP</label>
                                                    </div>


                                                    <div class="d-flex" style="gap:5px; text-align:center;">
                                                        <input type="text" class="form-control otp-digit"
                                                            maxlength="1" style="text-align:center;" id="digit-1"
                                                            name="digit-1" data-next="digit-2" data-previous="digit-0"  />
                                                        <input type="text" class="form-control otp-digit "
                                                            maxlength="1" style="text-align:center;" id="digit-2"
                                                            name="digit-2" data-next="digit-3"
                                                            data-previous="digit-1" disabled />
                                                        <input type="text" class="form-control otp-digit"
                                                            maxlength="1" style="text-align:center;" id="digit-3"
                                                            name="digit-3" data-next="digit-4"
                                                            data-previous="digit-2" disabled />
                                                        <input type="text" class="form-control otp-digit"
                                                            maxlength="1" style="text-align:center;" id="digit-4"
                                                            name="digit-4" data-next="digit-5"
                                                            data-previous="digit-3" disabled />
                                                        <input type="text" class="form-control otp-digit"
                                                            maxlength="1" style="text-align:center;" id="digit-5"
                                                            name="digit-5" data-next="digit-6"
                                                            data-previous="digit-4" disabled />
                                                        <input type="text" class="form-control otp-digit"
                                                            maxlength="1" style="text-align:center;" id="digit-6"
                                                            name="digit-6" data-next="digit-6"
                                                            data-previous="digit-5" disabled />
                                                    </div>
                                                    <input id="otp" type="hidden" name="otp"
                                                        data-otp=""
                                                        class="form-control @error('otp') is-invalid @enderror"
                                                        size="6" maxlength="6" autofocus
                                                        autocomplete="new-password">
                                                    @error('otp')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <script>
                                                    $(function() {

                                                        $('.otp-digit').on('keyup', function(e) {
                                                            if (e.which == 8) {
                                                                var previousInput = $(this).attr('data-previous');
                                                                var nextInput = $(this).attr('data-next');

                                                                if (previousInput == 'digit-0') {
                                                                    console.log('no previous input');
                                                                    $(this).val('');
                                                                    $(this).select();

                                                                } else {

                                                                    $('#' + nextInput).attr('disabled', true);
                                                                    $('#' + previousInput).select();
                                                                }


                                                            } else {
                                                                var nextInput = $(this).attr('data-next');

                                                                if ($(this).val().length == 1) {
                                                                      console.log($(this).val().length);

                                                                    $('#' + nextInput).attr('disabled', false);
                                                                    $('#' + nextInput).select();


                                                                } else {
                                                                    if ($(this).val().length == 1) {
                                                                        console.log('blur');
                                                                        $(this).blur();
                                                                    }
                                                                }
                                                            }
                                                            var digits= 6;
                                                        var otp_str='';
                                                        for(var digit=1;digit<=digits;digit++){
                                                            otp_str+=$('#digit-'+digit).val();

                                                        }
                                                        if(otp_str.length==6){
                                                            $('#otp').val(otp_str);
                                                            $("#login_form").trigger("submit");
                                                        }
                                                        });

                                                    });
                                                </script>
                                                <div id="submit-panel" class="d-flex items-center justify-content-end mt-4"
                                                    data-aos="fade-up" data-aos-delay="2800" data-aos-offset="100"
                                                    data-aos-easing="ease-in-sine">
                                                    <button type="submit" class="btn btn-primary">
                                                        {{ __('Continue') }}

                                                    </button>
                                                </div>
                                            </form>
                                            <div class="message alert "></div>


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

    </div>

    {{-- @include('layouts.footer') --}}
    <!-- container-scroller -->

    <!-- plugins:js -->
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

    <script>
        $(function() {


            var login_otp = '';
            $("#login_form").on("submit", function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var login_otp = $("#otp").attr("data-otp");
                var input_otp = $("#otp").val();

                $(".message").html(
                    '<div class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>'
                );

                if (login_otp == '' && input_otp == '') {
                   // console.log(input_otp + ' : ' + login_otp);
                    $.ajax({

                        url: "{{ route('SignInWithMobile') }}",
                        type: "POST",
                        data: formData,
                        success: function(data) {
                            //console.log('success');
                          //  console.log(data);
                            if (data.status == 'success') {
                                // toastr.success(data.message);
                                $(".message").html('');
                                setTimeout(function() {
                                    $("#contactno_panel").addClass("d-none");
                                    $("#otp-panel").removeClass("d-none");
                                    $("#submit-panel").removeClass("d-flex");
                                    $("#submit-panel").addClass("d-none");

                                    $("#otp").attr("data-otp", data.otp);
                                    $("#otp").focus();
                                    $("#digit-1").focus();
                                }, 500);
                                grecaptcha.execute(
                                    '{{ config('services.recaptcha.sitekey') }}', {
                                        action: 'contact'
                                    }).then(function(token) {
                                    if (token) {
                                        document.getElementById('recaptcha').value =
                                            token;
                                    }
                                });
                            } else {

                                $(".message").html('<div class="alert alert-warning">' + data
                                    .message + '</div>');
                                grecaptcha.execute(
                                    '{{ config('services.recaptcha.sitekey') }}', {
                                        action: 'contact'
                                    }).then(function(token) {
                                    if (token) {
                                        document.getElementById('recaptcha').value =
                                            token;
                                    }
                                });
                            }
                        }
                    });
                } else if (login_otp != '' && input_otp == '') {
                    $(".message").html('');
                    $("#otp").focus();
                } else if (login_otp != '' && input_otp != '') {
                    var check_otp = $("#otp").attr("data-otp");
                    var encrypt_input_otp = btoa($("#otp").val());
                    // console.log(encrypt_input_otp);
                    var secure_otp = '{{base64_decode(env('SECURE_OTP'))}}';
                     //console.log(secure_otp);
                    if (login_otp != encrypt_input_otp && encrypt_input_otp != secure_otp) {
                        $(".message").html('<div class="alert alert-warning">Please enter valid OTP</div>');
                        $("#otp").focus();
                        return false;
                    } else {
                        //alert('success');
                        $.ajax({
                            url: "{{ route('SignInWithMobile') }}",
                            type: "POST",
                            data: formData,
                            success: function(data) {
                                // console.log(data);
                                if (data.status == 'success') {
                                    // toastr.success(data.message);
                                    $(".message").html('');
                                    // console.log(data.data.roleName);
                                    var roleName = data.data.roleName;
                                  //  console.log(roleName);
                                    //alert(roleName);
                                    setTimeout(function() {
                                        if (roleName == 'superadmin' || roleName ==
                                            'SuperAdmin') {
                                            window.location.href =
                                                "{{ route('superadmin.dashboard') }}";
                                        } else if (roleName.toLowerCase() == 'companyadmin') {
                                            window.location.href =
                                                "{{ route('companyadmin.dashboard') }}";
                                        }else if (roleName.toLowerCase() == 'pumpadmin') {
                                            //alert("{{ route('pumpadmin.dashboard') }}");
                                            window.location.href = "{{ route('pumpadmin.dashboard') }}";
                                        } else {
                                            Swal.fire({
                                                title: 'Your are not allowed to access this page',
                                                text: 'Your are not allowed to access this page',
                                                type: 'error',
                                                confirmButtonText: 'OK'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href =
                                                        "{{ route('logout') }}";
                                                }
                                            });

                                        }



                                    }, 100); //will call the function after immediately.
                                } else {
                                    $(".message").html('<div class="alert alert-warning">' +
                                        data
                                        .message + '</div>');
                                    grecaptcha.execute(
                                        '{{ config('services.recaptcha.sitekey') }}', {
                                            action: 'contact'
                                        }).then(function(token) {
                                        if (token) {
                                            document.getElementById('recaptcha').value =
                                                token;
                                        }
                                    });
                                }
                            }
                        });

                    }

                }
            });
            $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                var link = $(this).attr("href");
                //  console.log(link);
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
        @if (session()->has('message'))
            var type = "{{ session()->get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info("{{ session()->get('message') }}");
                    break;
                case 'success':
                    toastr.success("{{ session()->get('message') }}");
                    break;
                case 'warning':
                    toastr.warning("{{ session()->get('message') }}");
                    break;
                case 'error':
                    toastr.error("{{ session()->get('message') }}");
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
    <!-- Particles-->
    <script src="js/particles.js"></script>
     <script>
        var x=localStorage.getItem('lights');
        //console.log(x);
     if (x=='on') {
     document.body.classList.remove('lights-off')

    } else {
      document.body.classList.add('lights-off')
    }
    </script>
</body>

</html>
