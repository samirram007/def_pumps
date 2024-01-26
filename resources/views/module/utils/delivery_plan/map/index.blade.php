<div class="modal-header ">
    <div class="modal-title text-light {{ env('APP_DEBUG') ? '' : 'd-none' }}">
        <div class="pl-2 pt-2">Total Distance : <span id="TotalDistance">0</span></div>
        <div class="pl-2 pb-2">Travel Time : <span id="TotalTime">0</span></div>
    </div>
    <button type="button" onclick="getMap(this)" class="close">
        <i class="fa fa-times-circle" style="font-size:24px; color:#fff"></i>
    </button>
</div>

<div id="jsonInfo" style="background: #38a6d170; display:none;"></div>
<div id="map" style="background: #083f5570 "></div>




<script>
    var map;
    var activeInfoWindow;
    var TotalDistance = 0;
    var TotalTime = 0;
    var plannedRoute = [];
    var driverRoute = [];
    async function initMap() {
        const directionsService = new google.maps.DirectionsService();

        const directionsRenderer = new google.maps.DirectionsRenderer({
            map: map,
            suppressMarkers: true,
            polylineOptions: {
                strokeColor: "#4074f8",
                strokeOpacity: 0.8,
                strokeWeight: 6,
            },

        }); // Planned Route
        const lineSymbol = {
            path: "M 0,-1 0,1",
            strokeOpacity: 0.7,
            scale: 4,
            strokeColor: "#fffff",
            strokeWeight: 2,
        };
        const Driver_directionsRenderer =
            new google.maps.DirectionsRenderer({
                map: map,
                suppressMarkers: true,
                polylineOptions: {
                    strokeWeight: 2,
                    strokeColor: "#ffffff",
                    strokeOpacity: 0,
                    icons: [{
                        icon: lineSymbol,
                        offset: "0",
                        repeat: "20px",
                    }],
                    zIndex: 5
                },
            }); // Driver Route

        const Driver_completed_directionsRenderer =
            new google.maps.DirectionsRenderer({
                map: map,
                suppressMarkers: true,
                polylineOptions: {
                    strokeColor: "transparent",
                    zIndex: -1,
                },
            }); // Driver Route

        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 8,
            options: {
                gestureHandling: 'greedy'
            }
        });

        directionsRenderer.setMap(map);
        Driver_directionsRenderer.setMap(map);
        Driver_completed_directionsRenderer.setMap(map);

        let waypt = [];
        let driver_waypt = [];
        let originCord = [];
        let destinationCord = [];
        let completeted_point = [];
        let intimate_point = [];

        let start_Latitude = 0.0;
        let start_Longitude = 0.0;
        let infoHTML = '';

        plannedRoute.sort((a, b) => a.sequenceNo - b.sequenceNo);
        document.querySelector("#jsonInfo").innerHTML = plannedRoute;
        start_Latitude = plannedRoute[0].startLatitude ?? 0.0;
        start_Longitude = plannedRoute[0].startLongitude ?? 0.0;



        for (let index = 0; index < plannedRoute.length; index++) {
            const latitude = plannedRoute[index]["latitude"];
            const longitude = plannedRoute[index]["longitude"];

            waypt.push({
                location: new google.maps.LatLng(latitude, longitude),
                stopover: true,
            });




        }

        // This function is to add markers on the route -- For pumps
        directionsService
            .route({
                origin: new google.maps.LatLng(
                    start_Latitude,
                    start_Longitude
                ), //Varanasi location
                destination: new google.maps.LatLng(
                    start_Latitude,
                    start_Longitude
                ), //Varanasi location
                waypoints: waypt,
                optimizeWaypoints: false,
                travelMode: google.maps.TravelMode.DRIVING,
            })
            .then((response) => {
                directionsRenderer.setDirections(response);
                var my_route = response.routes[0];
                // console.log(my_route.legs.length);
                for (var i = 0; i < my_route.legs.length; i++) {

                    const marker = new google.maps.Marker({
                        position: my_route.legs[i].start_location,
                        label: {
                            text: i == 0 ? 'SP' : i.toString(),
                            color: "white",
                        },
                        map: map,
                    });
                    var htmlStr = ``
                    if (i === 0) {
                        htmlStr += `Starting Point`
                    } else {
                        htmlStr += `<div class="info-window box-shadow">
                <h3>${plannedRoute[i-1]['officeName']}</h3>
                <p>Address: ${my_route.legs[i].start_address}</p>
                <div class="d-flex flex-row justify-content-between flex-wrap">
                    <div class="info-window-products d-flex flex-column justify-content-between">
                        <div class="border-bottom border-dark font-weight-bold">Current Stock </div>
                        <div>${(plannedRoute[i-1]['currentQuantity']).toFixed(3)}</div>
                    </div>
                    <div class="info-window-products d-flex flex-column justify-content-between">
                        <div class="border-bottom border-dark font-weight-bold">Available </div>
                        <div>${(plannedRoute[i-1]['availableQuantity']).toFixed(3)}</div>
                    </div>
                    <div class="info-window-products d-flex flex-column justify-content-between">
                        <div class="border-bottom border-dark font-weight-bold">Suggested </div>
                        <div>${(plannedRoute[i-1]['plannedQuantity']).toFixed(3)}</div>
                    </div>
                </div>
                <p class="mt-4 text-danger"><b>Next Stop: </b><u>${ (i==(my_route.legs.length-1))?'Starting Point':plannedRoute[i]['officeName']}</u>
                    (Distance: ${my_route.legs[i].distance.text}, Travel Time: ${my_route.legs[i].duration.text})</p>
                <button class="sr-only" onclick="alert()">Change</button></div>`

                    }
                    const infowindow = new google.maps.InfoWindow({
                        content: `<div class="info-window box-shadow">${htmlStr}</div>`
                    });
                    marker.addListener("click", () => {
                        if (activeInfoWindow) {
                            activeInfoWindow.close();
                        }
                        infowindow.setPosition(marker.getPosition());
                        infowindow.open(map);
                        activeInfoWindow = infowindow;
                    });

                }
            });
        for (let index = 0; index < driverRoute.length; index++) {
            const latitude = driverRoute[index]["latitude"];
            const longitude = driverRoute[index]["longitude"];

            driver_waypt.push({
                location: new google.maps.LatLng(
                    latitude,
                    longitude
                ),
                stopover: true,
            });
            if (driverRoute[index]["deliveryTrackerStatusId"] === 2) {
                completeted_point.push({
                    location: new google.maps.LatLng(
                        latitude,
                        longitude
                    ),
                    lastUpdatetime: driverRoute[index]["locationUpdateTime"],
                    officeName: driverRoute[index]["officeName"],
                });
            }
            if (driverRoute[index]["deliveryTrackerStatusId"] === 3) {
                completeted_point.push({
                    location: new google.maps.LatLng(
                        latitude,
                        longitude
                    ),
                    lastUpdatetime: driverRoute[index]["locationUpdateTime"],
                });
            }
        }


        setTimeout(() => {
            // This function is to add truck icon on the route -- For the current driver location
            directionsService
                .route({
                    origin: new google.maps.LatLng(
                        start_Latitude,
                        start_Longitude
                    ), //Varanasi location
                    destination: driver_waypt[driver_waypt.length - 1]
                        .location, //Varanasi location
                    waypoints: driver_waypt,
                    optimizeWaypoints: false,
                    travelMode: google.maps.TravelMode.DRIVING,
                })
                .then((response) => {
                    Driver_directionsRenderer.setDirections(response);
                    var my_route = response.routes[0];

                    for (var i = 0; i < my_route.legs.length; i++) {
                        if (i === my_route.legs.length - 1) {
                            icon = "{{ asset('delivery_plan/truck (right).png') }}";

                            if (my_route.legs.length > 1) {
                                var angle = Math.atan(
                                    (my_route.legs[i].start_location.toJSON().lng -
                                        my_route.legs[
                                            i - 1].start_location.toJSON().lng) / (
                                        my_route.legs[i]
                                        .start_location.toJSON().lat - my_route.legs[i -
                                            1]
                                        .start_location.toJSON().lat)
                                );

                                if (
                                    radiansToDegrees(angle) > 90 ||
                                    radiansToDegrees(angle) < 0
                                ) {
                                    print("right");
                                    icon = "{{ asset('delivery_plan/truck (left).png') }}";
                                } else {
                                    icon = "{{ asset('delivery_plan/truck (right).png') }}";
                                }
                            }

                            var marker = new google.maps.Marker({
                                position: my_route.legs[i].start_location,
                                icon: icon,
                                zIndex: 10,
                                map: map,
                            });
                        }
                    }
                });

            // This function is to add markers on the route -- For completed points
            for (var i = 0; i < completeted_point.length; i++) {
                const contentString =
                    '<div id="content">' +
                    '<div id="siteNotice">' +
                    "</div>" +
                    '<h2 id="firstHeading" class="firstHeading" style="color: green;">Delivered</h4>' +
                    '<div id="bodyContent">' +
                    "<p><b>Pump: </b> " +
                    completeted_point[i].officeName +
                    "</p>" +
                    "<p><b>Last updated: </b>" +
                    new Date(
                        completeted_point[i].lastUpdatetime
                    ).toDateString() +
                    "</p>" +
                    "</div>" +
                    "</div>";
                const infowindow = new google.maps.InfoWindow({
                    content: contentString,
                    ariaLabel: "Delivered",
                });
                const completedMarker = new google.maps.Marker({
                    position: completeted_point[i].location,
                    icon: {
                        url: "{{ asset('delivery_plan/green flag.png') }}",
                        size: new google.maps.Size(30, 32),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(10, 18),
                    },
                    zIndex: 100,
                    map: map,
                });

                completedMarker.addListener("click", () => {
                    if (activeInfoWindow) {
                        activeInfoWindow.close();
                    }
                    infowindow.open({
                        anchor: completedMarker,
                        map,
                        shouldFocus: false,
                    });
                    activeInfoWindow = infowindow;
                });
            }

            // This function is to add markers on the route -- For Intimate points
            for (var i = 0; i < intimate_point.length; i++) {
                const contentString =
                    '<div id="content">' +
                    '<div id="siteNotice">' +
                    "</div>" +
                    '<h2 id="firstHeading" class="firstHeading" style="color: blue;">Intimate</h4>' +
                    '<div id="bodyContent">' +
                    "<p><b>Last updated: </b>" +
                    new Date(
                        completeted_point[i].lastUpdatetime
                    ).toDateString() +
                    "</p>" +
                    "</div>" +
                    "</div>";
                const infowindow = new google.maps.InfoWindow({
                    content: contentString,
                    ariaLabel: "Intimate",
                });
                const intimateMarker = new google.maps.Marker({
                    position: intimate_point[i].location,
                    icon: {
                        url: "{{ asset('delivery_plan/blue flag.png') }}",
                        size: new google.maps.Size(30, 32),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(10, 18),
                    },
                    zIndex: 100,
                    map: map,
                });
                completedMarker.addListener("click", () => {

                    if (activeInfoWindow) {
                        activeInfoWindow.close();
                    }
                    infowindow.open({
                        anchor: completedMarker,
                        map,
                        shouldFocus: false,
                    });
                    activeInfoWindow = infowindow;
                });
            }
        }, 1000);
    }
</script>
