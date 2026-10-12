<?php
$footer_logo = ls_option( 'footer_logo' );
$phone       = ls_option( 'phone_number' );
$email       = ls_option( 'email_address' );
$address     = ls_option( 'address' );
$social      = ls_option( 'ls_social' );
$legal       = ls_option( 'ls_footer_legal' );
$note        = ls_option( 'ls_footer_note' );
$whatsapp    = preg_replace( '/\D/', '', (string) ls_option( 'ls_whatsapp' ) );
$wa_message  = ls_option( 'ls_whatsapp_message' );
?>
    <footer class="ls-footer">
        <div class="ls-wrap ls-foot-grid">
            <div class="ls-foot-brand">
                <a class="ls-foot-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <?php if ( $footer_logo ) : ?>
                        <?php echo ls_image( $footer_logo, 'medium', array( 'alt' => get_bloginfo( 'name' ) ) ); ?>
                    <?php else : ?>
                        <?php bloginfo( 'name' ); ?>
                    <?php endif; ?>
                </a>
                <?php if ( $about = ls_option( 'ls_footer_about' ) ) : ?>
                    <p><?php echo esc_html( $about ); ?></p>
                <?php endif; ?>
                <?php if ( $social ) : ?>
                    <ul class="ls-social">
                        <?php foreach ( $social as $item ) : ?>
                            <?php if ( empty( $item['url'] ) ) { continue; } ?>
                            <li>
                                <a href="<?php echo esc_url( $item['url'] ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( ucfirst( $item['network'] ) ); ?>">
                                    <?php echo ls_social_icon( $item['network'] ); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <div>
                <h2 class="ls-foot-title"><?php echo esc_html( ls_option( 'ls_footer_explore_title' ) ?: 'Explore' ); ?></h2>
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'footer-explore',
                    'menu_class'     => 'ls-foot-links',
                    'container'      => false,
                    'depth'          => 1,
                    'fallback_cb'    => 'ls_footer_fallback',
                ) );
                ?>
            </div>

            <div>
                <h2 class="ls-foot-title"><?php echo esc_html( ls_option( 'ls_footer_company_title' ) ?: 'Company' ); ?></h2>
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'footer-company',
                    'menu_class'     => 'ls-foot-links',
                    'container'      => false,
                    'depth'          => 1,
                    'fallback_cb'    => 'ls_footer_fallback',
                ) );
                ?>
            </div>

            <div>
                <h2 class="ls-foot-title"><?php echo esc_html( ls_option( 'ls_footer_contact_title' ) ?: 'Reach us' ); ?></h2>
                <ul class="ls-foot-links">
                    <?php if ( $phone ) : ?>
                        <li><a href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></li>
                    <?php endif; ?>
                    <?php if ( $email ) : ?>
                        <li><a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>"><?php echo esc_html( antispambot( $email ) ); ?></a></li>
                    <?php endif; ?>
                    <?php if ( $address ) : ?>
                        <li><?php echo esc_html( $address ); ?></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <div class="ls-wrap ls-foot-bottom">
            <span>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.</span>
            <span class="ls-foot-legal">
                <?php if ( $legal ) : ?>
                    <?php foreach ( $legal as $item ) : ?>
                        <?php echo ls_link( $item['link'] ); ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if ( $note ) : ?>
                    <span><?php echo esc_html( $note ); ?></span>
                <?php endif; ?>
            </span>
        </div>
    </footer>

    <?php if ( $whatsapp ) : ?>
        <a class="ls-wa" href="<?php echo esc_url( 'https://wa.me/' . $whatsapp . ( $wa_message ? '?text=' . rawurlencode( $wa_message ) : '' ) ); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Chat on WhatsApp', 'looksrilanka' ); ?>">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a10 10 0 00-8.6 15.1L2 22l5-1.3A10 10 0 1012 2zm5.9 14.2c-.2.6-1.4 1.2-1.9 1.3-.5.1-1.1.1-1.8-.1-.4-.1-1-.3-1.6-.6-2.9-1.3-4.7-4.2-4.9-4.4-.1-.2-1.2-1.6-1.2-3 0-1.4.7-2.1 1-2.4.3-.3.6-.3.8-.3h.6c.2 0 .4 0 .6.5.2.6.7 1.9.8 2 .1.2.1.4 0 .6-.1.2-.2.3-.4.5-.2.2-.4.4-.5.6-.2.2-.4.4-.2.7.2.3 1 1.6 2.1 2.6 1.4 1.3 2.6 1.7 3 1.9.3.2.5.1.7-.1.2-.2.9-1 1.1-1.4.2-.4.4-.3.7-.2.3.1 1.8.9 2.1 1 .3.2.5.2.6.3.1.2.1.9-.1 1.5z"/></svg>
        </a>
    <?php endif; ?>

    <?php wp_footer(); ?>
</body>
</html>
