<?php
/**
 * Template helpers. All of them degrade gracefully when ACF is inactive
 * or a field is empty, so a missing value never breaks the layout.
 */

function ls_get( $name, $post_id = false ) {
    return function_exists( 'get_field' ) ? get_field( $name, $post_id ) : null;
}

function ls_option( $name ) {
    return ls_get( $name, 'option' );
}

/**
 * Whether an image value (attachment ID, ACF array or URL) points to a file
 * that exists. URLs on other domains can't be checked here and count as OK;
 * the browser-side fallback in ls_fallback_script() catches those.
 */
function ls_image_ok( $image ) {
    if ( empty( $image ) ) {
        return false;
    }
    if ( is_array( $image ) ) {
        $image = $image['ID'] ?? ( $image['url'] ?? '' );
    }
    if ( is_numeric( $image ) ) {
        $file = get_attached_file( (int) $image );
        return $file && file_exists( $file );
    }

    $uploads = wp_get_upload_dir();
    $url     = preg_replace( '#^https?:#', '', (string) $image );
    $base    = preg_replace( '#^https?:#', '', $uploads['baseurl'] );
    if ( 0 === strpos( $url, $base ) ) {
        return file_exists( $uploads['basedir'] . rawurldecode( substr( $url, strlen( $base ) ) ) );
    }
    return '' !== $url;
}

/**
 * Fallback photos (Theme Settings → Site Settings → Fallback photos) that
 * exist on disk, as attachment IDs.
 */
function ls_fallback_ids() {
    static $ids = null;
    if ( null === $ids ) {
        $ids = array_values( array_filter( array_map( 'intval', (array) ls_option( 'ls_fallback_images' ) ), 'ls_image_ok' ) );
    }
    return $ids;
}

/**
 * Picks a fallback photo. The same seed always gives the same photo, so
 * different cards get different photos but a page never "shuffles".
 */
function ls_fallback_id( $seed = '' ) {
    $ids = ls_fallback_ids();
    return $ids ? $ids[ crc32( (string) $seed ) % count( $ids ) ] : 0;
}

/**
 * Outputs an <img> for an ACF image value (ID, array or URL).
 * When the file is missing, a fallback photo is shown instead; pass
 * $fallback = false for logos and portraits, which are then left out.
 */
function ls_image( $image, $size = 'large', $attr = array(), $fallback = true ) {
    if ( ! $fallback ) {
        $attr['data-ls-nofallback'] = '1';
    }
    if ( ! ls_image_ok( $image ) ) {
        $replacement = $fallback ? ls_fallback_id( is_scalar( $image ) ? $image : wp_json_encode( $image ) ) : 0;
        return $replacement ? wp_get_attachment_image( $replacement, $size, false, $attr ) : '';
    }
    if ( is_array( $image ) ) {
        $image = $image['ID'] ?? ( $image['url'] ?? '' );
    }
    if ( is_numeric( $image ) ) {
        return wp_get_attachment_image( (int) $image, $size, false, $attr );
    }

    $attr = wp_parse_args( $attr, array( 'alt' => '', 'loading' => 'lazy' ) );
    $html = '<img src="' . esc_url( $image ) . '"';
    foreach ( $attr as $key => $value ) {
        $html .= ' ' . esc_attr( $key ) . '="' . esc_attr( $value ) . '"';
    }
    return $html . '>';
}

/**
 * Outputs an <a> for an ACF link array. Returns '' when the link is empty.
 */
function ls_link( $link, $class = '', $fallback_title = '' ) {
    if ( empty( $link['url'] ) ) {
        return '';
    }
    $title  = ! empty( $link['title'] ) ? $link['title'] : $fallback_title;
    $target = ! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener"' : '';

    return sprintf(
        '<a class="%s" href="%s"%s>%s</a>',
        esc_attr( $class ),
        esc_url( $link['url'] ),
        $target,
        esc_html( $title )
    );
}

/**
 * Replaces {tours}, {destinations} and {experiences} with live published post counts.
 */
function ls_count_tokens( $text ) {
    if ( false === strpos( (string) $text, '{' ) ) {
        return $text;
    }
    $counts = array(
        '{tours}'        => post_type_exists( 'tour' ) ? (int) wp_count_posts( 'tour' )->publish : 0,
        '{destinations}' => post_type_exists( 'destination' ) ? (int) wp_count_posts( 'destination' )->publish : 0,
        '{experiences}'  => post_type_exists( 'escapades' ) ? (int) wp_count_posts( 'escapades' )->publish : 0,
    );
    return strtr( $text, $counts );
}

