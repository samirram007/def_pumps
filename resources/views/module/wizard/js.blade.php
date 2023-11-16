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
