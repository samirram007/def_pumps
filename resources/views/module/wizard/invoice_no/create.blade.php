<form id="formInvoiceNo">
    @csrf
    <div class="modal-body bg-light p-0">
        <div class=" w-100  ">


            <section class="content">
                <div class="rounded card p-3 bg-white shadow min-h-100">
                    <div class="rounded card p-3 bg-white shadow min-h-100">

                        <div class="card-title p-0 "> {{ __('Invoice No. Update') }} for
                            {{ $office[0]['officeName'] }} </div>

                    </div>
                    <div class="rounded card p-3 bg-white shadow min-h-100 mt-4">
                        @include('module.wizard.office.info')
                        <div class="col-md-12">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="invoice_no">{{ __('Fiscal Year') }}</label>
                                        <select name="fiscalYearId" id="fiscalYearId" class="form-control">

                                            @foreach ($fiscalYear as $item)
                                                <option value="{{ $item['fiscalYearId'] }}">
                                                    {{ $item['fiscalYearName'] }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="invoice_no">{{ __('Last Invoice No') }}</label>
                                        <input type="text" class="form-control" id="invoice_no" name="invoice_no"
                                            value="{{ $invoice_no }}" placeholder="{{ __('Invoice No') }}">
                                    </div>
                                </div>


                                <div class="col-12 col-md-3 mx-auto d-flex align-items-center">
                                    <input type="hidden" name="officeId" id="officeId"
                                        value="{{ $office[0]['officeId'] }}">
                                    <button type="submit"
                                        class="submit w-100 btn btn-rounded animated-shine  px-4"><span class="iconify"
                                            data-icon="mdi:content-save-all-outline" data-width="15"
                                            data-height="15"></span>
                                        {{ __('Set') }}</button>

                                </div>

                            </div>
                            <div class="row text-center  border-top  pt-2 gap-4 ">

                                <div class="col-12  d-flex justify-content-end ">
                                    <button type="button" onclick="showOffice(wizardOfficeId)"
                                        class="  btn btn-rounded animated-shine px-4">
                                        {{ __('Office Info') }}</button>

                                    <button type="button" onclick="loadWizardGodown(wizardOfficeId)"
                                        class="  btn btn-rounded animated-shine px-4">
                                        {{ __('Godown') }}</button>
                                    <button type="button" onclick="loadCreateUser(wizardOfficeId)"
                                        class="  btn btn-rounded animated-shine px-4">
                                        {{ __('Create Pump User') }}</button>



                                </div>


                            </div>

                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>

</form>



<script>
    $(document).ready(function() {

        $("#formInvoiceNo").on("submit", function(event) {

            event.preventDefault();
            $('.submit').attr('disabled', 'disabled');
            $('.submit').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
            );
            var roleName = "{{ $roleName }}";

            var url = "{{ route('superadmin.office.store_invoice_no') }}";
            //console.info(roleName);
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
                        $('#formInvoiceNo')[0].reset();
                        $('.submit').removeAttr('disabled');
                        $('.submit').html("{{ __('Set') }}");

                    } else {
                        toastr.error(data.message);
                        $('.submit').removeAttr('disabled');
                        $('.submit').html("{{ __('Set') }}");
                    }
                },
                error: function(data) {
                    toastr.error(data.message);
                    $('.submit').removeAttr('disabled');
                    $('.submit').html("{{ __('Set') }}");
                }
            });


        });
    });
</script>

</div>
