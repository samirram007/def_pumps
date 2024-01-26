@extends('layouts.main')
@section('content')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    {{-- <script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js"></script>
    <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDN32TA762x19KhBZX91X4uNcmdGAhAlrQ&callback=initMap"
    async defer></script> --}}

    {{-- <script
    src="https://roads.googleapis.com/v1/snapToRoads?parameters&key=AIzaSyDN32TA762x19KhBZX91X4uNcmdGAhAlrQ&callback=initMap&v=weekly"
    async defer></script> --}}

    <script>
        // let map;
        // // let Latitude = '25.3261953';
        // // let Longitude = '82.9852567';
        // let Latitude = '-28.024';
        // let Longitude = '140.887';
        // let newList=[];
    </script>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-between align-items-center">
                    <div class="col-sm-6">
                        <h4 class="m-0 text-dark">{{ __('Delivery plan') }}</h4>
                        <ol class="breadcrumb float-sm-left border-0 p-0 m-0">
                            <li class="breadcrumb-item "><a href="{{ route($routeRole . '.dashboard') }}"
                                    class="text-active">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item "><a href="{{ route($routeRole . '.delivery_plan') }}"
                                    class="text-active">{{ __('Delivery plan') }}</a></li>
                            <li class="breadcrumb-item active">{{ $plan['planTitle'] }}</li>
                        </ol>
                    </div><!-- /.col -->
                    <div class="col-sm-6 sr-only">
                        <a href="javascript:" onclick="toggleMapPanel();" title="{{ __('Map View') }}"
                            class="  float-right btn btn-rounded animated-shine px-2 mb-2 ">
                            <i class="fas fa-map"></i></a>

                        <a href="javascript:" onclick="toggleRequestPanel();" title="{{ __('New Request') }}"
                            class=" float-right btn btn-rounded animated-shine px-2 mb-2 ">
                            <i class="fa fa-paper-plane"></i></a>
                    </div><!-- /.col -->
                </div><!-- /.row -->

            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            {{-- @php
    print_r($plan);
@endphp --}}

            <div class="row">
                <div id="requestPanel" class="col-md-12">
                    <div class="card border border-primary p-3 py-0">
                        <div class="card-title text-primary m-0">
                            <div class="row   sr-only   ">
                                <div class="col-12">
                                    <label class="label text-primary">
                                        <span>{{ $MasterOffice[0]['officeName'] }} : {{ __('Delivery Plan') }} </span>
                                    </label>
                                </div>

                            </div>
                            <div class="card-content">
                                <div class="h5">{{ $plan['planTitle'] }}</div>
                                <div class="h6">{{ __('Date: ') }}{{ date('d-m-Y', strtotime($plan['planDate'])) }}
                                </div>
                                <div class="h6">{{ $plan['planTitle'] }}</div>
                            </div>
                        </div>


                    </div>
                </div>
                <div id="requestPanel" class="col-md-12">
                    <div class="card border border-primary p-3 py-0">

                        @foreach ($plan['deliveryPlanDetailsList'] as $key => $item)
                            <div class="d-flex justify-content-between">
                                <div>{{ __('Delivery Point') }} {{ $key + 1 }} : </div>
                                <div>{{ $item['office']['officeName'] }}</div>
                                <div>{{ $item['plannedQuantity'] }}</div>
                            </div>
                        @endforeach

                    </div>
                </div>
                @php
                   $extraList=json_decode($plan['extraList']);
                @endphp
                @dd($extraList)
                <div id="requestPanel" class="col-md-12">
                    <div class="card border border-primary p-3 py-0">

                        @foreach ($plan['deliveryPlanDetailsList'] as $key => $item)
                            <div class="d-flex justify-content-between">
                                <div>{{ __('Delivery Point') }} {{ $key + 1 }} : </div>
                                <div>{{ $item['office']['officeName'] }}</div>
                                <div>{{ $item['plannedQuantity'] }}</div>
                            </div>
                        @endforeach

                    </div>
                </div>
                {{--        <div id="requestProcessPanel" class="col-md-8">
                    <div class="card border border-primary p-3 py-0">
                        <div class="card-content">
                            <div id="reportPanel" class="reportPanel mt-3 sr-only">
                                @include('module.delivery_plan.delivery_plan_request')


                            </div>
                        </div>
                    </div>

                </div> --}}
            </div>





        </section>
    </div>


    <script>
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
            console.log(url);
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
                    $('.submit').html('Request a plan');
                    $.each(data.errors, function(key, value) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).next().text(value);
                        toastr.error(value);
                    });

                } else {
                    // console.log(data.data);
                    $('#reportPanel').html(data.html);
                    setTimeout(() => {
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

        function toggleRequestPanel() {
            if ($('#requestPanel').hasClass("col-md-4")) {
                $('#requestPanel').addClass("sr-only");
                $('#requestPanel').removeClass("col-md-4");
                if ($('#requestProcessPanel').hasClass("col-md-8")) {
                    $('#requestProcessPanel').removeClass("col-md-8");
                    $('#requestProcessPanel').addClass("col-md-12");
                }
                return;
            }
            if ($('#requestPanel').hasClass("sr-only")) {
                $('#requestPanel').removeClass("sr-only");
                $('#requestPanel').addClass("col-md-4");
                if ($('#requestProcessPanel').hasClass("col-md-12")) {
                    $('#requestProcessPanel').removeClass("col-md-12");
                    $('#requestProcessPanel').addClass("col-md-8");
                }
            }

        }

        function toggleMapPanel() {
            if ($('#listWrapperPanel').hasClass("d-flex")) {
                $('#listWrapperPanel').addClass("d-none");
                $('#listWrapperPanel').removeClass("d-flex");
                $('#mapWrapperPanel').addClass("d-flex");
                $('#mapWrapperPanel').removeClass("d-none");
                initMap();

                return;
            }
            if ($('#mapWrapperPanel').hasClass("d-flex")) {
                $('#mapWrapperPanel').addClass("d-none");
                $('#mapWrapperPanel').removeClass("d-flex");
                $('#listWrapperPanel').addClass("d-flex");
                $('#listWrapperPanel').removeClass("d-none");

                // return;
            }

        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_KEY') }}&callback=initMap" async defer></script>
    <script>
        console.clear();
    </script>
@endsection
