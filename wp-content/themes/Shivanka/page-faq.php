<?php
// Include the header
get_header();
/**
 * Template Name: FAQ
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
                    <span class="hero-sub-title"><?php echo acf_esc_html( get_field('sub_title') ); ?> </span>
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

 
        <!-- /Featured -->

        <!-- About -->
        <section class="p-top-90 p-bottom-90 bg-gray-gradient" data-aos="fade">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="accordion" id="accordionExample">
                        <?php if( have_rows('faq') ): ?>
                            <?php $a = 0; while( have_rows('faq') ): the_row(); ?>

                          <div class="accordion-item">
                            <h2 class="accordion-header">
                              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $a; ?>" aria-expanded="false" aria-controls="collapse<?php echo $a; ?>">
                                <?php echo get_sub_field('headingfaq'); ?>
                              </button>
                            </h2>
                            <div id="collapse<?php echo $a; ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                              <div class="accordion-body">
                                <?php echo get_sub_field('contentfaq'); ?>
                              </div>
                            </div>
                          </div>
                        <?php $a++; endwhile; endif; ?>
                         
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /About -->

      

    </main>
    <!-- /Main -->
<!-- Footer -->
<?php get_footer(); ?>