<?php
/**
 * Fallback template: search results and any listing without its own template.
 */
get_header();

if ( is_search() ) {
    $heading = sprintf( __( 'Search results for “%s”', 'looksrilanka' ), get_search_query() );
} elseif ( is_archive() ) {
    $heading = wp_strip_all_tags( get_the_archive_title() );
} else {
    $heading = get_bloginfo( 'name' );
}
?>
<main id="primary" class="ls-page ls-listing">
    <?php
    get_template_part( 'template-parts/page-hero', null, array(
        'heading' => $heading,
        'crumbs'  => array( 'Home' => home_url( '/' ), $heading => '' ),
        'after'   => is_search() ? '<form class="ls-search ls-search-hero" role="search" method="get" action="' . esc_url( home_url( '/' ) ) . '"><label class="screen-reader-text" for="ls-search-again">' . esc_html__( 'Search', 'looksrilanka' ) . '</label><input id="ls-search-again" type="search" name="s" value="' . esc_attr( get_search_query() ) . '"><button type="submit" class="ls-btn ls-btn-primary">' . esc_html__( 'Search', 'looksrilanka' ) . '</button></form>' : '',
    ) );
    ?>

    <div class="ls-wrap">
        <?php if ( have_posts() ) : ?>
            <div class="ls-grid ls-grid-3 ls-grid-spaced">
                <?php
                while ( have_posts() ) {
                    the_post();
                    get_template_part( 'template-parts/card-post' );
                }
                ?>
            </div>
            <?php the_posts_pagination( array( 'mid_size' => 1, 'class' => 'ls-pagination', 'prev_text' => '&lsaquo;', 'next_text' => '&rsaquo;' ) ); ?>
        <?php else : ?>
            <p class="ls-empty"><?php esc_html_e( 'Nothing found. Try a different search, or browse our tours.', 'looksrilanka' ); ?> <a href="<?php echo esc_url( get_post_type_archive_link( 'tour' ) ); ?>"><?php esc_html_e( 'See all tours', 'looksrilanka' ); ?></a></p>
        <?php endif; ?>
    </div>
</main>
<?php
get_footer();
