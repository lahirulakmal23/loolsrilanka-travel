<?php
$items = ls_get( 'hp_trust' );

if ( empty( $items ) ) {
    return;
}
?>
<div class="ls-trust">
    <ul class="ls-wrap">
        <?php foreach ( $items as $item ) : ?>
            <?php if ( $item['text'] ) : ?>
                <li><?php echo esc_html( $item['text'] ); ?></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>
