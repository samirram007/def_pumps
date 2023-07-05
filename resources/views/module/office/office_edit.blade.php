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

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" class="sr-only" name="masterOfficeId"
                                                    id="masterOfficeId"
                                                    value="{{ $editData->masterOfficeId}}">
                                                    {{-- value="{{ $editData->masterOfficeId == null ? $editData->officeId : $editData->masterOfficeId }}"> --}}
                                                <label for="officeName">{{ __('Business Entity') }}<span
                                                        class="text text-danger  ">*</span></label>
                                                        <small id="officeName-count-char"
                                                    class="count-char  position-absolute right-0  ">{{strlen($editData->officeName)}}/20</small>
                                                <input type="text" class="form-control" id="officeName"
                                                maxlength="20"
                                                    name="officeName" value="{{ $editData->officeName }}"
                                                    placeholder="{{ __('Enter Business Entity') }}"
                                                    onkeyup="countchar(this,'officeName',20);">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="officeTypeId">{{ __('Business Entity Type') }}<span
                                                        class="text text-danger  ">*</span></label>
                                                <select name="officeTypeId" id="officeTypeId" class="form-control">
                                                    @foreach ($officeTypes as $officeType)
                                                        <option value="{{ $officeType['officeTypeId'] }}"
                                                            {{ $editData->officeTypeId == $officeType['officeTypeId'] ? 'selected' : '' }}>
                                                            {{ $officeType['officeTypeName'] }}</option>
                                                    @endforeach

                                                </select>

                                            </div>
                                        </div>



                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="officeEmail">{{ __('Email') }}</label>
                                                <input type="email" class="form-control" id="officeEmail"
                                                    name="officeEmail" value="{{ $editData->officeEmail }}"
                                                    placeholder="{{ __('Enter Email') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="officeContactNo">{{ __('Contact No') }}</label>
                                                <small id="officeContactNo-count-char"
                                                class="count-char  position-absolute right-0  ">0/10</small>
                                                <input type="text" size="10" class="form-control"
                                                maxlength="10"
                                                    id="officeContactNo" name="officeContactNo"
                                                    value="{{ $editData->officeContactNo }}"
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
                                                        <option value="{{ $gstType['gstTypeId'] }}"
                                                            {{ $gstType['gstTypeId'] == $editData->gstTypeId ? 'selected' : '' }}>
                                                            {{ $gstType['gstTypeName'] }}</option>
                                                    @endforeach

                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="gstNumber">{{ __('GST No') }} <span
                                                        class="text text-danger  "
                                                        id="gst_number_require">{{ $editData->gstTypeId > 0 ? '*' : '' }}</span></label>
                                                        <small id="gstNumber-count-char"
                                                        class="count-char  position-absolute right-0  ">0/15</small>
                                                <input type="text" size="15" maxlength="15" class="form-control" id="gstNumber"
                                                    name="gstNumber" value="{{ $editData->gstNumber }}"
                                                    readonly
                                                    placeholder="{{ __('Enter GST no') }}"
                                                    onkeyup="countchar(this,'gstNumber',15);">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="registeredAddress">{{ __('Registered Address') }}</label>
                                                <textarea class="form-control" rows="2" id="registeredAddress" name="registeredAddress"
                                                    placeholder="{{ __('Enter Registered Address') }}">{{ $editData->registeredAddress }}</textarea>

                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="officeAddress">{{ __('Address') }}</label>
                                                <textarea class="form-control" rows="2" id="officeAddress" name="officeAddress" readonly
                                                    placeholder="{{ __('Enter Address') }}">{{ $editData->officeAddress }}</textarea>

                                            </div>
                                        </div>

                                        {{-- <div class="col-md-6">
                                            <div class="form-group">


                                                <label for="officeAddress">{{ __('Map') }}</label>
                                                <div id="map" style="width:100%; height:400px;"></div>
                                                <script
                                                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDN32TA762x19KhBZX91X4uNcmdGAhAlrQ&callback=initMap&v=weekly"
                                                   async defer></script>
                                                <script>
                                                    var map;

                                                    function initMap() {
                                                        const myLatlng = {
                                                            lat: {{ $editData->latitude }},
                                                            lng: {{ $editData->longitude }}
                                                        };
                                                        map = new google.maps.Map(document.getElementById('map'), {
                                                            center: myLatlng,
                                                            zoom: 8
                                                        });

                                                        // var geocoder = new google.maps.Geocoder();
                                                        // geocoder.geocode({
                                                        //     'address': '{{ $editData->officeAddress }}'
                                                        // }, function(results, status) {
                                                        //     console.log(status);
                                                        //     if (status === 'OK') {
                                                        //         var latitude = results[0].geometry.location.lat();
                                                        //         var longitude = results[0].geometry.location.lng();
                                                        //         console.log('Latitude: ' + latitude + ', Longitude: ' + longitude);
                                                        //     } else {
                                                        //         console.log('Geocode was not successful for the following reason: ' + status);
                                                        //     }
                                                        // });

                                                        let infoWindow = new google.maps.InfoWindow({
                                                            content: "Click the map to get Lat/Lng!",
                                                            position: myLatlng,
                                                        });
                                                        // infoWindow.open(map);
                                                        const marker = new google.maps.Marker({
                                                            position: myLatlng,
                                                            map,
                                                            title: "Click to zoom",
                                                        });
                                                        map.addListener("center_changed", () => {
                                                            // 3 seconds after the center of the map has changed, pan back to the
                                                            // marker.
                                                            window.setTimeout(() => {
                                                                map.panTo(marker.getPosition());
                                                            }, 3000);
                                                        });
                                                        map.addListener("click", (mapsMouseEvent) => {
                                                            // Close the current InfoWindow.
                                                            //  infoWindow.close();
                                                            // Create a new InfoWindow.
                                                            // infoWindow = new google.maps.InfoWindow({
                                                            //     position: mapsMouseEvent.latLng,
                                                            // });
                                                            map.setZoom(8);
                                                        map.setCenter(marker.getPosition());
                                                            $('#latitude').val(mapsMouseEvent.latLng.toJSON().lat);
                                                            $('#longitude').val(mapsMouseEvent.latLng.toJSON().lng);
                                                            // infoWindow.setContent(

                                                            //     JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
                                                            // );
                                                            // infoWindow.open(map);
                                                        });
                                                        marker.addListener("click", () => {
                                                            map.setZoom(8);
                                                            map.setCenter(marker.getPosition());
                                                        });
                                                    }
                                                    window.initMap = initMap;
                                                </script>

                                            </div>
                                        </div> --}}
                                        <div class="col-6 sr-only">
                                            <div class="form-group">
                                                <label for="longitude">{{ __('Longitude') }}</label>
                                                <input class="form-control" id="longitude" name="longitude"
                                                    placeholder="{{ __('Enter longitude') }}"
                                                    value="{{ $editData->longitude }}"
                                                    oninput="this.value = this.value.replace(/[^-?0-9\.]/g, '').replace(/^(-?[0-9]*\.[0-9]{0,6}).*/,'$1');">

                                            </div>
                                        </div>
                                        <div class="col-6 sr-only">
                                            <div class="form-group">
                                                <label for="latitude">{{ __('Latitude') }}</label>
                                                <input class="form-control" id="latitude" name="latitude"
                                                    placeholder="{{ __('Enter latitude') }}"
                                                    value="{{ $editData->latitude }}"
                                                    oninput="this.value = this.value.replace(/[^-?0-9\.]/g, '').replace(/^(-?[0-9]*\.[0-9]{0,6}).*/,'$1');">

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
<script>
    function countchar(sender,component,max){

//console.log(sender);

    var len = $(sender).val().length;
    if (len >= max) {
        $('#'+component+'-count-char').text(len+'/' + max);
        $('#'+component+'-count-char').css('color', '#0689bd');
    } else {
        var ch = max - len;
        $('#'+component+'-count-char').text(len + '/' + max);
         $('#'+component+'-count-char').css('color', ' #0689bd');
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
        var temp_gstNumber = '{{ $editData->gstNumber }}';
        setGstRequire();
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
            //spenner
            $('.submit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            const url = "{{ route($routeRole.'.office.update', $editData->officeId) }}";
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
                toastr.error(data.message);
                $('.submit').html('Save');
            });


        });
    });
</script>
