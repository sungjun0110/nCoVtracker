<?php get_header();?>
<!-- <div class="container pt-3">
  <div class="secondHeader">
    <nav class="site-nav children-links">
      <ul>
        <?php
          $args = array(
            'theme_location' => 'page-menu'
          );
        ?>

        <?php
          wp_nav_menu($args);
        ?>
      </ul>
    </nav>
  </div>
</div> -->

<div class="container pt-3 pb-3">
  <div class="main-column">

  <?php if (have_posts()) : while(have_posts()) : the_post();?>
    <div class="card mb-4">
      <div class="card_body m-3">
        <h3><?php the_title();?></h3>
        <?php if(has_post_thumbnail()):?>
          <img src="<?php the_post_thumbnail_url('smallest');?>" class="img-fluid">
        <?php endif;?>
        <?php the_content();?>
      </div>
    </div>
    <?php endwhile; endif;?>

  </div>
  <div class="secondary-column">
    <div class="card mb-4">
      <div class="card_body m-3">
        <?php dynamic_sidebar('sidebar1');?>
      </div>
    </div>
  </div>
</div>

<?php get_footer();?>
