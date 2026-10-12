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
                    <div class="hero-desc mb-3">
                        <strong class="fs-1 text-white">$ <?php echo esc_html( get_field('price') ); ?></strong>
                    </div>
                    <h1 class="display-3 hero-title mb-2">
                       <?php the_title(); ?>
                    </h1>
                    <div class="fs-5 hero-desc">
                        <span class="me-3"><i class="hicon hicon-menu-calendar"></i> <?php echo esc_html( get_field('days') ); ?> Days</span>
                        <span class="me-3"><i class="hicon hicon-flights-pin"></i> <?php echo esc_html( get_field('destinations') ); ?> Destinations</span>
                    </div>
                   
                </div>
               <!--  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>/tour">Tours</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
                    </ol>
                </nav> -->
            </div>
        </section>
        <!-- /Title -->

      

        <!-- Tour details -->
        <section class="p-top-90 p-bottom-90 bg-gray-gradient">
            <div class="container">
            <div class='row'>
            <div class="col-md-8">
                <!-- Tour Tab -->
                <ul class="nav tab-menu tour-nav shadow-sm mb-4" id="tour-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="overview-tab" data-bs-toggle="pill" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">
                            Overview
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="photos-tab" data-bs-toggle="pill" data-bs-target="#photos" type="button" role="tab" aria-controls="photos" aria-selected="false">
                            Waypoints
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="itinerary-tab" data-bs-toggle="pill" data-bs-target="#itinerary" type="button" role="tab" aria-controls="itinerary" aria-selected="false">
                            Itinerary
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="map-tab" data-bs-toggle="pill" data-bs-target="#map" type="button" role="tab" aria-controls="itinerary" aria-selected="false">
                            Map
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="exclusion-tab" data-bs-toggle="pill" data-bs-target="#exclusion" type="button" role="tab" aria-controls="itinerary" aria-selected="false">
                           Inclusion & Exclusion 
                        </button>
                    </li>
                   
                    
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade" id="map" role="tabpanel" aria-labelledby="map-tab" tabindex="0">
                        <!-- Itinerary -->
                        <div class="card border-0 p-xl-3 shadow-sm" data-aos="fade">
                            <div class="card-body">
                                <div class='map'> <?php echo get_field('iframe'); ?></div>
                            </div>
                        </div>
                    </div>
                    <style>
                    .map iframe{
                        width:100%;
                        height:550px
                    }
                    </style>
                    <div class="tab-pane fade" id="exclusion" role="tabpanel" aria-labelledby="exclusion-tab" tabindex="0">
                        <!-- Itinerary -->
                        <div class="card border-0 p-xl-3 shadow-sm" data-aos="fade">
                            <div class="card-body exclusion">
                            	<div class="d-xl-flex">
                                    <div class="mnw-200">
                                        <h3 class="h4">Inclusions</h3>
                                    </div>
                                    <?php echo get_field('inclusions'); ?>
                                </div>
                                <div class="d-xl-flex">
                                    <div class="mnw-200">
                                        <h3 class="h4">Exclusions</h3>
                                    </div>
                                    <?php echo get_field('exclusions'); ?>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab" tabindex="0">
                        <!-- About -->
                        <div class="card border-0 p-xl-3 shadow-sm" data-aos="fade">
                            <div class="card-body">
                                <div class="d-xl-flex border-bottom pb-3 mb-4">
                                    <div class="mnw-200">
                                        <h3 class="h4">Description</h3>
                                    </div>
                                    <p>
                                       <?php echo esc_html( get_field('description') ); ?>
                                    </p>
                                </div>
                                <div class="d-xl-flex">
                                    <div class="mnw-200">
                                        <h3 class="h4">Highlights</h3>
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
                            </div>
                        </div>
                        <!-- /About -->
                    </div>
                    <div class="tab-pane fade" id="photos" role="tabpanel" aria-labelledby="photos-tab" tabindex="0">
                        <!-- Photos -->
                        <div class="card border-0 p-xl-3 shadow-sm" data-aos="fade">
                            <div class="card-body">
                                <div class="row g-1 align-items-center">
                                  
                                    <?php if( have_rows('gallery') ): ?>
                                        <?php while( have_rows('gallery') ): the_row(); 
                                            ?>
                                            <div class="col-6 col-xl-3">
                                                <a href="<?php echo acf_esc_html( get_sub_field('image_gal') ); ?>" class="glightbox" data-glightbox="title:<?php echo acf_esc_html( get_sub_field('discription_gal') ); ?>" data-gallery="tour-photos">
                                                    <figure class="image-hover image-hover-scale image-hover-overlay rounded">
                                                        <img src="<?php echo acf_esc_html( get_sub_field('image_gal') ); ?>" srcset="<?php echo acf_esc_html( get_sub_field('image_gal') ); ?>" alt="">
                                                        <i class="hicon hicon-zoom-bold image-hover-icon fs-5"></i>
                                                    </figure>
                                                </a>
                                            </div>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                    

                                </div>
                            </div>
                        </div>
                        <!-- /Photos -->
                    </div>
                    <div class="tab-pane fade" id="itinerary" role="tabpanel" aria-labelledby="itinerary-tab" tabindex="0">
                        <!-- Itinerary -->
                        <div class="card border-0 p-xl-3 shadow-sm" data-aos="fade">
                            <div class="card-body">
                                <div class="accordion accordion-flush accordion-itinerary" id="acdItinerary">
                                    <?php if( have_rows('itinerary') ): ?>
                                        <?php $s=1; while( have_rows('itinerary') ): the_row(); ?>
                                        <div class="accordion-item bg-transparent">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#acdContent<?php echo $s; ?>" aria-expanded="false" aria-controls="acdContent1">
                                                    <strong class="rounded-1"><?php echo acf_esc_html( get_sub_field('day') ); ?>:</strong>
                                                    <span><?php echo acf_esc_html( get_sub_field('title_copy') ); ?></span>
                                                </button>
                                            </h2>
                                            <div id="acdContent<?php echo $s; ?>" class="accordion-collapse collapse" data-bs-parent="#acdItinerary">
                                                <div class="accordion-body">
                                                   <?php echo acf_esc_html( get_sub_field('description') ); ?>
                                                </div>
                                            </div>
                                        </div>
                                         <?php $s++; endwhile; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <!-- /Itinerary -->
                    </div>
                   
                </div>
                <!-- Tour Tab -->
            </div>
            <div class="col-md-4">
            <?php echo do_shortcode('[contact-form-7 id="69fc35b" title="Tour page form"]'); ?>
            </div>
            </div>
            </div>
        </section>
        <!-- /Tour details -->

    


 

    </main>
    <!-- /Main -->

<!-- Footer -->
<?php get_footer(); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var field = document.getElementById('page_title');
    if(field){
        field.value = document.title;
    }
});
</script>