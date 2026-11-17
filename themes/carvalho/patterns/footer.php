<?php
/**
 * Title: Footer
 * Slug: carvalho/footer
 * Categories: carvalho
 * Block Types: core/template-part/footer
 * Inserter: no
 *
 * @package Carvalho
 */

$carvalho_menu = array(
    'LinkedIn' => '#',
    'GitHub'   => 'https://github.com/jovtrc',
    'YouTube'  => '#',
    'RSS'      => get_bloginfo('rss2_url'),
);
?>
<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|40"}}},"textColor":"muted","fontSize":"small","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignwide has-muted-color has-text-color has-small-font-size" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--40)"><!-- wp:paragraph -->
<p><?php echo esc_html(get_bloginfo('name') . ', ' . gmdate('Y')); ?></p>
<!-- /wp:paragraph -->

<!-- wp:navigation {"overlayMenu":"never","fontSize":"small","layout":{"type":"flex","justifyContent":"left"}} -->
<?php foreach ($carvalho_menu as $carvalho_label => $carvalho_url) : ?>
<!-- wp:navigation-link {"label":"<?php echo esc_attr($carvalho_label); ?>","url":"<?php echo esc_url($carvalho_url); ?>","kind":"custom"} /-->
<?php endforeach; ?>
<!-- /wp:navigation --></div>
<!-- /wp:group -->
