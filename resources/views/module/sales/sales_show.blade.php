<div class="modal-dialog modal-lg  modal-dialog-centered mt-0 ">
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h4 class="modal-title text-light">{{ __('Invoice') }} : {{ $editData['invoiceNo'] }} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times-circle" style="font-size:24px; color:#fff"></i>
            </button>
        </div>
        <style>
            #formShow .card-body {
                background: #c5cdd5;
            }

            #formShow select::-ms-expand{
                display: none;

            }

            #formShow select {
                /* for Firefox */
                -moz-appearance: none;
                /* for Chrome */
                -webkit-appearance: none;
            }
            #formShow .form-control::placeholder,#formShow .text-danger  {
                color: #00000000;
                opacity: 0;
            }
        </style>
        <form id="formShow">

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
                                                    <div class="form-group ">

                                                        <label for="officeId">{{ __('Business Entity') }} <span
                                                                class="text-danger">*</span> </label>
                                                        <input type="text" class="sr-only " name="officeId"
                                                            value="{{ $editData['officeId'] }}">
                                                        <select class="form-control " name="officeId" id="officeId"
                                                            disabled>
                                                            {{-- <option value="" class="text-bold">Select Office</option> --}}
                                                            @forelse ($officeList as $tg)
                                                                <option value="{{ $tg['officeId'] }}"
                                                                    {{ $tg['officeId'] == $editData['officeId'] ? 'selected' : '' }}>
                                                                    {{ __($tg['officeName']) }}
                                                                </option>
                                                            @empty
                                                                <option value="">{{ __('No record found') }}
                                                                </option>
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3  offset-md-3 d-none">
                                                    <div class="form-group">

                                                        <label for="invoiceNo">{{ __('Invoice No') }} <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="invoiceNo"
                                                            name="invoiceNo" value="{{ $editData['invoiceNo'] }}"
                                                            placeholder="{{ __('Invoice No') }} ">
                                                    </div>
                                                </div>
                                                <div class="col-md-3  offset-md-3">
                                                    <div class="form-group">

                                                        <label for="invoiceDate">{{ __('Invoice Date') }} <span
                                                                class="text-danger">*</span></label>
                                                        <input type="date" class="form-control" id="invoiceDate"
                                                            name="invoiceDate"
                                                            value="{{ date('Y-m-d', strtotime($editData['invoiceDate'])) }}"
                                                            min="{{ date('Y-m-d', strtotime(collect(session()->get('userData'))->get('fiscalYear')['openDate'])) }}"
                                                            max="{{ date('Y-m-d') }}"
                                                            placeholder="{{ __('Enter Invoice Date') }} ">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="hidden" name="masterOfficeId" id="masterOfficeId"
                                                            value="{{ $masterOfficeId }}">
                                                        <label for="customerName">{{ __('Customer Name') }}</label>
                                                        <input type="text" class="form-control" id="customerName"
                                                            name="customerName" value="{{ $editData['customerName'] }}"
                                                            placeholder="{{ __('Enter Customer Name') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-6">
                                                    <div class="form-group">

                                                        <label for="mobileNo">{{ __('Mobile No') }}</label>
                                                        <input type="text" class="form-control" id="mobileNo"
                                                            name="mobileNo" value="{{ $editData['mobileNo'] }}"
                                                            maxLength="10"
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                            placeholder="{{ __('Enter Mobile No') }} ">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-6">
                                                    <div class="form-group">

                                                        <label for="vehicleNo">{{ __('Vehicle No') }}</label>
                                                        <input type="text" class="form-control" id="vehicleNo"
                                                            name="vehicleNo" value="{{ $editData['vehicleNo'] }}"
                                                            oninput="this.value = this.value.toUpperCase()"
                                                            placeholder="{{ __('Enter Vehicle No') }} ">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 ">
                                                    <div class="form-group">

                                                        <label for="productTypeId">{{ __('ProductType') }} <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="sr-only " name="productTypeId"
                                                            value="{{ $editData['productTypeId'] }}">

                                                        <select class="form-control " name="productTypeId"
                                                            id="productTypeId" disabled>
                                                            {{-- <option value="" class="text-bold">Select Office</option> --}}
                                                            @forelse ($productTypeList as $tg)
                                                                <option
                                                                    data-iscontainer="{{ $tg['isContainer'] == false ? 'false' : 'true' }}"
                                                                    data-rate="{{ $tg['rate'] }}"
                                                                    data-fuelrateId="{{ $tg['fuelRateId'] }}"
                                                                    data-quantity="{{ $tg['quantity'] }}"
                                                                    value="{{ $tg['productTypeId'] }}"
                                                                    {{ $tg['productTypeId'] == $editData['productTypeId'] ? 'selected' : '' }}>
                                                                    {{ __($tg['productTypeName']) }}


                                                                </option>
                                                            @empty
                                                                <option value="">{{ __('No record found') }}
                                                                </option>
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-6">
                                                    <div class="form-group">
                                                        <label for="rate">{{ __('Rate') }}{{ __('(INR)') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="sr-only" id="fuelRateId"
                                                            name="fuelRateId" value="{{ $editData['fuelRateId'] }}">
                                                        <input type="text" size="10" readonly
                                                            class="form-control" id="rate" name="rate"
                                                            oninput="this.value =  this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1') ;"
                                                            value="{{ $editData['rate'] }}"
                                                            placeholder="{{ __('Enter Rate') }}">
                                                    </div>
                                                </div>


                                                <div class="col-md-3 col-6">
                                                    <div class="form-group">
                                                        <label for="quantity">{{ __('Quantity') }} <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" size="10" class="form-control"
                                                            id="quantity" name="quantity"
                                                            {{ $editData['isContainer'] ? 'readonly' : '' }}
                                                            value="{{ $editData['quantity'] }}"
                                                            oninput="this.value =this.value.replace(/[^0-9.]/g, '').replace(/^([0-9]*\.[0-9]{0,3}).*/,'$1');"
                                                            placeholder="{{ __('Enter Quantity') }}">
                                                    </div>
                                                </div>

                                                {{-- oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" --}}
                                                <div class="col-md-3 col-6 ">
                                                    <div class="form-group">
                                                        <label
                                                            for="discount">{{ __('Discount') }}{{ __('(INR)') }}</label>
                                                        <input type="text" size="10" class="form-control"
                                                            id="discount" name="discount"
                                                            value="{{ $editData['discount'] }}"
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/^([0-9]*\.[0-9]{0,2}).*/,'$1');"
                                                            placeholder="{{ __('Enter Discount') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-6">
                                                    <div class="form-group">
                                                        <label for="total">{{ __('Total') }}{{ __('(INR)') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" size="10" readonly
                                                            class="form-control" id="total" name="total"
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                            value="{{ $editData['total'] }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-6 ">
                                                    <div class="form-group">

                                                        <label for="paymentModeId">{{ __('PaymentMode') }} <span
                                                                class="text-danger">*</span></label>

                                                        <select class="form-control " name="paymentModeId"
                                                            id="paymentModeId">
                                                            {{-- <option value="" class="text-bold">Select Office</option> --}}
                                                            @forelse ($paymentMode as $tg)
                                                                <option value="{{ $tg['paymentModeId'] }}"
                                                                    {{ $tg['paymentModeId'] == $editData['paymentModeId'] ? 'selected' : '' }}>
                                                                    {{ __($tg['paymentModeName']) }}
                                                                </option>
                                                            @empty
                                                                <option value="">{{ __('No record found') }}
                                                                </option>
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="comment">{{ __('Comment') }}</label>
                                                        <textarea class="form-control" rows="1" id="comment" name="comment"
                                                            placeholder="{{ __('Enter Comment') }}">{{ $editData['comment'] }}</textarea>

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
    <script>
        // setEnvWithRate(1);
        var routeRole = "{{ $routeRole }}";
        var loadQuantity = "{{ $editData['quantity'] }}";

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
                $("#quantity").val(loadQuantity);
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
            if (routeRole == 'pumpadmin') {
                url = "{{ route('pumpadmin.productType.getEnv', ':id') }}";
            }
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
                    //console.log(data);
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
            if (routeRole == 'pumpadmin') {
                url = "{{ route('pumpadmin.productType.getRate', ':id') }}";
            }
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
                    // console.log(data);
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
        $(document).ready(function() {

            $('#formShow input,#formShow select, #formShow textarea').attr('readonly', true);
            $('#formShow input, #formShow select, #formShow textarea').attr('disabled', true);



            //  $("#officeId").select2();
            $("#customerName").focus();

            $('#invoiceDate').on('change', function() {
                setTimeout(() => {
                    $("#officeId").change();
                }, 500);

            });
            $("#officeId").change(function() {
                // alert();
                var officeId = $('#officeId').val();
                var invoiceDate = $('#invoiceDate').val();
                var url = "{{ route($routeRole . '.productType_by_office_id', [':id', ':date']) }}";
                // if(routeRole == 'pumpadmin'){
                //     url = "{{ route('pumpadmin.productType_by_office_id', ':id') }}";
                // }
                url = url.replace(':id', officeId);
                url = url.replace(':date', invoiceDate);
                console.log(url);
                $.ajax({
                        type: "GET",
                        url: url,
                        dataType: "json",
                        encode: true,
                    })
                    .done(function(data) {

                        if (!data) {

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
                            //console.log(data);
                            $('#productTypeId').empty();
                            $('#quantity').val(loadQuantity);
                            // $('#productTypeId').append('<option value="">Select Product Type</option>');
                            //console.log(data.response);
                            var pTypeid = 0;
                            $.each(data.response, function(key, value) {
                                //console.log(eval(value));
                                if (pTypeid == 0) {
                                    pTypeid = value.productTypeId;
                                }

                                $('#productTypeId').append('<option value="' + value
                                    .productTypeId +
                                    '" data-iscontainer="' + value.isContainer +
                                    '" data-fuelrateid="' + value.fuelRateId +
                                    '" data-rate="' + value.rate + '" data-quantity="' +
                                    value.quantity + '">' + value.productTypeName +
                                    '</option>');
                            });
                            setEnvWithRate(pTypeid)

                        }
                    });
            });






            // $('#formCreate').submit();
            $('#discount').on('keyup', function() {
                var productTypeId = $('#productTypeId').val();
                //getRate(productTypeId);
                var quantity = $('#quantity').val();
                var rate = $('#rate').val();
                var discount = $(this).val();
                var total = (quantity * rate) - discount;
                total = Number.isNaN(total) ? 0 : total;
                $('#total').val(total == 0 ? '' : total.toFixed(2));
            });
            $('#quantity').on('keyup', function() {
                var productTypeId = $('#productTypeId').val();
                //getRate(productTypeId);
                var quantity = $(this).val();
                var rate = $('#rate').val();
                $('#discount').val() == '' ? '0' : $('#discount').val();
                var discount = $('#discount').val();
                var total = (quantity * rate) - discount;
                total = Number.isNaN(total) ? 0 : total;
                $('#total').val(total == 0 ? '' : total.toFixed(2));
            });
            $("#productTypeId").change(function() {
                var productTypeId = $(this).val();
                setEnvWithRate(productTypeId);
                //setEnv(productTypeId);
                //getRate(productTypeId);

            });


        });
    </script>
</div>
