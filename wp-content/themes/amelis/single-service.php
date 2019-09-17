<?php get_header();

$ancestors = get_post_ancestors($post);
?>

<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <ul class="list-inline">
                    <li><a href="<?php bloginfo('url');?>"><img src="<?php bloginfo('template_url');?>/assets/images/logo-symbol.svg" width="20" alt="Home"></a></li>
                    <li><a href="/nos-services">Services</a></li>
                    <?php if ($ancestors) : ?>
                        <li><a href="<?php echo get_permalink($ancestors[0])?> "><?php echo get_the_title($ancestors[0])?></a></li>
                    <?php endif; ?>
                    <li><?php the_title(); ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php the_content(); ?>

<?php get_footer(); ?>