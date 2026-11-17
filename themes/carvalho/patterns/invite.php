<?php
/**
 * Title: Speaking invitations
 * Slug: carvalho/invite
 * Categories: carvalho
 *
 * @package Carvalho
 */

?>
<!-- wp:group {"tagName":"section","align":"full","className":"carvalho-invite","backgroundColor":"contrast","textColor":"base","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull carvalho-invite has-base-color has-contrast-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:group {"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide"><!-- wp:heading {"fontSize":"xx-large"} -->
<h2 class="wp-block-heading has-xx-large-font-size"><?php esc_html_e('I accept speaking invitations.', 'carvalho'); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"carvalho-measure","textColor":"muted-inverse","fontSize":"medium"} -->
<p class="carvalho-measure has-muted-inverse-color has-text-color has-medium-font-size"><?php esc_html_e('I speak about WordPress at scale, headless and engineering for media companies, in Portuguese and in English. To invite me, write to me on LinkedIn.', 'carvalho'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}}}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--30)"><!-- wp:button {"backgroundColor":"base","textColor":"contrast"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-contrast-color has-base-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url(CARVALHO_LINKEDIN_URL); ?>"><?php esc_html_e('Invite me to speak', 'carvalho'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
