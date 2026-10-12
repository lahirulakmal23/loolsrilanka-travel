<?php
$cards = ls_get( 'hp_ways' );

if ( empty( $cards ) ) {
    return;
}
?>
<section class="ls-section">
    <div class="ls-wrap">
        <?php
        get_template_part( 'template-parts/section-head', null, array(
            'kicker'  => ls_get( 'hp_ways_kicker' ),
            'heading' => ls_get( 'hp_ways_heading' ),
            'intro'   => ls_get( 'hp_ways_intro' ),
        ) );
        ?>
        <div class="ls-exp-grid">
            <?php foreach ( $cards as $card ) : ?>
                <?php $count = ls_count_tokens( $card['count'] ); ?>
                <article class="ls-exp-card">
                    <div class="ls-exp-visual">
                        <?php echo ls_image( $card['image'], 'large', array( 'sizes' => '(max-width: 900px) 100vw, 380px' ) ); ?>
                    </div>
                    <div class="ls-exp-body">
                        <h3>
                            <?php echo esc_html( $card['title'] ); ?>
                            <?php if ( $count ) : ?>
                                <span class="ls-count"><?php echo esc_html( $count ); ?></span>
                            <?php endif; ?>
                        </h3>
                        <?php if ( $card['text'] ) : ?>
                            <p><?php echo esc_html( $card['text'] ); ?></p>
                        <?php endif; ?>
                        <?php echo ls_link( $card['link'], 'ls-exp-link ls-stretched' ); ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
