<div class="modal-dialog modal-lg  modal-dialog-centered mt-0">
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h4 class="modal-title text-light">{{ __('Add Business Entity') }} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @include('module.office.office_create')
    </div>
    <script>
        $(document).ready(function() {
            // $('#formCreate').submit();
            $("#formCreate").on("submit", function(event) {

                event.preventDefault();
                //spinner
                $('.submit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ');
                const url = "{{ route('companyadmin.office.store') }}";
                var serializeData = $(this).serialize();


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
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.errors.responseJSON,
                            footer: '<a href>Why do I have this issue?</a>'
                        });
                        $('.submit').html('Save');
                    } else {
                        location.reload();
                    }
                }).fail(function(data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.error,
                        footer: '<a href>Why do I have this issue?</a>'
                    })
                    console.log(data);
                    $('.submit').html('Save');
                });


            });
        });
    </script>
</div>
