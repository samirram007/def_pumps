<div class="modal-dialog modal-lg  modal-dialog-centered mt-0 ">
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h4 class="modal-title text-light" id="title">{{ __('New Driver') }} </h4>
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
                                                        <label for="driverName">{{ __('Driver Name') }}<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="driverName"
                                                            name="driverName" placeholder="Driver Name"
                                                            value="{{ old('driverName') }}">
                                                        <span class="text-danger" id="driverNameError"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <div class="form-group">
                                                        <label for="contactNumber">{{ __('Contact No') }}<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="contactNumber"
                                                        size="10" maxlength="10"
                                                            name="contactNumber" placeholder="Contact No"
                                                            value="{{ old('contactNumber') }}">
                                                        <span class="text-danger" id="contactNumberError"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <div class="form-group">
                                                        <label for="licenceNo">{{ __('Licence No') }}</label>
                                                        <input type="text" class="form-control" id="licenceNo"
                                                            name="licenceNo" placeholder="Licence No"
                                                            value="{{ old('licenceNo') }}">
                                                        <span class="text-danger" id="licenceNoError"></span>
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

        $('#formCreate').submit(function() {
            event.preventDefault();
            save_driver();
        });

        function save_driver() {
            // spinner
            $('.submit').html('<div class="spinner-border text-light" role="status"><span class="sr-only"></span>Save</div>');
            var driverName = $('#driverName').val();
            var contactNumber = $('#contactNumber').val();
            var licenceNo = $('#licenceNo').val();
            var officeId = "{{ $officeId }}";
            if (driverName == '') {
                toastr.error('Please enter Name');
                    $('.submit').html('Save');
                    return false;
            }
           if (contactNumber == '') {
                    toastr.error('Please enter contact no');
                    $('.submit').html('Save');
                    return false;
                }

            // console.log(productTypeId);
            //alert(productTypeId);

            var roleName = "{{ $roleName }}";

            var url = "{{ route('companyadmin.driver.store') }}";
            // if (roleName == 'companyadmin') {
            //     url = "{{ route('companyadmin.driver.store') }}";
            // }
            // console.log(url);
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    driverName: driverName,
                    contactNumber: contactNumber,
                    licenceNo: licenceNo,
                    officeId: officeId,
                },
                success: function(response) {
                    //  console.log(response);
                    if (response.status) {
                        toastr.success(response.message);
                        $('.submit').html('Save');
                        $("#modal-popup .close").click();
window.location.href="{{ route('companyadmin.driver.index') }}";
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
                        $('.submit').html('Save');
                    }
                },
                error: function(response) {
                    //  console.log(response);
                    toastr.error('Something went wrong');
                    $('.submit').html('Save');
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
                $('#color').val(product.color);
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
