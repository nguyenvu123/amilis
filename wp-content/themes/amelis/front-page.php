<?php get_header(); ?>



<?php display_organization_schema(); ?>


<section class="section section-hero">
    <div class="overlay">
        <div class="container container-wide">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 title-banner">
                    <h1 class="hero-title"><?php echo get_field("hero_h1") ?> </h1>
                    <a href="<?php echo get_field("hero_primary_cta_url") ?>" class="btn btn-primary"><?php echo get_field("hero_primary_cta_text")?></a>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="section section-features">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="feature-item first">
                    <p class="text">Aide à domicile </p>
                    <a href="<?php echo get_field("audience_1_cta_url");?>" class="hover-section visible-xs"></a>
                   
                    <h2 class="audience-title"><?php echo get_field("audience-1-title"); ?></h2>
                     <div class="audience-image agees">
                        <img src="<?php echo get_field('audience_1_image') ?>" alt='' />
                    </div>
                    <p class="hidden-xs audience-description"><?php echo get_field("audience_1_description"); ?></p>
                      <div class="btn-read-more">
                        <a href="<?php echo get_field("audience_3_cta_url");?>" class="btn-read-more-24 btn btn-border btn-dark hidden-xs">En Savoir Plus</a>
                    </div>
                 
                </div>
            </div>
            <div class="col-sm-4">
                <div class="feature-item">
                      <p class="text">Aide à domicile </p>
                    <a href="<?php echo get_field("audience_2_cta_url");?>" class="hover-section visible-xs"></a>
                   
                    <h2 class="audience-title"><?php echo get_field("audience-2-title"); ?></h2>
                     <div class="audience-image handicapees">
                       <img src="<?php echo get_field('audience_2_image') ?>" alt='' />
                    </div>
                    <p class="hidden-xs audience-description"><?php echo get_field("audience_2_description"); ?></p>
                     <div class="btn-read-more">
                        <a href="<?php echo get_field("audience_3_cta_url");?>" class="btn-read-more-24 btn btn-border btn-dark hidden-xs">En Savoir Plus</a>
                    </div>
                  
                </div>
            </div>
            <div class="col-sm-4">
                <div class="feature-item last">
                      <p class="text">Aide à domicile </p>
                    <a href="<?php echo get_field("audience_3_cta_url");?>" class="hover-section visible-xs"></a>
                   
                    <h2 class="audience-title"><?php echo get_field("audience-3-title"); ?></h2>
                     <div class="audience-image hospitalisation">
                       <img src="<?php echo get_field('audience_3_image') ?>" alt='' />
                    </div>
                    <p class="hidden-xs audience-description"><?php echo get_field("audience_3_description"); ?></p>
                    <div class="btn-read-more">
                        <a href="<?php echo get_field("audience_3_cta_url");?>" class="btn-read-more-24 btn btn-border btn-dark hidden-xs">En Savoir Plus</a>
                    </div>
                   
                
                </div>
            </div>
        </div>
    </div>
    <a href="#services" class="go-down first-one scroll"></a>
</section>

