<script>
    // var driverObj = driver({
    //     showProgress: true,
    //     popoverClass: 'driverjs-theme',
    //     showButtons: ['next', 'previous'],
    //     keyboardControl: true,
    //     side: "top",
    //     align: 'center',
    //     steps: [{
    //             element: "#h-section_create_office",
    //             side: "top",
    //             align: 'center',
    //             popover: {
    //                 title: "Pump creation wizard",
    //                 description: "Pump creation wizard",
    //                 showPrevBtn: false,
    //                 highlight: '',

    //                 nextBtnText: 'okay, Start!',

    //                 onNextClick: () => {
    //                     driverObj.moveNext()
    //                     document.querySelector('#officeName').focus()
    //                 }
    //             },

    //         },
    //         {
    //             element: "#h-officeName",
    //             side: "top",
    //             align: 'center',
    //             popover: {
    //                 title: "Pump Name",
    //                 description: "Pump Name is identification of pump<p><small class='text-danger'><i>Enter Pump Name to proceed next</i></small></p>",

    //                 onNextClick: () => {
    //                     if (document.querySelector('#officeName').value != '') {


    //                         driverObj.moveNext()
    //                         document.querySelector('#officeTypeId').focus()
    //                     }
    //                 }
    //             }
    //         },
    //         {
    //             element: "#h-officeType",
    //             side: "top",
    //             align: 'center',
    //             popover: {
    //                 title: "Pump Type",
    //                 description: "Select Pump Type",

    //                 onNextClick: () => {
    //                     if (document.querySelector('#officeTypeId').value != '') {


    //                         driverObj.moveNext()
    //                         document.querySelector('#officeEmail').focus()
    //                     }
    //                 }
    //             }
    //         },
    //         {
    //             element: "#h-officeEmail",
    //             side: "top",
    //             align: 'center',
    //             popover: {
    //                 title: "Email",
    //                 description: "Receives mail, notification, order-copy, invoice etc "
    //             }
    //         },
    //         {
    //             element: "#h-officeContactNo",
    //             popover: {
    //                 title: "Contact Number",
    //                 description: "Receives sms, notification, order-copy, invoice etc ",
    //                 onNextClick: () => {
    //                     driverObj.moveTo(5)
    //                     document.querySelector('#gstTypeId').focus()
    //                 }

    //             }
    //         },
    //         {
    //             element: "#h-officeGstType",
    //             popover: {
    //                 title: "Gst Type",
    //                 description: "If your business is under taxation exempt, then you can skip it",
    //                 onNextClick: () => {
    //                     if (document.querySelector('#gstTypeId').value == '0') {
    //                         driverObj.moveTo(7)
    //                         document.querySelector('#registeredAddress').focus()
    //                     } else {
    //                         driverObj.moveNext()
    //                         document.querySelector('#gstNumber').focus()
    //                     }

    //                 }
    //             }
    //         },
    //         {
    //             element: "#h-gstNumber",
    //             popover: {
    //                 title: "GST Number",
    //                 description: "15 digits GST Number",
    //                 onHighlightStarted: (Element) => {
    //                     if (document.querySelector('#gstTypeId').attr('readonly')) {
    //                         driverObj.moveNext();
    //                     }
    //                     console.log('true');


    //                 }
    //             }
    //         },
    //         {
    //             element: "#h-officeRegisterAddress",
    //             popover: {
    //                 title: "Register Address",
    //                 description: "Your Business Registered Address",
    //                 onPrevClick: () => {
    //                     if (document.querySelector('#gstTypeId').value == '0') {
    //                         driverObj.moveTo(5)
    //                         document.querySelector('#gstTypeId').focus()
    //                     } else {
    //                         driverObj.movePrevious()
    //                         document.querySelector('#gstNumber').focus()
    //                     }

    //                 }
    //             }
    //         },
    //         {
    //             element: "#h-officeSave",
    //             showButtons: ['previous'],
    //             popover: {
    //                 title: "Confirm",
    //                 description: "Confirm as new Pump"
    //             }
    //         },
    //     ]
    // });
    //driverObj.drive(0);
