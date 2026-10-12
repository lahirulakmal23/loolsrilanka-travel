<?php
/**
 * Question / answer list using native <details> so it works without JS.
 * Args: items (list of [question, answer]), heading, heading_tag, link (ACF link), class.
 */
$args = wp_parse_args( $args, array( 'items' => array(), 'heading' => '', 'heading_tag' => 'h2', 'link' => null, 'class' => '' ) );

$items = array_filter( (array) $args['items'], function ( $item ) {
    return ! empty( $item['question'] );
} );
if ( ! $items ) {
    return;
}
$tag = in_array( $args['heading_tag'], array( 'h2', 'h3' ), true ) ? $args['heading_tag'] : 'h2';
?>
<div class="ls-faq <?php echo esc_attr( $args['class'] ); ?>">
    <?php if ( $args['heading'] ) : ?>
        <<?php echo $tag; ?> class="ls-block-title"><?php echo esc_html( $args['heading'] ); ?></<?php echo $tag; ?>>
    <?php endif; ?>
    <?php foreach ( $items as $item ) : ?>
        <details class="ls-faq-item">
            <summary><?php echo esc_html( wp_strip_all_tags( $item['question'] ) ); ?></summary>
            <div class="ls-faq-answer"><?php echo wpautop( wp_kses_post( $item['answer'] ) ); ?></div>
        </details>
    <?php endforeach; ?>
    <?php echo ls_link( $args['link'], 'ls-text-link' ); ?>
</div>
