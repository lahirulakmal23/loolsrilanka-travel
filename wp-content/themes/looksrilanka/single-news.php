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
        <div class="ls-wrap">
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
        </div>

        <?php
        $more = new WP_Query( array(
            'post_type'      => 'news',
            'posts_per_page' => 3,
            'post__not_in'   => array( get_the_ID() ),
            'no_found_rows'  => true,
        ) );
        if ( $more->have_posts() ) :
            ?>
            <section class="ls-section ls-related">
                <div class="ls-wrap">
                    <h2 class="ls-block-title"><?php echo esc_html( ls_option( 'nw_more_heading' ) ?: __( 'More articles', 'looksrilanka' ) ); ?></h2>
                    <div class="ls-grid ls-grid-3">
                        <?php
                        while ( $more->have_posts() ) {
                            $more->the_post();
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
