@extends('layouts.main')
@section('content')
    <style>
        /*
                                     * Always set the map height explicitly to define the size of the div element
                                     * that contains the map.
                                     */
        #map_panel {}

        #map {
            height: 60vh;
            border: 6px solid #4d9784e1;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0 0 10px 0 #0000001a;

        }


        #legend {
            font-family: Arial, sans-serif;
            background: #fff;
            padding: 10px;
            margin: 10px;
            border: 3px solid #000;
        }

        #legend h3 {
            margin-top: 0;
        }

        #legend img {
            vertical-align: middle;
        }

        @media(max-width:640px) {
            .gm-style .gm-style-iw-d {
                width: 400px !important;
            }

            .info-window {
                font-size: 26px !important;
            }
        }
    </style>

    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDN32TA762x19KhBZX91X4uNcmdGAhAlrQ&callback=initMap&v=weekly"
        defer></script>
    <script>
        let map;
        let Latitude = '{{ $office['latitude'] }}';
        let Longitude = '{{ $office['longitude'] }}';
    </script>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-between align-items-center">
                    <div class="col-12">
                        <h4 class="m-0 text-dark">{{ __('Def Pumps') }} </h4>
                        <ol class="breadcrumb  border-0 p-0 m-0">
                            <li class="breadcrumb-item "><a href="{{ route($routeRole . '.dashboard') }}"
                                    class="text-active">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Sales') }}</li>
                        </ol>





                    </div><!-- /.col -->
                    <div class="col-sm-6">

                    </div><!-- /.col -->
                </div><!-- /.row -->

            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="card border border-primary p-2">
                @include('module.map.map_filter')
                <div id="map_panel" class="mt-4">
                    @include('module.map.map', ['map_data' => $map_data])
                </div>
                @include('module.map.map_legends')
            </div>
        </section>

        <script>
            $(document).ready(function() {
                // window.mapData =  '{!! $map_data !!}';

                $('#map_filter').on('change', function() {

                    $('#map').html(
                        '<div class="d-flex justify-content-center align-items-center" style="height: 60vh;"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>'
                    );
                    SetPumps();

                });
            });
            let allMapData = @json($map_data);
            const SetPumps = function() {

                var map_filter = $('#map_filter').val();
                $.ajax({
                    url: "{{ route($routeRole . '.map.filter') }}",
                    method: "GET",
                    data: {
                        map_filter: map_filter,
                    },
                    success: function(data) {
                        var mapData = data.res.map_data;
                        allMapData = mapData;

//console.log(typeof(mapData));
                        initMap(mapData);

                    }
                });
            }
            const ShowFilteredPumps = function() {

                var map_filter = $('#map_filter').val();
                var elmnt = $('#product_type');
                var product_type = elmnt.val();
                var recorder_point = elmnt.find(':selected').data('rp');
                //  console.log(recorder_point +" : Recorder Point");
                //  var recorder_point = $('#product_type').attr('data-recorderpoint');
                var slider_value = $('#rs-range-line').val();
                //filter allPumpsData by product_type and slider_value
                var filteredPumps = [];

                var obj = $.parseJSON(allMapData);
                // var obj = $.parseJSON(allMapData);

                var newarray = []
                $.each(obj, function(key, value) {

                    var flag = false;
                    if (value.products.length > 0) {
                        $.each(value.products, function(k, v) {

                            if (v.productTypeId == product_type && v.currentStock != null) {


                                if (v.currentStock < recorder_point) {
                                    value['flag'] = 'Red';


                                }
                                if (v.currentStock >= slider_value) {
                                    flag = true;
                                }

                            } else {
                                flag = true;
                            }
                        });
                        if (flag) {
                            newarray.push(value);
                        } else {
                            value['flag'] = 'Gray';

                            newarray.push(value);
                        }
                    } else {
                        value['flag'] = 'Red';
                        newarray.push(value);
                    }


                });



                initMap(JSON.stringify(newarray));

            }
            var activeInfoWindow;

            function initMap(map_data = []) {
                let infoHTML = '';
                const iconBase = "{{ asset('images/icons') }}/";
                map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 8,
                    center: new google.maps.LatLng(Latitude, Longitude),
                    mapTypeId: ["map", "satellite", "roadmap", "hybrid", "terrain"][2],
                    backgroundColor: '#fefefe',
                    mapTypeControl: true,
                    streetViewControl: true,
                    fullscreenControl: true,
                    disableDefaultUI: true,
                    zoomControl: true,
                    styles: [{
                        "featureType": "water",
                        "elementType": "geometry",
                        "stylers": [{
                            "visibility": "on"
                        }]
                    }, {
                        "featureType": "landscape",
                        "stylers": [{
                            "visibility": "on"
                        }]
                    }, {
                        "featureType": "road",
                        "stylers": [{
                            "visibility": "on"
                        }]
                    }, {
                        "featureType": "administrative",
                        "stylers": [{
                            "visibility": "on"
                        }]
                    }, {
                        "featureType": "poi",
                        "stylers": [{
                            "visibility": "on"
                        }]
                    }, {
                        "elementType": "labels",
                        "stylers": [{
                            "visibility": "on"
                        }]
                    }]


                });
                //console.log(map.center.latitude);





                const icons = {
                    "Retail Pumps": {
                        name: "Retail",
                        icon: iconBase + "map-pump-icon-teal.png",
                    },
                    "Wholesale Pumps": {
                        name: "Wholesale",
                        icon: iconBase + "map-pump-icon.png",
                    },
                    "Company": {
                        name: "Company",
                        icon: iconBase + "map-pump-icon.png",
                    },
                    "Red": {
                        name: "Red",
                        icon: iconBase + "map-pump-icon-red.png",
                    },
                    "Gray": {
                        name: "Gray",
                        icon: iconBase + "map-pump-icon-gray.png",
                    },

                };

                mapData = map_data.length > 0 ? map_data : '{!! $map_data !!}';
                //  console.log(mapData);
                //mapData= mapData;


                //  mapData=JSON.parse(mapData);
                let features = [];
                if (mapData != '') {

                    mapData = JSON.parse(mapData);
                    //  console.log(mapData);
                    var bounds = new google.maps.LatLngBounds();
                    mapData.forEach(data_stat => {
                        var myLatLng = new google.maps.LatLng(data_stat.latitude, data_stat.longitude);
                        bounds.extend(myLatLng);
                        const newArray = {
                            position: new google.maps.LatLng(myLatLng),
                            type: data_stat.officeTypeName,
                            textData: data_stat.officeAddress,
                            textTitle: data_stat.officeName,
                            products: data_stat.products,
                            flag: data_stat.flag,
                        };

                        features.push(newArray);
                    });


                    map.fitBounds(bounds);
                }


                features.forEach((feature) => {

                    const marker = new google.maps.Marker({
                        position: feature.position,
                        icon: icons[feature.flag].icon,
                        // iconSize: new google.maps.Size(10, 10),

                        map: map,

                    });


                    let productContent = '';
                    $.each(feature.products, function(i, product) {
                        productContent = productContent + (
                            `<div>${product.productTypeName} :  ${product.currentStock}</div>`);

                    });

                    const infowindow = new google.maps.InfoWindow({
                        content: `<div class="info-window">
                    <h3>${feature.textTitle}</h3>
                    <p>${feature.textData}</p>
                    <div class="info-window-products border-bottom border-dark font-weight-bold"> Current Stock </div>
                    ${productContent}</div>`
                    });


                    // $each(feature.products, function(product){
                    //     <p>${feature.products}</p>
                    // })
                    marker.addListener("click", () => {

                        if (activeInfoWindow) {
                            activeInfoWindow.close();
                        }
                        setTimeout(() => {
                            infowindow.open(map, marker);
                        }, 100);

                        activeInfoWindow = infowindow;

                    });


                });





            }
            window.initMap = initMap;
        </script>

    </div>
@endsection
