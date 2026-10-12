<?php
/**
 * Multi-day itinerary card (inside the loop).
 */
$id     = get_the_ID();
$days   = (int) ls_get( 'days' );
$route  = ls_route( $id );
$pace   = ls_get( 'it_pace' );
$price  = ls_get( 'price' );
$image  = ls_post_image( $id, 'large', array( 'sizes' => '(max-width: 860px) 100vw, 560px', 'alt' => '' ) );
?>
<article class="ls-card ls-itin-card">
    <a class="ls-card-visual" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
        <?php echo $image; ?>
        <?php if ( $days ) : ?>
            <span class="ls-badge"><?php echo esc_html( sprintf( _n( '%d Day', '%d Days', $days, 'looksrilanka' ), $days ) ); ?></span>
        <?php endif; ?>
    </a>
    <div class="ls-card-body">
        <h2 class="ls-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php if ( $route ) : ?>
            <div class="ls-route"><?php echo esc_html( $route ); ?></div>
        <?php endif; ?>
        <div class="ls-meta">
            <?php if ( $days ) : ?><span><?php echo esc_html( ls_days_label( $days ) ); ?></span><?php endif; ?>
            <?php if ( $dest = ls_get( 'destinations' ) ) : ?><span><?php echo esc_html( sprintf( __( '%s destinations', 'looksrilanka' ), $dest ) ); ?></span><?php endif; ?>
            <?php if ( $pace ) : ?><span><?php echo esc_html( $pace ); ?></span><?php endif; ?>
        </div>
        <p><?php echo esc_html( ls_summary( $id, 'it_summary' ) ); ?></p>
        <div class="ls-card-foot">
            <?php if ( $price ) : ?>
                <div class="ls-price"><?php echo esc_html( $price ); ?></div>
            <?php endif; ?>
            <a class="ls-btn-sm" href="<?php the_permalink(); ?>"><?php esc_html_e( 'View Itinerary', 'looksrilanka' ); ?></a>
        </div>
    </div>
</article>
