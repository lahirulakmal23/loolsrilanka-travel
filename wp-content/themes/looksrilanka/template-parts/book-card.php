<?php
/**
 * Booking sidebar for itineraries and day tours.
 * Args (all optional, default to the itinerary settings under Tour & Listing Pages):
 * price_note, trust (rows with "text"), form (shortcode), customise (ACF link or null), note.
 */
$args = wp_parse_args( $args, array(
    'price_note' => ls_get( 'it_price_note' ),
    'trust'      => ls_option( 'it_trust' ),
    'form'       => '',
    'customise'  => ls_option( 'it_customise_btn' ),
    'note'       => ls_option( 'it_book_note' ),
) );

$price      = ls_get( 'price' );
$price_note = $args['price_note'];
$trust      = array_filter( wp_list_pluck( $args['trust'] ?: array(), 'text' ) );
$form       = ls_form( $args['form'] ?: ( ls_option( 'ls_tour_form' ) ?: '[contact-form-7 id="69fc35b" title="Tour page form"]' ) );
$note       = $args['note'];
$customise  = $args['customise'];
?>
<aside class="ls-side ls-book" id="book">
    <div class="ls-book-card">
        <?php if ( $price ) : ?>
            <div class="ls-book-price">
                <?php echo esc_html( $price ); ?>
                <?php if ( $price_note ) : ?><span><?php echo esc_html( $price_note ); ?></span><?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ( $trust ) : ?>
            <ul class="ls-trust-list">
                <?php foreach ( $trust as $point ) : ?>
                    <li><?php echo esc_html( $point ); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php echo $form; ?>

        <?php echo ls_link( $customise, 'ls-btn ls-btn-ghost ls-btn-block' ); ?>

        <?php if ( $url = ls_whatsapp_url() ) : ?>
            <a class="ls-wa-mini" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener">
                <?php echo ls_whatsapp_svg(); ?>
                <?php esc_html_e( 'Book via WhatsApp instead', 'looksrilanka' ); ?>
            </a>
        <?php endif; ?>

        <?php if ( $note ) : ?>
            <p class="ls-assure"><?php echo esc_html( $note ); ?></p>
        <?php endif; ?>
    </div>
</aside>
