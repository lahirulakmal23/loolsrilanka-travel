<?php
// Include the header
get_header();
/**
 * Template Name: Contact us
 */

?>

    <!-- Main -->    
    <main>

        <!-- Title -->
        <section class="hero" data-aos="fade">
            <div class="hero-bg">
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('full', ['class' => 'img-fluid']); ?>

                <?php else : ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/default-image.jpg" alt="Destination">
                <?php endif; ?>
            </div>
            <div class="bg-content container">
                <div class="hero-page-title">
                    <span class="hero-sub-title"><?php echo acf_esc_html( get_field('sub_title') ); ?></span>
                    <h1 class="display-4 hero-title">
                       <?php the_title(); ?>
                    </h1>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>">Home</a></li> 
                        <li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
                    </ol>
                </nav>
            </div>
        </section>
        <!-- /Title -->

        <!-- About -->
        <section class="bg-gray-gradient p-bottom-90" data-aos="fade">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-xl-6">
                        <!-- Contac Information -->
                        <div class="p-top-90 mb-4">
                            <div class="border-bottom pb-4 mb-4">
                                <h2 class="me-auto mb-0">Ready to help you!</h2>
                            </div>
                            <p class="mb-4">We're here to help and answer any question you might have.</p>
                            <div class="row">
                                <div class="col-12">
                                    <div class="fw-medium mb-3">
                                        <i class="hicon hicon-flights-pin text-primary me-2"></i>
                                        <span><?php echo esc_html( get_field('address','option') ); ?></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="fw-medium mb-3">
                                        <i class="hicon hicon-telephone text-primary me-2"></i>
                                        <span><a href="tel:<?php echo esc_html( get_field('phone_number','option') ); ?>"></a><?php echo esc_html( get_field('phone_number','option') ); ?></a></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="fw-medium mb-3">
                                        <i class="hicon hicon-email-envelope text-primary me-2"></i>
                                        <span><a href="mailto:<?php echo get_field('email_address','option'); ?>"></a><?php echo esc_html( get_field('email_address','option') ); ?></a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Contac Information -->
                    </div>
                    <div class="col-12 col-xl-6">
                        <!-- Contact Form -->
                        <div class="form-contact rounded shadow-sm">
                            <div class="border-bottom pb-4 mb-4">
                                <h2 class="text-white mb-0">Looking for any help?</h2>
                            </div>
                            
                            <?php echo do_shortcode('[contact-form-7 id="da98f42" title="Contact form 1"]'); ?>

                        </div>
                        <!-- /Contact Form -->
                    </div>
                </div>
            </div>
        </section>
        <!-- /About -->

    </main>
    <!-- /Main -->    
<!-- Footer -->
<?php get_footer(); ?>