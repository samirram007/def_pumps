<!-- container-scroller -->

{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script> --}}
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script> --}}
<script type="text/javascript" src="{{ asset('datetime/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('datetime/daterangepicker.js') }}" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
<script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
<!-- plugins:js -->
<script src="{{ asset('theme/vendors/js/vendor.bundle.base.js') }}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
{{-- <script src="{{ asset('theme/vendors/chart.js/Chart.min.js') }}"></script> --}}
<script src="{{ asset('theme/vendors/datatables.net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('theme/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('theme/vendors/select2/select2.min.js') }}"></script>
<script src="{{ asset('theme/js/dataTables.select.min.js') }}"></script>



<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>
<script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.9/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{ asset('theme/js/off-canvas.js') }}"></script>
<script src="{{ asset('theme/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('theme/js/template.js') }}"></script>
<script src="{{ asset('theme/js/settings.js') }}"></script>
<script src="{{ asset('theme/js/todolist.js') }}"></script>
{{-- <script src="{{asset('landing/dist/js/main.min.js')}}"></script>
<script src="{{asset('landing/src/js/main.js')}}"></script> --}}
<script>
    $(document).ready(function() {
        // $('.script_active').click(function() {
        //     $('.nav-item').removeClass('active');
        //     $(this).toggleClass('active');
        // });
        setTimeout(() => {
            $('.preloader').fadeOut();
        }, 100);

    });
</script>
<script>
    var x = localStorage.getItem('lights');
    const doc = document;
    const lightSwitch = doc.getElementById('lights-toggle');
    let labelText = lightSwitch.parentNode.querySelector('.label-text');

    if (x == 'on') {
        document.body.classList.remove('lights-off');

        lightSwitch.checked = true;
        labelText.innerHTML = 'dark';



    } else {
        document.body.classList.add('lights-off');
        lightSwitch.checked = false;
        labelText.innerHTML = 'light';
    }
</script>
<script>
    function trimToMaxLength(str, maxLength) {
        if (str.length > maxLength) {
            return str.substring(0, maxLength) + "...";
        }
        return str;
    }
