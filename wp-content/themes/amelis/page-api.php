<?php
if ( $_GET['token'] == '200o0z4yyshrzwzntl2df2bauvssi4i6') :
    $latest_posts = get_posts();
    $args = array(
        'posts_per_page' => 3
    );

    if ( !empty($_GET['category_name']) )
        $args['category_name'] = $_GET['category_name'];

    $latest_posts = get_posts($args);
    $result = array();
    foreach ($latest_posts as $p) {
        $post_data = array();
        $post_data['title'] = $p->post_title;
        $post_data['url'] = get_permalink($p->ID);
        $post_data['thumbnail'] = get_the_post_thumbnail_url($p->ID, 'full');
        $post_data['date'] = $p->post_date;
        array_push($result, $post_data);
    }
    echo json_encode($result);
else :
    die();
endif;
?>