<?php
/**
 * Multi-day itinerary card (inside the loop).
 */
$id     = get_the_ID();
$days   = (int) ls_get( 'days' );
$route  = ls_route( $id );
$pace   = ls_get( 'it_pace' );
$price  = ls_get( 'price' );
$image  = ls_post_image( $id, 'large', array( 'sizes' => '(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 380px', 'alt' => '' ) );

$filter_tags = array();
if ( $days > 0 ) {
    if ( $days <= 7 ) {
        $filter_tags[] = '5-7-days';
    }
    if ( $days >= 8 && $days <= 11 ) {
        $filter_tags[] = '8-10-days';
    }
    if ( $days >= 11 ) {
        $filter_tags[] = '12-plus-days';
    }
}
$terms = get_the_terms( $id, 'tour-category' );
if ( $terms && ! is_wp_error( $terms ) ) {
    foreach ( $terms as $term ) {
        $filter_tags[] = $term->slug;
        if ( false !== strpos( $term->slug, 'honeymoon' ) ) {
            $filter_tags[] = 'honeymoon';
        }
        if ( false !== strpos( $term->slug, 'family' ) ) {
            $filter_tags[] = 'family';
        }
    }
}
$title_lower = strtolower( get_the_title( $id ) );
if ( false !== strpos( $title_lower, 'honeymoon' ) ) {
    $filter_tags[] = 'honeymoon';
}
if ( false !== strpos( $title_lower, 'family' ) || false !== strpos( $title_lower, 'families' ) ) {
    $filter_tags[] = 'family';
}
$filter_attr = implode( ' ', array_unique( $filter_tags ) );
?>
<article class="ls-card ls-itin-card" data-region="<?php echo esc_attr( $filter_attr ); ?>">
    <a class="ls-card-visual" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
        <?php echo $image; ?>
        <?php if ( $days ) : ?>
            <span class="ls-badge"><?php echo esc_html( sprintf( _n( '%d Day', '%d Days', $days, 'looksrilanka' ), $days ) ); ?></span>
        <?php endif; ?>
    </a>
    <div class="ls-card-body">
        <h2 class="ls-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php if ( $route ) : ?>
            <div class="ls-route" title="<?php echo esc_attr( $route ); ?>"><?php echo esc_html( $route ); ?></div>
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
