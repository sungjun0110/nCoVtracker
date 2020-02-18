<!DOCTYPE html>
<html>
  <head>
    <?php wp_head();?>
    <!-- <link rel='stylesheet' type='text/css' href='wp-content/themes/nCoVtracker/style.css' >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta http-http-equiv="X-YA-Compatible" content="ie=edge"> -->
  </head>

<body <?php body_class();?>>

  <header class="header" id="myHeader">
      <a href="http://nCoVtracker.com" class="logo"><img width="185px"
        src="https://github.com/sungjun0110/nCoVtracker/blob/master/logo.png?raw=true"> </a>

      <nav class="site-nav">
          <?php
            $args = array(
              'theme_location' => 'top-menu'
            );
          ?>
          <?php wp_nav_menu( $args );?>
      </nav>
  </header>
