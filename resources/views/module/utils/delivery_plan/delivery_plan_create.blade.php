@extends('layouts.main')
@section('content')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_KEY') }}&callback=initMap" async defer></script>
    <script>
        async function initMap() {
            return
        }
    </script>
    <div class="content-wrapper" id="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-between align-items-center">
                    <div class="col-md-4">
                        <h4 class="m-0   text-dark d-flex justify-content-start align-items-center gap-10">
                            {{ __('Delivery plan') }}</h4>
                        <ol class="breadcrumb float-sm-left border-0 p-0 m-0">
                            <li class="breadcrumb-item "><a href="{{ route($routeRole . '.dashboard') }}"
                                    class="text-active">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item "><a href="{{ route($routeRole . '.delivery_plan') }}"
                                    class="text-active">{{ __('Delivery plan') }}</a></li>
                            @if ($deliveryPlanId > 0)
                                <li class="breadcrumb-item active">{{ __('modify') }}</li>
                            @else
                                <li class="breadcrumb-item active">{{ __('create') }}</li>
                            @endif

                        </ol>
                    </div><!-- /.col -->
                    <div class="col-md-8 d-flex gap-10 flex-wrap justify-content-end ">


                        <a href="javascript:" id="requestFilter" onclick="toggleRequestPanel(this);"
                            title="{{ __('Show or Hide Request Panel') }}"
                            class=" toggle-1 d-none   btn btn-rounded animated-shine px-2    ">
                            <i class="fa fa-eye"></i> {{ __('Show or Hide Request Panel') }}</a>
                        <a href="javascript:" id="routeOptimize" onclick="updateRoute(this);"
                            title="{{ __('Set Optimize route') }}"
                            class=" update-route   btn btn-rounded animated-shine px-2    " style="display: none">
                            <i class="fa fa-bullseye"></i> {{ __('Set Optimize Route') }}</a>
                        <a href="javascript:" id="mapView" onclick="toggleMapPanel(this);" title="{{ __('Route Map') }}"
                            class="    btn btn-rounded animated-shine px-2    " style="display: none">
                            <i class="fas fa-map"></i>
                            <span>{{ __('Route Map') }}</span>
                        </a>
                        <a href="javascript:" id="savePlan" onclick="savePlan(this);" title="{{ __('Save Plan') }}"
                            class="    btn btn-rounded animated-shine px-2    " style="display: none">
                            <i class="fa fa-save"></i>
                            <span>{{ __('Save Plan') }}</span>
                        </a>

                        {{-- <a href="javascript:" onclick="toggleMapPanel(this);" title="{{ __('Map View') }}"
                            class="  float-right btn btn-rounded animated-shine px-2 mb-2 ">
                            <i class="fas fa-map"></i></a> --}}

                        {{-- <a href="javascript:" id="requestFilter" onclick="toggleRequestPanel(this);"
                            title="{{ __('Toggle Panel') }}"
                            class=" float-right btn btn-rounded animated-shine px-2 mb-2 sr-only d-none   ">
                            <i class="fa fa-eye"></i> Toggle Panel</a> --}}
                    </div><!-- /.col -->
                </div><!-- /.row -->

            </div><!-- /.container-fluid -->
        </div>

        <section class="content">


            <div class="row">
                <div id="requestPanel" class="col-md-4  offset-md-4">
                    <div class="card border border-primary p-3 py-0">
                        <div class="card-title text-primary m-0">
                            <div class="row      ">
                                <div class="col-12">
                                    <label class="label text-primary">
                                        <span>{{ $MasterOffice[0]['officeName'] }} : {{ __('Delivery Plan') }} </span>
                                    </label>
                                </div>
                                <div class="col-12">
                                    <label class="label   h6">
                                        <span>{{ __('Plan Date') }} : {{ date('d-m-Y', strtotime($planDate)) }} </span>
                                    </label>

                                </div>

                            </div>

                        </div>
                        <div class="card-content">
                            <form id="requestForm" enctype="multipart/form-data">
                                @csrf
                                <input type="text" class="sr-only" name="deliveryPlanId" value="{{ $deliveryPlanId }}">

                                <div class="row">
                                    <div class="col-md-6 pt-3">
                                        <div class="label-text">{{ __('Product') }}</div>
                                        <select name="productId" id="productId" class="form-control">
                                            @foreach ($products as $product)
                                                <option value="{{ $product['productTypeId'] }}"
                                                    {{ $product['productTypeId'] == $productId ? 'selected' : '' }}>
                                                    {{ __($product['productTypeName']) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 pt-3">
                                        <div class="label-text">{{ __('Manufacturing Hub') }}</div>
                                        <div class="d-flex">
                                            <select name="manufactureingHub" id="manufactureingHub"
                                                class="form-control form-inline">
                                                {{-- @foreach ($manufacturingHubs as $manufacturingHub)
                                                    <option value="{{ $manufacturingHub['hubId'] }}"
                                                        data-lat="{{ $manufacturingHub['latitude'] }}"
                                                        data-long="{{ $manufacturingHub['longitude'] }}">
                                                        {{ __($manufacturingHub['hubName']) }}</option>
                                                @endforeach --}}
                                            </select>

                                            <a href="javascript:" data-param=""
                                                data-url="{{ route($routeRole . '.hub.create') }}"
                                                title="{{ __('Add New Hub') }}"
                                                class="load-popup  btn-sm   btn-primary circle form-inline px-2 ">
                                                <i class="fa fa-plus"></i></a>
                                        </div>

                                    </div>
                                    {{-- <div class="col-md-3 pt-3 sr-only">
                                    <div class="label-text">{{ __('Business Entity') }}</div>
                                    <select name="officeId_filter" id="officeId_filter" class="form-control">
                                        @foreach ($officeList as $office)
                                            <option value="{{ $office['officeId'] }}">{{ __($office['officeName']) }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                </div>
                                <div class="row">
                                    <div class=" col-6 pt-3 sr-only">
                                        <div class="text-center-lg text-left-md label-text">{{ __('Plan Date') }}</div>
                                        <div class="d-flex " style="gap:10px;">
                                            <div class="w-100  ">
                                                <input type="datetime-local" class="form-control" name="planDate"
                                                    id="planDate" value="{{ $planDate }}">
                                            </div>

                                        </div>

                                    </div>
                                    <div class=" col-12 pt-3">
                                        <div class="text-center-lg text-left-md">
                                            <div class="text-center-lg text-left-md label-text">
                                                {{ __('Delivery Date') }}( 24HRS FORMAT)</div>
                                            <div class="d-flex " style="gap:10px;">

                                                <div class="w-100  ">
                                                    <input type="datetime-local" class="form-control"
                                                        name="expectedDeliveryDate" id="expectedDeliveryDate"
                                                        value="{{ $expectedDeliveryDate }}">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6 pt-3">
                                        <div class="label-text">{{ __('Tanker Capacity') }}</div>
                                        <input type="text" class="form-control" value="{{ $tankerCapacity }}"
                                            id="tankerCapacity" name="tankerCapacity">
                                        {{-- <select name="tankerCapacity" id="tankerCapacity" class="form-control">
                                            @foreach ($tankerCapacities as $tankerCapacity)
                                                <option value="{{ $tankerCapacity['capacity'] }}">
                                                    {{ __($tankerCapacity['capacity']) }}</option>
                                            @endforeach
                                        </select> --}}
                                    </div>
                                    <div class="col-6 pt-3">
                                        <div class="label-text">{{ __('Delivery Limit') }}</div>
                                        <input type="text" class="form-control" value="{{ $deliveryLimit }}"
                                            id="deliveryLimit" name="deliveryLimit">
                                        {{-- <select name="deliveryLimit" id="deliveryLimit" class="form-control">
                                            @foreach ($deliveryLimits as $deliveryLimit)
                                                <option value="{{ $deliveryLimit['limit'] }}">
                                                    {{ __($deliveryLimit['limit']) }}</option>
                                            @endforeach
                                        </select> --}}
                                    </div>
                                    <div class="col-12 pt-3 d-flex justify-content-center gap-4 ">
                                        <button id="RequestPlan" type="submit" title="{{ __('New Delivery Plan') }}"
                                            class="submit   btn btn-rounded animated-shine-primary px-2 mb-2 ">
                                            {{ __('Request a plan') }}</button>
                                        {{-- <button type="button" title="{{ __('load') }}"
                                        onclick="LoadManufactureingHub()"
                                            class="  btn btn-rounded animated-shine px-2 ">
                                            {{ __('load') }}</button> --}}
                                        <a href="javascript:" id="requestFilter" onclick="toggleRequestPanel(this);"
                                            title="{{ __('Toggle Panel') }}"
                                            class="toggle-2 d-none float-right btn btn-rounded animated-shine px-2 mb-2   ">
                                            <i class="fa fa-eye"></i> Toggle Panel</a>
                                    </div>


                                </div>
                            </form>
                            {{-- <div class="btn btn-primary" onClick="axiosCall();">Call Axios</div> --}}

                        </div>

                    </div>
                </div>
                <div id="requestProcessPanel" style="opacity:0" class="   ">
                    <div class="card border border-primary p-2 py-0">
                        <div class="card-content">
                            <div id="reportPanel" class="reportPanel   sr-only">
                                @include('module.delivery_plan.delivery_plan_request')


                            </div>
                        </div>
                    </div>

                </div>
            </div>





        </section>
    </div>
    <style scoped>
        .bg-loaded {
            background: #fff;
            animation: fadein 0.5s ease forwards, blink 0.5s linear 3 alternate;
        }


        @keyframes blink {
            0% {
                background: #8c6aca34;
            }

            70% {
                background: #9293d167;
            }

            100% {
                background: #fff;
            }

        }

        #requestPanel>div {
            background-color: #e6d3d3c9;
            /* background-image: linear-gradient(to right, #f7b9c6, #a7b5fb); */
            background-image: linear-gradient(239deg, #5badec 21%, #1daeb3);

        }

        #requestPanel>div .form-control {
            background-color: #ffffffe3 !important;
        }
    </style>
    <style>
        #table1 {
            width: 100%;
        }

        .gap-4 {
            gap: 1rem;
        }

        @media screen and min-width(768px) {

            #table1 td:nth-child(3),
            #table1 td:nth-child(4),
            #table1 td:nth-child(5),
            #table1 td:nth-child(6) {
                width: 50px !important;
            }

        }

        #table1 td:nth-child(2) {
            text-align: left;
            width: 250px !important;
            padding-left: 10px;
        }

        #table1>tbody td:nth-child(8) {
            text-align: left;
            width: 250px !important;
            padding-left: 10px;
            align-items: center;
            position: relative;
        }

        #table1>tbody td:nth-child(8) div {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 100%;
            background-color: #f3f2f200;
        }

        table.dataTable>tbody>tr.child ul.dtr-details>li {
            padding-top: 0;
            display: flex;
            align-items: center;
        }

        table.dataTable>tbody>tr.child ul.dtr-details>li .dtr-data {
            min-width: 150px;
            padding-inline-start: 10px;
        }

        table.dataTable>tbody>tr.child ul.dtr-details>li .editable {
            width: 150px;
        }

        table.dataTable>tbody>tr.child ul.dtr-details>li .editable {
            width: 150px;
        }

        table.dataTable tbody tr.dt-hasChild {
            height: 70px;
            align-items: center;

        }

        @media screen and max-width(768px) {
            #table1 .dtr-details>li {
                display: flex;
                align-items: center;

            }
        }
    </style>
