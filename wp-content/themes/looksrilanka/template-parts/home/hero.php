<?php
$slides   = ls_get( 'hp_slides' );
$btn_1    = ls_get( 'hp_hero_btn_1' );
$btn_2    = ls_get( 'hp_hero_btn_2' );
$interval = max( 3, (int) ( ls_get( 'hp_hero_interval' ) ?: 6 ) );

if ( empty( $slides ) ) {
    return;
}
$multiple = count( $slides ) > 1;
?>
<section class="ls-hero" data-ls-slider data-interval="<?php echo esc_attr( $interval * 1000 ); ?>" aria-roledescription="carousel" aria-label="<?php esc_attr_e( 'Highlights', 'looksrilanka' ); ?>">
    <?php foreach ( $slides as $i => $slide ) : ?>
        <div class="ls-slide<?php echo 0 === $i ? ' is-active' : ''; ?>" role="group" aria-roledescription="slide" aria-label="<?php echo esc_attr( ( $i + 1 ) . ' / ' . count( $slides ) ); ?>"<?php echo 0 === $i ? '' : ' aria-hidden="true"'; ?>>
            <?php
            echo ls_image( $slide['image'], 'full', array(
                'class'         => 'ls-slide-img',
                'alt'           => '',
                'loading'       => 0 === $i ? 'eager' : 'lazy',
                'fetchpriority' => 0 === $i ? 'high' : 'low',
                'sizes'         => '100vw',
            ) );
            ?>
            <div class="ls-hero-inner">
                <?php if ( $slide['eyebrow'] ) : ?>
                    <div class="ls-hero-eyebrow"><?php echo esc_html( $slide['eyebrow'] ); ?></div>
                <?php endif; ?>

                <?php if ( 0 === $i ) : ?>
                    <h1 class="ls-hero-title"><?php echo esc_html( $slide['heading'] ); ?></h1>
                <?php else : ?>
                    <h2 class="ls-hero-title"><?php echo esc_html( $slide['heading'] ); ?></h2>
                <?php endif; ?>

                <?php if ( $slide['lead'] ) : ?>
                    <p class="ls-hero-lead"><?php echo esc_html( $slide['lead'] ); ?></p>
                <?php endif; ?>

                <?php if ( $slide['badge'] ) : ?>
                    <div class="ls-hero-badge"><?php echo esc_html( $slide['badge'] ); ?></div>
                <?php endif; ?>

                <?php if ( ! empty( $btn_1['url'] ) || ! empty( $btn_2['url'] ) ) : ?>
                    <div class="ls-actions">
                        <?php echo ls_link( $btn_1, 'ls-btn ls-btn-accent' ); ?>
                        <?php echo ls_link( $btn_2, 'ls-btn ls-btn-outline' ); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <?php if ( $multiple ) : ?>
        <div class="ls-hero-controls">
            <div class="ls-dots">
                <?php foreach ( $slides as $i => $slide ) : ?>
                    <button type="button" class="<?php echo 0 === $i ? 'is-active' : ''; ?>" data-ls-go="<?php echo esc_attr( $i ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Go to slide %d', 'looksrilanka' ), $i + 1 ) ); ?>"></button>
                <?php endforeach; ?>
            </div>
            <div class="ls-arrows">
                <button type="button" data-ls-move="-1" aria-label="<?php esc_attr_e( 'Previous slide', 'looksrilanka' ); ?>">&lsaquo;</button>
                <button type="button" data-ls-move="1" aria-label="<?php esc_attr_e( 'Next slide', 'looksrilanka' ); ?>">&rsaquo;</button>
            </div>
        </div>
    <?php endif; ?>
</section>
