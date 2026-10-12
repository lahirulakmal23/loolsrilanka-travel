<?php
/**
 * Page not found. Text, photo and links are set under
 * Theme Settings → Site Settings → "Page not found (404)".
 */
get_header();

$links = ls_option( 'ls_404_links' ) ?: array();
?>
<main id="primary" class="ls-page">
    <section class="ls-404<?php echo ls_option( 'ls_404_image' ) ? ' has-image' : ''; ?>">
        <?php echo ls_image( ls_option( 'ls_404_image' ), 'full', array( 'class' => 'ls-page-hero-img', 'alt' => '', 'loading' => 'eager' ) ); ?>
        <div class="ls-wrap ls-404-inner">
            <div class="ls-404-code" aria-hidden="true">404</div>
            <h1><?php echo esc_html( ls_option( 'ls_404_heading' ) ?: __( 'This page seems to have wandered off the map', 'looksrilanka' ) ); ?></h1>
            <p><?php echo esc_html( ls_option( 'ls_404_text' ) ?: __( 'The page you are looking for has moved or no longer exists. Try a search, or start from one of these:', 'looksrilanka' ) ); ?></p>

            <form class="ls-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <label class="screen-reader-text" for="ls-404-search"><?php esc_html_e( 'Search', 'looksrilanka' ); ?></label>
                <input id="ls-404-search" type="search" name="s" placeholder="<?php esc_attr_e( 'Search tours, places…', 'looksrilanka' ); ?>">
                <button type="submit" class="ls-btn ls-btn-primary"><?php esc_html_e( 'Search', 'looksrilanka' ); ?></button>
            </form>

            <div class="ls-actions ls-404-links">
                <a class="ls-btn ls-btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'looksrilanka' ); ?></a>
                <?php foreach ( $links as $item ) : ?>
                    <?php echo ls_link( $item['link'], 'ls-btn ls-btn-outline' ); ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>
<?php
get_footer();
