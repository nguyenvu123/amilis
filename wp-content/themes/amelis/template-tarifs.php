<?php get_header();
/**
 * Template Name: Tarif page
 * Template Post Type: agence
 */
    $ancestors = get_post_ancestors($post);
?>

<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <ul class="list-inline">
                    <li><a href="<?php bloginfo('url');?>"><img src="<?php bloginfo('template_url');?>/assets/images/logo-symbol.svg" width="20" alt="Home"></a></li>
                    <li><a href="/nos-agences">Agences</a></li>
                    <li><a href="<?php echo get_permalink($ancestors[0])?> "><?php _e("Aide à domicile "); if (get_field("custom_breadcrumb", $ancestors[0])) echo get_field("custom_breadcrumb", $ancestors[0]); else echo get_the_title($ancestors[0]); ?></a></li>

                    <li><?php the_title(); ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php the_content(); ?>

<?php get_footer(); ?>