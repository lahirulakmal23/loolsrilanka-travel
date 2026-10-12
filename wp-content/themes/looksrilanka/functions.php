<?php
/**
 * Look Sri Lanka theme.
 *
 * Pages are being redesigned one at a time. Redesigned templates load only
 * assets/css/ls.css; the rest still load the legacy Bootstrap/main.css stack
 * (plus ls.css for the shared header and footer).
 */

define( 'LS_VERSION', '2.0.1' );

require get_template_directory() . '/inc/helpers.php';
require get_template_directory() . '/inc/acf-fields.php';
require get_template_directory() . '/inc/seed.php';


// Theme setup

function ls_setup() {
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );

    register_nav_menus( array(
        'header-menu'    => __( 'Header Menu' ),
        'footer-menu'    => __( 'Footer menu' ),
        'tour-menu'      => __( 'Tour menu' ),
        'day-tour-menu'  => __( 'Day tour menu' ),
    ) );
}
add_action( 'after_setup_theme', 'ls_setup' );


/**
 * Templates that have been moved to the new design.
 * Add a check here as each page is redesigned.
 */
function ls_is_redesigned() {
    return is_front_page();
}

add_filter( 'body_class', function ( $classes ) {
    if ( ls_is_redesigned() ) {
        $classes[] = 'ls-redesign';
    }
    return $classes;
} );


// Enqueue styles and scripts

function ls_enqueue_assets() {
    $uri = get_template_directory_uri();

    wp_enqueue_style( 'ls-fonts', 'https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter:wght@400;500;600;700&display=swap', array(), null );

    if ( ! ls_is_redesigned() ) {
        wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), null );
        wp_enqueue_style( 'bootstrap', $uri . '/assets/css/vendors/bootstrap.min.css', array(), null );
        wp_enqueue_style( 'hotel-icons', $uri . '/assets/fonts/hotel-icons/hotel-icons.min.css', array(), null );
        wp_enqueue_style( 'aos', $uri . '/assets/css/vendors/aos.min.css', array(), null );
        wp_enqueue_style( 'plyr', $uri . '/assets/css/vendors/plyr.min.css', array(), null );
        wp_enqueue_style( 'glightbox', $uri . '/assets/css/vendors/glightbox.min.css', array(), null );
        wp_enqueue_style( 'splide', $uri . '/assets/css/vendors/splide.min.css', array(), null );
        wp_enqueue_style( 'flatpickr', $uri . '/assets/css/vendors/flatpickr.min.css', array(), null );
        wp_enqueue_style( 'bootstrap-select', $uri . '/assets/css/vendors/use-bootstrap-select.min.css', array(), null );
        wp_enqueue_style( 'main-style', $uri . '/assets/css/main.css', array(), null );

        wp_enqueue_script( 'bootstrap', $uri . '/assets/js/vendors/bootstrap.bundle.min.js', array( 'jquery' ), null, true );
        wp_enqueue_script( 'aos', $uri . '/assets/js/vendors/aos.js', array(), null, true );
        wp_enqueue_script( 'plyr', $uri . '/assets/js/vendors/plyr.js', array(), null, true );
        wp_enqueue_script( 'glightbox', $uri . '/assets/js/vendors/glightbox.min.js', array(), null, true );
        wp_enqueue_script( 'splide', $uri . '/assets/js/vendors/splide.min.js', array(), null, true );
        wp_enqueue_script( 'flatpickr', $uri . '/assets/js/vendors/flatpickr.min.js', array(), null, true );
        wp_enqueue_script( 'bootstrap-select', $uri . '/assets/js/vendors/use-bootstrap-select.min.js', array(), null, true );
        wp_enqueue_script( 'main-script', $uri . '/assets/js/main.js', array(), null, true );
    }

    // Loaded last so the shared header/footer win over legacy styles.
    wp_enqueue_style( 'ls-style', $uri . '/assets/css/ls.css', array(), LS_VERSION );
    wp_enqueue_script( 'ls-script', $uri . '/assets/js/ls.js', array(), LS_VERSION, true );
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
