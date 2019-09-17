<?php
/*
Template Name: Search Page
*/
?>

<?php get_header(); ?>

<?php

global $query_string;

wp_parse_str( $query_string, $search_query );
$search = new WP_Query( $search_query );

?>

<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <ul class="list-inline">
                    <li><a href="<?php bloginfo('url');?>"><img src="<?php bloginfo('template_url');?>/assets/images/logo-symbol.svg" width="20" alt="Home"></a></li>
                    <li>Résultats de la recherche</li>
                    <li><?php echo esc_html( get_search_query() ); ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="section-hero">
    <div class="search-details">
        <h2>Vous avez recherché "<?php echo esc_html( get_search_query() ); ?>".</h2>
    </div>
</section>

<div class="container">

<?php if ( $search->have_posts() ) : ?>
	<?php while ( $search->have_posts() ) : ?>
		<?php $search->the_post(); ?>
        <div class="search-result-item">
            <h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
            <p><?php the_excerpt() ?></p>
        </div>

    <?php endwhile ?>
    <?php else : ?>
    <div class="search-result-item">
        <h2>Aucun résultat trouvé</h2>
        <p>S'il vous plaît essayer un autre terme de recherche</p>
    </div>
<?php endif ?>

<?php
    global $wp_query;
    $total_results = $wp_query->found_posts;
?>

</div>


<?php get_footer();?>