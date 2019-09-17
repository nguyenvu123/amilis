<?php
/**
 * Template Name: Menu service
 */

get_header(); ?>

<?php if (!is_home()): ?>
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">

            <ul class="list-inline">
                    <li><a href="<?php bloginfo('url');?>"><img src="<?php bloginfo('template_url');?>/assets/images/logo-symbol.svg" width="20" alt="Home"></a></li>
                    <li><a href="/nos-services">Services</a></li>
                    <li><?php the_title();?></li>
                </ul>

            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<section id="services" class="section section-services">
    <div class="container container-wide">
        <div class="row">
            <div class="">
<?php

// check if the repeater field has rows of data
if( have_rows('my_services') ):

 	// loop through the rows of data
    while ( have_rows('my_services') ) : the_row();
    // display a sub field value
?>
                <div class="services-item text-center">
                    <a href="<?php echo get_field("service_1_url"); ?>" class="hover-section"></a>
                    <span class="image-holder">
                        <img src="<?php echo the_sub_field('service_category_image');; ?>" alt="<?php echo the_sub_field('service_category_name');?>">
                    </span>
                    <h3><a href="<?php echo get_field("service_1_url"); ?>"><?php echo the_sub_field('service_category_name');?></a></h3>
                    <ul class="list-unstyled">
                    <?php
                    // check if the repeater field has rows of data
                        if( have_rows('service_category_subservices') ):

                            // loop through the rows of data
                            while ( have_rows('service_category_subservices') ) : the_row();

                                // display a sub field value
                                ?>
                                <li><?php echo the_sub_field('subservice');?></li>

                        <?php
                            endwhile;

                        else :

                            // no rows found

                        endif;
                    ?>
                    </ul>
                </div>
                <?php
                    endwhile;

                else :

                    // no rows found

                endif;
                ?>

            </div>
        </div>
    </div>
</section>


<?php
the_content();

get_footer();?>