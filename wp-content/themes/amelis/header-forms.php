<?php
 if(!isset($_SESSION))
    {
        session_start();
    }
?>

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

if ( is_page() ) :
  echo '<link rel="canonical" href="'.get_permalink().'" />';
endif;

?>


	<?php wp_head(); ?>



  <?php
    if ( session_id() && !empty( $_SESSION['trackingItemId'] ) ) :
      $lastId = $_SESSION['trackingItemId'];

      echo '<script>
        var idCode = '.$lastId.' // Dynamic populated
        if(idCode){  // evaluates if there is an Id code
          dataLayer.push ({
            ID: idCode
          })
        }
      </script>';


      $_SESSION['trackingItemId'] = '';
    endif;
  ?>


</head>

<body <?php body_class(); ?>>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MJZLBKC"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->


<div>
  <header class="site-header form-header">
    <div class="container">

      <div class="row row-top">

        <div class="logo-holder">
          <a href="<?php bloginfo('url');?>" class="logo"><img src="<?php bloginfo('template_url');?>/assets/images/logo-large.svg" height="96" alt="<?php bloginfo('name'); ?>"></a>
        </div>

        <div class="phone-holder hidden-xs">
              <?php echo file_get_contents(get_bloginfo('template_url') . "/assets/images/icon-call.svg") ?>
              <span style="display:block">01 72 68 02 01</span>
              <span style="display: block; font-size: 14px; line-height: 1em; font-weight: normal;">prix d’un appel normal</span>
        </div>

      </div>

    </div>
  </header>

	<div class="site-overlay only-xs"></div>
