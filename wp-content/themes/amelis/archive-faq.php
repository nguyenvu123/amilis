<?php get_header();
/**
* Template Name: FAQ
*/

$args_all = array(
  'post_type'  => 'faq',
  'posts_per_page' => -1,
  'order' => 'ASC',
  'orderby' => 'title',
  'post_parent' => 0,
);
$faqs_all = get_posts( $args_all );

$query_all = new WP_Query($args_all);

$header_image = get_field("faq_image_header", 1353);
$faq_h1 = get_field("faq_h1", 1353);
$section_h2 = get_field("section_h2", 1353);

$args_conseils = array(
  'post_type'  => 'faq',
  'posts_per_page' => -1,
  'order' => 'ASC',
  'orderby' => 'title',
  'post_parent' => 0,
  'tax_query' => array(
    array(
      'taxonomy' => 'faq-category',
      'field' => 'slug',
      'terms' => 'CONSEILS'
      )
      )
    );
    // $faqs_conseils = get_posts( $args_conseils );

    $query_conseils = new WP_Query($args_conseils);

    $args_services = array(
      'post_type'  => 'faq',
      'posts_per_page' => -1,
      'order' => 'ASC',
      'orderby' => 'title',
      'post_parent' => 0,
      'tax_query' => array(
        array(
          'taxonomy' => 'faq-category',
          'field' => 'slug',
          'terms' => 'SERVICES'
          )
          )
        );
        // $faqs_services = get_posts( $args_services );
        $query_services = new WP_Query($args_services);



        $args_offre = array(
          'post_type'  => 'faq',
          'posts_per_page' => -1,
          'order' => 'ASC',
          'orderby' => 'title',
          'post_parent' => 0,
          'tax_query' => array(
            array(
              'taxonomy' => 'faq-category',
              'field' => 'slug',
              'terms' => 'OFFRE'
              )
              )
            );
            // $faqs_offre = get_posts( $args_offre );
            $query_offre = new WP_Query($args_offre);

            // $question_icon = file_get_contents(get_bloginfo('template_url') . "/assets/images/faq-help.svg");
            $question_icon = "";

            ?>

            <?php if (!is_home(  )): ?>
            <div class="breadcrumb">
            <div class="container">
            <div class="row">
            <div class="col-xs-12">

            <ul class="list-inline">
            <li><a href="<?php bloginfo('url');?>"><img src="<?php bloginfo('template_url');?>/assets/images/logo-symbol.svg" width="20" alt="Home"></a></li>
            <li>FAQ</li>
            </ul>

            </div>
            </div>
            </div>
            </div>

            <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script> -->
            <script src="<?php echo get_stylesheet_directory_uri() . "/assets/js/util.js" ?>"></script>
            <script src="<?php echo get_stylesheet_directory_uri() . "/assets/js/collapse.js" ?>"></script>
            <script src="<?php echo get_stylesheet_directory_uri() . "/assets/js/tab.js" ?>"></script>

            <section class="hero-section" style="margin-top: 0">
              <div class="bg-image" id="faq-hero-image" style="background-image: url('<?php echo $header_image ?>')">
                <div class="title-container">
                  <div class="row">
                    <div class="text-center">
                      <h1 class="hero-title"><?php echo $faq_h1 ? $faq_h1 : "FAQ - Services d'aide à domicile"; ?></h1>
                    </div>
                  </div>
                </div>
              </div>
            </section>

            <?php endif; ?>
            <section style="padding:24px 0;">
            <div class="container">
            <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
            <li class="nav-item radio-tile">
            <a class="nav-link active" id="toutes-tab" data-toggle="tab" href="#toutes" role="tab" aria-controls="toutes" aria-selected="true">TOUTES</a>
            </li>
            <li class="nav-item radio-tile" >
            <a class="nav-link" id="conseils-tab" data-toggle="tab" href="#conseils" role="tab" aria-controls="conseils" aria-selected="false">CONSEILS POUR L’AIDE AUX PERSONNES ÂGÉES</a>
            </li>
            <li class="nav-item radio-tile">
            <a class="nav-link" id="services-tab" data-toggle="tab" href="#services" role="tab" aria-controls="services" aria-selected="false">LES SERVICES AIDE À DOMICILE</a>
            </li>
            <li class="nav-item radio-tile">
            <a class="nav-link" id="offre-tab" data-toggle="tab" href="#offre" role="tab" aria-controls="offre" aria-selected="false">L’OFFRE AMELIS</a>
            </li>
            </ul>
            <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="toutes" role="tabpanel" aria-labelledby="home-tab">

            <?php if ($query_all->have_posts()) : ?>
            <?php while ( $query_all->have_posts() ) : $query_all->the_post(); ?>
            <a class="btn-link btn-link--dark" data-toggle="collapse" href="<?php echo '#faq-' . get_the_ID(); ?>" role="button" aria-expanded="false" aria-controls="<?php echo '#faq-' . get_the_ID(); ?>">
            <span class="faq-question"><?php the_title() ?></span>
            </a>
            <div id="<?php echo 'faq-' . get_the_ID(); ?>" class="collapse">

            <div class="card card-body">
            <?php the_content(); ?>
            </div>

            </div>
            <?php endwhile; wp_reset_postdata(); ?>
            <?php else : ?>
            <!-- no faq items found -->
            <?php endif;?>
            </div>
            <div class="tab-pane fade" id="conseils" role="tabpanel" aria-labelledby="conseils-tab">
            <?php if ($query_conseils->have_posts()) : ?>
            <?php while ( $query_conseils->have_posts() ) : $query_conseils->the_post(); ?>
            <a class="btn-link btn-link--dark" data-toggle="collapse" href="<?php echo '#faq-' . get_the_ID(); ?>" role="button" aria-expanded="false" aria-controls="<?php echo '#faq-' . get_the_ID(); ?>">
            <span class="faq-question"><?php the_title() ?></span>
            </a>
            <div id="<?php echo 'faq-' . get_the_ID(); ?>" class="collapse">

            <div class="card card-body">
            <?php the_content(); ?>
            </div>

            </div>
            <?php endwhile; wp_reset_postdata();?>
            <?php else : ?>
            <!-- no faq items found -->
            <?php endif;?>
            </div>
            <div class="tab-pane fade" id="services" role="tabpanel" aria-labelledby="services-tab">
            <?php if ($query_services->have_posts()) : ?>
            <?php while ( $query_services->have_posts() ) : $query_services->the_post(); ?>
            <a class="btn-link btn-link--dark" data-toggle="collapse" href="<?php echo '#faq-' . get_the_ID(); ?>" role="button" aria-expanded="false" aria-controls="<?php echo '#faq-' . get_the_ID(); ?>">
            <span class="faq-question"><?php the_title() ?></span>
            </a>
            <div id="<?php echo 'faq-' . get_the_ID(); ?>" class="collapse">

            <div class="card card-body">
            <?php the_content(); ?>
            </div>

            </div>
            <?php endwhile; wp_reset_postdata();?>
            <?php else : ?>
            <!-- no faq items found -->
            <?php endif;?>
            </div>
            <div class="tab-pane fade" id="offre" role="tabpanel" aria-labelledby="offre-tab">
            <?php if ($query_offre->have_posts()) : ?>
            <?php while ( $query_offre->have_posts() ) : $query_offre->the_post(); ?>
            <a class="btn-link btn-link--dark" data-toggle="collapse" href="<?php echo '#faq-' . get_the_ID(); ?>" role="button" aria-expanded="false" aria-controls="<?php echo '#faq-' . get_the_ID(); ?>">
            <span class="faq-question"><?php the_title() ?></span>
            </a>
            <div id="<?php echo 'faq-' . get_the_ID(); ?>" class="collapse">

            <div class="card card-body">
            <?php the_content(); ?>
            </div>

            </div>
            <?php endwhile; wp_reset_postdata();?>
            <?php else : ?>
            <!-- no faq items found -->
            <?php endif;?>
            </div>
            </div>
            </div>
            </section>
            <section class="video-section section" style="padding:48px 0; background-color: #f8f8f9">
            <div class="container">
            <div class="row">
            <div class="col-md-10 col-md-offset-1 text-center">
            <h2 class="underline centered"><?php echo $section_h2 ? $section_h2 : "Parcourir nos vidéos" ?></h2>
            </div>
            </div>
            <div class="owl-carousel owl-theme video-carousel">
            <?php

            // check if the repeater field has rows of data
            // ID = 1353
            if ( have_rows('video_slider', 1353) ):
              $video_n = 0;
              // loop through the rows of data
              while ( have_rows('video_slider', 1353) ) : the_row();
              $video_n++;
              ?>

              <!-- // display a sub field value -->
              <div class="item-video <?php echo $video_n; ?>">
              <div class="youtube" data-embed="<?php echo the_sub_field('video_url', 1353);?>">
              <div class="play-button">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 48">
              <path class="st0" d="M38.7 22.006L3.7.306c-.8-.5-1.8-.5-2.5 0-.8.2-1.3 1-1.3 1.9v43.3c0 1 .5 1.7 1.3 2.2.5.2.8.2 1.3.2s1-.2 1.3-.5l35-21.7c.8-.5 1.3-1.2 1.3-1.9-.1-.6-.6-1.6-1.4-1.8zM5 41.306v-34.6l28 17.3-28 17.3z"/>
              </svg>
              </div>
              </div>
              <h3><?php echo the_sub_field('question', 1353);?></h3>
              </div>

              <?php endwhile; ?>

              <?php
              else :

                // no rows found
                echo "<div>";
                echo "nothing";
                echo "</div>";

              endif;

              ?>


              </div>
              </div>
              </section>

              <?php get_footer();?>