<?php
/**
 * Tema Carvalho — setup, estilos e categoria de patterns.
 *
 * @package Carvalho
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Carrega as traduções e aplica o style.css também no editor.
 */
function carvalho_setup(): void
{
    load_theme_textdomain('carvalho', get_template_directory() . '/languages');
    add_editor_style('style.css');
}
add_action('after_setup_theme', 'carvalho_setup');

/**
 * Devolve uma versão que muda quando o conteúdo do arquivo do tema muda.
 * A CDN guarda arquivos estáticos por dias; com a versão na URL, um arquivo alterado é buscado de novo.
 */
function carvalho_asset_version(string $path): string
{
    return substr(md5_file(get_theme_file_path($path)), 0, 8);
}

/**
 * Devolve a URL de um arquivo do tema com a versão do conteúdo.
 */
function carvalho_asset_url(string $path): string
{
    return add_query_arg('ver', carvalho_asset_version($path), get_theme_file_uri($path));
}

/**
 * Enfileira o style.css no front-end.
 */
function carvalho_enqueue_styles(): void
{
    wp_enqueue_style('carvalho', get_stylesheet_uri(), array(), carvalho_asset_version('style.css'));
}
add_action('wp_enqueue_scripts', 'carvalho_enqueue_styles');

/**
 * Registra a categoria que agrupa os patterns do tema.
 */
function carvalho_register_pattern_category(): void
{
    register_block_pattern_category('carvalho', array('label' => __('João Carvalho', 'carvalho')));
}
add_action('init', 'carvalho_register_pattern_category');