</script>
<style>
    .tooltip {
        position: relative;
        display: inline-block;
    }

    .tooltip .tooltiptext {
        visibility: hidden;
        width: 140px;
        background-color: #555;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px;
        position: absolute;
        z-index: 1;
        bottom: 150%;
        left: 50%;
        margin-left: -75px;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .tooltip .tooltiptext::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #555 transparent transparent transparent;
    }

    .tooltip:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }
</style>
<div class="stepper bg-light  ">
    @include('module.wizard.step_progressbar')
</div>

<form id="formCreate">
    @csrf

    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}

    <section class="content">
        <div class="  p-3 bg-transparent   min-h-100">

            <div class="row">

                <div class="col-md-4 sr-only">
                    <div id="h-section_create_office" class="sr-only"></div>
                    <div class=" d-flex justify-content-center ">
                        <img class="info-image" style="" src="{{ asset('images/wizard/img01.png') }}">
                    </div>

                </div>


                <div class=" col-12 px-0 ">

                    <div class="wizard-box scroll-box card card-primary   mr-md-2">


                        <div class="card-body d-flex flex-column justify-content-start">
                            <div class="row pl-2 d-flex justify-content-start text-left h6">
                                {{ __('General Information of new pump') }}
                            </div>
                            <div class="row ">
                                @if (isset($masterOfficeList))
                                    <div class="col-md-3 sr-only">
                                        <div class="form-group">
                                            <label for="masterOfficeId">{{ __('Parent Entity') }} <span
                                                    class="text text-danger  ">*</span> </label>
                                            <select name="masterOfficeId" id="masterOfficeId" class="form-control">
                                                {{-- <option value="">Select Parent</option> --}}
                                                @foreach ($masterOfficeList as $masterOffice)
                                                    <option value="{{ $masterOffice['officeId'] }}">
                                                        {{ $masterOffice['officeName'] }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <input type="text" class="sr-only" name="masterOfficeId" id="masterOfficeId"
                                        value="{{ $masterOfficeId }}">
                                @endif

                                <div id="h-officeName" class="col-md-3">
                                    <div class="form-group">

                                        <label for="officeName">{{ __('Pump Name') }} <span
                                                class="text text-danger  ">*</span> </label>
                                        <small id="officeName-count-char"
                                            class="count-char  position-absolute right-0  ">0/50</small>
                                        <input type="text" class="form-control" id="officeName" name="officeName"
                                            value="{{ old('officeName') }}" maxlength="50"
                                            placeholder="{{ __('Enter Pump Name') }}"
                                            onkeyup="countchar(this,'officeName',50);">

                                        <div class="description">
                                            {!! __(
                                                'Enter the name of the pump. Be precise and use any common abbreviations if necessary. <br>For example, "CP-500 Water Pump."',
                                            ) !!}
                                        </div>

                                    </div>

                                </div>

                                <div id="h-officeType" class="col-md-3">
                                    <div class="form-group">
                                        <label for="officeTypeId">{{ __('Business Entity Type') }}<span
                                                class="text text-danger ">*</span></label>
                                        <select name="officeTypeId" id="officeTypeId" class="form-control">
                                            @foreach ($officeTypes as $officeType)
                                                <option value="{{ $officeType['officeTypeId'] }}">
                                                    {{ $officeType['officeTypeName'] }}</option>
                                            @endforeach

                                        </select>
                                        <div class="description">
                                            Select the pump type from the provided options in the dropdown menu.
                                        </div>
                                    </div>
                                </div>



                                <div id="h-officeEmail" class="col-md-3">
                                    <div class="form-group">
                                        <label for="officeEmail">{{ __('Email') }}</label>
                                        <input type="email" class="form-control" id="officeEmail" name="officeEmail"
                                            value="{{ old('officeEmail') }}" placeholder="{{ __('Enter Email') }}">

                                        <div class="description">
                                            Enter the email address of the contact person or entity associated with the
                                            pump. Ensure it's a valid and complete email address.
                                        </div>
                                    </div>
                                </div>
                                <div id="h-officeContactNo" class="col-md-3">
                                    <div class="form-group">
                                        <label for="officeContactNo">{{ __('Contact No') }}</label>
                                        <small id="officeContactNo-count-char"
                                            class="count-char  position-absolute right-0  ">0/10</small>
                                        <input type="text" size="10" class="form-control" maxlength="10"
                                            id="officeContactNo" name="officeContactNo"
                                            value="{{ old('phoneNumber') }}"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/^([0-9]*\.[0-9]{0,2}).*/,'$1');"
                                            placeholder="{{ __('Enter Contact no') }}"
                                            onkeyup="countchar(this,'officeContactNo',10);">

                                        <div class="description">
                                            Enter the phone number, Ensure that the number is accurate and complete.
                                        </div>
                                    </div>
                                </div>
                                <div id="h-officeGstType" class="col-md-3">
                                    <div class="form-group">
                                        <label for="gstTypeId">{{ __('GST Type') }}</label>

                                        <select name="gstTypeId" id="gstTypeId" class="form-control">
                                            <option value="0">{{ __('Select GST Type') }}</option>
                                            @foreach ($gstTypes as $gstType)
                                                <option value="{{ $gstType['gstTypeId'] }}">
                                                    {{ $gstType['gstTypeName'] }}</option>
                                            @endforeach

                                        </select>
                                        <div class="description">
                                            Choose the applicable GST type from the dropdown. If no applicable, leave
                                            the field.
                                        </div>
                                    </div>
                                </div>
                                <div id="h-gstNumber" class="col-md-3">
                                    <div class="form-group">
                                        <label for="gstNumber">{{ __('GST No') }} <span class="text text-danger  "
                                                id="gst_number_require"></span></label>
                                        <small id="gstNumber-count-char"
                                            class="count-char  position-absolute right-0  ">0/15</small>
                                        <input type="text" size="15" maxlength="15" class="form-control"
                                            id="gstNumber" readonly name="gstNumber" value="{{ old('gstNumber') }}"
                                            placeholder="{{ __('Enter GST no') }}"
                                            onkeyup="countchar(this,'gstNumber',15);">
                                        <div class="description">
                                            Enter the GST number if the pump is registered under GST. Make sure to input
                                            the correct GST number.
                                        </div>
                                    </div>
                                </div>

                                <div id="h-officeRegisterAddress" class="col-md-6">

                                    <div class="form-group">
                                        <label
                                            for="registeredAddress">{{ __('Business Communication Address') }}</label>

                                        <textarea class="form-control" rows="1" id="registeredAddress" name="registeredAddress"
                                            placeholder="{{ __('Business Communication Address') }}">{{ old('registeredAddress') }}</textarea>
                                        <div class="description">
                                            The official business address, which includes street address, city, state,
                                            postal code, etc.
                                        </div>
                                    </div>

                                </div>

                                <div id="h-officeAddress" class="col-md-6 ">
                                    <div class="form-group">
                                        <label for="officeAddress">{{ __('Pump Location (Google Search Address)') }}
                                        </label>

                                        <span class="ml-1 text-secondary   p-0   " id="addressCopy"> <i
                                                class="fa fa-copy"></i> </span> <span class="tooltip">coppied</span>
                                        <textarea class="form-control" rows="1" id="officeAddress" name="officeAddress" readonly
                                            placeholder="{{ __('Enter Pump Location') }}">{{ old('officeAddress') }}</textarea>
                                        @include('module.office._partial.address_search')
                                        <div class="description">
                                            Pump Location (Google Search Address): The location of the pump, possibly in
                                            the format of a Google Maps address.
                                        </div>

                                    </div>
                                </div>

                                <div class="col-6  sr-only">
                                    <div class="form-group">
                                        <label for="longitude">{{ __('Longitude') }}</label>
                                        <input class="form-control" id="longitude" name="longitude"
                                            placeholder="{{ __('Enter longitude') }}" value="{{ old('longitude') }}"
                                            type="text"
                                            oninput="this.value = this.value.replace(/[^-?0-9\.]/g, '').replace(/^(-?[0-9]*\.[0-9]{0,6}).*/,'$1');">

                                    </div>
                                </div>
                                <div class="col-6  sr-only">
                                    <div class="form-group">
                                        <label for="latitude">{{ __('Latitude') }}</label>
                                        <input class="form-control" id="latitude" name="latitude" type="text"
                                            placeholder="{{ __('Enter latitude') }}" value="{{ old('latitude') }}"
                                            oninput="this.value = this.value.replace(/[^-?0-9\.]/g, '').replace(/^(-?[0-9]*\.[0-9]{0,6}).*/,'$1');">

                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="description">
                                        <strong> Additional Notes:</strong>

                                        Double-check all information for accuracy before submitting.
                                        Use the "Other" field only when the required option is not available.
                                        Ensure that all data is input accurately to avoid errors.
                                    </div>
                                    <div class="description">
                                        <strong> Form Submission:</strong>



                                        Click the "Submit" button when you have entered all the required information.
                                        Please
                                        review the entered data before submission.

                                        This approach provides clear instructions for data entry operators, making it
                                        easier
                                        for them to input accurate and complete information. Additionally, you can
                                        implement
                                        data validation to reduce the likelihood of errors during data entry.
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class=" py-4 bg-white   ">
                            <div class="row">
                                <div class="col-md-4 offset-md-4">
                                    <button type="submit" id="h-officeSave"
                                        class=" submit btn   btn-rounded animated-shine  w-100 px-4">
                                        {{ __('Save & Next') }}</button>

                                </div>
                                @if (!env('APP_DEBUG'))
                                    <div class="col-md-4 offset-md-4">
                                        <button type="button"
                                            onclick="loadWizardGodown('3F6BBA8A-E944-4740-0B60-08DBA781DEDC')"
                                            class="  btn btn-rounded animated-shine px-4">
                                            {{ __('Test') }}</button>
                                    </div>
                                @endif
                            </div>



                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-none">
                    <div class="card btn-section row text-center border-top bg-white  pt-2 pb-4  ">

                        <div class="card-body d-flex flex-column justify-content-between">
                            <div id="h-openingstock" class="col-12 border-bottom border-info">
                                <div class=" row d-flex justify-content-start ">

                                    <div class="h6 ">
                                        {{ __('Opening Stock for DIVOL') }}
                                    </div>

                                </div>
                                <div class="form-group row  ">

                                    <label for="openingStock"
                                        class="col-sm-4 col-form-label text-left">{{ __('Opening Stock') }}
                                        <span class="text text-danger  ">*</span> </label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="openingStock"
                                            name="openingStock" value="{{ old('openingStock') }}" maxlength="50"
                                            placeholder="{{ __('Opening Stock') }}">
                                    </div>


                                    <div class="description col-12">
                                        {!! __('Enter the initial stock of divol for this pump.') !!}
                                    </div>

                                </div>
                                <div class="form-group row">

                                    <label for="rate"
                                        class="col-sm-4 col-form-label text-left">{{ __('Price') }}
                                        <span class="text text-danger  ">*</span> </label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="rate" name="rate"
                                            value="{{ old('rate') }}" maxlength="50"
                                            placeholder="{{ __('Price') }}">
                                    </div>


                                    <div class="description col-12">
                                        {!! __('Enter the price or cost associated with the DIVOL product') !!}
                                    </div>

                                </div>

                            </div>

                            <div id="h-currentinvoice" class="col-12 border-bottom border-info my-2">
                                <div class=" row d-flex justify-content-start text-left ">

                                    <div class="h6">
                                        {{ __('Starting Invoice No for Current Financial Year') }}
                                    </div>

                                </div>
                                <div class="form-group row  ">

                                    <label for="invoiceNo"
                                        class="col-sm-4 col-form-label text-left">{{ __('Invoice No.') }}
                                        <span class="text text-danger  ">*</span> </label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="invoiceNo" name="invoiceNo"
                                            value="{{ old('invoiceNo') }}" maxlength="50"
                                            placeholder="{{ __('Invoice No.') }}">
                                    </div>


                                    <div class="description col-12">
                                        {!! __('Enter the initial invoice number for the current financial year.') !!}
                                    </div>

                                </div>


                            </div>
                            <div class=" mt-2  d-flex justify-content-center">

                                <button type="submit" id="h-officeSave"
                                    class=" submit btn   btn-rounded animated-shine-primary   px-4">
                                    {{ __('Save') }}</button>
                                @if (env('APP_DEBUG'))
                                    <button type="button"
                                        onclick="loadWizardGodown('3F6BBA8A-E944-4740-0B60-08DBA781DEDC')"
                                        class="  btn btn-rounded animated-shine px-4">
                                        {{ __('Test') }}</button>
                                @endif


                            </div>
                            {{-- <div class="col-6 mx-auto">
                                    <button type="button" class=" btn btn-rounded animated-shine-danger px-4"
                                        data-dismiss="modal">{{ __('Cancel') }}</button>
                                </div> --}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


</form>

<style>
    .count-char {
        right: 14px;
        bottom: 0;
        font-size: 0.75rem;
        font-weight: bolder;
        color: #0689bd;
    }

    .form-group>label {
        margin-bottom: .1rem !important;
    }
</style>
{{-- counter of character --}}

<script>
    $('#addressCopy').on('click', function(e) {
        // console.log(e.target)
        // $('#officeAddress').val();
        var copyText = document.getElementById("officeAddress");
        // console.log(copyText)
        // Select the text field
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText.value);

    })
    $('.form-control').on('focus', function(e) {
        // console.log(e.target)
        e.target.autocomplete = "off";
        //  e.target.value = ""

    })
    //     document.querySelector('.form-control').addEventListener("focus", function() {
    //         console
    //     this.value = "";
    //   });
    // function countchar('officeName',length){
    function countchar(sender, component, max) {

        //console.log(sender);

        var len = $(sender).val().length;
        if (len >= max) {
            $('#' + component + '-count-char').text(len + '/' + max);
            $('#' + component + '-count-char').css('color', '#0689bd');
        } else {
            var ch = max - len;
            $('#' + component + '-count-char').text(len + '/' + max);
            $('#' + component + '-count-char').css('color', ' #0689bd');
        }

    }
