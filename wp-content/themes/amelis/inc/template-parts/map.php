<div style="width: 100%;">

    <?php
        $args = array(
            'post_type'  => 'agence',
            'numberposts' => 20,
            'order' => 'ASC',
            'orderby' => 'title',
            'post_parent' => 0
        );
        $agences = get_posts( $args );
    ?>


    <div class="code-postal-search">
        <div class="code-postal-search__input">
            <div class="form-group">
                <input id="randomcp_field_name" type="text" pattern="[0-9]*" inputmode="numeric" onkeydown="return FilterInput(event)" min="10000" placeholder="Code postal de la personne aidée" autocomplete="false" required="required">
                <input type="text" placeholder="" id="randomcp_field_name_text_with_location" style="display: none">
                <input type="hidden" value="" id="code_postal_hidden">
                <div class="icon"><?php echo file_get_contents(get_bloginfo('template_url') . "/assets/images/icon-search.svg") ?></div>
            </div>
            
            <div id="useOnlyNumbers" style="color: #B71C1C; font-size: 14px; margin-top: 8px; display: none; z-index: 100"></div>
        </div>
        <div style="display: none; font-size: 14px; line-height: 1.4; padding: 12px 18px; background: rgba(255,255,255,0.5); font-weight: 500;" class="agence-not-found-small-map"></div>
    </div>

    <div id="shortcode-map" style="height: 300px;">

    </div>

    <script type="text/javascript">
        // When the window has finished loading create our google map below
        google.maps.event.addDomListener(window, 'load', initShortCodeMap);

        var map;
        var markers = [];
        var image = '/wp-content/themes/amelis/assets/images/agency.png';
        var markerData = [];
        // var agence = [];

        // Basic options for a simple Google Map
        // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
        var mapOptions = {
            // How zoomed in you want the map to start at (always required)
            zoom: 5,

            // The latitude and longitude to center the map (always required)
            center: new google.maps.LatLng(46.293948, 2.256196),

            // How you would like to style the map.
            // This is where you would paste any style found on Snazzy Maps.
            styles: [{"featureType":"administrative.locality","elementType":"all","stylers":[{"hue":"#2c2e33"},{"saturation":7},{"lightness":19},{"visibility":"on"}]},{"featureType":"landscape","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"simplified"}]},{"featureType":"poi","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"off"}]},{"featureType":"road","elementType":"geometry","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":-2},{"visibility":"simplified"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"hue":"#e9ebed"},{"saturation":-90},{"lightness":-8},{"visibility":"simplified"}]},{"featureType":"transit","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":10},{"lightness":69},{"visibility":"on"}]},{"featureType":"water","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":-78},{"lightness":67},{"visibility":"simplified"}]}],
            mapTypeControl: false
        };
        // Get the HTML DOM element that will contain your map
        // We are using a div with id="map" seen below in the <body>
        var mapElement = document.getElementById('shortcode-map');

        // Create the Google Map using our element and options defined above
        var map = new google.maps.Map(mapElement, mapOptions);


        function addMapMarker(agence) {
            // Reinit map with new center
            mapOptions.center = new google.maps.LatLng(agence.latitude, agence.longitude);
            mapOptions.zoom = 15;

            // Create the Google Map using our element and options defined above
            var map = new google.maps.Map(mapElement, mapOptions);

            var content = '<div id="content-' + agence.id + '>" class="map-popup">'+
                '<div>'+
                '</div>'+
                '<h4 class="firstHeading"><a href="' + agence.url + '">' + agence.title + '</a></h1>'+
                '<div id="bodyContent">'+
                '<p><strong>' + agence.director.position + '</strong> ' + agence.director.name + '</p>'+
                '<p><img src="/wp-content/themes/amelis/assets/images/phone.svg" alt=""><a href="tel:' + agence.phone_formatted + '"><span>' + agence.phone + '</a></p>'+
                '<p><img src="/wp-content/themes/amelis/assets/images/mail.svg" alt=""><a href="' + agence.email + '"><span>' + agence.email + '</a></p>'+
                '</div>'+
                '</div>';

            var infowindow = new google.maps.InfoWindow();

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(agence.latitude, agence.longitude),
                map: map,
                icon: image,
                title: agence.title
            });


            marker.addListener('click', function() {
                infowindow.setContent(content);
                infowindow.open(map, marker);
            });

            markers = [];
            markerData = [];

            markerData.item = marker;
            markerData.agence_id = agence.id;
            markers.push(markerData);
        }


        function initShortCodeMap() {
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

                // var contentString_<?php echo $a->ID; ?>;
                // var marker_<?php echo $a->ID; ?>;
                // var infowindow_<?php echo $a->ID; ?>;

                // agence.content_id = contentString_<?php echo $a->ID; ?>;
                // agence.marker_id = marker_<?php echo $a->ID; ?>;
                // agence.window_id = infowindow_<?php echo $a->ID; ?>;

                // agence.id = <?php echo $a->ID; ?>;
                // agence.url = '<?php echo get_the_permalink($a->ID); ?>';
                // agence.title = '<?php echo $a->post_title; ?>';
                // agence.director = [];
                // agence.director.position = '<?php echo get_field('position', $dir[0]->ID); ?>';
                // agence.director.name = '<?php echo $dir[0]->post_title; ?>';
                // agence.phone_formatted = <?php echo str_replace(' ', '', get_field('phone', $a->ID)); ?>;
                // agence.phone = '<?php echo get_field('phone', $a->ID); ?>';
                // agence.email = '<?php echo get_field('email', $a->ID); ?>';
                // agence.latitude = <?php echo get_field('latitude', $a->ID); ?>;
                // agence.longitude = <?php echo get_field('longitude', $a->ID); ?>;

                var contentString_<?php echo $a->ID; ?> = '<div id="content-<?php echo $a->ID; ?>" class="map-popup">'+
                '<div>'+
                '</div>'+
                '<h4 class="firstHeading"><a href="<?php echo get_the_permalink($a->ID); ?>">' + '<?php echo $a->post_title; ?>' + '</a></h1>'+
                '<div id="bodyContent">'+
                '<p><strong><?php echo get_field('position', $dir[0]->ID); ?></strong> <?php echo $dir[0]->post_title; ?></p>'+
                '<p><img src="<?php bloginfo('template_url');?>/assets/images/phone.svg" alt=""><a href="tel:<?php echo str_replace(' ', '', get_field('phone', $a->ID)); ?>"><span><?php echo get_field('phone', $a->ID); ?></a></p>'+
                '<p><img src="<?php bloginfo('template_url');?>/assets/images/mail.svg" alt=""><a href="mailto:<?php echo get_field('email', $a->ID);  ?>"><span><?php echo get_field('email', $a->ID); ?></a></p>'+
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

                var markerData = [];
                markerData.item = marker_<?php echo $a->ID; ?>;
                markerData.agence_id = <?php echo $a->ID; ?>;
                markers.push(markerData);

            <?php endforeach; ?>
        }

        // Shows any markers currently in the array.
        function showMarkers() {
            setMapOnAll(map);
        }

        // Deletes all markers in the array by removing references to them.
        function deleteMarkers(agence) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].item.setMap(null);
            }
            markers = [];

            if ( agence )
                addMapMarker(agence);
        }
    </script>

</div>