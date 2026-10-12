<?php
$reasons = ls_get( 'hp_why' );
$image   = ls_get( 'hp_why_image' );
$caption = ls_get( 'hp_why_caption' );
$heading = ls_get( 'hp_why_heading' );

if ( empty( $reasons ) && ! $heading ) {
    return;
}
?>
<section class="ls-section ls-why">
    <div class="ls-wrap ls-why-grid">
        <div>
            <?php
            get_template_part( 'template-parts/section-head', null, array(
                'kicker'  => ls_get( 'hp_why_kicker' ),
                'heading' => $heading,
                'class'   => 'ls-mb-0',
            ) );
            ?>
            <?php if ( $reasons ) : ?>
                <ul class="ls-why-list">
                    <?php foreach ( $reasons as $reason ) : ?>
                        <li>
                            <?php echo ls_icon( $reason['icon'] ); ?>
                            <div>
                                <h3><?php echo esc_html( $reason['title'] ); ?></h3>
                                <?php if ( $reason['text'] ) : ?>
                                    <p><?php echo esc_html( $reason['text'] ); ?></p>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <?php
        // An empty field falls back to one of the Theme Settings fallback photos.
        $photo = ls_image( $image, 'large', array(
            'class' => 'ls-why-photo-img',
            'sizes' => '(max-width: 900px) 100vw, 520px',
        ) );
        ?>
        <?php if ( $photo ) : ?>
            <figure class="ls-why-photo">
                <?php echo $photo; ?>
                <?php if ( $caption ) : ?>
                    <figcaption><?php echo esc_html( $caption ); ?></figcaption>
                <?php endif; ?>
            </figure>
        <?php endif; ?>
    </div>
</section>
