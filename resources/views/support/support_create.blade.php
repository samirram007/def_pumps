<div class="modal-dialog modal-md modal-dialog-centered mt-0">
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h4 class="modal-title text-light">{{ __('Create New Ticket') }} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="formCreate">
            @csrf
            <div class="modal-body bg-light p-0" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1000">
                <div class=" w-100  ">


                    <section class="content">
                        <div class="rounded card p-3 bg-white shadow min-h-100">
                            <div class="row mx-auto">


                            </div>
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="card card-primary">

                                        <div class="card-body">

                                            <div class="row">

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="title">{{ __('Subject') }}</label>
                                                        <input type="text" class="form-control" id="title"
                                                            name="title" value=" "
                                                            placeholder="{{ __('Subject') }}">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row text-center">
                                                <div class="col-6 mx-auto">

                                                    <button type="submit"
                                                        class="submit btn btn-rounded animated-shine  px-4"><span
                                                            class="iconify" data-icon="mdi:content-save-all-outline"
                                                            data-width="15" data-height="15"></span>
                                                        {{ __('Save') }}</button>

                                                </div>
                                                <div class="col-6 mx-auto">
                                                    <button type="button"
                                                        class=" btn btn-rounded animated-shine-danger px-4"
                                                        data-dismiss="modal">{{ __('Cancel') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

        </form>
    </div>
    @php
        $roleName = Session::get('roleName');

    @endphp

    <script>
        //  $(document).ready(function() {
        //      $('#roleName').select2({
        //          placeholder: "Select Role",
        //          allowClear: true
        //      });
        //      $('#officeId').select2({
        //          placeholder: "Select Office",
        //          allowClear: true
        //      });
        //  });
    </script>

    <script>
        $(document).ready(function() {
            // $('#formCreate').submit();
            $("#formCreate").on("submit", function(event) {

                event.preventDefault();
                $('.submit').attr('disabled', 'disabled');
                $('.submit').html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                    );
                var roleName = "{{ $roleName }}";

                var url = "{{ route('store.support') }}";
                var serializeData = $(this).serialize();

                //console.log(serializeData);
                $.ajax({
                    url: url,
                    type: "POST",
                    data: serializeData,
                    success: function(data) {
                        if (data.status == true) {
                            toastr.success(data.message);
                            $('#formCreate')[0].reset();
                            $("#modal-popup").html('');
                            $("#modal-popup").modal('hide');
                            //ChatBody(data.id);
                            $('#searchPanel').hide();
                            $('#detailsPanel').html(data.html);
                            $('#detailsPanel').show();
                            // location.reload();
                        } else {
                            $.each(data.errors, function(key, value) {
                             $('#' + key).addClass('is-invalid');
                             $('#' + key).next().text(value);
                             toastr.error(value);
                         });

                            toastr.error(data.message);
                            $('.submit').removeAttr('disabled');
                            $('.submit').html("{{ __('Save') }}");
                        }
                    },
                    error: function(data) {
                        toastr.error(data.message);
                        $('.submit').removeAttr('disabled');
                        $('.submit').html("{{ __('Save') }}");
                    }
                });


            });
        });
    </script>

</div>
