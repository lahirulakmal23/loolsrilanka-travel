<?php
/**
 * Template Name: Day Tours
 *
 * Day tour listing. WordPress uses this file for the page with the slug
 * "day-tours" automatically. Texts are under Theme Settings → Tour & Listing
 * Pages → "Day tours page"; the tours themselves are the Day Tours posts.
 */
get_header();

$tours = new WP_Query( array(
    'post_type'      => 'day-tour',
    'posts_per_page' => -1,
    'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
) );

// Filter buttons: day tour categories that have at least one tour.
$filters = array();
foreach ( $tours->posts as $tour ) {
    $terms = get_the_terms( $tour, 'day-tour-category' );
    foreach ( $terms && ! is_wp_error( $terms ) ? $terms : array() as $term ) {
        $filters[ $term->slug ] = $term->name;
    }
}

$form  = ls_form( ls_option( 'dt_book_form' ) ?: ls_option( 'ls_tour_form' ) );
$steps = array_filter( wp_list_pluck( ls_option( 'dt_steps' ) ?: array(), 'text' ) );
$combo = array_filter( wp_list_pluck( ls_option( 'dt_combos' ) ?: array(), 'text' ) );

while ( have_posts() ) :
    the_post();
    ?>
    <main id="primary" class="ls-page ls-listing ls-day-tours">
        <?php
        get_template_part( 'template-parts/page-hero', null, array(
            'heading' => ls_option( 'dt_list_heading' ) ?: get_the_title(),
            'text'    => ls_option( 'dt_list_text' ),
            'image'   => ls_option( 'dt_list_image' ) ?: ( has_post_thumbnail() ? get_post_thumbnail_id() : '' ),
            'crumbs'  => array( 'Home' => home_url( '/' ), get_the_title() => '' ),
        ) );
        ?>

        <div class="ls-wrap">
            <?php if ( count( $filters ) > 1 ) : ?>
                <div class="ls-filters" data-ls-filter="#ls-dt-grid" role="group" aria-label="<?php esc_attr_e( 'Filter day tours', 'looksrilanka' ); ?>">
                    <button type="button" class="is-active" data-region="all" aria-pressed="true"><?php echo esc_html( ls_option( 'dt_list_all' ) ?: 'All Tours' ); ?></button>
                    <?php foreach ( $filters as $slug => $label ) : ?>
                        <button type="button" data-region="<?php echo esc_attr( $slug ); ?>" aria-pressed="false"><?php echo esc_html( $label ); ?></button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ( $tours->have_posts() ) : ?>
                <div class="ls-grid ls-grid-3" id="ls-dt-grid">
                    <?php
                    while ( $tours->have_posts() ) {
                        $tours->the_post();
                        get_template_part( 'template-parts/card-day-tour', null, array( 'book' => (bool) $form ) );
                    }
                    wp_reset_postdata();
                    ?>
                </div>
            <?php else : ?>
                <p class="ls-empty"><?php esc_html_e( 'No day tours found.', 'looksrilanka' ); ?></p>
            <?php endif; ?>
        </div>

        <?php if ( $form ) : ?>
            <section class="ls-dt-booking" id="book">
                <div class="ls-wrap ls-side-layout">
                    <div>
                        <?php if ( $h = ls_option( 'dt_book_heading' ) ) : ?><h2 class="ls-block-title"><?php echo esc_html( $h ); ?></h2><?php endif; ?>
                        <?php if ( $t = ls_option( 'dt_book_text' ) ) : ?><p class="ls-sub"><?php echo esc_html( $t ); ?></p><?php endif; ?>
                        <p class="ls-dt-selected" hidden><?php echo esc_html( ls_option( 'dt_selected_label' ) ?: 'Selected tour:' ); ?> <strong></strong></p>
                        <?php echo $form; ?>
                        <?php if ( $note = ls_option( 'dt_book_note' ) ) : ?><p class="ls-assure ls-dt-assure"><?php echo esc_html( $note ); ?></p><?php endif; ?>
                    </div>
                    <aside class="ls-side">
                        <?php if ( $steps ) : ?>
                            <div class="ls-side-card">
                                <?php if ( $h = ls_option( 'dt_steps_heading' ) ) : ?><h3><?php echo esc_html( $h ); ?></h3><?php endif; ?>
                                <ol>
                                    <?php foreach ( $steps as $step ) : ?>
                                        <li><?php echo esc_html( $step ); ?></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                        <?php endif; ?>
                        <?php get_template_part( 'template-parts/wa-card', null, array( 'text' => ls_option( 'dt_wa_text' ) ) ); ?>
                    </aside>
                </div>
            </section>
        <?php endif; ?>

        <?php if ( $combo_heading = ls_option( 'dt_combo_heading' ) ) : ?>
            <section class="ls-section ls-cta-green ls-dt-combo">
                <div class="ls-wrap">
                    <h2><?php echo esc_html( $combo_heading ); ?></h2>
                    <?php if ( $t = ls_option( 'dt_combo_text' ) ) : ?><p><?php echo esc_html( $t ); ?></p><?php endif; ?>
                    <?php if ( $combo ) : ?>
                        <ul class="ls-dt-combos">
                            <?php foreach ( $combo as $item ) : ?>
                                <li><?php echo esc_html( $item ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <div class="ls-actions"><?php echo ls_link( ls_option( 'dt_combo_btn' ), 'ls-btn ls-btn-dark' ); ?></div>
                </div>
            </section>
        <?php endif; ?>
    </main>
    <?php
endwhile;

get_footer();
