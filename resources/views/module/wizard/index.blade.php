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
.wizard-box{
    min-height: 70vh; max-height:100%;   border-bottom:7px solid #31787a

}
@media screen and (max-width:480px){
    .wizard-box{
    min-height: 70vh; max-height:100%;   border-bottom:0px solid #31787a; margin-bottom: 10px;

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
    .form-control:focus + .description {
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

                    <div class="rounded card p-3 bg-white shadow min-h-100"  style="border-bottom:5px solid #519da0 ">
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
    <script>
        var step = @json($step);
        var routeRole = @json($routeRole);
        var section_modal = $('#section_modal');
        var section = section_modal;
        // var officeId = '';
        var wizardOfficeId = @json($officeId);

        $(document).ready(function() {



            if (step == 'modal') {
                setTimeout(() => {
                    createOffice();
                }, 100);

            }

            async function ajaxPost(url, section, data) {
                $.ajax({
                    url: url,
                    method: "POST",
                    data: data,
                    success: function(response) {

                        if (response.status) {

                            section.innerHTML = response.html;
                            return;
                        }
                        toastr.error('something went wrong');
                        return;

                    }
                });
            }



        });

        async function createOffice() {

            var url = "{{ route($routeRole . '.wizard.modal', ['create_office', ':id']) }}";
            url = url.replace(':id', wizardOfficeId);



            $('#title').html("New Pump");
            await ajaxGet(url);

        }
        async function showOffice() {

            var url = "{{ route($routeRole . '.wizard.modal', ['show_office', ':id']) }}";
            url = url.replace(':id', wizardOfficeId);

            var elements = $('.modal_section');

            elements.addClass('d-none');
            var section = $('#section_modal');
            section.removeClass('d-none');
            $('#title').html("Office Info");
            await ajaxGet(url, section);

        }

        async function loadWizardGodown(id) {
            if (wizardOfficeId == '') {
                wizardOfficeId = id
            }
            if (wizardOfficeId == '') {
                toastr.error("Office Initialize failed")
                return
            }
            var url = "{{ route($routeRole . '.wizard.modal', ['godown_list', ':id']) }}";
            url = url.replace(':id', wizardOfficeId);

            // var elements = $('.modal_section');
            // elements.addClass('d-none');
            // var section = $('#section_godown_list');
            // section.removeClass('d-none');
            $('#title').html("List Of Godown");
            await ajaxGet(url, section);

        }



        async function getAllStock(id) {


            if (wizardOfficeId == '') {
                wizardOfficeId = id
            }
            if (wizardOfficeId == '') {
                toastr.error("Office Initialize failed")
                return
            }
            var url = "{{ route('companyadmin.wizard.modal', ['all_stock', ':id']) }}";

            url = url.replace(':id', wizardOfficeId);

            var elements = $('.modal_section');
            elements.addClass('d-none');
            var section = $('#section_modal');
            section.removeClass('d-none');
            $('#title').html("Stock in Godown");
            await ajaxGet(url, section);
        }
        async function addGodown(id) {
            if (wizardOfficeId == '') {
                wizardOfficeId = id
            }
            if (wizardOfficeId == '') {
                toastr.error("Office Initialize failed")
                return
            }
            let url = "{{ route('companyadmin.wizard.modal', ['create_godown', ':id']) }}";
            url = url.replace(':id', wizardOfficeId);

            var elements = $('.modal_section');
            elements.addClass('d-none');
            var section = $('#section_modal');
            section.removeClass('d-none');
            $('#title').html("Create Godown Details");
            await ajaxGet(url, section);




        }
        async function editGodown(id) {
            if (id == '') {
                toastr.error("Godown is missing")
                return
            }

            let url = "{{ route('companyadmin.wizard.modal', ['edit_godown', ':id']) }}";
            url = url.replace(':id', id);

            var elements = $('.modal_section');
            elements.addClass('d-none');
            var section = $('#section_modal');
            section.removeClass('d-none');
            $('#title').html("Modify Godown Details");
            await ajaxGet(url, section);

        }
        // $('.godown-edit').on('click', (e) => {

        //     let godownId = $(e.target).attr('data-id');
        //     let url = "{{ route('companyadmin.wizard.modal', ['edit_godown', ':id']) }}";

        //     url = url.replace(':id', godownId);

        //     $.ajax({
        //         url: url,
        //         type: "GET",
        //         dataType: 'json',
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         contentType: "application/json; charset=utf-8",
        //         success: (response) => {

        //             $('#EntryPanel').removeClass('d-none');
        //             $('#EntryPanel').html(response.html)
        //             $('#ListPanel').addClass('d-none');
        //             $('#modalTitle').html("{!! __('Edit Godown') !!}");


        //         },
        //         error: function(xhr, status, error) {

        //         }
        //     });

        // });
        $('.godown-delete').on('click', (e) => {
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
                    let godownId = $(e.target).attr('data-id');
                    let url = "{{ route('companyadmin.godown.delete', ':id') }}";

                    url = url.replace(':id', godownId);

                    $.ajax({
                        url: url,
                        type: "GET",
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        contentType: "application/json; charset=utf-8",
                        success: (response) => {
                            if (response.status) {
                                toastr.info("Godown successfully deleted");
                                // $('#EntryPanel').addClass('d-none');
                                // $('#EntryPanel').html('')
                                // $('#ListPanel').removeClass('d-none');
                                $('#ListPanel').html(response.html);
                                $('#modalTitle').html("{!! __('Godowns') !!}");

                            } else {
                                toastr.error("Godown deletion error");
                            }


                        },
                        error: function(xhr, status, error) {
                            toastr.error("Godown deletion error");
                        }
                    });
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            })


        });

        $('#godownName').on('keyup', () => {
            $('#godownNameError').html('');
        });
        $('.all-stock').on('click', function() {
            getAllStock();


        });

        $('.godown-stock').on('click', function(e) {
            let godownId = $(e.target).attr('data-id');
            let url = "{{ route('companyadmin.godown.current_stock', ':id') }}";

            url = url.replace(':id', godownId);

            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: "application/json; charset=utf-8",
                success: (response) => {

                    $('#EntryPanel').removeClass('d-none');
                    $('#EntryPanel').html(response.html)
                    $('#ListPanel').addClass('d-none');
                    $('#modalTitle').html("{!! __('Godown Stock') !!}");


                },
                error: function(xhr, status, error) {

                }
            });

        });


        async function loadWizardRate(id) {
            if (id == '') {
                toastr.error("Godown is missing")
                return
            }

            let url = "{{ route('companyadmin.wizard.modal', ['product_rate', ':id']) }}";
            url = url.replace(':id', id);

            var elements = $('.modal_section');
            elements.addClass('d-none');
            var section = $('#section_modal');
            section.removeClass('d-none');
            $('#title').html("Set Product Rates");
            await ajaxGet(url, section);


        }
        async function loadWizardInvoiceNo(id) {

            if (id == '') {
                toastr.error("Office is missing")
                return
            }
            if (wizardOfficeId == '') {
                wizardOfficeId = id
            }
            if (wizardOfficeId == '') {
                toastr.error("Office Initialize failed")
                return
            }

            let url = "{{ route('companyadmin.wizard.modal', ['invoice_no', ':id']) }}";
            url = url.replace(':id', wizardOfficeId);

            var elements = $('.modal_section');
            elements.addClass('d-none');
            var section = $('#section_modal');
            section.removeClass('d-none');
            $('#title').html("Set Invoice No");
            await ajaxGet(url, section);


        }


        async function loadCreateUser(id) {
            if (wizardOfficeId == '') {
                wizardOfficeId = id
            }
            if (wizardOfficeId == '') {
                toastr.error("Office Initialize failed")
                return
            }
            let url = "{{ route('companyadmin.wizard.modal', ['create_user', ':id']) }}";
            url = url.replace(':id', wizardOfficeId);

            var elements = $('.modal_section');
            elements.addClass('d-none');
            var section = $('#section_modal');
            section.removeClass('d-none');
            $('#title').html("Add New User");
            await ajaxGet(url, section);
        }


        async function loadListUser(id) {
            if (wizardOfficeId == '') {
                wizardOfficeId = id
            }
            if (wizardOfficeId == '') {
                toastr.error("Office Initialize failed")
                return
            }
            let url = "{{ route('companyadmin.wizard.modal', ['user_list', ':id']) }}";
            url = url.replace(':id', wizardOfficeId);

            var elements = $('.modal_section');
            elements.addClass('d-none');
            var section = $('#section_modal');
            section.removeClass('d-none');
            $('#title').html("List Of User");
            await ajaxGet(url, section);
        }
        async function LoadSales(id) {
            if (wizardOfficeId == '') {
                wizardOfficeId = id
            }
            if (wizardOfficeId == '') {
                toastr.error("Office Initialize failed")
                return
            }

            let url = "{{ route('companyadmin.sales.index_create', [':id']) }}";
            url = url.replace(':id', wizardOfficeId);
            location.replace(url);
            // var elements = $('.modal_section');
            // elements.addClass('d-none');
            // var section = $('#section_modal');
            // section.removeClass('d-none');
            // await ajaxGet(url, section);
        }
        async function ajaxGet(url) {
            $.ajax({
                url: url,
                method: "GET",
                success: function(response) {

                    if (response.status) {

                        section_modal.html(response.html);
                        // console.log(response.html)
                        return;
                    }
                    toastr.error('something went wrong');
                    return;

                }
            });
        }
    </script>
@endsection
