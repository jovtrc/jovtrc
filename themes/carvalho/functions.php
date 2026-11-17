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
 * Enfileira o style.css no front-end.
 */
function carvalho_enqueue_styles(): void
{
    wp_enqueue_style('carvalho', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));
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
