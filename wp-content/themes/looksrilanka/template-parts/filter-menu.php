<?php
/**
 * Filter pills built from a WordPress menu (e.g. "Tour menu" → tour categories).
 * Args: location, all_label, all_url.
 */
$args = wp_parse_args( $args, array( 'location' => '', 'all_label' => 'All', 'all_url' => '' ) );

$locations = get_nav_menu_locations();
$items     = ! empty( $locations[ $args['location'] ] ) ? wp_get_nav_menu_items( $locations[ $args['location'] ] ) : array();
$current   = trailingslashit( strtok( home_url( add_query_arg( array() ) ), '?' ) );
$current   = preg_replace( '#/page/\d+/?$#', '/', $current );
$all_url   = trailingslashit( $args['all_url'] );

if ( ! $items ) {
    return;
}
?>
<nav class="ls-filters" aria-label="<?php esc_attr_e( 'Filter', 'looksrilanka' ); ?>">
    <?php
    $has_all = false;
    foreach ( $items as $item ) {
        if ( trailingslashit( $item->url ) === $all_url ) {
            $has_all = true;
        }
    }
    if ( ! $has_all ) {
        printf(
            '<a href="%s"%s>%s</a>',
            esc_url( $all_url ),
            $current === $all_url ? ' class="is-active" aria-current="page"' : '',
            esc_html( $args['all_label'] )
        );
    }
    foreach ( $items as $item ) {
        $active = trailingslashit( $item->url ) === $current;
        printf(
            '<a href="%s"%s>%s</a>',
            esc_url( $item->url ),
            $active ? ' class="is-active" aria-current="page"' : '',
            esc_html( wp_strip_all_tags( $item->title ) )
        );
    }
    ?>
</nav>
