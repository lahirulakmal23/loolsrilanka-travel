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
 * Outputs an <img> for an ACF image value (ID, array or URL).
 */
function ls_image( $image, $size = 'large', $attr = array() ) {
    if ( empty( $image ) ) {
        return '';
    }
    if ( is_array( $image ) && isset( $image['ID'] ) ) {
        $image = $image['ID'];
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
 * Replaces {tours} and {day_tours} with live published post counts.
 */
function ls_count_tokens( $text ) {
    if ( false === strpos( (string) $text, '{' ) ) {
        return $text;
    }
    $counts = array(
        '{tours}'     => post_type_exists( 'tour' ) ? (int) wp_count_posts( 'tour' )->publish : 0,
        '{day_tours}' => post_type_exists( 'day-tour' ) ? (int) wp_count_posts( 'day-tour' )->publish : 0,
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
 * Fallback for the footer menu when no menu is assigned in Appearance > Menus.
 */
function ls_footer_fallback( $args ) {
    $items = array(
        '/'               => 'Home',
        '/about-us/'      => 'About us',
        '/tailor-made-2/' => 'Tailor-Made',
        '/blog/'          => 'Blog',
        '/faq/'           => 'Faq',
        '/contact-us/'    => 'Contact us',
    );

    echo '<ul class="' . esc_attr( $args['menu_class'] ) . '">';
    foreach ( $items as $path => $label ) {
        echo '<li><a href="' . esc_url( home_url( $path ) ) . '">' . esc_html( $label ) . '</a></li>';
    }
    echo '</ul>';
}
