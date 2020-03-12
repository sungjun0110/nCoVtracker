<?php get_header();?>

<div id="main-screen">
  <div class="screen side left">
    <div class="card mb-2">
      <div class="card_body m-2">
          <!-- <a href='http://localhost/wordpress/?am_force_theme_layout=mobile'>Mobile</a> -->
        <div class='left-top'>
          <h3>Board</h3>
          <b id='update-time'><br></b>
          </b>
            <a href='http://ncovtracker.com/?am_force_theme_layout=mobile'><br>Mobile Site</a>
          </b>

          <b><br><br>I am solely keeping up this website, please help maintain nCoVTracker with your donation!</b>
          <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
          <input type="hidden" name="cmd" value="_s-xclick" />
          <input type="hidden" name="hosted_button_id" value="P7E4KSBZVAZ2E" />
          <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
          <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
          </form>

        </div>
      </div>
    </div>
    <div class="card mb-2">
      <div class="card_body m-2">
        <h3>Today's News</h3>
        <iframe id="todays-news" width="370" height="208" src=""
        frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen></iframe>
        <div class="news-controller">
          <a href="#" id="prev">Prev</a>
          <a href="#" id="next">Next</a>
        </div>
      </div>
    </div>



    <div class="card mb-2" style="height: 300px; overflow-y: hidden;">
      <div class="card_body m-2">
        <h4 id="video-title">How to Wash Your Hands Properly</h4>
        <iframe id='video' width="370" height="208"
          src="https://www.youtube.com/embed/mcOdaqQ_IAU"
          frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen>
        </iframe>

        <div class="news-controller">
          <a href="#" id="prev2" style="display:none">Prev</a>
          <a href="#" id="next2">Next</a>
        </div>
      </div>

    </div>

    <div id="111589682">
    <script type="text/javascript">
        try {
            window._mNHandle.queue.push(function (){
                window._mNDetails.loadTag("111589682", "300x250", "111589682");
            });
        }
        catch (error) {}
    </script>
    </div>
  </div>

  <div class="screen middle">
    <div class="middle-top">
      <div id="map"></div>
    </div>
    <div class="middle-bot left">
      <div class="card mb-2" style="border:2px solid #2f2d8640; border-radius: 7px;">
        <div class="card_body m-2 current-cases">
          <h5>Current Cases</h5>
          <p>Confirmed</p>
          <p id='confirmed'>0</p>
          <p>Death</p>
          <p id='death'>0</p>
          <p>Recovery</p>
          <p id='recovery'>0</p>
        </div>
      </div>
    </div>

    <div class="middle-bot right">
      <div class="chart-controller">
        <div class='controller-buttons'>
          <button type='button' id="country" class='selected'>Country Detail</button>
          <button type='button' id="world">Comparison</button>
        </div>
        <div class="chart-search">
          <input id='chart-search-input' type='hidden' placeholder='Enter country name (max: 7)'>
          <table class="search-table">
          <tbody id='livesearch'></tbody>
          </table>
        </div>

        <!-- <select id="start-date2" style='display: block'>
          <option value='' disabled selected>Start Date</option>
        </select> -->
        <select id="start-date" style='visibility: hidden'>
          <option value='' disabled selected>Start Date</option>
        </select>

        <button type='button' id="reset" style='visibility: hidden;'>Reset</button>

      </div>
      <div class="card mb-2">
        <div class="card_body m-2 chart-container" >
          <canvas id="ncovChart" style="background-image: url('asset/chartimg.png');
            background-repeat: no-repeat; background-position: center;"></canvas>
          <canvas id="ncovChart2" style="background-image: url('asset/chartimg.png');
            background-repeat: no-repeat; background-position: center;"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="screen side right">

        <div class="table-search-bar">
          <input id="table-search-input" type="text" placeholder="Enter country name">
        </div>

    <div class="card mb-2" style='width:376px;'>
      <div class="card_body m-2">
        <table id="ncovTable" style='width:357px;'></table>
      </div>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js">
</script>
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=[key]">
</script>


<?php get_footer();?>
