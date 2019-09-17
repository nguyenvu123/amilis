<?php get_header(); ?>

<?php if (!is_home(  )): ?>
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">

            <?php custom_breadcrumbs(); ?>

            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php the_content(); ?>

<?php get_footer();?>