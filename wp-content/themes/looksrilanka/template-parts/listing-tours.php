<?php
/**
 * Itinerary listing, used by the tour archive and the tour category pages.
 */
$archive = get_post_type_archive_link( 'tour' );
$term    = is_tax() ? get_queried_object() : null;
$text    = ls_option( 'it_list_text' ) ?: ls_option( 'tour_page_content' );

$crumbs = array( 'Home' => home_url( '/' ) );
if ( $term ) {
    $crumbs['Itineraries'] = $archive;
    $crumbs[ $term->name ] = '';
    $text = term_description( $term ) ? wp_strip_all_tags( term_description( $term ) ) : $text;
} else {
    $crumbs['Itineraries'] = '';
}
?>
<main id="primary" class="ls-page ls-listing">
    <?php
    get_template_part( 'template-parts/page-hero', null, array(
        'heading' => $term ? $term->name : ( ls_option( 'it_list_heading' ) ?: 'Tour Itineraries' ),
        'text'    => $text,
        'image'   => ls_option( 'tour_page_banner' ),
        'crumbs'  => $crumbs,
    ) );
    ?>

    <div class="ls-wrap">
        <div class="ls-filters" data-ls-filter="#ls-tour-grid" role="group" aria-label="<?php esc_attr_e( 'Filter tour itineraries', 'looksrilanka' ); ?>">
            <button type="button" class="is-active" data-region="all" aria-pressed="true"><?php esc_html_e( 'All Itineraries', 'looksrilanka' ); ?></button>
            <button type="button" data-region="5-7-days" aria-pressed="false"><?php esc_html_e( '5–7 Days', 'looksrilanka' ); ?></button>
            <button type="button" data-region="8-10-days" aria-pressed="false"><?php esc_html_e( '8–10 Days', 'looksrilanka' ); ?></button>
            <button type="button" data-region="12-plus-days" aria-pressed="false"><?php esc_html_e( '12+ Days', 'looksrilanka' ); ?></button>
            <button type="button" data-region="honeymoon" aria-pressed="false"><?php esc_html_e( 'Honeymoon', 'looksrilanka' ); ?></button>
            <button type="button" data-region="family" aria-pressed="false"><?php esc_html_e( 'Family', 'looksrilanka' ); ?></button>
        </div>

        <?php if ( have_posts() ) : ?>
            <div class="ls-grid ls-grid-3 ls-grid-tours" id="ls-tour-grid" data-per-page="9">
                <?php
                while ( have_posts() ) {
                    the_post();
                    get_template_part( 'template-parts/card-tour' );
                }
                ?>
            </div>
            <p class="ls-empty ls-empty-filter" hidden><?php esc_html_e( 'No itineraries match this filter.', 'looksrilanka' ); ?></p>
            <nav class="ls-pagination" id="ls-tour-grid-pages" aria-label="<?php esc_attr_e( 'Itinerary pages', 'looksrilanka' ); ?>" data-previous="<?php esc_attr_e( 'Previous page', 'looksrilanka' ); ?>" data-next="<?php esc_attr_e( 'Next page', 'looksrilanka' ); ?>" data-page-label="<?php esc_attr_e( 'Page', 'looksrilanka' ); ?>" hidden>
                <div class="nav-links"></div>
            </nav>
        <?php else : ?>
            <p class="ls-empty"><?php esc_html_e( 'No tours found in this category yet.', 'looksrilanka' ); ?> <a href="<?php echo esc_url( $archive ); ?>"><?php esc_html_e( 'See all tours', 'looksrilanka' ); ?></a></p>
        <?php endif; ?>
    </div>

    <?php
    get_template_part( 'template-parts/cta-band', null, array(
        'heading' => ls_option( 'it_list_cta_heading' ),
        'text'    => ls_option( 'it_list_cta_text' ),
        'button'  => ls_option( 'it_list_cta_btn' ),
    ) );
    ?>
</main>