function ls_initials( $name ) {
    $initials = '';
    foreach ( preg_split( '/\s+/', trim( wp_strip_all_tags( $name ) ) ) as $word ) {
        if ( '' !== $word && ctype_alpha( $word[0] ) ) {
            $initials .= strtoupper( $word[0] );
        }
        if ( strlen( $initials ) === 2 ) {
            break;
        }
    }
    return $initials;
}

/**
 * Inline SVG icons used by editable lists (the field stores the key).
 */
function ls_icon( $key ) {
    $paths = array(
        'star'    => '<path d="M12 2l2.6 6.2L21 9l-5 4.6L17.5 21 12 17.3 6.5 21 8 13.6 3 9l6.4-.8z"/>',
        'clock'   => '<path d="M4 12a8 8 0 1116 0 8 8 0 01-16 0z"/><path d="M12 8v4l3 2"/>',
        'home'    => '<path d="M3 10l9-7 9 7v9a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>',
        'shield'  => '<path d="M12 3l8 3v6c0 4.5-3.4 8.3-8 9-4.6-.7-8-4.5-8-9V6z"/><path d="M9 12l2 2 4-4"/>',
        'support' => '<path d="M4 13v-1a8 8 0 1116 0v1"/><path d="M4 13h3v5H5a1 1 0 01-1-1zM20 13h-3v5h2a1 1 0 001-1z"/><path d="M17 18c0 1.7-2.2 3-5 3"/>',
        'sliders' => '<path d="M4 6h10M18 6h2M4 12h4M12 12h8M4 18h12M20 18h0"/><circle cx="16" cy="6" r="2"/><circle cx="10" cy="12" r="2"/><circle cx="18" cy="18" r="2"/>',
        'map'     => '<path d="M9 4L3 6v14l6-2 6 2 6-2V4l-6 2z"/><path d="M9 4v14M15 6v14"/>',
        'heart'   => '<path d="M12 20s-7-4.4-7-10a4 4 0 017-2.6A4 4 0 0119 10c0 5.6-7 10-7 10z"/>',
        'tag'     => '<path d="M3 12V4h8l10 10-8 8z"/><circle cx="7.5" cy="7.5" r="1.5"/>',
        'leaf'    => '<path d="M5 19c0-8 5-14 15-14 0 10-6 15-14 15"/><path d="M5 19l7-7"/>',
    );
    $path = isset( $paths[ $key ] ) ? $paths[ $key ] : $paths['star'];

    return '<svg class="ls-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $path . '</svg>';
}

function ls_social_icon( $network ) {
    $paths = array(
        'facebook'    => '<path d="M14 8h3V4h-3a4 4 0 00-4 4v2H8v4h2v8h4v-8h3l1-4h-4V8z"/>',
        'instagram'   => '<rect x="3" y="3" width="18" height="18" rx="5" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="17.5" cy="6.5" r="1.2"/>',
        'tiktok'      => '<path d="M16 3c.4 2.6 2 4.2 4.5 4.4v3.4a8 8 0 01-4.5-1.4V16a6 6 0 11-6-6v3.5a2.5 2.5 0 102.5 2.5V3z"/>',
        'tripadvisor' => '<circle cx="7" cy="13" r="3.2" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="17" cy="13" r="3.2" fill="none" stroke="currentColor" stroke-width="2"/><path d="M2 8h4a10 10 0 0112 0h4l-2 2" fill="none" stroke="currentColor" stroke-width="2"/>',
        'youtube'     => '<path d="M22 8.5a3 3 0 00-2.1-2.1C18 6 12 6 12 6s-6 0-7.9.4A3 3 0 002 8.5 31 31 0 002 12a31 31 0 00.1 3.5 3 3 0 002.1 2.1C6 18 12 18 12 18s6 0 7.9-.4a3 3 0 002.1-2.1A31 31 0 0022 12a31 31 0 000-3.5zM10 15V9l5 3z"/>',
        'linkedin'    => '<path d="M4 9h4v12H4zM6 3a2 2 0 110 4 2 2 0 010-4zM10 9h4v1.7c.6-1 1.9-2 3.8-2 4 0 4.2 2.6 4.2 6V21h-4v-5.5c0-1.4 0-3.1-2-3.1s-2.2 1.4-2.2 3V21H10z"/>',
    );
    $path = isset( $paths[ $network ] ) ? $paths[ $network ] : '';

    return '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">' . $path . '</svg>';
}

/**
 * Fallback for the footer menus when no menu is assigned in Appearance > Menus.
 */
