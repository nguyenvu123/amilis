<?php get_header(); ?>

<?php display_organization_schema(); ?>


<?php

    $members = get_posts(array(
        'post_type' => 'agence-member',
        'orderby' => 'id',
        'order' => 'asc',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'agence', // name of custom field
                'value' => '"' . get_the_ID() . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
                'compare' => 'LIKE'
            )
        )
    ));

    $description_name = '';
    $description_position = '';
    $description_avatar = '';

    if ( $members ) {
        foreach ( $members as $m) {
            $position = get_field('position', $m->ID);
            if ( $position == 'Directrice' || $position == 'Directeur') {
                $avatar = get_field('avatar', $m->ID);

                $description_name = get_the_title( $m->ID );
                $description_position = $position;
                $description_avatar = $avatar;
            }
        }
    }
?>

<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <ul class="list-inline">
                    <li><a href="<?php bloginfo('url');?>"><img src="<?php bloginfo('template_url');?>/assets/images/logo-symbol.svg" width="20" alt="Home"></a></li>
                    <li><a href="/nos-agences">Agences</a></li>
                    <li><?php _e("Aide à domicile "); echo get_field("custom_breadcrumb") ? get_field("custom_breadcrumb") : get_the_title(); ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="agence-image visible-xs" style="background-image: url('<?php echo get_field("mobile_agency_img") ? get_field("mobile_agency_img") : "http://placehold.it/450x92" ?>');"></div>
<section>
    <div class="background-map" style="background-image: url('<?php echo get_field("agency_map_image") ? get_field("agency_map_image") : bloginfo('template_url') . "/assets/images/agence-map.png"?>');">
        <div class="agence-info">
            <div class="container">
                <div class="row">
                    <div class="col-sm-7 bg-white">
                        <div class="agence-info__part1">
                            <h1>
                            <?php if (get_field("custom_h1")) : ?>
                            <?php echo get_field("custom_h1") ?>
                                <span class="h1-description"><?php echo get_field("custom_agency_name"); echo " "; echo get_field("short_zipcode") ? get_field("short_zipcode") : ""; ?></span>
                            <?php else : ?>
                            <?php _e("Agence d'aide à domicile à"); ?>
                                <span class="h1-description"><?php the_title(); echo " "; echo get_field("short_zipcode") ? get_field("short_zipcode") : ""; ?></span>
                            <?php endif; ?>
                            </h1>

                            <div class="agence-contact visible-xs">
                                <div class="item">
                                    <p class="agence-contact__address">
                                        <img src="<?php bloginfo('template_url');?>/assets/images/map.svg" alt="map">
                                        <span>
                                            <span class="agence-contact__address__street"><?php echo get_field('address'); ?></span><span class="agence-contact__address__zipcode-city"><?php echo get_field('zipcode'); ?> <?php echo get_field('city'); ?></span>
                                        </span>
                                    </p>
                                </div>

                                <div class="item">
                                    <p>
                                        <img src="<?php bloginfo('template_url');?>/assets/images/phone.svg" alt="phone">
                                        <a href="tel:<?php echo get_field('phone'); ?>"><span><?php echo get_field('phone'); ?></span></a>
                                    </p>

                                    <?php if ( !empty(get_field('email')) ) : ?>
                                        <p>
                                            <img src="<?php bloginfo('template_url');?>/assets/images/mail.svg" alt="email">
                                            <a href="mailto:<?php echo get_field('email'); ?>"><span><?php echo get_field('email'); ?></span></a>
                                        </p>
                                    <?php endif; ?>


                                    <?php if ( !empty(get_field('fax')) ) : ?>
                                        <p>
                                            <img src="<?php bloginfo('template_url');?>/assets/images/fax.svg" alt="fax">
                                            <span><?php echo get_field('fax'); ?></span>
                                        </p>
                                    <?php endif; ?>

                                </div>
                                <div class="item">
                                    <p>
                                        <img src="<?php bloginfo('template_url');?>/assets/images/clock.svg" alt="Horaires">
                                        <span><?php echo get_field('horaires'); ?></span>
                                    </p>
                                </div>

                            </div>
                            <div class="zones-desservies-container">
                                <div class="hidden-xs">
                                    <h2 class="title-orange">Zones Desservies:</h2>
                                    <p class="zones-desservies"><?php echo get_field('zones_desservies'); ?>
                                    <?php if ( current_user_can('administrator')) : ?>
                                        <br><a href="#showMap" id="voirSurLaCarte">Voir sur la carte</a>
                                    <?php endif; ?></p>
                                </div>
                                <div class="visible-xs">
                                    <div class="select-style toggle-zones">Zones Desservies:</div>
                                    <div class="zones">
                                        <p class="zones-desservies"><?php echo get_field('zones_desservies'); ?></p>
                                            <div id="map-zones" class="map" style="height: 250px"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="h-space-20"></div>

                            <div class="cta-actions">
                                <a href="<?php echo get_page_link(19); ?>" class="btn btn-primary btn-arrow"><span class="hidden-xs">Demander un </span> devis gratuit</a>
                                <a href="<?php echo get_field("agency_tarifs_url") ? get_field("agency_tarifs_url") : "#" ?>" class="btn btn-white">Nos tarifs</a>
                            </div>
                        </div>

                        <div class="h-space-50"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container coordonnees" id="agence-coordonnees" style="position: relative;">
        <script>
            var zonesHeight = document.querySelector('.zones-desservies-container').getBoundingClientRect().height;
            var negativeTop = -223 - zonesHeight;
            document.getElementById("agence-coordonnees").style.top = negativeTop+"px";
        </script>
        <div class="row">
        <div class="col-sm-5 col-sm-offset-7 agence-info__sidebar">
                <div class="agence-contact hidden-xs">
                    <h2>Coordonnées
                    <span class="title-description">Amelis groupe Sodexo <?php the_title(); echo " "; echo get_field("short_zipcode") ? get_field("short_zipcode") : ""; ?></span></h2>

                    <hr>

                    <div class="item">
                        <h3>Adresse</h3>
                        <p class="agence-contact__address">
                            <img src="<?php bloginfo('template_url');?>/assets/images/map.svg" alt="map">
                            <span class="agence-contact__address__wrapper">
                                <span class="agence-contact__address__street"><?php echo get_field('address'); ?> </span><span class="agence-contact__address__zipcode-city"><?php echo get_field('zipcode'); ?> <?php echo get_field('city'); ?></span>
                            </span>
                        </p>
                    </div>

                    <div class="item">
                        <h3>Contact</h3>
                        <p>
                            <img src="<?php bloginfo('template_url');?>/assets/images/phone.svg" alt="phone">
                            <a href="tel:<?php echo get_field('phone'); ?>"><span><?php echo get_field('phone'); ?></span></a>
                        </p>

                        <?php if ( !empty(get_field('email')) ) : ?>
                            <p>
                                <img src="<?php bloginfo('template_url');?>/assets/images/mail.svg" alt="">
                                <a href="mailto:<?php echo get_field('email'); ?>"><span><?php echo get_field('email'); ?></span></a>
                            </p>
                        <?php endif; ?>


                        <?php if ( !empty(get_field('fax')) ) : ?>
                            <p>
                                <img src="<?php bloginfo('template_url');?>/assets/images/fax.svg" alt="fax">
                                <span><?php echo get_field('fax'); ?></span>
                            </p>
                        <?php endif; ?>


                    </div>

                    <div class="item">
                        <h3>Horaires</h3>
                        <p>
                            <img src="<?php bloginfo('template_url');?>/assets/images/clock.svg" alt="Horaires">
                            <span><?php echo get_field('horaires'); ?></span>
                        </p>
                    </div>

                    <h3>Trouvez-nous sur la carte</h3>

                    <div id="map" style="width: 100%; height: 260px;" class="single-map"></div>
                </div>
            </div>
        </div>
    </div> <!-- Coordonnees -->
