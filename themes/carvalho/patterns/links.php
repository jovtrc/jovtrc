<?php
/**
 * Title: Links
 * Slug: carvalho/links
 * Categories: carvalho
 *
 * @package Carvalho
 */

$carvalho_links = array(
    array(
        'name'  => 'LinkedIn',
        'about' => __('Professional profile and contact', 'carvalho'),
        'url'   => CARVALHO_LINKEDIN_URL,
    ),
    array(
        'name'  => 'GitHub',
        'about' => __('Open source', 'carvalho'),
        'url'   => 'https://github.com/jovtrc',
    ),
    array(
        'name'  => __('Blog', 'carvalho'),
        'about' => __('Writing about WordPress and engineering', 'carvalho'),
        'url'   => home_url('/blog/'),
    ),
    array(
        'name'  => 'Tinta',
        'about' => __('A private wiki for teams, inside WordPress.', 'carvalho'),
        'url'   => 'https://tinta.carvalho.cc/',
    ),
    array(
        'name'  => 'restpress',
        'about' => __('A plugin that generates the WordPress REST API documentation.', 'carvalho'),
        'url'   => 'https://restpress.org/',
    ),
);
?>
<!-- wp:group {"tagName":"main","className":"carvalho-links","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|30"}}},"layout":{"type":"constrained","contentSize":"30rem"}} -->
<main class="wp-block-group carvalho-links" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--30)"><!-- wp:heading {"level":1,"fontSize":"x-large"} -->
<h1 class="wp-block-heading has-x-large-font-size"><?php echo esc_html(get_bloginfo('name')); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color"><?php
/* translators: %s: link to 42WP. */
printf(esc_html__('Co-founder and Head of Engineering at %s. Teacher and speaker.', 'carvalho'), '<a href="' . esc_url(CARVALHO_42WP_URL) . '">42WP</a>');
?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}}}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--30)"><!-- wp:button {"width":100} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url(CARVALHO_LINKEDIN_URL); ?>"><?php esc_html_e('Invite me to speak', 'carvalho'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:group {"style":{"spacing":{"blockGap":"0","margin":{"top":"var:preset|spacing|30"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--30)"><?php foreach ($carvalho_links as $carvalho_link) : ?><!-- wp:group {"className":"carvalho-link","style":{"spacing":{"blockGap":"0.125rem"}},"layout":{"type":"default"}} -->
<div class="wp-block-group carvalho-link"><!-- wp:paragraph {"fontSize":"large","fontFamily":"display"} -->
<p class="has-display-font-family has-large-font-size"><a href="<?php echo esc_url($carvalho_link['url']); ?>"><?php echo esc_html($carvalho_link['name']); ?></a></p>
<!-- /wp:paragraph --><?php if ($carvalho_link['about']) : ?>

<!-- wp:paragraph {"textColor":"muted","fontSize":"small"} -->
<p class="has-muted-color has-text-color has-small-font-size"><?php echo esc_html($carvalho_link['about']); ?></p>
<!-- /wp:paragraph --><?php endif; ?></div>
<!-- /wp:group --><?php endforeach; ?></div>
<!-- /wp:group -->

<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}},"textColor":"muted","fontSize":"small"} -->
<p class="has-muted-color has-text-color has-small-font-size" style="margin-top:var(--wp--preset--spacing--40)"><a href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html(wp_parse_url(home_url(), PHP_URL_HOST)); ?></a></p>
<!-- /wp:paragraph --></main>
<!-- /wp:group -->
