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
    var x = localStorage.getItem('lights');
    const doc = document;
    const lightSwitch = doc.getElementById('lights-toggle');
    let labelText = lightSwitch.parentNode.querySelector('.label-text');
    console.log(x);
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
            if (lightSwitch.checked) {
                body.classList.remove('lights-off')
                //   deleteCookie('lights-off');
                // setCookie('lights','on')
                localStorage.setItem('lights', 'on');
               // sessionStorage.setItem('lights', 'on');
              //  setCookie('lights', 'on');
                if (labelText) {
                    labelText.innerHTML = 'dark'
                }
            } else {
                body.classList.add('lights-off')
                //   setCookie('lights','off')
                localStorage.setItem('lights', 'off')
               // sessionStorage.setItem('lights', 'off')
               // setCookie('lights', 'off');
                if (labelText) {
                    labelText.innerHTML = 'light'
                }
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