@endsection
@push('script')
    <script>
        const deliveryPlanId = {{ $deliveryPlanId }};

        var isOptimize = true

        const delivery_details = @json($delivery_details);
        const btnRouteOptimize = document.querySelector("#routeOptimize")
        $("#requestForm").on("submit", function(event) {
            event.preventDefault();

            if ($('#reportPanel').hasClass('sr-only')) {
                $('#reportPanel').removeClass('sr-only')
            }
            $('#reportPanel').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
            );
            $('.submit').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
            );
            var url = "{{ route($routeRole . '.delivery_plan.new_request') }}";

            var formData = new FormData($(this)[0]);

            formData.append('product', $('#productId option:selected').text());
            formData.append('mfgHub', $('#manufactureingHub option:selected').text());


            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                processData: false, // don't process the data
                contentType: false, // set content type to false as jQuery will tell the server its a query string request
            }).done(function(data) {
                if (!data.status) {

                    $('.submit').attr('disabled', false);
                    $('.submit').html('Request a plan');
                    $.each(data.errors, function(key, value) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).next().text(value);
                        toastr.error(value);
                    });

                } else {

                    $('#reportPanel').html(data.html);
                    // $('#mapView').html(`<i class="fas fa-map"></i> {{ __('Route Map') }}`)
                    setTimeout(() => {
                        isOptimize = true
                        toastr.success(data.message);
                    }, 1000);
                    toggleRequestPanel();
                }
                $('.submit').attr('disabled', false);
                $('.submit').html('Request a plan');
            }).fail(function(data) {

                $('.submit').attr('disabled', false);
                $('.submit').html('Request a plan');
                toastr.error(data.message);

                // console.log(data);
            });


        });


        async function axiosCall() {
            let url = 'api/v1/dashboard/dropdown_list/8379AC15-C52A-4F2E-D69C-08DAF9596B0B';
            // let url = 'http://115.124.120.251:5059/api/DeliveryPlan/DeliveryPlanDetailsByDeliveryPlanId/1';
            // Storing response
            let options = {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                }
            }
            const officeData = await axios.get(url).then(resp => {
                // console.log(resp.data);
                return resp.data;

            });


        }

        async function LoadManufactureingHub() {

            if ($('#manufactureingHub').hasClass('bg-loaded')) {
                $('#manufactureingHub').removeClass('bg-loaded')
            }
            let url = "{{ route($routeRole . '.hub.list') }}";

            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: "application/json; charset=utf-8",
                success: (response) => {

                    $('#manufactureingHub').val('');
                    let htmlStr = ''
                    let manufactureingHub = {{ $manufactureingHub }};
                    response.data.forEach(element => {

                        htmlStr += `<option value="${ element['hubId'] }" ` +
                            `data-lat="${ element['latitude'] }"` +
                            `data-long="${ element['longitude'] }">` +
                            `${ element['hubName'] } ` +
                            `</option>`;

                    });
                    // console.log( manufactureingHub);
                    $('#manufactureingHub').html(htmlStr)
                    $('#manufactureingHub').val(manufactureingHub);
                    $('#manufactureingHub').addClass('bg-loaded')
                    $('#manufactureingHub').select2()

                    // setTimeout(() => {
                    //     $('#manufactureingHub').addClass('bg-loaded')
                    //     $('#manufactureingHub').select2()


                    // }, 500);




                },
                error: function(xhr, status, error) {

                }
            });
        }

        function toggleRequestPanel() {
            if ($('#requestPanel').hasClass("col-md-4")) {
                $('#requestPanel').addClass("sr-only");
                $('#requestPanel').removeClass("col-md-4");
                $('#routeOptimize').show()
                $('#mapView').show()
                $('#savePlan').show()

                if ($('#requestProcessPanel').hasClass("col-md-8")) {
                    $('#requestProcessPanel').removeClass("col-md-8");
                    $('#requestProcessPanel').addClass("col-md-12");
                    $('.toggle-1').removeClass('d-none')
                    $('.toggle-1').html(`<i class="fa fa-eye"></i> {{ __('Show Request Panel') }}`)

                } else {
                    $('#requestPanel').removeClass("offset-md-4");
                    $('#requestProcessPanel').addClass("col-md-12");
                    $('#requestProcessPanel').css({
                        opacity: 1
                    })
                    $('.toggle-1').removeClass('d-none')
                    $('.toggle-1').html(`<i class="fa fa-eye"></i> {{ __('Show Request Panel') }}`)

                }

                return;
            }
            if ($('#requestPanel').hasClass("sr-only")) {
                $('#requestPanel').removeClass("sr-only");
                $('#requestPanel').addClass("col-md-4");

                $('#routeOptimize').show()
                $('#mapView').show()
                $('#savePlan').show()
                if ($('#requestProcessPanel').hasClass("col-md-12")) {
                    $('#requestProcessPanel').removeClass("col-md-12");
                    $('#requestProcessPanel').addClass("col-md-8");
                    $('.toggle-1').removeClass('d-none')
                    $('.toggle-1').html(`<i class="fa fa-eye"></i> {{ __('Hide Request Panel') }}`)

                } else {
                    $('.toggle-1').removeClass('d-none')
                    $('.toggle-1').html(`<i class="fa fa-eye"></i> {{ __('Show Request Panel') }}`)

                }
            }


        }

        function savePlan(e) {
            if (!isOptimize) {
                toastr.error(`please " <i class="fa fa-bullseye"></i> Set Optimize Route"`)
                return


            }
            let btnThisText = $('#savePlan').html();

            $('#savePlan').attr('disabled', true);
            $('#savePlan').css('pointer-events:none');
            $('#savePlan').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
            );
            try {
                $("#formSavePlan").submit()
            } catch (error) {
                console.log(error);
            } finally {
                console.log(btnThisText);
                $('#savePlan').html(btnThisText);
                $('#savePlan').attr('disabled', false);
                $('#savePlan').css('pointer-events:auto');
            }

        }
        var inProgress = false;

        function toggleMapPanel(element) {
            if (inProgress) return;
            inProgress = true

            let i_element = '';
            let div_element = '';
            element.setAttribute('disabled', true);
            Object.values(element.childNodes).forEach(val => {
                var tag = val.tagName;

                if (tag == 'I') {
                    if (val.classList.contains('fa-map')) {

                        val.classList.remove('fa-map');
                        val.classList.add('spinner-border');
                        val.classList.add('spinner-border-sm');
                        i_element = val;

                    }
                }
                if (tag == 'SPAN') {
                    div_element = val;
                }


            });

            if ($('#listWrapperPanel').hasClass("d-flex")) {
                $('#listWrapperPanel').addClass("d-none");
                $('#listWrapperPanel').removeClass("d-flex");
                $('#mapWrapperPanel').addClass("d-flex");
                $('#mapWrapperPanel').removeClass("d-none");
                initMap();
                setTimeout(() => {
                    if (i_element.classList.contains('spinner-border')) {
                        i_element.classList.add('fa-map');
                        i_element.classList.remove('spinner-border');
                        i_element.classList.remove('spinner-border-sm');
                    }
                    if (div_element.innerHTML.localeCompare('Route Map') == 0) {
                        //console.log(val.innerHTML+': abc');

                        div_element.innerHTML = `Route Data`;
                    } else {
                        div_element.innerHTML = `Route Map`;
                    }
                    inProgress = false;
                }, 2000);
                return;
            }
            if ($('#mapWrapperPanel').hasClass("d-flex")) {
                $('#mapWrapperPanel').addClass("d-none");
                $('#mapWrapperPanel').removeClass("d-flex");
                $('#listWrapperPanel').addClass("d-flex");
                $('#listWrapperPanel').removeClass("d-none");

                // return;
                setTimeout(() => {
                    if (i_element.classList.contains('spinner-border')) {
                        i_element.classList.add('fa-map');
                        i_element.classList.remove('spinner-border');
                        i_element.classList.remove('spinner-border-sm');
                    }
                    if (div_element.innerHTML.localeCompare('Route Map') == 0) {
                        //console.log(val.innerHTML+': abc');

                        div_element.innerHTML = `Route Data`;
                    } else {
                        div_element.innerHTML = `Route Map`;
                    }
                    inProgress = false;
                }, 500);
            }

        }

        async function init_loading() {
            // console.log('Countr');
            if (!$('#manufactureingHub').val() == '' || !$('#manufactureingHub').val() == 0) {
                $("#RequestPlan").click();
                toggleRequestPanel();
                return;
            } else {
                //console.log('Countr wait');
                setTimeout(() => {
                    init_loading()
                }, 1000);
            }



        }
        $(document).ready(() => {

            LoadManufactureingHub();
            if (deliveryPlanId > 0) {
                init_loading()

            }
        });
    </script>
    <script>
        console.clear();
    </script>
@endpush
