<?php
/**
 * Experience (escapade) detail.
 */
get_header();

while ( have_posts() ) :
    the_post();
    $gallery    = ls_gallery_items( get_the_ID() );
    $hero_image = ls_post_hero_image( get_the_ID() );
    ?>
    <main id="primary" class="ls-page ls-detail">
        <?php
        get_template_part( 'template-parts/page-hero', null, array(
            'heading' => get_the_title(),
            'image'   => $hero_image,
            'crumbs'  => array( 'Home' => home_url( '/' ), __( 'Experiences', 'looksrilanka' ) => get_post_type_archive_link( 'escapades' ), get_the_title() => '' ),
            'class'   => 'ls-page-hero-tall',
        ) );
        ?>

        <div class="ls-wrap ls-narrow">
            <section class="ls-prose-block">
                <div class="ls-kicker"><?php esc_html_e( 'About this experience', 'looksrilanka' ); ?></div>
                <div class="ls-prose"><?php the_content(); ?></div>
            </section>

            <?php get_template_part( 'template-parts/highlights-grid', null, array( 'heading' => __( 'Highlights', 'looksrilanka' ) ) ); ?>

            <?php if ( $gallery ) : ?>
                <section class="ls-block">
                    <h2 class="ls-block-title"><?php esc_html_e( 'Gallery', 'looksrilanka' ); ?></h2>
                    <?php get_template_part( 'template-parts/gallery-grid', null, array( 'items' => $gallery, 'group' => 'experience' ) ); ?>
                </section>
            <?php endif; ?>
        </div>

        <?php
        get_template_part( 'template-parts/cta-band', null, array(
            'heading' => str_replace( '{experience}', get_the_title(), (string) ls_option( 'ex_single_cta_heading' ) ),
            'text'    => str_replace( '{experience}', get_the_title(), (string) ls_option( 'ex_single_cta_text' ) ),
            'button'  => ls_option( 'ex_single_cta_btn' ),
        ) );
        ?>
    </main>
    <?php
endwhile;

get_footer();
