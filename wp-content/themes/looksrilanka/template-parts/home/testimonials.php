<?php
$reviews = ls_get( 'hp_testimonials' );

if ( empty( $reviews ) ) {
    return;
}
$avatar_colors = array( 'var(--ls-blue)', 'var(--ls-primary-text)', 'var(--ls-navy)' );
?>
<section class="ls-section">
    <div class="ls-wrap">
        <?php
        get_template_part( 'template-parts/section-head', null, array(
            'kicker'  => ls_get( 'hp_testi_kicker' ),
            'heading' => ls_get( 'hp_testi_heading' ),
        ) );
        ?>
        <div class="ls-testi-grid">
            <?php foreach ( $reviews as $i => $review ) : ?>
                <?php $rating = min( 5, max( 1, (int) ( $review['rating'] ?: 5 ) ) ); ?>
                <figure class="ls-testi">
                    <div class="ls-stars" role="img" aria-label="<?php echo esc_attr( sprintf( __( '%d out of 5 stars', 'looksrilanka' ), $rating ) ); ?>">
                        <?php echo str_repeat( '★', $rating ) . '<span class="ls-stars-off">' . str_repeat( '★', 5 - $rating ) . '</span>'; ?>
                    </div>
                    <blockquote><p><?php echo esc_html( $review['quote'] ); ?></p></blockquote>
                    <figcaption class="ls-who-row">
                        <?php if ( $review['photo'] && ls_image_ok( $review['photo'] ) ) : ?>
                            <?php echo ls_image( $review['photo'], 'thumbnail', array( 'class' => 'ls-avatar' ), false ); ?>
                        <?php else : ?>
                            <span class="ls-avatar" style="background:<?php echo esc_attr( $avatar_colors[ $i % 3 ] ); ?>" aria-hidden="true"><?php echo esc_html( ls_initials( $review['name'] ) ); ?></span>
                        <?php endif; ?>
                        <span>
                            <span class="ls-who"><?php echo esc_html( $review['name'] ); ?></span>
                            <?php if ( $review['trip'] ) : ?>
                                <span class="ls-trip-tag"><?php echo esc_html( $review['trip'] ); ?></span>
                            <?php endif; ?>
                        </span>
                    </figcaption>
                </figure>
            <?php endforeach; ?>
        </div>
    </div>
</section>
