@extends('layouts.main')

@section('content')
    @php
        $token = session()->get('_token');
        $userid = session()->get('loginid');
        $lang = str_replace('_', '-', app()->getLocale());
        // $theme = '<script>
        //     localStorage.getItem('lights')
        // </script>';

    @endphp

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
    <object id="object" data="" type="" class="object "></object>

@endsection
@push('script')
<script>
    function newDashboard() {
        var token = '{{ $token }}';
        var userid = '{{ $userid }}';
        var lang='{{ $lang  }}';
        var theme = localStorage.getItem('lights') == 'on' ? 'light' : 'dark';
        var DASHBOARD_URL="{{ env('DASHBOARD_URL') }}";
        // var str = `http://115.124.120.251:5063/?theme=${theme}&lang=${lang}&userId=${ userid }&jwtToken=${ token }`;
        var str = `${DASHBOARD_URL}?theme=${theme}&lang=${lang}&userId=${ userid }&jwtToken=${ token }`;
        document.getElementById('object').data = str;
    }

    function switchDashboard() {
        if (document.getElementById('object').classList.contains('sr-only')) {
            document.getElementById('object').classList.remove('sr-only')
            document.getElementById('old').classList.add('sr-only')
            newDashboard()
        } else {
            document.getElementById('object').classList.add('sr-only')
            document.getElementById('old').classList.remove('sr-only')
            filter()
        }

    }
    $(document).ready(() => {
        newDashboard()
    });
</script>

@endpush
