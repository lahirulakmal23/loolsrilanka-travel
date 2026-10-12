<?php
// Include the header
get_header();

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

 
        <!-- /Featured -->

        <!-- About -->
        <section class="p-top-90 p-bottom-90 bg-gray-gradient" data-aos="fade">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div>
                                <?php the_content(); ?>
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