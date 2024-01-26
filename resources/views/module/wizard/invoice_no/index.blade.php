<section class="content">
    <div class="  p-3 bg-transparent   min-h-100">

        <div class="row">


            <div class=" col-12  ">
                <div class="wizard-box scroll-box card card-primary position-relative ">


                    <div class="rounded card p-3 bg-white shadow-none  min-h-100">
                        @include('module.wizard.office.info')
                        <div id="createGodown" class="w-100    " style="border-bottom: 1px solid #2222221a;">

                            <div class=" p-2">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fiscalYearId">{{ __('Fiscal Year') }}</label>
                                                <select name="fiscalYearId" id="fiscalYearId" class="form-control">

                                                    @foreach ($fiscalYear as $item)
                                                        <option value="{{ $item['fiscalYearId'] }}">
                                                            {{ $item['fiscalYearName'] }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-6  ">
                                            <div class="form-group">

                                                <label for="invoiceNo">{{ __('First Invoice No') }}<span
                                                        class="text-danger text-lg ml-2">*</span><i
                                                        class="fas fa-info-circle   fa-lg p-c info"
                                                        data-title="{{ __('First Invoice No') }}"
                                                        data-desc="{{ __('desc.invoice_no') }}"></i></label>
                                                <input type="text" class="form-control" name="invoiceNo"
                                                    id="invoiceNo" autofocus>
                                                <span id="invoiceNoError" class="text-danger text-sm"></span>
                                            </div>
                                        </div>


                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                    <div class=" py-4 bg-white  position-absolute w-100 " style="bottom: 0">
                        <div class="row">

                            <div class="col-md-4 offset-md-4 px-4 fixed-box">

                                <a href="javascript:" onclick="handleClickStoreInvoice(this)"
                                    class="btn-invoice-store  btn   btn-rounded animated-shine  w-100 px-4">
                                    {{ __('Save & Next') }}</a>

                            </div>

                        </div>



                    </div>
                </div>
                <script>
                    $(document).ready(() => {
                        $('.info').on('click', function(e) {

                            const desc = $(this).attr('data-desc');
                            const title = $(this).attr('data-title');
                            $('#modal-tooltip').modal('show');
                            $('#modal-tooltip .desc').html(desc)
                            $('#modal-tooltip #title').html(title)
                        })





                    });
                </script>
            </div>
        </div>
    </div>

</section>
