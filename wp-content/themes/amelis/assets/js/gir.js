jQuery(function($) {
    $(document).ready(function(){

        if ( $('#testGir').length > 0 ) {

            $('.etape-step-holder input[type="radio"]').on('change prev_question_loaded', function(e) {
                $('.form-footer-nav .btn-nav.forward').removeClass('disabled').addClass('active');
            });

            // Click step
            $('.steps-container .step').click(function(e) {
                e.preventDefault();

                var clickedStep = $(this).attr('data-question');
                var currentStep = $('.steps-container .step.step--active').attr('data-question');

                
                if ( currentStep > 1 && currentStep < 17 ) {

                    if ( $(this).hasClass('step--completed') ) {
                        // Mark current bullet as completed or empty
                        if ( $('.etape-1.active').find('input').is(':checked') ) {
                            $("a[data-question='"+currentStep+"']").removeClass('step--active').addClass('step--completed');
                        } else {
                            $("a[data-question='"+currentStep+"']").removeClass('step--active').removeClass('step--completed');
                        }

                        // Hide current question
                        $('#etape-1 .etape-1.active').hide().removeClass('active');

                        // Mark clicked bullet as active
                        $("a[data-question='"+clickedStep+"']").removeClass('step--completed').addClass('step--active');

                        // Show clicked question content
                        $("#etape-1 .etape-1").eq(clickedStep-1).fadeIn('fast').addClass('active');


                        $('.test-gir').trigger('question_loaded');
                    }
                } else if (currentStep == 17) { // coming from form
                    $("a[data-question='"+currentStep+"']").removeClass('step--active').removeClass('step--completed');

                    // Switch etapes between form and questions
                    $('#etape-3').hide();
                    $('#etape-1').show();

                    // Mark clicked bullet as active
                    $("a[data-question='"+clickedStep+"']").removeClass('step--completed').addClass('step--active');

                    // Show clicked question content
                    $("#etape-1 .etape-1").eq(clickedStep-1).fadeIn('fast').addClass('active');

                    // Trigger event for loading next question
                    $('.test-gir').trigger('prev_question_loaded');

                    // Change back button if coming from form
                    changeButtonToSuivant();
                    
                    $('#gdprContainer').hide();

                }

            });

            // Click next
            $('.form-footer-nav .btn-nav.forward').click(function(e) {
                e.preventDefault();

                if ( $(this).hasClass('disabled') )
                    return false;

                // Go forward only if answer is selected
                if ( $('.etape-1.active').find('input').is(':checked') ) {

                    // Hide current question and show next question
                    $('#etape-1 .etape-1.active').hide().removeClass('active').next().fadeIn('fast').addClass('active');

                    // Check if needs to load form or next question
                    if ( parseInt($('.step--active').attr('data-question')) < 16 ) {
                        // Trigger event for loading next question
                        $('.test-gir').trigger('next_question_loaded');
                    } else if ( parseInt($('.step--active').attr('data-question')) == 16 ) {
                        $('.test-gir').trigger('next_question_loaded');
                        
                        $('#etape-1').hide();
                        $('#etape-3').fadeIn('fast');
                        $(this).removeClass('active').addClass('disabled');
                        $('.form-footer.fixed').removeClass('fixed');

                        // console.log('show gdpr')
                        $('#gdprContainer').show();

                        // Button updates
                        changeButtonToEnvoyer();
                    }

                } else {
                    if ($(this).hasClass('form-submit')) {
                        girSubmitData();
                    }
                }
            });

            // Click prev
            $('.form-footer-nav .btn-nav.back').click(function(e) {
                e.preventDefault();
                var step = parseInt($('.step--active').attr('data-question'));

                if ( step > 1 && step < 17 ) {
                    // Hide current question and show prev question
                    $('#etape-1 .etape-1.active').hide().removeClass('active').prev().fadeIn('fast').addClass('active');

                    // Trigger event for loading next question
                    $('.test-gir').trigger('prev_question_loaded');

                    $('#gdprContainer').hide();
                    $('.form-footer-nav .btn-nav.forward').removeClass('form-submit');

                } else if (step == 17) {
                    $('#etape-3').hide();
                    $('#etape-1').show();
                    $('#etape-1 .etape-1').last().fadeIn('fast').addClass('active');

                    // Trigger event for loading next question
                    $('.test-gir').trigger('prev_question_loaded');

                    // Change back button if coming from form
                    changeButtonToSuivant();

                    $('#gdprContainer').hide();
                }
            });


            $('.test-gir').on('question_loaded', function() {
                var step = parseInt($('.step--active').attr('data-question'));

                if ( step == 1 ) {
                    $('.form-footer-nav .btn-nav.forward').removeClass('disabled').addClass('active');
                    $('.form-footer-nav .btn-nav.back').removeClass('active').addClass('disabled');
                }

                // Show back url
                if ( step > 1 )
                    $('.form-footer-nav .btn-nav.back').removeClass('disabled').addClass('active');

                // Show forward url if there already is an option selected
                if ( $('.etape-1.active').find('input').is(':checked') )
                    $('.form-footer-nav .btn-nav.forward').removeClass('disabled').addClass('active');
                else
                    $('.form-footer-nav .btn-nav.forward').removeClass('active').addClass('disabled');
            });


            $('.test-gir').on('next_question_loaded', function() {
                // Bullets progress
                $('.step--active').removeClass('step--active').addClass('step--completed').next().addClass('step--active');

                var step = parseInt($('.step--active').attr('data-question'));

                // Show back url
                if ( step > 1 )
                    $('.form-footer-nav .btn-nav.back').removeClass('disabled').addClass('active');

                // Show forward url if there already is an option selected
                if ( $('.etape-1.active').find('input').is(':checked') )
                    $('.form-footer-nav .btn-nav.forward').removeClass('disabled').addClass('active');
                else
                    $('.form-footer-nav .btn-nav.forward').removeClass('active').addClass('disabled');
            });


            $('.test-gir').on('prev_question_loaded', function() {
                // Bullets progress
                var currentStep = $('.step--active').attr('data-question');

                if( $('.etape-1').eq(currentStep-1).find('input').is(':checked') )
                    $('.step--active').removeClass('step--active').addClass('step--completed').prev().addClass('step--active');
                else
                    $('.step--active').removeClass('step--active').prev().addClass('step--active');

                // Show back url
                if ( parseInt($('.step--active').attr('data-question')) > 1 ) {
                    $('.form-footer-nav .btn-nav.back').removeClass('disabled').addClass('active');
                    $('.form-footer-nav .btn-nav.forward').removeClass('disabled').addClass('active');
                }
                else {
                    $('.form-footer-nav .btn-nav.back').removeClass('active').addClass('disabled');
                    $('.form-footer-nav .btn-nav.forward').removeClass('disabled').addClass('active');
                }
            });



            function girSubmitData() {
                var input = {
                    'name' : $('#amelis_nom_field').val(),
                    'phone' : $('#amelis_tph_field').val(),
                    'email' : $('#amelis_em_field').val(),
                    'code_postal' : $('#randomcp_field_name').val(),
                    'newsletter' : '',
                    'contactesign' : '',
                };

            
                // Newsletter checkbox
                if ( $("#newsletter-sign").is(':checked') )
                    input.newsletter = $("#newsletter-sign").val();

                // Contact checkbox
                if ( $("#contacte-sign").is(':checked') )
                    input.contactesign = $("#contacte-sign").val();

                var data = {
                    action: 'girSubmit',
                    nonce: ajax_object.nonce,
                    name: input.name,
                    email : input.email,
                    phone: input.phone,
                    code_postal: input.code_postal,
                    newsletter: input.newsletter,
                    contactesign: input.contactesign,
                    data: $('#testGir input').serialize()
                };

                $.post(ajax_object.url, data, function(response_data) {
                    var response = jQuery.parseJSON(response_data);

                    // Redirect to thank you
                    window.location.href = response.thank_you_url;
    
                    // $('form#testGir')[0].reset();
                }).fail(function(xhr, textStatus, e) {
                });
            }


            function changeButtonToEnvoyer() {
                $('.form-footer-nav .btn-nav.forward').addClass('form-submit btn-etape-3').removeClass('btn-etape-1');
                $('.form-footer-nav .btn-nav.forward span').text('Envoyer');
                $('.form-footer-nav .btn-nav.forward svg').hide();
            }

            function changeButtonToSuivant() {
                if ( $('.form-footer-nav .btn-nav.forward').hasClass('btn-etape-3') ) {
                    $('.form-footer-nav .btn-nav.forward').removeClass('form-submit btn-etape-3').addClass('btn-etape-1');
                    $('.form-footer-nav .btn-nav.forward span').text('Suivant');
                    $('.form-footer-nav .btn-nav.forward svg').show();
                }
            }

        }

    });
})
