<?php
// Include the header
get_header();
?>

    <!-- Main -->
    <main>

<!-- Title -->
<section class="hero" data-aos="fade">
    <div class="hero-bg">
        <img src="<?php echo get_field('news_page_banner', 'option'); ?>" 
             srcset="<?php echo get_field('news_page_banner', 'option'); ?>" 
             alt="tours">
    </div>
    <div class="bg-content container">
        <div class="hero-page-title">
            <span class="hero-sub-title">Explore Sri Lanka, Your Way</span>
            <h1 class="display-3 hero-title">News</h1>
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
      

        <!-- Tour grid -->
        <div class="tour-grid">
            <div class="row">
                
                <div class="col-md-12">
                    <div class="row">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <div class="col-12 col-xxl-4 col-xl-4 col-md-6" data-aos="fade">
                            <!-- Tour -->
                            <div class="tour-item rounded shadow-sm hover-effect mb-4">
                                <div class="tour-img">
                                    <a href="<?php the_permalink(); ?>">
                                        <figure class="image-hover image-hover-overlay tourlist" style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>);">
                                             
                                            <i class="hicon hicon-plus-thin image-hover-icon"></i>
                                        </figure>
                                    </a>
                                    <div class="tour-like">
                                        <button type="button" class="circle-icon like-icon liked">
                                            <i class="hicon hicon-favorite-filled"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="tour-content">
                                    <h3 class="tour-title">
                                        <a href="<?php the_permalink(); ?>" class="link-dark link-hover"><?php the_title(); ?></a>
                                    </h3>
                                    
                                    <div class="tour-booking">
                                        
                                        <a href="<?php the_permalink(); ?>" class="circle-icon circle-icon-link">
                                            <i class="hicon hicon-flights-one-ways"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- /Tour -->
                        </div> 
                    <?php endwhile; else : ?>
                        <p>No news found.</p>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
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