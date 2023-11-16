@extends('layouts.main')
@section('content')
    <style>
        .description {
            font-size: 0.8rem;
            color: #0689bd;
            border: 1px dashed #0689bd00;
            margin: 3px 5px 10px 0;
            /* padding: 0 5px; */
            border-radius: 10px;
            text-align: left;
        }

        .wizard-box {
            min-height: 70vh;
            max-height: 100%;
            border-bottom: 7px solid #31787a
        }

        @media screen and (max-width:480px) {
            .wizard-box {
                min-height: 70vh;
                max-height: 100%;
                border-bottom: 0px solid #31787a;
                margin-bottom: 10px;

            }
        }

        .form-control {
            color: #0689bd;
            background: #eceded85;
        }

        .form-control:focus {
            color: #0689bd;
            background: #cde0e048;
            clear: both;
            -webkit-user-modify: read-write-plaintext-only;
        }

        .form-control:focus+.description {
            color: #0055c5;
            font-weight: bolder;
            background: #cde0e048;
        }

        .scroll-box {
            overflow-y: auto;
            overflow-x: clip;

        }

        .scroll-box::-webkit-scrollbar {
            width: 5px;
        }

        .scroll-box::-webkit-scrollbar-track {
            box-shadow: inset 0 0 2px rgba(0, 0, 0, 0.3);
        }

        .scroll-box::-webkit-scrollbar-thumb {
            background-color: rgb(19, 120, 221);
            outline: 0 solid rgb(19, 120, 221);
        }

        .btn-section {
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .info-image {
            min-height: 60vh;
            max-height: 60vh;
        }

        /* @media screen and (max-width:480px){
            .info-image{
                display: none;
            max-width: 20rem;
            min-height: 20rem; max-height:20rem;
        }
        } */
    </style>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-between align-items-center">
                    <div class="col-md-6">
                        <h4 class="m-0 text-dark">{{ __('Pump') }}</h4>
                        <ol class="breadcrumb  border-0 p-0 m-0">
                            <li class="breadcrumb-item "><a href="{{ route('companyadmin.dashboard') }}"
                                    class="text-active">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item "><a href="{{ route('companyadmin.office.index') }}"
                                    class="text-active">{{ __('Business Entity') }}</a></li>
                            <li class="breadcrumb-item active ">{{ __('New Pump') }}</li>
                        </ol>

                    </div>
                    <div class="col-md-6  ">

                        <div class=" d-flex  justify-content-end" style="right:0;top:0;">
                            <a href="{{ route('companyadmin.wizard.index') }}" title="{{ __('New Pump') }}"
                                class="sr-only d-none {{ env('APP_ENV') == 'local' ? 'load-wizard  btn btn-rounded animated-shine disabled px-2 mb-2 ' : 'sr-only' }} ">
                                {{ __('New Pump') }}</a>
                            {{-- <a href="javascript:" data-param="" data-size=""
                                data-url="{{ route('companyadmin.wizard.modal', 'modal') }}"
                                title="{{ __('New Pump') }}"
                                class="{{ env('APP_ENV')=='local'?'load-wizard  btn btn-rounded animated-shine px-2 mb-2 ':'sr-only' }} ">
                                {{ __('New Pump') }}</a> --}}
                            <a href="{{ route('companyadmin.office.index') }}" title="{{ __('Business Entities') }}"
                                class="  btn btn-rounded animated-shine px-2 mb-2 ">
                                {{ __('Business Entities') }}</a>
                        </div>
                    </div>
                </div>
                <section id="section_modal" class="modal_section ">

                    <div class="rounded card p-3 bg-white shadow min-h-100" style="border-bottom:5px solid #519da0 ">
                        <div class="spinner-border text-primary" role="status">
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
    {{-- <script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>
    <script>
        const driver = window.driver.js.driver;
    </script> --}}
@endsection
