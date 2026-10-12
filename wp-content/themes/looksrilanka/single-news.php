<?php
// Include the header
get_header();
?>

    <!-- Main -->
<main>

    <!-- Hero -->
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
                

                <h1 class="display-3 hero-title mb-2">
                    <?php the_title(); ?>
                </h1>

               
            </div>
        </div>
    </section>

    <!-- News Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">

                <!-- Main Content -->
                <div class="col-md-12">

                

                    <!-- Post Content -->
                    <div class="news-content">
                        <?php the_content(); ?>
                    </div>

                    <!-- Tags -->
                    <?php
                    $tags = get_the_tags();
                    if ($tags) :
                    ?>
                        <div class="mt-5">
                            <h5>Tags</h5>

                            <?php foreach ($tags as $tag) : ?>
                                <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"
                                   class="badge bg-primary text-decoration-none me-2 mb-2">
                                    <?php echo esc_html($tag->name); ?>
                                </a>
                            <?php endforeach; ?>

                        </div>
                    <?php endif; ?>

                </div>

               

            </div>
        </div>
    </section>

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