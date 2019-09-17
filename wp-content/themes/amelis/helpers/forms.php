<?php

    function show_name_field($label = 'Mon Prénom et Nom *', $field = 'amelis_nom_field') {
        echo '<label for="'.$field.'">
            <span>'.$label.'</span>
            <input type="text" placeholder="'.$label.'" class="field-required" id="'.$field.'" required="required">
        </label>';
    }

    function show_email_field($label = 'Mon Email *', $field = 'amelis_em_field') {
        echo '<label for="'.$field.'">
            <span>'.$label.'</span>
            <input type="email" placeholder="'.$label.'" class="field-required" id="'.$field.'" required="required">
        </label>';
    }

    function show_telephone_field( $required = true, $label = 'Mon Téléphone *', $field = 'amelis_tph_field') {
        $input = '<label for="'.$field.'">
            <span>'.$label.'</span>
            <input type="number" onkeydown="return FilterInput(event)" class="field-required" placeholder="'.$label.'" id="'.$field.'"';
        
        if ( $required )
            $input .= ' required="required"';
            
        $input .= '>
        </label>';

        echo $input;
    }


    function show_agences_dropdown() {
        $agences = getAllAgences();

        echo '<select name="agency-selection" id="agency_selection_map">
            <option value="0" selected>Sélectionnez une autre agence</option>';
        foreach ( $agences as $a ) {
            echo '<option value="'.get_field('zipcode', $a->ID).'">'.$a->post_title.'</option>';
        }
        echo '</select>';
    }


    function show_newsletter_checkbox() {
        echo '<label class="newsletter-sign" for="newsletter-sign">
                    <input type="checkbox" name="newsletter_box" id="newsletter-sign" value="1"> Je souhaite recevoir la newsletter Amelis
                </label>';
    }


    function display_code_postal_placeholder() {
        echo 'Code postal de la personne aidée';
    }



    function email_is_spam($email) {
        $emails = ['hoyer.bezons@gmail.com'];

        if ( in_array($email, $emails) ) {
            return true;
        } else {
            return false;
        }
    }