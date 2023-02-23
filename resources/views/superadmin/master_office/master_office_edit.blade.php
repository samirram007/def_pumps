<div class="modal-dialog modal-lg  modal-dialog-centered mt-0">
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h4 class="modal-title text-light">{{ __('Edit Top Company') }} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @include('module.office.office_edit')
    </div>
    <script>
        $(document).ready(function() {
            // $('#formCreate').submit();
            $("#formCreate").on("submit", function(event) {
                event.preventDefault();
                //spenner
                $('.submit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                const url = "{{ route('superadmin.master_office.update', $editData->officeId) }}";
                var serializeData = $(this).serialize();
                console.log(url);
                //  var formData = {
                //      name: $("#name").val(),
                //      email: $("#email").val(),
                //      superheroAlias: $("#superheroAlias").val(),
                //  };

                $.ajax({
                    type: "POST",
                    url: url,
                    _token: "{{ csrf_token() }}",
                    data: serializeData,
                    dataType: "json",
                    encode: true,
                }).done(function(data) {
                    if (!data.status) {
                        console.log(data.errors);
                        $.each(data.errors, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).next().text(value);
                            toastr.error(value);
                        });

                        $('.submit').html('Save');
                    } else {
                        toastr.success(data.message);
                        window.location.href = "{{ route('superadmin.master_office.index') }}";
                    }
                }).fail(function(data) {
                    toastr.error(data.message);
                    $('.submit').html('Save');
                });


            });
        });
    </script>
</div>
