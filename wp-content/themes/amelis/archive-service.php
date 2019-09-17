<?php
/**
 * Template Name: Service Archive
 */
get_header(); ?>

<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <ul class="list-inline">
                    <li><a href="<?php bloginfo('url');?>"><img src="<?php bloginfo('template_url');?>/assets/images/logo-symbol.svg" width="20" alt="Home"></a></li>
                    <li><a href="/nos-services">Services</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>


<?php

the_content();

?>


<?php get_footer();?>