function ls_footer_fallback( $args ) {
    $sets = array(
        'footer-explore' => array(
            '/tour/'        => 'Tour Itineraries',
            '/experiences/' => 'Experiences',
            '/destination/' => 'Destinations',
            '/blog/'        => 'Blog',
        ),
        'footer-company' => array(
            '/about-us/'      => 'About Us',
            '/tailor-made-2/' => 'Tailor-Made Tours',
            '/faq/'           => 'FAQ',
            '/contact-us/'    => 'Contact',
        ),
    );
    $items = isset( $sets[ $args['theme_location'] ] ) ? $sets[ $args['theme_location'] ] : array();

    echo '<ul class="' . esc_attr( $args['menu_class'] ) . '">';
    foreach ( $items as $path => $label ) {
        echo '<li><a href="' . esc_url( home_url( $path ) ) . '">' . esc_html( $label ) . '</a></li>';
    }
    echo '</ul>';
}

/**
 * Best available photo for a tour, destination, experience or article:
 * featured image, then the first gallery photo that exists, then a
 * fallback photo (always the same one for the same post).
 */
function ls_post_image( $post_id, $size = 'large', $attr = array() ) {
    $thumb = get_post_thumbnail_id( $post_id );
    if ( $thumb && ls_image_ok( $thumb ) ) {
        return wp_get_attachment_image( $thumb, $size, false, $attr );
    }

    $gallery = ls_gallery_items( $post_id );
    if ( $gallery ) {
        return ls_image( $gallery[0]['id'] ?: $gallery[0]['url'], $size, $attr );
    }

    $fallback = ls_fallback_id( $post_id );
    return $fallback ? wp_get_attachment_image( $fallback, $size, false, $attr ) : '';
}

/**
 * Hero image value for a post: featured image, first gallery photo, or fallback.
 */
function ls_post_hero_image( $post_id ) {
    $thumb = get_post_thumbnail_id( $post_id );
    if ( $thumb && ls_image_ok( $thumb ) ) {
        return $thumb;
    }
    $gallery = ls_gallery_items( $post_id );
    if ( $gallery ) {
        return $gallery[0]['id'] ?: $gallery[0]['url'];
    }
    return ls_fallback_id( $post_id );
}

/**
 * Gallery images of a post as a flat list of [full, thumb, caption].
 * Handles the three gallery formats used across the post types.
 */
function ls_gallery_items( $post_id ) {
    $items   = array();
    $gallery = ls_get( 'gallery', $post_id );

    if ( ! is_array( $gallery ) ) {
        return $items;
    }
    foreach ( $gallery as $row ) {
        if ( is_array( $row ) && isset( $row['ID'] ) ) {
            $items[] = array( 'id' => $row['ID'], 'url' => $row['url'], 'caption' => $row['caption'] ?? '' );
        } elseif ( is_numeric( $row ) ) {
            $items[] = array( 'id' => (int) $row, 'url' => wp_get_attachment_url( (int) $row ), 'caption' => wp_get_attachment_caption( (int) $row ) );
        } elseif ( is_array( $row ) ) {
            $url     = $row['image_gal'] ?? ( $row['image'] ?? '' );
            $caption = $row['discription_gal'] ?? ( $row['discription'] ?? '' );
            if ( is_array( $url ) ) {
                $url = $url['url'] ?? '';
            }
            if ( $url ) {
                $items[] = array( 'id' => attachment_url_to_postid( $url ), 'url' => $url, 'caption' => $caption );
            }
        }
    }
    // Leave out photos whose file is missing (checked for this site's own uploads).
    return array_values( array_filter( $items, function ( $item ) {
        return ! empty( $item['url'] ) && ls_image_ok( $item['id'] ?: $item['url'] );
    } ) );
}

/**
 * One photo for the photo grid (template-parts/photo-grid.php).
 * ratio = width / height, kept within limits so rows stay even.
 */
function ls_photo_item( $id, $place = '', $category = '', $url = '', $caption = '' ) {
    $meta     = $id ? wp_get_attachment_metadata( $id ) : array();
    $ratio    = ! empty( $meta['width'] ) && ! empty( $meta['height'] ) ? $meta['width'] / $meta['height'] : 1.4;
    $category = trim( (string) $category );
    return array(
        'id'       => (int) $id,
        'url'      => $id ? wp_get_attachment_url( $id ) : $url,
        'place'    => trim( (string) $place ),
        'category' => $category,
        'slug'     => sanitize_title( $category ),
        'caption'  => trim( (string) $caption ),
        'ratio'    => max( .7, min( 1.8, $ratio ) ),
    );
}

