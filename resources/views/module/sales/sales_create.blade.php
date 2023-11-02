<div class="modal-dialog modal-lg  modal-dialog-centered mt-0 ">
    <div class="loader"></div>
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h4 class="modal-title text-light" id="title">{{ __('New Invoice') }} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times-circle" style="font-size:24px; color:#fff"></i>
            </button>
        </div>
        <form id="formCreate">
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

                                                        <label for="officeId">{{ __('Business Entity') }} <span
                                                                class="text-danger">*</span> </label>

                                                        <select class="form-control " name="officeId" id="officeId">
                                                            {{-- <option value="" class="text-bold">Select Office</option> --}}
                                                            @forelse ($officeList as $tg)
                                                                <option value="{{ $tg['officeId'] }}">
                                                                    {{ __($tg['officeName']) }}
                                                                </option>
                                                            @empty
                                                                <option value="">{{ __('No record found') }}
                                                                </option>
                                                            @endforelse
                                                        </select>
                                                    </div>

                                                </div>

                                                <div class="col-md-3 offset-md-3 ">
                                                    <div class="form-group">

                                                        <label for="invoiceDate">{{ __('Invoice Date') }} <span
                                                                class="text-danger">*</span></label>
                                                        {{-- <input type="date" class="form-control" id="invoiceDate"
                                                            name="invoiceDate" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d', strtotime(collect(session()->get('userData'))->get('fiscalYear')['openDate'])) }}" max="{{ date('Y-m-d') }}"
                                                            placeholder="{{__('Enter Invoice Date')}} "> --}}
                                                        <input type="date" class="form-control" id="invoiceDate"
                                                            name="invoiceDate" value="{{ date('Y-m-d') }}"
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
                                                            name="customerName" value="{{ old('customerName') }}"
                                                            placeholder="{{ __('Enter Customer Name') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-6">
                                                    <div class="form-group">

                                                        <label for="mobileNo">{{ __('Mobile No') }}</label>
                                                        <input type="text" class="form-control" id="mobileNo"
                                                            name="mobileNo" value="{{ old('mobileNo') }}"
                                                            maxLength="10"
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                            placeholder="{{ __('Enter Mobile No') }} ">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-6">
                                                    <div class="form-group">

                                                        <label for="vehicleNo">{{ __('Vehicle No') }}</label>
                                                        <input type="text" class="form-control" id="vehicleNo"
                                                            name="vehicleNo" value="{{ old('vehicleNo') }}"
                                                            oninput="this.value = this.value.toUpperCase()"
                                                            placeholder="{{ __('Enter Vehicle No') }} ">
                                                    </div>
                                                </div>

                                                <div class="col-md-3 col-6 sr-only">
                                                    <div class="form-group">
                                                        <label for="businessTaxTypeId">{{ __('Sales Type') }} <span
                                                                class="text-danger">*</span> </label>
                                                        <select class="form-control " name="businessTaxTypeId"
                                                            id="businessTaxTypeId">
                                                            {{-- <option value="" class="text-bold">Select Office</option> --}}
                                                            @forelse ($businessTaxTypes as $tg)
                                                                <option value="{{ $tg['businessTaxTypeId'] }}"
                                                                    data-docrequired="{{ $tg['isDocRequired'] }}"
                                                                    {{ $tg['businessTaxTypeId'] == 3 ? 'selected' : '' }}>
                                                                    {{ __($tg['businessTaxTypeName']) }}
                                                                </option>
                                                            @empty
                                                                <option value="">{{ __('No record found') }}
                                                                </option>
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 col-6 sr-only">
                                                    <div class="form-group">

                                                        <label for="submittedDocumentNo"
                                                            id="DocNoLabel">{{ __('Document No') }}</label>
                                                        <input type="text" class="form-control"
                                                            id="submittedDocumentNo" name="submittedDocumentNo" readonly
                                                            value="{{ old('submittedDocumentNo') }}"
                                                            oninput="this.value = this.value.toUpperCase()"
                                                            placeholder="{{ __('') }} ">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">

                                                        <label for="productTypeId">{{ __('ProductType') }} <span
                                                                class="text-danger">*</span></label>

                                                        <select class="form-control " name="productTypeId"
                                                            id="productTypeId">
                                                            {{-- <option value="" class="text-bold">Select Office</option> --}}
                                                            @forelse ($productTypeList as $tg)
                                                                <option
                                                                    data-iscontainer="{{ $tg['isContainer'] == false ? 'false' : 'true' }}"
                                                                    data-rate="{{ $tg['rate'] }}"
                                                                    data-fuelrateId="{{ $tg['fuelRateId'] }}"
                                                                    data-quantity="{{ $tg['quantity'] }}"
                                                                    data-primaryunitid="{{ $tg['primaryUnitId'] }}"
                                                                    data-primaryunitname="{{ $tg['primaryUnitName'] }}"
                                                                    data-primaryunitshortname="{{ $tg['primaryUnitShortName'] }}"
                                                                    data-primaryunitsingularshortname="{{ $tg['primaryUnitSingularShortName'] }}"
                                                                    value="{{ $tg['productTypeId'] }}">
                                                                    {{ __($tg['productTypeName']) }}
                                                                    {{ isset($tg['secondaryUnitId']) ? '(' . $tg['quantity'] . ' ' . $tg['secondaryUnitShortName'] . ')' : '' }}
                                                                </option>
                                                            @empty
                                                                <option value="">{{ __('No record found') }}
                                                                </option>
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3  ">
                                                    <div class="form-group">
                                                        <label for="godownId">{{ __('Godown') }}<span
                                                                class="text-danger">*</span>
                                                        </label>
                                                        <select class="form-control " name="godownId" id="godownId">
                                                            {{-- <option value="" class="text-bold">Select Office</option> --}}
                                                            @forelse ($godownList as $tg)
                                                                <option value="{{ $tg['godownId'] }}"
                                                                    data-isstorage="{{ $tg['isReserver'] == 1 ? '1' : '0' }}">
                                                                    {{ __($tg['godownName']) }}
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
                                                        <label for="currentStock">{{ __('Current Stock') }} <span
                                                                class="unit-short-name">{{ __('(ltr)') }}</span>
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" size="10" readonly
                                                            class="form-control" id="currentStock"
                                                            name="currentStock"
                                                            oninput="this.value =  this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1') ;"
                                                            value="{{ old('currentStock') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-6">
                                                    <div class="form-group">
                                                        <label for="rate">{{ __('Rate') }}{{ __('(INR)') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="sr-only" id="fuelRateId"
                                                            name="fuelRateId" value="{{ old('fuelRateId') }}">
                                                        <input type="text" size="10" readonly
                                                            class="form-control" id="rate" name="rate"
                                                            oninput="this.value =  this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1') ;"
                                                            value="{{ old('rate') }}"
                                                            placeholder="{{ __('Enter Rate') }}">
                                                    </div>
                                                </div>


                                                <div class="col-md-3 col-6">
                                                    <div class="form-group">
                                                        <label for="quantity">{{ __('Quantity') }} <span
                                                                class="unit-short-name">{{ __('(ltr)') }}</span><span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" size="10" class="form-control"
                                                            id="quantity" name="quantity"
                                                            value="{{ old('quantity') }}"
                                                            oninput="this.value =this.value.replace(/[^0-9.]/g, '').replace(/^([0-9]*\.[0-9]{0,3}).*/,'$1');"
                                                            placeholder="{{ __('Enter Quantity') }}">
                                                        <span id="secondaryQuantity"></span>
                                                    </div>
                                                </div>
                                                {{-- oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" --}}
                                                <div class="col-md-3 col-6 ">
                                                    <div class="form-group">
                                                        <label
                                                            for="discount">{{ __('Discount') }}{{ __('(INR)') }}</label>
                                                        <input type="text" size="10" class="form-control"
                                                            id="discount" name="discount"
                                                            value="{{ old('discount') }}"
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
                                                            value="{{ old('total') }}">
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
                                                                <option value="{{ $tg['paymentModeId'] }}">
                                                                    {{ __($tg['paymentModeName']) }}
                                                                </option>
                                                            @empty
                                                                <option value="">{{ __('No record found') }}
                                                                </option>
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <label for="comment">{{ __('Comment') }}</label>
                                                        <textarea class="form-control color-y" rows="1" id="comment" name="comment"
                                                            placeholder="{{ __('Enter Comment') }}">{{ old('comment') }}</textarea>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row text-center">
                                                <div class="col-6 mx-auto">
                                                    {{-- <input type="text" id="salesId" class="sr-only"
                                                        value="0"> --}}
                                                    <button type="submit"
                                                        class="submit btn btn-rounded animated-shine px-4"><span
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
                    </section>
                </div>
            </div>

        </form>
        {{-- <input type="text" class="sr-only" id="edit_data" data-editdata="{{ json_encode($editData, true) }}"> --}}
    </div>
    <style scoped>
        .color-y {
            background: #f7efc5;
            border: 1px solid #e9dfae;
        }

        .color-y:focus {
            background: #f7ecb8;
            border: 2px solid #cec492;
            outline: 2px solid transparent;
            box-shadow: none;
        }

        #secondaryQuantity {
            font-size: 12px;
            font-weight: 600;
            color: #6c757d;
            padding: 2px 0 0 12px;
        }

        .loader {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 12px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 100px;
            height: 100px;
            background: #22222262;
            -webkit-animation: spin 4s linear infinite;
            /* Safari */
            animation: spin 4s linear infinite;
            z-index: 9999;
        }

        @keyframes spin() {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>


</div>


<script>
    // setEnvWithRate(1);
    var routeRole = "{{ $routeRole }}";


    function setEnvWithRate(productTypeId) {
        // console.log(productTypeId);
        var isContainer = $("#productTypeId").find(':selected').attr('data-iscontainer');
        var rate = $("#productTypeId").find(':selected').attr('data-rate');
        var fuelRateId = $("#productTypeId").find(':selected').attr('data-fuelrateid');
        var quantity = $("#productTypeId").find(':selected').attr('data-quantity');
        var primaryUnitName = $("#productTypeId").find(':selected').attr('data-primaryunitname');
        var primaryUnitShortName = $("#productTypeId").find(':selected').attr('data-primaryunitshortname');
        var primaryUnitSingularShortName = $("#productTypeId").find(':selected').attr(
            'data-primaryunitsingularshortname');
        var useSecondaryUnit = $("#productTypeId").find(':selected').attr('data-usesecondaryunit');
        var secondaryUnitShortName = $("#productTypeId").find(':selected').attr('data-secondaryunitshortname');
        var secondaryUnitRatio = $("#productTypeId").find(':selected').attr('data-secondaryunitratio');

        $('.unit-short-name').html(' (' + primaryUnitShortName + ')');
        $("#rate").val(rate);
        $("#fuelRateId").val(fuelRateId);
        if (isContainer == 'true') {
            // console.log(isContainer);
            isContainer = true;
            // console.log(isContainer);
        } else {
            isContainer = false;
        }
        // if (!isContainer) {
        //     //$("#quantity").val('');
        //     $("#quantity").attr('readonly', false);


        // } else {
        //     // $("#quantity").val(quantity);
        //     $("#quantity").attr('readonly', false);

        // }
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
                    toastr.error(value);
                });

            } else {
                console.log(data);
                var isContainer = data.isContainer;
                if (isContainer == true) {
                    $("#quantity").val(data.quantity);
                    $("#quantity").attr('readonly', false);
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
    $(document).ready(function() {
        $("#officeId").select2();
        $("#godownId").select2();
        $("#customerName").focus();
        var officeId_filter = $('#officeId_filter').val();
        $('#officeId').val(officeId_filter);
        setTimeout(() => {
            $("#officeId").change();
        }, 100);
        $('#invoiceDate').on('change', function() {
            setTimeout(() => {
                $("#officeId").change();
            }, 100);

        });
        let oldDocNo = '';
        $("#salesTypeId").change(function() {
            var salesTypeId = $('#salesTypeId').val();
            var docRequired = $(this).children("option:selected").attr('data-docrequired');
            var textValue = $(this).children("option:selected").html();
            textValue = textValue.replace('Based', 'No').trim();
            oldDocNo = $('#submittedDocumentNo').val().length > 0 ? $('#submittedDocumentNo')
                .val() : oldDocNo;
            //console.log(oldDocNo);
            if (docRequired) {
                $('#submittedDocumentNo').attr('readonly', false);
                $('#submittedDocumentNo').val(oldDocNo);
                $('#submittedDocumentNo').attr('placeholder', textValue);
                $('#DocNoLabel').html(textValue + '<span class="text-danger">*</span>');
            } else {
                $('#submittedDocumentNo').attr('readonly', true);
                $('#submittedDocumentNo').attr('placeholder', '');
                $('#submittedDocumentNo').val('');
                $('#DocNoLabel').html('Document No');
            }

        });
        $("#officeId").change(function() {
            // alert();
            var officeId = $('#officeId').val();
            var invoiceDate = $('#invoiceDate').val();
            var url = "{{ route($routeRole . '.productType_by_office_id', [':id', ':date']) }}";

            url = url.replace(':id', officeId);
            url = url.replace(':date', invoiceDate);
            //console.log(url);

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
                        // $('#quantity').val('');
                        // $('#productTypeId').append('<option value="">Select Product Type</option>');
                        //console.log(data.response);
                        var pTypeid = 0;
                        //console.log(data.response);
                        var item_title = '';
                        var item_rate = '';
                        var title_length = 0;
                        $.each(data.response, function(key, value) {
                            //console.log(eval(value));
                            if (pTypeid == 0) {
                                pTypeid = value.productTypeId;
                            }
                            item_title = value.productTypeName +
                                (value.secondaryUnitId != null ? ('(' + value
                                    .quantity +
                                    ' ' + value.secondaryUnitShortName +
                                    ')') : '');
                            //console.log();
                            title_length = item_title.length;
                            //console.log((40 - title_length));
                            // item_title = item_title.padEnd((40 - title_length), ".");
                            item_title = item_title.rpad(25, '.');
                            //console.log(item_title);
                            item_rate = '@' +
                                Number(value.rate).toFixed(
                                    2) + ' INR /' +
                                value.primaryUnitSingularShortName;
                            $('#productTypeId').append('<option value="' + value
                                .productTypeId +
                                '" data-iscontainer="' + value.isContainer +
                                '" data-fuelrateid="' + value.fuelRateId +
                                '" data-rate="' + value.rate +
                                '" data-quantity="' + value.quantity +
                                '" data-primaryunitname="' + value.primaryUnitName +
                                '" data-primaryunitshortname="' + value
                                .primaryUnitShortName +
                                '" data-primaryunitsingularshortname="' + value
                                .primaryUnitSingularShortName +
                                '" data-usesecondaryunit="' + (value
                                    .useSecondaryUnit ? '1' : '0') +
                                '" data-secondaryunitname="' + (value
                                    .secondaryUnitName != null ? value
                                    .secondaryUnitName : "") +
                                '" data-secondaryunitshortname="' + (value
                                    .secondaryUnitShortName != null ? value
                                    .secondaryUnitShortName : "") +
                                '" data-secondaryunitsingularshortname="' + (value
                                    .secondaryUnitSingularShortName != null ? value
                                    .secondaryUnitSingularShortName : "") +
                                '" data-secondaryunitratio="' + (value
                                    .secondaryUnitRatio != null ? value
                                    .secondaryUnitRatio : "") + '">' +
                                item_title +
                                item_rate +
                                '</option>');
                        });
                        setEnvWithRate(pTypeid)
                        changeGodownList()


                    }
                    $('#productTypeId').select2();
                });
        });

        String.prototype.lpad || (String.prototype.lpad = function(length, pad) {
            if (length < this.length)
                return this;

            pad = pad || ' ';
            let str = this;

            while (str.length < length) {
                str = pad + str;
            }

            return str.substr(-length);
        });

        String.prototype.rpad || (String.prototype.rpad = function(length, pad) {
            if (length < this.length)
                return this;

            pad = pad || ' ';
            let str = this;

            while (str.length < length) {
                str += pad;
            }

            return str.substr(0, length);
        });

        function changeGodownList() {
            $('#godownId').empty();
            var officeId = $('#officeId').val();
            var productId = $('#productTypeId').val();
            var productAsContainer = $('#productTypeId').children("option:selected").attr(
                'data-iscontainer');

            var url = "{{ route($routeRole . '.godownlist', ':id') }}";
            // var url = "{{ route('companyadmin.godownlist', ':id') }}";
            url = url.replace(':id', officeId);
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
                        $('#godownId').empty();
                        // $('#quantity').val('');
                        // $('#productTypeId').append('<option value="">Select Product Type</option>');
                        //console.log(data.response);
                        var gTypeid = 0;
                        //console.log(data.response);
                        let cnt = 0;
                        $.each(data.response, function(key, value) {
                            // console.log(value.godownProduct)
                            if (value.productTypeId == productId) {
                                $.each(value.godownProduct, function(inside_key, inside_value) {
                                    // if (productAsContainer == 'false' && inside_value.isStorage) {
                                    if (!inside_value.isReserver) {
                                        if (cnt == 0) {
                                            $('#currentStock').val(inside_value
                                                .currentStock);
                                            if (inside_value.currentStock <= 0) {
                                                $('#currentStock').addClass(
                                                    'is-invalid');
                                                // $('#currentStock').next().text(value);
                                            } else {
                                                if ($('#currentStock').hasClass(
                                                        'is-invalid')) {
                                                    $('#currentStock').removeClass(
                                                        'is-invalid');
                                                }
                                            }
                                        }
                                        cnt++;
                                        $('#godownId').append('<option value="' +
                                            inside_value.godownId +
                                            '" data-isreserver="' + inside_value
                                            .isReserver +
                                            '" data-capacity="' + inside_value
                                            .capacity +
                                            '" data-currentstock="' + inside_value
                                            .currentStock +
                                            '">' + inside_value
                                            .godownName +
                                            '</option>');
                                    }

                                });

                            }
                            //console.log(eval(value));
                            // if (gTypeid == 0) {
                            //     gTypeid = value.godownId;
                            // }
                            // console.log(productAsContainer);
                            // if (productAsContainer == 'false' && value.isStorage) {
                            //     $('#godownId').append('<option value="' + value
                            //         .productTypeId +
                            //         '" data-isstorage="' + value.isStorage + '">' + value
                            //         .godownName +
                            //         '</option>');
                            // }

                        });
                        //setProductEnvWithRate(gTypeid);

                    }
                });
        };

        $('#godownId').on('change', () => {
            let currentStock = $('#godownId').children("option:selected").attr('data-currentstock');
            $('#currentStock').val(currentStock);
            if (currentStock <= 0) {
                $('#currentStock').addClass('is-invalid');
                // $('#currentStock').next().text(value);
            } else {
                if ($('#currentStock').hasClass('is-invalid')) {
                    $('#currentStock').removeClass('is-invalid');
                }
            }
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
        var quantityBlurCount = 0;
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
            // console.log(quantity);

            calculateSecondary();
            quantityBlurCount = 0;
            checkAvailability();
        });

        $('#quantity').on('blur', () => {

            checkAvailability();
            quantityBlurCount++;
        });

        function checkAvailability() {
            var quantity = $("#quantity").val();
            var currentStock = $("#currentStock").val();
            if (parseFloat(quantity) > parseFloat(currentStock)) {
                if (quantityBlurCount == 0) {
                    toastr.warning(
                        "<h3 class='text-danger font-weight-bold'>Stock is low</h3>Please Change the Tank.."
                    );
                }

            }

        }

        function calculateSecondary() {
            var quantity = $("#quantity").val();
            var useSecondaryUnit = $("#productTypeId").find(':selected').attr('data-usesecondaryunit');
            var secondaryUnitShortName = $("#productTypeId").find(':selected').attr(
                'data-secondaryunitshortname');
            var secondaryUnitRatio = $("#productTypeId").find(':selected').attr(
                'data-secondaryunitratio');
            if (useSecondaryUnit == '1') {
                quantity = quantity * secondaryUnitRatio;
                quantity = Number.isNaN(quantity) ? 0 : quantity;
                quantity = quantity > 0 ? (quantity + ' ' + secondaryUnitShortName) : '';
            } else {
                quantity = '';
            }
            $('#secondaryQuantity').html(quantity);
        }
        $("#productTypeId").change(function() {
            var productTypeId = $(this).val();
            setEnvWithRate(productTypeId);
            changeGodownList();
            calculateSecondary();
            //setEnv(productTypeId);
            //getRate(productTypeId);

        });
