<?php get_header(); ?>

<?php
    $args = array(
        'post_type'  => 'agence',
        'numberposts' => -1,
        'order' => 'ASC',
        'orderby' => 'title',
        'post_parent' => 0
    );
    $agences = get_posts( $args );
?>

<div class="page-trouver-une-agence ">

<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <ul class="list-inline">
                    <li><a href="<?php bloginfo('url');?>"><img src="<?php bloginfo('template_url');?>/assets/images/logo-symbol.svg" width="20" alt="Home"></a></li>
                    <li>Agences</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="section-hero">
<div class="gray-overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1 class="text-center ">
                Trouvez une agence d'aide à <br class="visible-lg"> domicile <span class="hidden-xs"> près de chez vous</span></h1>
                <div class="code-postal-search">
                    <div class="code-postal-search__input">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                            <div class="form-group">
                                <input id="randomcp_field_name" type="text" pattern="[0-9]*" inputmode="numeric" onkeydown="return FilterInput(event)" min="10000" placeholder="Code postal de la personne aidée" autocomplete="false" required="required">
                                <input type="text" placeholder="" id="randomcp_field_name_text_with_location" style="display: none">

                                <input type="hidden" class="redirectToAgence" value="" id="code_postal_hidden">


                                <div class="icon"><?php echo file_get_contents(get_bloginfo('template_url') . "/assets/images/icon-search.svg") ?></div>

                                <div style="display: none; font-size: 14px; line-height: 1.4; padding: 12px 18px; background: rgba(255,255,255,0.5); font-weight: 500;" class="agence-not-found-trouvez"></div>

                            </div>
                                <div id="useOnlyNumbers" style="color: #B71C1C; font-size: 14px; margin-top: 8px; display: none;"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section-amelis-sur-la-carte">
    <h2 class="underline centered" id="trouverTitle">Amelis sur la carte</h2>

    <div class="map-holder">

            <div class="container container-wide">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="select-style hidden-xs">
                            <select name="agency-selection" class="redirectToAgence" id="agency_selection_map">
                                <option value="0" selected>Sélectionnez une agence</option>
                                <?php foreach ($agences as $a) : ?>
                                    <option value="<?php echo get_field('zipcode', $a->ID) ?>"><?php echo $a->post_title; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

        <div id="map" style="width: 100%; height: 620px;"></div>
        <div class="visible-xs text-center">
        <div class="container">
        <div class="row">
        <div class="col-xs-12">

                <div class="h-space-30"></div>

                    <div class="select-style" style="bottom: auto; max-width: unset; margin:0 auto; position: relative;" >
                        <select name="agency-selection" class="redirectToAgence" id="agency_selection_xs">
                            <option value="0">Sélectionnez une agence</option>
                            <?php foreach ($agences as $a) : ?>
                                <option value="<?php echo get_field('zipcode', $a->ID); ?>"><?php echo $a->post_title; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="h-space-30"></div>
        </div>

        </div>

            </div>
        <div class="section-agencies">
            <h2 class="underline centered" id="">Nos Agences</h2>
            <div class="container">
            <div class="row">
                <?php foreach ($agences as $agency): ?>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="agency-card agency-entity text-left">
                        <h3 class="agency-entity__title"><a href="<?php echo get_page_link($agency->ID) ?>"><?php echo $agency->post_title; ?></a></h3>
                        <div class="agency-entity__actions">
                        <div class="agency-entity__icons">
                            <div class="agency-entity__action-icon">
                                <a href="tel:<?php echo get_field('phone', $agency->ID); ?>"><?php echo file_get_contents(get_bloginfo('template_url') . "/assets/images/icon-call.svg") ?></a>
                            </div>
                            <div class="agency-entity__action-icon">
                                <a href="mailto:<?php echo get_field('email', $agency->ID); ?>"><?php echo file_get_contents(get_bloginfo('template_url') . "/assets/images/mail.svg") ?></a>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div> <!-- .row -->
                </div> <!-- .container -->
        </div> <!-- .section-agencies -->
    </div>

    <div id="nothing-to-show" style="display: none"></div>

    <div class="container" id="agenceFoundHolder" style="display: none">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-1">
                <div class="agency-entity">
                    <h4 class="agency-entity__name hidden-xs"></h4>
                    <a href="#" class="agency-entity__name visible-xs text-center"><h4 class="agency-entity__name"></h4></a>
                    <div class="agency-entity__actions">
                        <a href="#" class="btn btn-primary hidden-xs">En savoir plus</a>
                        <div class="agency-entity__icons">
                            <div class="agency-entity__action-icon">
                                <a href="tel:<?php echo get_field('phone', $agency->ID); ?>"><?php echo file_get_contents(get_bloginfo('template_url') . "/assets/images/icon-call.svg") ?></a>
                            </div>
                            <div class="agency-entity__action-icon">
                                <a href="mailto:<?php echo get_field('email', $agency->ID); ?>"><?php echo file_get_contents(get_bloginfo('template_url') . "/assets/images/mail.svg") ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="h-space-30"></div>
                    <div class="hidden-xs">
                        <div class="select-style">
                            <select name="agency-selection" id="agency_selection">
                                <option value="0">Selectionez une agence</option>
                                <?php foreach ($agences as $a) : ?>
                                    <option value="<?php echo get_field('zipcode', $a->ID) ?>"><?php echo $a->post_title; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="h-space-20"></div>
                        <a href="/nos-agences/">Retour à la carte</a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div id="map-small"></div>
            </div>
            <div class="container">
                <div class="h-space-30"></div>

                <div class="visible-xs text-center">
                    <div class="select-style">
                        <select name="agency-selection" id="agency_selection_xs">
                            <option value="0">Selectionez une agence</option>
                            <?php foreach ($agences as $a) : ?>
                                <option value="<?php echo get_field('zipcode', $a->ID); ?>"><?php echo $a->post_title; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="h-space-20"></div>
                    <a href="/nos-agences/">Retour à la carte</a>
                </div>

            </div>
        </div>
    </div>
