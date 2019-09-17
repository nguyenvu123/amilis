<?php


function trouver_map( $atts ) {

    $a = shortcode_atts( array(
		'clickable' => 'yes',
    ), $atts );


    ob_start();
    if ( $a['clickable'] == 'yes' )
        get_template_part('inc/template-parts/map');
    else
        get_template_part('inc/template-parts/map-not-clickable');

    $output = ob_get_clean();

    return $output;
}
add_shortcode( 'trouver-map', 'trouver_map' );



// Short code for agences tarifs pages
function agences_tarifs_dropdown( $atts ) {
    $agences = getAllAgences();

    $output = '<div class="col-sm-4 col-sm-offset-4">';
    $output .= '<div class="text-center select-style">';
    $output .= '<select name="agence_tarif" id="agence_tarif" class="" onchange="if (this.value) window.location.href=this.value">';
    $output .= '<option value="">Sélectionnez une agence</option>';

    foreach ( $agences as $a ) {

        $all_pages = get_pages( array( 'post_type'=> 'agence' ) );

        $child_pages = get_page_children($a->ID, $all_pages );

        foreach ( $child_pages as $child_page ) {
            if ( $child_page->post_title == 'Tarifs' ) {
                $output.= '<option value="'.get_permalink($child_page->ID).'">'.$a->post_title.'</option>';
            }
        }
    }

    $output .= '</select>';
    $output .= '</div>';
    $output .= '</div>';

    return $output;
}
add_shortcode( 'agences-tarifs', 'agences_tarifs_dropdown' );



// Short code for displaying the latest blog posts, that come from another Wordpress site, via an API
function latest_blog( $atts ) {

    $a = shortcode_atts( array(
		'category' => '',
    ), $atts );

    $api_url = 'https://institut.amelis-services.com/get-blog-posts/?token=200o0z4yyshrzwzntl2df2bauvssi4i6';

    if ( !empty($a['category']) )
        $api_url .= '&category_name='.$a['category'];

    $posts_json = file_get_contents($api_url);
    $posts = json_decode($posts_json);


    $output = '';
    $output .= '<section class="section section-conseils" style="padding:0;">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <h2 class="underline centered">Nos derniers articles</h2>
                    <div class="h-space-10"></div>
                </div>

                <div class="clearfix"></div>
                <div class="blog-carousel">';

     foreach ($posts as $p) :
        $output .= '<div class="col-sm-12 item">
            <div class="blog-item">
                <a href="'.$p->url.'" target="_blank" class="hover-section"></a>
                <span class="image-holder">
                    <img src="'.$p->thumbnail.'" width="100%" alt="'.$p->title.'">
                </span>
                <span>'.strftime("%d %B %G", strtotime($p->date)).'</span>
                <h3><a href="'. $p->url.'" target="_blank">'.$p->title.'</a></h3>
            </div>
        </div>';
     endforeach;

     $output .='</div>
            </div>
        </div>
    </section>';


    // ob_start(); // this is for including template parts
    // get_template_part('inc/template-parts/section-blog');
    // $output = ob_get_clean(); // after including template parts

    return $output;
}
add_shortcode( 'latest-blog', 'latest_blog' );


function prestation_func ( $atts ) {
    ob_start();
    $autre = get_page_by_title( "Autre", "" ,"service" );

	global $post;

	$args = array (
		'posts_per_page' => -1,
		'orderby' => 'date',
		'order' => 'DESC',
		'post_type' => 'service',
        'post__not_in' => array( $post->ID, $autre->ID ),
        'meta_key' => 'exclude_from_query',
        'meta_value' => 0,
    );

	$services = get_posts($args);

    $carousel_start = '<div class="prestation-holder-7 owl-carousel">';
    $prestation_item_start = '<div class="prestation-item item">';
    $end_div = '</div>';
    echo $carousel_start;
    foreach ( $services as $service ) {
        setup_postdata( $service );
        echo $prestation_item_start;
        echo '<a href="' . get_permalink( $service->ID ) . '" class="hover-section"></a>';
        echo '<div class="img-holder">';
        echo the_field("svg_image", $service->ID);
        echo $end_div; // .img-holder
        echo '<h3 class="title"><a href=' .  get_permalink( $service->ID ) .'">' . get_the_title( $service->ID ) . '</a></h3>';
        echo $end_div; // .prestation-item
    }
    wp_reset_postdata();
    echo $end_div; // carousel_start
    $output = ob_get_clean();

    return $output;
}

add_shortcode( 'nos-services', 'prestation_func' );

function testimonials_short () {
    ob_start();

    get_template_part("inc/template-parts/testimonials_select");

    $output = ob_get_clean();

    return $output;
}
add_shortcode( 'testimonials', 'testimonials_short' );