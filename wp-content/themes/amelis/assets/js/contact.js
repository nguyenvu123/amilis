jQuery(function($) {
    $(document).ready(function(){




        $("#etape-contact #amelis_nom_field, #etape-contact #agency_selection_xs, #contact-subject, #etape-contact #amelis_tph_field, #etape-contact #amelis_em_field").on('change keyup blur', function(e) {
            var showSubmitButton = 0;

            $("#etape-contact #amelis_nom_field, #etape-contact #agency_selection_xs, #contact-subject, #etape-contact #amelis_tph_field, #etape-contact #amelis_em_field").each(function(index) {
                if ( $(this).hasClass('success') )
                    showSubmitButton++;
            });

            if (showSubmitButton == 5)
                $('.btn-etape-3.btn-nav.forward').addClass('active').removeClass('disabled');
            else
                $('.btn-etape-3.btn-nav.forward').addClass('disabled').removeClass('active');
        });

        if ( $('#contactForm').length > 0 ) {

            // Navigation through steps
            $('.btn-nav.forward').on('click', function(e) {
                e.preventDefault();

                if ( $(this).hasClass('disabled') )
                    return false;

                contactSubmitData();
            });
            
        }



        // submit form, which is common
        function contactSubmitData() {    

            var input = {
                'name' : $('#amelis_nom_field').val(),
                'phone' : $('#amelis_tph_field').val(),
                'email' : $('#amelis_em_field').val(),
                'subject' : $('#contact-subject').val(),
                'agence' : $('#agency_selection_xs').val(),
                'newsletter' : '',
            };

            
            // Newsletter checkbox
            if ( $("#newsletter-sign").is(':checked') )
                input.newsletter = $("#newsletter-sign").val();


            var data = {
                action: 'contactSubmit',
                nonce: ajax_object.nonce,
                name: input.name,
                email : input.email,
                phone: input.phone,
                subject: input.subject,
                agence: input.agence,
                newsletter: input.newsletter,
                data: $('#contactForm input').serialize()
            };

            

            $.post(ajax_object.url, data, function(response_data) {
                var response = jQuery.parseJSON(response_data);

                // Redirect to thank you
                window.location.href = response.thank_you_url;

                // $('#rejoignez-nous')[0].reset();
            }).fail(function(xhr, textStatus, e) {
            });
        }




        // Validation
        $('#agency_selection_xs').on('blur', function(e) {
            stringVal = $(this);
            validateContactAgence(stringVal);
        })

        function validateContactAgence(stringVal) {
            if(stringVal.val() > 0 ) {
                stringVal.removeClass().addClass('success');
                stringVal.parent().parent().find('.validation-message').text('');
            }
            else {
                stringVal.removeClass().addClass('error');
                stringVal.parent().parent().find('.validation-message').removeClass('success-message').addClass('error-message').text("Le champ Sélectionnez votre agence * est requis.");
            }
        }


        
        $('#contact-subject').on('blur', function(e) {
            stringVal = $(this);
            validateContactSubject(stringVal);
        })

        function validateContactSubject(stringVal) {
            if(stringVal.val().length > 0 ) {
                stringVal.removeClass().addClass('success');
                stringVal.parent().parent().find('.validation-message').text('');
            }
            else {
                stringVal.removeClass().addClass('error');
                stringVal.parent().parent().find('.validation-message').removeClass('success-message').addClass('error-message').text("Le champ Sélectionnez l'objet de votre demande * est requis.");
            }
        }


        

    });
})