</section>

</div> <!-- .page-trouver-une-agence -->

<script type="text/javascript">
    // When the window has finished loading create our google map below
    google.maps.event.addDomListener(window, 'load', init);

    function init() {
        // Basic options for a simple Google Map
        // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
        var mapOptions = {
            // How zoomed in you want the map to start at (always required)
            zoom: 6,

            // The latitude and longitude to center the map (always required)
            center: new google.maps.LatLng(46.293948, 2.256196),

            // How you would like to style the map.
            // This is where you would paste any style found on Snazzy Maps.
            styles: [{"featureType":"administrative.locality","elementType":"all","stylers":[{"hue":"#2c2e33"},{"saturation":7},{"lightness":19},{"visibility":"on"}]},{"featureType":"landscape","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"simplified"}]},{"featureType":"poi","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"off"}]},{"featureType":"road","elementType":"geometry","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":-2},{"visibility":"simplified"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"hue":"#e9ebed"},{"saturation":-90},{"lightness":-8},{"visibility":"simplified"}]},{"featureType":"transit","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":10},{"lightness":69},{"visibility":"on"}]},{"featureType":"water","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":-78},{"lightness":67},{"visibility":"simplified"}]}],
            mapTypeControl: false
        };

        // var screenWidth = window.screen.width * window.devicePixelRatio;
        // var screenHeight = window.screen.height * window.devicePixelRatio;

        var screenWidth = window.screen.width;

        if (screenWidth < 600) {
            mapOptions.zoom = 5;
        }

        // Get the HTML DOM element that will contain your map
        // We are using a div with id="map" seen below in the <body>
        var mapElement = document.getElementById('map');

        // Create the Google Map using our element and options defined above
        var map = new google.maps.Map(mapElement, mapOptions);

        // Let's also add a marker while we're at it
        var image = '/wp-content/themes/amelis/assets/images/agency.png';

        <?php foreach ($agences as $a) : ?>

            <?php
                $dir = get_posts(array(
                    'post_type' => 'agence-member',
                    'orderby' => 'id',
                    'order' => 'asc',
                    'posts_per_page' => -1,
                    'meta_key' => 'position',
                    'meta_value' => array('Directrice', 'Directeur'),
                    'meta_query' => array(
                        array(
                            'key' => 'agence', // name of custom field
                            'value' => '"' . $a->ID . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
                            'compare' => 'LIKE'
                        )
                    )
                ));
            ?>

            var contentString_<?php echo $a->ID; ?> = '<div id="content-<?php echo $a->ID; ?>" class="map-popup">'+
            '<div>'+
            '</div>'+
            '<h4 class="firstHeading"><a href="<?php echo get_the_permalink($a->ID); ?>">' + '<?php echo $a->post_title; ?>' + '</a></h1>'+
            '<div id="bodyContent">'+
            '<p><strong><?php echo get_field('position', $dir[0]->ID); ?></strong> <?php echo $dir[0]->post_title; ?></p>'+
            '<p><img src="<?php bloginfo('template_url');?>/assets/images/phone.svg" alt="phone"><a href="tel:<?php echo str_replace(' ', '', get_field('phone', $a->ID)); ?>"><span><?php echo get_field('phone', $a->ID); ?></a></p>'+
            '<p><img src="<?php bloginfo('template_url');?>/assets/images/mail.svg" alt="mail"><a href="mailto:<?php echo get_field('email', $a->ID);  ?>"><span><?php echo get_field('email', $a->ID); ?></a></p>'+
            '</div>'+
            '</div>';

            var infowindow = new google.maps.InfoWindow();


            var marker_<?php echo $a->ID; ?> = new google.maps.Marker({
                position: new google.maps.LatLng(<?php echo get_field('latitude', $a->ID); ?>, <?php echo get_field('longitude', $a->ID); ?>),
                map: map,
                icon: image,
                title: '<?php echo $a->post_title;?>'
            });

            marker_<?php echo $a->ID; ?>.addListener('click', function() {
                infowindow.setContent(contentString_<?php echo $a->ID; ?>);
                infowindow.open(map, marker_<?php echo $a->ID; ?>);
            });
        <?php endforeach; ?>
    }
</script>
<?php get_footer() ?>
