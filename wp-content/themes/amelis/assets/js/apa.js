jQuery(function($) {
    $(document).ready(function(){
        // Demande form
        if ( $('#formulaireDemande').length > 0 ) {

            // Form nav
            $('#formulaireDemande .etape-1 input[type=radio]').on('change', function(e) {
                if ( $('input[name="department"]').is(':checked') ) {
                    $('.btn-nav.forward')
                        .addClass('active')
                        .removeClass('disabled');
                }

            });

            // Navigation through steps
            $('.form-footer-nav .btn-nav').on('click', function(e) {
                e.preventDefault();

                if ( $(this).hasClass('disabled') )
                    return false;

                // Determine current and loading steps
                var currentStep = parseInt( $("#current_step").val() );
                var loadingStep = parseInt( $(this).attr('loading-step') );
                var direction = $(this).attr('direction');

                apaDemandeLoadStep(loadingStep, currentStep, direction);
            });

            // Load Steps
            function apaDemandeLoadStep(loadingStep, currentStep, direction) {
                loadingStep = parseInt(loadingStep);
    
                if ( loadingStep < 1 || loadingStep == currentStep || loadingStep > 3 )
                    return false;
                if ( loadingStep == 3) {
                    apaSubmitData();
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
    
    
                // Forward button styles per step
                $(".btn-nav.forward").removeClass(function (index, className) {
                    return (className.match (/\bbtn-etape-\S+/g) || []).join(' ');
                }).addClass('btn-etape-' + loadingStep);
    
                // Scroll top
                $('html, body').stop().animate({
                    scrollTop: 0
                }, 500);
    
                if ( loadingStep == 1) {
                    apaDemandeLoadStepOne(loadingStep, currentStep, direction);
                    return;
                }
                else if ( loadingStep == 2) {
                    apaDemandeLoadStepTwo(loadingStep, currentStep, direction);
                    return;
                }
                else
                    return false;
            }

            function apaDemandeLoadStepOne(loadingStep, currentStep, direction) {
                $("#current_step").val('1');
    
                // Disable back button
                $('.btn-nav.back').removeClass('active').addClass('disabled');
    
                $('#etape-1').fadeIn().removeClass('etape-hidden').addClass('etape-visible');
                
                $(".btn-nav.forward span").text('Suivant');

                history.pushState({page: 'conseils/aides-financieres/apa/formulaire/telecharger/', loadingStep: 0, currentStep: 1, direction: 'back'}, "1", "#!step-1");
    

            }

            function apaDemandeLoadStepTwo(loadingStep, currentStep, direction) {
                $("#current_step").val('2');
    
                // Activate back button
                $('.btn-nav.back').removeClass('disabled').addClass('active');
                $('#etape-3').fadeIn().removeClass('etape-hidden').addClass('etape-visible');
    
                // Envoyer button
                $(".btn-nav.forward").addClass('btn-etape-3');
                $(".btn-nav.forward span").text('Envoyer');

                // step 3
                var showSubmitButton  = false;

                if ( loadingStep == '2' ) {
                    var i = 0;
                    $("#amelis_nom_field, #randomcp_field_name, #amelis_tph_field, #amelis_em_field").each(function(index) {
                        if ( $(this).hasClass('success') )
                            i++;
                    });
                    if ( i == 4)
                        showSubmitButton = true;
                }

                if (showSubmitButton)
                    $('.btn-nav.forward').addClass('active').removeClass('disabled');
                else
                    $('.btn-nav.forward').addClass('disabled').removeClass('active');
    
                if ( direction == 'forward')
                    history.pushState({page: 'conseils/aides-financieres/apa/formulaire/telecharger/', loadingStep: 1, currentStep: 2, direction: 'back'}, "2", "#!step-2");
            }
    

        }

        // Telecharged form
        if ( $('#apaTelecharger').length > 0 ) {

            // Navigation through steps
            $('.btn-nav.forward').on('click', function(e) {
                e.preventDefault();

                if ( $(this).hasClass('disabled') )
                    return false;

                apaSubmitData();
            });
            
        }

        // submit form, which is common
        function apaSubmitData() {    

            var input = {
                'name' : $('#amelis_nom_field').val(),
                'phone' : $('#amelis_tph_field').val(),
                'email' : $('#amelis_em_field').val(),
                'code_postal' : $('#randomcp_field_name').val(),
                'department' : 0,
                'newsletter' : '',
                'contactesign' : '',
                'type' : $('#form_type').val()
            };

            if ( $('input[name="department"]').length > 0 && $('input[name="department"]').is(':checked') )
                input.department = $('input[name="department"]:checked').val();

            // Newsletter checkbox
            if ( $("#newsletter-sign").is(':checked') )
                input.newsletter = $("#newsletter-sign").val();

            // Contact checkbox
            if ( $("#contacte-sign").is(':checked') )
                input.contactesign = $("#contacte-sign").val();

            var data = {
                action: 'apaSubmit',
                nonce: ajax_object.nonce,
                name: input.name,
                email : input.email,
                phone: input.phone,
                code_postal: input.code_postal,
                type: input.type,
                department: input.department,
                newsletter: input.newsletter,
                contactesign: input.contactesign,
            };

            if ( $('#formulaireDemande').length > 0 )
                data.data = $('#formulaireDemande input').serialize()

            if ( $('#apaTelecharger').length > 0 )
                data.data = $('#apaTelecharger input').serialize()

            $.post(ajax_object.url, data, function(response_data) {
                
                var response = jQuery.parseJSON(response_data);

                // Redirect to thank you
                window.location.href = response.thank_you_url;

                // $('#rejoignez-nous')[0].reset();
            }).fail(function(xhr, textStatus, e) {
            });
        }

    });
})
