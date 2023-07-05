<div class="modal-dialog modal-lg  modal-dialog-centered mt-0 ">
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h4 class="modal-title text-light" id="title">{{ __('New Product') }} </h4>
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
                                                        <label for="productTypeName">{{ __('Product Name') }}<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="productTypeName"
                                                            name="productTypeName" placeholder="Product Name"
                                                            value="{{ old('productTypeName') }}">
                                                        <span class="text-danger" id="productTypeNameError"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-6 mb-4">
                                                    <div class="form-group">
                                                        <label for="isContainer">{{ __('Container') }} ?<span
                                                                class="text-danger">*</span></label>
                                                        <select name="isContainer" id="isContainer"
                                                            class="form-control">
                                                            <option value="1">Yes</option>
                                                            <option value="0">No</option>
                                                        </select>
                                                        <span class="text-danger" id="isContainerError"></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 col-6 mb-4">
                                                    <div class="form-group">
                                                        <label for="quantity">{{ __('Quantity') }} </label>
                                                        <input type="text" class="form-control" id="quantity"
                                                            name="quantity" placeholder="Quantity"
                                                            value="{{ old('quantity') }}">
                                                        <span class="text-danger" id="quantityError"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <fieldset class="row">
                                                <legend>{{__('Units of Measurement')}}</legend>

                                                <div class="col-md-3 col-6 mb-4">
                                                    <div class="form-group">
                                                        <label for="primaryUnitId">{{ __('Primary Unit') }} <span
                                                                class="text-danger">*</span></label>
                                                        <select name="primaryUnitId" id="primaryUnitId"
                                                            class="form-control">
                                                            @foreach ($units as $unit)
                                                                <option value="{{ $unit['unitId'] }}">
                                                                    {{ $unit['unitName'] }}({{ $unit['unitShortName'] }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger" id="primaryUnitIdError"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-6 mb-4">
                                                    <div class="form-group">
                                                        <label for="useSecondaryUnit">{{ __('Use Secondary Unit') }}
                                                            ?</label>
                                                        <select name="useSecondaryUnit" id="useSecondaryUnit"
                                                            class="form-control">
                                                            <option value="1">Yes</option>
                                                            <option value="0">No</option>
                                                        </select>
                                                        <span class="text-danger" id="useSecondaryUnitError"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-6 mb-4 secondary">
                                                    <div class="form-group">
                                                        <label for="secondaryUnitId">{{ __('Secondary Unit') }}
                                                        </label>
                                                        <select name="secondaryUnitId" id="secondaryUnitId"
                                                            class="form-control">
                                                            @foreach ($units as $unit)
                                                                <option value="{{ $unit['unitId'] }}">
                                                                    {{ $unit['unitName'] }}({{ $unit['unitShortName'] }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger" id="secondaryUnitIdError"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-6 mb-4 secondary">
                                                    <div class="form-group">
                                                        <label for="secondaryUnitRatio">{{ __('Unit Ratio') }}</label>
                                                        <input type="text" class="form-control"
                                                            id="secondaryUnitRatio" name="secondaryUnitRatio"
                                                            placeholder="Unit Ratio"
                                                            onInput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                            value="{{ old('secondaryUnitRatio') }}">
                                                        <span class="text-danger" id="secondaryUnitRatioError"></span>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset class="row">
                                                <div class="col-md-3 col-6 mb-4">
                                                    <div class="form-group">
                                                        <label for="recorderPoint">{{ __('Recorder Point') }}<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="recorderPoint"
                                                            name="recorderPoint" placeholder="Recorder Point"
                                                            onInput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                            value="{{ old('recorderPoint') }}">
                                                        <span class="text-danger" id="recorderPointError"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-6 mb-4">
                                                    <div class="form-group">
                                                        <label for="maxStockLevel">{{ __('Max Stock Level') }} <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="maxStockLevel"
                                                            name="maxStockLevel" placeholder="Max Stock Level"
                                                            onInput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                            value="{{ old('maxStockLevel') }}">
                                                        <span class="text-danger" id="maxStockLevelError"></span>
                                                    </div>
                                                </div>
                                            </fieldset>

                                            <div class="row text-center">
                                                <div class="col-6 mx-auto">
                                                    <input type="text" class="sr-only" id="organizationId"
                                                        name="organizationId" value="{{ $organizationId }}">
                                                    <input type="text" class="sr-only" id="productTypeId"
                                                        name="productTypeId" value="{{ $productTypeId }}"
                                                        data-product="{{ !isset($product) ? '' : json_encode($product[0]) }}">
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
                        </div>

                    </section>
                </div>
            </div>
        </form>
    </div>
    <style scoped>
        legend {
            text-align: center;
            font-size: 1.2rem;
        }

        .sharebox {
            display: block;
            float: left;
            background: #fff;
            width: 100%;
            padding-bottom: 0px;
            font-style: italic;
            font-size: 18px;
            line-height: 1.5;
            margin: 30px 25px 10px 0px;
            border: 2px solid #777;
            padding: 20px;
            padding-bottom: 0;
            position: relative;
        }

    </style>
    <script>
        $('#isContainer').change(function() {
            ToggleQtyInput();
        });
        $('#useSecondaryUnit').change(function() {
            ToggleSecondaryUnit();
        });
        $('#primaryUnitId').change(function() {
            ToggleSecondaryUnit();
        });
        $('#formCreate').submit(function() {
            event.preventDefault();
            save_product();
        });

        function save_product() {
            // spinner
            $('#save').html('<div class="spinner-border text-light" role="status"><span class="sr-only"></span>Save</div>');
            var productTypeId = $('#productTypeId').val();
            var productTypeName = $('#productTypeName').val();
            var isContainer = $('#isContainer').val();
            var quantity = $('#quantity').val();
            var organizationId = $('#organizationId').val();
            var recorderPoint = $('#recorderPoint').val();
            var maxStockLevel = $('#maxStockLevel').val();
            var primaryUnitId = $('#primaryUnitId').val();
            var useSecondaryUnit = $('#useSecondaryUnit').val();
            var secondaryUnitId = $('#secondaryUnitId').val();
            var secondaryUnitRatio = $('#secondaryUnitRatio').val();
            if (isContainer == 1) {
                if (quantity == '') {
                    toastr.error('Please enter Quantity');
                    $('#save').html('Save');
                    return false;
                }
            }
            if (useSecondaryUnit == 1) {
                if (secondaryUnitId == '') {
                    toastr.error('Please select Secondary Unit');
                    $('#save').html('Save');
                    return false;
                }
                if (secondaryUnitRatio == '') {
                    toastr.error('Please enter Unit Ratio');
                    $('#save').html('Save');
                    return false;
                }
            }
            if (recorderPoint == '' || recorderPoint == 0) {
                toastr.error('Please enter Recorder Point');
                $('#save').html('Save');
                return false;
            }
            if (maxStockLevel == '' || maxStockLevel == 0) {
                toastr.error('Please enter Max Stock Level');
                $('#save').html('Save');
                return false;
            }
            // console.log(productTypeId);
            //alert(productTypeId);

            var roleName = "{{ $roleName }}";

            var url = "{{ route('superadmin.save_product') }}";
            if (roleName == 'companyadmin') {
                url = "{{ route('companyadmin.save_product') }}";
            }
            console.log(url);
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    productTypeId: productTypeId,
                    productTypeName: productTypeName,
                    isContainer: isContainer,
                    quantity: quantity,
                    organizationId: organizationId,
                    recorderPoint: recorderPoint,
                    maxStockLevel: maxStockLevel,
                    primaryUnitId: primaryUnitId,
                    useSecondaryUnit: useSecondaryUnit,
                    secondaryUnitId: secondaryUnitId,
                    secondaryUnitRatio: secondaryUnitRatio,
                },
                success: function(response) {
                    //  console.log(response);
                    if (response.status == 'success') {
                        toastr.success(response.message);
                        $('#save').html('Save');
                        $("#modal-popup .close").click();

                        setTimeout(() => {
                            // console.log('loading....');
                            $('.reportPanel').html(response.html);
                            //loading();
                            // $('.search').click();
                        }, 1000);
                        // $("#ProductListBody").html(response.html);
                        // $('#TableRowProduct' + productTypeId).removeClass('activeClass');
                        // $('#TableRowProduct' + productTypeId).addClass('addClass');
                        // $('#TableRowProduct' + productTypeId).html('<td><input type="text" class="sr-only" name="productTypeId[]" value="' + productTypeId + '"><input type="text" class="sr-only" name="organizationId[]" value="' + organizationId + '">' + productTypeName + '</td><td>' + isContainer + '</td><td style="border-bottom:2px dashed #000!important;"><input type="text" class="bg-white w-100 text-right border-0" onInput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="quantity[]" value="' + quantity + '"></td><td class="text-center"><a href="javascript:" class="edit_data btn btn-primary btn-sm " data-producttypeid="' + productTypeId + '" data-producttypename="' + productTypeName + '" data-iscontainer="' + isContainer + '" data-quantity="' + quantity + '" data-organizationid="' + organizationId + '"><i class="fa fa-edit"></i></a></td>');
                        // $('#TableRowAddProduct').html('');
                        // $('.edit_data').attr('disabled', false);
                    } else {
                        toastr.error(response.message);
                        $('#save').html('Save');
                    }
                },
                error: function(response) {
                    //  console.log(response);
                    toastr.error('Something went wrong');
                    $('#save').html('Save');
                }
            });
        }

        function ToggleQtyInput() {
            var isContainer = $('#isContainer').val();
            if (isContainer == 1) {
                $('#quantity').prop('readonly', false);

            } else {
                $('#quantity').prop('readonly', true);
                $('#quantity').val('');
            }
        }

        function ToggleSecondaryUnit() {
            var useSecondaryUnit = $('#useSecondaryUnit').val();

            if (useSecondaryUnit == 1) {
                //console.log(useSecondaryUnit);
                $('#secondaryUnitId').prop('readonly', false);
                $('#secondaryUnitId').prop('disabled', false);
                $('#secondaryUnitRatio').prop('readonly', false);
                $('#secondaryUnitId').html($('#primaryUnitId').html());

                populateSecondaryUnit();
                $('.secondary').removeClass('sr-only');
            } else {
                $('#secondaryUnitId').prop('readonly', true);
                $('#secondaryUnitId').prop('disabled', true);
                $('#secondaryUnitRatio').prop('readonly', true);
                $('#secondaryUnitId').html('');
                $('#secondaryUnitRatio').val('');
                $('.secondary').addClass('sr-only');

            }
        }

        function populateSecondaryUnit() {
            var primaryUnitId = $('#primaryUnitId').val();
            var secondaryUnitId = $('#secondaryUnitId').val();
            var secondaryUnitRatio = $('#secondaryUnitRatio').val();

            //remove primaryUnitId selected value from secondaryUnitId
            $('#secondaryUnitId option[value="' + primaryUnitId + '"]').remove();
            // console.log(primaryUnitId);
            // console.log(secondaryUnitId);
            // console.log(secondaryUnitRatio);
            if (primaryUnitId == secondaryUnitId) {
                // toastr.error('Primary Unit and Secondary Unit can not be same');
                // $('#secondaryUnitId').val('');
                $('#secondaryUnitRatio').val('');
            }
            if (secondaryUnitRatio == '') {
                // toastr.error('Please enter Unit Ratio');
                //$('#secondaryUnitId').val('');
            }
        }
        $(document).ready(function() {
            if ($('#productTypeId').val() != 0) {
                var product = JSON.parse($('#productTypeId').attr('data-product'));
                //console.log(product.secondaryUnitRatio);
                $('#productTypeName').val(product.productTypeName);
                $('#isContainer').val((product.isContainer) ? 1 : 0);

                $('#recorderPoint').val(product.recorderPoint);
                $('#maxStockLevel').val(product.maxStockLevel);
                $('#primaryUnitId').val(product.primaryUnitId);
                $('#useSecondaryUnit').val((product.useSecondaryUnit) ? 1 : 0);
                $('#secondaryUnitId').val(product.secondaryUnitId);

                ToggleQtyInput();
                $('#quantity').val(product.quantity);
                ToggleSecondaryUnit();
                $('#secondaryUnitRatio').val(product.secondaryUnitRatio);
                $('#title').html(product.productTypeName + ' :: '+"{!!__('edit-mode')!!}");

            } else {
                $('#title').html("{{ __('New Product') }}");
                ToggleQtyInput();
                ToggleSecondaryUnit();
            }

        });
    </script>
</div>
