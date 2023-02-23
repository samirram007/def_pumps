<div class="modal-dialog modal-lg  modal-dialog-centered mt-0 ">
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h4 class="modal-title text-light">{{ __('New Expense Voucher') }} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="formCreate" enctype="multipart/form-data">
            @csrf
            <div class="modal-body bg-light p-0" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1000">
                <div class=" w-100  ">
                    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}

                    <section class="content">
                        <div class="rounded card p-3 bg-white shadow min-h-100">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-primary">


                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <div class="form-group">

                                                        <label for="officeId">{{ __('Business Entity') }}  <span class="text-danger">*</span></label>

                                                        <select class="form-control " name="officeId" id="officeId">
                                                            {{-- <option value="" class="text-bold">Select Office</option> --}}
                                                            @forelse ($officeList as $tg)
                                                                <option value="{{ $tg['officeId'] }}">
                                                                    {{ __($tg['officeName']) }}
                                                                </option>
                                                            @empty
                                                                <option value="">{{__('No record found')}} </option>
                                                            @endforelse
                                                        </select>
                                                        <input type="hidden" name="masterOfficeId" id="masterOfficeId"
                                                            value="{{ $masterOfficeId }}">
                                                    </div>
                                                    <script>
                                                        var officeId_filter=$('#officeId_filter').val();
                                                         $('#officeId').val(officeId_filter);
                                                    </script>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="voucherNo">{{ __('Voucher No') }}</label>
                                                        <input type="text"  class="form-control"
                                                            id="voucherNo" name="voucherNo"
                                                            value="{{ old('voucherNo') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="voucherDate">{{ __('Voucher Date') }} <span class="text-danger">*</span></label>
                                                        <input type="date" required class="form-control"
                                                            id="voucherDate" name="voucherDate"
                                                            value="{{ old('voucherDate') == null ? date('Y-m-d') : old('voucherDate') }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="particulars">{{ __('Particulars') }} <span class="text-danger">*</span></label>
                                                        <textarea class="form-control" rows="1" id="particulars" name="particulars" placeholder="{{__('Enter particulars')}}">{{ old('particulars') }}</textarea>

                                                    </div>
                                                </div>




                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="amount">{{ __('Amount') }}{{__('(INR)')}} <span class="text-danger">*</span></label>
                                                        <input type="text" size="10"
                                                            class="form-control" id="amount" name="amount"
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/^([0-9]*\.[0-9]{0,2}).*/,'$1');"
                                                            value="{{ old('amount') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group d-none">
                                                        <label for="image">{{ __('image') }}</label>
                                                        <input class="form-control" type="file" name="image"
                                                            id="image">

                                                    </div>
                                                </div>



                                            </div>
                                            <div class="row text-center">
                                                <div class="col-6 mx-auto">
                                                    <button type="submit"
                                                        class="submit btn btn-rounded animated-shine px-4"><span
                                                            class="iconify" data-icon="mdi:content-save-all-outline"
                                                            data-width="15" data-height="15"></span>
                                                        {{ __('Save') }}</button>

                                                </div>
                                                <div class="col-6 mx-auto">
                                                    <button type="button"
                                                        class=" btn btn-rounded animated-shine-danger px-4"
                                                        data-dismiss="modal">{{__('Cancel')}}</button>
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
    <script>
        setEnvWithRate(1);
        var routeRole = "{{ $routeRole }}";
        function setEnvWithRate(productTypeId) {
            // console.log(productTypeId);
            var isContainer = $("#productTypeId").find(':selected').attr('data-iscontainer');
            var rate = $("#productTypeId").find(':selected').attr('data-rate');
            var fuelRateId = $("#productTypeId").find(':selected').attr('data-fuelrateid');
            var quantity = $("#productTypeId").find(':selected').attr('data-quantity');

            $("#rate").val(rate);
            $("#fuelRateId").val(fuelRateId);
            if (isContainer == 'true') {
                // console.log(isContainer);
                isContainer = true;
                // console.log(isContainer);
            } else {
                isContainer = false;
            }
            if (!isContainer) {
                $("#quantity").val('');
                $("#quantity").attr('readonly', false);


            } else {
                $("#quantity").val(quantity);
                $("#quantity").attr('readonly', true);

            }
            CalculateTotal();
        }

        function CalculateTotal() {
            $('#quantity').val() == '' ? '0' : $('#quantity').val();
            var quantity = $("#quantity").val();
            $('#rate').val() == '' ? '0' : $('#quantiratety').val();
            var rate = $('#rate').val();
            $('#discount').val() == '' ? '0' : $('#discount').val();
            var discount = $('#discount').val();
            var total = (quantity * rate) - discount;
            total = Number.isNaN(total) ? 0 : total;
            $('#total').val(total == 0 ? '' : total.toFixed(2));
        }
        // setEnv(1);
        // getRate(1);
        function setEnv(productTypeId) {
            var url = "{{ route('companyadmin.productType.getEnv', ':id') }}";
            url = url.replace(':id', productTypeId);
            $('#total').val('');
            //console.log(url);
            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                encode: true,
            }).done(function(data) {

                if (!data) {

                    //console.log(data.errors);
                    $.each(data.errors, function(key, value) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).next().text(value);
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                    })
                } else {
                    console.log(data);
                    var isContainer = data.isContainer;
                    if (isContainer == true) {
                        $("#quantity").val(data.quantity);
                        $("#quantity").attr('readonly', true);
                    } else {
                        $("#quantity").attr('readonly', false);
                    }
                    // $('#fuelRateId').val(data.fuelRateId);
                    //$('#rate').val(data.rate);
                    // $('#quantity').val(data.quantity);
                    // $('#discount').val(data.discount);
                    // $('#total').val(data.total);
                    // $('#comment').val(data.comment);
                }
            });
        }

        function getRate(productTypeId) {
            var url = "{{ route('companyadmin.productType.getRate', ':id') }}";
            url = url.replace(':id', productTypeId);
            $('#total').val('');
            //console.log(url);
            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                encode: true,
            }).done(function(data) {

                if (!data) {

                    //console.log(data.errors);
                    $.each(data.errors, function(key, value) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).next().text(value);
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                    })
                } else {
                    console.log(data);
                    $('#rate').val(data.rate);
                    $('#fuelRateId').val(data.fuelRateId);
                    $('#discount').val() == '' ? '0' : $('#discount').val();
                    var discount = $('#discount').val();

                    var total = ($('#quantity').val() * data.rate) - discount;

                    total = Number.isNaN(total) ? 0 : total;
                    $('#total').val(total == 0 ? '' : total.toFixed(2));


                }
            });
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $("#officeId").select2();


            $("#formCreate").on("submit", function(event) {

                event.preventDefault();
                $('.submit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ');
                var url = "{{ route($routeRole.'.expense.store') }}";

                var formData = new FormData($(this)[0]);

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    processData: false, // don't process the data
                    contentType: false, // set content type to false as jQuery will tell the server its a query string request
                }).done(function(data) {
                    if (!data.status) {

                            $('.submit').attr('disabled', false);
                            $('.submit').html('Submit');
                            $.each(data.errors, function(key, value) {
                                $('#' + key).addClass('is-invalid');
                                $('#' + key).next().text(value);
                                toastr.error(value);
                            });
                            $('.submit').attr('disabled', false);
                            $('.submit').html('Save');
                    } else {
                        setTimeout(() => {
                            $('.search').click();
                            $('.close').click();
                            toastr.success(data.message);
                        }, 1000);
                    }
                }).fail(function(data) {

                        $('.submit').attr('disabled', false);
                        $('.submit').html('Submit');
                        toastr.error(data.message);

                    // console.log(data);
                });

                // };
                // reader.readAsText(file);
            });
        });
    </script>
</div>
