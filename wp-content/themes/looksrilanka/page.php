<?php
/**
 * Default page: hero (featured image + "sub_title") and the page content
 * in a readable column. Used by Privacy Policy, Terms & Conditions, etc.
 */
get_header();

while ( have_posts() ) :
    the_post();
    ?>
    <main id="primary" class="ls-page">
        <?php
        get_template_part( 'template-parts/page-hero', null, array(
            'kicker' => ls_get( 'sub_title' ),
            'image'  => has_post_thumbnail() ? get_post_thumbnail_id() : '',
            'crumbs' => array( 'Home' => home_url( '/' ), get_the_title() => '' ),
        ) );
        ?>
        <div class="ls-wrap">
            <article class="ls-article ls-prose">
                <?php the_content(); ?>
            </article>
        </div>
    </main>
    <?php
endwhile;

get_footer();
