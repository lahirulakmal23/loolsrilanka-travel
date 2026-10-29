<?php
/**
 * Article card for blog / news listings (inside the loop).
 */
$id      = get_the_ID();
$image   = ls_post_image( $id, 'large', array( 'sizes' => '(max-width: 640px) 100vw, 380px', 'alt' => esc_attr( get_the_title() ) ) );
$author  = get_the_author();
$words   = str_word_count( wp_strip_all_tags( get_the_content() ) );
$minutes = max( 1, (int) ceil( $words / 200 ) );

// Categories / Tags for data-cat and tag badge
$terms = wp_get_object_terms( $id, array( 'category', 'post_tag' ) );
if ( empty( $terms ) || is_wp_error( $terms ) ) {
    $tax_names = get_object_taxonomies( get_post_type() );
    if ( ! empty( $tax_names ) ) {
        $terms = wp_get_object_terms( $id, $tax_names );
    }
}

$cat_slugs = array();
$tag_label = '';
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
    foreach ( $terms as $term ) {
        if ( 'uncategorised' !== $term->slug && 'uncategorized' !== $term->slug ) {
            $cat_slugs[] = $term->slug;
            if ( ! $tag_label ) {
                $tag_label = $term->name;
            }
        }
    }
}
if ( ! $tag_label ) {
    $tag_label = __( 'Story', 'looksrilanka' );
}
$data_cat = ! empty( $cat_slugs ) ? implode( ' ', $cat_slugs ) : 'general';
?>
<a class="post-card ls-card ls-post-card" href="<?php the_permalink(); ?>" data-cat="<?php echo esc_attr( $data_cat ); ?>">
    <div class="post-visual ls-card-visual"<?php if ( ! has_post_thumbnail( $id ) ) : ?> style="background:linear-gradient(135deg,var(--ls-blue),var(--ls-navy));"<?php endif; ?>>
        <?php if ( $image ) : ?>
            <?php echo $image; ?>
        <?php endif; ?>
        <span class="tag"><?php echo esc_html( $tag_label ); ?></span>
    </div>
    <div class="post-body ls-card-body">
        <h3><?php the_title(); ?></h3>
        <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
        <div class="post-meta">
            <span><?php echo esc_html( $author ?: get_the_date() ); ?></span>
            <span><?php echo esc_html( sprintf( _n( '%d min read', '%d min read', $minutes, 'looksrilanka' ), $minutes ) ); ?></span>
        </div>
    </div>
</a>
