<?php
/**
 * Green call-to-action band used at the bottom of inner pages.
 * Args: heading, text, button (ACF link).
 */
$args = wp_parse_args( $args, array( 'heading' => '', 'text' => '', 'button' => null ) );

if ( ! $args['heading'] ) {
    return;
}
?>
<section class="ls-section ls-cta-green">
    <div class="ls-wrap">
        <h2><?php echo esc_html( $args['heading'] ); ?></h2>
        <?php if ( $args['text'] ) : ?>
            <p><?php echo esc_html( $args['text'] ); ?></p>
        <?php endif; ?>
        <div class="ls-actions"><?php echo ls_link( $args['button'], 'ls-btn ls-btn-accent' ); ?></div>
    </div>
</section>
