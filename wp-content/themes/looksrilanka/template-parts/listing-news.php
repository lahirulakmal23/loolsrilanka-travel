<?php
/**
 * Blog / news listing. Args: query (WP_Query; defaults to the main query).
 */
$args  = wp_parse_args( $args, array( 'query' => null ) );
$query = $args['query'] ?: $GLOBALS['wp_query'];
$title = is_page() ? get_the_title() : __( 'News', 'looksrilanka' );
$paged = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
?>
<main id="primary" class="ls-page ls-listing ls-listing-blog">
    <?php
    get_template_part( 'template-parts/page-hero', null, array(
        'kicker'  => ls_option( 'nw_list_kicker' ),
        'heading' => ls_option( 'nw_list_heading' ) ?: $title,
        'text'    => ls_option( 'nw_list_text' ),
        'image'   => ls_option( 'blog_page_banner' ) ?: ls_option( 'news_page_banner' ),
        'crumbs'  => array( 'Home' => home_url( '/' ), $title => '' ),
    ) );
    ?>

    <?php if ( $query->have_posts() ) : ?>
        <?php
        $posts_list = $query->posts;
        $featured_post = null;

        // On first page, present the first article as the featured card
        if ( 1 === (int) $paged && ! empty( $posts_list ) ) {
            $featured_post = array_shift( $posts_list );
        }
        ?>

        <?php if ( $featured_post ) :
            $feat_id     = $featured_post->ID;
            $feat_title  = get_the_title( $featured_post );
            $feat_link   = get_permalink( $featured_post );
            $feat_image  = ls_post_image( $feat_id, 'large', array( 'sizes' => '(max-width: 800px) 100vw, 680px', 'alt' => esc_attr( $feat_title ) ) );
            $feat_author = get_the_author_meta( 'display_name', $featured_post->post_author );
            $feat_init   = $feat_author ? mb_substr( $feat_author, 0, 1 ) : 'S';
            $feat_date   = get_the_date( 'M Y', $featured_post );
            $feat_words  = str_word_count( wp_strip_all_tags( $featured_post->post_content ) );
            $feat_mins   = max( 1, (int) ceil( $feat_words / 200 ) );

            // Terms for featured badge
            $feat_terms = wp_get_object_terms( $feat_id, array( 'category', 'post_tag' ) );
            if ( empty( $feat_terms ) || is_wp_error( $feat_terms ) ) {
                $feat_tax_names = get_object_taxonomies( $featured_post->post_type );
                if ( ! empty( $feat_tax_names ) ) {
                    $feat_terms = wp_get_object_terms( $feat_id, $feat_tax_names );
                }
            }
            $feat_badge = '';
            if ( ! empty( $feat_terms ) && ! is_wp_error( $feat_terms ) ) {
                foreach ( $feat_terms as $t ) {
                    if ( 'uncategorised' !== $t->slug && 'uncategorized' !== $t->slug ) {
                        $feat_badge = $t->name;
                        break;
                    }
                }
            }
            if ( ! $feat_badge ) {
                $feat_badge = __( 'Featured Story', 'looksrilanka' );
            }
            ?>
            <section class="featured">
                <div class="wrap ls-wrap">
                    <a class="featured-card" href="<?php echo esc_url( $feat_link ); ?>">
                        <div class="featured-visual"<?php if ( ! has_post_thumbnail( $feat_id ) ) : ?> style="background:linear-gradient(135deg,var(--ls-accent),var(--ls-navy));"<?php endif; ?>>
                            <?php if ( $feat_image ) : ?>
                                <?php echo $feat_image; ?>
                            <?php endif; ?>
                        </div>
                        <div class="featured-body">
                            <span class="tag"><?php echo esc_html( $feat_badge ); ?></span>
                            <h2><?php echo esc_html( $feat_title ); ?></h2>
                            <p><?php echo esc_html( wp_trim_words( get_the_excerpt( $featured_post ), 30 ) ); ?></p>
                            <div class="byline">
                                <div class="avatar"><?php echo esc_html( $feat_init ); ?></div>
                                <?php echo esc_html( $feat_author ); ?> · <?php echo esc_html( $feat_date ); ?> · <?php echo esc_html( sprintf( _n( '%d min read', '%d min read', $feat_mins, 'looksrilanka' ), $feat_mins ) ); ?>
                            </div>
                            <span class="read-link"><?php esc_html_e( 'Read the full story →', 'looksrilanka' ); ?></span>
                        </div>
                    </a>
                </div>
            </section>
        <?php endif; ?>

        <div class="wrap ls-wrap">
            <?php
            // Collect all unique categories from all posts for filter buttons
            $filter_categories = array();
            $all_to_scan = $query->posts;
            foreach ( $all_to_scan as $item ) {
                $item_terms = wp_get_object_terms( $item->ID, array( 'category', 'post_tag' ) );
                if ( empty( $item_terms ) || is_wp_error( $item_terms ) ) {
                    $t_names = get_object_taxonomies( $item->post_type );
                    if ( ! empty( $t_names ) ) {
                        $item_terms = wp_get_object_terms( $item->ID, $t_names );
                    }
                }
                if ( ! empty( $item_terms ) && ! is_wp_error( $item_terms ) ) {
                    foreach ( $item_terms as $t ) {
                        if ( 'uncategorised' !== $t->slug && 'uncategorized' !== $t->slug ) {
                            $filter_categories[ $t->slug ] = $t->name;
                        }
                    }
                }
            }

            if ( ! empty( $filter_categories ) ) : ?>
                <div class="filters" id="filterBar" role="group" aria-label="<?php esc_attr_e( 'Filter articles', 'looksrilanka' ); ?>">
                    <button type="button" class="active" data-cat="all"><?php esc_html_e( 'All Posts', 'looksrilanka' ); ?></button>
                    <?php foreach ( $filter_categories as $slug => $name ) : ?>
                        <button type="button" data-cat="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $name ); ?></button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="post-grid ls-grid ls-grid-3" id="postGrid">
                <?php
                if ( ! empty( $posts_list ) ) {
                    foreach ( $posts_list as $post_item ) {
                        $GLOBALS['post'] = $post_item;
                        setup_postdata( $post_item );
                        get_template_part( 'template-parts/card-post' );
                    }
                    wp_reset_postdata();
                }
                ?>
            </div>

            <p class="ls-empty ls-empty-filter" id="noFilterMatch" hidden><?php esc_html_e( 'No articles found matching this topic.', 'looksrilanka' ); ?></p>

            <?php
            $links = paginate_links( array(
                'total'     => $query->max_num_pages,
                'current'   => $paged,
                'mid_size'  => 1,
                'prev_text' => '&lsaquo;',
                'next_text' => '&rsaquo;',
            ) );
            if ( $links ) {
                echo '<nav class="navigation pagination ls-pagination" aria-label="' . esc_attr__( 'More articles', 'looksrilanka' ) . '"><div class="nav-links">' . $links . '</div></nav>';
            }
            ?>
        </div>
    <?php else : ?>
        <div class="wrap ls-wrap">
            <p class="ls-empty"><?php esc_html_e( 'No articles yet — check back soon.', 'looksrilanka' ); ?></p>
        </div>
    <?php endif; ?>

    <section class="newsletter">
        <div class="wrap ls-wrap">
            <h2><?php echo esc_html( ls_option( 'nw_newsletter_heading' ) ?: __( 'Get one good Sri Lanka tip a month', 'looksrilanka' ) ); ?></h2>
            <p><?php echo esc_html( ls_option( 'nw_newsletter_text' ) ?: __( 'No spam, no daily emails — just the occasional post worth reading before you plan a trip here.', 'looksrilanka' ) ); ?></p>
            <form class="news-form" onsubmit="return false;">
                <input type="email" placeholder="<?php esc_attr_e( 'you@email.com', 'looksrilanka' ); ?>" aria-label="<?php esc_attr_e( 'Email address', 'looksrilanka' ); ?>" required>
                <button class="btn" type="submit"><?php esc_html_e( 'Subscribe', 'looksrilanka' ); ?></button>
            </form>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function(){
    var filterBar = document.getElementById('filterBar');
    if (!filterBar) return;
    filterBar.addEventListener('click', function(e){
        var btn = e.target.closest('button[data-cat]');
        if (!btn) return;
        filterBar.querySelectorAll('button').forEach(function(b){ b.classList.remove('active'); });
        btn.classList.add('active');
        var f = btn.dataset.cat;
        var visibleCount = 0;
        document.querySelectorAll('#postGrid .post-card').forEach(function(c){
            var own = ' ' + (c.dataset.cat || '') + ' ';
            var show = (f === 'all' || own.indexOf(' ' + f + ' ') !== -1);
            c.style.display = show ? '' : 'none';
            if (show) visibleCount++;
        });
        var emptyMsg = document.getElementById('noFilterMatch');
        if (emptyMsg) {
            emptyMsg.hidden = (visibleCount > 0);
        }
    });
});
</script>
