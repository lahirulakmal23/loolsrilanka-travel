<?php
/**
 * Home page. Every section is edited under Pages → Home → "Home Page (New Design)".
 * A section is skipped entirely when its content is empty.
 */
get_header();
?>

<main class="ls-page ls-home">
    <?php
    get_template_part( 'template-parts/home/hero' );
    get_template_part( 'template-parts/home/trust' );
    get_template_part( 'template-parts/home/ways' );
    get_template_part( 'template-parts/home/why' );
    get_template_part( 'template-parts/home/partner' );
    get_template_part( 'template-parts/home/testimonials' );
    get_template_part( 'template-parts/home/cta' );
    ?>
</main>

<?php get_footer(); ?>
