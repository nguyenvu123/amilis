<?php

function display_organization_schema() {
    $schema = '<script type="application/ld+json">
        {
        "@context":"http://schema.org",
        "@type":"Organization",
        "name":"Amelis groupe Sodexo",
        "url":"https://www.amelis-services.com/",
        "logo": "https://www.amelis-services.com/sites/amelis.hwc.fr/themes/amelis_theme/logo.png",
        "description": "Amelis propose des services d’aide à domicile aux personnes âgées ou dépendantes pour préserver leur autonomie et leur qualité de vie.",
        "address":{"@type": "PostalAddress",
        "streetAddress":"19 rue du dôme",
        "addressLocality":"Boulogne-Billancourt",
        "postalCode":"92100",
        "addressCountry":"France"
        },
        "sameAs":[
        "https://www.facebook.com/AmelisServices",
        "https://twitter.com/amelisservices",
        "https://www.youtube.com/channel/UCOanvcTvuC4VeyMP3kQn3IA",
        "https://www.linkedin.com/company/amelis-services"
        ],
        "contactPoint":[
        {
        "@type":"ContactPoint",
        "contactType":"Customer Service",
        "url":"https://www.amelis-services.com/contact",
        "contactOption" : "TollFree",
        "telephone":"+33 01 72 68 02 01"
        },
        {
        "@type":"ContactPoint",
        "contactType":"Sales",
        "url":"https://www.amelis-services.com/demander-un-devis-gratuit/",
        "contactOption" : "TollFree",
        "telephone":"+33 01 72 68 02 01"
        }
        ]
        }
        </script>';
    
    echo $schema;
}