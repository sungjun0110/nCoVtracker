<!DOCTYPE html>
<html>
  <head>
    <?php wp_head();?>
    <!-- <link rel='stylesheet' type='text/css' href='wp-content/themes/nCoVtracker/style.css' > -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta http-http-equiv="X-YA-Compatible" content="ie=edge">
    <meta name='keywords' content="Coronavirus, nCoVtracker, ncov, Covid, Covid-19, Sars-Cov-2, Outbreak, Pandemic, Virus, Confirmed Cases, Live Cases">
    <meta name='description' content='nCoVtracker is created to track all novel coronavirus cases.'>
    <script data-ad-client="ca-pub-4435018117840586" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script type="text/javascript">
      window._mNHandle = window._mNHandle || {};
      window._mNHandle.queue = window._mNHandle.queue || [];
      medianet_versionId = "3121199";
    </script>
    <script src="https://contextual.media.net/dmedianet.js?cid=8CUS2P526" async="async"></script>

  </head>

<body <?php body_class();?>>

  <header>
    <div class="header">
      <div class="header-left">
        <a href="http://nCoVtracker.com" class="logo"><img width='230px' src="https://ncovtracker.com/asset/logo.png"></a>
          <!-- wp-content/themes/nCoVtracker/asset/logo.png for test -->
      </div>

      <div class='header-right'>

        <nav class="site-nav">

            <?php
              $args = array(
                'theme_location' => 'top-menu'
              );
            ?>
            <?php wp_nav_menu( $args );?>

            <!-- <div class="mobile">
              <a href='http://ncovtracker.com/?am_force_theme_layout=mobile'>Mobile</a>
            </div> -->
        </nav>
      </div>

    </div>
  </header>
