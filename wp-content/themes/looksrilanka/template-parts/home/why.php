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
        // Three overlapping photos. An empty field falls back to one of the
        // Theme Settings fallback photos (a different one per slot).
        $photos = array();
        foreach ( array( $image, ls_get( 'hp_why_image_2' ), ls_get( 'hp_why_image_3' ) ) as $i => $value ) {
            $photos[] = ls_image( $value ?: ls_fallback_id( 'why-' . $i ), 'large', array(
                'class' => 'ls-why-photo-img',
                'sizes' => '(max-width: 900px) 70vw, 380px',
            ) );
        }
        $photos = array_filter( $photos );
        ?>
        <?php if ( $photos ) : ?>
            <div class="ls-why-collage">
                <?php foreach ( array_values( $photos ) as $i => $photo ) : ?>
                    <figure class="ls-why-photo ls-why-photo-<?php echo esc_attr( $i + 1 ); ?>">
                        <?php echo $photo; ?>
                        <?php if ( $caption && $i === count( $photos ) - 1 ) : ?>
                            <figcaption><?php echo esc_html( $caption ); ?></figcaption>
                        <?php endif; ?>
                    </figure>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
