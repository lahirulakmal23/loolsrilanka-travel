<?php
/**
 * Destination card (inside the loop).
 */
$id     = get_the_ID();
$region = trim( (string) ls_get( 'ds_region' ) );
$image  = ls_post_image( $id, 'large', array( 'sizes' => '(max-width: 640px) 100vw, 380px', 'alt' => '' ) );
?>
<article class="ls-card ls-dest-card" data-region="<?php echo esc_attr( sanitize_title( $region ) ); ?>">
    <a class="ls-card-visual" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
        <?php echo $image; ?>
        <?php if ( $region ) : ?>
            <span class="ls-tag"><?php echo esc_html( $region ); ?></span>
        <?php endif; ?>
    </a>
    <div class="ls-card-body">
        <h2 class="ls-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <p><?php echo esc_html( ls_summary( $id, 'ds_summary', 22 ) ); ?></p>
        <a class="ls-text-link" href="<?php the_permalink(); ?>"><?php echo esc_html( sprintf( __( 'Explore %s →', 'looksrilanka' ), get_the_title() ) ); ?></a>
    </div>
</article>
