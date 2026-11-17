<?php
/**
 * Title: Hero
 * Slug: carvalho/hero
 * Categories: carvalho
 *
 * @package Carvalho
 */

?>
<!-- wp:group {"tagName":"section","align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"default"}} -->
<section class="wp-block-group alignwide" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:heading {"level":1,"className":"carvalho-headline","fontSize":"hero"} -->
<h1 class="wp-block-heading carvalho-headline has-hero-font-size"><?php esc_html_e('I lead engineering at 42WP. I build WordPress for large media companies.', 'carvalho'); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"carvalho-measure","textColor":"muted","fontSize":"medium"} -->
<p class="carvalho-measure has-muted-color has-text-color has-medium-font-size"><?php esc_html_e('As Head of Engineering, I’m responsible for architecture, migrations and teams on WordPress VIP projects. I’m also a teacher and a speaker.', 'carvalho'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30","margin":{"top":"var:preset|spacing|40"}}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--40)"><!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url(CARVALHO_LINKEDIN_URL); ?>"><?php esc_html_e('Invite me to speak', 'carvalho'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:paragraph -->
<p><a href="<?php echo esc_url(CARVALHO_LINKEDIN_URL); ?>"><?php esc_html_e('Follow me on LinkedIn', 'carvalho'); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="<?php echo esc_url(home_url('/links/')); ?>"><?php esc_html_e('See all links', 'carvalho'); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
