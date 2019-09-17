<?php get_header(); ?>

<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">

            <?php custom_breadcrumbs(); ?>

            </div>
        </div>
    </div>
</div>

<?php the_content(); ?>

<?php get_footer();?>