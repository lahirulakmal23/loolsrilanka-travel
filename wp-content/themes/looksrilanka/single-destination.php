<?php
/**
 * Destination detail.
 */
get_header();

while ( have_posts() ) :
    the_post();
    $id         = get_the_ID();
    $region     = ls_get( 'ds_region' );
    $facts      = array_values( array_filter( (array) ls_get( 'ds_facts' ), function ( $fact ) {
        return is_array( $fact ) && '' !== trim( (string) $fact['label'] ) && '' !== trim( (string) $fact['value'] );
    } ) );
    $appears    = ls_destination_appearances( $id );
    $labels     = wp_list_pluck( $appears, 'label', 'id' );
    $related    = array();

    // "Where this appears": the itineraries picked in wp-admin, otherwise the
    // itineraries and day tours whose route mentions this destination.
    foreach ( (array) ls_get( 'ds_related' ) as $rel_id ) {
        if ( $rel_id && 'publish' === get_post_status( $rel_id ) ) {
            $related[] = array( 'id' => $rel_id, 'label' => $labels[ $rel_id ] ?? ls_days_label( ls_get( 'days', $rel_id ) ) );
        }
    }
    if ( ! $related ) {
        $related = array_slice( $appears, 0, 6 );
    }

    // Quick facts: the rows entered in wp-admin, with the region and how many
    // tours visit it added unless those rows already exist.
    $fact_keys = array_map( 'ls_place_key', wp_list_pluck( $facts, 'label' ) );
    $auto      = array();
    $tours     = count( wp_list_filter( $appears, array( 'type' => 'tour' ) ) );
    $day_tours = count( $appears ) - $tours;
    if ( $region && ! in_array( 'region', $fact_keys, true ) ) {
        $auto[] = array( 'label' => __( 'Region', 'looksrilanka' ), 'value' => $region );
    }
    if ( $tours && ! in_array( 'itineraries', $fact_keys, true ) ) {
        $auto[] = array( 'label' => __( 'Itineraries', 'looksrilanka' ), 'value' => sprintf( _n( '%d tour', '%d tours', $tours, 'looksrilanka' ), $tours ) );
    }
    if ( $day_tours && ! in_array( 'daytours', $fact_keys, true ) ) {
        $auto[] = array( 'label' => __( 'Day tours', 'looksrilanka' ), 'value' => sprintf( _n( '%d day trip', '%d day trips', $day_tours, 'looksrilanka' ), $day_tours ) );
    }
    $facts = array_merge( $auto, $facts );
    $hero_image = ls_post_hero_image( get_the_ID() );
    $photos     = ls_destination_photos( $id, is_numeric( $hero_image ) ? (int) $hero_image : 0 );
    $gallery_pg = get_page_by_path( 'gallery' );
    ?>
    <main id="primary" class="ls-page ls-detail">
        <?php
        get_template_part( 'template-parts/page-hero', null, array(
            'heading' => get_the_title(),
            'image'   => $hero_image,
            'crumbs'  => array( 'Home' => home_url( '/' ), 'Destinations' => get_post_type_archive_link( 'destination' ), get_the_title() => '' ),
            'badges'  => array( $region ),
            'class'   => 'ls-page-hero-tall',
        ) );
        ?>

        <div class="ls-wrap ls-side-layout">
            <div class="ls-main-col">
                <section class="ls-prose-block">
                    <div class="ls-kicker"><?php esc_html_e( 'About this destination', 'looksrilanka' ); ?></div>
                    <?php if ( $heading = ls_get( 'ds_heading' ) ) : ?>
                        <h2 class="ls-block-title"><?php echo esc_html( $heading ); ?></h2>
                    <?php endif; ?>
                    <div class="ls-prose"><?php the_content(); ?></div>
                </section>

                <?php get_template_part( 'template-parts/highlights-grid' ); ?>

                <?php if ( $photos ) : ?>
                    <section class="ls-block ls-ds-gallery">
                        <div class="ls-ds-gallery-head">
                            <h2 class="ls-block-title"><?php echo esc_html( str_replace( '{destination}', get_the_title(), (string) ( ls_option( 'ds_gallery_heading' ) ?: 'Photos of {destination}' ) ) ); ?></h2>
                            <?php $place = current( array_filter( wp_list_pluck( $photos, 'place' ) ) ); ?>
                            <?php if ( $place && $gallery_pg && 'publish' === $gallery_pg->post_status ) : ?>
                                <a class="ls-text-link" href="<?php echo esc_url( add_query_arg( 'q', rawurlencode( $place ), get_permalink( $gallery_pg ) ) ); ?>"><?php echo esc_html( ls_option( 'ds_gallery_link' ) ?: 'View all photos →' ); ?></a>
                            <?php endif; ?>
                        </div>
                        <?php
                        get_template_part( 'template-parts/photo-grid', null, array(
                            'photos'     => array_slice( $photos, 0, 9 ),
                            'class'      => 'ls-gl-grid-sm',
                            'lightbox'   => 'destination',
                            'show_place' => false,
                        ) );
                        ?>
                    </section>
                <?php endif; ?>
            </div>

            <?php if ( $facts || $related ) : ?>
                <aside class="ls-side">
                    <?php if ( $facts ) : ?>
                        <div class="ls-side-card">
                            <h3><?php esc_html_e( 'Quick facts', 'looksrilanka' ); ?></h3>
                            <dl class="ls-facts">
                                <?php foreach ( $facts as $fact ) : ?>
                                    <div><dt><?php echo esc_html( $fact['label'] ); ?></dt><dd><?php echo esc_html( $fact['value'] ); ?></dd></div>
                                <?php endforeach; ?>
                            </dl>
                        </div>
                    <?php endif; ?>
                    <?php if ( $related ) : ?>
                        <div class="ls-side-card">
                            <h3><?php esc_html_e( 'Where this appears', 'looksrilanka' ); ?></h3>
                            <ul class="ls-related-list">
                                <?php foreach ( $related as $rel ) : ?>
                                    <li>
                                        <a href="<?php echo esc_url( get_permalink( $rel['id'] ) ); ?>">
                                            <?php echo esc_html( wp_strip_all_tags( get_the_title( $rel['id'] ) ) ); ?>
                                            <?php if ( $rel['label'] ) : ?><span><?php echo esc_html( $rel['label'] ); ?></span><?php endif; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </aside>
            <?php endif; ?>
        </div>

        <?php
        get_template_part( 'template-parts/cta-band', null, array(
            'heading' => str_replace( '{destination}', get_the_title(), (string) ls_option( 'ds_single_cta_heading' ) ),
            'text'    => str_replace( '{destination}', get_the_title(), (string) ls_option( 'ds_single_cta_text' ) ),
            'button'  => ls_option( 'ds_single_cta_btn' ),
        ) );
        ?>
    </main>
    <?php
endwhile;

get_footer();
