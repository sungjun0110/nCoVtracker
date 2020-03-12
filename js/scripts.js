$(document).ready(function(){
    var world_case_detail;
    var infected_cases_world;
    var locations_dict = {};
    var etc;
    var map;
    var check = true;
    var video_links = [];
    var news_links = [];
    var index_length;
    var world_chart_number = 0;
    var world_chart_dates = {};
    var news_index = 0;
    var colors = ['rgb(30, 144, 255, 0.7)', 'rgb(235, 158, 52, 0.7)', 'rgb(212, 108, 255, 0.7)', 'rgb(47, 45, 134, 0.7)',
      'rgb(129, 243, 38, 0.7)', 'rgb(45, 230, 252, 0.7)', 'rgb(245, 66, 66, 0.7)']; // dodgerblud, orange, light purple, yellow, light green, light blue, red
    var myCompareChart = document.getElementById("ncovChart2").getContext('2d');
    var compareChart;

    var myCaseChart = document.getElementById("ncovChart").getContext('2d');
    var caseChart;

    function chartInit(){
      caseChart = new Chart(myCaseChart, {
        type:'line', //bar, horizontalBar, pie, line, doughnut, radar, polarArea
        data: {
          datasets: [{
            label: "Confirmed",
            data: '',
            backgroundColor: 'rgb(235, 158, 52, 0.5)',
            lineTension: 0,
            fill:'2',
            pointRadius:0
          }, {
            label: "Death",
            data: '',
            backgroundColor: 'rgb(245, 66, 66, 0.5)',
            lineTension: 0,
            fill:'origin',
            pointRadius:0
          }, {
            label: "Recovery",
            data: '',
            backgroundColor: 'rgb(30, 100, 255, 0.5)',
            lineTension: 0,
            fill:'origin',
            pointRadius:0
          }]
        },
        options: {
          title: {
            display: true,
            text: "SARS-CoV-2 Cases  -  World",
            fontSize: 22
          },
          aspectRatio: 1.55,
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero:true
              }
            }],
            xAxes: [{
              ticks: {
                max: 10,
                reverse:true
              }
            }]
          }
        }
      });
    }

    function compareChartInit(){
      compareChart = new Chart(myCompareChart, {
        type:'scatter', //bar, horizontalBar, pie, line, doughnut, radar, polarArea
        data: {
          datasets: []
        },
        options: {
          title: {
            display: true,
            text: "SARS-CoV-2 Confirmed Cases",
            fontSize: 22
          },
          aspectRatio: 1.55,
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero:true
              }
            }],
            xAxes: [{
              ticks: {
                stepSize: 2,
                reverse:true,
                callback: function(index){
                  return world_chart_dates[index];
                }
              }
            }]
          }
        }
      });
    }

    video_links= ["https://www.youtube.com/embed/mcOdaqQ_IAU", "https://www.youtube.com/embed/xjcsrU-ZmgY"];
    chartInit();
    compareChartInit();
    $("#next2").click(function(){
      $('#video-title').text('How do viruses spread?');
      $("#video").attr("src", video_links[1]);
      $('#next2').hide();
      $('#prev2').show();
    });

    $("#prev2").click(function(){
      $('#video-title').text('How to Wash Your Hands Properly');
      $("#video").attr("src", video_links[0]);
      $('#prev2').hide();
      $('#next2').show();
    });
    initVar();

    function initVar() {
      $.ajax({
        url: "wp-content/themes/nCoVtracker/data.php",
        success: function(data){
          infected_cases_world = JSON.parse(data);
          // console.log(infected_cases_world);
          for (var i = 0; i < infected_cases_world.length; i++) {
            locations_dict[infected_cases_world[i]["name"]] = {lat: parseFloat(infected_cases_world[i]["lat"]), lng: parseFloat(infected_cases_world[i]["lng"])};
          }
          $.ajax({
            url: "wp-content/themes/nCoVtracker/init-data.php",
            success: function(data) {
              world_case_detail = JSON.parse(data);
              // console.log(world_case_detail);
              if(check){
                myTable();
                initMap();
                updateChart("World");
                check=false;
              }
              $.ajax({
                url: "wp-content/themes/nCoVtracker/etc-data.php",
                success: function(data) {
                  etc = JSON.parse(data);
                  initTodaysNews(etc);
                }
              });
            }
          });
        }
      });

      setTimeout(initVar, 3600000);
    }

    // Today's News
    function initTodaysNews(etc){
      document.getElementById("update-time").innerHTML = etc[0][0];
      document.getElementById("todays-news").src = etc[1][0];
      for (var i = 1; i < (etc.length); i++){
          news_links.push(etc[i][0]);
      }
      index_length = etc.length -1;

      // todays-news controller
      $("#next").click(function(){
        if (news_index < index_length) {
            news_index++;
            $("#todays-news").attr("src", news_links[news_index]);
            if (news_index == index_length-1){
              $('#next').hide();
            }
            else{
              $('#prev').show();
            }
        }
      });

      $("#prev").click(function(){
        if (news_index > 0){
            news_index--;
            $("#todays-news").attr("src", news_links[news_index]);
            if (news_index == 0){
              $('#prev').hide();
            }
            else{
              $('#next').show();
            }
        }
      });
    }

    function initMap(){
      // Map options
      var options = {
        zoom:2,
        center:{lat:26.797493, lng:6.567761},
        minZoom:2,
        maxZoom:7,
      }

      // New map
      map = new google.maps.Map(document.getElementById('map'), options);

      var infowindow = new google.maps.InfoWindow();

      var world_marker = 'wp-content/themes/nCoVtracker/asset/world.png';
      var markers = ['wp-content/themes/nCoVtracker/asset/world.png',
          'wp-content/themes/nCoVtracker/asset/0.png',
          'wp-content/themes/nCoVtracker/asset/1.png',
          'wp-content/themes/nCoVtracker/asset/10.png',
          'wp-content/themes/nCoVtracker/asset/100.png',
          'wp-content/themes/nCoVtracker/asset/1000.png',
          'wp-content/themes/nCoVtracker/asset/10000.png'];

      function marker(n){
        if (n > 0 && n < 10){
          return markers[0];
        }
        else if (n > 10 && n < 100) {
          return markers[1];
        }
        else if (n > 100 && n < 1000) {
          return markers[2];
        }
        else if (n > 100 && n < 1000) {
          return markers[3];
        }
        else{
          return markers[4];
        }
      }

      // markers for world cases
      var world_markers = world_case_detail.map(function(location, i) {
        var j = world_case_detail[i][3];

        if (j == 0 ){
          return;
        }
        else if (j > 0 && j < 10){
          initMarker(2);
        }
        else if (j >= 10 && j < 100) {
          initMarker(3);
        }
        else if (j >= 100 && j < 1000) {
          initMarker(4);
        }
        else if (j >= 1000 && j < 10000) {
          initMarker(5);
        }
        else{
          initMarker(6);
        }

        var marker;

        function initMarker(n) {
          marker = new google.maps.Marker({
            position: {lat: parseFloat(world_case_detail[i]["lat"]), lng: parseFloat(world_case_detail[i]["lng"])},
            title: world_case_detail[i][0],
            icon: markers[n],
            map:map
          });
        }

        var content = "<h6>" + world_case_detail[i][0] + "</h6>" + "<b>" + "Confirmed Cases: " + world_case_detail[i][3] + "<br>Deaths: " + world_case_detail[i][4] + "<br/>Recoveries: " + world_case_detail[i][5] + "</b>";

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
          icon: 'wp-content/themes/nCoVtracker/asset/green.png',
        });

        google.maps.event.addListener(marker,'click', function(evt) {
          marker.setMap(null);
        })
      }
    }

    // panning map
    function moveTo(sel) {
      if (sel == 'World') {
        map.setZoom(2);
        map.panTo({lat:37.390487, lng:0.488139});
      }
      else if ( sel == 'Russia' ) {
        map.panTo(locations_dict[sel]);
        map.setZoom(3);
      }
      else if (sel == 'Canada' || sel == 'United States' || sel == 'China' || sel == 'Brazil'
        || sel == 'Australia' || sel == 'Argentina' || sel == 'Chile') {
        map.panTo(locations_dict[sel]);
        map.setZoom(4);
      }
      else {
        map.panTo(locations_dict[sel]);
        map.setZoom(5);
      }
    }

    function currentCases(data){
      document.getElementById("confirmed").innerHTML = data[0] + " " + "(+" + (data[0] - data[3]) + ")";
      document.getElementById("death").innerHTML = data[1] + " " + "(+" + (data[1] - data[4]) + ")";
      document.getElementById("recovery").innerHTML = data[2] + " " + "(+" + (data[2] - data[5]) + ")";
    }

    // Table
    function myTable() {

      var table = "<tr><th>Country</th><th> Confirmed </th><th> Death </th><th> Recovery </th></tr><tbody id='table-body'>";
      table += "<tr class='selected'><td>" +
      infected_cases_world[0][0] + "</td><td>" +
      infected_cases_world[0][3] + "</td><td>" +
      infected_cases_world[0][4] + "</td><td>" +
      infected_cases_world[0][5] + "</td></tr>";
      for (var i = 1; i < infected_cases_world.length; i++) {
        table += "<tr><td>" +
        infected_cases_world[i][0] + "</td><td>" +
        infected_cases_world[i][3] + "</td><td>" +
        infected_cases_world[i][4] + "</td><td>" +
        infected_cases_world[i][5] + "</td></tr>";
      }
      table += "</tbody>"
      document.getElementById("ncovTable").innerHTML = table;

      $("#table-body tr").click(function ()
      {
          $(this).toggleClass('selected').siblings().removeClass('selected');
          updateChart($(this).children().first().text());
          moveTo($(this).children().first().text());
      });

      $("#table-search-input").on("keyup", function(){
        var value = $(this).val().toLowerCase();
        $("#table-body tr").filter(function() {
          $(this).toggle($(this).children('td').first().text().toLowerCase().indexOf(value) > -1).addClass("tr");
        });
      });
    }


    // chart-controller
    $('.controller-buttons button').on('click', function(){
      $('.controller-buttons button').removeClass('selected');
      $(this).addClass('selected');
    });

    $('#world').on('click', function(){
      $('#chart-search-input').attr('type', 'text');
      $('#reset').css('visibility', 'visible');
      $('#start-date').css('visibility', 'visible');
      $('#start-date2').css('display', 'none');
      $('#ncovChart').css('z-index', -1);
      $('#ncovChart2').css('z-index', 1);
    });

    $('#country').on('click', function(){
      $('#chart-search-input').attr('type', 'hidden');
      $('#reset').css('visibility', 'hidden');
      $('#start-date').css('visibility', 'hidden');
      $('#start-date2').css('display', 'block');
      $('#ncovChart').css('z-index', 1);
      $('#ncovChart2').css('z-index', -1);
    });

    $('#reset').on('click', function() {
      compareChartInit();
      removeStartDate();
      world_chart_number = 0;
    });

    $('#reset').mouseenter(function(){
      $(this).css('backgroundColor', '#ff1e1e80');
    });

    $('#reset').mouseleave(function(){
      $(this).css('backgroundColor', '#f3f3f3');
    });

    $('#chart-search-input').keyup(function(){
      var str = this.value;

      if (str.length == 0) {
        document.getElementById("livesearch").innerHTML="";
        document.getElementById("livesearch").style.border="0px";
      }

      else{
        $.ajax({
          type: 'POST',
          url: 'wp-content/themes/nCoVtracker/search.php',
          data: { q: str },
          success: function(data) {
            document.getElementById("livesearch").innerHTML = data;
            document.getElementById("livesearch").style.border = "1px solid #ccc";

            $('#livesearch tr td').click(function(){
              var name = this.innerHTML;
              console.log(name);
              $.ajax({
                type: 'POST',
                url: "wp-content/themes/nCoVtracker/country-search.php",
                data: { a: name },
                success: function(data){

                  var chartdata = JSON.parse(data);
                  var chartdata_length = chartdata.length-1;


                  if (world_chart_number == 0){
                    updateCompareChart(chartdata, name);
                  }

                  else if (world_chart_number < 7){
                    updateCompareChart(chartdata, name, chartdata_length);
                  }

                }
              });
            });

            $("body").click(function(){
              $(".search-table").hide();
            });

            $("#chart-search-input").keyup(function(){
              $(".search-table").show();
            });
          }
        });
      }
    });

    function initStartDate() {
      var select = "<option value='' disabled selected>Start Date</option>";
      for (let i = Object.keys(world_chart_dates).length-1; i > 0; i--) {
        select += "<option value=" + i + ">" + world_chart_dates[i] + "</option>";
      }
      document.getElementById("start-date").innerHTML = select;

      $('#start-date').click(function(){
        if ($(this).val() != null){
          compareChart.options.scales.xAxes[0].ticks.max = parseInt($(this).val());
          compareChart.update();
        }
      });
    }

    // function initStartDate2(dates) {
    //   var select = "<option value='' disabled selected>Start Date</option>";
    //   for (let i = dates.length-1; i > 0; i--) {
    //     select += "<option value=" + i + ">" + dates[i] + "</option>";
    //   }
    //   document.getElementById("start-date2").innerHTML = select;
    //
    //   $('#start-date2').click(function(){
    //     console.log($(this).val());
    //     if ($(this).val() != null){
    //       caseChart.options.scales.xAxes[0].ticks.max = parseInt($(this).val());
    //       caseChart.update();
    //     }
    //   });
    // }

    function removeStartDate(){
      document.getElementById("start-date").innerHTML = "<option value='' disabled selected>Start Date</option>";
    }

    function updateCompareChart(newData, name, length){
      $.ajax({
        type: 'POST',
        url: "wp-content/themes/nCoVtracker/country-data.php",
        data: { a: name },
        success: function(data){
          let chartdata = JSON.parse(data);
          var data = [];

          if (chartdata.length > Object.keys(world_chart_dates).length){
            world_chart_dates = {};
            for (let i = 0; i < chartdata.length; i++){
              world_chart_dates[i] = chartdata[i][0];
            }
          }

          initStartDate();

          for (var i = 0; i < chartdata.length; i++) {
            data.push({x: i, y: parseInt(chartdata[i][1])});
          }

          compareChart.data.datasets.push({label: name, data: data, borderColor: colors[world_chart_number],
            fill: false, showLine:true, lineTension: 0, pointRadius: 0});
          compareChart.update();
          world_chart_number += 1;
          if (world_chart_number == 7){
            $('#chart-search-input').attr('type', 'hidden');
          }
        }
      });
    }

    function updateChart(str) {
      $.ajax({
        type: 'POST',
        url: "wp-content/themes/nCoVtracker/country-data.php",
        data: { a: str },
        success: function(data){
          let chartdata = JSON.parse(data);
          var l = [];
          var c = [];
          var d = [];
          var r = [];
          for (let i = 0; i < chartdata.length; i++){
            l.push(chartdata[i][0]);
            c.push(parseInt(chartdata[i][1]));
            d.push(parseInt(chartdata[i][2]));
            r.push(parseInt(chartdata[i][3]));
          }
          currentCases([c[0], d[0], r[0], c[1], d[1], r[1]]);
          caseChart.data.labels = l;
          caseChart.data.datasets[0].data = c;
          caseChart.data.datasets[1].data = d;
          caseChart.data.datasets[2].data = r;
          caseChart.options.title.text = 'SARS-CoV-2 Cases  -  ' + str;
          caseChart.update();

          // initStartDate2(l);
        }
      });
    }

}); // end
