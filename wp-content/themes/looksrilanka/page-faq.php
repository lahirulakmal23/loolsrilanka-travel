<?php
/**
 * Template Name: FAQ
 *
 * Each row of the "faq" field is a topic. Q:/A: pairs inside it become
 * separate expandable questions; text without Q: markers is shown as is.
 */
get_header();

while ( have_posts() ) :
    the_post();
    $topics = ls_get( 'faq' ) ?: array();
    ?>
    <main id="primary" class="ls-page ls-faq-page">
        <?php
        get_template_part( 'template-parts/page-hero', null, array(
            'kicker'  => ls_get( 'fq_hero_kicker' ) ?: ls_get( 'sub_title' ),
            'heading' => ls_get( 'fq_hero_heading' ) ?: get_the_title(),
            'text'    => ls_get( 'fq_hero_text' ),
            'image'   => has_post_thumbnail() ? get_post_thumbnail_id() : '',
        ) );
        ?>

        <div class="ls-wrap ls-side-layout ls-side-left">
            <aside class="ls-side">
                <?php if ( count( $topics ) > 1 ) : ?>
                    <nav class="ls-side-card ls-topic-nav" aria-label="<?php esc_attr_e( 'Topics', 'looksrilanka' ); ?>">
                        <h3><?php esc_html_e( 'Topics', 'looksrilanka' ); ?></h3>
                        <ul>
                            <?php foreach ( $topics as $i => $topic ) : ?>
                                <li><a href="#topic-<?php echo esc_attr( $i + 1 ); ?>"><?php echo esc_html( wp_strip_all_tags( $topic['headingfaq'] ) ); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </nav>
                <?php endif; ?>

                <?php if ( $side = ls_get( 'fq_side_text' ) ) : ?>
                    <div class="ls-side-card">
                        <?php if ( $h = ls_get( 'fq_side_heading' ) ) : ?><h3><?php echo esc_html( $h ); ?></h3><?php endif; ?>
                        <p><?php echo esc_html( $side ); ?></p>
                        <?php echo ls_link( ls_get( 'fq_side_btn' ), 'ls-btn ls-btn-primary ls-btn-block' ); ?>
                    </div>
                <?php endif; ?>

                <?php get_template_part( 'template-parts/wa-card', null, array( 'text' => ls_get( 'fq_whatsapp_text' ) ) ); ?>
            </aside>

            <div class="ls-main-col">
                <?php if ( trim( get_the_content() ) ) : ?>
                    <div class="ls-prose ls-block-first"><?php the_content(); ?></div>
                <?php endif; ?>

                <?php foreach ( $topics as $i => $topic ) : ?>
                    <?php $items = ls_parse_faq_html( $topic['contentfaq'] ); ?>
                    <section class="ls-faq-topic" id="topic-<?php echo esc_attr( $i + 1 ); ?>">
                        <h2 class="ls-block-title"><?php echo esc_html( wp_strip_all_tags( $topic['headingfaq'] ) ); ?></h2>
                        <?php if ( $items ) : ?>
                            <?php get_template_part( 'template-parts/faq-list', null, array( 'items' => $items ) ); ?>
                        <?php else : ?>
                            <div class="ls-prose ls-prose-card"><?php echo wp_kses_post( wpautop( $topic['contentfaq'] ) ); ?></div>
                        <?php endif; ?>
                    </section>
                <?php endforeach; ?>
            </div>
        </div>

        <?php
        get_template_part( 'template-parts/cta-band', null, array(
            'heading' => ls_get( 'fq_cta_heading' ),
            'text'    => ls_get( 'fq_cta_text' ),
            'button'  => ls_get( 'fq_cta_btn' ),
        ) );
        ?>
    </main>
    <?php
endwhile;

get_footer();
