<?php
/**
 * Photo grid that opens in a lightbox (GLightbox). Args: items (from ls_gallery_items), group.
 */
$args = wp_parse_args( $args, array( 'items' => array(), 'group' => 'gallery' ) );

if ( ! $args['items'] ) {
    return;
}
?>
<div class="ls-gallery">
    <?php foreach ( $args['items'] as $item ) : ?>
        <a class="glightbox" href="<?php echo esc_url( $item['url'] ); ?>" data-gallery="<?php echo esc_attr( $args['group'] ); ?>"<?php echo $item['caption'] ? ' data-title="' . esc_attr( $item['caption'] ) . '"' : ''; ?>>
            <?php echo $item['id'] ? wp_get_attachment_image( $item['id'], 'medium_large', false, array( 'alt' => esc_attr( $item['caption'] ) ) ) : ls_image( $item['url'], 'medium_large', array( 'alt' => $item['caption'] ) ); ?>
        </a>
    <?php endforeach; ?>
</div>
