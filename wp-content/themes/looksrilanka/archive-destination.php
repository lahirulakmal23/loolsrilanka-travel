<?php
/**
 * Destinations listing. All destinations are shown on one page
 * (see ls_destination_query) so the region filter works instantly.
 */
get_header();

// Region filter buttons, in order of first appearance.
$regions = array();
if ( have_posts() ) {
    while ( have_posts() ) {
        the_post();
        $region = trim( (string) ls_get( 'ds_region' ) );
        if ( $region ) {
            $regions[ sanitize_title( $region ) ] = $region;
        }
    }
    rewind_posts();
}
?>
<main id="primary" class="ls-page ls-listing">
    <?php
    get_template_part( 'template-parts/page-hero', null, array(
        'heading' => ls_option( 'ds_list_heading' ) ?: 'Destinations',
        'text'    => ls_option( 'ds_list_text' ) ?: ls_option( 'destination_page_content' ),
        'image'   => ls_option( 'destination_page_banner' ),
        'crumbs'  => array( 'Home' => home_url( '/' ), 'Destinations' => '' ),
    ) );
    ?>

    <div class="ls-wrap">
        <?php if ( count( $regions ) > 1 ) : ?>
            <div class="ls-filters" data-ls-filter="#ls-dest-grid" role="group" aria-label="<?php esc_attr_e( 'Filter by region', 'looksrilanka' ); ?>">
                <button type="button" class="is-active" data-region="all" aria-pressed="true"><?php echo esc_html( ls_option( 'ds_list_all' ) ?: 'All Regions' ); ?></button>
                <?php foreach ( $regions as $slug => $label ) : ?>
                    <button type="button" data-region="<?php echo esc_attr( $slug ); ?>" aria-pressed="false"><?php echo esc_html( $label ); ?></button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ( have_posts() ) : ?>
            <div class="ls-grid ls-grid-3" id="ls-dest-grid">
                <?php
                while ( have_posts() ) {
                    the_post();
                    get_template_part( 'template-parts/card-destination' );
                }
                ?>
            </div>
            <?php the_posts_pagination( array( 'mid_size' => 1, 'class' => 'ls-pagination' ) ); ?>
        <?php else : ?>
            <p class="ls-empty"><?php esc_html_e( 'No destinations found.', 'looksrilanka' ); ?></p>
        <?php endif; ?>
    </div>

    <?php
    get_template_part( 'template-parts/cta-band', null, array(
        'heading' => ls_option( 'ds_list_cta_heading' ),
        'text'    => ls_option( 'ds_list_cta_text' ),
        'button'  => ls_option( 'ds_list_cta_btn' ),
    ) );
    ?>
</main>
<?php
get_footer();
