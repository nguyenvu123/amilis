<?php
/*
  * apa/formulaire/telecharger
  *  Uses a custom header and footer (to be shared by other forms)
  *  Template Name: APA Formulaire

*/
get_header("forms");

?>

<div class="form-page step-1">

    <div id="formulaireDemande">
        <div class="container"></div>
        <input id="current_step" type="hidden" name="current_step" value="1">
        <input id="form_type" type="hidden" name="form_type" value="APA Formulaire">

        <section class="section section-hero">
            <div class="overlay" style="background-image:url(<?php echo IMG_FOLDER .  'devis-gratuit-image.jpg' ?>); background-size: cover;">
                <div class="container container-wide text-center">
                    <h1 class="text-white devis-gratuit-title">Téléchargement du formulaire de demande APA</h1>
                    <p>Les champs identifiés par (*) sont obligatoires afin de nous permettre de traiter votre demande.</p>
                    <p></p>
                </div>
            </div>
        </section>

        <section class="section form-steps">
            <div class="text-center">
                <h4>Etape <span><span class="current-step-number">1</span> / 2</span></h4>
                <div class="steps-container">
                    <div class="step step--active"></div>
                    <div class="step"></div>
                </div>
            </div>
        </section>

        <section class="section section-etape">
            <div class="container">
                <div id="etape-1" class="etape-step-holder">
                    <div class="etape-1 etape-1--question-1">
                        <h3 class="text-center">Demande APA pour le:</h3>
                        <div class="form-container">
                            <div class="departments-wrapper">
                                <div class="input-container">
                                    <input type="radio" name="department" value="6" class="btn-radio">
                                    <div class="radio-tile">
                                        <label>Départment 06</label>
                                    </div>
                                </div>
                                <div class="input-container">
                                    <input type="radio" name="department" value="33" class="btn-radio">
                                    <div class="radio-tile">
                                        <label>Départment 33</label>
                                    </div>
                                </div>
                                <div class="input-container">
                                    <input type="radio" name="department" value="35" class="btn-radio">
                                    <div class="radio-tile">
                                        <label>Départment 35</label>
                                    </div>
                                </div>
                                <div class="input-container">
                                    <input type="radio" name="department" value="49" class="btn-radio">
                                    <div class="radio-tile">
                                        <label>Départment 49</label>
                                    </div>
                                </div>
                            </div>
                            <div class="departments-wrapper">
                                <div class="input-container">
                                    <input type="radio" name="department" value="75" class="btn-radio">
                                    <div class="radio-tile">
                                        <label>Départment 75</label>
                                    </div>
                                </div>
                                <div class="input-container">
                                    <input type="radio" name="department" value="78" class="btn-radio">
                                    <div class="radio-tile">
                                        <label>Départment 78</label>
                                    </div>
                                </div>
                                <div class="input-container">
                                    <input type="radio" name="department" value="92" class="btn-radio">
                                    <div class="radio-tile">
                                        <label>Départment 92</label>
                                    </div>
                                </div>
                                <div class="input-container">
                                    <input type="radio" name="department" value="95" class="btn-radio">
                                    <div class="radio-tile">
                                        <label>Départment 95</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p>Pour contacter un autre département, consultez l’annuaire du <a href="https://www.pour-les-personnes-agees.gouv.fr/annuaire-conseils-departementaux" target="_blank">portail national d’information pour l’autonomie des personnes âgées</a></p>
                        <div class="h-space-30"></div>
                    </div> <!-- .etape-1--question-2 -->
                </div> <!-- .etape-1 -->
                <div id="etape-3" class="etape-step-holder etape-hidden">
                    <div class="etape-2 text-inputs">

                    <?php wp_nonce_field( 'web_form_action', 'web_form_wpnonce' ) ?>
                    <input type="text" name="your_subject" class="d-none" value="">

                        <div class="text-input">
                            <?php show_name_field(); ?>
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
                                <span> Code postal de la personne dépendante * </span>
                                <input type="text" pattern="[0-9]*" inputmode="numeric" onkeydown="return FilterInput(event)" placeholder="Code postal de la personne dépendante *" id="randomcp_field_name" required="required">
                                <input type="text" placeholder="" id="randomcp_field_name_text_with_location" style="display: none">
                            </label>
                            <span class="validation-message"></span>
                        </div>
                        <?php show_newsletter_checkbox(); ?>

                        <label class="newsletter-sign" for="contacte-sign">
                            <input type="checkbox" id="contacte-sign" value="1"> Je souhaite être contacté(e) par Amelis au sujet de cette demande de document
                        </label>
                    </div> <!-- .etape-2 -->
                </div> <!-- #etape-3 -->
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


    <footer class="form-footer ">


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