<?php
$heading = ls_get( 'hp_b2b_heading' );

if ( ! ls_get( 'hp_b2b_show' ) || ! $heading ) {
    return;
}

$text     = ls_get( 'hp_b2b_text' );
$partners = array_filter( array_map( 'trim', explode( "\n", (string) ls_get( 'hp_b2b_partners' ) ) ) );
?>
<section class="ls-section ls-b2b">
    <div class="ls-wrap ls-b2b-inner">
        <div>
            <h2><?php echo esc_html( $heading ); ?></h2>
            <?php if ( $text ) : ?>
                <p><?php echo esc_html( $text ); ?></p>
            <?php endif; ?>
            <?php if ( $partners ) : ?>
                <ul class="ls-partners">
                    <?php foreach ( $partners as $partner ) : ?>
                        <li><?php echo esc_html( $partner ); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <?php echo ls_link( ls_get( 'hp_b2b_btn' ), 'ls-btn ls-btn-accent' ); ?>
    </div>
</section>
