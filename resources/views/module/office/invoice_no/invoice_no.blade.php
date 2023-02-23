<div class="modal-dialog modal-lg modal-dialog-centered mt-0">
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h4 class="modal-title text-light">{{ __('Invoice No. Update') }} </h4>
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

                                <h3 class="card-title  "> {{ __('Invoice No. Update') }} for
                                    {{ $office[0]['officeName'] }} </h3>

                            </div>
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="card card-primary">

                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="invoice_no">{{ __('Fiscal Year') }}</label>
                                                        <select name="fiscalYearId" id="fiscalYearId"
                                                            class="form-control">

                                                            @foreach ($fiscalYear as $item)
                                                                <option value="{{ $item['fiscalYearId'] }}">
                                                                    {{ $item['fiscalYearName'] }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="invoice_no">{{ __('Last Invoice No') }}</label>
                                                        <input type="text" class="form-control" id="invoice_no"
                                                            name="invoice_no" value="{{ $invoice_no }}"
                                                            placeholder="{{ __('Invoice No') }}">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row text-center">
                                                <div class="col-6 mx-auto">
                                                    <input type="hidden" name="officeId" id="officeId"
                                                        value="{{ $office[0]['officeId'] }}">
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
                $('.submit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
                var roleName = "{{ $roleName }}";

                var url = "{{ route('superadmin.office.store_invoice_no') }}";
                if (roleName == 'companyadmin') {
                    url = "{{ route('companyadmin.office.store_invoice_no') }}";
                }
                // const url = "{{ route('companyadmin.office.store_invoice_no') }}";
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
                            location.reload();
                        } else {
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
