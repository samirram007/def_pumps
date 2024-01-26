<style>
    .object {
        width: 100%;
        height: calc(100vh - 4rem);
    }

    ::-webkit-scrollbar {
        width: .5em;
    }

    .theme-container {
        background: rgb(26, 28, 45) !important;
        border-radius: 20px;
        padding: 1.2rem;
    }
</style>
<div class="modal-header ">
    <div class="modal-title text-light {{ env('APP_DEBUG') ? '' : 'd-none' }}">
        <div class="pl-2 pt-2">{{ __('Driver Statistics') }} </div>

    </div>
    <button type="button" onclick="showStat(this)" class="close">
        <i class="fa fa-times-circle" style="font-size:24px; color:#fff"></i>
    </button>
</div>
<object id="statObject" data="" type="" class="object "></object>


<script>
    function driverStat(driverId) {


        var theme = localStorage.getItem('lights') == 'on' ? 'light' : 'dark';
        var DASHBOARD_URL = "{{ env('DASHBOARD_URL') }}";
        var str = `${DASHBOARD_URL}driverstatistic?driverId=${driverId}`;
        console.log(str);
        document.getElementById('statObject').data = str;
        showStat()
    }

    function showStat() {

        // initMap();
        if ($('#statWrapperPanel').hasClass('d-none')) {
            $('#statWrapperPanel').removeClass('d-none');
            $('#statWrapperPanel').addClass('d-flex');


        } else if ($('#statWrapperPanel').hasClass('d-flex')) {

            $('#statWrapperPanel').addClass('d-none');
            $('#statWrapperPanel').removeClass('d-flex');


        }
    }
</script>
