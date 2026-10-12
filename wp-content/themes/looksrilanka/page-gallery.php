<?php
/**
 * Template Name: Gallery
 *
 * Photo grid with category filters, search and paging (all client-side in
 * ls.js, so every photo is in the page and still visible without JS).
 * Photos and their categories are the "gl_photos" rows on this page.
 */
get_header();

while ( have_posts() ) :
    the_post();

    $photos = ls_gallery_page_photos( get_the_ID() );

    // Filter buttons: the categories listed on the page first, then any others the photos use.
    $categories = array();
    foreach ( preg_split( '/\r\n|\r|\n/', (string) ls_get( 'gl_categories' ) ) as $label ) {
        if ( trim( $label ) ) {
            $categories[ sanitize_title( $label ) ] = trim( $label );
        }
    }
    $used       = array_filter( array_column( $photos, 'category', 'slug' ) );
    $categories = array_intersect_key( $categories, $used ) + $used;

    $share_btn = ls_get( 'gl_share_btn' );
    if ( empty( $share_btn['url'] ) ) {
        foreach ( (array) ls_option( 'ls_social' ) as $social ) {
            if ( 'instagram' === ( $social['network'] ?? '' ) && ! empty( $social['url'] ) ) {
                $share_btn = array( 'url' => $social['url'], 'title' => 'Follow Us on Instagram', 'target' => '_blank' );
                break;
            }
        }
    }
    ?>
    <main id="primary" class="ls-page ls-gallery-page">
        <?php
        get_template_part( 'template-parts/page-hero', null, array(
            'kicker'  => ls_get( 'gl_hero_kicker' ),
            'heading' => ls_get( 'gl_hero_heading' ) ?: get_the_title(),
            'text'    => ls_get( 'gl_hero_text' ),
            'image'   => has_post_thumbnail() ? get_post_thumbnail_id() : '',
            'crumbs'  => array( 'Home' => home_url( '/' ), get_the_title() => '' ),
        ) );
        ?>

        <div class="ls-wrap ls-gl" data-ls-gallery data-per-page="<?php echo esc_attr( max( 1, (int) ls_get( 'gl_per_page' ) ?: 8 ) ); ?>">
            <?php if ( $photos ) : ?>
                <div class="ls-gl-bar">
                    <?php if ( count( $categories ) > 1 ) : ?>
                        <div class="ls-filters ls-gl-filters" role="group" aria-label="<?php esc_attr_e( 'Filter by category', 'looksrilanka' ); ?>">
                            <button type="button" class="is-active" data-cat="all" aria-pressed="true"><?php echo esc_html( ls_get( 'gl_all_label' ) ?: 'All' ); ?></button>
                            <?php foreach ( $categories as $slug => $label ) : ?>
                                <button type="button" data-cat="<?php echo esc_attr( $slug ); ?>" aria-pressed="false"><?php echo esc_html( $label ); ?></button>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php $placeholder = ls_get( 'gl_search_label' ) ?: 'Search gallery…'; ?>
                    <label class="ls-gl-search">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M20 20l-4-4"/></svg>
                        <input type="search" placeholder="<?php echo esc_attr( $placeholder ); ?>" aria-label="<?php echo esc_attr( $placeholder ); ?>" autocomplete="off">
                    </label>
                </div>

                <?php get_template_part( 'template-parts/photo-grid', null, array( 'photos' => $photos ) ); ?>

                <p class="ls-empty ls-gl-empty" hidden><?php echo esc_html( ls_get( 'gl_empty_text' ) ?: 'No photos match your search.' ); ?></p>
                <nav class="ls-pagination ls-gl-pages" aria-label="<?php esc_attr_e( 'Gallery pages', 'looksrilanka' ); ?>" hidden><div class="nav-links"></div></nav>
            <?php else : ?>
                <p class="ls-empty"><?php echo esc_html( ls_get( 'gl_empty_text' ) ?: 'No photos yet.' ); ?></p>
            <?php endif; ?>
        </div>

        <?php if ( $share_heading = ls_get( 'gl_share_heading' ) ) : ?>
            <section class="ls-gl-share">
                <div class="ls-wrap ls-gl-share-inner">
                    <span class="ls-gl-share-ico" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 8h3l2-3h6l2 3h3a1 1 0 011 1v10a1 1 0 01-1 1H4a1 1 0 01-1-1V9a1 1 0 011-1z"/><circle cx="12" cy="13.5" r="3.5"/></svg>
                    </span>
                    <div class="ls-gl-share-text">
                        <h2><?php echo esc_html( $share_heading ); ?></h2>
                        <?php if ( $share_text = ls_get( 'gl_share_text' ) ) : ?><p><?php echo esc_html( $share_text ); ?></p><?php endif; ?>
                    </div>
                    <?php if ( ! empty( $share_btn['url'] ) ) : ?>
                        <a class="ls-gl-share-btn" href="<?php echo esc_url( $share_btn['url'] ); ?>"<?php echo ! empty( $share_btn['target'] ) ? ' target="_blank" rel="noopener"' : ''; ?>>
                            <?php echo ls_social_icon( 'instagram' ); ?>
                            <?php echo esc_html( $share_btn['title'] ?: 'Follow Us on Instagram' ); ?>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                        </a>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>
    </main>
    <?php
endwhile;

get_footer();