var hitState=false;
        $("#formCreate").on("submit", function(event) {

            event.preventDefault();
            if(hitState){
                toastr.info("Please wait..")
                return
            }
            hitState=true;
            $('.submit').attr('disabled', true);
            //spinner
            $('.submit').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
            );
            var url = "{{ route('companyadmin.sales.store') }}";
            if (routeRole == 'pumpadmin') {
                url = "{{ route('pumpadmin.sales.store') }}";
            }
            // if($('#godownId').val()=='' || $('#godownId').val()==null){

            //     Swal.fire('',"Please select godown",'warning');
            // }
            var serializeData = $(this).serialize();
            // alert(serializeData);
            //alert(url);

            $.ajax({
                type: "POST",
                url: url,
                _token: "{{ csrf_token() }}",
                data: serializeData,
                dataType: "json",
                encode: true,
            }).done(function(data) {
                if (!data.status) {
                    //   console.log(data);


                    $('.submit').attr('disabled', false);
                    $('.submit').html('Submit');
                    let errorStr = ''
                    hitState=false;
                    $.each(data, function(key, value) {
                        $('#' + key).addClass('is-invalid');
                        // $('#' + key).next().text(value);
                        errorStr += `<p>${value}</p>`;
                        toastr.error(value);

                        return;
                    });
                    // Swal.fire('',errorStr,'warning');
                } else {
                    setTimeout(() => {
                        $('.search').click();
                        $('.close').click();
                        hitState=false;
                        toastr.success(data.message);
                    }, 1000);
                    //location.reload();
                }
            }).fail(function(data) {
                $('.submit').attr('disabled', false);
                $('.submit').html('Submit');
                toastr.error(data.message);
                hitState=false;

                // console.log(data);
            });


        });


        setTimeout(() => {
            console.log('still loading');
            hitState=false;
            $('.loader').hide();
        }, 100);

    });
</script>
