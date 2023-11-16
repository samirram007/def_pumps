@extends('layouts.main')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/driver.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css" />

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-between align-items-center">
                    <div class="col-md-6">
                        <h4 class="m-0 text-dark">{{ __('Business Entity') }}</h4>
                        <ol class="breadcrumb  border-0 p-0 m-0">
                            <li class="breadcrumb-item "><a href="{{ route('companyadmin.dashboard') }}"
                                    class="text-active">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Business Entity') }}</li>
                        </ol>

                    </div>
                    <div class="col-md-6  ">

                        <div class=" d-flex  justify-content-end" style="right:0;top:0;">
                            <a href="{{ route('companyadmin.wizard.index') }}" title="{{ __('New Pump') }}"
                                class="{{ env('APP_ENV') == 'local' ? 'load-wizard  btn btn-rounded animated-shine px-2 mb-2 ' : 'sr-only' }} ">
                                {{ __('New Pump') }}</a>
                            {{-- <a href="javascript:" data-param="" data-size=""
                                data-url="{{ route('companyadmin.wizard.modal', 'modal') }}" title="{{ __('New Pump') }}"
                                class="{{ env('APP_ENV') == 'local' ? 'load-wizard  btn btn-rounded animated-shine px-2 mb-2 ' : 'sr-only' }} ">
                                {{ __('New Pump W') }}</a> --}}
                            <a href="javascript:" data-param="" data-url="{{ route('companyadmin.office.create') }}"
                                title="{{ __('Add Business Entity') }}"
                                class="load-popup  btn btn-rounded animated-shine px-2 mb-2 ">
                                {{ __('Add Business Entity') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <section class="content">
            <div class="organization-chart">
                <div class="card">


                    <div class="card-body">

                        <div class="column">

                            <div class="row">
                                <div id="organisation-chart" class="col-lg-12">

                                    <div class="spinner-border text-primary" role="status">
                                    </div>
                                </div>



                            </div>

                        </div>

                    </div>
                    {{-- @dd($offices) --}}
                    {{-- @include('module.office._partial.index_body', ['offices' => $offices]) --}}
                </div>
        </section>


    </div>
@endsection

@section('style')
    <style>
        .pdl-0 {
            padding-left: 2px !important;
            width: 100%;
        }

        .pdl-1 {
            padding-left: 20px !important;
        }

        .pdl-2 {
            padding-left: 40px !important;
        }

        .pdl-3 {
            padding-left: 60px !important;
        }

        .pdl-4 {
            padding-left: 80px !important;
        }

        .pdl-5 {
            padding-left: 100px !important;
        }

        .pdlg-1 {
            padding-left: 80px !important;
        }

        .pdlg-2 {
            padding-left: 100px !important;
        }

        .pdlg-3 {
            padding-left: 120px !important;
        }

        .pdlg-4 {
            padding-left: 140px !important;
        }

        .pdlg-5 {
            padding-left: 160px !important;
        }

        .pdl-10 {
            padding-left: 10px !important;
        }

        .m-size {
            font-size: 1.2rem;
            font-weight: 600;
            line-height: 0.5;
        }

        .fw-600 {
            font-weight: 600
        }

        .custom-table-shadow {
            box-shadow: 0 2px 5px 0 rgb(0 0 0 / 25%), 0 3px 10px 5px rgb(0 0 0 / 5%) !important
        }

        .accordion-item {
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #5796d0), color-stop(100%, #3d6d99));
            width: 100%;
            color: #fff;
        }

        .accordion-item:hover {
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #495261), color-stop(100%, #38404b));
        }

        .accordion-button {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
            padding: 0.1rem 1.25rem;
            font-size: 1rem;
            color: #fff;
            text-align: left;
            border: 0;
            border-radius: 0;
            overflow-anchor: none;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out, border-radius .15s ease;
        }

        .accordion-button:before {
            flex-shrink: 0;
            width: 1.25rem;
            height: 1.25rem;
            margin-right: 20px;
            content: "";
            background-image: url(../images/icons/arrow.svg);
            background-repeat: no-repeat;
            background-size: 1.25rem;
            transition: transform .2s ease-in-out;
            transform: rotate(-180deg);
        }

        .accordion-button:not(.collapsed):before {
            transform: rotate(0deg);
        }
    </style>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('.expand').on('click', function(event) {
                //   console.log('clicked'+ $(this).children('td:first-child').children('button').html().trim());
                if ($(this).children('td:first-child').children('button').html().trim() == '+') {
                    $(this).children('td:first-child').children('button').html('-');
                    // $(this).css('border-bottom','2px solid #fff');

                } else {
                    $(this).children('td:first-child').children('button').html('+');
                    //$(this).css('border-bottom','1px solid #dee2e6');
                }
                // $('.collapse').toggle();

            });


            var table = $('#table').DataTable({
                responsive: true,
                select: false,

                zeroRecords: true,
                "oLanguage": langOpt,
                "order": [
                    [0, "asc"]
                ]
            });


        });
        populateOffice();
        async function populateOffice() {

            //console.log(officeId);
            var office_url = "{{ route('companyadmin.office.populate_list') }}";
            // console.log(office_url);

            $.ajax({
                url: office_url,
                type: 'get',
                dataType: 'json',
                success: function(data) {
                    $("#organisation-chart").html(data.html);
                }
            });

        }

        function loadGodown(officeId) {
            // console.log(officeId);
            var godown_url = "{{ route('companyadmin.office.godowns', ':id') }}";

            var godown_url = godown_url.replace(':id', officeId);
            $.ajax({
                url: godown_url,
                type: 'get',
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    $("#modal-popup").html(data['html']);
                }
            });

        }
    </script>


    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>
    <script>
        const driver = window.driver.js.driver;
    </script>
@endpush
