<?php
/**
 * Template Name: Tailor-Made / Plan My Trip
 *
 * The enquiry form is the page content (Contact Form 7 shortcode), so it is
 * still edited in the normal page editor.
 */
get_header();

while ( have_posts() ) :
    the_post();
    $steps = ls_get( 'tm_steps' );
    $inspo = ls_get( 'tm_inspo' );
    ?>
    <main id="primary" class="ls-page ls-tailor">
        <?php
        get_template_part( 'template-parts/page-hero', null, array(
            'kicker'  => ls_get( 'tm_hero_kicker' ) ?: ls_get( 'sub_title' ),
            'heading' => ls_get( 'tm_hero_heading' ) ?: get_the_title(),
            'text'    => ls_get( 'tm_hero_text' ),
            'image'   => has_post_thumbnail() ? get_post_thumbnail_id() : '',
            'class'   => 'ls-page-hero-tall',
        ) );
        ?>

        <?php if ( $steps ) : ?>
            <section class="ls-section ls-white">
                <div class="ls-wrap">
                    <?php
                    get_template_part( 'template-parts/section-head', null, array(
                        'kicker'  => ls_get( 'tm_how_kicker' ),
                        'heading' => ls_get( 'tm_how_heading' ),
                    ) );
                    ?>
                    <ol class="ls-steps">
                        <?php foreach ( $steps as $i => $step ) : ?>
                            <li>
                                <span class="ls-step-num" aria-hidden="true"><?php echo esc_html( str_pad( $i + 1, 2, '0', STR_PAD_LEFT ) ); ?></span>
                                <h3><?php echo esc_html( $step['title'] ); ?></h3>
                                <p><?php echo esc_html( $step['text'] ); ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            </section>
        <?php endif; ?>

        <?php if ( $inspo ) : ?>
            <section class="ls-section">
                <div class="ls-wrap">
                    <?php
                    get_template_part( 'template-parts/section-head', null, array(
                        'kicker'  => ls_get( 'tm_inspo_kicker' ),
                        'heading' => ls_get( 'tm_inspo_heading' ),
                    ) );
                    ?>
                    <div class="ls-grid ls-grid-4 ls-inspo-grid">
                        <?php foreach ( $inspo as $card ) : ?>
                            <?php
                            $tag   = ! empty( $card['link']['url'] ) ? 'a' : 'div';
                            $attrs = 'a' === $tag ? ' href="' . esc_url( $card['link']['url'] ) . '"' : '';
                            ?>
                            <<?php echo $tag . $attrs; ?> class="ls-inspo-card">
                                <?php echo ls_image( $card['image'], 'medium_large', array( 'alt' => '', 'sizes' => '(max-width: 900px) 50vw, 280px' ) ); ?>
                                <span><?php echo esc_html( $card['label'] ); ?></span>
                            </<?php echo $tag; ?>>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <section class="ls-section ls-white" id="plan">
            <div class="ls-wrap ls-side-layout">
                <div class="ls-panel">
                    <?php if ( $h = ls_get( 'tm_form_heading' ) ) : ?><h2 class="ls-block-title"><?php echo esc_html( $h ); ?></h2><?php endif; ?>
                    <?php if ( $t = ls_get( 'tm_form_text' ) ) : ?><p class="ls-sub"><?php echo esc_html( $t ); ?></p><?php endif; ?>
                    <div class="ls-form ls-prose"><?php the_content(); ?></div>
                    <?php if ( $note = ls_get( 'tm_note' ) ) : ?><p class="ls-assure"><?php echo esc_html( $note ); ?></p><?php endif; ?>
                </div>
                <aside class="ls-side">
                    <?php if ( $side = ls_get( 'tm_side_text' ) ) : ?>
                        <div class="ls-side-card">
                            <?php if ( $h = ls_get( 'tm_side_heading' ) ) : ?><h3><?php echo esc_html( $h ); ?></h3><?php endif; ?>
                            <p><?php echo esc_html( $side ); ?></p>
                        </div>
                    <?php endif; ?>
                    <?php get_template_part( 'template-parts/wa-card', null, array( 'text' => ls_get( 'tm_whatsapp_text' ) ) ); ?>
                </aside>
            </div>
        </section>
    </main>
    <?php
endwhile;

get_footer();
