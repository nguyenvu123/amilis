<?php


function send_form_email($subject, $to, $message, $attachments = NULL, $links) {
    // Headers
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8'."\r\n";
    $headers .= 'From: Amelis Groupe Sodexo <'.FROM_EMAIL.'>'."\r\n";

    $links_array = [
        'NosAgences' => '<a href="'.WP_SITEURL.'/nos-agences/">Nos Agences</a>',
        'NosServices' => '<a href="'.WP_SITEURL.'/nos-services/">Nos Services</a>',

        'Blog' => '<a href="https://institut.amelis-services.com/">Blog</a></p>',

        'AideFinancieres' => '<a href="'.WP_SITEURL.'/conseils/aides-financieres/">Aides Financieres</a>',
        'NotreFonctionnement' => '<a href="'.WP_SITEURL.'/qui-sommes-nous/fonctionnement/">Notre Fonctionnement</a>',
        'Histoire' => '<a href="'.WP_SITEURL.'/qui-sommes-nous/le-groupe">L’histoire Amelis</a>',

        'FormPCH' => '<a href="'.WP_SITEURL.'/conseils/aides-financieres/pch/telecharger-formulaire/">Formulaire demande PCH</a>',
        'GuidePCH' => '<a href="'.WP_SITEURL.'/conseils/aides-financieres/pch/telecharger/">Guide pratique PCH</a>',
    ];

    $message .= '<p>'.$links_array[$links[0]].' &nbsp;&nbsp;&nbsp;&nbsp; '.$links_array[$links[1]].'  &nbsp;&nbsp;&nbsp;&nbsp; '.$links_array[$links[2]].' </p>';
  
    $message .= '<br>';

    $message .= '<table border="0" cellpadding="0" cellspacing="0" width="600">
    <tbody><tr>
      <td align="left" width="134"><img style="width:134px;border:none;display:block" src="'.get_stylesheet_directory_uri().'/assets/images/email/email-logo.png"></td>
      <td width="40"></td>
      <td style="border-right:1px solid #333"></td>
      <td width="40"></td>
      <td><table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody><tr>
          <td><span style="color:#dc3d05"><strong>Amelis groupe Sodexo</strong></span><br><span style="color:#dc3d05"><i>Les Professionnels de l’aide à domicile</i></span><br>19 rue du Dôme, 92100 Boulogne-Billancourt</td>
        </tr>
        <tr><td height="5"></td></tr>
        <tr>
          <td><a href="tel:0811%20130%C2%A0078" target="_blank">0811 130&nbsp;078</a></td>
        </tr>
        <tr><td height="7"></td></tr>
        <tr>
          <td>
            <a href="https://www.facebook.com/AmelisServices" style="display:inline-block" target="_blank"><img src="'.get_stylesheet_directory_uri().'/assets/images/email/icon-facebook.png" width="30" height="30" style="width:30px;height:30px;border:none;display:block" class="CToWUd"></a>
            <a href="https://fr.linkedin.com/company/amelis-services" style="display:inline-block" target="_blank"><img src="'.get_stylesheet_directory_uri().'/assets/images/email/icon-linkedin.png" width="30" height="30" style="width:30px;height:30px;border:none;display:block" class="CToWUd"></a>
            <a href="https://twitter.com/amelisservices" style="display:inline-block" target="_blank"><img src="'.get_stylesheet_directory_uri().'/assets/images/email/icon-twitter.png" width="30" height="30" style="width:30px;height:30px;border:none;display:block" class="CToWUd"></a>
            <a href="https://www.youtube.com/channel/UCOanvcTvuC4VeyMP3kQn3IA" style="display:inline-block" target="_blank"><img src="'.get_stylesheet_directory_uri().'/assets/images/email/icon-youtube.png" width="30" height="30" style="width:30px;height:30px;border:none;display:block" class="CToWUd"></a>
          </td>
        </tr>
      </tbody></table></td>
    </tr>
  </tbody></table>';

  $message .= '<p></p>';

    wp_mail( $to, $subject, $message, $headers, $attachments );
}


