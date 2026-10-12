<?php
/**
 * "Things to do" grid from the highlights repeater. Args: heading.
 */
$args       = wp_parse_args( $args, array( 'heading' => __( 'Things to do here', 'looksrilanka' ) ) );
$highlights = array_filter( wp_list_pluck( ls_get( 'highlights' ) ?: array(), 'highlight' ) );

if ( ! $highlights ) {
    return;
}
$icons = array( 'star', 'map', 'leaf', 'heart', 'home', 'clock' );
?>
<section class="ls-block">
    <h2 class="ls-block-title"><?php echo esc_html( $args['heading'] ); ?></h2>
    <ul class="ls-things">
        <?php foreach ( array_values( $highlights ) as $i => $highlight ) : ?>
            <li>
                <?php echo ls_icon( $icons[ $i % count( $icons ) ] ); ?>
                <span><?php echo esc_html( wp_strip_all_tags( $highlight ) ); ?></span>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
