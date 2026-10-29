<?php
/**
 * Home: Modern Travel Photo Gallery Showcase.
 * Displays an asymmetric bento mosaic of destination moments.
 * Falls back to Gallery page photos or destination attachments automatically.
 */
$show = ls_get( 'hp_gallery_show' );
if ( null !== $show && ! $show ) {
    return;
}

$kicker  = ls_get( 'hp_gallery_kicker' ) ?: __( 'Visual Journey', 'looksrilanka' );
$heading = ls_get( 'hp_gallery_heading' ) ?: __( 'Glimpses of Paradise', 'looksrilanka' );
$intro   = ls_get( 'hp_gallery_intro' );
if ( empty( $intro ) && null === $intro ) {
    $intro = __( 'From mist-veiled mountain peaks and sacred ancient temples to golden coastlines and untamed safari wildlife.', 'looksrilanka' );
}

$link = ls_get( 'hp_gallery_link' );
if ( empty( $link['url'] ) ) {
    $gallery_page = get_page_by_path( 'gallery' );
    $link = array(
        'url'    => $gallery_page ? get_permalink( $gallery_page ) : home_url( '/gallery/' ),
        'title'  => __( 'Explore Full Gallery', 'looksrilanka' ),
        'target' => '',
    );
}

// 1. Check for curated photos in Home ACF field
$photos = array();
$curated = (array) ls_get( 'hp_gallery_photos' );
foreach ( $curated as $item_id ) {
    $id = is_array( $item_id ) ? ( $item_id['ID'] ?? 0 ) : (int) $item_id;
    if ( $id && ls_image_ok( $id ) ) {
        $meta     = wp_get_attachment_metadata( $id );
        $title    = get_the_title( $id );
        $caption  = wp_get_attachment_caption( $id );
        $photos[] = ls_photo_item( $id, $title, '', '', $caption );
    }
}

// 2. If empty, pull from the Gallery page
if ( empty( $photos ) && function_exists( 'ls_gallery_page_photos' ) ) {
    $photos = ls_gallery_page_photos();
}

// 3. If still fewer than 7 photos, complement with published destinations
if ( count( $photos ) < 7 ) {
    $dest_query = get_posts( array(
        'post_type'      => 'destination',
        'posts_per_page' => 10,
        'post_status'    => 'publish',
    ) );
    $seen_ids = array_flip( array_filter( array_column( $photos, 'id' ) ) );
    foreach ( $dest_query as $dest ) {
        $thumb = get_post_thumbnail_id( $dest->ID );
        if ( $thumb && ! isset( $seen_ids[ $thumb ] ) && ls_image_ok( $thumb ) ) {
            $seen_ids[ $thumb ] = true;
            $region = (string) get_field( 'field_ls_ds_region', $dest->ID );
            $photos[] = ls_photo_item( $thumb, get_the_title( $dest->ID ), $region ?: 'Explore' );
            if ( count( $photos ) >= 7 ) {
                break;
            }
        }
    }
}

// Limit to 7 items for the balanced bento mosaic
$photos = array_slice( $photos, 0, 7 );

if ( empty( $photos ) ) {
    return;
}

?>


<section class="ls-section ls-home-gallery">
    <div class="ls-wrap">
        <div class="ls-hg-head">
            <div class="ls-section-head ls-mb-0">
                <?php if ( $kicker ) : ?>
                    <p class="ls-kicker"><?php echo esc_html( $kicker ); ?></p>
                <?php endif; ?>
                <h2><?php echo esc_html( $heading ); ?></h2>
                <?php if ( $intro ) : ?>
                    <p><?php echo esc_html( $intro ); ?></p>
                <?php endif; ?>
            </div>
            <?php if ( ! empty( $link['url'] ) ) : ?>
                <div class="ls-hg-actions">
                    <a class="ls-hg-btn" href="<?php echo esc_url( $link['url'] ); ?>"<?php echo ! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener"' : ''; ?>>
                        <span><?php echo esc_html( $link['title'] ); ?></span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <div class="ls-hg-grid">
            <?php foreach ( $photos as $idx => $photo ) :
                $is_hero = ( 0 === $idx );
                $place   = $photo['place'] ?: get_bloginfo( 'name' );
                $caption = $photo['caption'] ?: trim( $place . ( $photo['category'] ? ' · ' . $photo['category'] : '' ), ' ·' );
                $size    = $is_hero ? 'large' : 'medium_large';
            ?>
                <a class="ls-hg-card glightbox<?php echo $is_hero ? ' ls-hg-card-lg' : ''; ?>"
                   href="<?php echo esc_url( $photo['url'] ); ?>"
                   data-gallery="home-gallery"
                   data-cat="<?php echo esc_attr( $photo['slug'] ); ?>"
                   data-title="<?php echo esc_attr( $caption ); ?>"
                   aria-label="<?php echo esc_attr( sprintf( __( 'View photo: %s', 'looksrilanka' ), $place ) ); ?>">

                    <?php if ( $photo['id'] ) : ?>
                        <?php echo wp_get_attachment_image( $photo['id'], $size, false, array(
                            'class'   => 'ls-hg-img',
                            'alt'     => $caption,
                            'loading' => $is_hero ? 'eager' : 'lazy',
                        ) ); ?>
                    <?php else : ?>
                        <?php echo ls_image( $photo['url'], $size, array(
                            'class' => 'ls-hg-img',
                            'alt'   => $caption,
                        ) ); ?>
                    <?php endif; ?>

                    <?php if ( ! empty( $photo['category'] ) ) : ?>
                        <span class="ls-hg-cat"><?php echo esc_html( $photo['category'] ); ?></span>
                    <?php endif; ?>

                    <span class="ls-hg-zoom" aria-hidden="true" title="<?php esc_attr_e( 'Expand photo', 'looksrilanka' ); ?>">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.35-4.35"/><path d="M11 8v6M8 11h6"/></svg>
                    </span>

                    <div class="ls-hg-body">
                        <span class="ls-hg-place">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2a7 7 0 00-7 7c0 5.2 7 13 7 13s7-7.8 7-13a7 7 0 00-7-7zm0 9.5A2.5 2.5 0 1112 6.5a2.5 2.5 0 010 5z"/></svg>
                            <?php echo esc_html( $place ); ?>
                        </span>
                        <?php if ( ! empty( $photo['caption'] ) && $photo['caption'] !== $place ) : ?>
                            <span class="ls-hg-caption"><?php echo esc_html( $photo['caption'] ); ?></span>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

    </div>
</section>
