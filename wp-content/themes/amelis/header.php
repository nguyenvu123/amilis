<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=EDGE" />
	<meta charset="<?php bloginfo( 'charset' ); ?>">

  <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<script>(function(){document.documentElement.className='js'})();</script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MJZLBKC');</script>
<!-- End Google Tag Manager -->

  <?php

  if ( !is_front_page() ) :
    echo '<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHpx78atlJrgAZFhIZvrKoJe1_AdEhGA4&#038;ver=5.1.1">
    </script>';
  endif;


    if ( is_front_page() ) :

     echo '<link rel="canonical" href="'.esc_url( home_url( '/' ) ).'" />';

    elseif ( is_single() ) :

      echo '<link rel="canonical" href="'.get_permalink().'" />';

    elseif ( is_page() ) :

      echo '<link rel="canonical" href="'.get_permalink().'" />';

    elseif ( is_archive() ) :

      echo '<link rel="canonical" href="'.esc_url( home_url( $_SERVER['REQUEST_URI'] ) ).'" />';

    endif;

  ?>

	<?php wp_head(); ?>
</head>


<body <?php body_class(); ?>>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MJZLBKC"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<div id="siteWrapper">
  <header id="mainHeader" class="site-header">
    <div class="container container-wide">

      <div class="row row-top">
        <div class="visible-xs visible-sm visible-md" style="margin-left: 16px">
          <a href="#" class="toggle-menu btn mobile-toggle">Menu</a>
        </div>
        <div class="logo-holder">
            <a href="<?php bloginfo('url');?>" class="logo">
              <span class="logo-amelis-svg">
                <?php echo file_get_contents(get_bloginfo('template_url') . "/assets/images/main-logo.svg")?>
              </span>
            </a>
        </div>
        <div class="btn search-mobile toggle visible-xs visible-sm visible-md"><?php echo file_get_contents(get_bloginfo('template_url') . "/assets/images/icon-search.svg") ?></div>
        <div class="nav-search-input visible-xs visible-sm visible-md">
          <form role="search" method="get" class="search-form" action="<?php bloginfo('url'); ?>/" id="nav-search-input__form">
                <input type="search" class="nav-search-input__field" placeholder="Rechercher" value="<?php echo get_search_query(); ?>" name="s">
                <button type="submit" class="" form="nav-search-input__form"><?php echo file_get_contents(get_bloginfo('template_url') . "/assets/images/icon-search.svg") ?></button>
              </form>
        </div>
        <div class="text-right header__navigation">
          <div class="include-menu">
              <nav class="navigation">
            <div class="text-center visible-xs visible-sm visible-md">
              <div class="logo-holder mt-auto">
                <a href="<?php bloginfo('url');?>" class="logo">
                  <span class="logo-amelis-svg">
                    <?php echo file_get_contents(get_bloginfo('template_url') . "/assets/images/logo-large-side.svg")?>
                  </span>
                </a>
              </div>
            <div class="close-menu-button mobile-toggle">
              <?php echo file_get_contents(get_bloginfo('template_url') . "/assets/images/x.svg")?>
            </div>
            </div>
            <div class="search-container visible-xs">
              <form role="search" method="get" class="search-form" action="<?php bloginfo('url'); ?>/" id="nav-search-input__search-container">
                <input type="search" class="form-control search-control" placeholder="Rechercher" value="<?php echo get_search_query(); ?>" name="s">
                <button type="submit" class="btn search-mobile visible-xs visible-sm"><?php echo file_get_contents(get_bloginfo('template_url') . "/assets/images/icon-search.svg") ?></button>
              </form>
            </div>
                <?php
                  wp_nav_menu( array(
                    'menu' => 'primary-menu',
                    'depth' => '2',
                    'container' => 'div',
                    'container_class' => 'sub-collapse navbar-collapse',
                    'menu_class'     => 'main-menu navbar-nav mr-auto',
                    'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
                    'walker'          => new WP_Bootstrap_Navwalker(),
                  ) );
                ?>
                
                
          </nav>
          <div class="icon-search icon-close">
            <i class="icon-Shape"></i>
             <i class="close-search icon-ArrowLong-1"></i>
          </div>
          <div class="search-container-2 hidden-xs hidden-sm hidden-md">

            <form role="search" method="get" class="search-form" action="<?php bloginfo('url'); ?>/" id="nav-search-input__search-container-2">
              <input type="search" class="form-control search-control" placeholder="Rechercher" value="<?php echo get_search_query(); ?>" name="s" />
              <button type="submit" class="search-mobile"><i class="icon-Shape"></i></button>
            </form>
          </div>
          </div>
        </div>


      </div>
    
        <div class="p-fixed phone-header">
          <div class="phone-holder hidden-xs">
              <!-- <img src="<?php bloginfo('template_url');?>/assets/images/icon-call.svg" width="23" height="23" alt=""> -->
              <i class="icon-Phone"></i>
              <span class="numner-phone" style="display:block">01 72 68 02 01</span>
              <span class="text" style="display: block; font-size: 14px; line-height: 1em; font-weight: normal;">prix d’un appel normal</span>
          </div>
        </div>
  

    </div>
   
    <div class="site-overlay only-md mobile-toggle"></div>
  </header>
  <div class="site-overlay__undernav search-mobile toggle only-md"></div>
  <div class="main-content">
    
 

