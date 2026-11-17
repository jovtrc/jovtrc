<?php
/**
 * Configuração inicial do site: tema, opções, páginas, posts e links permanentes.
 * Pode rodar mais de uma vez: o que já existe não é recriado.
 *
 * No servidor: wp eval-file setup.php
 */

/**
 * Devolve o ID do conteúdo com o slug informado e o cria se ainda não existir.
 */
function carvalho_setup_content(string $type, string $slug, array $fields): int
{
    $existing = get_page_by_path($slug, OBJECT, $type);
    if ($existing) {
        return $existing->ID;
    }

    return wp_insert_post(array_merge($fields, array(
        'post_type' => $type,
        'post_status' => 'publish',
        'post_name' => $slug,
    )));
}

/**
 * Envia para a lixeira o post de exemplo criado na instalação do WordPress.
 */
function carvalho_setup_trash_sample_post(): void
{
    foreach (array('hello-world', 'ola-mundo') as $slug) {
        $sample = get_page_by_path($slug, OBJECT, 'post');
        if ($sample) {
            wp_trash_post($sample->ID);
        }
    }
}

switch_theme('carvalho');

update_option('blogname', 'João Carvalho');
update_option('blogdescription', '');
update_option('date_format', 'j \d\e F \d\e Y');

$carvalho_front = carvalho_setup_content('page', 'sobre', array('post_title' => 'Sobre'));
$carvalho_blog = carvalho_setup_content('page', 'blog', array('post_title' => 'Blog'));
carvalho_setup_content('page', 'links', array('post_title' => 'Links'));

update_option('show_on_front', 'page');
update_option('page_on_front', $carvalho_front);
update_option('page_for_posts', $carvalho_blog);

$carvalho_posts = array(
    'myths-and-truths-a-recap-of-my-talk-on-headless-wordpress' => array(
        'post_title' => 'Mitos e verdades: resumo da minha palestra sobre WordPress headless',
        'post_date' => '2025-11-29 17:45:00',
    ),
    'cnn-brasil-no-wordcamp-us-2024' => array(
        'post_title' => 'A CNN Brasil no WordCamp US 2024: resumo da palestra',
        'post_date' => '2026-11-16 09:00:00',
    ),
);
foreach ($carvalho_posts as $carvalho_slug => $carvalho_fields) {
    $carvalho_fields['post_content'] = wp_slash(file_get_contents(__DIR__ . "/posts/{$carvalho_slug}.html"));
    carvalho_setup_content('post', $carvalho_slug, $carvalho_fields);
}

carvalho_setup_trash_sample_post();

global $wp_rewrite;
$wp_rewrite->set_permalink_structure('/blog/%postname%/');
$wp_rewrite->flush_rules();
