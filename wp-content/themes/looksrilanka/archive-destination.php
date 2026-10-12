<?php
// Include the header
get_header();
?>

    <!-- Main -->
    <main>

<!-- Title -->
<section class="hero" data-aos="fade">
    <div class="hero-bg">
        <img src="<?php echo get_field('destination_page_banner', 'option'); ?>" 
             srcset="<?php echo get_field('destination_page_banner', 'option'); ?>" 
             alt="Destinations">
    </div>
    <div class="bg-content container">
        <div class="hero-page-title">
            <span class="hero-sub-title">Discover Sri Lanka, One Gem at a Time</span>
            <h1 class="display-3 hero-title">Destinations</h1>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php the_archive_title(); ?></li>
            </ol>
        </nav>
    </div>
</section>
<!-- /Title -->

<!-- Destination -->
<section class="p-top-90 p-bottom-90 bg-gray-gradient">
    <div class="container">
    <div class="p-bottom-90 text-center"><?php echo get_field('destination_page_content','option'); ?></div>
        <!-- Title -->
        <div class="d-xl-flex align-items-xl-center pb-4" data-aos="fade">
            <div class="block-title me-auto">
                <h2 class="h1 title">Destinations in Sri Lanka</h2>
            </div>
            <div class="extra-info mt-3">
                <strong class="text-body">+<?php echo wp_count_posts('destination')->publish; ?></strong>
                <span class="text-secondary">Attractive destinations</span>
            </div>
        </div>
        <!-- /Title -->

        <!-- Destination list -->
        <div class="row">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="col-12 col-xxl-3 col-xl-4 col-md-6" data-aos="fade">
                    <!-- Destination -->
                    <a href="<?php the_permalink(); ?>" class="destination bottom-overlay hover-effect rounded mb-4">
                        <figure class="image-hover image-hover-overlay" style="background-image:url('<?php echo  get_the_post_thumbnail_url(); ?>');height:250px;background-size: cover;background-position: center;">
                            
                            <i class="hicon hicon-plus-thin image-hover-icon"></i>
                        </figure>
                        <div class="bottom-overlay-content">
                            <div class="destination-content">
                                <div class="destination-info">
                                    <h3 class="destination-title"><?php the_title(); ?></h3>
                                    
                                </div>
                                <span class="circle-icon circle-icon-link">
                                    <i class="hicon hicon-flights-pin"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                    <!-- /Destination -->
                </div>
            <?php endwhile; else : ?>
                <p>No destinations found.</p>
            <?php endif; ?>
        </div>
        <!-- /Destination list -->

        <!-- Pagination -->
        <nav aria-label="Page navigation" class="pt-3 text-center" data-aos="fade">
            <?php 
            the_posts_pagination([
                'mid_size'  => 2,
                'prev_text' => '<i class="hicon hicon-edge-arrow-left"></i>',
                'next_text' => '<i class="hicon hicon-edge-arrow-right"></i>',
                'screen_reader_text' => ' '
            ]); 
            ?>
        </nav>
        <!-- /Pagination -->
    </div>
</section>
<!-- /Destination -->

 

    </main>
    <!-- /Main -->

<!-- Footer -->
<?php get_footer(); ?>