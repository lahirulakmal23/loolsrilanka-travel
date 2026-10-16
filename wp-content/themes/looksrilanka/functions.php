<?php
/**
 * Look Sri Lanka theme.
 *
 * Every template uses the redesign: assets/css/ls.css and assets/js/ls.js.
 * Content is edited through ACF fields (inc/acf-fields*.php).
 */

define( 'LS_VERSION', '3.0.1' );

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
 * Day tours (post type and category registered by Custom Post Type UI).
 * The listing is the "Day Tours" page (page-day-tours.php), so the post type
 * archive and category archives send visitors there.
 */
function ls_day_tours_url() {
    $page = get_page_by_path( 'day-tours' );
    return $page ? get_permalink( $page ) : '';
}

add_action( 'template_redirect', function () {
    if ( ( is_post_type_archive( 'day-tour' ) || is_tax( 'day-tour-category' ) ) && ( $url = ls_day_tours_url() ) ) {
        wp_safe_redirect( $url, 301 );
        exit;
    }
} );

// News (registered by Custom Post Type UI): enable the Excerpt box, which the blog cards use as their summary.
add_action( 'init', function () {
    add_post_type_support( 'news', 'excerpt' );
}, 20 );


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
    // Scroll-reveal animations (AOS); ls.js decides which elements get them.
    wp_enqueue_style( 'aos', $uri . '/assets/css/vendors/aos.min.css', array(), null );
    wp_enqueue_script( 'aos', $uri . '/assets/js/vendors/aos.js', array(), null, true );

    // Photo lightbox on pages with galleries. Loaded before ls.js, which starts it.
    $script_deps = array( 'aos' );
    if ( is_singular( array( 'tour', 'day-tour', 'destination', 'escapades' ) ) || is_page_template( 'page-gallery.php' ) ) {
        wp_enqueue_style( 'glightbox', $uri . '/assets/css/vendors/glightbox.min.css', array(), null );
        wp_enqueue_script( 'glightbox', $uri . '/assets/js/vendors/glightbox.min.js', array(), null, true );
        $script_deps[] = 'glightbox';
    }

    wp_enqueue_style( 'ls-style', $uri . '/assets/css/ls.css', array( 'aos' ), LS_VERSION );
    wp_enqueue_script( 'ls-script', $uri . '/assets/js/ls.js', $script_deps, LS_VERSION, true );
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
