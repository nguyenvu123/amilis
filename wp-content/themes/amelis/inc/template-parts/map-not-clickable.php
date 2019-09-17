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

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(agence.latitude, agence.longitude),
                map: map,
                icon: image,
                title: agence.title
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

                var infowindow = new google.maps.InfoWindow();

                var marker_<?php echo $a->ID; ?> = new google.maps.Marker({
                    position: new google.maps.LatLng(<?php echo get_field('latitude', $a->ID); ?>, <?php echo get_field('longitude', $a->ID); ?>),
                    map: map,
                    icon: image,
                    title: '<?php echo $a->post_title;?>'
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