@include('module.office._partial.address_search')
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
                                        @if (isset($masterOfficeList))
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <label for="masterOfficeId">{{ __('Parent Entity') }} <span
                                                    class="text text-danger  ">*</span> </label>
                                                <select name="masterOfficeId" id="masterOfficeId" class="form-control">
                                                    <option value="">Select Parent</option>
                                                    @foreach ($masterOfficeList as $masterOffice)
                                                        <option value="{{ $masterOffice['officeId'] }}">
                                                            {{ $masterOffice['officeName'] }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            </div>
                                        @else
                                            <input type="text" class="sr-only" name="masterOfficeId"
                                                id="masterOfficeId" value="{{ $masterOfficeId }}">
                                        @endif

                                        <div class="col-md-6">
                                            <div class="form-group">

                                                <label for="officeName">{{ __('Business Entity') }} <span
                                                        class="text text-danger  ">*</span> </label>
                                                <small id="officeName-count-char"
                                                    class="count-char  position-absolute right-0  ">0/50</small>
                                                <input type="text" class="form-control" id="officeName"
                                                    name="officeName" value="{{ old('officeName') }}" maxlength="50"
                                                    placeholder="{{ __('Enter Business Entity') }}"
                                                    onkeyup="countchar(this,'officeName',50);">


                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="officeTypeId">{{ __('Business Entity Type') }}<span
                                                        class="text text-danger ">*</span></label>
                                                <select name="officeTypeId" id="officeTypeId" class="form-control">
                                                    @foreach ($officeTypes as $officeType)
                                                        <option value="{{ $officeType['officeTypeId'] }}">
                                                            {{ $officeType['officeTypeName'] }}</option>
                                                    @endforeach

                                                </select>

                                            </div>
                                        </div>



                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="officeEmail">{{ __('Email') }}</label>
                                                <input type="email" class="form-control" id="officeEmail"
                                                    name="officeEmail" value="{{ old('officeEmail') }}"
                                                    placeholder="{{ __('Enter Email') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
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
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="gstTypeId">{{ __('GST Type') }}</label>

                                                <select name="gstTypeId" id="gstTypeId" class="form-control">
                                                    <option value="0">{{ __('Select GST Type') }}</option>
                                                    @foreach ($gstTypes as $gstType)
                                                        <option value="{{ $gstType['gstTypeId'] }}">
                                                            {{ $gstType['gstTypeName'] }}</option>
                                                    @endforeach

                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="gstNumber">{{ __('GST No') }} <span
                                                        class="text text-danger  "
                                                        id="gst_number_require"></span></label>
                                                <small id="gstNumber-count-char"
                                                    class="count-char  position-absolute right-0  ">0/15</small>
                                                <input type="text" size="15" maxlength="15" class="form-control"
                                                    id="gstNumber" readonly name="gstNumber"
                                                    value="{{ old('gstNumber') }}"
                                                    placeholder="{{ __('Enter GST no') }}"
                                                    onkeyup="countchar(this,'gstNumber',15);">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="registeredAddress">{{ __('Registered Address') }}</label>
                                                <textarea class="form-control" rows="1" id="registeredAddress" name="registeredAddress"
                                                    placeholder="{{ __('Enter Registered Address') }}">{{ old('registeredAddress') }}</textarea>

                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="officeAddress">{{ __('Address') }}</label>
                                                <textarea class="form-control" rows="1" id="officeAddress" name="officeAddress" readonly
                                                    placeholder="{{ __('Enter Address') }}">{{ old('officeAddress') }}</textarea>

                                            </div>
                                        </div>

                                        <div class="col-6  sr-only">
                                            <div class="form-group">
                                                <label for="longitude">{{ __('Longitude') }}</label>
                                                <input class="form-control" id="longitude" name="longitude"
                                                    placeholder="{{ __('Enter longitude') }}"
                                                    value="{{ old('longitude') }}" type="text"
                                                    oninput="this.value = this.value.replace(/[^-?0-9\.]/g, '').replace(/^(-?[0-9]*\.[0-9]{0,6}).*/,'$1');">

                                            </div>
                                        </div>
                                        <div class="col-6  sr-only">
                                            <div class="form-group">
                                                <label for="latitude">{{ __('Latitude') }}</label>
                                                <input class="form-control" id="latitude" name="latitude"
                                                    type="text" placeholder="{{ __('Enter latitude') }}"
                                                    value="{{ old('latitude') }}"
                                                    oninput="this.value = this.value.replace(/[^-?0-9\.]/g, '').replace(/^(-?[0-9]*\.[0-9]{0,6}).*/,'$1');">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row text-center">
                                        <div class="col-6 mx-auto">
                                            <button type="submit"
                                                class=" submit btn btn-rounded animated-shine px-4">
                                                {{ __('Save') }}</button>

                                        </div>
                                        <div class="col-6 mx-auto">
                                            <button type="button" class=" btn btn-rounded animated-shine-danger px-4"
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


        $('#officeAddress').on('click', function() {
            // console.log($('#officeAddress').val());
            $('#google_address_search_panel').removeClass('sr-only');
            var address = $('#officeAddress').val();
            console.log(address);
            setTimeout(function() {
                $('#address_search').val(address);
                $('#address_search').focus();
            }, 1000);

        });
        // $('#address_search').on('blur', function() {
        //     $('#google_address_search_panel').addClass('sr-only');
        // });
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

            const url = "{{ route($routeRole . '.office.store') }}";
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
                        toastr.error(value);
                    });

                    $('.submit').html('Save');
                } else {
                    toastr.success(data.message);
                    location.reload();
                }
            }).fail(function(data) {

                toastr.error(data.error);
                $('.submit').html('Save');
            });


        });
    });
</script>
