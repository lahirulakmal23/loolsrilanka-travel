<?php
/**
 * Multi-day itinerary detail.
 */
get_header();

while ( have_posts() ) :
    the_post();
    $id          = get_the_ID();
    $days        = (int) ls_get( 'days' );
    $route       = ls_route( $id );
    $itinerary   = ls_get( 'itinerary' ) ?: array();
    $highlights  = array_filter( wp_list_pluck( ls_get( 'highlights' ) ?: array(), 'highlight' ) );
    $gallery     = ls_gallery_items( $id );
    $map         = trim( (string) ls_get( 'iframe' ) );
    $drive_times = array_filter( wp_list_pluck( ls_get( 'it_drive_times' ) ?: array(), 'text' ) );

    $meta = array_filter( array(
        __( 'Duration', 'looksrilanka' )     => ls_days_label( $days ),
        __( 'Group size', 'looksrilanka' )   => ls_get( 'it_group' ),
        __( 'Destinations', 'looksrilanka' ) => ls_get( 'destinations' ),
        __( 'Pace', 'looksrilanka' )         => ls_get( 'it_pace' ),
    ) );
    ob_start();
    ?>
    <?php if ( $route ) : ?>
        <div class="ls-route ls-route-hero"><?php echo esc_html( $route ); ?></div>
    <?php endif; ?>
    <?php if ( $meta ) : ?>
        <dl class="ls-meta-row">
            <?php foreach ( $meta as $label => $value ) : ?>
                <div><dd><?php echo esc_html( $value ); ?></dd><dt><?php echo esc_html( $label ); ?></dt></div>
            <?php endforeach; ?>
        </dl>
    <?php endif; ?>
    <?php
    $hero_after = ob_get_clean();
    ?>
    <main id="primary" class="ls-page ls-detail">
        <?php
        get_template_part( 'template-parts/page-hero', null, array(
            'heading' => get_the_title(),
            'image'   => ls_post_hero_image( get_the_ID() ),
            'crumbs'  => array( 'Home' => home_url( '/' ), 'Itineraries' => get_post_type_archive_link( 'tour' ), get_the_title() => '' ),
            'after'   => $hero_after,
        ) );
        ?>

        <div class="ls-wrap ls-side-layout">
            <div class="ls-main-col">

                <?php if ( ls_get( 'description' ) || $highlights ) : ?>
                    <section class="ls-prose-block">
                        <div class="ls-kicker"><?php esc_html_e( 'Overview', 'looksrilanka' ); ?></div>
                        <?php if ( $desc = ls_get( 'description' ) ) : ?>
                            <div class="ls-prose"><?php echo wpautop( esc_html( $desc ) ); ?></div>
                        <?php endif; ?>
                        <?php if ( $highlights ) : ?>
                            <h3 class="ls-mini-title"><?php esc_html_e( 'Highlights', 'looksrilanka' ); ?></h3>
                            <ul class="ls-check-list">
                                <?php foreach ( $highlights as $highlight ) : ?>
                                    <li><?php echo esc_html( wp_strip_all_tags( $highlight ) ); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </section>
                <?php endif; ?>

                <?php if ( $map || $drive_times ) : ?>
                    <section class="ls-route-map">
                        <?php if ( $map ) : ?>
                            <div class="ls-map-embed"><?php echo ls_kses_embed( $map ); ?></div>
                        <?php endif; ?>
                        <?php if ( $drive_times ) : ?>
                            <ul class="ls-drive-times">
                                <?php foreach ( $drive_times as $time ) : ?>
                                    <li><?php echo esc_html( $time ); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </section>
                <?php endif; ?>

                <?php if ( $itinerary ) : ?>
                    <section class="ls-block" id="itinerary">
                        <h2 class="ls-block-title"><?php esc_html_e( 'Day by day', 'looksrilanka' ); ?></h2>
                        <nav class="ls-day-nav" aria-label="<?php esc_attr_e( 'Jump to day', 'looksrilanka' ); ?>">
                            <?php foreach ( $itinerary as $i => $day ) : ?>
                                <a href="#day-<?php echo esc_attr( $i + 1 ); ?>"><?php echo esc_html( trim( wp_strip_all_tags( $day['day'] ) ) ?: sprintf( __( 'Day %d', 'looksrilanka' ), $i + 1 ) ); ?></a>
                            <?php endforeach; ?>
                        </nav>
                        <ol class="ls-days">
                            <?php foreach ( $itinerary as $i => $day ) : ?>
                                <?php
                                preg_match_all( '/\d+/', (string) $day['day'], $nums );
                                $badge = $nums[0] ? implode( '-', array_map( 'intval', $nums[0] ) ) : $i + 1;
                                $text  = trim( (string) $day['description'] );
                                ?>
                                <li class="ls-day" id="day-<?php echo esc_attr( $i + 1 ); ?>">
                                    <span class="ls-day-badge" aria-hidden="true"><?php echo esc_html( $badge ); ?></span>
                                    <div>
                                        <span class="ls-day-label"><?php echo esc_html( wp_strip_all_tags( $day['day'] ) ); ?></span>
                                        <h3><?php echo esc_html( wp_strip_all_tags( $day['title_copy'] ) ); ?></h3>
                                        <?php if ( $text ) : ?>
                                            <div class="ls-prose"><?php echo wpautop( wp_kses_post( $text ) ); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    </section>
                <?php endif; ?>

                <?php if ( $gallery ) : ?>
                    <section class="ls-block">
                        <h2 class="ls-block-title"><?php esc_html_e( 'Waypoints', 'looksrilanka' ); ?></h2>
                        <?php get_template_part( 'template-parts/gallery-grid', null, array( 'items' => $gallery, 'group' => 'tour' ) ); ?>
                    </section>
                <?php endif; ?>

                <?php get_template_part( 'template-parts/includes' ); ?>

                <?php
                get_template_part( 'template-parts/faq-list', null, array(
                    'items'       => ls_option( 'it_faq' ),
                    'heading'     => ls_option( 'it_faq_heading' ),
                    'heading_tag' => 'h2',
                    'class'       => 'ls-block',
                ) );
                ?>
            </div>

            <?php get_template_part( 'template-parts/book-card' ); ?>
        </div>

        <?php
        get_template_part( 'template-parts/cta-band', null, array(
            'heading' => ls_option( 'it_single_cta_heading' ),
            'text'    => ls_option( 'it_single_cta_text' ),
            'button'  => ls_option( 'it_single_cta_btn' ),
        ) );
        ?>
    </main>
    <?php
endwhile;

get_footer();
