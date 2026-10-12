<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/logos/128x128.png" type="image/png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <?php 
    // Enqueue WordPress styles and scripts
    wp_head(); 
    ?>
</head>
<body <?php body_class(); ?>>

    <?php 
    // Preloader section
    if ( get_field('enable_preloader') ) : 
    ?>
    <div id="preloader">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden"><?php esc_html_e( 'Loading...', 'textdomain' ); ?></span>
        </div>
    </div>
    <?php endif; ?>

    <!-- Header -->
    <header id="header" data-aos="fade">

        <!-- Header Topbar -->
        <div class="header-topbar">
            <div class="container">
                <div class="row g-0">
                    <div class="col-6 col-xl-7 col-md-8">
                        <div class="d-flex align-items-center">
                            <a href="tel:<?php echo esc_attr( get_field('phone_number','option') ); ?>">
                                <i class="hicon hicon-telephone me-1"></i>
                                <span><?php echo esc_html( get_field('phone_number','option') ); ?></span>
                            </a>
                            <span class="vr bg-white d-none d-md-inline ms-3 me-3"></span>
                            <a href="mailto:<?php echo esc_attr( get_field('email_address','option') ); ?>" class="d-none d-md-inline">
                                <i class="hicon hicon-email-envelope me-1"></i>
                                <span><?php echo esc_html( get_field('email_address','option') ); ?></span>
                            </a>
                        </div>
                    </div>
                    <div class="col-6 col-xl-5 col-md-4">
                    	<div class="d-flex justify-content-end sio-mobile">
                         <a href="https://www.instagram.com/lsladventuretours/" target="_blank">
                                <i class="fa fa-instagram"></i>
                            </a> <span class="vr bg-white d-none d-md-inline ms-3 me-3"></span>
                             <a href="https://web.facebook.com/lsladventuretours.srilanka" target="_blank">
                                <i class="fa fa-facebook"></i>
                            </a><span class="vr bg-white d-none d-md-inline ms-3 me-3"></span>
                            <a href="https://www.tiktok.com/@lsladventuretourslk" target="_blank">
                                <i class="fa fa-tiktok"></i>
                            </a><span class="vr bg-white d-none d-md-inline ms-3 me-3"></span>
                            <a href="https://www.tripadvisor.com/Attraction_Review-g297897-d11660643-Reviews-LSL_Adventure_Tours-Negombo_Western_Province.html" target="_blank">
                                <i class="fa fa-tripadvisor" aria-hidden="true"></i>
                            </a>
                         </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Header Topbar -->

        <!-- Header Navbar -->
        <div class="header-navbar">
            <nav class="navbar navbar-expand-xl">
                <div class="container">
                    <button class="navbar-toggler me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                        <i class="hicon hicon-bold hicon-hamburger-menu"></i>
                    </button>
                    <a class="navbar-brand" href="<?php echo home_url(); ?>">
                        <img src="<?php echo get_field('header_logo', 'option'); ?>" alt="<?php bloginfo( 'name' ); ?>">
                    </a>
                    <div class="offcanvas offcanvas-navbar offcanvas-start border-end-0" tabindex="-1" id="offcanvasNavbar">
                        <div class="offcanvas-header border-bottom p-4 p-xl-0">
                            <a href="<?php echo home_url(); ?>" class="d-inline-block mobile-menu-logo">
                                <img src="<?php echo esc_url( get_field('header_logo', 'option') ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                            </a>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas" aria-label="<?php esc_attr_e( 'Close', 'textdomain' ); ?>"></button>
                        </div>
                        <div class="offcanvas-body p-4 p-xl-0">
                            <?php 
                            // Dynamic menu from WordPress
                            wp_nav_menu( array(
                                'theme_location' => 'header-menu',
                                'menu_class'     => 'navbar-nav',
                                'container'      => false,
                            ) ); 
                            ?>
                            <a href='<?php echo home_url(); ?>/tailor-made-2/' class="tailor btn btn-primary btn-uppercase ">Tailor-Made</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <!-- /Header Navbar -->

    </header>
    <!-- /Header -->