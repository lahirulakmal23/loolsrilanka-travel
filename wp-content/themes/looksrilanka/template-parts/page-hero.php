<?php
/**
 * Inner-page hero band.
 * Args: kicker, heading, text, image (ACF image value or attachment ID),
 *       crumbs (label => url, last item without url), badges (list), class, after (HTML).
 */
$args = wp_parse_args( $args, array(
    'kicker'  => '',
    'heading' => get_the_title(),
    'text'    => '',
    'image'   => '',
    'crumbs'  => array(),
    'badges'  => array(),
    'class'   => '',
    'after'   => '',
) );

$has_image = ! empty( $args['image'] );
?>
<section class="ls-page-hero<?php echo $has_image ? ' has-image' : ''; ?> <?php echo esc_attr( $args['class'] ); ?>">
    <?php if ( $has_image ) : ?>
        <?php echo ls_image( $args['image'], 'full', array( 'class' => 'ls-page-hero-img', 'alt' => '', 'loading' => 'eager', 'fetchpriority' => 'high', 'sizes' => '100vw' ) ); ?>
    <?php endif; ?>
    <div class="ls-wrap ls-page-hero-inner">
        <?php if ( $args['crumbs'] ) : ?>
            <nav class="ls-crumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'looksrilanka' ); ?>">
                <?php
                $parts = array();
                foreach ( $args['crumbs'] as $label => $url ) {
                    $parts[] = $url
                        ? '<a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>'
                        : '<span aria-current="page">' . esc_html( $label ) . '</span>';
                }
                echo implode( ' <span class="ls-crumb-sep" aria-hidden="true">/</span> ', $parts );
                ?>
            </nav>
        <?php endif; ?>

        <?php if ( $args['kicker'] ) : ?>
            <div class="ls-kicker"><?php echo esc_html( $args['kicker'] ); ?></div>
        <?php endif; ?>

        <h1><?php echo esc_html( wp_strip_all_tags( $args['heading'] ) ); ?></h1>

        <?php if ( $args['text'] ) : ?>
            <p class="ls-page-hero-text"><?php echo esc_html( $args['text'] ); ?></p>
        <?php endif; ?>

        <?php if ( array_filter( $args['badges'] ) ) : ?>
            <ul class="ls-pills">
                <?php foreach ( array_filter( $args['badges'] ) as $badge ) : ?>
                    <li><?php echo esc_html( $badge ); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php echo $args['after']; // Pre-escaped markup from the calling template. ?>
    </div>
</section>
