<?php
/**
 * Title: Header
 * Slug: carvalho/header
 * Categories: carvalho
 * Block Types: core/template-part/header
 * Inserter: no
 *
 * @package Carvalho
 */

$carvalho_menu = array(
    __('About', 'carvalho') => home_url('/'),
    __('Talks', 'carvalho') => home_url('/#palestras'),
    __('Blog', 'carvalho')  => home_url('/blog/'),
    __('Links', 'carvalho') => home_url('/links/'),
);
?>
<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignwide" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30)"><!-- wp:site-title {"level":0} /-->

<!-- wp:navigation {"overlayMenu":"never","layout":{"type":"flex","justifyContent":"left"}} -->
<?php foreach ($carvalho_menu as $carvalho_label => $carvalho_url) : ?>
<!-- wp:navigation-link {"label":"<?php echo esc_attr($carvalho_label); ?>","url":"<?php echo esc_url($carvalho_url); ?>","kind":"custom"} /-->
<?php endforeach; ?>
<!-- /wp:navigation --></div>
<!-- /wp:group -->
