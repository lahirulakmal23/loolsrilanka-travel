<?php
$footer_logo = ls_option( 'footer_logo' );
$footer_background = ls_option( 'ls_footer_background' );
if ( ! $footer_background ) {
    $footer_artwork = get_posts( array(
        'post_type' => 'attachment',
        'post_status' => 'inherit',
        'name' => 'welcome-to-sri-lanka',
        'posts_per_page' => 1,
        'fields' => 'ids',
        'no_found_rows' => true,
    ) );
    $footer_background = $footer_artwork[0] ?? 0;
}
$phone       = ls_option( 'phone_number' );
$email       = ls_option( 'email_address' );
$address     = ls_option( 'address' );
$social      = ls_option( 'ls_social' );
$legal       = ls_option( 'ls_footer_legal' );
$note        = ls_option( 'ls_footer_note' );
$whatsapp    = preg_replace( '/\D/', '', (string) ls_option( 'ls_whatsapp' ) );
$wa_message  = ls_option( 'ls_whatsapp_message' );
$wa_faqs     = array();
$wa_answers  = array();
foreach ( (array) ls_option( 'ls_whatsapp_faqs' ) as $wa_faq ) {
    if ( is_array( $wa_faq ) && isset( $wa_faq['question'] ) && '' !== trim( (string) $wa_faq['question'] ) ) {
        $wa_faqs[] = trim( (string) $wa_faq['question'] );
        $wa_answers[ trim( (string) $wa_faq['question'] ) ] = trim( (string) ( $wa_faq['answer'] ?? '' ) );
    }
}
?>
    <footer class="ls-footer">
        <div class="ls-wrap ls-foot-grid">
        <?php if ( $footer_background ) : ?>
            <?php echo ls_image( $footer_background, 'full', array( 'class' => 'ls-foot-background', 'alt' => '', 'aria-hidden' => 'true', 'loading' => 'lazy', 'fetchpriority' => 'low', 'sizes' => '100vw' ), false ); ?>
        <?php endif; ?>
            <div class="ls-foot-brand">
                <a class="ls-foot-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <?php if ( $footer_logo ) : ?>
                        <?php echo ls_image( $footer_logo, 'medium', array( 'alt' => get_bloginfo( 'name' ), 'sizes' => '260px' ), false ); ?>
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
        <a class="ls-wa" href="<?php echo esc_url( 'https://wa.me/' . $whatsapp . ( $wa_message ? '?text=' . rawurlencode( $wa_message ) : '' ) ); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Chat on WhatsApp', 'looksrilanka' ); ?>"<?php if ( $wa_faqs ) : ?> aria-haspopup="dialog" aria-controls="ls-wa-dialog"<?php endif; ?>>
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a10 10 0 00-8.6 15.1L2 22l5-1.3A10 10 0 1012 2zm5.9 14.2c-.2.6-1.4 1.2-1.9 1.3-.5.1-1.1.1-1.8-.1-.4-.1-1-.3-1.6-.6-2.9-1.3-4.7-4.2-4.9-4.4-.1-.2-1.2-1.6-1.2-3 0-1.4.7-2.1 1-2.4.3-.3.6-.3.8-.3h.6c.2 0 .4 0 .6.5.2.6.7 1.9.8 2 .1.2.1.4 0 .6-.1.2-.2.3-.4.5-.2.2-.4.4-.5.6-.2.2-.4.4-.2.7.2.3 1 1.6 2.1 2.6 1.4 1.3 2.6 1.7 3 1.9.3.2.5.1.7-.1.2-.2.9-1 1.1-1.4.2-.4.4-.3.7-.2.3.1 1.8.9 2.1 1 .3.2.5.2.6.3.1.2.1.9-.1 1.5z"/></svg>
        </a>
    <?php endif; ?>

    <?php if ( $whatsapp && $wa_faqs ) : ?>
        <dialog class="ls-wa-dialog" id="ls-wa-dialog" aria-labelledby="ls-wa-title" aria-describedby="ls-wa-description" aria-modal="false">
            <header class="ls-wa-chat-header">
                <h2 id="ls-wa-title"><?php esc_html_e( 'LSL Adventure Assistance', 'looksrilanka' ); ?></h2>
                <p id="ls-wa-description"><?php esc_html_e( 'How can we help you today?', 'looksrilanka' ); ?></p>
                <button type="button" class="ls-wa-close" aria-label="<?php esc_attr_e( 'Close chat', 'looksrilanka' ); ?>">&times;</button>
            </header>
            <div class="ls-wa-chat-messages" role="log" aria-live="polite" aria-label="<?php esc_attr_e( 'Chat messages', 'looksrilanka' ); ?>">
                <div class="ls-wa-chat-bubble">
                    <p><?php esc_html_e( 'Hello! We can help you plan your Sri Lanka trip. Choose a quick question below, or chat directly with our team on WhatsApp.', 'looksrilanka' ); ?></p>
                    <?php if ( $about_page = get_page_by_path( 'about-us' ) ) : ?>
                        <a href="<?php echo esc_url( get_permalink( $about_page ) ); ?>"><?php esc_html_e( 'Learn more about us', 'looksrilanka' ); ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <form class="ls-wa-chat-form" action="<?php echo esc_url( 'https://wa.me/' . $whatsapp ); ?>" method="get" target="_blank" rel="noopener noreferrer">
                <input type="hidden" id="ls-wa-question" name="text" value="<?php echo esc_attr( $wa_message ); ?>">
                <div class="ls-wa-quick-questions">
                    <h3><?php esc_html_e( 'Quick Questions', 'looksrilanka' ); ?></h3>
                    <div class="ls-wa-question-list" id="ls-wa-question-list">
                        <?php foreach ( $wa_faqs as $wa_index => $wa_question ) : ?>
                            <button type="button" class="ls-wa-question"<?php echo $wa_index >= 4 ? ' hidden' : ''; ?> aria-pressed="false" data-ls-wa-question="<?php echo esc_attr( $wa_question ); ?>" data-ls-wa-answer-text="<?php echo esc_attr( $wa_answers[ $wa_question ] ?? '' ); ?>"><?php echo esc_html( $wa_question ); ?></button>
                        <?php endforeach; ?>
                    </div>
                    <?php if ( count( $wa_faqs ) > 4 ) : ?>
                        <button type="button" class="ls-wa-more-questions" data-ls-wa-more aria-expanded="false" aria-controls="ls-wa-question-list" data-label-more="<?php esc_attr_e( 'Show all questions', 'looksrilanka' ); ?>" data-label-fewer="<?php esc_attr_e( 'Show fewer questions', 'looksrilanka' ); ?>"><?php esc_html_e( 'Show all questions', 'looksrilanka' ); ?></button>
                    <?php endif; ?>
                </div>
                <div class="ls-wa-chat-footer">
                    <p><?php esc_html_e( 'For other questions, chat directly with us on WhatsApp.', 'looksrilanka' ); ?></p>
                    <button class="ls-wa-submit" type="submit"><?php echo ls_whatsapp_svg(); ?> <span><?php esc_html_e( 'Continue in WhatsApp', 'looksrilanka' ); ?></span></button>
                </div>
            </form>
        </dialog>
    <?php endif; ?>

    <?php wp_footer(); ?>
</body>
</html>
