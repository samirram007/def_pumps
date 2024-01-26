<div class="modal-dialog modal-xl  modal-dialog-top mt-4">


    <div class="modal-content bg-info">
        <div class="modal-header">
            <h4 class="modal-title text-light" id="title">{{ __($title) }} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times-circle" style="font-size:24px; color:#fff"></i>
            </button>
        </div>

        <div class="modal-body bg-light p-0">
            <div class=" w-100  ">
                <div class="stepper bg-light sr-only">
                    @include('module.wizard.step_progressbar')
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


            </div>
        </div>

    </div>

</div>
<script>
    var step = @json($step);
    var routeRole = @json($routeRole);
    // var officeId = '';
    var wizardOfficeId = @json($officeId);

    $(document).ready(function() {



        if (step == 'modal') {

            createOffice();
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

        var elements = $('.modal_section');

        elements.addClass('d-none');
        var section = $('#section_create_office');
        section.removeClass('d-none');
        $('#title').html("New Pump");
        await ajaxGet(url, section);

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

        var elements = $('.modal_section');
        elements.addClass('d-none');
        var section = $('#section_godown_list');
        section.removeClass('d-none');
        $('#title').html("List Of Godown");
        await ajaxGet(url, section);

    }
    async function ajaxGet(url, section) {
        $.ajax({
            url: url,
            method: "GET",
            success: function(response) {

                if (response.status) {
                    section.html(response.html);
                    return;
                }
                toastr.error('something went wrong');
                return;

            }
        });
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
    var stepper = [{
            "title": "Pump Info",
            "active": true
        },
        {
            "title": "Godown",
            "active": false
        },

        {
            "title": "Rate",
            "active": false
        },

        {
            "title": "Invoice No",
            "active": false
        },
        {
            "title": "User",
            "active": false
        }

    ];
    async function populateStepper() {
        var stepperHtml = ""
        await stepper.forEach(function(step, idx, stepper) {
            console.log(step.title);
            stepperHtml +=
                `<div class="progress-step ${step.active==true?'progress-step-active':''}" data-title="${step.title}"></div>`;
        });
        document.querySelector('#progressbar').innerHTML = stepperHtml;

    }

    populateStepper.call();
</script>
