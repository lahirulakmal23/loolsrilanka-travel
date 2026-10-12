<?php
/**
 * Look Sri Lanka theme.
 *
 * Every template uses the redesign: assets/css/ls.css and assets/js/ls.js.
 * Content is edited through ACF fields (inc/acf-fields*.php).
 */

define( 'LS_VERSION', '2.3.0' );

require get_template_directory() . '/inc/helpers.php';
require get_template_directory() . '/inc/acf-fields.php';
require get_template_directory() . '/inc/acf-fields-pages.php';
require get_template_directory() . '/inc/seed.php';
require get_template_directory() . '/inc/seed-pages.php';


// Theme setup

function ls_setup() {
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );

    register_nav_menus( array(
        'header-menu'    => __( 'Header Menu' ),
        'footer-menu'    => __( 'Footer menu' ),
        'footer-explore' => __( 'Footer: Explore column' ),
        'footer-company' => __( 'Footer: Company column' ),
        'tour-menu'      => __( 'Tour menu' ),
    ) );
}
add_action( 'after_setup_theme', 'ls_setup' );

/**
 * Day Tours are no longer offered. The post type and its category are
 * registered by Custom Post Type UI, so they are removed again here; the
 * existing day tour posts stay in the database untouched.
 */
add_action( 'init', function () {
    if ( post_type_exists( 'day-tour' ) ) {
        unregister_post_type( 'day-tour' );
    }
    if ( taxonomy_exists( 'day-tour-category' ) ) {
        unregister_taxonomy( 'day-tour-category' );
    }
}, 100 );

// Old day tour links go to the itineraries page instead of a 404.
add_action( 'template_redirect', function () {
    $path = trim( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' );
    if ( preg_match( '#^day-tour(-category)?(/|$)#', $path ) ) {
        wp_safe_redirect( get_post_type_archive_link( 'tour' ), 301 );
        exit;
    }
} );

// Hide any menu item that still points to day tours.
add_filter( 'wp_nav_menu_objects', function ( $items ) {
    return array_filter( $items, function ( $item ) {
        return ! preg_match( '#/day-tour(-category)?(/|$)#', (string) wp_parse_url( $item->url, PHP_URL_PATH ) );
    } );
} );


/**
 * Show every destination on one page so the region filter covers them all.
 */
add_action( 'pre_get_posts', function ( $query ) {
    if ( ! is_admin() && $query->is_main_query() && $query->is_post_type_archive( 'destination' ) ) {
        $query->set( 'posts_per_page', -1 );
    }
} );

// Base styles in ls.css are scoped to this class.
add_filter( 'body_class', function ( $classes ) {
    $classes[] = 'ls-redesign';
    return $classes;
} );


// Enqueue styles and scripts

function ls_enqueue_assets() {
    $uri = get_template_directory_uri();

    wp_enqueue_style( 'ls-fonts', 'https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter:wght@400;500;600;700&display=swap', array(), null );
    wp_enqueue_style( 'ls-style', $uri . '/assets/css/ls.css', array(), LS_VERSION );
    wp_enqueue_script( 'ls-script', $uri . '/assets/js/ls.js', array(), LS_VERSION, true );

    // Photo lightbox on pages with galleries.
    if ( is_singular( array( 'tour', 'destination', 'escapades' ) ) ) {
        wp_enqueue_style( 'glightbox', $uri . '/assets/css/vendors/glightbox.min.css', array(), null );
        wp_enqueue_script( 'glightbox', $uri . '/assets/js/vendors/glightbox.min.js', array(), null, true );
    }
}
add_action( 'wp_enqueue_scripts', 'ls_enqueue_assets' );

add_filter( 'wp_resource_hints', function ( $urls, $relation ) {
    if ( 'preconnect' === $relation ) {
        $urls[] = 'https://fonts.googleapis.com';
        $urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
    }
    return $urls;
}, 10, 2 );


function plugins_from_admin( $plugins ) {
    $plugins_to_h = [
        'advanced-custom-fields-pro-master/acf.php',
        'custom-post-type-ui/custom-post-type-ui.php',
        'wp-rocket/wp-rocket.php',
    ];

    foreach ( $plugins_to_h as $plugin ) {
        if ( isset( $plugins[ $plugin ] ) ) {
            unset( $plugins[ $plugin ] );
        }
    }

    return $plugins;
}
add_filter( 'all_plugins', 'plugins_from_admin' );


if ( function_exists( 'acf_add_options_page' ) ) {

    acf_add_options_page( array(
        'page_title' => 'Theme General Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug'  => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
    ) );

    acf_add_options_sub_page( array(
        'page_title'  => 'Theme Header Settings',
        'menu_title'  => 'Header',
        'parent_slug' => 'theme-general-settings',
    ) );

    acf_add_options_sub_page( array(
        'page_title'  => 'Theme Footer Settings',
        'menu_title'  => 'Footer',
        'parent_slug' => 'theme-general-settings',
    ) );
}
