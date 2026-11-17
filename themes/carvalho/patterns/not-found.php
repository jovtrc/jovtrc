<?php
/**
 * Title: Page not found
 * Slug: carvalho/not-found
 * Categories: carvalho
 * Inserter: no
 *
 * @package Carvalho
 */

?>
<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading"><?php esc_html_e('Page not found', 'carvalho'); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"medium"} -->
<p class="has-muted-color has-text-color has-medium-font-size"><?php esc_html_e('The address may have changed.', 'carvalho'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Go to the home page', 'carvalho'); ?></a></p>
<!-- /wp:paragraph -->
