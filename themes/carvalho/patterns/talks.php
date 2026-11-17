<?php
/**
 * Title: Talks
 * Slug: carvalho/talks
 * Categories: carvalho
 *
 * @package Carvalho
 */

$carvalho_talks = array(
    array(
        'title' => __('The myths and truths about headless WordPress', 'carvalho'),
        'event' => __('WordCamp Brasil, 2025', 'carvalho'),
        'about' => __('What CNN Brasil gained and what it faced when it moved its news site to headless. When to migrate and when not to.', 'carvalho'),
        'photo' => 'wordcamp-brasil-2025.jpg',
        'alt' => __('João Carvalho on stage at WordCamp Brasil 2025', 'carvalho'),
        'video' => 'https://www.youtube.com/watch?v=nVHpRDY_9qE',
        'recap' => home_url('/blog/mitos-e-verdades-resumo-da-minha-palestra-sobre-wordpress-headless/'),
    ),
    array(
        'title' => __('Breaking News: CNN’s Rise to Industry Leader in Brazil', 'carvalho'),
        'event' => __('WordCamp US, 2024, with Brian Alvey', 'carvalho'),
        'about' => __('The architecture and team culture decisions that made CNN Brasil one of the three largest news sites in Brazil.', 'carvalho'),
        'photo' => 'wordcamp-us-2024.jpg',
        'alt' => __('João Carvalho on stage at WordCamp US 2024, in Portland', 'carvalho'),
        'video' => 'https://www.youtube.com/live/EL9x9aw54as?t=11475s',
        'recap' => home_url('/blog/cnn-brasil-no-wordcamp-us-2024/'),
    ),
);
?>
<!-- wp:group {"tagName":"section","anchor":"palestras","align":"wide","className":"carvalho-section","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"default"}} -->
<section id="palestras" class="wp-block-group alignwide carvalho-section" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"250px"} -->
<div class="wp-block-column" style="flex-basis:250px"><!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e('Talks', 'carvalho'); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|40","left":"var:preset|spacing|40"}}}} -->
<div class="wp-block-columns"><?php foreach ($carvalho_talks as $carvalho_talk) : ?><!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"aspectRatio":"16/9","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="<?php echo esc_url(get_theme_file_uri('assets/images/talks/' . $carvalho_talk['photo'])); ?>" alt="<?php echo esc_attr($carvalho_talk['alt']); ?>" width="1280" height="720" loading="lazy" style="aspect-ratio:16/9;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php echo esc_html($carvalho_talk['title']); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color"><?php echo esc_html($carvalho_talk['event']); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php echo esc_html($carvalho_talk['about']); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group"><!-- wp:paragraph -->
<p><a href="<?php echo esc_url($carvalho_talk['video']); ?>"><?php esc_html_e('Watch the talk', 'carvalho'); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="<?php echo esc_url($carvalho_talk['recap']); ?>"><?php esc_html_e('Read the recap', 'carvalho'); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --><?php endforeach; ?></div>
<!-- /wp:columns --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
