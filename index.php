<?php
get_header(); ?>

<?php
  include_once "data.php"
?>

<body>
  <div id="map"></div>
  <script>
    var infected_cases = <?php echo json_encode($data, true);?>;
    var infected_cases_canada = <?php echo json_encode($data_CA, true);?>;

    var locations = []
    var cases = []
    var locations_CA = []
    var cases_CA = []

    // locations in US
    for (var i = 0; i < infected_cases.length; i++) {
      locations.push({lat: parseFloat(infected_cases[i]["lat"]), lng: parseFloat(infected_cases[i]["lng"])});
    }
    // locations in CA
    for (var i = 0; i < infected_cases_canada.length; i++) {
      locations_CA.push({lat: parseFloat(infected_cases_canada[i]["lat"]), lng: parseFloat(infected_cases_canada[i]["lng"])});
    }
    // case details in US
    for (var i = 0; i < infected_cases.length; i++) {
      cases.push([infected_cases[i]["case_index"], infected_cases[i]["date"], infected_cases[i]["address"]]);
    }
    // case details in CA
    for (var i = 0; i < infected_cases_canada.length; i++) {
      cases_CA.push([infected_cases_canada[i]["case_index"], infected_cases_canada[i]["date"], infected_cases_canada[i]["address"]]);
    }

    //console.log(infected_cases); // for debugging
    var infoObj = [];

    function initMap(){
      // Map options
      var options = {
        zoom:4,
        center:{lat:44.669386, lng:-96.474131}
      }
      // New map
      var map = new google.maps.Map(document.getElementById('map'), options);

      var markImage = 'https://github.com/sungjun0110/googleMapApi/blob/master/regularMarker.png?raw=true';
      var infowindow = new google.maps.InfoWindow();

      var markers = locations.map(function(location, i) {
        var marker = new google.maps.Marker({
          position: locations[i],
          title: "Case No. " + cases[i][0],
          icon: markImage,
          map:map
        });
        var content = "Case No. " + cases[i][0] + " in " + cases[i][2] + "<br>" + "Date: " + cases[i][1];

        google.maps.event.addListener(marker,'click', function(evt) {
          infowindow.setContent(content);
          infowindow.open(map, marker);
        })
        return marker;
      });

      var markers_CA = locations_CA.map(function(location, i) {
        var marker = new google.maps.Marker({
          position: locations_CA[i],
          title: "Case No. " + cases_CA[i][0],
          icon: markImage,
          map:map
        });
        var content = "Case No. " + cases_CA[i][0] + " in " + cases_CA[i][2] + "<br>" + "Date: " + cases_CA[i][1];

        google.maps.event.addListener(marker,'click', function(evt) {
          infowindow.setContent(content);
          infowindow.open(map, marker);
        })
        return marker;
      });


      // Add a marker clusterer to manage the markers.
      var markerCluster = new MarkerClusterer(map, markers,
          {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
      var markerCluster_CA = new MarkerClusterer(map, markers_CA,
          {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
    }

    console.log(cases_CA);
    console.log(cases);
  </script>
  </script>
  <script src="https://unpkg.com/@google/markerclustererplus@4.0.1/dist/markerclustererplus.min.js">
  </script>
  <script async defer
  src="https://maps.googleapis.com/maps/api/js?key={{{{API-KEY}}}}&callback=initMap">
  </script>
</body>
