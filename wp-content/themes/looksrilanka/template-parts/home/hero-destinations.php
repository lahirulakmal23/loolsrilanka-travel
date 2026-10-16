<?php
/**
 * Home: popular destinations, four cards in their own section after the hero.
 * A slider: the chosen destinations in their set order, or 8 automatically.
 */
// The switch is on unless it has been turned off (null = never saved).
$show = ls_get( 'hp_hdest_show' );
if ( null !== $show && ! $show ) {
    return;
}

$chosen = array_filter( array_map( 'intval', (array) ls_get( 'hp_hdest_items' ) ) );
$query  = new WP_Query( array(
    'post_type'      => 'destination',
    'post__in'       => $chosen,
    'orderby'        => $chosen ? 'post__in' : array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
    'posts_per_page' => $chosen ? count( $chosen ) : 8,
    'no_found_rows'  => true,
) );

if ( ! $query->have_posts() ) {
    return;
}
?>
<section class="ls-hero-dest" aria-label="<?php esc_attr_e( 'Popular destinations', 'looksrilanka' ); ?>">
    <div class="ls-wrap" data-ls-carousel>
        <div class="ls-hdest-head">
            <?php
            // Default text until the fields are saved (null = never saved; an emptied field stays hidden).
            get_template_part( 'template-parts/section-head', null, array(
                'kicker'  => ls_get( 'hp_hdest_kicker' ) ?? __( 'Popular destinations', 'looksrilanka' ),
                'heading' => ls_get( 'hp_hdest_heading' ) ?? __( 'Where travellers love to go', 'looksrilanka' ),
            ) );
            ?>
            <div class="ls-hdest-nav" hidden>
                <button type="button" data-ls-step="-1" aria-label="<?php esc_attr_e( 'Previous destinations', 'looksrilanka' ); ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5M11 6l-6 6 6 6"/></svg>
                </button>
                <button type="button" data-ls-step="1" aria-label="<?php esc_attr_e( 'Next destinations', 'looksrilanka' ); ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </button>
            </div>
        </div>
        <ul class="ls-hdest-row" data-ls-track>
            <?php
            $i = 0;
            while ( $query->have_posts() ) :
                $query->the_post();
                $region = trim( (string) ls_get( 'ds_region' ) );
                ?>
                <li class="ls-hdest" style="--i: <?php echo esc_attr( $i ); ?>">
                    <a class="ls-hdest-link" href="<?php the_permalink(); ?>">
                        <?php echo ls_post_image( get_the_ID(), 'medium_large', array( 'class' => 'ls-hdest-img', 'alt' => '', 'sizes' => '(max-width: 760px) 72vw, 290px' ) ); ?>
                        <?php if ( $region ) : ?>
                            <span class="ls-hdest-tag"><?php echo esc_html( $region ); ?></span>
                        <?php endif; ?>
                        <span class="ls-hdest-body">
                            <span class="ls-hdest-text">
                                <span class="ls-hdest-name"><?php the_title(); ?></span>
                                <span class="ls-hdest-cta"><?php esc_html_e( 'Explore', 'looksrilanka' ); ?></span>
                            </span>
                            <span class="ls-hdest-arrow" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7M9 7h8v8"/></svg>
                            </span>
                        </span>
                    </a>
                </li>
                <?php
                $i++;
            endwhile;
            wp_reset_postdata();
            ?>
        </ul>
    </div>
</section>
