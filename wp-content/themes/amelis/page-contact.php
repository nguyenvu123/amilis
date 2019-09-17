<?php
/*
  *  Uses a custom header and footer (to be shared by other forms)
  *
*/
get_header("forms");
    $agences = getAllAgences();
?>



<div class="form-page step-1">

    <form id="contactForm" method="post" action="<?php echo network_admin_url( 'admin-ajax.php' ) ?>">
        <input id="current_step" type="hidden" name="current_step" value="1">
                    
        <?php wp_nonce_field( 'web_form_action', 'web_form_wpnonce' ) ?>
        <input type="text" name="your_subject" class="d-none" value="">

        <section class="section section-hero">
            <div class="overlay" style="background-image:url(<?php echo IMG_FOLDER .  'devis-gratuit-image.jpg' ?>); background-size: cover;">
                <div class="container container-wide text-center">
                    <h1 class="text-white devis-gratuit-title">Contacter Amelis</h1>
                    <p>Les champs identifiés par (*) sont obligatoires afin de nous permettre de traiter votre demande.</p>
                </div>
            </div>
        </section>

        <section class="form-steps container">
            <div class="container text-center">
                    Vous souhaitez obtenir des informations sur les services d'aide à domicile, nos tarifs ou les aides financières publiques, contactez-nous soit en remplissant le formulaire ci-dessous, soit par téléphone au prix d’un appel local au 01 72 68 02 01. Nos équipes vous répondront sous 24h.
            </div>
        </section>
        <section class="section section-etape">
            <div class="container">
                <div id="etape-contact" class="etape-step-holder">
                    <div class="etape-2 text-inputs">

                        <div class="select-input" style="margin-bottom: 12px;">
                            <div class="select-style">
                                <select name="agence" id="agency_selection_xs" required="required">
                                    <option value="0">Sélectionnez votre agence *</option>
                                    <?php foreach ($agences as $a) : ?>
                                        <option value="<?php echo $a->ID; ?>"><?php echo $a->post_title; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <span class="validation-message"></span>
                        </div>
                        <p style="font-size: 14px; margin-bottom: 12px;">Si vous ne trouvez pas une agence à proximité de chez vous, merci de nous contacter par téléphone au prix d’un appel local au 01 72 68 02 01</p>

                        <div class="select-input" style="margin-bottom: 24px;">
                            <div class="select-style">
                                <select name="contact-subject" id="contact-subject">
                                    <option value="">Sélectionnez l'objet de votre demande *</option>
                                        <option value="Avoir des infos sur vos services">Avoir des infos sur vos services</option>
                                        <option value="Je suis client et souhaite vous contacter">Je suis client et souhaite vous contacter</option>
                                        <option value="En savoir plus sur votre tarifs et les aides">En savoir plus sur vos tarifs et les aides</option>
                                        <option value="Autre">Autre</option>
                                </select>
                            </div>
                            <span class="validation-message"></span>
                        </div>
                        <div class="text-input">
                                <?php show_name_field(); ?>
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
                        </div>

                    </div>
                </div> <!-- #etape-1 -->

            </div> <!-- .container -->
        </section>
    </form>

    <footer class="form-footer">

        <nav class="form-footer-nav">
            <a href="#" direction="forward" class="btn btn-nav forward disabled btn-etape-3"><span>Envoyer</span> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="7" height="12"><defs><path id="icon-arrow-right" d="M3.5153 7.088L7.794 2.8222c.391-.39 1.0243-.389 1.4142.0022.39.391.389 1.0242-.0022 1.4142L4.2213 9.2082c-.3903.389-1.0218.389-1.412 0l-5.0153-5c-.3911-.39-.3921-1.0231-.0022-1.4142.39-.3911 1.0231-.3921 1.4142-.0022L3.5153 7.088z"></path></defs><use fill="#DCE0E5" transform="rotate(-90 3.5 6)" xlink:href="#icon-arrow-right"></use></svg></a>
        </nav>
        <div class="container">
            <div class="gdpr"><?php echo get_field("gdpr_message") ?></div>
        </div>
    </footer>
</div> <!-- started in header -->
    <?php get_footer("forms"); ?>