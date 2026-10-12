<?php
/**
 * Green WhatsApp call-out card. Args: text, class.
 * Hidden when no WhatsApp number is set in Site Settings.
 */
$args = wp_parse_args( $args, array( 'text' => '', 'class' => '' ) );
$url  = ls_whatsapp_url();

if ( ! $url || ! $args['text'] ) {
    return;
}
?>
<a class="ls-wa-card <?php echo esc_attr( $args['class'] ); ?>" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener">
    <?php echo ls_whatsapp_svg(); ?>
    <span><?php echo esc_html( $args['text'] ); ?></span>
</a>