/**
 * Photos on the Gallery page ("gl_photos" rows). Defaults to the page with the slug "gallery".
 */
function ls_gallery_page_photos( $page_id = 0 ) {
    if ( ! $page_id ) {
        $page    = get_page_by_path( 'gallery' );
        $page_id = $page ? $page->ID : 0;
    }
    $photos = array();
    foreach ( $page_id ? (array) ls_get( 'gl_photos', $page_id ) : array() as $row ) {
        if ( ! empty( $row['image'] ) && ls_image_ok( $row['image'] ) ) {
            $photos[] = ls_photo_item( (int) $row['image'], $row['place'] ?? '', $row['category'] ?? '' );
        }
    }
    return $photos;
}

// Place name reduced to letters, so "Nuwara Eliya" and "Nuwaraeliya" compare equal.
function ls_place_key( $text ) {
    return preg_replace( '/[^a-z]/', '', strtolower( remove_accents( wp_strip_all_tags( (string) $text ) ) ) );
}

/**
 * Photos for a destination: its own gallery first, then the Gallery page
 * photos whose place matches its name ("Yala" matches "Yala - Tissamaharama").
 * $skip is an attachment ID to leave out (the hero photo).
 */
function ls_destination_photos( $post_id, $skip = 0 ) {
    $name   = ls_place_key( get_the_title( $post_id ) );
    $seen   = $skip ? array( (int) $skip => true ) : array();
    $photos = array();

    foreach ( ls_gallery_items( $post_id ) as $item ) {
        $id = (int) $item['id'];
        if ( $id && isset( $seen[ $id ] ) ) {
            continue;
        }
        $seen[ $id ] = true;
        $photos[]    = ls_photo_item( $id, '', '', $item['url'], $item['caption'] );
    }

    if ( strlen( $name ) >= 3 ) {
        foreach ( ls_gallery_page_photos() as $photo ) {
            $place = ls_place_key( $photo['place'] );
            if ( strlen( $place ) < 3 || isset( $seen[ $photo['id'] ] ) ) {
                continue;
            }
            if ( 0 === strpos( $name, $place ) || 0 === strpos( $place, $name ) ) {
                $seen[ $photo['id'] ] = true;
                $photos[]             = $photo;
            }
        }
    }
    return $photos;
}

/**
 * Route line for a tour. Uses the "Route" field, or builds one from the
 * itinerary day titles ("Negombo - Kandy" → Negombo → Kandy).
 */
function ls_route( $post_id ) {
    $route = trim( (string) ls_get( 'it_route', $post_id ) );
    if ( $route ) {
        return $route;
    }

    $places = array();
    foreach ( (array) ls_get( 'itinerary', $post_id ) as $day ) {
        if ( ! is_array( $day ) || empty( $day['title_copy'] ) ) {
            continue;
        }
        foreach ( preg_split( '/\s+[-–]\s+/', wp_strip_all_tags( $day['title_copy'] ) ) as $place ) {
            $place = trim( preg_replace( '/\(.*?\)/', '', $place ) );
            if ( '' === $place || false !== stripos( $place, 'airport' ) ) {
                continue;
            }
            if ( end( $places ) !== $place ) {
                $places[] = $place;
            }
        }
    }
    return implode( ' → ', array_unique( $places ) );
}

/**
 * Short card text: the summary field, or the start of the description/content.
 */
function ls_summary( $post_id, $field, $words = 24 ) {
    $text = trim( (string) ls_get( $field, $post_id ) );
    if ( ! $text ) {
        $text = (string) ls_get( 'description', $post_id );
    }
    if ( ! $text ) {
        $text = get_post_field( 'post_content', $post_id );
    }
    return wp_trim_words( wp_strip_all_tags( strip_shortcodes( $text ) ), $words );
}

function ls_days_label( $days ) {
    $days = (int) $days;
    if ( $days < 1 ) {
        return '';
    }
    if ( 1 === $days ) {
        return '1 Day';
    }
    return sprintf( '%d Days / %d Nights', $days, $days - 1 );
}

/**
 * Renders a Contact Form 7 shortcode stored in a field.
 */
function ls_form( $shortcode ) {
    $shortcode = trim( (string) $shortcode );
    if ( '' === $shortcode || '[' !== $shortcode[0] ) {
        return '';
    }
    return '<div class="ls-form">' . do_shortcode( $shortcode ) . '</div>';
}