</script>

<script>
    $(document).ready(function() {


        $('#officeAddress').on('click', function(e) {
            // console.log($('#officeAddress').val());
            $('#google_address_search_panel').removeClass('sr-only');
            var address = $(this).val();
            console.log(address);
            //
            setTimeout(function() {

                $('#address_search').focus();
                $('#address_search').val(address);
            }, 500);

        });

        $('#gstTypeId').on('change', function() {
            setGstRequire();
        });
        $('#gstTypeId').on('blur', function() {
            setGstRequire();
        });
        var temp_gstNumber = '';

        function setGstRequire() {
            var gstTypeId = $("#gstTypeId").val();
            //console.log(gstTypeId);
            if (gstTypeId == null || gstTypeId == "" || gstTypeId == 0) {
                temp_gstNumber = $("#gstNumber").val();
                //  console.log(temp_gstNumber);
                $("#gstNumber").val('');
                $("#gstNumber").attr("readonly", true);
                $('#gst_number_require').html('');
            } else {
                $("#gstNumber").val(temp_gstNumber);

                $("#gstNumber").attr("readonly", false);
                $('#gst_number_require').html('*');
            }
        }
    });
</script>

<script>
    $(document).ready(function() {
        // $('#formCreate').submit();
        $("#formCreate").on("submit", function(event) {

            event.preventDefault();
            $('.submit').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
            );

            const url = "{{ route($routeRole . '.wizard.office.store') }}";
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
                    // console.log(data.errors);
                    $.each(data.errors, function(key, value) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).next().text(value);
                        toastr.error(value);
                    });

                    $('.submit').html("{{ __('Confirm as new pump') }}");
                } else {
                    toastr.success(data.message);
                    //  console.log(data);
                    // loadWizardGodown(data.officeId);
                    loadWizardRate(data.officeId);
                    setTimeout(() => {
                        populateOffice();
                    }, 100);
                    // location.reload();
                }
            }).fail(function(data) {

                toastr.error(data.error);
                $('.submit').html("{{ __('Confirm as new pump') }}");
            });




        });


    });
</script>
