<?php get_header('forms');
/**
 * Template Name: APA/PCH/ARDH simple form
 * Template Post Type: page
 */

    global $post;

    $page_id = $post->ID;
?>


<div class="form-page step-1">

<div id="apaTelecharger">
    <input id="current_step" type="hidden" name="current_step" value="1">
    <input id="form_type" type="hidden" name="form_type" value="<?php echo get_field('form_type', get_the_ID()); ?>">

    <section class="section section-hero">
        <div class="overlay" style="background-image:url(<?php echo IMG_FOLDER .  'devis-gratuit-image.jpg' ?>); background-size: cover;">
            <div class="container container-wide text-center">
                <?php
                    if ( $page_id == 2720 )
                        $h1_title = 'Recevoir le formulaire par email';
                    else if ($page_id == 2749)
                        $h1_title = 'Recevoir le formulaire ARDH par email';
                    else
                        $h1_title = 'Recevoir le guide par email';
                ?>
                <h1 class="text-white devis-gratuit-title"><?php echo $h1_title; ?></h1>

                <p>Les champs identifiés par (*) sont obligatoires afin de nous permettre de traiter votre demande.</p>
            </div>
        </div>
    </section>

    <section class="section section-etape">
        <div class="container">
            <div id="etape-3" class="etape-step-holder">
                <div class="etape-2 text-inputs">

                    <?php wp_nonce_field( 'web_form_action', 'web_form_wpnonce' ) ?>
                    <input type="text" name="your_subject" class="d-none" value="">

                <div class="text-input">
                        <?php show_name_field('Mon Prénom et Nom *'); ?>
                        <span class="validation-message"></span>
                    </div>

                    <div class="text-input">
                        <?php show_telephone_field(false, 'Mon Téléphone', 'amelis_tph_field'); ?>
                        <span class="validation-message"></span>
                    </div>


                    <div class="text-input">
                        <?php show_email_field(); ?>
                        <span class="validation-message"></span>
                    </div>


                    <div class="text-input code-postal">
                        <label for="randomcp_field_name">

                            <?php

                                if ($page_id == 2749 ) :
                                    $code_postal_label = 'Code postal de la personne hospitalisée *';
                                elseif ($page_id == 2720 || $page_id == 2725) :
                                    $code_postal_label = 'Code postal de la personne handicapée *';
                                elseif ($page_id == 233 || $page_id == 236) :
                                    $code_postal_label = 'Code postal de la personne dépendante *';
                                else :
                                    $code_postal_label = 'Code postal de la personne aidée *';
                                endif;
                            ?>

                                <span><?php echo $code_postal_label; ?></span>

                            <input type="text" pattern="[0-9]*" inputmode="numeric" onkeydown="return FilterInput(event)" placeholder="<?php echo $code_postal_label; ?>" id="randomcp_field_name" required="required">
                            <input type="text" placeholder="" id="randomcp_field_name_text_with_location" style="display: none">
                            <?php if ( !in_array($page_id, array('236') ) ) : ?>
                                <!-- <p><strong style="display: none" class="agence-found"></strong></p> -->
                            <?php endif; ?>
                        </label>
                        <span class="validation-message"></span>
                    </div>


                    <?php show_newsletter_checkbox(); ?>
                    <label class="newsletter-sign" for="contacte-sign">
                        <input type="checkbox" id="contacte-sign" value="1"> Je souhaite être contacté(e) par Amelis au sujet de cette demande de document
                    </label>
                </div>
            </div> <!-- #etape-1 -->

        </div> <!-- .container -->
    </section>
</div>


<footer class="form-footer">

    <nav class="form-footer-nav">
        <a href="#" class="btn btn-nav forward btn-etape-3 disabled">Envoyer <?php echo file_get_contents(get_bloginfo('template_url') . "/assets/images/arrow-right.svg") ?></a>
    </nav>
    <div class="container">
        <div class="gdpr"><?php echo get_field("gdpr_message") ?></div>
    </div>
</footer>
</div> <!-- started in header -->



<?php get_footer('forms'); ?>