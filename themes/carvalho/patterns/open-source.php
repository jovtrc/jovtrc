<?php
/**
 * Title: Open source
 * Slug: carvalho/open-source
 * Categories: carvalho
 *
 * @package Carvalho
 */

$carvalho_projects = array(
    array(
        'name'  => 'Tinta',
        'about' => __('A private wiki for teams, inside WordPress.', 'carvalho'),
        'label' => 'tinta.carvalho.cc',
        'url'   => 'https://tinta.carvalho.cc/',
    ),
    array(
        'name'  => 'restpress',
        'about' => __('A plugin that generates the WordPress REST API documentation.', 'carvalho'),
        'label' => 'restpress.org',
        'url'   => 'https://restpress.org/',
    ),
);
?>
<!-- wp:group {"tagName":"section","align":"wide","className":"carvalho-section","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"default"}} -->
<section class="wp-block-group alignwide carvalho-section" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"250px"} -->
<div class="wp-block-column" style="flex-basis:250px"><!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e('Open source', 'carvalho'); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|40","left":"var:preset|spacing|40"}}}} -->
<div class="wp-block-columns"><?php foreach ($carvalho_projects as $carvalho_project) : ?><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php echo esc_html($carvalho_project['name']); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color"><?php echo esc_html($carvalho_project['about']); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="<?php echo esc_url($carvalho_project['url']); ?>"><?php echo esc_html($carvalho_project['label']); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --><?php endforeach; ?></div>
<!-- /wp:columns --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
