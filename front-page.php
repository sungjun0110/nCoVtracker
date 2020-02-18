<?php get_header();?>

<?php
  include_once "data.php";
?>


<div id="second-header">
  <div class="custom-select">

  </div>
</div>

<div id="map"></div>

<script type="text/javascript">
  var infected_cases = <?php echo json_encode($data, true);?>;
  var infected_cases_canada = <?php echo json_encode($data_CA, true);?>;
  var infected_cases_world = <?php echo json_encode($data_world, true); ?>;

  var locations = [];
  var cases = [];
  var locations_CA = [];
  var cases_CA = [];
  var locations_world = [];
  var cases_world = [];

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
  // console.log(infected_cases); // for debugging
  // console.log(country_coords);

  // world locations
  for (var i = 0; i < infected_cases_world.length; i++) {
    locations_world.push({lat: parseFloat(infected_cases_world[i]["lat"]), lng: parseFloat(infected_cases_world[i]["lng"])});
  }
  // world cases details
  for (var i = 0; i < infected_cases_world.length; i++) {
    cases_world.push([infected_cases_world[i]["name"], infected_cases_world[i]["confirmed"], infected_cases_world[i]["death"], infected_cases_world[i]["recovery"]]);
  }

  var map;
  function initMap(){
    // Map options
    var options = {
      zoom:4,
      center:{lat:44.669386, lng:-96.474131},
      minZoom:2,
      maxZoom:8,
    }
    // New map
    map = new google.maps.Map(document.getElementById('map'), options);

    var markImage = 'https://github.com/sungjun0110/googleMapApi/blob/master/regularMarker.png?raw=true';
    var worldMarkerImage = 'https://github.com/sungjun0110/nCoVtracker/blob/master/worldMarker.png?raw=true';
    var infowindow = new google.maps.InfoWindow();
    var usMarker = 'https://github.com/sungjun0110/nCoVtracker/blob/master/USmarker.png?raw=true';
    var caMarker = 'https://github.com/sungjun0110/nCoVtracker/blob/master/CAmarker.png?raw=true';
    var customMarker = 'https://github.com/sungjun0110/nCoVtracker/blob/master/customMarker.png?raw=true';

    // markers for US cases
    var markers = locations.map(function(location, i) {
      var marker = new google.maps.Marker({
        position: locations[i],
        title: "Case No. " + cases[i][0],
        icon: usMarker,
        map:map
      });
      var content = "Case No. " + cases[i][0] + " in " + cases[i][2] + "<br>" + "Date: " + cases[i][1];

      google.maps.event.addListener(marker,'click', function(evt) {
        infowindow.setContent(content);
        infowindow.open(map, marker);
      })
      return marker;
    });

    // markers for Canadian cases
    var markers_CA = locations_CA.map(function(location, i) {
      var marker = new google.maps.Marker({
        position: locations_CA[i],
        title: "Case No. " + cases_CA[i][0],
        icon: caMarker,
        map:map
      });
      var content = "Case No. " + cases_CA[i][0] + " in " + cases_CA[i][2] + "<br>" + "Date: " + cases_CA[i][1];

      google.maps.event.addListener(marker,'click', function(evt) {
        infowindow.setContent(content);
        infowindow.open(map, marker);
      })
      return marker;
    });

    // markers for world cases
    var world_markers = locations_world.map(function(location, i) {
      var marker = new google.maps.Marker({
        position: locations_world[i],
        title: cases_world[i][0],
        icon: worldMarkerImage,
        map:map
      });
      var content = cases_world[i][1] + " confirmed cases in " + cases_world[i][0];

      google.maps.event.addListener(marker,'click', function(evt) {
        infowindow.setContent(content);
        infowindow.open(map, marker);
      })
      return marker;
    });

    map.addListener('click', function(e) {
      placeMarker(e.latLng, map);
    });

    function placeMarker(latLng, map) {
      var marker = new google.maps.Marker({
        position: latLng,
        map: map,
        icon: customMarker,
      });

      google.maps.event.addListener(marker,'click', function(evt) {
        marker.setMap(null);
      })
  }
}

  // console.log(cases_CA);
  // console.log(cases);
  console.log(locations_world);
  var htmlcode = '<select>';
  for (var i = 0; i < cases_world.length; i++) {
    htmlcode += '\n<option value="' + i + '">' + cases_world[i][0] + " - "
    + " Confirmed: " + cases_world[i][1]
    + " Deaths: " + cases_world[i][2]
    + " Recoveries: " + cases_world[i][3] + '</option>\n';
  }
  htmlcode += "</select>";

  function moveTo(sel) {
    // var value = sel.value;
    console.log(sel);
    map.panTo(locations_world[sel]);
  }

  document.getElementsByClassName('custom-select')[0].innerHTML = htmlcode;
</script>
<script src="https://unpkg.com/@google/markerclustererplus@4.0.1/dist/markerclustererplus.min.js">
</script>
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=[[[API KEY]]]&callback=initMap">
</script>

<?php get_footer();?>
