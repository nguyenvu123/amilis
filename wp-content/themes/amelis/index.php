<?php get_header(); ?>

<?php if (is_404()) :?>

<section style="min-height: 500px; margin-top: 200px;">
    <div class="container">
        <div class="404-message">
            <h1>Page non trouvée</h1>
            <p>Nous n'arrivons pas à trouver la page que vous recherchez. Code d'erreur: 404</p>
        </div>
        <div class="h-space-20"></div>
        <a href="/" class="btn btn-primary">Retour à la page d'accueil</a>
    </div>
</section>

<?php endif;?>

<?php get_footer(); ?>