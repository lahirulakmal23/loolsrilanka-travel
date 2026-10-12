<?php
/**
 * Article card for blog / news listings (inside the loop).
 */
$image = ls_post_image( get_the_ID(), 'large', array( 'sizes' => '(max-width: 640px) 100vw, 380px', 'alt' => '' ) );
?>
<article class="ls-card ls-post-card">
    <a class="ls-card-visual" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
        <?php echo $image; ?>
    </a>
    <div class="ls-card-body">
        <time class="ls-post-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
        <h2 class="ls-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
        <a class="ls-text-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read article →', 'looksrilanka' ); ?></a>
    </div>
</article>
