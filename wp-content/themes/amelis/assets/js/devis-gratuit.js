jQuery(function($) {
    $(document).ready(function(){

        // // Reset form on refresh
        // if ( $('form#devisGratuit').length > 0 )
        //   $('form#devisGratuit')[0].reset();

        // step 1 validation
        $('#devisGratuit #etape-1 input[type=radio]').on('change', function(e) {
            $('.btn-nav.forward')
                .addClass('active')
                .removeClass('disabled');
        });

        //step 2 validation
        $('#devisGratuit input[name="combien-fois"], #devisGratuit input[name="services[]"]').on('change', function(e) {
            if ( $('#devisGratuit input[name="combien-fois"]').is(':checked') && $('#devisGratuit input[name="services[]"]').is(':checked') ) {
                $('.btn-nav.forward')
                    .addClass('active')
                    .removeClass('disabled');
            } else {
                $('.btn-nav.forward')
                    .removeClass('active')
                    .addClass('disabled');
            }
        })


        // Navigation through steps
        $('.devisGratuitNav .btn-nav').on('click', function(e) {
            e.preventDefault();

            if ( $(this).hasClass('disabled') )
                return false;

            // Determine current and loading steps
            var currentStep = parseInt( $("#current_step").val() );
            var loadingStep = parseInt( $(this).attr('loading-step') );
            var direction = $(this).attr('direction');

            devisGratuitLoadStep(loadingStep, currentStep, direction);
        });

        // Load Steps
        function devisGratuitLoadStep(loadingStep, currentStep, direction) {
            loadingStep = parseInt(loadingStep);

            if ( loadingStep < 1 || loadingStep == currentStep || loadingStep > 4 )
                return false;
            if ( loadingStep == 4) {
                devisGratuitSubmitData();
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
                devisGratuitLoadStepOne(loadingStep, currentStep, direction);
                return;
            }
            else if (loadingStep == 2) {
                devisGratuitLoadStepTwo(loadingStep, currentStep, direction);
                return;
            }
            else if (loadingStep == 3) {
                devisGratuitLoadStepThree(loadingStep, currentStep, direction);
                return;
            }
            else
                return false;
        }

        // Load step 1
        function devisGratuitLoadStepOne(loadingStep, currentStep, direction) {
            $("#current_step").val('1');

            // Disable back button
            $('.btn-nav.back').removeClass('active').addClass('disabled');

            $('#etape-1').fadeIn().removeClass('etape-hidden').addClass('etape-visible');

            $('.devis-gratuit-title').text('Quels sont mes besoins ?');
            $('.devis-gratuit-title').parent().find('p').hide();

            $(".btn-nav.forward span").text('Suivant');

            // History push
            // console.log('Update history: ' + loadingStep, currentStep, direction);

            history.pushState({page: ajax_object.form_url, loadingStep: 0, currentStep: 1, direction: 'back'}, "1", "#!step-1");

            checkFieldsWhenStepLoads(loadingStep);
        }

        function devisGratuitLoadStepTwo(loadingStep, currentStep, direction) {
            $("#current_step").val('2');

            // Activate back button
            $('.btn-nav.back').removeClass('disabled').addClass('active');
            $('#etape-2').fadeIn().removeClass('etape-hidden').addClass('etape-visible');


            $('.devis-gratuit-title').text('Quels sont les besoins de la personne aidée ?');
            $('.devis-gratuit-title').parent().find('p').hide();

            $(".btn-nav.forward span").text('Suivant');

            // console.log('Update history: ' + loadingStep, currentStep, direction);

            // // History push
            // if ( direction == 'back')
            //     window.history.go(-1);
            if ( direction == 'forward')
                history.pushState({page: ajax_object.form_url, loadingStep: 1, currentStep: 2, direction: 'back'}, "2", "#!step-2");

            checkFieldsWhenStepLoads(loadingStep);

        }

        function devisGratuitLoadStepThree(loadingStep, currentStep, direction) {
            $("#current_step").val('3');

            // Activate back button
            $('.btn-nav.back').removeClass('disabled').addClass('active');
            $('#etape-3').fadeIn().removeClass('etape-hidden').addClass('etape-visible');

            $(".devis-gratuit-title").text("Quelles sont mes coordonnées ?");
            $('.devis-gratuit-title').parent().find('p').text('Les champs identifiés par (*) sont obligatoires').show();

            $(".btn-nav.forward span").text('Envoyer');

            $('#amelis_nom_field').trigger('step_3_loaded');
            $('#randomcp_field_name').trigger('step_3_loaded');
            $('#amelis_tph_field').trigger('step_3_loaded');
            $('#amelis_em_field').trigger('step_3_loaded');

            // History push
            // console.log('Update history: ' + loadingStep, currentStep, direction);// History push

            // if ( direction == 'back')
            //     window.history.go(-1);
            if (direction == 'forward')
                history.pushState({page: ajax_object.form_url, loadingStep: 2, currentStep: 3, direction: 'back'}, "3", "#!step-3");

            checkFieldsWhenStepLoads(loadingStep);
        }

        function devisGratuitSubmitData() {
            var input = {
                'name' : $('#amelis_nom_field').val(),
                'phone' : $('#amelis_tph_field').val(),
                'email' : $('#amelis_em_field').val(),
                'code_postal' : $('#randomcp_field_name').val(),
                'newsletter' : '',
            };


            // Newsletter checkbox
            if ( $("#newsletter-sign").is(':checked') )
                input.newsletter = $("#newsletter-sign").val();


            var data = {
                action: 'devisGratuitSubmit',
                nonce: ajax_object.nonce,
                name: input.name,
                email : input.email,
                phone: input.phone,
                code_postal: input.code_postal,
                newsletter: input.newsletter,
                data: $('#devisGratuit input').serialize()
            };

            $.post(ajax_object.url, data, function(response_data) {

                var response = jQuery.parseJSON(response_data);

                // Redirect to thank you
                window.location.href = response.thank_you_url;
                // console.log(response);

                // Go to thank you page
                // $('#devisGratuit').slideUp('normal', function() {
                //   $('.form-footer nav').remove();
                //   $('.section-thank-you').slideDown('normal');
                // })

            }).fail(function(xhr, textStatus, e) {
            });
        }



        // History check
        if ( $('#devisGratuit').length > 0 ) {

            var hash = window.location.hash;
            var hash_split = hash.split('-');

            if ( hash_split.length <= 1 )
                history.pushState({page: ajax_object.form_url, loadingStep: 0, currentStep: 1, direction: 'back'}, "1", "#!step-1");


            window.onpopstate = function(e) {
                var data = e.state;

                if(data) {
                    if(e.state.page === ajax_object.form_url) {
                        var direction = "forward";

                        var hash = window.location.hash;
                        var hash_split = hash.split('-');

                        if ( hash_split[1].length > 0 ) {
                            var loadingStep = hash_split[1];
                            var currentStep = parseInt( $("#current_step").val() );

                            if ( loadingStep < currentStep )
                                direction = 'back';

                            devisGratuitLoadStep(loadingStep, currentStep, direction);
                        }
                    }
                }
            };
        }




        // Validation
        $('#amelis_nom_field').on('blur', function(e) {
            nom = $(this);
            validateNom(nom);
        })

        function validateNom(nom) {
            if(nom.val().length > 0 ) {
                nom.removeClass().addClass('success');
                nom.parent().parent().find('.validation-message').text('');
            }
            else {
                nom.removeClass().addClass('error');
                nom.parent().parent().find('.validation-message').removeClass('success-message').addClass('error-message').text('Nom et prénom sont requis.');
            }
        }



        $('#randomcp_field_name').on('blur', function(e) {
            if( $(this).val().length == 5 ) {
                $(this).removeClass().addClass('success');
                $(this).parent().parent().find('.validation-message').text('');
                $('#randomcp_field_name_text_with_location').removeClass().addClass('success');
                showAgenceIfFound($(this).val());
            }
            else {
                $(this).removeClass().addClass('error');
                $(this).parent().parent().find('.validation-message').removeClass('success-message').addClass('error-message').text('Le code postal doit contenir 5 chiffres');
                $('#randomcp_field_name_text_with_location').removeClass().addClass('error');
            }
        })

        $( "#randomcp_field_name" ).keyup(function() {
            if($(this).val().length == 5) {
                // $(this).removeClass().addClass('success');
                // $(this).parent().parent().find('.validation-message').text('');
                // $('#randomcp_field_name_text_with_location').removeClass().addClass('success');
                // showAgenceIfFound($(this).val());
            }
            else if ($(this).val().length > 5 ) {
                var postal_code = $(this).val();
                $(this).val(postal_code.substring(0,5));

                $(this).removeClass().addClass('error');
                $(this).parent().parent().find('.validation-message').removeClass('success-message').addClass('error-message').text('Le code postal doit contenir 5 chiffres');
            }
        });


        $('#amelis_tph_field').on('blur', function(e) {
            if($(this).val().length == 10) {

                var attr = $(this).attr('required')

                if ( typeof attr !== typeof undefined && attr !== false )
                    $(this).removeClass().addClass('success');
                else
                    $(this).removeClass().addClass('success noValidation');
            }
            else {
                $(this).removeClass().addClass('error');
                $(this).parent().parent().find('.validation-message').removeClass('success-message').addClass('error-message').text('Le téléphone doit contenir 10 chiffres.');
            }
        })

        $( '#amelis_tph_field' ).keyup(function() {
            if($(this).val().length == 10) {

                var attr = $(this).attr('required')

                if ( typeof attr !== typeof undefined && attr !== false )
                    $(this).removeClass().addClass('success');
                else
                    $(this).removeClass().addClass('success noValidation')

                $(this).removeClass().addClass('success');

                $(this).parent().parent().find('.validation-message').text('');
            } else if ( $(this).val().length < 10 ) {
                $(this).removeClass();
            }
            else if ($(this).val().length > 10 ) {
                var phone = $(this).val();
                $(this).val(phone.substring(0,10));

                $(this).removeClass().addClass('success');
                $(this).parent().parent().find('.validation-message').removeClass('success-message').addClass('error-message').text('Le téléphone doit contenir 10 chiffres.');
            }
        });

        $('#amelis_em_field ').on('blur', function(e) {
            if( validate_email($(this).val() ) ) {
                $(this).removeClass().addClass('success');
                $(this).parent().parent().find('.validation-message').text('');
            }
            else {
                $(this).removeClass().addClass('error');
                $(this).parent().parent().find('.validation-message').removeClass('success-message').addClass('error-message').text("E-mail n'est pas valide");
            }
        })


        $("#etape-3 #amelis_nom_field, #etape-3 #randomcp_field_name, #etape-3 #amelis_tph_field, #etape-3 #amelis_em_field").on('change keyup blur', function(e) {
            var showSubmitButton = 0;
            var howManyRequiredFields = 0;

            $("#etape-3 #amelis_nom_field, #etape-3 #randomcp_field_name, #etape-3 #amelis_tph_field, #etape-3 #amelis_em_field").each(function(index) {
                var attr = $(this).attr('required')

                if ( typeof attr !== typeof undefined && attr !== false ) {
                    howManyRequiredFields++;

                    if ( $(this).hasClass('success')  && !$(this).hasClass('noValidation') )
                        showSubmitButton++;
                }
            });

            // console.log(showSubmitButton, howManyRequiredFields);

            if (showSubmitButton == howManyRequiredFields)
                $('.btn-etape-3.btn-nav.forward, .btn-finish-gir').addClass('active').removeClass('disabled');
            else
                $('.btn-etape-3.btn-nav.forward, .btn-finish-gir').addClass('disabled').removeClass('active');
        });


        function checkFieldsWhenStepLoads(stepLoaded) {
            var showSubmitButton = false;

            // step 1
            if ( stepLoaded == '1' ) {
                if ( $('input[name="aide-pour"]').is(':checked') ) {
                    // console.log('detected loading step 1');
                    showSubmitButton = true;
                }
            }


            // step 2
            if ( stepLoaded == '2' ) {
                if ( $('input[name="services[]"]').is(':checked') && $('input[name="combien-fois"]').is(':checked') ) {
                    showSubmitButton = true;
                    // console.log('detected loading step 2');
                }
            }

            // step 3
            if ( stepLoaded == '3' ) {
                var i = 0;
                $("#etape-3 #amelis_nom_field, #etape-3 #randomcp_field_name, #etape-3 #amelis_tph_field, #etape-3 #amelis_em_field").each(function(index) {
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
        }



        // Devis Gratuit autocomplete
        $('#randomcp_field_name').autocomplete({
            serviceUrl: ajax_object.url,
            type: 'POST',
            minChars: 3,
            autoSelectFirst: true,
            showNoSuggestionNotice: true,
            noSuggestionNotice: "Aucun résultat",
            onSelect: function(suggestion) {
            if ( $('#showAgenceBool').val() == 'false' ) {

            } else {
                showAgenceIfFound(suggestion.data)
            }

            matchAgenceByRandomPostalCodeOnTrouver(suggestion.data);

            if ( $('#randomcp_field_name_text_with_location').length > 0 ) {
                $('#randomcp_field_name_text_with_location').val(suggestion.value).show();

                $('#randomcp_field_name').val(suggestion.data).trigger('blur').hide();
            }

            $('.text-input.code-postal').next('.text-input').find('input').focus();



            // $(this).parents('.form-page').find('input,a,select,button,textarea')
            //         .filter(':visible, #randomcp_field_name_text_with_location, #randomcp_field_name')
            //         .eq(focusable.index(self) + (e.shiftKey ? -1 : 1)).focus();

            },
            params: {
            action : 'postalCodeAutocomplete',
            nonce: ajax_object.nonce
            }
        });

        $('#randomcp_field_name_text_with_location').on('focus', function() {
            $(this).hide();
            $('#randomcp_field_name').show().focus();
        })

        function showAgenceIfFound(postal_code) {

            if ( $('#randomcp_field_name').length > 0 ) {
                var type = 'agence';

                var data = {
                    action : 'getAgenceByPostalCode',
                    type: type,
                    postal_code : postal_code
                };

                if ( $('#emploi_form').val() == 'true' )
                    data.type = 'emploi';

                $.post(ajax_object.url, data, function(response_data) {
                var response = jQuery.parseJSON(response_data);
                    if ( response.agence == 'true') {
                        $('.agence-not-found').text('').hide();
                        $('.agence-not-found-small-map').text('').hide();

                        $('.agence-found').text(response.message).fadeIn();

                        $('#trouverTitle').text('Agence la plus proche');

                        // Emploi
                        $('.emploi-agence-found').text(response.message).fadeIn();
                        if ( $('#agenceDropdown').length > 0 ) {
                            $('#agenceDropdown').hide();
                        }
                    }
                    else {
                        var notFound = 'Amelis n’intervient pas dans votre ville, nous pouvons transmettre votre demande à nos partenaires qui seront susceptibles de vous aider dans vos recherches. Si vous souhaitez être contacté par leurs soins, merci de compléter le formulaire et de cliquer sur «Envoyer». Cordialement, l’équipe Amelis';

                        $('.agence-not-found').text(notFound).fadeIn();
                        $('.agence-found').text(notFound).fadeIn();

                        $('.agence-not-found-small-map').text('Amelis n’intervient pas dans votre ville.').fadeIn();
                        
                        $('.agence-not-found-trouvez').text('Amelis n’intervient pas dans votre ville.').fadeIn();



                        // Emploi
                        $('.emploi-agence-found').text('No agence.').fadeIn();

                        if ( $('#agenceDropdown').length > 0 ) {
                            $('#agenceDropdown').show();
                        }
                    }
                });
            };

        }

        function matchAgenceByRandomPostalCodeOnTrouver(postal_code) {
            if ( $('#code_postal_hidden').length > 0 ) {
                $('#code_postal_hidden').val(postal_code).trigger("change");
            }
        }




        function validate_number (number) {
            return /^\d+$/.test(this);
        }

        var validate_email = function(email) {
            // http://stackoverflow.com/a/46181/11236
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }


    });
})
