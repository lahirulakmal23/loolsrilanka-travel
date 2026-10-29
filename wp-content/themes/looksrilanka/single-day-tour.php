<?php
/**
 * Day tour detail.
 * Tour content is on the Day Tour post; shared headings, trust points and
 * the booking note are under Tour & Listing Pages → "Day tour detail".
 */
get_header();

while ( have_posts() ) :
    the_post();
    $id         = get_the_ID();
    $list_url   = ls_day_tours_url();
    $highlights = array_filter( wp_list_pluck( ls_get( 'highlights' ) ?: array(), 'highlight' ) );
    $schedule   = array_filter( ls_get( 'dt_schedule' ) ?: array(), function ( $row ) {
        return ! empty( $row['title'] );
    } );
    $itinerary  = trim( (string) ls_get( 'itinerary' ) );
    $meeting    = trim( (string) ls_get( 'dt_meeting' ) );
    $map        = trim( (string) ls_get( 'iframe' ) );
    $tips       = array_filter( ls_get( 'dt_tips' ) ?: array(), function ( $row ) {
        return ! empty( $row['title'] );
    } );
    $faq        = array();
    foreach ( ls_get( 'faq' ) ?: array() as $row ) {
        $faq[] = array( 'question' => $row['title_copy'] ?? '', 'answer' => $row['description'] ?? '' );
    }

    // Photo mosaic: featured image first, then the gallery (up to 5 in all).
    $photos = array();
    $thumb  = get_post_thumbnail_id();
    if ( $thumb && ls_image_ok( $thumb ) ) {
        $photos[] = array( 'id' => $thumb, 'url' => wp_get_attachment_url( $thumb ), 'caption' => '' );
    }
    foreach ( ls_gallery_items( $id ) as $item ) {
        if ( ! $thumb || (int) $item['id'] !== (int) $thumb ) {
            $photos[] = $item;
        }
    }
    if ( ! $photos && ( $fallback = ls_fallback_id( $id ) ) ) {
        $photos[] = array( 'id' => $fallback, 'url' => wp_get_attachment_url( $fallback ), 'caption' => '' );
    }
    $photos = array_slice( $photos, 0, 5 );

    $badges = array(
        implode( ' · ', array_filter( array( ls_get( 'dt_badge' ), ls_get( 'dt_duration' ) ) ) ),
        ls_get( 'dt_from' ),
        ls_get( 'dt_good_for' ) ? ( ls_option( 'dt_good_for_label' ) ?: 'Good for:' ) . ' ' . ls_get( 'dt_good_for' ) : '',
    );

    ob_start();
    if ( $photos ) :
        ?>
        <div class="ls-dt-mosaic ls-dt-mosaic-<?php echo count( $photos ); ?>">
            <?php foreach ( $photos as $i => $photo ) : ?>
                <a class="glightbox" href="<?php echo esc_url( $photo['url'] ); ?>" data-gallery="day-tour"<?php echo $photo['caption'] ? ' data-title="' . esc_attr( $photo['caption'] ) . '"' : ''; ?>>
                    <?php
                    // The hero photo above is the main image now, so the mosaic loads lazily.
                    $attr = array( 'alt' => $photo['caption'] ?: wp_strip_all_tags( get_the_title() ), 'sizes' => 0 === $i ? '(max-width: 760px) 100vw, 600px' : '(max-width: 760px) 50vw, 300px', 'loading' => 'lazy' );
                    echo $photo['id'] ? wp_get_attachment_image( $photo['id'], 0 === $i ? 'large' : 'medium_large', false, $attr ) : ls_image( $photo['url'], 'large', $attr );
                    ?>
                </a>
            <?php endforeach; ?>
        </div>
        <?php
    endif;
    $mosaic = ob_get_clean();

    // Hero background: the first photo (featured image, else gallery / fallback).
    $hero_image = $photos ? ( $photos[0]['id'] ?: $photos[0]['url'] ) : '';
    ?>
    <main id="primary" class="ls-page ls-detail ls-day-tour">
        <?php
        get_template_part( 'template-parts/page-hero', null, array(
            'heading' => get_the_title(),
            'image'   => $hero_image,
            'crumbs'  => array_filter( array(
                'Home'           => home_url( '/' ),
                'Day Tours'      => $list_url ?: null,
                get_the_title()  => '',
            ), function ( $url ) { return null !== $url; } ),
            'badges'  => $badges,
            'class'   => 'ls-dt-hero',
        ) );
        ?>

        <?php if ( $mosaic ) : ?>
            <div class="ls-wrap ls-dt-gallery"><?php echo $mosaic; // Pre-escaped markup built above. ?></div>
        <?php endif; ?>

        <div class="ls-wrap ls-side-layout">
            <div class="ls-main-col">

                <?php if ( ls_get( 'description' ) || $highlights ) : ?>
                    <section class="ls-prose-block">
                        <div class="ls-kicker"><?php echo esc_html( ls_option( 'dt_overview_label' ) ?: 'Overview' ); ?></div>
                        <?php if ( $heading = ls_get( 'dt_heading' ) ) : ?>
                            <h2 class="ls-block-title"><?php echo esc_html( $heading ); ?></h2>
                        <?php endif; ?>
                        <?php if ( $desc = ls_get( 'description' ) ) : ?>
                            <div class="ls-prose"><?php echo wpautop( esc_html( $desc ) ); ?></div>
                        <?php endif; ?>
                        <?php if ( $highlights ) : ?>
                            <h3 class="ls-mini-title"><?php echo esc_html( ls_option( 'dt_highlights_heading' ) ?: 'Highlights' ); ?></h3>
                            <ul class="ls-check-list">
                                <?php foreach ( $highlights as $highlight ) : ?>
                                    <li><?php echo esc_html( wp_strip_all_tags( $highlight ) ); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </section>
                <?php endif; ?>

                <?php if ( $schedule ) : ?>
                    <section class="ls-block">
                        <h2 class="ls-block-title"><?php echo esc_html( ls_option( 'dt_schedule_heading' ) ?: 'Hour-by-hour schedule' ); ?></h2>
                        <ol class="ls-timeline">
                            <?php foreach ( $schedule as $row ) : ?>
                                <li>
                                    <?php if ( ! empty( $row['time'] ) ) : ?><span class="ls-timeline-time"><?php echo esc_html( $row['time'] ); ?></span><?php endif; ?>
                                    <h3><?php echo esc_html( $row['title'] ); ?></h3>
                                    <?php if ( ! empty( $row['text'] ) ) : ?><p><?php echo esc_html( $row['text'] ); ?></p><?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    </section>
                <?php elseif ( wp_strip_all_tags( $itinerary ) ) : ?>
                    <section class="ls-block">
                        <h2 class="ls-block-title"><?php echo esc_html( ls_option( 'dt_itinerary_heading' ) ?: 'The day' ); ?></h2>
                        <div class="ls-prose ls-prose-card"><?php echo wpautop( wp_kses_post( $itinerary ) ); ?></div>
                    </section>
                <?php endif; ?>

                <div class="ls-block"><?php get_template_part( 'template-parts/includes' ); ?></div>

                <?php if ( $meeting || $map ) : ?>
                    <section class="ls-block">
                        <h2 class="ls-block-title"><?php echo esc_html( ls_option( 'dt_meeting_heading' ) ?: 'Meeting point & pickup' ); ?></h2>
                        <div class="ls-dt-meeting<?php echo $meeting && $map ? ' has-both' : ''; ?>">
                            <?php if ( $meeting ) : ?>
                                <div class="ls-dt-meeting-info ls-prose"><?php echo wpautop( wp_kses_post( $meeting ) ); ?></div>
                            <?php endif; ?>
                            <?php if ( $map ) : ?>
                                <div class="ls-map-embed"><?php echo ls_kses_embed( $map ); ?></div>
                            <?php endif; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <?php if ( $tips ) : ?>
                    <section class="ls-block">
                        <h2 class="ls-block-title"><?php echo esc_html( ls_option( 'dt_tips_heading' ) ?: 'Good to know' ); ?></h2>
                        <div class="ls-dt-tips">
                            <?php foreach ( $tips as $tip ) : ?>
                                <div class="ls-side-card">
                                    <h3><?php echo esc_html( $tip['title'] ); ?></h3>
                                    <?php if ( ! empty( $tip['text'] ) ) : ?><p><?php echo esc_html( $tip['text'] ); ?></p><?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <?php $faq = array_filter( $faq, function ( $row ) { return trim( wp_strip_all_tags( $row['question'] ) ); } ); ?>
                <?php if ( $faq ) : ?>
                    <section class="ls-block ls-dt-faq">
                        <h2 class="ls-block-title"><?php echo esc_html( ls_option( 'dt_faq_heading' ) ?: 'Frequently asked' ); ?></h2>
                        <?php foreach ( $faq as $row ) : ?>
                            <div class="ls-dt-faq-item">
                                <h3><?php echo esc_html( wp_strip_all_tags( $row['question'] ) ); ?></h3>
                                <?php echo wpautop( wp_kses_post( $row['answer'] ) ); ?>
                            </div>
                        <?php endforeach; ?>
                    </section>
                <?php endif; ?>
            </div>

            <?php
            get_template_part( 'template-parts/book-card', null, array(
                'price_note' => ls_get( 'dt_price_note' ),
                'trust'      => ls_option( 'dt_trust' ),
                'form'       => ls_option( 'dt_detail_form' ) ?: ls_option( 'dt_book_form' ),
                'customise'  => null,
                'note'       => ls_option( 'dt_book_note' ),
            ) );
            ?>
        </div>

        <?php
        // "Other day tours": two tours plus the destination guide, or three tours.
        $destination = (int) ls_get( 'dt_destination' );
        if ( ! $destination && ( $place = trim( (string) ls_get( 'destinations' ) ) ) ) {
            foreach ( get_posts( array( 'post_type' => 'destination', 'numberposts' => -1, 'fields' => 'ids' ) ) as $dest_id ) {
                if ( 0 === stripos( get_the_title( $dest_id ), $place ) ) {
                    $destination = $dest_id;
                    break;
                }
            }
        }
        $related = get_posts( array(
            'post_type'   => 'day-tour',
            'numberposts' => $destination ? 2 : 3,
            'exclude'     => array( $id ),
            'orderby'     => 'rand',
        ) );
        if ( $related || $destination ) :
            ?>
            <section class="ls-dt-related">
                <div class="ls-wrap">
                    <h2 class="ls-block-title"><?php echo esc_html( ls_option( 'dt_related_heading' ) ?: 'Other day tours you might like' ); ?></h2>
                    <div class="ls-dt-rel-grid">
                        <?php foreach ( $related as $tour ) : ?>
                            <?php $info = array_filter( array( get_field( 'price', $tour->ID ), get_field( 'dt_badge', $tour->ID ) ) ); ?>
                            <a class="ls-dt-rel" href="<?php echo esc_url( get_permalink( $tour ) ); ?>">
                                <span class="ls-dt-rel-img"><?php echo ls_post_image( $tour->ID, 'medium_large', array( 'alt' => '', 'sizes' => '(max-width: 860px) 100vw, 380px' ) ); ?></span>
                                <span class="ls-dt-rel-body">
                                    <h3><?php echo esc_html( get_the_title( $tour ) ); ?></h3>
                                    <?php if ( $info ) : ?><span><?php echo esc_html( implode( ' · ', $info ) ); ?></span><?php endif; ?>
                                </span>
                            </a>
                        <?php endforeach; ?>
                        <?php if ( $destination ) : ?>
                            <a class="ls-dt-rel" href="<?php echo esc_url( get_permalink( $destination ) ); ?>">
                                <span class="ls-dt-rel-img"><?php echo ls_post_image( $destination, 'medium_large', array( 'alt' => '', 'sizes' => '(max-width: 860px) 100vw, 380px' ) ); ?></span>
                                <span class="ls-dt-rel-body">
                                    <h3><?php echo esc_html( sprintf( ls_option( 'dt_dest_title' ) ?: '%s Destination Guide', get_the_title( $destination ) ) ); ?></h3>
                                    <span><?php echo esc_html( ls_option( 'dt_dest_text' ) ?: 'Learn more about this site' ); ?></span>
                                </span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </main>
    <?php
endwhile;

get_footer();
