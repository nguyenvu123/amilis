<?php get_header(); ?>

<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <ul class="list-inline">
                    <li><a href="<?php bloginfo('url');?>"><img src="<?php bloginfo('template_url');?>/assets/images/logo-symbol.svg" width="20" alt="Home"></a></li>
                    <li><a href="#">Emploi</a></li>
                    <li><?php the_title(); ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-auxiliaire">

<section class="section section-hero" style="background-image: url('<?php echo IMG_FOLDER . "auxiliaire-de-vie-bg.jpg"?>')">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center">
                <h1 class="devis-gratuit-title">Emploi auxiliaire de vie sociale</h1>
                <a href="/rejoignez-nous" class="btn btn-primary">Je postule</a>
            </div>
        </div>
    </div>
</section>



<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h2 class="underline">A propos d'Amelis</h2>
                <p>The results of a government-funded study show that very high doses of an avian influenza vaccine, supplied by Sanofi-Aventis, are needed to produce an immune response that should guard against the virus. 54% of the volunteers received two shots of 90 micrograms each, 28 days apart. </p>
            </div>

            <div class="col-sm-6">
                <img src="<?php echo IMG_FOLDER . "sample-image-1.jpg" ?>" alt="" class="img-responsive">
            </div>
        </div>
    </div>
</section>

<section class="section section-auxiliaire-raisons">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center">
                <h2 class="underline centered">5 Raisons <br>pour devenir Auxiliare de vie Amelis</h2>
            </div>
            <div class="col-xs-12">
                <div class="raisons-holder">
                    <div class="raison-item">
                        <div class="icon">
                            <img src="<?php echo IMG_FOLDER . "development.png"?>" alt="Developpment des competences">
                        </div>
                        <div class="raison-item__details">
                            <h3>Developpment des competences</h3>
                            <p>Formation, continue semaine d’integratio, etc...</p>
                        </div>
                    </div>
                    <div class="raison-item">
                        <div class="icon">
                            <img src="<?php echo IMG_FOLDER . "opportunite.png" ?>" alt="Opportunite de cariere">
                        </div>
                        <div class="raison-item__details">
                            <h3>Opportunite de cariere</h3>
                            <p>De nombreuses ADV sont devenues chargees de qualite au sein de nos agences.</p>
                        </div>
                    </div>
                    <div class="raison-item">
                        <div class="icon">
                            <img src="<?php echo IMG_FOLDER . "reconnaissance.png" ?>" alt="Reconnaissance">
                        </div>
                        <div class="raison-item__details">
                            <h3>Reconnaissance</h3>
                            <p>Election de la meilleure ADV de l’annee, recompensee aux Etats Unis.</p>
                        </div>
                    </div>
                    <div class="raison-item">
                        <div class="icon">
                            <img src="<?php echo IMG_FOLDER . "salaire.png" ?>" alt="Salaire copetitif et avantages">
                        </div>
                        <div class="raison-item__details">
                            <h3>Salaire copetitif et avantages</h3>
                            <p>Comite d’Entreprise, mutuelles, 1% logement...</p>
                        </div>
                    </div>
                    <div class="raison-item">
                        <div class="icon">
                            <img src="<?php echo IMG_FOLDER . "bien-etre.png" ?>" alt="Bien-etre au travail">
                        </div>
                        <div class="raison-item__details">
                            <h3>Bien-etre au travail</h3>
                            <p>Des charges de qualite s’assurent regulierement de vos conditions de travail, planiing stable, etc...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section-auxiliaire-personalite">
    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <h2 class="underline">Votre Personalite</h2>
                <p>
                    Vous etes un <span class="color-primary"> professionel passionne</span> par votre metier et desireux d’apporter bien-etre et serenite aux personnes dependantes.
                </p>
                <div class="h-space-10"></div>
                <p> Souriant, attentionne, respecteaux et ponctuel, vous places <span class="color-primary"> l’humain au coeur </span> de vos interventions.</p>
                <p><a href="/rejoignez-nous" class="btn btn-primary">Je postule</a></p>
            </div>
            <div class="col-sm-7">
                <div class="video-holder">
                    <a href="#" class="play">
                        <div class="svg-holder">
                            <?php echo file_get_contents(get_bloginfo('template_url')."/assets/images/play.svg"); ?>
                        </div>
                    </a>
                    <img src="<?php echo IMG_FOLDER . "sample-image-2.jpg" ?>" alt="" class="img-responsive">
                </div>
            </div>
        </div>
    </div>
</section>


</div>



<?php get_footer(); ?>