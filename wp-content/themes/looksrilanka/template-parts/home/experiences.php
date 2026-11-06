<?php
/**
 * Home: Curated Experiences (escapades).
 */
$show = ls_get( 'hp_exp_show' );
if ( null !== $show && ! $show ) {
    return;
}

$kicker  = ls_get( 'hp_exp_kicker' ) ?: __( 'Unforgettable Moments', 'looksrilanka' );
$heading = ls_get( 'hp_exp_heading' ) ?: __( 'Curated Sri Lankan Experiences', 'looksrilanka' );
$intro   = ls_get( 'hp_exp_intro' ) ?: __( 'From surfing tropical breaks and wildlife safaris to sacred ancient temples and tea country treks — discover activities that make your trip extraordinary.', 'looksrilanka' );

$exp_link = ls_get( 'hp_exp_link' );
if ( empty( $exp_link ) || empty( $exp_link['url'] ) ) {
    $archive_url = get_post_type_archive_link( 'escapades' );
    if ( ! $archive_url ) {
        $archive_url = home_url( '/experiences/' );
    }
    $exp_link = array(
        'url'    => $archive_url,
        'title'  => __( 'View all experiences', 'looksrilanka' ),
        'target' => '',
    );
}

$chosen = array_filter( array_map( 'intval', (array) ls_get( 'hp_exp_items' ) ) );
$query  = new WP_Query( array(
    'post_type'      => 'escapades',
    'post__in'       => $chosen,
    'orderby'        => $chosen ? 'post__in' : array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
    'posts_per_page' => $chosen ? count( $chosen ) : 6,
    'post_status'    => 'publish',
    'no_found_rows'  => true,
) );
?>
<section class="ls-section ls-home-exp" id="experiences" aria-label="<?php echo esc_attr( $heading ); ?>">
    <div class="ls-wrap">
        <div class="ls-exp-head">
            <?php
            get_template_part( 'template-parts/section-head', null, array(
                'kicker'  => $kicker,
                'heading' => $heading,
                'intro'   => $intro,
                'class'   => 'ls-mb-0',
            ) );
            ?>
            <?php if ( ! empty( $exp_link['url'] ) ) : ?>
                <a class="ls-exp-all-btn" href="<?php echo esc_url( $exp_link['url'] ); ?>"<?php echo ! empty( $exp_link['target'] ) ? ' target="' . esc_attr( $exp_link['target'] ) . '"' : ''; ?>>
                    <span><?php echo esc_html( $exp_link['title'] ?: __( 'View all experiences', 'looksrilanka' ) ); ?></span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
            <?php endif; ?>
        </div>

        <div class="ls-grid ls-grid-3 ls-exp-cards-grid">
            <?php
            if ( $query->have_posts() ) :
                while ( $query->have_posts() ) :
                    $query->the_post();
                    $id     = get_the_ID();
                    $region = trim( (string) ( ls_get( 'ds_region', $id ) ?: ls_get( 'ex_category', $id ) ) );
                    $image  = ls_post_image( $id, 'large', array( 'sizes' => '(max-width: 640px) 100vw, (max-width: 960px) 50vw, 420px', 'alt' => get_the_title() ) );
                    ?>
                    <article class="ls-card ls-exp-tile">
                        <a class="ls-card-visual ls-exp-tile-visual" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                            <?php echo $image; ?>
                            <?php if ( $region ) : ?>
                                <span class="ls-tag ls-exp-tag"><?php echo esc_html( $region ); ?></span>
                            <?php endif; ?>
                        </a>
                        <div class="ls-card-body ls-exp-tile-body">
                            <h3 class="ls-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p><?php echo esc_html( ls_summary( $id, 'ds_summary', 20 ) ); ?></p>
                            <a class="ls-text-link ls-exp-more-link" href="<?php the_permalink(); ?>">
                                <?php echo esc_html( sprintf( __( 'Explore %s →', 'looksrilanka' ), get_the_title() ) ); ?>
                            </a>
                        </div>
                    </article>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                // Default experiences if none created yet
                $fallbacks = array(
                    array(
                        'title' => __( 'Hot Air Ballooning over Sigiriya', 'looksrilanka' ),
                        'tag'   => __( 'Adventure', 'looksrilanka' ),
                        'text'  => __( 'Glide above the ancient rock fortress, misty jungles, and peaceful lakes at sunrise.', 'looksrilanka' ),
                        'image' => '2025/02/Sigiriya-Home-01.jpg',
                        'link'  => home_url( '/experiences/' ),
                    ),
                    array(
                        'title' => __( 'Yala Wilderness Leopard Safari', 'looksrilanka' ),
                        'tag'   => __( 'Wildlife', 'looksrilanka' ),
                        'text'  => __( 'Track leopards, wild elephants, and sloth bears across the untamed coastal scrub of Yala National Park.', 'looksrilanka' ),
                        'image' => '2024/12/Leopard-Sri-Lanka-scaled.jpg',
                        'link'  => home_url( '/experiences/' ),
                    ),
                    array(
                        'title' => __( 'Surfing & Coastal Escapades in Weligama', 'looksrilanka' ),
                        'tag'   => __( 'Coast & Ocean', 'looksrilanka' ),
                        'text'  => __( 'Ride warm Indian Ocean breaks, explore vibrant coral reefs, and unwind along golden shores.', 'looksrilanka' ),
                        'image' => '2025/02/Weligama-Home-01.jpg',
                        'link'  => home_url( '/experiences/' ),
                    ),
                    array(
                        'title' => __( 'Scenic Hill Country Train Journey', 'looksrilanka' ),
                        'tag'   => __( 'Scenic Route', 'looksrilanka' ),
                        'text'  => __( 'Traverse misty mountains, emerald tea estates, and cascading waterfalls from Kandy to Ella.', 'looksrilanka' ),
                        'image' => '2025/02/Ella-Home.jpg',
                        'link'  => home_url( '/experiences/' ),
                    ),
                    array(
                        'title' => __( 'Sacred Kandy Cultural Heritage Tour', 'looksrilanka' ),
                        'tag'   => __( 'Heritage', 'looksrilanka' ),
                        'text'  => __( 'Witness sacred Buddhist rituals at the Temple of the Tooth and explore royal botanical gardens.', 'looksrilanka' ),
                        'image' => '2025/02/Kandy-Home-01.jpg',
                        'link'  => home_url( '/experiences/' ),
                    ),
                    array(
                        'title' => __( 'Mirissa Blue Whale Watching', 'looksrilanka' ),
                        'tag'   => __( 'Marine Safari', 'looksrilanka' ),
                        'text'  => __( 'Set sail at dawn to witness the world\'s largest creatures gracefully swimming in open waters.', 'looksrilanka' ),
                        'image' => '2025/02/Mirissa-Home-01.jpg',
                        'link'  => home_url( '/experiences/' ),
                    ),
                );
                foreach ( $fallbacks as $fb ) :
                    $fb_att = attachment_url_to_postid( wp_upload_dir()['baseurl'] . '/' . $fb['image'] );
                    $img_html = $fb_att ? ls_image( $fb_att, 'large' ) : '';
                    ?>
                    <article class="ls-card ls-exp-tile">
                        <a class="ls-card-visual ls-exp-tile-visual" href="<?php echo esc_url( $fb['link'] ); ?>" tabindex="-1" aria-hidden="true">
                            <?php if ( $img_html ) : ?>
                                <?php echo $img_html; ?>
                            <?php else : ?>
                                <span class="ls-card-visual-fallback"></span>
                            <?php endif; ?>
                            <?php if ( ! empty( $fb['tag'] ) ) : ?>
                                <span class="ls-tag ls-exp-tag"><?php echo esc_html( $fb['tag'] ); ?></span>
                            <?php endif; ?>
                        </a>
                        <div class="ls-card-body ls-exp-tile-body">
                            <h3 class="ls-card-title"><a href="<?php echo esc_url( $fb['link'] ); ?>"><?php echo esc_html( $fb['title'] ); ?></a></h3>
                            <p><?php echo esc_html( $fb['text'] ); ?></p>
                            <a class="ls-text-link ls-exp-more-link" href="<?php echo esc_url( $fb['link'] ); ?>">
                                <?php echo esc_html( sprintf( __( 'Explore %s →', 'looksrilanka' ), $fb['title'] ) ); ?>
                            </a>
                        </div>
                    </article>
                    <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>
