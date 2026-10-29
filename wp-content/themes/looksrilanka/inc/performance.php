<?php
/**
 * Front-end performance tweaks. None of them change what a page shows:
 *  1. Form assets (Contact Form 7, country phone field, jQuery) load only on
 *     pages that actually render a form, instead of on every page.
 *  2. Photos below the fold are lazy-loaded unless a template marks them as
 *     eager / high priority (heroes, logo).
 *  3. Unused WordPress head extras (emoji script, oEmbed/RSD links …) are removed.
 */

/* 1. Form assets only where a form is rendered -------------------------------- */

// Stop Contact Form 7 from loading its files on every page.
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );

// Country phone field plugin handles (they also pull in jQuery).
function ls_form_asset_handles() {
    return array(
        'styles'  => array( 'nbcpf-intlTelInput-style', 'nbcpf-countryFlag-style' ),
        'scripts' => array( 'nbcpf-intlTelInput-script', 'nbcpf-countryFlag-script' ),
    );
}

add_action( 'wp_enqueue_scripts', function () {
    $handles = ls_form_asset_handles();
    foreach ( $handles['styles'] as $handle ) {
        wp_dequeue_style( $handle );
    }
    foreach ( $handles['scripts'] as $handle ) {
        wp_dequeue_script( $handle );
    }
}, 100 );

/**
 * Loads the form files once, the first time a form shortcode is rendered.
 * Scripts print in the footer as before; styles print just after the form.
 */
function ls_enqueue_form_assets() {
    static $done = false;
    if ( $done ) {
        return;
    }
    $done = true;

    if ( function_exists( 'wpcf7_enqueue_scripts' ) ) {
        wpcf7_enqueue_scripts();
    }
    if ( function_exists( 'wpcf7_enqueue_styles' ) ) {
        wpcf7_enqueue_styles();
    }
    $handles = ls_form_asset_handles();
    foreach ( $handles['styles'] as $handle ) {
        if ( wp_style_is( $handle, 'registered' ) ) {
            wp_enqueue_style( $handle );
        }
    }
    foreach ( $handles['scripts'] as $handle ) {
        if ( wp_script_is( $handle, 'registered' ) ) {
            wp_enqueue_script( $handle );
        }
    }
}

add_filter( 'do_shortcode_tag', function ( $output, $tag ) {
    if ( in_array( $tag, array( 'contact-form-7', 'contact-form' ), true ) ) {
        ls_enqueue_form_assets();
    }
    return $output;
}, 10, 2 );

/* 2. Lazy-load photos below the fold ----------------------------------------- */

add_filter( 'wp_get_attachment_image_attributes', function ( $attr ) {
    if ( is_admin() || wp_doing_ajax() || is_feed() ) {
        return $attr;
    }
    // Leave alone images a template marked (eager hero/logo) or WordPress picked as the main image.
    if ( ! empty( $attr['loading'] ) || ( isset( $attr['fetchpriority'] ) && 'high' === $attr['fetchpriority'] ) ) {
        return $attr;
    }
    $attr['loading'] = 'lazy';
    if ( empty( $attr['decoding'] ) ) {
        $attr['decoding'] = 'async';
    }
    return $attr;
}, 20 );

/* 3. Remove unused head extras ----------------------------------------------- */

add_action( 'init', function () {
    // Emoji detection script and styles (browsers show emoji natively).
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'emoji_svg_url', '__return_false' );

    // Discovery links nobody visiting the site needs.
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'wp_generator' );
    remove_action( 'wp_head', 'wp_shortlink_wp_head' );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
    remove_action( 'wp_head', 'rest_output_link_wp_head' );
} );

// No DNS prefetch for the emoji CDN.
add_filter( 'wp_resource_hints', function ( $urls, $relation ) {
    if ( 'dns-prefetch' === $relation ) {
        $urls = array_filter( $urls, function ( $url ) {
            return ! ( is_string( $url ) && false !== strpos( $url, 's.w.org' ) );
        } );
    }
    return $urls;
}, 10, 2 );
