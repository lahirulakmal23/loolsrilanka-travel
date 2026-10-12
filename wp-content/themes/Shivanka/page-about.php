<?php
// Include the header
get_header();
/**
 * Template Name: About us
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
        <section class="p-top-80 p-bottom-80 bg-gray-gradient" data-aos="fade">
            <div class="container">
                <div class="row g-0">
                    
                      
                        <div class="col-12 col-xl-12 text-alingn-center">
                           <div>
                               <?php echo get_field('lscontent'); ?>
                           </div>
                            <div class="pt-3">
                                <a href="<?php echo home_url(); ?>/contact-us" class="btn btn-primary mnw-180">
                                    <i class="hicon hicon-email-envelope"></i>
                                    <span>Let's talk now</span>
                                </a>
                            </div>
                        </div>
                        <!-- /Content -->
                </div>
            </div>
        </section>
        <!-- /About -->

               <!-- Our team -->
        <section class="p-top-80 p-bottom-50 bg-gray-gradient" data-aos="fade">
            <div class="container">
                <div class="team-slider  mb-5">
                    <!-- Title -->
                    <div class="block-title text-center pb-3">
                        <small class="sub-title">Meet our Team</small>
                        <h2 class="h1 title">The Heart behind the Journey</h2>
                    </div>
                    <!-- /Title -->
                    <!-- Team -->
                    <div class=" pt-2 pb-2">
                        <div class="row">
                            <?php if( have_rows('our_team') ): ?>
                            <?php while( have_rows('our_team') ): the_row(); ?>
                            <div class="col-12 col-xl-3 ">
                                <div class="team shadow-sm rounded hover-effect">
                                    <img src="<?php echo get_sub_field('timage'); ?>" srcset="<?php echo get_sub_field('timage'); ?>" alt="">
                                    <div class="team-info">
                                        <h3 class="h5 team-name"><?php echo get_sub_field('tname'); ?></h3>
                                        <span class="team-city"><?php echo get_sub_field('tpostion'); ?></span>
                                        <p class='content_tm'><?php echo get_sub_field('content_tm'); ?></p>
                                    </div>
                                </div>
                            </div>
                          <?php endwhile; endif; ?>
                        </div>
                    </div>
                    <!-- /Team -->
                </div>
            </div>
        </section>
        <!-- /Our team -->

        <section class="p-top-80 p-bottom-80 bg-dark-blue" data-aos="fade">
            <div class="container">
                <div class="row g-0">
                     
                        <div class="col-12 col-xl-6 order-0 order-xl-0">
	                        <div class="block-title  pb-3 white">
		                        <small class="sub-title">Our Guides</small>
		                        <h2 class="h1 title">Crafting Your Journey</h2>
		                    </div>
                           <div class="con-white">
                              <?php echo get_field('rscontent'); ?>
                           </div>
                        </div>
                        <div class="col-12 col-xl-6 order-1 order-xl-1">
                            <div class="image-info image-info-vertical ms-xl-5">
                                <div class="top-0 end-0 me-4 mt-4">
                                     <img src="<?php echo get_field('rflimage'); ?>" srcset="<?php echo get_field('rflimage'); ?>" class="w-100" alt="">
                                </div>
                            </div>
                        </div>
 
                </div>
            </div>
        </section>
            <!-- Our team -->
        <section class="p-top-80 p-bottom-80 bg-gray-gradient" data-aos="fade">
            <div class="container">
                <div class="team-slider  mb-5">
                    <!-- Title -->
                    <div class="block-title text-center pb-3">

                        <small class="sub-title">Makes You Happy</small>
                        <h2 class="h1 title">Crafting Your Sri Lankan Masterpiece</h2>
                         
                    </div>
                    <div class="text-center">
                              <?php echo get_field('muh'); ?>
                           </div>
                           <br>
                    <!-- /Title -->
                    <!-- Team -->
                    <div class=" pt-2 pb-2">
                        <div class="row">
                            <?php if( have_rows('make_you_happy') ): ?>
                            <?php while( have_rows('make_you_happy') ): the_row(); ?>
                            <div class="col-12 col-xl-4 ">
                              
                                    <img src="<?php echo get_sub_field('timage'); ?>" srcset="<?php echo get_sub_field('timage'); ?>" class="w-100" alt="">
                                 
                                 
                            </div>
                          <?php endwhile; endif; ?>
                        </div>
                    </div>
                    <!-- /Team -->
                </div>
            </div>
        </section>
        <!-- /Our team -->
    </main>
    <!-- /Main -->
<!-- Footer -->
<?php get_footer(); ?>