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

/* 4. Smaller WebP copies, generated offline or when media is uploaded -------- */

/** Create a sidecar without changing the original file or attachment metadata. */
function ls_generate_webp_copy( $file ) {
    if ( ! is_file( $file ) || ! preg_match( '/\.(?:jpe?g|png)$/i', $file ) || filesize( $file ) < 12288 ) {
        return false;
    }
    $target = $file . '.webp';
    if ( is_file( $target ) && filemtime( $target ) >= filemtime( $file ) ) {
        return $target;
    }
    $dimensions = wp_getimagesize( $file );
    // Huge camera originals stay untouched; optimize their display-size copies.
    if ( ! $dimensions || max( $dimensions[0], $dimensions[1] ) > 2560 ) {
        return false;
    }
    $editor = wp_get_image_editor( $file );
    if ( is_wp_error( $editor ) || is_wp_error( $editor->set_quality( 80 ) ) ) {
        return false;
    }
    $saved = $editor->save( $target, 'image/webp' );
    if ( is_wp_error( $saved ) ) {
        return false;
    }
    if ( filesize( $saved['path'] ) >= filesize( $file ) ) {
        wp_delete_file( $saved['path'] );
        return false;
    }
    return $saved['path'];
}

/** Use only existing, smaller copies. No conversion runs during page requests. */
function ls_webp_image_url( $url ) {
    static $urls = array();
    if ( isset( $urls[ $url ] ) ) {
        return $urls[ $url ];
    }
    $urls[ $url ] = $url;
    $uploads = wp_get_upload_dir();
    $base = $uploads['baseurl'] . '/';
    if ( 0 !== strpos( $url, $base ) || ! preg_match( '/\.(?:jpe?g|png)$/i', $url ) ) {
        return $url;
    }
    $relative = rawurldecode( substr( $url, strlen( $base ) ) );
    if ( false !== strpos( $relative, '..' ) || false !== strpos( $relative, '\\' ) ) {
        return $url;
    }
    $file = trailingslashit( $uploads['basedir'] ) . $relative;
    $webp = $file . '.webp';
    if ( is_file( $file ) && is_file( $webp ) && filemtime( $webp ) >= filemtime( $file ) && filesize( $webp ) < filesize( $file ) ) {
        $urls[ $url ] = $url . '.webp';
    }
    return $urls[ $url ];
}

add_filter( 'wp_get_attachment_image_attributes', function ( $attr ) {
    if ( ! is_admin() && ! is_feed() && ! empty( $attr['src'] ) ) {
        $attr['src'] = ls_webp_image_url( $attr['src'] );
    }
    return $attr;
}, 30 );

add_filter( 'wp_calculate_image_srcset', function ( $sources ) {
    if ( ! is_admin() && ! is_feed() ) {
        foreach ( $sources as &$source ) {
            $source['url'] = ls_webp_image_url( $source['url'] );
        }
        unset( $source );
    }
    return $sources;
} );

// Keep future uploads optimized without requiring another bulk run.
add_filter( 'wp_generate_attachment_metadata', function ( $metadata, $attachment_id ) {
    if ( ! wp_image_editor_supports( array( 'mime_type' => 'image/webp' ) ) ) {
        return $metadata;
    }
    $file = get_attached_file( $attachment_id );
    if ( $file ) {
        ls_generate_webp_copy( $file );
        foreach ( $metadata['sizes'] ?? array() as $size ) {
            ls_generate_webp_copy( dirname( $file ) . '/' . $size['file'] );
        }
    }
    return $metadata;
}, 20, 2 );
