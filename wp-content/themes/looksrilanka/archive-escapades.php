<?php
/**
 * Experiences (escapades) listing.
 */
get_header();
?>
<main id="primary" class="ls-page ls-listing">
    <?php
    get_template_part( 'template-parts/page-hero', null, array(
        'heading' => ls_option( 'ex_list_heading' ) ?: __( 'Experiences', 'looksrilanka' ),
        'text'    => ls_option( 'ex_list_text' ) ?: ls_option( 'escapades_page_content' ),
        'image'   => ls_option( 'escapades_page_banner' ),
        'crumbs'  => array( 'Home' => home_url( '/' ), __( 'Experiences', 'looksrilanka' ) => '' ),
    ) );
    ?>

    <div class="ls-wrap">
        <?php if ( have_posts() ) : ?>
            <div class="ls-grid ls-grid-3 ls-grid-spaced">
                <?php
                while ( have_posts() ) {
                    the_post();
                    get_template_part( 'template-parts/card-destination' );
                }
                ?>
            </div>
            <?php the_posts_pagination( array( 'mid_size' => 1, 'class' => 'ls-pagination', 'prev_text' => '&lsaquo;', 'next_text' => '&rsaquo;' ) ); ?>
        <?php else : ?>
            <p class="ls-empty"><?php esc_html_e( 'No experiences found.', 'looksrilanka' ); ?></p>
        <?php endif; ?>
    </div>

    <?php
    get_template_part( 'template-parts/cta-band', null, array(
        'heading' => ls_option( 'ex_list_cta_heading' ),
        'text'    => ls_option( 'ex_list_cta_text' ),
        'button'  => ls_option( 'ex_list_cta_btn' ),
    ) );
    ?>
</main>
<?php
get_footer();
