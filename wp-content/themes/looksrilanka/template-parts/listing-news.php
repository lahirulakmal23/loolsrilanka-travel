<?php
/**
 * Blog / news listing. Args: query (WP_Query; defaults to the main query).
 */
$args  = wp_parse_args( $args, array( 'query' => null ) );
$query = $args['query'] ?: $GLOBALS['wp_query'];
$title = is_page() ? get_the_title() : __( 'News', 'looksrilanka' );
?>
<main id="primary" class="ls-page ls-listing">
    <?php
    get_template_part( 'template-parts/page-hero', null, array(
        'kicker'  => ls_option( 'nw_list_kicker' ),
        'heading' => ls_option( 'nw_list_heading' ) ?: $title,
        'text'    => ls_option( 'nw_list_text' ),
        'image'   => ls_option( 'blog_page_banner' ) ?: ls_option( 'news_page_banner' ),
        'crumbs'  => array( 'Home' => home_url( '/' ), $title => '' ),
    ) );
    ?>

    <div class="ls-wrap">
        <?php if ( $query->have_posts() ) : ?>
            <div class="ls-grid ls-grid-3">
                <?php
                while ( $query->have_posts() ) {
                    $query->the_post();
                    get_template_part( 'template-parts/card-post' );
                }
                wp_reset_postdata();
                ?>
            </div>
            <?php
            $links = paginate_links( array(
                'total'     => $query->max_num_pages,
                'current'   => max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) ),
                'mid_size'  => 1,
                'prev_text' => '&lsaquo;',
                'next_text' => '&rsaquo;',
            ) );
            if ( $links ) {
                echo '<nav class="navigation pagination ls-pagination" aria-label="' . esc_attr__( 'More articles', 'looksrilanka' ) . '"><div class="nav-links">' . $links . '</div></nav>';
            }
            ?>
        <?php else : ?>
            <p class="ls-empty"><?php esc_html_e( 'No articles yet — check back soon.', 'looksrilanka' ); ?></p>
        <?php endif; ?>
    </div>

    <?php
    get_template_part( 'template-parts/cta-band', null, array(
        'heading' => ls_option( 'nw_cta_heading' ),
        'text'    => ls_option( 'nw_cta_text' ),
        'button'  => ls_option( 'nw_cta_btn' ),
    ) );
    ?>
</main>
