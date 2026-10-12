<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

    <?php if ( ls_get( 'enable_preloader' ) ) : ?>
    <div id="preloader" class="ls-preloader" aria-hidden="true"><span></span></div>
    <?php endif; ?>

    <a class="ls-skip" href="#main"><?php esc_html_e( 'Skip to content', 'looksrilanka' ); ?></a>

    <?php
    $logo = ls_option( 'header_logo' );
    $cta  = ls_option( 'ls_header_cta' );
    ?>
    <header class="ls-header">
        <div class="ls-navbar">
            <a class="ls-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <?php if ( $logo ) : ?>
                    <?php echo ls_image( $logo, 'medium', array( 'alt' => get_bloginfo( 'name' ), 'loading' => 'eager' ) ); ?>
                <?php else : ?>
                    <?php bloginfo( 'name' ); ?>
                <?php endif; ?>
            </a>

            <nav class="ls-nav" aria-label="<?php esc_attr_e( 'Main', 'looksrilanka' ); ?>">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'header-menu',
                    'menu_class'     => 'ls-menu',
                    'container'      => false,
                    'depth'          => 2,
                    'fallback_cb'    => false,
                ) );
                ?>
            </nav>

            <?php echo ls_link( $cta, 'ls-nav-cta' ); ?>

            <button class="ls-burger" type="button" aria-expanded="false" aria-controls="ls-mobile-menu" aria-label="<?php esc_attr_e( 'Open menu', 'looksrilanka' ); ?>">
                <span></span><span></span><span></span>
            </button>
        </div>

        <div class="ls-mobile-menu" id="ls-mobile-menu" hidden>
            <?php
            wp_nav_menu( array(
                'theme_location' => 'header-menu',
                'menu_class'     => 'ls-mobile-list',
                'container'      => false,
                'depth'          => 2,
                'fallback_cb'    => false,
            ) );
            echo ls_link( $cta, 'ls-btn ls-btn-primary' );
            ?>
        </div>
    </header>

    <div id="main" tabindex="-1"></div>
