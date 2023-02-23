<html>
  <head>
    <title>Power Station of India</title>
    <!-- <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script> -->
	<style>
	/*
 * Always set the map height explicitly to define the size of the div element
 * that contains the map.
 */
#map {
  height: 100%;
}

/*
 * Optional: Makes the sample page fill the window.
 */
html,
body {
  height: 100%;
  margin: 0;
  padding: 0;
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

@media(max-width:640px)
{
 .gm-style .gm-style-iw-d  {width: 400px !important;}
.info-window {font-size: 26px !important;}
}




	</style>
  </head>
  <body>

    <div id="map"></div>
    <!-- <div id="legend"><h3>Legend</h3></div> -->

    <!--
     The `defer` attribute causes the callback to execute after the full HTML
     document has been parsed. For non-blocking uses, avoiding race conditions,
     and consistent behavior across browsers, consider loading using Promises
     with https://www.npmjs.com/package/@googlemaps/js-api-loader.
    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDN32TA762x19KhBZX91X4uNcmdGAhAlrQ&callback=initMap&v=weekly" defer></script>
	<script>
	let map;



function initMap() {
	let infoHTML = '';
  map = new google.maps.Map(document.getElementById("map"),
  {
    zoom:5.01,
    center: new google.maps.LatLng(21.125498, 81.914063),
    mapTypeId: "roadmap",
	backgroundColor: '#fefefe',
    tilt: 1.5,
    disableDefaultUI: true,
    zoomControl: false,
	styles: [
    {
    "featureType": "water",
    "elementType": "geometry",
    "stylers": [
      { "visibility": "on" }
    ]
    },{
    "featureType": "landscape",
    "stylers": [
      { "visibility": "off" }
    ]
    },{
    "featureType": "road",
    "stylers": [
      { "visibility": "off" }
    ]
    },{
    "featureType": "administrative",
    "stylers": [
      { "visibility": "on" }
    ]
    },{
    "featureType": "poi",
    "stylers": [
      { "visibility": "on" }
    ]
    },{
    "elementType": "labels",
    "stylers": [
      { "visibility": "off" }
    ]
    }
  ]


  });



  var historicalOverlay;

    // var imageBounds = new google.maps.LatLngBounds(
    //     new google.maps.LatLng(6.782525, 67.249219),
    //     new google.maps.LatLng(37.583628, 97.821),

    // );
    var imageBounds={
        north: 37.079356,
        south: 8.079190 ,
        east:  96.965078,
        west:  68.090387
    };
    

    historicalOverlay = new google.maps.GroundOverlay(
        '{{asset('images/india-map.svg')}}',

        imageBounds,
        {opacity: 1},
        {tilt:35}
        );
    historicalOverlay.setMap(map);
  const iconBase = "{{asset('images/icons')}}/";
  const icons = {
    NUCLEAR: {
      name: "Nuclear",
      icon: iconBase + "nuclear.svg",
    },
    THERMAL: {
      name: "Thermal",
      icon: iconBase + "thermal.svg",
    },
    SOLAR: {
      name: "Solar",
      icon: iconBase + "solar.svg",
    },
    HYDRO: {
      name: "Hydro",
      icon: iconBase + "hydro.svg",
    },
    WIND: {
      name: "Wind",
      icon: iconBase + "wind.svg",
    },
  };
//console.log(icons);
  var mapData= '{!! $map_data !!}';


    //  mapData=JSON.parse(mapData);
    let features=[];
    if (mapData != '') {

        mapData = JSON.parse(mapData);
        //console.log(mapData);
        mapData.forEach(data_stat => {
            //
            const newArray={
                                position: new google.maps.LatLng(data_stat.lat,data_stat.lng),
                                type: data_stat.FuelType,
                                textData: data_stat.PowerStationName,
                                textTitle: data_stat.SectorTypeName,
                            } ;
//console.log(data_stat.FuelType);
                        features.push(newArray);
        });


    }
     console.log(features);
    
//  console.log(features_);

  features.forEach((feature) => {
    //console.log(feature[0].type);

    const marker = new google.maps.Marker({
      position: feature.position,
      icon: icons[feature.type].icon,
      map: map
    });


 
   
    const infowindow = new google.maps.InfoWindow({
      content: `<div class="info-window">
                    <h3>${feature.textTitle}</h3>
                    <p>${feature.textData}</p>
                </div>`
    });

   

	 marker.addListener("click", () => {
		infowindow.open({
		  anchor: marker,
		  map,
		  shouldFocus: true,
		});
	  });


  });

 bounds  = new google.maps.LatLngBounds( 
	new google.maps.LatLng(8.282, 76.64),
	 //new google.maps.LatLng(8.583, 77.721),
	//new google.maps.LatLng(30.583, 87.721),
	new google.maps.LatLng(30.583, 97.721),

);

	

map.fitBounds(bounds);       
map.panToBounds(bounds); 


}






window.initMap = initMap;


	</script>




  </body>
</html>
