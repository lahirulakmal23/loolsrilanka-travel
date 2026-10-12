<?php
/**
 * Justified photo grid (Gallery page and destination pages).
 * Args: photos (from ls_photo_item), class, lightbox (GLightbox group name; '' when
 * the page handles clicks itself), show_place (pin + place name on each photo).
 */
$args = wp_parse_args( $args, array( 'photos' => array(), 'class' => '', 'lightbox' => '', 'show_place' => true ) );

if ( ! $args['photos'] ) {
    return;
}
?>
<div class="ls-gl-grid <?php echo esc_attr( $args['class'] ); ?>">
    <?php foreach ( $args['photos'] as $photo ) : ?>
        <?php
        $place   = $args['show_place'] ? $photo['place'] : '';
        $caption = $photo['caption'] ?: trim( $photo['place'] . ( $photo['category'] ? ' · ' . $photo['category'] : '' ), ' ·' );
        $attr    = array( 'alt' => $caption, 'sizes' => '(max-width: 600px) 100vw, 40vw' );
        ?>
        <a class="ls-gl-item<?php echo $args['lightbox'] ? ' glightbox' : ''; ?>" href="<?php echo esc_url( $photo['url'] ); ?>"
           style="--r: <?php echo esc_attr( round( $photo['ratio'], 3 ) ); ?>"
           data-cat="<?php echo esc_attr( $photo['slug'] ); ?>"
           data-search="<?php echo esc_attr( strtolower( $photo['place'] . ' ' . $photo['category'] ) ); ?>"
           data-title="<?php echo esc_attr( $caption ); ?>"<?php echo $args['lightbox'] ? ' data-gallery="' . esc_attr( $args['lightbox'] ) . '"' : ''; ?>>
            <?php echo $photo['id'] ? wp_get_attachment_image( $photo['id'], 'large', false, $attr ) : ls_image( $photo['url'], 'large', $attr ); ?>
            <?php if ( $place || $photo['category'] ) : ?>
                <span class="ls-gl-cap">
                    <?php if ( $place ) : ?>
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2a7 7 0 00-7 7c0 5.2 7 13 7 13s7-7.8 7-13a7 7 0 00-7-7zm0 9.5A2.5 2.5 0 1112 6.5a2.5 2.5 0 010 5z"/></svg>
                        <span class="ls-gl-place"><?php echo esc_html( $place ); ?></span>
                    <?php endif; ?>
                    <?php if ( $photo['category'] ) : ?>
                        <span class="ls-gl-tag"><?php echo esc_html( $photo['category'] ); ?></span>
                    <?php endif; ?>
                </span>
            <?php endif; ?>
        </a>
    <?php endforeach; ?>
</div>