<section id="services" class="section section-services">
    <div class="container container-wide">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 text-center">
                <h2 class="underline centered title"><?php echo get_field("services_title"); ?></h2>
                <p class="description"><?php echo get_field("services_description"); ?></p>
            </div>
        </div>
            <div class="include-items-services row">
                <div class="col-sm-3 col-md-6">
                    <div class="services-item text-center">
                        <a href="<?php echo get_field("service_1_url"); ?>" class="hover-section"></a>
                        <span class="image-holder">
                            <img src="<?php echo get_field("service_1_image"); ?>" alt="<?php echo get_field("service_1_title");?>">
                        </span>
                        <h3><a href="<?php echo get_field("service_1_url"); ?>"><?php echo get_field("service_1_title");?></a></h3>
                        <ul class="list-unstyled">

                            <?php

                                // check if the repeater field has rows of data
                                if( have_rows('services_enumerated') ):

                                    // loop through the rows of data
                                    while ( have_rows('services_enumerated') ) : the_row();

                                    // display a sub field value
                            ?>
                                        <li><?php echo the_sub_field('subservice');?></li>
                            <?php
                                    endwhile;

                                else :

                                    // no rows found
                                    echo "<li>Aide au lever/coucher</li>";
                                    echo "<li>Aide à la toilette</li>";
                                    echo "<li>Aide aux courses</li>";
                                    echo "<li>Aide à l’habillage</li>";

                                endif;

                            ?>
                        </ul>
                    </div>
                    <div class="include-link">
                        <a href="<?php echo get_field("service_1_url"); ?>" class="hover-section"><i class="icon-ArrowLong-2"></i></a>
                    </div>
                    
                </div>

                <div class="col-sm-3 col-md-6">
                    <div class="services-item text-center">
                        <a href="<?php echo get_field("service_2_url"); ?>" class="hover-section"></a>
                        <span class="image-holder">
                            <img src="<?php echo get_field("service_2_image"); ?>" alt="<?php echo get_field("service_2_title");?>">
                        </span>
                        <h3><a href="<?php echo get_field("service_2_url"); ?>"><?php echo get_field("service_2_title");?></a></h3>
                        <ul class="list-unstyled">
                            <?php

                                // check if the repeater field has rows of data
                                if( have_rows('services_enumerated_2') ):

                                    // loop through the rows of data
                                    while ( have_rows('services_enumerated_2') ) : the_row();

                                    // display a sub field value
                            ?>
                                        <li><?php echo the_sub_field('subservice_2');?></li>
                            <?php
                                    endwhile;

                                else :

                                    // no rows found
                                    echo "<li>Entretien du domicile</li>";
                                    echo "<li>Repassage</li>";

                                endif;

                            ?>
                        </ul>
                    </div>
                     <div class="include-link">
                        <a href="<?php echo get_field("service_1_url"); ?>" class="hover-section"><i class="icon-ArrowLong-2"></i></a>
                    </div>
                </div>

                <div class="col-sm-3 col-md-6">
                    <div class="services-item text-center">
                        <a href="<?php echo get_field("service_3_url"); ?>" class="hover-section"></a>
                        <span class="image-holder">
                            <img src="<?php echo get_field("service_3_image"); ?>"  alt="">
                        </span>
                        <h3><a href="<?php echo get_field("service_3_url"); ?>"><?php echo get_field("service_3_title");?></a></h3>
                        <ul class="list-unstyled">
                            <?php

                                // check if the repeater field has rows of data
                                if( have_rows('services_enumerated_3') ):

                                    // loop through the rows of data
                                    while ( have_rows('services_enumerated_3') ) : the_row();

                                    // display a sub field value
                            ?>
                                        <li><?php echo the_sub_field('subservice_3');?></li>
                            <?php
                                    endwhile;

                                else :

                                    // no rows found
                                    echo "<li>Préparation des repas</li>";
                                    echo "<li>Prise de médicaments</li>";
                                    echo "<li>Aide à la prise de repas</li>";

                                endif;
                            ?>
                        </ul>
                    </div>
                    <div class="include-link">
                        <a href="<?php echo get_field("service_1_url"); ?>" class="hover-section"><i class="icon-ArrowLong-2"></i></a>
                    </div>
                </div>

                <div class="col-sm-3 col-md-6">
                    <div class="services-item text-center">
                        <a href="<?php echo get_field("service_4_url"); ?>" class="hover-section"></a>
                        <span class="image-holder">
                            <img src="<?php echo get_field("service_4_image"); ?>"  alt="<?php echo get_field("service_4_title");?>">
                        </span>
                        <h3><a href="<?php echo get_field("service_4_url"); ?>"><?php echo get_field("service_4_title");?></a></h3>
                        <ul class="list-unstyled">



                            <?php

                                // check if the repeater field has rows of data
                                if( have_rows('services_enumerated_4') ):

                                    // loop through the rows of data
                                    while ( have_rows('services_enumerated_4') ) : the_row();

                                    // display a sub field value
                            ?>
                                        <li><?php echo the_sub_field('subservice_4');?></li>
                            <?php
                                    endwhile;

                                else :

                                    // no rows found
                                    echo "<li>Sorties et promenades</li>";
                                    echo "<li>Activités</li>";
                                    echo "<li>Lien social</li>";

                                endif;
                            ?>
                        </ul>
                    </div>
                    <div class="include-link">
                        <a href="<?php echo get_field("service_1_url"); ?>" class="hover-section"><i class="icon-ArrowLong-2"></i></a>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
       
    </div>
    <a href="#engagements" class="go-down scroll"></a>
</section>