function send_APA_guide_email($data) {
    
    $subject = 'Votre guide APA';

    $to = $data['email'];

    $message = '';
    $message .= '<p>Bonjour '.$data['name'].',</p>';
    $message .= '<p>Veuillez trouver ci-joint votre guide APA.</p>';
    $message .= '<p>Vous trouverez au sein de ce guide toutes les informations utiles concernant cette aide sociale destinée aux personnes âgées en perte d’autonomie.</p>';
    $message .= '<p>Contactez-nous pour plus de renseignements sur l’Allocation Personnalisée d’Autonomie et nos services d’aide à domicile.</p>';
    $message .= '<p>Cordialement</p>';
    
    $attachments = array(WP_CONTENT_DIR . '/guides/Guide-Pratique-APA.pdf');

    $links = ['AideFinancieres', 'NotreFonctionnement', 'NosAgences'];

    send_form_email($subject, $to, $message, $attachments, $links);
    
    $return_url = site_url(PATH_APA_GUIDE_THANK_YOU);
    return $return_url;
}


function send_APA_formulaire_email($data) {

    $subject = 'Votre formulaire APA';

    $to = $data['email'];
    

    $message = '';
    $message .= '<p>Bonjour '.$data['name'].',</p>';
    $message .= '<p>Veuillez trouver ci-joint votre formulaire de demande APA.</p>';
    $message .= '<p>Pour tout savoir sur la préparation et l’instruction de votre dossier par le conseil général, téléchargez notre <a href="'.WP_SITEURL.'/aides/apa">guide pratique APA</a>.</p>';
    $message .= '<p>Contactez-nous pour plus de renseignements sur l’Allocation Personnalisée d’Autonomie et nos services d’aide à domicile.</p>';
    $message .= '<p>Cordialement</p>';


    $form_files = array(
        6 => 'Formulaire-Demande-APA-Alpes-Maritimes-06',
        33 => 'Formulaire-Demande-APA-Gironde-33',
        35 => 'Formulaire-Demande-APA-Ille-et-Vilaine-35',
        49 => 'Formulaire-Demande-APA-Maine-et-Loire-49',
        75 => 'Formulaire-Demande-APA-Paris-75',
        78 => 'Formulaire-Demande-APA-Yvelines-78',
        92 => 'Formulaire-Demande-APA-Hauts-de-Seine-92',
        95 => 'Formulaire-Demande-APA-Val-d_oise-95'
    );

    $attachments = array(WP_CONTENT_DIR . "/guides/".$form_files[$data['department']].".pdf");

    $links = ['AideFinancieres', 'NotreFonctionnement', 'NosAgences'];

    send_form_email($subject, $to, $message, $attachments, $links);

    $return_url = site_url(PATH_APA_FORM_THANK_YOU);
    return $return_url;
}


function send_PCH_guide_email($data) {

    $subject = 'Votre guide PCH';

    $to = $data['email'];

    $message = '';
    $message .= '<p>Bonjour '.$data['name'].',</p>';
    $message .= '<p>Veuillez trouver ci-joint votre guide PCH.</p>';
    $message .= '<p>Vous trouverez au sein de ce guide toutes les informations utiles concernant cette aide destinée aux personnes handicapées.</p>';
    $message .= '<p>Contactez-nous pour plus de renseignements sur la Prestation de Compensation du Handicap et nos services d’aide à domicile.</p>';
    $message .= '<p>Cordialement</p>';
    
    $attachments = array(WP_CONTENT_DIR . '/guides/Guide-PCH.pdf');

    $links = ['FormPCH', 'NosServices', 'Blog'];

    send_form_email($subject, $to, $message, $attachments, $links);
    
    $return_url = site_url(PATH_PCH_GUIDE_YOU);
    return $return_url;
}


function send_PCH_formulaire_email($data) {

    $subject = 'Votre formulaire PCH';

    $to = $data['email'];

    $message = '';
    $message .= '<p>Bonjour '.$data['name'].',</p>';
    $message .= '<p>Veuillez trouver ci-joint votre formulaire de demande PCH.</p>';
    $message .= '<p>Pour tout savoir sur la préparation et l’instruction de votre dossier par le conseil général, téléchargez notre <a href="'.WP_SITEURL.'/conseils/aides-financieres/pch/telecharger/">guide pratique PCH.</a></p>';
    $message .= '<p>Contactez-nous pour plus de renseignements sur la Prestation de Compensation du Handicap et nos services d’aide à domicile.</p>';
    $message .= '<p>Cordialement</p>';

    
    // $attachments = array(WP_CONTENT_DIR . '/guides/Formulaire-PCH.pdf');
    $attachments = array(WP_CONTENT_DIR . '/guides/Formulaire-MDPH-2017.pdf');

    $links = ['GuidePCH', 'NosServices', 'Blog'];

    send_form_email($subject, $to, $message, $attachments, $links);

    $return_url = site_url(PATH_PCH_FORM_THANK_YOU);
    return $return_url;
}


