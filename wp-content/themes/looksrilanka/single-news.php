<?php
/**
 * News article.
 */
get_header();

$blog_page = get_page_by_path( 'blog' );
$list_url  = $blog_page ? get_permalink( $blog_page ) : get_post_type_archive_link( 'news' );
$list_name = $blog_page ? get_the_title( $blog_page ) : __( 'News', 'looksrilanka' );

while ( have_posts() ) :
    the_post();
    $tags = get_the_tags();
    ?>
    <main id="primary" class="ls-page">
        <?php
        get_template_part( 'template-parts/page-hero', null, array(
            'kicker' => get_the_date(),
            'image'  => ls_post_hero_image( get_the_ID() ),
            'crumbs' => array( 'Home' => home_url( '/' ), $list_name => $list_url, get_the_title() => '' ),
            'class'  => 'ls-page-hero-tall',
        ) );
        ?>
        <div class="ls-wrap ls-side-layout ls-article-layout">
            <article class="ls-article ls-prose">
                <?php the_content(); ?>

                <?php if ( $tags ) : ?>
                    <ul class="ls-tags">
                        <?php foreach ( $tags as $tag ) : ?>
                            <li><a href="<?php echo esc_url( get_tag_link( $tag ) ); ?>"><?php echo esc_html( $tag->name ); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <a class="ls-text-link ls-back-link" href="<?php echo esc_url( $list_url ); ?>">&larr; <?php echo esc_html( sprintf( __( 'Back to %s', 'looksrilanka' ), $list_name ) ); ?></a>
            </article>

            <?php
            $recent = get_posts( array(
                'post_type'   => 'news',
                'numberposts' => 4,
                'exclude'     => array( get_the_ID() ),
            ) );
            if ( $recent ) :
                ?>
                <aside class="ls-side ls-article-side">
                    <div class="ls-recent">
                        <h2 class="ls-recent-title"><?php echo esc_html( ls_option( 'nw_recent_heading' ) ?: __( 'Recent Posts', 'looksrilanka' ) ); ?></h2>
                        <ul class="ls-recent-list">
                            <?php foreach ( $recent as $item ) : ?>
                                <li>
                                    <a class="ls-recent-item" href="<?php echo esc_url( get_permalink( $item ) ); ?>">
                                        <span class="ls-recent-thumb"><?php echo ls_post_image( $item->ID, 'thumbnail', array( 'alt' => '', 'sizes' => '84px' ) ); ?></span>
                                        <span class="ls-recent-body">
                                            <span class="ls-recent-name"><?php echo esc_html( get_the_title( $item ) ); ?></span>
                                            <time class="ls-recent-date" datetime="<?php echo esc_attr( get_the_date( 'c', $item ) ); ?>">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 10h18"/></svg>
                                                <?php echo esc_html( get_the_date( '', $item ) ); ?>
                                            </time>
                                        </span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </aside>
            <?php endif; ?>
        </div>

        <?php
        $related = new WP_Query( array(
            'post_type'      => 'news',
            'posts_per_page' => 3,
            'post__not_in'   => array( get_the_ID() ),
            'no_found_rows'  => true,
        ) );
        if ( $related->have_posts() ) :
            ?>
            <section class="ls-section ls-related">
                <div class="ls-wrap">
                    <h2 class="ls-block-title"><?php echo esc_html( ls_option( 'nw_more_heading' ) ?: __( 'More articles', 'looksrilanka' ) ); ?></h2>
                    <div class="ls-grid ls-grid-3">
                        <?php
                        while ( $related->have_posts() ) {
                            $related->the_post();
                            get_template_part( 'template-parts/card-post' );
                        }
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php
        get_template_part( 'template-parts/cta-band', null, array(
            'heading' => ls_option( 'nw_cta_heading' ),
            'text'    => ls_option( 'nw_cta_text' ),
            'button'  => ls_option( 'nw_cta_btn' ),
        ) );
        ?>
    </main>
    <?php
endwhile;

get_footer();
