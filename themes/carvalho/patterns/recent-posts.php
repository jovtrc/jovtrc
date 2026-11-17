<?php
/**
 * Title: Recent posts
 * Slug: carvalho/recent-posts
 * Categories: carvalho
 *
 * @package Carvalho
 */

?>
<!-- wp:group {"tagName":"section","align":"wide","className":"carvalho-section","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"default"}} -->
<section class="wp-block-group alignwide carvalho-section" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"250px"} -->
<div class="wp-block-column" style="flex-basis:250px"><!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e('Blog', 'carvalho'); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:query {"queryId":1,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false}} -->
<div class="wp-block-query"><!-- wp:post-template {"className":"carvalho-rows"} -->
<!-- wp:group {"className":"carvalho-row","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"top"}} -->
<div class="wp-block-group carvalho-row"><!-- wp:post-title {"level":3,"isLink":true} /-->

<!-- wp:post-date {"textColor":"muted","fontSize":"small"} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color"><?php esc_html_e('No posts yet.', 'carvalho'); ?></p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
