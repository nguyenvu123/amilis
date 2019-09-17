<?php
/*
  * This page is for emploi/agence-administratif/postuler/
  * Uses a custom header and footer (to be shared by other forms)
  *
  * Page Name: Emploi Administratif
  //emplate Name: Emploi Admin
*/
get_header("forms");

?>



<div class="form-page step-3">

    <div id="rejoignez-nous">
        <input id="current_step" type="hidden" name="current_step" value="1">

        <section class="section section-hero">
            <div class="overlay" style="background-image:url(<?php echo IMG_FOLDER .  'devis-gratuit-image.jpg' ?>); background-size: cover;">
                <div class="container container-wide text-center">
                    <h1 class="text-white devis-gratuit-title">Candidature</h1>
                    <p>Les champs identifiés par (*) sont obligatoires</p>
                </div>
            </div>
        </section>

        <section class="section section-etape">
            <div class="container">
                <div id="etape-2" class="etape-step-holder emploi-etape-2">

                    <input type="hidden" id="emploi_form" name="emploi_form" value="true">
                    <input type="hidden" id="emploi_type" name="emploi_type" value="administratif">
                    
                    <?php wp_nonce_field( 'web_form_action', 'web_form_wpnonce' ) ?>
                    <input type="text" name="your_subject" class="d-none" value="">

                    <div class="etape-2 text-inputs">
                        <div class="text-input">
                            <?php $jobs = showJobPositions(); ?>

                            <div class="select-style">
                                <select name="job_selection" id="job_selection" required="required">
                                    <option value="" selected>Poste souhaité *</option>
                                    <?php foreach ($jobs as $key => $value) : ?>
                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <span class="validation-message"></span>
                        </div>

                        <div class="text-input">
                            <?php $agences = getAllAgences(); ?>
                            <div class="select-style">
                                <select name="agence" id="agence" required="required">
                                    <option value="" selected>Localisation *</option>';
                                    <?php foreach ( $agences as $a ) : ?>
                                        <?php if ($a->ID == 90) : ?>
                                            <option value="99999"><?php echo HQ_NAME; ?></option>
                                        <?php endif; ?>
                                        <option value="<?php echo get_field('zipcode', $a->ID); ?>"><?php echo $a->post_title; ?></option>
                                    <?php endforeach; ?>
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
                        <div class="text-input">
                            <label for="linkedin_profile">
                            <span>Lien de mon profil Linkedin</span>
                            <input type="text" name="linkedin_profile" class="partager-profil" value="" placeholder="Lien de mon profil Linkedin">


                            </label>
                        </div>
                    </div> <!-- .etape-2 -->
                </div> <!-- #etape-2 -->
            </div> <!-- .container -->
        </section>
    </div>

    <footer class="form-footer emploiNav">

        <div id="emploiResumeButtons" class="container">
            <div class="col-xs-12">
                <div class="resume-container hidden-xs">
                    <div class="inputfile-container">
                        <form method="POST" action="/wp-admin/admin-ajax.php" enctype="multipart/form-data" id="resumeFileUpload">
                            <input type="hidden" name="action" value="uploadResume">
                            <?php wp_nonce_field( 'name_of_my_action', 'name_of_nonce_field' ); ?>

                            <input type="file" name="file" id="file" class="inputfile" />
                            <label for="file"><span> Joindre mon cv</span> <?php echo file_get_contents(get_bloginfo('template_url') . "/assets/images/icon-upload.svg") ?>
                            </label>
                        </form>
                    </div>
                    <div><span>Word ou PDF</span></div>
                </div>

                <div class="text-center"><span id="fileUploadingFeedback"></span></div>
            </div>
        </div>

        <nav class="form-footer-nav">
            <a href="#" direction="forward" class="btn btn-nav forward disabled btn-etape-2" data-next-step="3" loading-step="3" direction="forward"><span>Envoyer</span> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="7" height="12"><defs><path id="icon-arrow-right" d="M3.5153 7.088L7.794 2.8222c.391-.39 1.0243-.389 1.4142.0022.39.391.389 1.0242-.0022 1.4142L4.2213 9.2082c-.3903.389-1.0218.389-1.412 0l-5.0153-5c-.3911-.39-.3921-1.0231-.0022-1.4142.39-.3911 1.0231-.3921 1.4142-.0022L3.5153 7.088z"></path></defs><use fill="#DCE0E5" transform="rotate(-90 3.5 6)" xlink:href="#icon-arrow-right"></use></svg></a>
        </nav>
        <div class="container">
           <div class="gdpr"><?php echo get_field("gdpr_message") ?></div>
        </div>
    </footer>
</div> <!-- started in header -->
    <?php get_footer("forms"); ?>