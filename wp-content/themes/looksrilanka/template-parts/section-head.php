<?php
/**
 * Shared section heading: small label, heading and optional intro.
 * Args: kicker, heading, intro, class.
 */
$args = wp_parse_args( $args, array( 'kicker' => '', 'heading' => '', 'intro' => '', 'class' => '' ) );

if ( ! $args['kicker'] && ! $args['heading'] && ! $args['intro'] ) {
    return;
}
?>
<div class="ls-section-head <?php echo esc_attr( $args['class'] ); ?>">
    <?php if ( $args['kicker'] ) : ?>
        <div class="ls-kicker"><?php echo esc_html( $args['kicker'] ); ?></div>
    <?php endif; ?>
    <?php if ( $args['heading'] ) : ?>
        <h2><?php echo esc_html( $args['heading'] ); ?></h2>
    <?php endif; ?>
    <?php if ( $args['intro'] ) : ?>
        <p><?php echo esc_html( $args['intro'] ); ?></p>
    <?php endif; ?>
</div>
