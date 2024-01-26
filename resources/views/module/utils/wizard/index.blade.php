@extends('layouts.main')
@section('content')
    @include('module.wizard.tooltip')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                {{-- @include('module.wizard.header') --}}
                <div>
                    <div class="stepper bg-light anim-fade-in ">
                        @include('module.wizard.step_progressbar')
                    </div>
                </div>

                <section id="section_modal" class="modal_section content">

                    <div class="rounded card p-3 bg-white shadow min-h-100">
                        <div class="spinner-border text-primary" role="status">
                        </div>
                    </div>
                </section>
                <section id="section_create_office" class="modal_section content">

                </section>
                <section id="section_godown_list" class="modal_section content">

                </section>
                <section id="stepGodown" class="modal_section content">
                    Godown
                </section>

            </div>
        </div>
        <form id="formCreate">
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
