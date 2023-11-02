<div>Total Distance : <span id="TotalDistance">0</span></div>
<div>Travel Time : <span id="TotalTime">0</span></div>
<div id="map" style="background: #083f5570 "></div>




<script>
    var map;
    var activeInfoWindow;
    var TotalDistance = 0;
    var TotalTime = 0;
    async function initMap() {
        TotalDistance = 0;
        TotalTime = 0;
        const directionsService = new google.maps.DirectionsService();
        const directionsRenderer = new google.maps.DirectionsRenderer({
            map: map,
            suppressMarkers: true
        });

        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 8,
            options: {
                gestureHandling: 'greedy'
            }
        });
        directionsRenderer.setMap(map);
        let waypt = []
        let json = [];
        let originCord = [];
        let destinationCord = [];

        let infoHTML = '';


        json["Route"] = newList;
        for (let index = 0; index < json["Route"].length - 1; index++) {
            const latitude = json["Route"][index]["latitude"];
            const longitude = json["Route"][index]["longitude"];
            const latitude2 = json["Route"][index + 1]["latitude"];
            const longitude2 = json["Route"][index + 1]["longitude"];
            if (index + 1 < json["Route"].length - 1) {
                waypt.push({
                    location: new google.maps.LatLng(latitude2, longitude2),
                    stopover: true,
                });
            }
            // new google.maps.Marker({
            //   position: new google.maps.LatLng(latitude, longitude),
            //   map,
            //   title: json["Route"][index]["officeName"],
            //   label: { text: index.toString(), color: "white" },
            // });
            if (index == 0) {
                originCord["latitude"] = json["Route"][index]["latitude"];
                originCord["longitude"] = json["Route"][index]["longitude"];
                destinationCord["latitude"] = json["Route"][index]["latitude"];
                destinationCord["longitude"] = json["Route"][index]["longitude"];
            }
            // if (index == json["Route"].length - 2) {
            //     //console.log(json["Route"]);
            //     destinationCord["latitude"] = json["Route"][index]["latitude"];
            //     destinationCord["longitude"] = json["Route"][index]["longitude"];
            // }


        }

        directionsService
            .route({
                origin: new google.maps.LatLng(parseFloat(originCord["latitude"]), parseFloat(originCord[
                    "longitude"])),
                destination: new google.maps.LatLng(parseFloat(destinationCord["latitude"]), parseFloat(
                    destinationCord["longitude"])),
                waypoints: waypt,
                optimizeWaypoints: false,
                travelMode: google.maps.TravelMode.DRIVING,
            })
            .then((response) => {
                console.log(response);
                directionsRenderer.setDirections(response);
                var my_route = response.routes[0];
                console.log(my_route);
                for (var i = 0; i < my_route.legs.length; i++) {
                    const marker = new google.maps.Marker({
                        position: my_route.legs[i].start_location,
                        label: {
                            text: i == 0 ? 'SP' : i.toString(),
                            color: "white"
                        },
                        map: map
                    });
                    let OfficeName = '';
                    const infowindow = new google.maps.InfoWindow({
                        content: `<div class="info-window box-shadow">` +
                            `<h3>` + json["Route"][i]['officeName'] + `</h3>` +
                            `<p>Address : ` + my_route.legs[i].start_address + `</p>` +
                            `<div class="d-flex flex-row justify-content-between flex-wrap"> ` +
                            `<div class="info-window-products  d-flex  flex-column justify-content-between ">` +
                            `<div class="border-bottom border-dark font-weight-bold">Current Stock </div><div>` +
                            (json["Route"][i]['currentStock']).toFixed(3) + ` </div>` +
                            `</div> ` +
                            `<div class="info-window-products  d-flex flex-column justify-content-between ">` +
                            `<div class="border-bottom border-dark font-weight-bold">Available </div><div>` +
                            (json["Route"][i]['totalCapacity'] - json["Route"][i]['currentStock'])
                            .toFixed(3) + ` </div>` +
                            `</div> ` +
                            `<div class="info-window-products   d-flex flex-column justify-content-between ">` +
                            `<div class="border-bottom border-dark font-weight-bold">Suggested </div>` +
                            (json["Route"][i]['atDeliveryRequirement']).toFixed(3) + ` </div>` +
                            `</div> ` +
                            `</div> ` +
                            `<p class="mt-4 text-danger"><b>NextStop : </b><b><u>` + json["Route"][i +
                                1]['officeName'] + `</u></b>(Distance: ` + my_route.legs[i].distance
                            .text + `, Travel Time : ` + my_route.legs[i].duration.text + `)</p>` +
                            `<button class="sr-only" onclick="alert();">Change</button>` +
                            `</div>`
                    });

                    marker.addListener("click", () => {
                        if (activeInfoWindow) {
                            activeInfoWindow.close();
                        }
                        infowindow.open({
                            anchor: marker,
                            map,
                        });
                        activeInfoWindow = infowindow;
                    });
                    TotalDistance += my_route.legs[i].distance.value;
                    TotalTime += my_route.legs[i].duration.value;
                }
                document.getElementById("TotalDistance").innerHTML = zeroPad(TotalDistance / 1000, 1) +
                    ' <b>km</b>';
                document.getElementById("TotalTime").innerHTML = toHoursAndMinutes(TotalTime);

            });
        //directionsService.route()


    }
    var zeroPad = function(num, pad) {
        var pd = Math.pow(10, pad);
        return Math.floor(num * pd) / pd;
    }

    function toHoursAndMinutes(totalSeconds) {
        // const totalMinutes = Math.floor(totalSeconds / 60);

        // const seconds = totalSeconds % 60;
        // const hours = Math.floor(totalMinutes / 60);
        // const minutes = totalMinutes % 60;

        // return hours + '<b>h</b> ' + minutes + '<b>m</b> ' + seconds + '<b>s</b>';
        var duration=totalSeconds*1000;
        var days = Math.floor(duration / (1000 * 60 * 60 * 24));
            var hours = Math.floor((duration % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((duration % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((duration % (1000 * 60)) / 1000);
            // Output the result in an element with id="demo"
            return days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
    }
</script>

@push('script')
<!-- <script src="mapsJavaScriptAPI.js" async defer></script> -->
<script>

     console.clear();
</script>

@endpush

