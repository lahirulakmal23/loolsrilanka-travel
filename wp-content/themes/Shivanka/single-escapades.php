<?php
// Include the header
get_header();
?>

    <!-- Main -->
    <main>

   <!-- Title -->
        <section class="hero" data-aos="fade">
            <div class="hero-bg">
                <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
            </div>
            <div class="bg-content container">
                <div class="hero-page-title">
                  
                    <h1 class="display-3 hero-title mb-2">
                        <?php the_title(); ?>
                    </h1>

                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>/destination">Destination</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
                    </ol>
                </nav>
            </div>
        </section>
        <!-- /Title -->
            <!-- Tour details -->
        <section class="p-top-90 p-bottom-90 bg-gray-gradient">
            <div class="container">
                <!-- About -->
                <div class="card border-0 shadow-sm p-xl-2 mb-4" data-aos="fade">
                    <div class="card-body">
                        <div class="border-bottom mb-4 pb-4">
                            <h2 class="text-body-emphasis mb-0">About</h2>
                        </div>
                        <div class="d-lg-flex border-bottom pb-3 mb-4">
                            <div class="mnw-200">
                                <h3 class="h5">Highlights</h3>
                            </div>
                            <ul class="highlight-list checked">
                                <?php if( have_rows('highlights') ): ?>
                                    <?php while( have_rows('highlights') ): the_row(); 
                                        ?>
                                        <li>
                                            <span><strong><?php echo acf_esc_html( get_sub_field('highlight') ); ?></strong></span>
                                        </li>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="d-lg-flex">
                            <div class="mnw-200">
                                <h3 class="h5">Description</h3>
                            </div>
                           <?php the_content(); ?>ZX
                        </div>
                    </div>
                </div>
                <!-- /About -->
                <!-- Photos -->
                <div class="card border-0 shadow-sm p-xl-2 mb-4" data-aos="fade">
                    <div class="card-body">
                        <div class="border-bottom mb-4 pb-4">
                            <h2 class="text-body-emphasis mb-0">
                                Attractions
                            </h2>
                        </div>
                        <div class="row g-3 align-items-center">
                            
                           <?php 
                            if ( have_rows('gallery') ) : 
                              while ( have_rows('gallery') ) : the_row(); ?>
                                <div class="col-6 col-xl-3">
                                  <a href="<?php echo get_sub_field('image'); ?>" class="glightbox" data-gallery="tour-photos" data-glightbox="title:<?php echo acf_esc_html( get_sub_field('discription') ); ?>">
                                    <figure class="image-hover image-hover-scale image-hover-overlay rounded">
                                      <img src="<?php echo get_sub_field('image'); ?>" srcset="<?php echo get_sub_field('image'); ?>" alt="">
                                      <i class="hicon hicon-zoom-bold image-hover-icon fs-5"></i>
                                    </figure>
                                  </a>
                                </div>
                              <?php endwhile; 
                            endif; 
                            ?>

                            
                        </div>
                    </div>
                </div>
                
            </div>
        </section>
        <!-- /Tour details --> 

    </main>
    <!-- /Main -->

<!-- Footer -->
<?php get_footer(); ?>