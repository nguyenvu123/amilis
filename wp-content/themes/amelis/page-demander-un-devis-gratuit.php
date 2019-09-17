<?php
/* Template for the main form "Devis Gratuit"
  *  Uses a custom header and footer (to be shared by other forms)
  *
*/
get_header("forms");
?>



<div class="form-page step-1">

    <div id="devisGratuit">
        <input id="current_step" type="hidden" name="current_step" value="1">

        <section class="section section-hero">
            <div class="overlay" style="background-image:url(<?php echo IMG_FOLDER .  'devis-gratuit-image.jpg' ?>); background-size: cover;">
                <div class="container container-wide text-center">
                    <h1 class="text-white devis-gratuit-title">Quels sont mes besoins ?</h1>
                    <p class="devis-help-text"></p>
                </div>
            </div>
        </section>

        <section class="section form-steps">
            <div class="text-center">
                <h4>Etape <span><span class="current-step-number">1</span> / 3</span></h4>
                <div class="steps-container">
                    <div class="step step--active"></div>
                    <div class="step"></div>
                    <div class="step"></div>
                </div>
            </div>
        </section>
        <section class="section section-etape">
            <div class="container">

                <div id="etape-1" class="etape-step-holder">
                    <div class="etape-1">
                        <h3 class="text-center">Je recherche une aide pour :</h3>
                        <div class="form-container">
                            <div class="input-container">
                                <input type="radio" name="aide-pour" value="Moi" class="btn-radio">
                                <div class="radio-tile">
                                    <label>Moi</label>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="aide-pour" value="Autre personne" class="btn-radio">
                                <div class="radio-tile">
                                    <label>Une autre personne</label>
                                </div>
                            </div>
                        </div>
                    </div> <!-- .etape-1 -->
                </div>
                <div id="etape-2" class="etape-step-holder etape-hidden">
                    <div class="etape-2 etape-2--question-1">
                        <h3 class="text-center">Plusieurs réponses possibles *</h3>
                        <div class="form-container">
                            <div class="row">

                            <?php
                                $args = array (
                                    'posts_per_page' => -1,
                                    'orderby' => 'title',
                                    'order' => 'ASC',
                                    'post_type' => 'service',
                                    'meta_key' => 'exclude_from_query',
                                    'meta_value' => 0,
                                );
                                $services = get_posts($args);

                                $i = 1;

                                foreach ( $services as $service ) :
                            ?>
                                <div class="col-xs-6 col-md-3">
                                        <div class="input-container checkbox-container">
                                            <input type="checkbox" class="btn-checkbox" name="services[]" value="<?php echo $service->ID; ?>" id="checkbox-<?php echo $service->ID; ?>">
                                            <div class="checkbox-tile">
                                                <?php echo the_field("svg_image", $service->ID); ?>
                                            </div>
                                            <label class="checkbox-tile-label" for="checkbox-<?php echo $service->ID; ?>"><?php echo $service->post_title; ?></label>
                                        </div>
                                    </div>
                                <?php
                                    $i++;
                                endforeach;
                                wp_reset_postdata();
                            ?>

                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="etape-2 etape-2--question-2">
                            <h3 class="text-center">Combien de fois par semaine je souhaite bénéficier de ces services ? (à titre indicatif) *</h3>
                            <div class="form-container">
                                <div class="input-container">
                                    <input type="radio" name="combien-fois" value="3" class="btn-radio">
                                    <div class="radio-tile">
                                        <label>1 à 3 Jours</label>
                                    </div>
                                </div>
                                <div class="input-container">
                                    <input type="radio" name="combien-fois" value="5" class="btn-radio">
                                    <div class="radio-tile">
                                        <label >3 à 5 Jours</label>
                                    </div>
                                </div>
                                <div class="input-container">
                                    <input type="radio" name="combien-fois" value="-1" class="btn-radio">
                                    <div class="radio-tile">
                                        <label >Tous les Jours</label>
                                    </div>
                                </div>
                                <div class="input-container">
                                    <input type="radio" name="combien-fois" value="0" class="btn-radio">
                                    <div class="radio-tile">
                                        <label >Je ne sais pas</label>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- .etape-2--question-2 -->
                    </div> <!-- .etape-2 question 1 and 2 -->
                </div>


                <div id="etape-3" class="etape-step-holder etape-hidden">
                    <div class="etape-3">
                    
	                    <?php wp_nonce_field( 'devis_gratuit_action', 'devis_gratuit_wpnonce' ) ?>
                        <input type="text" name="your_subject" class="d-none" value="">

                        <div class="text-input">
                            <?php show_name_field(); ?>
                            <span class="validation-message"></span>
                        </div>
                        <div class="text-input code-postal">
                            <label for="randomcp_field_name">
                                <span> Code postal de la ville d'intervention * </span>
                                <input type="text" pattern="[0-9]*" inputmode="numeric" onkeydown="return FilterInput(event)" autocomplete="false" placeholder="Code postal de la ville d'intervention *" id="randomcp_field_name" required="required">
                                <input type="text" autocomplete="false" placeholder="" id="randomcp_field_name_text_with_location" style="display: none">
                                <p><strong style="display: none" class="agence-found"></strong></p>
                            </label>
                            <span class="validation-message"></span>
                        </div>
                        <div class="text-input">
                            <?php show_email_field(); ?>
                            <span class="validation-message"></span>
                        </div>
                        <div class="text-input">
                            <?php show_telephone_field(); ?>
                            <span class="validation-message"></span>
                        </div>
                        <?php show_newsletter_checkbox(); ?>
                        <p class="text-center subform-text">Nos équipes vous recontacteront <span class="color-primary">sous 24h</span> pour apporter une solution à vos besoins</p>
                    </div>
                </div>

            </div> <!-- .container -->
        </section>
    </div>


    <footer class="form-footer devisGratuitNav">
        <nav class="form-footer-nav">
            <a href="#" data-previous-step="0" loading-step="0" direction="back" class="btn btn-nav back disabled"><?php echo file_get_contents(get_bloginfo('template_url') . "/assets/images/arrow-left.svg") ?> Retour</a>
            <a href="#" data-next-step="2" loading-step="2" direction="forward" class="btn btn-nav forward btn-etape-1 disabled"><span>Suivant</span> <?php echo file_get_contents(get_bloginfo('template_url') . "/assets/images/arrow-right.svg") ?></a>
        </nav>
        <div class="container">
            <div class="gdpr"><?php echo get_field("gdpr_message") ?></div>
        </div>
    </footer>
</div> <!-- started in header -->
    <?php get_footer("forms"); ?>