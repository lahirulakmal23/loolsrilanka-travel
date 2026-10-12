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
        <?php
        get_template_part( 'template-parts/filter-menu', null, array(
            'location'  => 'tour-menu',
            'all_label' => ls_option( 'it_list_all' ) ?: 'All Itineraries',
            'all_url'   => $archive,
        ) );
        ?>

        <?php if ( have_posts() ) : ?>
            <div class="ls-grid ls-grid-2">
                <?php
                while ( have_posts() ) {
                    the_post();
                    get_template_part( 'template-parts/card-tour' );
                }
                ?>
            </div>
            <?php
            the_posts_pagination( array(
                'mid_size'           => 1,
                'prev_text'          => '&lsaquo;<span class="screen-reader-text"> ' . __( 'Previous', 'looksrilanka' ) . '</span>',
                'next_text'          => '<span class="screen-reader-text">' . __( 'Next', 'looksrilanka' ) . ' </span>&rsaquo;',
                'class'              => 'ls-pagination',
                'screen_reader_text' => __( 'More tours', 'looksrilanka' ),
            ) );
            ?>
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