function send_ARDH_guide_email($data) {

    $subject = 'Votre formulaire ARDH';

    $to = $data['email'];

    $message = '';
    $message .= '<p>Bonjour '.$data['name'].',</p>';
    $message .= '<p>Veuillez trouver ci-joint votre formulaire de demande ARDH.</p>';
    $message .= '<p>Contactez-nous pour plus de renseignements sur l’Aide au Retour à Domicile après Hospitalisation et nos services d’aide à domicile.</p>';
    $message .= '<p>Contactez-nous pour plus de renseignements sur l’Allocation Personnalisée d’Autonomie et nos services d’aide à domicile.</p>';
    $message .= '<p>Cordialement</p>';

    
    $attachments = array(WP_CONTENT_DIR . '/guides/Demande-ARDH.pdf');

    $links = ['AideFinancieres', 'NosServices', 'Blog'];

    send_form_email($subject, $to, $message, $attachments, $links);
    
    $return_url = site_url(PATH_ARDH_THANK_YOU);
    return $return_url;
}


function send_devis_gratuit_email($data) {

    $subject = 'Réception de votre demande d’aide à domicile';

    $to = $data['email'];

    $message = '';
    $message .= '<p>Bonjour '.$data['name'].',</p>';
    $message .= '<p>Nous avons bien reçu votre demande d’aide à domicile.</p>';
    $message .= '<p>Nos équipes vous contacteront sous 24h (jours ouvrés).</p>';
    $message .= '<p>Cordialement</p>';
    $message .= '<p></p>';


    $links = ['AideFinancieres', 'NotreFonctionnement', 'NosAgences'];

    send_form_email($subject, $to, $message, NULL, $links);

    return true;
}


function send_emploi_auxiliaire_email($data) {

    $subject = 'Merci pour votre candidature';

    $to = $data['email'];

    $message = '';
    $message .= '<p>Bonjour '.$data['name'].',</p>';
    $message .= '<p>Nous avons bien reçu votre candidature pour le poste d’auxiliaire de vie (H/F) et vous remercions de l’intérêt que vous portez à notre entreprise.</p>';
    $message .= '<p>Sans nouvelle de notre part dans un délai de trois semaines, nous vous demandons de bien vouloir considérer que nous ne pouvons pas y apporter une suite favorable.</p>';
    $message .= '<p>Cordialement</p>';
    $message .= '<p></p>';


    $links = ['NotreFonctionnement', 'Histoire', 'Blog'];

    send_form_email($subject, $to, $message, NULL, $links);

    return true;
}


function send_emploi_administratif_email($data) {

    $subject = 'Merci pour votre candidature';

    $to = $data['email'];

    $message = '';
    $message .= '<p>Bonjour '.$data['name'].',</p>';
    $message .= '<p>Nous accusons réception de votre candidature et vous remercions de l’intérêt que vous portez à notre société.</p>';
    $message .= '<p>Votre dossier sera traité dans les plus brefs délais. Cependant, si vous n’avez pas de nouvelles de notre part dans les trois semaines qui suivent ce courrier, veuillez considérer que nous ne sommes pas en mesure de répondre favorablement à votre candidature.</p>';
    $message .= '<p>Sauf avis contraire de votre part, nous nous permettons de conserver dans notre base de données l’ensemble des éléments que vous nous avez transmis afin de vous faire part d’opportunités futures susceptibles de vous intéresser.</p>';
    $message .= '<p>Cordialement</p>';
    $message .= '<p></p>';


    $links = ['NotreFonctionnement', 'Histoire', 'Blog'];

    send_form_email($subject, $to, $message, NULL, $links);

    return true;
}


function send_contact_email($data) {

    $subject = 'Confirmation de réception de votre demande';

    $to = $data['email'];

    $message = '';
    $message .= '<p>Bonjour '.$data['name'].',</p>';
    $message .= '<p>Nous avons bien reçu votre demande.</p>';
    $message .= '<p>Nos équipes vous contacteront sous 24h (jours ouvrés).</p>';
    $message .= '<p>Cordialement</p>';
    $message .= '<p></p>';


    $links = ['AideFinancieres', 'NotreFonctionnement', 'NosAgences'];

    send_form_email($subject, $to, $message, NULL, $links);

    return true;
}