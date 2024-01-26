@extends('layouts.main')
@section('content')
    @include('module.wizard.tooltip')

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid position-relative">
                {{-- @include('module.wizard.header') --}}
                <div>
                    <div class="stepper bg-light anim-fade-in ">
                        {{-- @include('module.wizard.step_progressbar') --}}
                        @include('module.wizard.step_progressBlock')
                    </div>
                </div>

                <section id="section_modal" class="modal_section content d-none ">

                    {{-- <div class="rounded card p-3 bg-white shadow min-h-100">
                        <div class="spinner-border text-primary" role="status">
                        </div>
                    </div> --}}
                </section>
                <style>
                    #spinner {
                        background-color: #26454729 !important;
                        background: #ffffff85;
                        background-image: linear-gradient(90deg, #26454729, #26454729, #59b6ae56, #26454729);
                        z-index: 1000;
                        position: absolute;
                        width: -webkit-fill-available;
                        height: -webkit-fill-available;
                        min-height: 50vh;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        padding: 10px;
                        margin: 1rem 0.5rem 1rem 0.1rem;
                        border-radius: 10px;
                        animation: gradient 4s ease-in-out infinite;
                        opacity: 0;
                    }

                    #spinner>.spinner-border {

                        /* animation-name: changeColor;
                                                                                                                                                                                                                                                                                                                                                        animation-duration: 2s;
                                                                                                                                                                                                                                                                                                                                                        animation-iteration-count: infinite;
                                                                                                                                                                                                                                                                                                                                                        animation-fill-mode: ease-in-out; */
                    }

                    @keyframes spin {
                        100% {
                            transform: rotate(360deg);
                        }
                    }

                    /* Keyframes for gradient animation */
                    @keyframes gradient {
                        20% {
                            opacity: 0.6;
                            background-image: linear-gradient(90deg, #3498db5d, #5b59b656, #26454729, #599cb656);
                            filter: blur(1px);
                        }

                        50% {
                            opacity: 0.5;
                            background-image: linear-gradient(90deg, #26454729, #26454729, #598cb656, #26454729);
                            filter: blur(2px);
                        }

                        90% {
                            opacity: 0.6;
                            filter: blur(1px);
                            background-image: linear-gradient(90deg, #26454729, #26454729, #59b6ae56, #26454729);
                        }
                    }

                    @keyframes changeColor {
                        0% {
                            color: #ffc107;
                        }

                        25% {
                            color: #d3e0fd;
                        }

                        50% {
                            color: #8f9ceb;
                        }

                        75% {
                            color: #079cff;
                        }

                        100% {
                            color: #ffc107;
                        }

                    }
                </style>
                <section id="spinner" class="modal_section content position-absolute d-none ">


                    <span class="spinner-border " role="status">
                    </span>



                </section>
                <section id="stepWelcome" class="modal_section content ">
                    @include('module.wizard.welcome.index')
                </section>

                <section id="section_create_office" class="modal_section content">

                </section>
                <section id="section_godown_list" class="modal_section content">

                </section>
                <section id="stepComplete" class="modal_section content">
                    {{-- @include('module.wizard.welcome.complete') --}}
                </section>
                <section id="stepOffice" class="modal_section content">

                </section>
                <section id="stepGodown" class="modal_section content">

                </section>
                <section id="stepProduct" class="modal_section content">

                </section>
                <section id="stepInvoice" class="modal_section content">
                    {{-- @include('module.wizard.invoice_no.index') --}}
                </section>
                <section id="stepUser" class="modal_section content">

                </section>

            </div>
        </div>
        <form id="formCreate">
            @csrf
        </form>
        <form id="formPayload">
            @csrf
        </form>
    </div>
    {{-- <script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>
    <script>
        const driver = window.driver.js.driver;
    </script> --}}
    @include('module.wizard.css')
    @include('module.wizard.js')
@endsection
