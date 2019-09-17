<?php
/*
  *  Uses a custom header and footer (to be shared by other forms)
  *  Page Name: APA Guide
*/
get_header("forms");

?>



<div class="form-page step-1">

    <div id="apaTelecharger">
        <input id="current_step" type="hidden" name="current_step" value="1">
        <input id="form_type" type="hidden" name="form_type" value="<?php echo get_field('form_type', get_the_ID()); ?>">

        <section class="section section-hero">
            <div class="overlay" style="background-image:url(<?php echo IMG_FOLDER .  'devis-gratuit-image.jpg' ?>); background-size: cover;">
                <div class="container container-wide text-center">
                    <h1 class="text-white devis-gratuit-title">Recevoir le guide par email</h1>
                    <p>Les champs identifiés par (*) sont obligatoires afin de nous permettre de traiter votre demande.</p>
                </div>
            </div>
        </section>

        <section class="section section-etape">
            <div class="container">
                <div id="etape-3" class="etape-step-holder">
                    <div class="etape-2 text-inputs">
                    <div class="text-input">
                            <?php show_name_field(); ?>
                            <span class="validation-message"></span>
                        </div>
                        <div class="text-input">
                            <?php show_telephone_field(false, 'Mon Téléphone *', 'amelis_tph_field'); ?>
                            <span class="validation-message"></span>
                        </div>
                        <div class="text-input">
                            <?php show_email_field(); ?>
                            <span class="validation-message"></span>
                        </div>
                        <div class="text-input code-postal">
                            <label for="randomcp_field_name">
                                <span> Code postal de la personne aidée * </span>
                                <input type="number" onkeydown="return FilterInput(event)" placeholder="Code postal de la personne aide *" id="randomcp_field_name" required="required">
                                <input type="text" placeholder="" id="randomcp_field_name_text_with_location" style="display: none">
                            </label>
                            <span class="validation-message"></span>
                        </div>
                        <?php show_newsletter_checkbox(); ?>
                        <label class="newsletter-sign" for="contacte-sign">
                            <input type="checkbox" id="contacte-sign"> Je souhaite être contacté(e) par Amelis au sujet de cette demande de document
                        </label>
                    </div>
                </div> <!-- #etape-1 -->

            </div> <!-- .container -->
        </section>
    </div>

    <section class="section section-thank-you" style="display: none;">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text-center">
                    <h4>Merci!</h4>

                    <p>Nous avons bien recu votre demande de devis gratuit et personnalise. Nos equipes vous contacteront sous 24h (jours ouvres) afin d'y apporter une response.</p>
                    <div class="h-space-30"></div>
                    <h4>Plus d'info?</h4>
                    <p>Decouvrez <a href="#">le fonctionnement d'Amelis</a> et comment nos equipes vous accompagnent dans tous les aspects en charge de la perte d'autonomie de vos proches.</p>

                    <div class="h-space-30"></div>

                    <a href="/" class="btn btn-nav back back-site"><?php echo file_get_contents(get_bloginfo('template_url') . "/assets/images/arrow-left.svg") ?> Retour au site</a>
                </div>
            </div>
        </div>
    </section>


    <footer class="form-footer">

        <nav class="form-footer-nav">
            <a href="javascript:history.back()" class="btn btn-nav back active"><?php echo file_get_contents(get_bloginfo('template_url') . "/assets/images/arrow-left.svg") ?> Retour</a>
            <a href="#" class="btn btn-nav forward btn-etape-3 disabled">Envoyer <?php echo file_get_contents(get_bloginfo('template_url') . "/assets/images/arrow-right.svg") ?></a>
        </nav>
        <div class="container">
            <div class="gdpr"><?php echo get_field("gdpr_message") ?></div>
        </div>
    </footer>
</div> <!-- started in header -->
    <?php get_footer("forms"); ?>