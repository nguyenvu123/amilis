<?php
/*
  * This page is for emploi/auxiliaire-de-vie/postuler/
  *  Uses a custom header and footer (to be shared by other forms)
  *
  * Page Name: Emploi Auxiliaire
  * emplate Name: Emploi Auxiliaire
*/
get_header("forms");

?>



<div class="form-page step-1">

    <div id="rejoignez-nous">
        <input id="current_step" type="hidden" name="current_step" value="1">

        <section class="section section-hero">
            <div class="overlay" style="background-image:url(<?php echo IMG_FOLDER .  'devis-gratuit-image.jpg' ?>); background-size: cover;">
                <div class="container container-wide text-center">
                    <h1 class="text-white devis-gratuit-title">Quelles sont mes coordonnées ?</h1>
                    <p>Les champs identifiés par (*) sont obligatoires</p>
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
                        <h3 class="text-center">Êtes-vous diplômé du secteur social *</h3>
                        <div class="form-container rejoignez-nous">
                            <div class="input-container">
                                <input type="radio" name="diplome" value="DEAVS" class="btn-radio">
                                <div class="radio-tile">
                                    <label>DEAVS/DEAES</label>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="diplome" value="MCAD" class="btn-radio">
                                <div class="radio-tile">
                                    <label>MCAD</label>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="diplome" value="BEP carrières sanitaires et sociales" class="btn-radio">
                                <div class="radio-tile">
                                    <label>BEP carrières sanitaires et sociales</label>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="diplome" value="Titre ADVF" class="btn-radio">
                                <div class="radio-tile">
                                    <label>Titre ADVF</label>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="diplome" value="CQP" class="btn-radio">
                                <div class="radio-tile">
                                    <label>CQP</label>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="diplome" value="Bac pro ASSP" class="btn-radio">
                                <div class="radio-tile">
                                    <label>BEP/BAC pro ASSP</label>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="diplome" value="Autre" class="btn-radio">
                                <div class="radio-tile">
                                    <label>Autre</label>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="diplome" value="Aucun" class="btn-radio">
                                <div class="radio-tile">
                                    <label>Aucun</label>
                                </div>
                            </div>
                        </div>
                        <div class="etape-1 etape-1--question-2">
                            <h3 class="text-center">Justifiez-vous de 3 ans d’expérience professionnelle dans le secteur social ? *</h3>
                            <div class="form-container">
                                <div class="input-container">
                                    <input type="radio" name="experience" value="1" class="btn-radio">
                                    <div class="radio-tile">
                                        <label>Oui</label>
                                    </div>
                                </div>
                                <div class="input-container">
                                    <input type="radio" name="experience" value="0" class="btn-radio">
                                    <div class="radio-tile">
                                        <label >Non</label>
                                    </div>
                                </div>
                            </div>

                            <div id="experienceExamplesHolder" class="yes-selected" style="display:none">
                                <h3 class="text-center">Si oui, pouvez-vous indiquer pour quelles structures et pendant combien de temps ?</h3>

                                <div class="form-container">
                                    <div class="text-input">

                                        <div class="row">
                                            <div class="col-xs-8">
                                                <label for="">
                                                    <span>Nom de la structure</span>
                                                    <input type="text" name="structure_1" placeholder="Nom de la structure" id="" required="required">
                                                </label>
                                            </div>

                                            <div class="col-xs-4">
                                                <label for="">
                                                    <span>Durée</span>
                                                    <input type="number" onkeydown="return FilterInput(event)" name="duree_1" max="10" placeholder="Durée" id="" required="required">
                                                </label>
                                            </div>
                                        </div>
                                            <div class="h-space-30"></div>

                                        <div class="row">
                                            <div class="col-xs-8">
                                                <label for="">
                                                    <span>Nom de la structure</span>
                                                    <input type="text" name="structure_2" placeholder="Nom de la structure" id="" required="required">
                                                </label>
                                            </div>

                                            <div class="col-xs-4">
                                                <label for="">
                                                    <span>Durée</span>
                                                    <input type="number" onkeydown="return FilterInput(event)" name="duree_2"  max="10" placeholder="Durée" id="" required="required">
                                                </label>
                                            </div>
                                        </div>
                                            <div class="h-space-30"></div>

                                        <div class="row">
                                            <div class="col-xs-8">
                                                <label for="">
                                                    <span>Nom de la structure</span>
                                                    <input type="text" name="structure_3" placeholder="Nom de la structure" id="" required="required">
                                                </label>
                                            </div>

                                            <div class="col-xs-4">
                                                <label for="">
                                                    <span>Durée</span>
                                                    <input type="number" onkeydown="return FilterInput(event)" name="duree_3"  max="10" placeholder="Durée" id="" required="required">
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div> <!-- .etape-1--question-2 -->


                    </div> <!-- .etape-1 -->
                </div> <!-- #etape-1 -->

                <div id="etape-2" class="etape-step-holder etape-hidden emploi-etape-2">

                    <input type="hidden" id="emploi_form" name="emploi_form" value="true">
                    <input type="hidden" id="emploi_type" name="emploi_type" value="auxiliaire">

                    <?php wp_nonce_field( 'web_form_action', 'web_form_wpnonce' ) ?>
                    <input type="text" name="your_subject" class="d-none" value="">

                    <div class="etape-2 text-inputs">
                        <div class="text-input">
                            <?php show_name_field(); ?>
                            <span class="validation-message"></span>
                        </div>
                        <div class="text-input">
                            <?php show_email_field(); ?>
                            <span class="validation-message"></span>
                        </div>
                        <div class="text-input code-postal">
                            <label for="randomcp_field_name">
                                <span> Mon code postal (ville de résidence) * </span>
                                <input type="text" pattern="[0-9]*" inputmode="numeric" onkeydown="return FilterInput(event)" placeholder="Mon Code Postal *" id="randomcp_field_name" required="required">
                                <input type="text" placeholder="" id="randomcp_field_name_text_with_location" style="display: none">
                                <!-- <p><strong style="display: none" class="emploi-agence-found"></strong></p> -->
                            </label>
                            <span class="validation-message"></span>
                        </div>

                        <?php
                            $agences = getAllAgences();
                        ?>

                        <div class="text-input select-style" id="agenceDropdown" style="display: none">
                            <label for="agence">
                                <select name="agence" id="agence">
                                    <option value="">Choisir une agence</option>

                                    <?php foreach ($agences as $a) : ?>
                                        <option value="<?php echo get_field('zipcode', $a->ID) ?>"><?php echo $a->post_title; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </label>
                        </div>
                        <div class="text-input">
                            <?php show_telephone_field(); ?>
                            <span class="validation-message"></span>
                        </div>
                    </div> <!-- .etape-2 -->
                </div> <!-- #etape-2 -->
            </div> <!-- .container -->
        </section>
    </div>



    <footer class="form-footer emploiNav">

        <div id="emploiResumeButtons" style="display: none;" class="container">
            <div class="col-xs-12">
                <div class="resume-container hidden-xs">
                    <div class="inputfile-container ">
                        <form method="POST" action="/wp-admin/admin-ajax.php" enctype="multipart/form-data" id="resumeFileUpload">
                            <input type="hidden" name="action" value="uploadResume">
                            <?php wp_nonce_field( 'name_of_my_action', 'name_of_nonce_field' ); ?>

                            <input type="file" name="file" id="file" class="inputfile" />
                            <label for="file"><span> Joindre mon cv</span> <?php echo file_get_contents(get_bloginfo('template_url') . "/assets/images/icon-upload.svg") ?></label>
                        </form>
                    </div>
                    <div><span>Word ou PDF</span></div>
                </div>
                <div class="text-center"><span id="fileUploadingFeedback"></span></div>
                <div class="visible-xs text-center" style="margin-top: 24px;">Merci de renseigner vos coordonnées, nos équipes vous recontacteront sous 24h.</div>
            </div>
        </div>

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