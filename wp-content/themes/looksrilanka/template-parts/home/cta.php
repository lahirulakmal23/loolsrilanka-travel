<?php
$heading = ls_get( 'hp_cta_heading' );

if ( ! $heading ) {
    return;
}
$text  = ls_get( 'hp_cta_text' );
$image = ls_get( 'hp_cta_image' );
$bg    = $image ? ls_image( $image, 'full', array( 'class' => 'ls-cta-bg', 'alt' => '', 'sizes' => '100vw' ) ) : '';
?>
<section class="ls-section ls-cta-band<?php echo $bg ? ' has-bg' : ''; ?>">
    <?php echo $bg; ?>
    <div class="ls-wrap">
        <h2><?php echo esc_html( $heading ); ?></h2>
        <?php if ( $text ) : ?>
            <p><?php echo esc_html( $text ); ?></p>
        <?php endif; ?>
        <div class="ls-actions"><?php echo ls_link( ls_get( 'hp_cta_btn' ), 'ls-btn ls-btn-primary' ); ?></div>
    </div>
</section>
