<?php
/**
 * Template Name: About us
 */
get_header();

while ( have_posts() ) :
    the_post();
    $story_text  = ls_get( 'lscontent' );
    $guides_text = ls_get( 'rscontent' );
    $stats       = ls_get( 'ab_stats' );
    $values      = ls_get( 'ab_values' );
    $team        = ls_get( 'our_team' );
    ?>
    <main id="primary" class="ls-page ls-about">
        <?php
        get_template_part( 'template-parts/page-hero', null, array(
            'kicker'  => ls_get( 'ab_hero_kicker' ) ?: ls_get( 'sub_title' ),
            'heading' => ls_get( 'ab_hero_heading' ) ?: get_the_title(),
            'text'    => ls_get( 'ab_hero_text' ),
            'image'   => has_post_thumbnail() ? get_post_thumbnail_id() : '',
            'class'   => 'ls-page-hero-tall',
        ) );
        ?>

        <?php if ( $story_text ) : ?>
            <section class="ls-section ls-white">
                <div class="ls-wrap ls-media-row">
                    <?php if ( $img = ls_get( 'ab_story_image' ) ) : ?>
                        <figure class="ls-media-frame"><?php echo ls_image( $img, 'large', array( 'sizes' => '(max-width: 900px) 100vw, 520px' ) ); ?></figure>
                    <?php endif; ?>
                    <div>
                        <?php
                        get_template_part( 'template-parts/section-head', null, array(
                            'kicker'  => ls_get( 'ab_story_kicker' ),
                            'heading' => ls_get( 'ab_story_heading' ),
                            'class'   => 'ls-mb-0',
                        ) );
                        ?>
                        <div class="ls-prose"><?php echo wpautop( wp_kses_post( $story_text ) ); ?></div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if ( $stats ) : ?>
            <section class="ls-stats">
                <dl class="ls-wrap ls-stats-grid">
                    <?php foreach ( $stats as $stat ) : ?>
                        <div><dd><?php echo esc_html( $stat['number'] ); ?></dd><dt><?php echo esc_html( $stat['label'] ); ?></dt></div>
                    <?php endforeach; ?>
                </dl>
            </section>
        <?php endif; ?>

        <?php if ( $values ) : ?>
            <section class="ls-section">
                <div class="ls-wrap">
                    <?php
                    get_template_part( 'template-parts/section-head', null, array(
                        'heading' => ls_get( 'ab_values_heading' ),
                        'intro'   => ls_get( 'ab_values_intro' ),
                    ) );
                    ?>
                    <div class="ls-grid ls-grid-3">
                        <?php foreach ( $values as $value ) : ?>
                            <div class="ls-value-card">
                                <?php echo ls_icon( $value['icon'] ); ?>
                                <h3><?php echo esc_html( $value['title'] ); ?></h3>
                                <p><?php echo esc_html( $value['text'] ); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if ( trim( wp_strip_all_tags( (string) $guides_text ) ) ) : ?>
            <section class="ls-section ls-white">
                <div class="ls-wrap ls-media-row ls-media-row-reverse">
                    <?php if ( $img = ls_get( 'rflimage' ) ) : ?>
                        <figure class="ls-media-frame"><?php echo ls_image( $img, 'large', array( 'sizes' => '(max-width: 900px) 100vw, 520px' ) ); ?></figure>
                    <?php endif; ?>
                    <div>
                        <?php
                        get_template_part( 'template-parts/section-head', null, array(
                            'kicker'  => ls_get( 'ab_guides_kicker' ),
                            'heading' => ls_get( 'ab_guides_heading' ),
                            'class'   => 'ls-mb-0',
                        ) );
                        ?>
                        <div class="ls-prose"><?php echo wp_kses_post( wpautop( $guides_text ) ); ?></div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if ( $team ) : ?>
            <section class="ls-section">
                <div class="ls-wrap">
                    <?php
                    get_template_part( 'template-parts/section-head', null, array(
                        'heading' => ls_get( 'ab_team_heading' ),
                        'intro'   => ls_get( 'ab_team_intro' ),
                    ) );
                    ?>
                    <div class="ls-grid ls-grid-4">
                        <?php foreach ( $team as $member ) : ?>
                            <div class="ls-member">
                                <div class="ls-member-photo">
                                    <?php if ( $member['timage'] && ls_image_ok( $member['timage'] ) ) : ?>
                                        <?php echo ls_image( $member['timage'], 'medium_large', array( 'alt' => $member['tname'] ), false ); ?>
                                    <?php else : ?>
                                        <span aria-hidden="true"><?php echo esc_html( ls_initials( $member['tname'] ) ); ?></span>
                                    <?php endif; ?>
                                </div>
                                <h3><?php echo esc_html( $member['tname'] ); ?></h3>
                                <?php if ( $member['tpostion'] ) : ?><span class="ls-member-role"><?php echo esc_html( $member['tpostion'] ); ?></span><?php endif; ?>
                                <?php if ( $member['content_tm'] ) : ?><p><?php echo esc_html( wp_strip_all_tags( $member['content_tm'] ) ); ?></p><?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php
        get_template_part( 'template-parts/cta-band', null, array(
            'heading' => ls_get( 'ab_cta_heading' ),
            'text'    => ls_get( 'ab_cta_text' ),
            'button'  => ls_get( 'ab_cta_btn' ),
        ) );
        ?>
    </main>
    <?php
endwhile;

get_footer();
