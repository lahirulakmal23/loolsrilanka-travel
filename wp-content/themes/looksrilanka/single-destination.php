<?php
/**
 * Destination detail.
 */
get_header();

while ( have_posts() ) :
    the_post();
    $id         = get_the_ID();
    $region     = ls_get( 'ds_region' );
    $gallery    = ls_gallery_items( $id );
    $facts      = ls_get( 'ds_facts' );
    $related    = ls_get( 'ds_related' );
    $hero_image = ls_post_hero_image( get_the_ID() );
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

                <?php if ( $gallery ) : ?>
                    <section class="ls-block">
                        <h2 class="ls-block-title"><?php esc_html_e( 'Gallery', 'looksrilanka' ); ?></h2>
                        <?php get_template_part( 'template-parts/gallery-grid', null, array( 'items' => $gallery, 'group' => 'destination' ) ); ?>
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
                                <?php foreach ( $related as $rel_id ) : ?>
                                    <?php if ( 'publish' !== get_post_status( $rel_id ) ) { continue; } ?>
                                    <li>
                                        <a href="<?php echo esc_url( get_permalink( $rel_id ) ); ?>">
                                            <?php echo esc_html( get_the_title( $rel_id ) ); ?>
                                            <span><?php echo esc_html( ls_days_label( ls_get( 'days', $rel_id ) ) ); ?></span>
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