function ls_whatsapp_url() {
    $number = preg_replace( '/\D/', '', (string) ls_option( 'ls_whatsapp' ) );
    if ( ! $number ) {
        return '';
    }
    $message = ls_option( 'ls_whatsapp_message' );
    return 'https://wa.me/' . $number . ( $message ? '?text=' . rawurlencode( $message ) : '' );
}

function ls_whatsapp_svg() {
    return '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a10 10 0 00-8.6 15.1L2 22l5-1.3A10 10 0 1012 2zm5.9 14.2c-.2.6-1.4 1.2-1.9 1.3-.5.1-1.1.1-1.8-.1-.4-.1-1-.3-1.6-.6-2.9-1.3-4.7-4.2-4.9-4.4-.1-.2-1.2-1.6-1.2-3 0-1.4.7-2.1 1-2.4.3-.3.6-.3.8-.3h.6c.2 0 .4 0 .6.5.2.6.7 1.9.8 2 .1.2.1.4 0 .6-.1.2-.2.3-.4.5-.2.2-.4.4-.5.6-.2.2-.4.4-.2.7.2.3 1 1.6 2.1 2.6 1.4 1.3 2.6 1.7 3 1.9.3.2.5.1.7-.1.2-.2.9-1 1.1-1.4.2-.4.4-.3.7-.2.3.1 1.8.9 2.1 1 .3.2.5.2.6.3.1.2.1.9-.1 1.5z"/></svg>';
}

/**
 * Keeps safe HTML from WYSIWYG fields and maps iframes (Google Maps) through.
 */
function ls_kses_embed( $html ) {
    $allowed           = wp_kses_allowed_html( 'post' );
    $allowed['iframe'] = array( 'src' => true, 'width' => true, 'height' => true, 'style' => true, 'loading' => true, 'allowfullscreen' => true, 'referrerpolicy' => true, 'title' => true, 'frameborder' => true );
    return wp_kses( (string) $html, $allowed );
}

/**
 * Splits FAQ text written as "Q: … / A: …" paragraphs into separate
 * questions. Returns an empty array when no "Q:" markers are found.
 */
function ls_parse_faq_html( $html ) {
    $parts = preg_split( '#<p[^>]*>\s*(?:<strong>|<b>)?\s*Q\s*[:.]\s*(.*?)\s*(?:</strong>|</b>)?\s*</p>#is', (string) $html, -1, PREG_SPLIT_DELIM_CAPTURE );

    if ( count( $parts ) < 3 ) {
        return array();
    }

    $items = array();
    for ( $i = 1; $i < count( $parts ); $i += 2 ) {
        $answer  = preg_replace( '#^(\s*<p[^>]*>\s*)(?:<strong>|<b>)?\s*A\s*[:.]\s*(?:</strong>|</b>)?\s*#i', '$1', trim( $parts[ $i + 1 ] ?? '' ) );
        $items[] = array(
            'question' => wp_strip_all_tags( $parts[ $i ] ),
            'answer'   => $answer,
        );
    }
    return $items;
}

/**
 * Inline script (printed early in <head>) that repairs images that fail to
 * load in the browser — e.g. photos hosted on another domain:
 * gallery tiles are removed, logos/portraits are hidden, and every other
 * photo is swapped for one of the fallback photos.
 */
function ls_fallback_script() {
    $urls = array_values( array_filter( array_map( function ( $id ) {
        return wp_get_attachment_image_url( $id, 'large' );
    }, ls_fallback_ids() ) ) );
    ?>
    <script>
    (function () {
        var photos = <?php echo wp_json_encode( $urls ); ?>;
        function pick(seed) {
            var h = 0;
            for (var i = 0; i < seed.length; i++) { h = (h * 31 + seed.charCodeAt(i)) | 0; }
            return photos[Math.abs(h) % photos.length];
        }
        window.addEventListener('error', function (e) {
            var img = e.target;
            if (!img || img.tagName !== 'IMG' || img.getAttribute('data-ls-fallen')) return;
            img.setAttribute('data-ls-fallen', '1');
            var tile = img.closest('.ls-gallery a');
            if (tile) { tile.parentNode.removeChild(tile); return; }
            if (img.hasAttribute('data-ls-nofallback') || !photos.length) { img.style.display = 'none'; return; }
            img.removeAttribute('srcset');
            img.removeAttribute('sizes');
            img.src = pick(img.getAttribute('src') || '');
        }, true);
    })();
    </script>
    <?php
}
add_action( 'wp_head', 'ls_fallback_script', 1 );