</script>
<script>
    (function() {
        const doc = document
        const rootEl = doc.documentElement
        const body = doc.body
        const lightSwitch = doc.getElementById('lights-toggle')
        /* global ScrollReveal */
        // const sr = window.sr = ScrollReveal()

        // rootEl.classList.remove('no-js')
        // rootEl.classList.add('js')

        // window.addEventListener('load', function() {
        //     body.classList.add('is-loaded')
        // })

        // Reveal animations
        // function revealAnimations() {
        //     sr.reveal('.feature', {
        //         duration: 600,
        //         distance: '20px',
        //         easing: 'cubic-bezier(0.215, 0.61, 0.355, 1)',
        //         origin: 'right',
        //         viewFactor: 0.2
        //     })
        // }

        // if (body.classList.contains('has-animations')) {
        //     window.addEventListener('load', revealAnimations)
        // }

        // Light switcher
        if (lightSwitch) {
            // window.addEventListener('load', checkLights)
            lightSwitch.addEventListener('change', checkLights)
        }

        function checkLights() {
            let labelText = lightSwitch.parentNode.querySelector('.label-text')

            // console.log(document.getElementById("object"))

            if (lightSwitch.checked) {
                body.classList.remove('lights-off')
                // changeDashboardTheme('dark', 'light')

                //   deleteCookie('lights-off');
                // setCookie('lights','on')
                localStorage.setItem('lights', 'on');
                if (document.getElementById("object") != null) {

                    newDashboard()
                }
                // sessionStorage.setItem('lights', 'on');
                //  setCookie('lights', 'on');
                if (labelText) {
                    labelText.innerHTML = 'dark'
                }

            } else {
                body.classList.add('lights-off')

                //   setCookie('lights','off')
                localStorage.setItem('lights', 'off')
                if (document.getElementById("object") != null) {
                    newDashboard()
                }
                // sessionStorage.setItem('lights', 'off')
                // setCookie('lights', 'off');
                if (labelText) {
                    labelText.innerHTML = 'light'
                }

            }

        }

        function changeDashboardTheme(value1, value2) {
            console.log(document.getElementById("object"));
            if (document.getElementById("object") != null) {
                var dashboardObject = document.getElementById("object")
                var objData = dashboardObject.data;
                objData.replace(`theme=${value1}`, `theme=${value2}`);
                console.log(objData)
            }

        }

        function deleteCookie(key) {
            document.cookie = key + '="";expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        };

        function setCookie(key, value) {
            var expires = new Date();
            expires.setTime(expires.getTime() + (60 * 1000));
            document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
        }
    }())
</script>
<!-- endinject -->
<!-- Custom js for this page-->
{{-- <script src="{{asset('theme/js/dashboard.js')}}"></script> --}}

{{-- <script src="{{ asset('theme/js/Chart.roundedBarCharts.js') }}"></script> --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-toast />



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
                confirmButtonText: 'Confirm!',
                cancelButtonText: 'Not Confirm!'
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

        $(document).on('click', '.delete_remove', function(e) {
            e.preventDefault();
            var link = $(this).attr("href");
            Swal.fire({
                title: 'Are you sure?',
                text: "Your action will cancel this plan forever, if you are sure plase click Confirm, if not Click Not Confirm!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm!',
                cancelButtonText: 'Not Confirm!'
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
            var thisHTML = e.target.innerHTML;
            //console.log(thisHTML);
            var spinner =
                `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>${thisHTML} `
            e.target.innerHTML = spinner;
            e.target.style = "pointer-events: none";
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
                    '_token': token,
                    'param': param,
                    'size': size
                },
                success: function(data) {

                    if (!data.error) {
                        e.target.innerHTML = thisHTML;
                        e.target.style = "pointer-events: auto";
                        $("#modal-popup").html(window.atob(data['html']));

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
                        e.target.innerHTML = thisHTML;
                        e.target.style = "pointer-events: auto";
                    }


                },
                error: function(xhr, status, error) {
                    e.target.innerHTML = thisHTML;
                    e.target.style = "pointer-events: auto";

                }

            });

        });

        $(document).on("click", ".load-popup-back", function(e) {
            thisHTML = e.target.innerHTML;
            //console.log(thisHTML);
            var spinner =
                `<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> `
            e.target.innerHTML = spinner;
            e.target.style = "pointer-events: none";

            var deliveryPlanId = $(this).data('param');
            let url = `{{ route('companyadmin.delivery_plan.status_change', ':id') }}`;
            url = url.replace(':id', deliveryPlanId);
            console.log(url);
            let param = '';
            let size = '';
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
                        e.target.innerHTML = thisHTML;
                        e.target.style = "pointer-events: auto";
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

                        toastr.error("Something went wrong, please try again")
                    }


                },
                error: function(xhr, status, error) {
                    e.target.innerHTML = thisHTML;
                    e.target.style = "pointer-events: auto";
                    toastr.error("Something went wrong, please try again")
                }

            });
        });
        $(document).on("click", ".load-popup", function(e) {
            var thisHTML = e.target.innerHTML;
            //console.log(thisHTML);
            var spinner =
                `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> `
            e.target.innerHTML = spinner;
            e.target.style = "pointer-events: none";

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
                    //console.log(thisHTML);
                    e.target.innerHTML = thisHTML;
                    e.target.style = "pointer-events: auto";
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
                        e.target.innerHTML = thisHTML;
                        e.target.style = "pointer-events: auto";
                        toastr.error("Something went wrong, please try again")
                    }


                },
                error: function(xhr, status, error) {
                    e.target.innerHTML = thisHTML;
                    e.target.style = "pointer-events: auto";
                    toastr.error("Something went wrong, please try again")
                }

            });

        });


        $(document).on("click", ".load-wizard", function(e) {
            var thisHTML = e.target.innerHTML;
            //console.log(thisHTML);
            var spinner =
                `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> `
            e.target.innerHTML = spinner;
            e.target.style = "pointer-events: none";
            var param = $(this).data('param');
            var url = $(this).data('url');
            var size = $(this).data('size');
            // console.log(url);
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
                    e.target.innerHTML = thisHTML;
                    e.target.style = "pointer-events: auto";
                    if (!data.error) {
                        $("#modal-wizard").html(data['html']);
                        // $("#modal-wizard").modal('show');
                        //increase modal height 0 to 100 % animated
                        var init_height = 0;

                        var interval = setInterval(() => {
                            init_height = (init_height + 0.2);
                            $("#modal-wizard").css('opacity', init_height);
                            $("#modal-wizard").modal('show');

                            if (init_height >= 1) {
                                clearInterval(interval);

                            }

                        }, 50);

                    } else {
                        e.target.innerHTML = thisHTML;
                        e.target.style = "pointer-events: auto";
                        toastr.error("Something went wrong, please try again")
                    }


                },
                error: function(xhr, status, error) {
                    e.target.innerHTML = thisHTML;
                    e.target.style = "pointer-events: auto";
                    toastr.error("Something went wrong, please try again")

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
{{-- <script src="https://unpkg.com/aos@next/dist/aos.js"></script> --}}
<script src="{{ asset('js/aos.js') }}"></script>
<script>
    AOS.init();
</script>
