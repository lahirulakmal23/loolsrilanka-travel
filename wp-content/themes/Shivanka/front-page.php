<?php
// Include the header
get_header();
?>
 
    <!-- Main -->
    <main>

        <!-- Hero -->
        <section class="hero" data-aos="fade">
            <h1 class="d-none">Moliva</h1>
            <!-- Video -->
            <div class="hero-video">
                <div class="bg-video bg-overlay ratio ratio-16x9 z-0">
                    <video class="object-fit-cover" poster="<?php echo esc_html( get_field('slider') ); ?>" src="<?php echo esc_html( get_field('slider_video') ); ?>" autoplay loop playsinline muted></video>
                    <div class="bg-content hero-caption">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-12 col-xl-7 col-md-10">
                                    <div class="hero-sub-title">
                                        <span><?php echo esc_html( get_field('title') ); ?></span>
                                    </div>
                                    <h2 class="display-3 hero-title">
                                        <?php echo esc_html( get_field('para') ); ?>
                                    </h2>
                                    <div class="hero-action">
                                        <a href="<?php echo esc_html( get_field('link') ); ?>" class="btn btn-outline-light btn-uppercase mnw-180">
                                            <span>Explore</span>
                                            <i class="hicon hicon-flights-one-ways"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Video -->
          
        </section>
        <!-- /Hero -->

        <!-- Featured -->
        <section class="pt-5 pb-4" data-aos="fade">
            <div class="container">
                <ul class="stats-list row g-0">
                    <li class="col-6 col-xl-3">
                        <div class="stats-item">
                            <h3 class="h1 stats-number">+<?php echo esc_html( get_field('attractive_tours') ); ?></h3>
                            <p class="stats-desc">
                                Attractive tours 
                            </p>
                        </div>
                    </li>
                    <li class="col-6 col-xl-3">
                        <div class="stats-item">
                            <h3 class="h1 stats-number">+<?php echo esc_html( get_field('clients') ); ?></h3>
                            <p class="stats-desc">
                                Clients from<br> around the world
                            </p>
                        </div>
                    </li>
                    <li class="col-6 col-xl-3">
                        <div class="stats-item">
                            <h3 class="h1 stats-number">4.9</h3>
                            <p class="stats-desc">
                                <span class="star-rate-view star-rate-size-sm"><span class="star-value rate-50"></span></span>
                                <br>
                                <span>On Tripadvisor</span>
                            </p>
                        </div>
                    </li>
                    <li class="col-6 col-xl-3">
                        <div class="stats-item">
                            <h3 class="h1 stats-number"><?php echo esc_html( get_field('satisfied') ); ?></h3>
                            <p class="stats-desc">
                                Our clients <br>are satisfied
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
        <!-- /Featured -->

        <!-- About -->
        <section class="p-top-80 p-bottom-80 bg-gray-gradient" data-aos="fade">
            <div class="container">
                <div class="row g-0">
                    <div class="col-12 col-xl-6">
                        <!-- Image -->
                        <div class="pe-xl-5 mb-5 mb-xl-0">
                            <div class="block-title ms-5 mb-5">
                                <small class="sub-title">About us</small>
                                <h2 class="h1 title"><?php echo esc_html( get_field('title_ab') ); ?></h2>
                            </div>
                            <div class="image-info image-info-right image-info-vertical">
                               <!--  <div class="vertical-title">
                                    <small>
                                        <strong class="text-primary fw-semibold">Sine 1993</strong> - <strong class="text-body fw-semibold">31 years</strong> of experience
                                    </small>
                                </div> -->
                                <div class="image-center">
                                    <img src="<?php echo esc_html( get_field('image_1') ); ?>" srcset="<?php echo esc_html( get_field('image_1') ); ?>" class="rounded w-100" alt="">
                                </div>
                                <div class="info-top-right">
                                    <div class="vertical-award rounded shadow-sm">
                                        <div class="award-content">
                                            <img src="<?php echo esc_html( get_field('image_tripadvisor') ); ?>" srcset="<?php echo esc_html( get_field('image_tripadvisor') ); ?>" class="w-100" alt="">
                                        </div>
                                        <div class="award-footer">
                                            <small>Tripadvisor</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Image -->
                    </div>
                    <div class="col-12 col-xl-6">
                        <!-- Content -->
                        <div class="image-info image-info-vertical">
                           <!--  <div class="vertical-title">
                                <small>
                                    <strong class="text-primary fw-semibold">Moliva </strong><span class="text-body">Travel Agency</span>
                                </small>
                            </div> -->
                            <div class="image-center mb-4">
                                <img src="<?php echo esc_html( get_field('image_2') ); ?>" srcset="<?php echo esc_html( get_field('image_2') ); ?>" class="rounded w-100" alt="">
                            </div>
                        </div>
                        <div class="ps-xl-5">
                            <p>
                                <?php echo  get_field('para_ab'); ?>
                            </p>
                            <ul class="strength-list row g-0 pt-2">
                                <?php if( have_rows('strength_list') ): ?>
                                    <?php while( have_rows('strength_list') ): the_row();  
                                        ?>
                                        <li class="col-12 col-md-6">
                                            <div class="strength-item">
                                                <span class="strength-icon">
                                                    <i class="hicon hicon-150 hicon-confirmation-instant"></i>
                                                </span>
                                                <strong class="strength-title"><?php echo acf_esc_html( get_sub_field('strength') ); ?></strong>
                                            </div>
                                        </li>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                                
                            </ul>
                            <div class="pt-3">
                                <a href="<?php echo home_url(); ?>/about" class="btn btn-primary btn-uppercase mnw-180">
                                    <span>Read more</span>
                                    <i class="hicon hicon-flights-one-ways"></i>
                                </a>
                            </div>
                        </div>
                        <!-- /Content -->
                    </div>
                </div>
            </div>
        </section>
        <!-- /About -->

        <!-- Destintions -->
        <section class="p-top-80 p-bottom-80 bg-gray-gradient" data-aos="fade">
            <div class="container">
                <!-- Title -->
                <div class="text-center mb-3 pb-3">
                    <div class="block-title">
                        <small class="sub-title">Many tourists visit</small>
                        <h2 class="h1 title">Top destinations</h2>
                    </div>
                    <div class="extra-info">
                        <strong>+50</strong>
                        <span>Attractive destinations</span>
                    </div>
                </div>
                <!-- T/itle -->
                <!-- Destination list -->
                <div class=" g-1 g-md-3 align-items-center">
                    <div class="row">
                        <?php if( have_rows('add_destination') ): ?>
                            <?php 
                            $counter = 0; // Initialize counter to track position
                            while( have_rows('add_destination') ): the_row(); 
                                // Get sub-field values
                                $image = get_sub_field('image');
                                $title = get_sub_field('title');
                                $tour_count = get_sub_field('tour_count');
                                $link = get_sub_field('link');
                                
                                
                            ?>
                                <div class="col-12 col-xxl-3 col-xl-4 col-md-6 aos-init aos-animate" data-aos="fade">
                                    <!-- Destination -->
                                    <a href="<?php echo esc_url($link); ?>" class="destination destination-center bottom-overlay rounded">
                                        <figure class="image-hover image-hover-overlay image-hover-scale">
                                            <img src="<?php echo esc_url($image['url']); ?>" 
                                                 srcset="<?php echo esc_url($image['sizes']['large']); ?> 2x" alt="<?php echo esc_attr($image['alt']); ?>">
                                        </figure>
                                        <div class="bottom-overlay-content pb-3 pb-md-4">
                                            <div class="destination-icon">
                                                <span class="circle-icon circle-icon-link icon-mobile-small">
                                                    <i class="hicon hicon-flights-pin"></i>
                                                </span>
                                            </div>
                                            <h3 class="destination-title"><?php echo esc_html($title); ?></h3>
                                        </div>
                                        
                                    </a>
                                    <!-- /Destination -->
                                </div>
                            <?php 
                                $counter++; // Increment the counter
                            endwhile; 
                        else: ?>
                            <p>No destinations found.</p>
                        <?php endif; ?>
                     
                         
                </div>
                <div class="text-center pt-5">
                    <a href="<?php echo home_url(); ?>/destination/" class="btn btn-primary btn-uppercase mnw-180">
                        <span>View more</span>
                        <i class="hicon hicon-flights-one-ways"></i>
                    </a>
                </div>
                <!-- Destination list -->
            </div>
        </section>
        <!-- /Destintions -->

        <!-- Tour types -->
        <section class="p-top-80 p-bottom-80 bg-gray-gradient eyw" data-aos="fade">
            <div class="container">
                <!-- Types -->
                <div class="block-title text-center pb-4">
                    <small class="sub-title card-title">Flexible tours</small>
                    <h2 class="h1 title card-title lh-xs">Explore your way</h2>
                </div>
                <!-- /Title -->
                <div class="row g-3 g-xl-4">
                    <div class="col-12 col-xl-4 col-md-6">
                        <a href="<?php echo home_url(); ?>/tailor-made-2/" class="info-card hover-effect shadow-sm text-center rounded">
                            <div class="card-icon wite">
                                <img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/Group-Tour.png">
                            </div>
                            <h3 class="h4 card-title">Group tours</h3>
                            <p class="card-desc"><?php echo esc_html( get_field('group_tours') ); ?></p>
                            <span class="card-link">
                                <span>Start Planning</span>
                                <i class="hicon hicon-flights-one-ways"></i>
                            </span>
                        </a>
                    </div>
                    <div class="col-12 col-xl-4 col-md-6">
                        <a href="<?php echo home_url(); ?>/tour" class="info-card hover-effect active shadow-sm text-center rounded">
                            <div class="card-icon">
                                <img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/Private-Tour.png">
                            </div>
                            <h3 class="h4 card-title">Private tours</h3>
                            <p class="card-desc"><?php echo esc_html( get_field('private_tours') ); ?></p>
                            <span class="card-link">
                                <span>View tours</span>
                                <i class="hicon hicon-flights-one-ways"></i>
                            </span>
                        </a>
                    </div>
                    <div class="col-12 col-xl-4 col-md-6">
                        <a href="<?php echo home_url(); ?>/tailor-made-2/" class="info-card  hover-effect shadow-sm text-center rounded">
                            <div class="card-icon wite">
                                <img src="<?php echo home_url(); ?>/wp-content/uploads/2025/02/Tailor-made.png">
                            </div>
                            <h3 class="h4 card-title">Tailor-Made tours</h3>
                            <p class="card-desc"><?php echo esc_html( get_field('tailor_made_tours') ); ?></p>
                            <span class="card-link">
                                <span>Start Planning</span>
                                <i class="hicon hicon-flights-one-ways"></i>
                            </span>
                        </a>
                    </div>
                </div>
                <!-- /Types -->
            </div>
        </section>
        <!-- /Tour types -->

        <!-- Why -->
        <section class="hero eyw" data-aos="fade">
            <div class="hero-bg">
                <img src="<?php echo get_field('why_choose_us_background_image'); ?>" srcset="<?php echo get_field('why_choose_us_background_image'); ?>" alt="">
            </div>
            <div class="bg-content container">
                <div class="p-top-90 p-bottom-50">
                    <div class="block-title text-center pb-2">
                        <small class="sub-title">Great experience</small>
                        <h2 class="h1 title text-white">Why choose us</h2>
                    </div>
                    <div class="why-slider splide splide__pagination__start w-100 mb-5 mb-xl-0">
                        <div class="splide__track pt-2 pb-2">
                            <ul class="splide__list">
                                 <?php if( have_rows('why_choose_us') ): ?>
                                    <?php  
                                    while( have_rows('why_choose_us') ): the_row(); 
                                        
                                    ?>
                                <li class="splide__slide">
                                    <div class="transparent-card text-center">
                                        <div class="card-icon wite">
                                                <img src="<?php echo get_sub_field('icon_wcu'); ?>">
                                        </div>
                                        <h3 class="h5 card-title">    <?php echo get_sub_field('heading_wcu'); ?> </h3>
                                        <p class="card-desc">
                                                <?php echo get_sub_field('content_wcu'); ?> 
                                        </p>
                                    </div>
                                </li>
                                 <?php  
                            endwhile; 
                             endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Why -->

        <!-- Tours -->
        <section class="p-top-80 p-bottom-80 bg-gray-gradient" data-aos="fade">
            <div class="container">
                <!-- Title -->
                <div class="text-center mb-4">
                    <div class="block-title">
                        <small class="sub-title">Many tourists choose</small>
                        <h2 class="h1 title">Top LSL Tours</h2>
                    </div>
                    <div class="extra-info">
                        <strong>+80K</strong>
                        <span>Tourists have chosen these tours</span>
                    </div>
                </div>
                <!-- /Title -->
                <div class="tour-slider-2 splide mb-5">
                    <div class="splide__arrows">
                        <button class="splide__arrow splide__arrow--prev">
                            <i class="hicon hicon-edge-arrow-left"></i>
                        </button>
                        <button class="splide__arrow splide__arrow--next">
                            <i class="hicon hicon-edge-arrow-right"></i>
                        </button>
                    </div>
                    <!-- Tours list -->
                    <div class="splide__track pt-2 pb-2">
                        <ul class="splide__list tour-grid">
                            
                            <?php
                            $args = array(
                                'post_type'      => 'tour',
                                'posts_per_page' => 50,
                            );
                            $query = new WP_Query($args);
                            
                            if ($query->have_posts()) :
                                while ($query->have_posts()) : $query->the_post();
                                    $tour_title = get_the_title();
                                    $tour_link  = get_permalink();
                                    $tour_image = get_the_post_thumbnail_url();
                                    ?>
                                    <li class="splide__slide">
                                        <div class="tour-item rounded shadow-sm hover-effect">
                                            <div class="tour-img">
                                                <a href="<?php echo esc_url($tour_link); ?>">
                                                    <figure class="image-hover image-hover-overlay">
                                                        <img src="<?php echo $tour_image; ?>" alt="<?php echo esc_attr($tour_title); ?>">
                                                        <i class="hicon hicon-plus-thin image-hover-icon"></i>
                                                    </figure>
                                                </a>
                                            </div>
                                            <div class="tour-content">
                                                <h3 class="tour-title">
                                                    <a href="<?php echo esc_url($tour_link); ?>" class="link-dark link-hover">
                                                        <?php echo esc_html($tour_title); ?>
                                                    </a>
                                                </h3>
                                                <div class="tour-itinerary">
                                                    <span><i class="hicon hicon-menu-calendar"></i> <?php echo esc_html( get_field('days') ); ?> days</span>
                                                    <span><i class="hicon hicon-flights-pin"></i><?php echo esc_html( get_field('destinations') ); ?> Destinations</span>
                                                </div>
                                                <div class="tour-booking">
                                                    <div class="tour-price">
                                                        <strong><?php echo esc_html( get_field('price') ); ?></strong> 
                                                    </div>
                                                    <a href="<?php echo esc_url($tour_link); ?>" class="circle-icon circle-icon-link">
                                                        <i class="hicon hicon-flights-one-ways"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>

                            
                        </ul>
                    </div>
                    <!-- /Tour List -->
                </div>
            </div>
        </section>
        <!-- /Tours -->

  

        <!-- Booking -->
        <section class="p-top-120 p-bottom-120 bg-dark-blue" data-aos="fade">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-12 col-xl-8">
                        <div class="text-center">
                            <div class="block-title">
                                <small class="sub-title text-light">Start Exploring</small>
                                <h2 class="h1 title text-white">Are you ready for adventures?</h2>
                            </div>
                            <div class="d-md-inline-flex align-items-md-center">
                                 
                                <a href="<?php echo home_url(); ?>/contact-us" class="btn btn-outline-light btn-uppercase mnw-180 me-2 ms-2 mt-4">
                                    <i class="hicon hicon hicon-email-envelope"></i>
                                    <span>Contact Us</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Booking -->

        <!-- Testimonials -->
        <section class="p-top-80 p-bottom-80 bg-gray-gradient" data-aos="fade">
            <div class="container">
                <!-- Title -->
                <div class="text-center mb-4">
                    <div class="block-title">
                        <small class="sub-title">Genuine Reviews</small>
                        <h2 class="h1 title">Tourists talk about us</h2>
                    </div>
                    <div class="d-lg-inline-flex align-items-lg-center mb-3">
                        <div class="extra-info me-md-4">
                            <strong>+95K</strong>
                            <span>Tour bookings</span>
                        </div>
                        <div class="extra-info me-md-4">
                            <strong>4.9</strong>
                            <span class="fw-medium text-secondary">
                                <span class="star-rate-view star-rate-size-sm"><span class="star-value rate-50"></span></span>
                                <span>(+85K reviews)</span>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- /Title -->
                <div class="testimonials-slider-3 splide mb-5">
                    <!-- Testimonial list -->
                    <div class="splide__track pt-2 pb-2">
                        <ul class="splide__list">
                             <?php if( have_rows('review') ): ?>
                            <?php 
                            $counter = 0; // Initialize counter to track position
                            while( have_rows('review') ): the_row(); 
                                
                            ?>
                                <li class="splide__slide">
                                    <!-- Testimonial -->
                                    <div class="testimonial-above mb-1 hover-effect">
                                        <div class="testimonial-content rounded shadow-sm">
                                            <div class="testimonial-star">
                                                <span class="star-rate-view star-rate-size-sm"><span class="star-value rate-45"></span></span>
                                            </div>
                                            <blockquote class="testimonial-review">
                                                <?php echo get_sub_field('review_ew'); ?>
                                            </blockquote>
                                            <div class="testimonial-name">
                                                <h3 class="h5 mb-0"><?php echo get_sub_field('name_rw'); ?></h3>
                                                <span><?php echo get_sub_field('place_rw'); ?></span>
                                            </div>
                                        </div>
                                        <div class="testimonial-avatar shadow-sm">
                                            <img src="<?php echo get_sub_field('image_rw'); ?>" srcset="<?php echo get_sub_field('image_rw'); ?>" alt="">
                                            <span class="testimonial-icon">
                                                <i class="hicon hicon-message-right"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <!-- /Testimonial -->
                                </li>
                            <?php 
                                $counter++; // Increment the counter
                            endwhile; 
                        else: ?>
                            <p>No testimonials found.</p>
                        <?php endif; ?>
                            
                            
                        </ul>
                    </div>
                    <!-- Testimonial list -->
                </div>
            </div>
        </section>
        <!-- /testimonials -->

 

    </main>
    <!-- /Main -->

<!-- Footer -->
<?php get_footer(); ?>