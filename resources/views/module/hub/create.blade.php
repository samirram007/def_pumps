<div class="modal-dialog modal-md  modal-dialog-top mt-4 ">
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h4 class="modal-title text-light">{{ __('New Hub') }} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times-circle" style="font-size:24px; color:#fff"></i>
            </button>
        </div>

        <form id="hubCreate">
            @csrf
            <div class="modal-body bg-light p-0" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1000">
                <div class=" w-100  ">
                    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}

                    <section class="content">
                        <div class="rounded card p-3 bg-white shadow min-h-100">

                            <div class="card card-primary">


                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">

                                                <label for="hubName">{{ __('Hub Name') }} <span
                                                        class="text text-danger  ">*</span>



                                                </label>
                                                <small id="hubName-count-char"
                                                    class="count-char  position-absolute right-0  ">0/20</small>
                                                <input type="text" class="form-control" id="hubName" name="hubName"
                                                    value="{{ old('hubName') }}" maxlength="20"
                                                    placeholder="{{ __('Enter Hub Name') }}"
                                                    onkeyup="countchar(this,'hubName',20);">


                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="stateId">{{ __('State') }}</label>

                                                <select name="stateId" id="stateId" class="form-control">
                                                    <option value="0">{{ __('Select State') }}</option>
                                                    @foreach ($state_list as $state)
                                                        <option value="{{ $state['stateId'] }}">
                                                            {{ $state['stateName'] }}</option>
                                                    @endforeach

                                                </select>

                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="hubAddress">{{ __('Address') }}</label>
                                                <input class="form-control" id="hubAddress" name="hubAddress"
                                                    placeholder="{{ __('Enter Address') }}"
                                                    value="{{ old('hubAddress') }}" />

                                            </div>
                                            @include('module.hub.address_search')
                                        </div>

                                        <div class="col-6 ">
                                            <div class="form-group">
                                                <label for="longitude">{{ __('Longitude') }}</label>
                                                <input class="form-control" id="longitude" name="longitude"
                                                    placeholder="{{ __('Enter longitude') }}" readonly
                                                    value="{{ old('longitude') }}" type="text"
                                                    oninput="this.value = this.value.replace(/[^-?0-9\.]/g, '').replace(/^(-?[0-9]*\.[0-9]{0,6}).*/,'$1');">

                                            </div>

                                        </div>
                                        <div class="col-6 ">
                                            <div class="form-group">
                                                <label for="latitude">{{ __('Latitude') }}</label>
                                                <input class="form-control" id="latitude" name="latitude"
                                                    type="text" placeholder="{{ __('Enter latitude') }}"
                                                    value="{{ old('latitude') }}" readonly
                                                    oninput="this.value = this.value.replace(/[^-?0-9\.]/g, '').replace(/^(-?[0-9]*\.[0-9]{0,6}).*/,'$1');">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row text-center">
                                        <div class="col-6 mx-auto">
                                            <button type="submit" class=" create-hub submit btn btn-rounded animated-shine px-4">
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

                    </section>
                </div>
            </div>

        </form>




    </div>
    <style scoped>
        #cityListPanel {
            min-height: 100px;
            max-height: 70vh;
            overflow-y: scroll;
            margin-block: 10px;
            display: flex;
            flex-flow: column nowrap;
            align-items: flex-start;
            border-bottom: 1px solid #a5a3a3;
        }

        .cityList {
            display: flex;
            width: 100%;
            justify-content: space-between;
            margin-bottom: 10px;
            flex-direction: row;
            padding: 5px
        }

        .cityList .city {
            font-size: 16px;
            color: rgb(70, 68, 68);
        }

        .cityList .state {
            font-size: 12px;

            color: darkgray;
        }

        .cityList:first-child:nth-child(2) {}

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

        .spin {
            display: flex;
            justify-content: center;
            align-items: center;
            max-height: calc(200px - 3rem);
            background: rgba(116, 113, 113, 0.658);
            opacity: 0.6;
            filter: blur(20px);
            animation: login-blur 3s infinite;
            animation-delay: 0s;
            transform-origin: top;
            overflow: hidden;
        }


        @keyframes login-blur {
            from {
                transform: translate(0) rotate(45deg);
            }

            to {
                transform: translateX(370px) rotate(45deg);
            }
        }
    </style>
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
        var routeRole = "{{ $routeRole }}";
        $(document).ready(function() {

            $('#hubAddress').on('keyup', function() {
                // console.log($('#officeAddress').val());
                // spinner

                $('#address_search_list').html(
                    `<div class="spin"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div>`
                    )

                var address = $(this).val();
                var stateName = $('#stateId').find("option:selected").text();
               // console.log(stateName);

                if ($('#google_address_search_panel').hasClass('sr-only')) {
                    $('#google_address_search_panel').removeClass('sr-only');
                    // var address = $('#hubAddress').val();
                    // console.log(address);
                    // setTimeout(function() {
                    //     $('#address_search').val(address);
                    //     // $('#address_search').focus();
                    // }, 100);

                } else {
                    // var address = $(this).val();
                    if (address.length > 3) {
                        $.ajax({
                            url: "{{ route('hub.address.search') }}",
                            type: "GET",
                            data: {
                                address: address,
                    stateName:stateName,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                $('#address_search_list').html(response.html);
                            }
                        });
                    }
                }

            });
            $('#searchBox').on('keyup', function(e) {

                search()


            });
            $('#searchBtn').on('click', function() {
                search()
            });

            function search() {
                let str = $('#searchBox').val();
                var search_url = "{{ route($routeRole . '.city.search', ':id') }}";
                search_url = search_url.replace(':id', str)
                console.log(search_url);
                $.ajax({
                    url: search_url,
                    method: 'GET',
                    dataType: 'json',
                    success: (data) => {
                        $("#cityListPanel").html("");
                        let htmlString = '';
                        for (let i = 0; i < Object.keys(data['cities']).length; i++) {
                            let cityName = Object.values(data["cities"])[i]["cityName"];
                            let stateName = Object.values(data["cities"])[i]["state"]["stateName"];
                            //const countryCode = Object.values(data["countries"])[j]['code'];
                            let cityId = Object.values(data["cities"])[i]["cityId"];
                            htmlString += `<div id="city${cityId}" class="cityList card">` +
                                `<div>` +
                                `<div class="city">${cityName}</div>` +
                                `<div class="state">State: ${stateName} </div>` +
                                `</div>` +
                                `<button class="btn-sm btn-info" onclick="selectCity(${cityId});"><i class="fa fa-plus"></i> </button>` +
                                `</div>`;

                        }
                        $("#cityListPanel").html(htmlString);
                    },
                    error: (err) => {
                        console.log(`Error ${JSON.stringify(err)}`)
                    }
                })

            }
            $('#hubCreate').on('submit', function(e) {
                e.preventDefault()
                if($('#hubName').val().length==0){
                    toastr.error("Enter Hub Name")
                    return
                }
                if($('#stateId').val().length==0 || $('#stateId').val()==null){
                    toastr.error("Select State")
                    return
                }
                if($('#hubAddress').val().length==0){
                    toastr.error("Enter Hub Address")
                    return
                }
                if($('#longitude').val().length==0 || $('#latitude').val().length==0){
                    toastr.error("Select Proper Address")
                    return
                }
                $(".create-hub").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Save'
            )
                var url = "{{ route($routeRole . '.hub.add') }}";

                var formData = new FormData($(this)[0]);
                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    processData: false, // don't process the data
                    contentType: false, // set content type to false as jQuery will tell the server its a query string request
                }).done(function(data) {
                    if (!data.status) {

                        $('.create-hub').attr('disabled', false);
                        $('.create-hub').html('Save');
                        $.each(data.errors, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).next().text(value);
                            toastr.error(value);
                        });

                    } else {
                        // console.log(data.data);
                        //$('#reportPanel').html(data.html);
                        LoadManufactureingHub();
                        setTimeout(() => {

                            toastr.success(data.message);
                        }, 1000);
                        $("#modal-popup .close").click()
                       // toggleRequestPanel();
                    }
                    $('.create-hub').attr('disabled', false);
                    $('.create-hub').html('Save');
                }).fail(function(data) {

                    $('.create-hub').attr('disabled', false);
                    $('.create-hub').html('Save');
                    toastr.error(data.message);

                    // console.log(data);
                });


            })


        });

        function selectCity(cityId) {
            $('#cityId').val(cityId);
            console.log(cityId);
            $("#city" + cityId).remove();
            // setTimeout(()=>{location.reload()},1500);
            $("#cityForm").submit();

        }
    </script>
</div>
