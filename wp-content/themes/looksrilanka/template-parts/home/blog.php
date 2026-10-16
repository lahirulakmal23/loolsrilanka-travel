<?php
/**
 * Home: popular blog articles (News). The chosen articles in their set order,
 * or the 3 newest when none are chosen. The first one is shown large.
 */
// The switch is on unless it has been turned off (null = never saved).
$show = ls_get( 'hp_blog_show' );
if ( null !== $show && ! $show ) {
    return;
}

$chosen = array_filter( array_map( 'intval', (array) ls_get( 'hp_blog_items' ) ) );
$query  = new WP_Query( array(
    'post_type'      => 'news',
    'post__in'       => $chosen,
    'orderby'        => $chosen ? 'post__in' : 'date',
    'posts_per_page' => 3,
    'no_found_rows'  => true,
) );

if ( ! $query->have_posts() ) {
    return;
}

$link = ls_get( 'hp_blog_link' );
?>
<section class="ls-section ls-white ls-home-blog">
    <div class="ls-wrap">
        <div class="ls-blog-head">
            <?php
            get_template_part( 'template-parts/section-head', null, array(
                'kicker'  => ls_get( 'hp_blog_kicker' ),
                'heading' => ls_get( 'hp_blog_heading' ),
                'class'   => 'ls-mb-0',
            ) );
            ?>
            <?php echo ls_link( $link, 'ls-blog-all' ); ?>
        </div>

        <div class="ls-blog-layout">
            <?php
            $i = 0;
            while ( $query->have_posts() ) :
                $query->the_post();
                $words   = str_word_count( wp_strip_all_tags( get_the_content() ) );
                $minutes = max( 1, (int) ceil( $words / 200 ) );
                $meta    = sprintf(
                    '<time datetime="%s">%s</time><span aria-hidden="true">·</span><span>%s</span>',
                    esc_attr( get_the_date( 'c' ) ),
                    esc_html( get_the_date() ),
                    esc_html( sprintf( _n( '%d min read', '%d min read', $minutes, 'looksrilanka' ), $minutes ) )
                );
                ?>
                <?php if ( 0 === $i ) : ?>
                    <article class="ls-blog-feature">
                        <a class="ls-blog-feature-link" href="<?php the_permalink(); ?>">
                            <?php echo ls_post_image( get_the_ID(), 'large', array( 'class' => 'ls-blog-img', 'alt' => '', 'sizes' => '(max-width: 900px) 100vw, 640px' ) ); ?>
                            <div class="ls-blog-feature-body">
                                <p class="ls-blog-meta"><?php echo $meta; // Escaped above. ?></p>
                                <h3><?php the_title(); ?></h3>
                                <span class="ls-blog-more"><?php esc_html_e( 'Read article', 'looksrilanka' ); ?></span>
                            </div>
                        </a>
                    </article>
                <?php else : ?>
                    <article class="ls-blog-item">
                        <a class="ls-blog-thumb" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                            <?php echo ls_post_image( get_the_ID(), 'medium_large', array( 'class' => 'ls-blog-img', 'alt' => '', 'sizes' => '(max-width: 640px) 100vw, 220px' ) ); ?>
                        </a>
                        <div class="ls-blog-item-body">
                            <p class="ls-blog-meta"><?php echo $meta; // Escaped above. ?></p>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p class="ls-blog-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
                            <a class="ls-blog-more" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true"><?php esc_html_e( 'Read article', 'looksrilanka' ); ?></a>
                        </div>
                    </article>
                <?php endif; ?>
                <?php
                $i++;
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
    </div>
</section>
