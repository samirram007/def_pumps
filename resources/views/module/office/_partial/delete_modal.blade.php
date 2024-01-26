<div class="modal fade" id="modal-delete" role="tooltip" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md  modal-dialog-center ">
        <div class="modal-content" style="min-height: 30vh">
            <div class="modal-header bg-transparent    text-dark">
                <h3 class="modal-title text-info px-2 ">{{ __('Are you sure?') }} </h3>
                <button type="button" class="close d-none" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times-circle " style="font-size:24px; color:#cac3c3"></i>
                </button>
            </div>

            <div class=" modal-body bg-transparent py-2 px-2">
                <div class="h6 px-4 py-2 text-gray" id="title"></div>
                <div id="formofficeDelete" class="row m-0 border-bottom  ">
                    <input class="sr-only " type="text" name="officeId" id="officeId">

                </div>

                <div id="listPayload" class="w-100 mt-2 px-4 text-secondary">

                    {{ __('desc.delete_message') }}

                </div>
            </div>
            <div class="modal-footer bg-transparent py-1 px-1">
                <div class="row w-100 mx-0">


                    <div class="col-12 d-flex justify-content-end  " style="gap:20px;">
                        <button type="button"
                            class="remove_office btn btn-info animated-shine btn-sm">{{ __('Confirm') }}</button>
                        <button type="button" class="btn btn-primary animated-shine btn-sm" data-dismiss="modal"
                            aria-label="Close">
                            {{ __('desc.close') }}</i>
                        </button>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <form id="formDelete">
        @csrf
    </form>
</div>
<script>
    $('.remove_office').on('click', (el) => {
        // console.log(el.target.innerHTML);
        var officeId = $('#formofficeDelete #officeId').val();
        var thisHTML = el.target.innerHTML;
        el.target.classList.add("pe-none")
        //el.preventDefault();
        el.target.innerHTML =
            `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting ... `
        // return;
        const url = "{{ route('companyadmin.office.destroy') }}";

        var formData = new FormData($('#formDelete')[0])

        formData.append('officeId', officeId);
        //console.log(formData, officeId);

        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            dataType: "json",
            encode: true,
            processData: false, // don't process the data
            contentType: false, // set content type to false as jQuery will tell the server its a query string request
        }).done(function(data) {
            el.target.innerHTML = thisHTML
            if (!data.status) {
                //console.log(data.errors);
                $.each(data.errors, function(key, value) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).next().text(value);
                    toastr.error(value);
                });
                el.target.classList.remove("pe-none")

            } else {

                toastr.success(data.message);
                el.target.innerHTML =
                    `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting ... `
                setTimeout(() => {
                    location.reload();
                }, 2500);

            }
        }).fail(function(data) {
            el.target.innerHTML = thisHTML
            el.target.classList.remove("pe-none")
            toastr.error(data.error);

        });



        // populateOfficeList()

    });
</script>
<style>
    #modal-delete {
        background-color: #ffffff0e;
        background-image: linear-gradient(to right, #f7b9c813, #a7b5fb13);
    }

    /* #stock .modal-dialog {
        background-color: #ffffffc9;
        background-image: linear-gradient(to right, #f7b9c8, #a7b5fb);
    } */
    #modal-delete .modal-dialog {
        background-color: #fffffff6;
        /* background-image: linear-gradient(to right, #5badec, #5fdef8); */
        /* background-image: linear-gradient(-22deg, #5badec 21%, #1daeb3); */
        /* background-image: linear-gradient(-22deg, #5badec 21%, #1daeb3); */
    }

    #modal-delete .modal-content {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        width: 100%;
        pointer-events: auto;
        background-color: #fff0;
        background-clip: padding-box;
        border: 0px solid rgba(0, 0, 0, .2);
        border-radius: .3rem;
        outline: 0;
    }

    #modal-delete .modal-header {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: start;
        align-items: flex-start;
        -ms-flex-pack: justify;
        justify-content: space-between;
        padding: 1rem;
        border-bottom: 1px solid #881ab37d;
        border-top-left-radius: .3rem;
        border-top-right-radius: .3rem;
        box-shadow: 1px 5px 9px 0px #574545;
    }

    #modal-delete .btn-primary {
        color: #fff;
        background-color: #536ec94a;
        border-color: #c7c7d9a1;
    }

    #modal-delete .btn-primary:hover {
        color: #fff;
        background-color: rgb(93, 162, 235);
        border-color: #005cbf;
    }

    #modal-delete .btn-primary:not(:disabled):not(.disabled).active,
    #modal-delete .btn-primary:not(:disabled):not(.disabled):active,
    #modal-delete .show>.btn-primary.dropdown-toggle {
        color: #fff;
        background-color: rgb(61, 144, 233)a8;
        border-color: #005cbf;
    }
</style>
