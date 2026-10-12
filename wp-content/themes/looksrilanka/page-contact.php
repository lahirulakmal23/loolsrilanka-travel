<?php
/**
 * Template Name: Contact us
 */
get_header();

while ( have_posts() ) :
    the_post();
    $traveller_form = ls_form( ls_get( 'ct_form_shortcode' ) ?: '[contact-form-7 id="da98f42" title="Contact form 1"]' );
    $agent_form     = ls_form( ls_get( 'ct_agent_shortcode' ) );
    $phone          = ls_option( 'phone_number' );
    $email          = ls_option( 'email_address' );
    $address        = ls_option( 'address' );
    $map            = trim( (string) ls_get( 'ct_map_embed' ) );
    $map_image      = ls_get( 'ct_map_image' );

    $tabs = '';
    if ( $agent_form ) {
        $tabs = sprintf(
            '<div class="ls-path-tabs" role="tablist"><button type="button" role="tab" id="ls-tab-traveller" aria-controls="ls-panel-traveller" aria-selected="true">%s</button><button type="button" role="tab" id="ls-tab-agent" aria-controls="ls-panel-agent" aria-selected="false" tabindex="-1">%s</button></div>',
            esc_html( ls_get( 'ct_form_label' ) ?: __( "I'm a Traveller", 'looksrilanka' ) ),
            esc_html( ls_get( 'ct_agent_label' ) ?: __( "I'm a Travel Agent", 'looksrilanka' ) )
        );
    }
    ?>
    <main id="primary" class="ls-page ls-contact">
        <?php
        get_template_part( 'template-parts/page-hero', null, array(
            'kicker'  => ls_get( 'ct_hero_kicker' ) ?: ls_get( 'sub_title' ),
            'heading' => ls_get( 'ct_hero_heading' ) ?: get_the_title(),
            'text'    => ls_get( 'ct_hero_text' ),
            'image'   => has_post_thumbnail() ? get_post_thumbnail_id() : '',
            'after'   => $tabs,
        ) );
        ?>

        <div class="ls-wrap ls-side-layout ls-side-layout-wide">
            <div class="ls-panel" data-ls-tabs>
                <div id="ls-panel-traveller" role="tabpanel" aria-labelledby="ls-tab-traveller">
                    <?php if ( $h = ls_get( 'ct_form_heading' ) ) : ?><h2 class="ls-block-title"><?php echo esc_html( $h ); ?></h2><?php endif; ?>
                    <?php if ( $t = ls_get( 'ct_form_text' ) ) : ?><p class="ls-sub"><?php echo esc_html( $t ); ?></p><?php endif; ?>
                    <?php echo $traveller_form; ?>
                </div>
                <?php if ( $agent_form ) : ?>
                    <div id="ls-panel-agent" role="tabpanel" aria-labelledby="ls-tab-agent" hidden>
                        <?php if ( $h = ls_get( 'ct_agent_heading' ) ) : ?><h2 class="ls-block-title"><?php echo esc_html( $h ); ?></h2><?php endif; ?>
                        <?php if ( $t = ls_get( 'ct_agent_text' ) ) : ?><p class="ls-sub"><?php echo esc_html( $t ); ?></p><?php endif; ?>
                        <?php echo $agent_form; ?>
                    </div>
                <?php endif; ?>
            </div>

            <aside class="ls-side">
                <?php if ( $phone || $email || $address ) : ?>
                    <div class="ls-side-card">
                        <h3><?php esc_html_e( 'Direct contact', 'looksrilanka' ); ?></h3>
                        <ul class="ls-contact-list">
                            <?php if ( $phone ) : ?>
                                <li>
                                    <svg class="ls-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M22 16.9v3a2 2 0 01-2.2 2 19.8 19.8 0 01-8.6-3.1 19.5 19.5 0 01-6-6A19.8 19.8 0 012.1 4.2 2 2 0 014 2h3a2 2 0 012 1.7c.1.9.3 1.8.6 2.7a2 2 0 01-.4 2.1L8 9.9a16 16 0 006 6l1.4-1.4a2 2 0 012.1-.4c.9.3 1.8.5 2.7.6a2 2 0 011.8 2z"/></svg>
                                    <div>
                                        <a href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
                                        <?php if ( $hours = ls_get( 'ct_hours' ) ) : ?><small><?php echo esc_html( $hours ); ?></small><?php endif; ?>
                                    </div>
                                </li>
                            <?php endif; ?>
                            <?php if ( $email ) : ?>
                                <li>
                                    <svg class="ls-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M4 4h16v16H4z"/><path d="M22 6l-10 7L2 6"/></svg>
                                    <div>
                                        <a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>"><?php echo esc_html( antispambot( $email ) ); ?></a>
                                        <?php if ( $email_2 = ls_get( 'ct_email_2' ) ) : ?><small><?php echo esc_html( $email_2 ); ?></small><?php endif; ?>
                                    </div>
                                </li>
                            <?php endif; ?>
                            <?php if ( $address ) : ?>
                                <li>
                                    <svg class="ls-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    <div><?php echo esc_html( $address ); ?></div>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php get_template_part( 'template-parts/wa-card', null, array( 'text' => ls_get( 'ct_whatsapp_text' ) ) ); ?>

                <?php if ( $map || $map_image ) : ?>
                    <div class="ls-side-card">
                        <?php if ( $h = ls_get( 'ct_map_heading' ) ) : ?><h3><?php echo esc_html( $h ); ?></h3><?php endif; ?>
                        <?php if ( $map ) : ?>
                            <div class="ls-map-embed ls-map-embed-sm"><?php echo ls_kses_embed( $map ); ?></div>
                        <?php else : ?>
                            <?php echo ls_image( $map_image, 'medium_large' ); ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </aside>
        </div>

        <?php if ( ls_get( 'ct_faq' ) ) : ?>
            <section class="ls-section ls-white">
                <div class="ls-wrap">
                    <?php
                    get_template_part( 'template-parts/faq-list', null, array(
                        'items'   => ls_get( 'ct_faq' ),
                        'heading' => ls_get( 'ct_faq_heading' ),
                        'link'    => ls_get( 'ct_faq_link' ),
                        'class'   => 'ls-faq-wide',
                    ) );
                    ?>
                </div>
            </section>
        <?php endif; ?>
    </main>
    <?php
endwhile;

get_footer();