<section id="engagements" class="section section-engagements">
    <div class="container  container-wide">
        <div class="row">
            <div class="col-xs-12 text-center">
                <h2 class="underline centered title left"><?php echo get_field("nos_engagements_title") ? get_field("nos_engagements_title") : 'Nos engagements'; ?></h2>
                <p class="description hidden-xs"><?php echo get_field("nos_engagements_description") ? get_field("nos_engagements_description") : '<p class="description hidden-xs">Amelis est spécialisé dans l’aide à domicile auprès des <a href="http://stage.amelis-services.com/aide-a-domicile-pour-personnes-agees/">personnes âgées</a> et <a href="http://stage.amelis-services.com/aide-a-domicile-pour-personnes-handicapees/">personnes handicapées</a><br class="hidden-sm"> 7000 familles nous ont fait confiance depuis 2002</p>'; ?></p>
                <div class="h-space-40 hidden-xs"></div>
            </div>
        </div>
        <div class="row">

            <div class="col-4 block-left">
                <div class="item">
                    <a href="<?php echo get_field("engagement_1_url"); ?>" class="hover-section"></a>
                 
                    <h4 class="text-link"><?php echo get_field("nos_engagement_title_1") ? get_field("nos_engagement_title_1") : 'Qualité de<br class="hidden-xs"> service'; ?></h4>
                    <p><?php echo get_field("nos_engagement1_descr_1") ? get_field("nos_engagement1_descr_1") : 'Auxiliaires diplômées et expérimentées'; ?></p>
                </div>
                <div class="item">
                    <a href="<?php echo get_field("engagement_2_url"); ?>" class="hover-section"></a>
                 
                    <h4 class="text-link"><?php echo get_field("nos_engagement_title_2") ? get_field("nos_engagement_title_2") : 'Continu<br class="hidden-xs">Disponibilité'; ?> </h4>
                    <p><?php echo get_field("nos_engagement_descr_2") ? get_field("nos_engagement_descr_2") : 'A votre écoute <br>24h/24 et 7j/7'; ?></p>
                </div>
                <div class="item">
                    <a href="<?php echo get_field("engagement_3_url"); ?>" class="hover-section"></a>
                 
                    <h4 class="text-link"><?php echo get_field("nos_engagement_title_3") ? get_field("nos_engagement_title_3") : 'Suivi<br class="hidden-xs"> personnalisé'; ?></h4>
                    <p><?php echo get_field("nos_engagement_descr_3") ? get_field("nos_engagement_descr_3") : 'Interlocuteur dédié et approche humaine'; ?></p>
                </div>
            </div>
            <div class="col-4 block-right">
                <div class="item">
                    <a href="<?php echo get_field("engagement_4_url"); ?>" class="hover-section"></a>
                  
                    <h4 class="text-link"><?php echo get_field("nos_engagement_title_4") ? get_field("nos_engagement_title_4") : 'Service<br class="hidden-xs"> prestataire'; ?></h4>
                    <p><?php echo get_field("nos_engagement_descr_4") ? get_field("nos_engagement_descr_4") : 'Aucun risque juridique pour le bénéficiaire'; ?></p>
                </div>
                <div class="item">
                    <a href="<?php echo get_field("engagement_5_url"); ?>" class="hover-section"></a>
                 
                    <h4 class="text-link"><?php echo get_field("nos_engagement_title_5") ? get_field("nos_engagement_title_5") : 'Filiale d’un grand groupe Française'; ?> </h4>
                    <p><?php echo get_field("nos_engagement_descr_5") ? get_field("nos_engagement_descr_5") : 'Leader mondial des services de qualité de vie'; ?></p>
                </div>
            </div>

            <div class="col-4">
                <img src="<?php echo get_field('image_engagement') ?>" />
            </div>


        </div>
    </div>
</section>

<section class="section section-testimonials">
    <div class="container container-wide">
        <div class="row">
            <div class="col-sm-7 col-xs-12">
                <div class="block-left">
                    <div class="icon-top">
                        <i class="icon-Heart"></i>
                    </div>
                    
                    <h2 class="title"><?php echo get_field("testimonials_section_title") ? get_field("testimonials_section_title") : 'L’humain au cœur de l’aide à domicile'; ?></h2>
                    <p><?php echo get_field("testimonials_text") ? get_field("testimonials_text") : 'Elisabeth Morin, bénéficiaire parisienne,  explique comment Amelis est intervenu pour lui apporter un soutien physique et moral après ses deux chutes successives. Morgane, aide à domicile, accompagne Mme Morin en sortie, lui permettant ainsi de retrouver du lien social.'; ?></p>
                </div>
              
            </div>
            <div class="col-sm-5 col-xs-12 include-video">
                <div class="video-holder">
                    <div class="wrapper">
                        <div class="youtube" data-embed="1kjG4sLg6ic">
                            <div class="play-button">
                             <i class="icon-Play"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_template_part("inc/template-parts/section","blog") ?>

<?php get_footer(); ?>