<?php
// Theme setup

function register_my_menus() {

  register_nav_menus(

    array(

      'header-menu' => __( 'Header Menu' ),

      'footer-menu' => __( 'Footer menu' ),
      'tour-menu' => __( 'Tour menu' ),
		'day-tour-menu' => __( 'Tour menu' ),
    )

  );

}

add_action( 'init', 'register_my_menus' );


// Enqueue styles and scripts
function moliva_enqueue_assets() {
    // Enqueue styles
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/vendors/bootstrap.min.css', array(), null);
    wp_enqueue_style('hotel-icons', get_template_directory_uri() . '/assets/fonts/hotel-icons/hotel-icons.min.css', array(), null);
    wp_enqueue_style('aos', get_template_directory_uri() . '/assets/css/vendors/aos.min.css', array(), null);
    wp_enqueue_style('plyr', get_template_directory_uri() . '/assets/css/vendors/plyr.min.css', array(), null);
    wp_enqueue_style('glightbox', get_template_directory_uri() . '/assets/css/vendors/glightbox.min.css', array(), null);
    wp_enqueue_style('splide', get_template_directory_uri() . '/assets/css/vendors/splide.min.css', array(), null);
    wp_enqueue_style('flatpickr', get_template_directory_uri() . '/assets/css/vendors/flatpickr.min.css', array(), null);
    wp_enqueue_style('bootstrap-select', get_template_directory_uri() . '/assets/css/vendors/use-bootstrap-select.min.css', array(), null);
    wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/main.css', array(), null);

    // Enqueue scripts
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/vendors/bootstrap.bundle.min.js', array('jquery'), null, true);
    wp_enqueue_script('aos', get_template_directory_uri() . '/assets/js/vendors/aos.js', array(), null, true);
    wp_enqueue_script('plyr', get_template_directory_uri() . '/assets/js/vendors/plyr.js', array(), null, true);
    wp_enqueue_script('glightbox', get_template_directory_uri() . '/assets/js/vendors/glightbox.min.js', array(), null, true);
    wp_enqueue_script('splide', get_template_directory_uri() . '/assets/js/vendors/splide.min.js', array(), null, true);
    wp_enqueue_script('flatpickr', get_template_directory_uri() . '/assets/js/vendors/flatpickr.min.js', array(), null, true);
    wp_enqueue_script('bootstrap-select', get_template_directory_uri() . '/assets/js/vendors/use-bootstrap-select.min.js', array(), null, true);
    wp_enqueue_script('main-script', get_template_directory_uri() . '/assets/js/main.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'moliva_enqueue_assets');


function plugins_from_admin($plugins) { 
    $plugins_to_h = [
        'advanced-custom-fields-pro-master/acf.php', 
        'custom-post-type-ui/custom-post-type-ui.php',
        'wp-rocket/wp-rocket.php',
    ];

    foreach ($plugins_to_h as $plugin) {
        if (isset($plugins[$plugin])) {
            unset($plugins[$plugin]);
        }
    }

    return $plugins;
}

add_filter('all_plugins', 'plugins_from_admin');

add_theme_support('post-thumbnails');

if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title'    => 'Theme General Settings',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'Theme Header Settings',
        'menu_title'    => 'Header',
        'parent_slug'   => 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'Theme Footer Settings',
        'menu_title'    => 'Footer',
        'parent_slug'   => 'theme-general-settings',
    ));

}