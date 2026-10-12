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

        <figure class="ls-map-panel">
            <?php if ( $image ) : ?>
                <?php echo ls_image( $image, 'large', array( 'sizes' => '(max-width: 900px) 100vw, 480px' ) ); ?>
            <?php else : ?>
                <svg viewBox="0 0 300 420" role="img" aria-label="<?php esc_attr_e( 'Route map of Sri Lanka', 'looksrilanka' ); ?>">
                    <path d="M150 20 C 90 60, 60 140, 80 220 C 95 290, 60 330, 90 380 C 110 410, 190 410, 210 380 C 240 330, 205 290, 220 220 C 240 140, 210 60, 150 20 Z" fill="var(--ls-sand-2)" stroke="var(--ls-blue)" stroke-width="1.5"/>
                    <path d="M150 70 Q120 160 140 250 Q150 320 150 370" stroke="var(--ls-orange)" stroke-width="2" fill="none" stroke-dasharray="1 8" stroke-linecap="round"/>
                    <g fill="var(--ls-blue)" font-size="12" font-family="Inter, sans-serif">
                        <circle cx="150" cy="70" r="5"/><text x="160" y="74">Sigiriya</text>
                        <circle cx="130" cy="180" r="5"/><text x="140" y="184">Kandy</text>
                        <circle cx="150" cy="260" r="5"/><text x="160" y="264">Ella</text>
                        <circle cx="150" cy="370" r="5"/><text x="160" y="374">Galle</text>
                    </g>
                </svg>
            <?php endif; ?>
            <?php if ( $caption ) : ?>
                <figcaption><?php echo esc_html( $caption ); ?></figcaption>
            <?php endif; ?>
        </figure>
    </div>
</section>
