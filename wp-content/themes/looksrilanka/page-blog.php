<?php
/**
 * Template Name: Blog
 *
 * Lists the News articles. (The Blog page was already set to this template,
 * but the file was missing, so the page showed nothing.)
 */
get_header();

$news = new WP_Query( array(
    'post_type'      => 'news',
    'posts_per_page' => 9,
    'paged'          => max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) ),
) );

get_template_part( 'template-parts/listing-news', null, array( 'query' => $news ) );

get_footer();
