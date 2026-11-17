<?php
/**
 * Configuração inicial do site: tema, opções, páginas, posts e links permanentes.
 * Pode rodar mais de uma vez: o que já existe não é recriado.
 *
 * No servidor: wp eval-file setup.php
 */

/**
 * Devolve o ID do conteúdo com o slug informado e o cria se ainda não existir.
 * Se já existir, atualiza os campos informados, menos o conteúdo, que pode ter sido editado no painel.
 */
function carvalho_setup_content(string $type, string $slug, array $fields): int
{
    $existing = get_page_by_path($slug, OBJECT, $type);
    if ($existing) {
        $changes = array_diff_key($fields, array('post_content' => true));
        wp_update_post(array_merge($changes, array('ID' => $existing->ID)));
        return $existing->ID;
    }

    return wp_insert_post(array_merge($fields, array(
        'post_type' => $type,
        'post_status' => 'publish',
        'post_name' => $slug,
    )));
}

/**
 * Desativa as cópias de plugins que o primeiro deploy renomeou para *.pre-symlink.*.
 * As cópias do repositório são ativadas depois, em outro processo, para que as duas não carreguem juntas.
 */
function carvalho_setup_deactivate_replaced_plugins(): void
{
    require_once ABSPATH . 'wp-admin/includes/plugin.php';

    $replaced = array_filter(
        (array) get_option('active_plugins', array()),
        fn(string $plugin): bool => str_contains(dirname($plugin), '.pre-symlink.')
    );
    deactivate_plugins($replaced);
}

/**
 * Troca o slug de um post e atualiza os links internos que apontam para ele.
 * O WordPress guarda o slug antigo e redireciona o endereço antigo para o novo.
 */
function carvalho_setup_rename_post(string $old_slug, string $new_slug): void
{
    global $wpdb;

    $post = get_page_by_path($old_slug, OBJECT, 'post');
    if (! $post) {
        return;
    }

    wp_update_post(array('ID' => $post->ID, 'post_name' => $new_slug));
    $wpdb->query($wpdb->prepare(
        "UPDATE {$wpdb->posts} SET post_content = REPLACE(post_content, %s, %s)",
        "/blog/{$old_slug}/",
        "/blog/{$new_slug}/"
    ));
    wp_cache_flush();
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

carvalho_setup_deactivate_replaced_plugins();
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

carvalho_setup_rename_post(
    'myths-and-truths-a-recap-of-my-talk-on-headless-wordpress',
    'mitos-e-verdades-resumo-da-minha-palestra-sobre-wordpress-headless'
);

$carvalho_posts = array(
    'mitos-e-verdades-resumo-da-minha-palestra-sobre-wordpress-headless' => array(
        'post_title' => 'Mitos e verdades: resumo da minha palestra sobre WordPress headless',
        'post_date' => '2025-11-29 17:45:00',
    ),
    'cnn-brasil-no-wordcamp-us-2024' => array(
        'post_title' => 'A CNN Brasil no WordCamp US 2024: resumo da palestra',
        'post_date' => '2024-09-20 09:00:00',
    ),
);
foreach ($carvalho_posts as $carvalho_slug => $carvalho_fields) {
    $carvalho_fields['post_date_gmt'] = get_gmt_from_date($carvalho_fields['post_date']);
    $carvalho_fields['post_content'] = wp_slash(file_get_contents(__DIR__ . "/posts/{$carvalho_slug}.html"));
    carvalho_setup_content('post', $carvalho_slug, $carvalho_fields);
}

carvalho_setup_trash_sample_post();

global $wp_rewrite;
$wp_rewrite->set_permalink_structure('/blog/%postname%/');
$wp_rewrite->flush_rules();
