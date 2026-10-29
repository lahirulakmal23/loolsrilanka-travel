<?php
/**
 * Day tour card (inside the loop).
 * Args: book (true = the "Book" button prefills the booking form on the same page).
 */
$args     = wp_parse_args( $args, array( 'book' => false ) );
$id       = get_the_ID();
$from     = ls_get( 'dt_from' );
$duration = ls_get( 'dt_duration' );
$good_for = ls_get( 'dt_good_for' );
$price    = ls_get( 'price' );
$note     = ls_get( 'dt_price_note' );
$terms    = get_the_terms( $id, 'day-tour-category' );
$cats     = $terms && ! is_wp_error( $terms ) ? wp_list_pluck( $terms, 'slug' ) : array();
?>
<article class="ls-card ls-dt-card" data-region="<?php echo esc_attr( implode( ' ', $cats ) ); ?>">
    <a class="ls-card-visual" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
        <?php echo ls_post_image( $id, 'large', array( 'sizes' => '(max-width: 640px) 100vw, 380px', 'alt' => '' ) ); ?>
        <?php if ( $badge = ls_get( 'dt_badge' ) ) : ?>
            <span class="ls-badge"><?php echo esc_html( $badge ); ?></span>
        <?php endif; ?>
    </a>
    <div class="ls-card-body">
        <h3 class="ls-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <div class="ls-meta">
            <?php if ( $from ) : ?><span><?php echo esc_html( $from ); ?></span><?php endif; ?>
            <?php if ( $duration ) : ?><span><?php echo esc_html( $duration ); ?></span><?php endif; ?>
            <?php if ( ! $from && ! $duration && ( $dest = ls_get( 'destinations' ) ) ) : ?><span><?php echo esc_html( $dest ); ?></span><?php endif; ?>
        </div>
        <p><?php echo esc_html( ls_summary( $id, 'dt_summary', 22 ) ); ?></p>
        <?php if ( $good_for ) : ?>
            <div class="ls-dt-good"><?php echo esc_html( ( ls_option( 'dt_good_for_label' ) ?: 'Good for:' ) . ' ' . $good_for ); ?></div>
        <?php endif; ?>
        <div class="ls-card-foot">
            <?php if ( $price ) : ?>
                <div class="ls-price"><?php echo esc_html( $price ); ?><?php if ( $note ) : ?><span><?php echo esc_html( $note ); ?></span><?php endif; ?></div>
            <?php endif; ?>
            <?php if ( $args['book'] ) : ?>
                <a class="ls-btn-sm" href="#book" data-ls-book="<?php echo esc_attr( wp_strip_all_tags( get_the_title() ) ); ?>"><?php echo esc_html( ls_option( 'dt_book_btn' ) ?: 'Book' ); ?></a>
            <?php else : ?>
                <a class="ls-btn-sm" href="<?php the_permalink(); ?>"><?php echo esc_html( ls_option( 'dt_view_btn' ) ?: 'View Tour Details' ); ?></a>
            <?php endif; ?>
        </div>
    </div>
</article>