</section>
<section class="agence-info__part2 agence-info">
    <div class="container">
        <div class="row">
            <div class="col-sm-7">
                <div>
                    <?php if ( !empty($description_name) ) : ?>
                        <div class="img-holder">
                            <img src="<?php echo $description_avatar['url']; ?>" alt="<?php echo $description_name; ?>" width="120" />
                        </div>
                        <div class="director-info">
                            <h4><?php echo $description_name; ?></h4>
                            <span><?php echo $description_position; ?> de l'agence</span>
                        </div>

                        <div class="clearfix"></div>
                        <div class="h-space-40"></div>
                    <?php endif; ?>

                    <div class="agence-info__description">
                        <?php echo get_field('description'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="relative" style="position: relative;">
    <a href="#prestation" class="go-down scroll"></a>
</section>
<script type="application/ld+json">
	{
  	"@context": "http://schema.org",
  	"@type": "LocalBusiness",
  	"address": {
      "@type": "PostalAddress",
      "addressLocality": "<?php echo get_field('city'); ?>",
      "postalCode":"<?php echo get_field('zipcode'); ?>",
      "streetAddress": "<?php echo get_field('address'); ?>"
  	},
    <?php if ( !empty(get_field('agency_schema_description')) ) { ?>
        "description": "<?php echo get_field('agency_schema_description'); ?>",
    <?php } else { ?>
        "description": "<?php echo get_field('description'); ?>",
    <?php } ?>

    "image": "<?php echo get_field('mobile_agency_img'); ?>",
  	"name": "Amelis groupe Sodexo <?php echo get_the_title(); ?>",
  	"telephone": "<?php echo get_field('phone'); ?>",
  	"email": "<?php echo get_field('email'); ?>",
  	"openingHours": "<?php echo get_field('horaires'); ?>",
  	"geo": {
      "@type": "GeoCoordinates",
      "latitude": "<?php echo get_field('latitude'); ?>",
      "longitude": "<?php echo get_field('longitude'); ?>"
 		},
  	"sameAs" : [
  	  "<?php echo get_field('facebook'); ?>",
      "<?php echo get_field('youtube'); ?>",
      "<?php echo get_field('linkedin'); ?>"
    ]
	}
</script>

<div class="section agence-prestation" id="prestation">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 text-center">
                <h2 class="underline centered">Nos Prestations</h2>
            </div>
        </div>
        <div class="row">
            <div class="text-center">
                <div class="items-holder services-carousel owl-carousel">
                    <?php
                        $services = get_field('services');
                        if( $services ): ?>
                            <?php foreach( $services as $s ): // variable must NOT be called $post (IMPORTANT) ?>
                                <div class="prestation-item">
                                    <a href="<?php echo get_permalink( $s->ID ); ?>" class="hover-section"></a>
                                    <div class="img-holder">
                                        <?php echo the_field("svg_image", $s->ID); ?>
                                    </div>
                                    <h3 class="title"><a href="<?php echo get_permalink( $s->ID ); ?>"><?php echo get_the_title( $s->ID ); ?></a></h3>
                                </div>
                            <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <p class="description" style="margin-top: 48px"><?php echo get_field("prestation") ? get_field("prestation") : "Découvrez l’ensemble de <a href=\"/nos-services\">nos services</a> d’ aide à domicile au <strong>" .  get_the_title() . "</strong>"; ?></p>
            </div>
        </div>
    </div>
</div>

<div class="section agence-equipe">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center">
                <h2 class="underline centered">Une Équipe Dédiée</h2>
                <div class="h-space-20"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                    <?php if( $members ): ?>
                        <div class="row">
                        <div class="owl-carousel member-carousel">
                        <?php foreach( $members as $member ): ?>
                            <?php

                            $photo = get_field('avatar', $member->ID);
                            $position = get_field('position', $member->ID);

                            ?>
                                <div class="member-item">
                                    <div class="img-holder">
                                        <img src="<?php echo $photo['url']; ?>" alt="<?php echo $photo['alt']; ?>" width="120" />
                                    </div>
                                    <h4><?php echo get_the_title( $member->ID ); ?></h4>
                                    <span><?php echo $position; ?></span>
                                </div>
                        <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
            </div>

            <div class="col-sm-6 text-center part-of-team">
                <div class="h-space-40"></div>
                <p>Voulez-vous faire partie de notre équipe ?</p>
                <?php $emploi_link = get_field('rejoignez_nous_cta') ? get_field('rejoignez_nous_cta') : '/emploi/agence-administratif'; ?>
                <a href="<?php echo $emploi_link; ?>" class="btn btn-primary btn-arrow">Rejoignez-Nous</a>
            </div>
        </div>
    </div>
</div>

<div class="section agence-testimonials">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="underline centered">Ils connaissent les services d'Amelis</h2>
            </div>
        </div>
        <div class="row">

        <?php get_template_part("inc/template-parts/testimonials") ?>

        </div>
    </div>
</div>


<?php if ( current_user_can('administrator')) : ?>
    <?php if ( $post->ID == 71 ) : ?>
    <div id="mapModalOverlay" style="background: rgba(0,0,0,0.7); width: 100%; height: 100%; position: fixed; z-index: 10000; top: 0; left: 0; display: none;"></div>
    <div id="mapModalContent" style="background: #fff; padding: 50px; width: 100%; max-width: 900px; position: absolute; top: 100px; left: 0; right: 0; bottom: 0; margin: 0 auto auto auto; z-index: 10100; height: 500px; box-sizing: border-box; display: none;">
        <div id="map-zones-lg" class="map" style="height: 400px"></div>
    </div>
    <?php endif; ?>
<?php endif; ?>

<script type="text/javascript">
    // When the window has finished loading create our google map below
    google.maps.event.addDomListener(window, 'load', init);

    function init() {
        // Basic options for a simple Google Map
        // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
        var mapOptions = {
            // How zoomed in you want the map to start at (always required)
            zoom: 15,

            // The latitude and longitude to center the map (always required)
            center: new google.maps.LatLng(<?php echo get_field('latitude', get_the_ID()); ?>, <?php echo get_field('longitude', get_the_ID()); ?>),

            // How you would like to style the map.
            // This is where you would paste any style found on Snazzy Maps.
            styles: [{"featureType":"administrative.locality","elementType":"all","stylers":[{"hue":"#2c2e33"},{"saturation":7},{"lightness":19},{"visibility":"on"}]},{"featureType":"landscape","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"simplified"}]},{"featureType":"poi","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"off"}]},{"featureType":"road","elementType":"geometry","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":-2},{"visibility":"simplified"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"hue":"#e9ebed"},{"saturation":-90},{"lightness":-8},{"visibility":"simplified"}]},{"featureType":"transit","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":10},{"lightness":69},{"visibility":"on"}]},{"featureType":"water","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":-78},{"lightness":67},{"visibility":"simplified"}]}],
            mapTypeControl: false
        };

        // Get the HTML DOM element that will contain your map
        // We are using a div with id="map" seen below in the <body>
        var mapElement = document.getElementById('map');

        // Create the Google Map using our element and options defined above
        var map = new google.maps.Map(mapElement, mapOptions);

        // Let's also add a marker while we're at it
        var image = '/wp-content/themes/amelis/assets/images/agency.png';


            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(<?php echo get_field('latitude', get_the_ID()); ?>, <?php echo get_field('longitude', get_the_ID()); ?>),
                map: map,
                icon: image,
                title: '<?php echo get_the_title(); ?>'
            });


            var coordinates = [
                {lat: 48.866647, lng: 2.230694},
                {lat: 48.854463, lng: 2.225178},
                {lat: 48.847556, lng: 2.227111},
                {lat: 48.838622, lng: 2.223849},
                {lat: 48.828806, lng: 2.228388},
                {lat: 48.825335, lng: 2.229320},
                {lat: 48.821409, lng: 2.237110},
                {lat: 48.826686, lng: 2.253236},
                {lat: 48.833870, lng: 2.262536},
                {lat: 48.831528, lng: 2.267249},
                {lat: 48.827927, lng: 2.267501},
                {lat: 48.828046, lng: 2.273732},
                {lat: 48.832286, lng: 2.279125},
                {lat: 48.826539, lng: 2.294471},
                {lat: 48.815930, lng: 2.343774},
                {lat: 48.815930, lng: 2.343774},
                {lat: 48.828642, lng: 2.402978},
                {lat: 48.824922, lng: 2.409514},
                {lat: 48.821830, lng: 2.431528},
                {lat: 48.819349, lng: 2.434667},
                {lat: 48.818254, lng: 2.438637},
                {lat: 48.816927, lng: 2.459149},
                {lat: 48.819727, lng: 2.463013},
                {lat: 48.836510, lng: 2.469894},
                {lat: 48.842430, lng: 2.463371},
                {lat: 48.846020, lng: 2.440111},
                {lat: 48.840629, lng: 2.438307},
                {lat: 48.844954, lng: 2.419510},
                {lat: 48.835762, lng: 2.421021},
                {lat: 48.835215, lng: 2.412706},
                {lat: 48.847392, lng: 2.415973},
                {lat: 48.880196, lng: 2.409116},
                {lat: 48.886178, lng: 2.398255},
                {lat: 48.900432, lng: 2.392679},
                {lat: 48.901229, lng: 2.319636},
                {lat: 48.886405, lng: 2.287346},
                {lat: 48.877998, lng: 2.278930},
                {lat: 48.880740, lng: 2.258159},
                {lat: 48.874583, lng: 2.254863}
            ];
            
            var shape = new google.maps.Polygon({
                paths: coordinates,
                strokeColor: '#dc3b05',
                strokeOpacity: 0.6,
                strokeWeight: 2,
                fillColor: '#dc3b05',
                fillOpacity: 0.35
            });

            // Map mobile
            mapOptions.zoom = 10;
            var mapElement = document.getElementById('map-zones');
            var map = new google.maps.Map(mapElement, mapOptions);
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(<?php echo get_field('latitude', get_the_ID()); ?>, <?php echo get_field('longitude', get_the_ID()); ?>),
                map: map,
                icon: image,
                title: '<?php echo get_the_title(); ?>'
            });


            <?php if ( current_user_can('administrator')) : ?>
                shape.setMap(map);

                // Map mobile
                mapOptions.zoom = 11;
                var mapElement = document.getElementById('map-zones-lg');
                var mapZones = new google.maps.Map(mapElement, mapOptions);

                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(<?php echo get_field('latitude', get_the_ID()); ?>, <?php echo get_field('longitude', get_the_ID()); ?>),
                    map: mapZones,
                    icon: image,
                    title: '<?php echo get_the_title(); ?>'
                });

                // Construct the polygon.
                
                var shape = new google.maps.Polygon({
                    paths: coordinates,
                    strokeColor: '#dc3b05',
                    strokeOpacity: 0.6,
                    strokeWeight: 2,
                    fillColor: '#dc3b05',
                    fillOpacity: 0.35
                });
            
                shape.setMap(mapZones);
            <?php endif; ?>
    }
</script>


<?php get_footer(); ?>