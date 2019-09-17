jQuery(function($) {
    $(document).ready(function(){

        // Form nav
        $('#rejoignez-nous .etape-1--question-1 input[type=radio], #rejoignez-nous .etape-1--question-2 input[type=radio]').on('change', function(e) {
            if ( $('input[name="diplome"]').is(':checked') && $('input[name="experience"]') .is(':checked') ) {
                $('.btn-nav.forward')
                    .addClass('active')
                    .removeClass('disabled');
            }

        });

        


        $('#rejoignez-nous #job_selection').change(function(e) {
            console.log('test');
            if ($(this).val() == 5) {
                $('#agence').append('<option value="99999">Boulogne - Siège</option');
                $('#agence').val('99999').change();
                $('#agence').attr('disabled', 'disabled');
            } else {
                $('#agence option[value="99999"]').remove();
                $('#agence').removeAttr('disabled').removeClass('success');
            }
        })


        $('input[name="experience"]').on('change', function(e) {
            if ( $(this).val() == '1' ) {
                $('#experienceExamplesHolder').fadeIn('fast');
            } else {
                $('#experienceExamplesHolder').fadeOut('fast');
                $('input[name="structure_1"]').val('');
                $('input[name="structure_2"]').val('');
                $('input[name="structure_3"]').val('');
                $('input[name="duree_1"]').val('');
                $('input[name="duree_2"]').val('');
                $('input[name="duree_3"]').val('');
            }
        })

        // Navigation through steps
        $('.emploiNav .btn-nav').on('click', function(e) {
            e.preventDefault();

            if ( $(this).hasClass('disabled') )
                return false;

            // Determine current and loading steps
            var currentStep = parseInt( $("#current_step").val() );
            var loadingStep = parseInt( $(this).attr('loading-step') );
            var direction = $(this).attr('direction');

            emploiLoadStep(loadingStep, currentStep, direction);
        });

        // Load Steps
        function emploiLoadStep(loadingStep, currentStep, direction) {
            loadingStep = parseInt(loadingStep);

            if ( loadingStep < 1 || loadingStep == currentStep || loadingStep > 3 )
                return false;
            if ( loadingStep == 3) {
                emploiSubmitData();
                return;
            }

            // Hide current step
            $('.etape-step-holder').hide().removeClass('etape-visible').addClass('etape-hidden');

            // Update main div class
            $('.form-page').removeClass(function (index, className) {
                return (className.match (/\bstep-\S+/g) || []).join(' ');
            }).addClass('step-' + loadingStep);

            // Update current step number title
            $('.current-step-number').text(loadingStep);
            // Update steps display
            $('.steps-container .step').removeClass('step--active');
            $(".steps-container .step").slice(0, loadingStep).addClass('step--active');

            // Change state for nav buttons back to disabled
            if ( direction == 'forward' )
                $('.btn-nav.forward').removeClass('active').addClass('disabled');
            else if ( direction == 'back')
                $('.btn-nav.forward').removeClass('disabled').addClass('active');

            $('.btn-nav.forward').attr('loading-step', (loadingStep + 1) );
            $('.btn-nav.back').attr('loading-step', (loadingStep - 1) );


            $('#emploiResumeButtons').hide();

            // Forward button styles per step
            $(".btn-nav.forward").removeClass(function (index, className) {
                return (className.match (/\bbtn-etape-\S+/g) || []).join(' ');
            }).addClass('btn-etape-' + loadingStep);

            // Scroll top
            $('html, body').stop().animate({
                scrollTop: 0
            }, 500);

            if ( loadingStep == 1) {
                emploiLoadStepOne(loadingStep, currentStep, direction);
                return;
            }
            else if (loadingStep == 2) {
                emploiGratuitLoadStepTwo(loadingStep, currentStep, direction);
                return;
            }
            else
                return false;
        }

        // Load step 1
        function emploiLoadStepOne(loadingStep, currentStep, direction) {
            $("#current_step").val('1');

            // Disable back button
            $('.btn-nav.back').removeClass('active').addClass('disabled');

            $('#etape-1').fadeIn().removeClass('etape-hidden').addClass('etape-visible');
            
            $(".btn-nav.forward span").text('Suivant');

            history.pushState({page: ajax_object.form_url, loadingStep: 0, currentStep: 1, direction: 'back'}, "1", "#!step-1");
        }

        // Load step 2
        function emploiGratuitLoadStepTwo(loadingStep, currentStep, direction) {
            $("#current_step").val('2');

            // Activate back button
            $('.btn-nav.back').removeClass('disabled').addClass('active');
            $('#etape-2').fadeIn().removeClass('etape-hidden').addClass('etape-visible');

            $(".btn-nav.forward span").text('Envoyer');

            $('#emploiResumeButtons').show();

            if ( direction == 'forward')
                history.pushState({page: ajax_object.form_url, loadingStep: 1, currentStep: 2, direction: 'back'}, "2", "#!step-2");
        }

        function emploiSubmitData() {        

            var input = {
                'name' : $('#amelis_nom_field').val(),
                'phone' : $('#amelis_tph_field').val(),
                'email' : $('#amelis_em_field').val(),
                'code_postal' : '',
                'experience' : $('input[name="experience"]:checked').val(),
                'diplome' : '',
                'agence' : $('#agence').val(),
                'emploi_type' : $('#emploi_type').val(),
                'job_selection' : '',
                'linkedin' : ''
            };

            if ( $('#randomcp_field_name').length > 0 )
                input.code_postal = $('#randomcp_field_name').val();

            if ( $('#job_selection').length > 0 )
                input.job_selection = $('#job_selection').val();
        
            if ( $('input[name="linkedin_profile"]').length > 0 )
                input.linkedin = $('input[name="linkedin_profile"]').val();
    
            if ( $('input[name="diplome"]:checked').val() )
                input.diplome = $('input[name="diplome"]:checked').val();

        
            var formdata = false;
            if (window.FormData) {  
                formdata = new FormData();
            }

            var inputFile = document.getElementById("file");
            if ( $('#file').val() )
                formdata.append('file', inputFile.files[0]);

            formdata.append('action', 'emploiSubmit');
            formdata.append('nonce', ajax_object.nonce);
            formdata.append('name', input.name);
            formdata.append('email', input.email);
            formdata.append('phone', input.phone);
            formdata.append('experience', input.experience);
            formdata.append('diplome', input.diplome);
            formdata.append('code_postal', input.code_postal);
            formdata.append('agence', input.agence);
            formdata.append('emploi_type', input.emploi_type);
            formdata.append('job_selection', input.job_selection);
            formdata.append('linkedin', input.linkedin);
            formdata.append('data', $('#rejoignez-nous input').serialize());

            var data = {
                action: 'emploiSubmit',
                nonce: ajax_object.nonce,
                name: input.name,
                email : input.email,
                phone: input.phone,
                experience : input.experience,
                diplome: input.diplome,
                code_postal: input.code_postal,
                agence: input.agence,
                emploi_type: input.emploi_type,
                job_selection: input.job_selection,
                linkedin: input.linkedin,
                data: $('#rejoignez-nous input').serialize()
            };

            $.ajax({
                url: ajax_object.url, // le nom du fichier indiqué dans le formulaire
                type: 'POST', // la méthode indiquée dans le formulaire (get ou post)
                cache: false,
                data: formdata,
                processData: false,
                contentType: false,
                success: function(response_data) { // je récupère la réponse du fichier PHP
                    response = jQuery.parseJSON(response_data);

                    if ( response.status == 'success' ) {
                        // Redirect to thank you
                        window.location.href = response.thank_you_url;
                    } else if ( response.status == 'error' ) {
                        $('#fileUploadingFeedback').text(response.message).show();;
                    }
                }    
                //return false; 
            }); 
        }

        

        $('#resumeFileUpload #file').on('change', function() {

            var formdata = false;
            if (window.FormData) {  
                formdata = new FormData();
            }

            var inputFile = document.getElementById("file");

            formdata.append('file', inputFile.files[0]);
            formdata.append('nonce', ajax_object.nonce);
            formdata.append('action', $('#resumeFileUpload input[name="action"]').val());

            $('#fileUploadingFeedback').hide();

            $.ajax({
                url: ajax_object.url, // le nom du fichier indiqué dans le formulaire
                type: 'POST', // la méthode indiquée dans le formulaire (get ou post)
                cache: false,
                data: formdata,
                processData: false,
                contentType: false,
                success: function(response_data) { // je récupère la réponse du fichier PHP
                    response = jQuery.parseJSON(response_data);
                    if ( response.status == 'success' ) {

                    } else if ( response.status == 'error' ) {
                        $('#fileUploadingFeedback').text(response.message).show();;
                    }
                }    
                //return false; 
            }); 

        });


        $(".emploi-etape-2 input, .emploi-etape-2 select").on('change keyup blur', function(e) {
            var showSubmitButton = 0;
            var required_fields = 0;

            if ( $('#emploi_type').val() == 'administratif')
                required_fields = 5;

            if ( $('#emploi_type').val() == 'auxiliaire')
                required_fields = 4;

            $(".emploi-etape-2 input[required='required'], .emploi-etape-2 select[required='required']").each(function(index) {
                if ( $(this).hasClass('success') )
                    showSubmitButton++;
            });

            if (showSubmitButton == required_fields)
                $('.btn-etape-2.btn-nav.forward').addClass('active').removeClass('disabled');
            else
                $('.btn-etape-2.btn-nav.forward').addClass('disabled').removeClass('active');
        })

        // validation
        $('#job_selection').on('blur change', function(e) {
            field = $(this);
            validateTextInput(field)
        })
        $('.emploi-etape-2 #agence').on('blur change', function(e) {
            field = $(this);
            validateTextInput(field)
        })

        function validateTextInput(field) {
            if(field.val().length > 0 ) {
                field.removeClass().addClass('success');
                field.parent().parent().find('.validation-message').text('');
            }
            else {
                field.removeClass().addClass('error');
                field.parent().parent().find('.validation-message').removeClass('success-message').addClass('error-message').text('Ce champ est obligatoire.');
            }
        }

        

    });
})
