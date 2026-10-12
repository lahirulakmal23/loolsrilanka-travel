<?php
/**
 * Included / not included box from the inclusions & exclusions fields.
 */
$included = ls_get( 'inclusions' );
$excluded = ls_get( 'exclusions' );

if ( ! trim( wp_strip_all_tags( (string) $included ) ) && ! trim( wp_strip_all_tags( (string) $excluded ) ) ) {
    return;
}
?>
<div class="ls-includes" id="included">
    <?php if ( trim( wp_strip_all_tags( (string) $included ) ) ) : ?>
        <div class="ls-inc ls-inc-yes">
            <h3><?php esc_html_e( 'Included', 'looksrilanka' ); ?></h3>
            <?php echo wp_kses_post( $included ); ?>
        </div>
    <?php endif; ?>
    <?php if ( trim( wp_strip_all_tags( (string) $excluded ) ) ) : ?>
        <div class="ls-inc ls-inc-no">
            <h3><?php esc_html_e( 'Not Included', 'looksrilanka' ); ?></h3>
            <?php echo wp_kses_post( $excluded ); ?>
        </div>
    <?php endif; ?>
</div>
