<?php
/**
 * ACF field groups for the redesign, registered in code so they are
 * version-controlled and identical on every environment.
 *
 * Field names are prefixed (hp_ / ls_) so they never collide with the
 * older field groups stored in the database.
 */

/**
 * Builds an ACF field array with a key derived from the name.
 */
function ls_f( $type, $name, $label, $extra = array() ) {
    return array_merge( array(
        'key'   => 'field_ls_' . $name,
        'name'  => $name,
        'label' => $label,
        'type'  => $type,
    ), $extra );
}

function ls_tab( $label ) {
    return array(
        'key'       => 'field_ls_tab_' . sanitize_key( $label ),
        'label'     => $label,
        'type'      => 'tab',
        'placement' => 'top',
    );
}

/**
 * Sub fields need unique keys too, so prefix them with the parent name.
 */
function ls_sub( $parent, $fields ) {
    foreach ( $fields as &$field ) {
        $field['key'] = 'field_ls_' . $parent . '__' . $field['name'];
    }
    return $fields;
}

function ls_icon_choices() {
    return array(
        'star'    => 'Star',
        'clock'   => 'Clock',
        'home'    => 'House',
        'shield'  => 'Shield / tick',
        'support' => 'Headset / support',
        'sliders' => 'Customise',
        'map'     => 'Map',
        'heart'   => 'Heart',
        'tag'     => 'Price tag',
        'leaf'    => 'Leaf',
    );
}

add_action( 'acf/init', 'ls_register_field_groups' );

function ls_register_field_groups() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    /* ------------------------------------------------------------------
     * Global site settings (Theme Settings options page)
     * ------------------------------------------------------------------ */
    acf_add_local_field_group( array(
        'key'      => 'group_ls_site_settings',
        'title'    => 'Site Settings (New Design)',
        'location' => array( array( array( 'param' => 'options_page', 'operator' => '==', 'value' => 'theme-general-settings' ) ) ),
        'fields'   => array(
            ls_tab( 'Header' ),
            ls_f( 'link', 'ls_header_cta', 'Header button', array(
                'instructions' => 'The highlighted button at the end of the menu (e.g. "Plan My Trip").',
            ) ),
            ls_f( 'message', 'ls_logo_note', 'Logo', array(
                'message' => 'The header and footer logos are set under Theme Settings → Header / Footer. If no logo is uploaded, the site name is shown as text.',
            ) ),

            ls_tab( 'Contact & Social' ),
            ls_f( 'text', 'ls_whatsapp', 'WhatsApp number', array(
                'instructions' => 'International format, digits only (e.g. 94766603699). Shows the floating WhatsApp button. Leave empty to hide it.',
            ) ),
            ls_f( 'text', 'ls_whatsapp_message', 'WhatsApp pre-filled message', array(
                'instructions' => 'Optional text that appears in the chat when a visitor taps the button.',
            ) ),
            ls_f( 'repeater', 'ls_social', 'Social links', array(
                'layout'       => 'table',
                'button_label' => 'Add social link',
                'sub_fields'   => ls_sub( 'ls_social', array(
                    ls_f( 'select', 'network', 'Network', array(
                        'choices' => array(
                            'facebook'    => 'Facebook',
                            'instagram'   => 'Instagram',
                            'tiktok'      => 'TikTok',
                            'tripadvisor' => 'Tripadvisor',
                            'youtube'     => 'YouTube',
                            'linkedin'    => 'LinkedIn',
                        ),
                    ) ),
                    ls_f( 'url', 'url', 'URL' ),
                ) ),
            ) ),

            ls_tab( 'Footer' ),
            ls_f( 'textarea', 'ls_footer_about', 'Footer description', array( 'rows' => 3, 'new_lines' => '' ) ),
            ls_f( 'text', 'ls_footer_explore_title', 'Column 2 heading', array( 'default_value' => 'Explore', 'instructions' => 'Links come from Appearance → Menus → "Footer: Explore column".' ) ),
            ls_f( 'text', 'ls_footer_company_title', 'Column 3 heading', array( 'default_value' => 'Company', 'instructions' => 'Links come from Appearance → Menus → "Footer: Company column".' ) ),
            ls_f( 'text', 'ls_footer_contact_title', 'Column 4 heading', array( 'default_value' => 'Reach us', 'instructions' => 'Phone, email and address come from Theme Settings → Header / Footer.' ) ),
            ls_f( 'text', 'ls_footer_note', 'Bottom-right note', array( 'instructions' => 'e.g. a licence or registration number. Leave empty to show the Privacy / Terms links only.' ) ),
            ls_f( 'repeater', 'ls_footer_legal', 'Bottom links', array(
                'layout'       => 'table',
                'button_label' => 'Add link',
                'sub_fields'   => ls_sub( 'ls_footer_legal', array(
                    ls_f( 'link', 'link', 'Link' ),
                ) ),
            ) ),
        ),
    ) );

    /* ------------------------------------------------------------------
     * Home page
     * ------------------------------------------------------------------ */
    acf_add_local_field_group( array(
        'key'                   => 'group_ls_home',
        'title'                 => 'Home Page (New Design)',
        'menu_order'            => -10,
        'position'              => 'acf_after_title',
        'style'                 => 'default',
        'hide_on_screen'        => array( 'the_content' ),
        'location'              => array( array( array( 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ) ) ),
        'fields'                => array(

            // Hero slider
            ls_tab( 'Hero slider' ),
            ls_f( 'repeater', 'hp_slides', 'Slides', array(
                'instructions' => 'Each slide has its own photo and text. Drag rows to reorder. Use landscape photos at least 1920px wide.',
                'layout'       => 'block',
                'collapsed'    => 'field_ls_hp_slides__heading',
                'min'          => 1,
                'button_label' => 'Add slide',
                'sub_fields'   => ls_sub( 'hp_slides', array(
                    ls_f( 'image', 'image', 'Photo', array( 'return_format' => 'id', 'preview_size' => 'medium', 'required' => 1, 'wrapper' => array( 'width' => 35 ) ) ),
                    ls_f( 'text', 'eyebrow', 'Small label', array( 'instructions' => 'e.g. "Cultural Triangle"', 'wrapper' => array( 'width' => 65 ) ) ),
                    ls_f( 'text', 'heading', 'Heading', array( 'required' => 1, 'wrapper' => array( 'width' => 65 ) ) ),
                    ls_f( 'textarea', 'lead', 'Text', array( 'rows' => 2, 'new_lines' => '', 'wrapper' => array( 'width' => 65 ) ) ),
                    ls_f( 'text', 'badge', 'Badge', array( 'instructions' => 'Short highlight in the orange pill, e.g. "9 days · from $1,450pp". Optional.', 'wrapper' => array( 'width' => 65 ) ) ),
                ) ),
            ) ),
            ls_f( 'link', 'hp_hero_btn_1', 'Main button', array( 'wrapper' => array( 'width' => 50 ) ) ),
            ls_f( 'link', 'hp_hero_btn_2', 'Second button', array( 'wrapper' => array( 'width' => 50 ) ) ),
            ls_f( 'number', 'hp_hero_interval', 'Seconds per slide', array( 'default_value' => 6, 'min' => 3, 'max' => 20 ) ),

            // Trust strip
            ls_tab( 'Trust strip' ),
            ls_f( 'repeater', 'hp_trust', 'Trust points', array(
                'instructions' => 'The dark bar under the slider. Keep each point short.',
                'layout'       => 'table',
                'button_label' => 'Add point',
                'sub_fields'   => ls_sub( 'hp_trust', array(
                    ls_f( 'text', 'text', 'Text' ),
                ) ),
            ) ),

            // Ways to explore
            ls_tab( 'Ways to explore' ),
            ls_f( 'text', 'hp_ways_kicker', 'Small label', array( 'wrapper' => array( 'width' => 35 ) ) ),
            ls_f( 'text', 'hp_ways_heading', 'Heading', array( 'wrapper' => array( 'width' => 65 ) ) ),
            ls_f( 'textarea', 'hp_ways_intro', 'Intro text', array( 'rows' => 2, 'new_lines' => '' ) ),
            ls_f( 'repeater', 'hp_ways', 'Cards', array(
                'layout'       => 'block',
                'collapsed'    => 'field_ls_hp_ways__title',
                'button_label' => 'Add card',
                'sub_fields'   => ls_sub( 'hp_ways', array(
                    ls_f( 'image', 'image', 'Photo', array( 'return_format' => 'id', 'preview_size' => 'medium', 'wrapper' => array( 'width' => 35 ) ) ),
                    ls_f( 'text', 'title', 'Title', array( 'wrapper' => array( 'width' => 65 ) ) ),
                    ls_f( 'text', 'count', 'Count label', array( 'instructions' => 'e.g. "{tours} routes". {tours} and {day_tours} are replaced with the live number of published tours.', 'wrapper' => array( 'width' => 65 ) ) ),
                    ls_f( 'textarea', 'text', 'Text', array( 'rows' => 2, 'new_lines' => '', 'wrapper' => array( 'width' => 65 ) ) ),
                    ls_f( 'link', 'link', 'Link', array( 'wrapper' => array( 'width' => 65 ) ) ),
                ) ),
            ) ),

            // Why us
            ls_tab( 'Why us' ),
            ls_f( 'text', 'hp_why_kicker', 'Small label', array( 'wrapper' => array( 'width' => 35 ) ) ),
            ls_f( 'text', 'hp_why_heading', 'Heading', array( 'wrapper' => array( 'width' => 65 ) ) ),
            ls_f( 'repeater', 'hp_why', 'Reasons', array(
                'layout'       => 'block',
                'collapsed'    => 'field_ls_hp_why__title',
                'button_label' => 'Add reason',
                'sub_fields'   => ls_sub( 'hp_why', array(
                    ls_f( 'select', 'icon', 'Icon', array( 'choices' => ls_icon_choices(), 'default_value' => 'star', 'wrapper' => array( 'width' => 25 ) ) ),
                    ls_f( 'text', 'title', 'Title', array( 'wrapper' => array( 'width' => 75 ) ) ),
                    ls_f( 'textarea', 'text', 'Text', array( 'rows' => 2, 'new_lines' => '' ) ),
                ) ),
            ) ),
            ls_f( 'image', 'hp_why_image', 'Side image', array(
                'instructions' => 'Optional. Leave empty to show the built-in route map illustration.',
                'return_format' => 'id',
                'preview_size'  => 'medium',
                'wrapper'       => array( 'width' => 50 ),
            ) ),
            ls_f( 'text', 'hp_why_caption', 'Side image caption', array( 'wrapper' => array( 'width' => 50 ) ) ),

            // Partner strip
            ls_tab( 'Partner strip' ),
            ls_f( 'true_false', 'hp_b2b_show', 'Show this section', array( 'ui' => 1, 'default_value' => 1 ) ),
            ls_f( 'text', 'hp_b2b_heading', 'Heading' ),
            ls_f( 'textarea', 'hp_b2b_text', 'Text', array( 'rows' => 2, 'new_lines' => '' ) ),
            ls_f( 'textarea', 'hp_b2b_partners', 'Partner names', array( 'rows' => 3, 'new_lines' => '', 'instructions' => 'One per line. Leave empty to hide.' ) ),
            ls_f( 'link', 'hp_b2b_btn', 'Button' ),

            // Testimonials
            ls_tab( 'Testimonials' ),
            ls_f( 'text', 'hp_testi_kicker', 'Small label', array( 'wrapper' => array( 'width' => 35 ) ) ),
            ls_f( 'text', 'hp_testi_heading', 'Heading', array( 'wrapper' => array( 'width' => 65 ) ) ),
            ls_f( 'repeater', 'hp_testimonials', 'Reviews', array(
                'layout'       => 'block',
                'collapsed'    => 'field_ls_hp_testimonials__name',
                'button_label' => 'Add review',
                'sub_fields'   => ls_sub( 'hp_testimonials', array(
                    ls_f( 'textarea', 'quote', 'Review', array( 'rows' => 3, 'new_lines' => '' ) ),
                    ls_f( 'text', 'name', 'Name & country', array( 'instructions' => 'e.g. "Hannah R., United Kingdom"', 'wrapper' => array( 'width' => 50 ) ) ),
                    ls_f( 'text', 'trip', 'Trip / detail', array( 'instructions' => 'e.g. "10-day Cultural Triangle & Coast". Optional.', 'wrapper' => array( 'width' => 50 ) ) ),
                    ls_f( 'number', 'rating', 'Stars', array( 'default_value' => 5, 'min' => 1, 'max' => 5, 'wrapper' => array( 'width' => 50 ) ) ),
                    ls_f( 'image', 'photo', 'Photo', array( 'return_format' => 'id', 'preview_size' => 'thumbnail', 'instructions' => 'Optional. Initials are shown when empty.', 'wrapper' => array( 'width' => 50 ) ) ),
                ) ),
            ) ),

            // CTA band
            ls_tab( 'Call to action' ),
            ls_f( 'text', 'hp_cta_heading', 'Heading' ),
            ls_f( 'textarea', 'hp_cta_text', 'Text', array( 'rows' => 2, 'new_lines' => '' ) ),
            ls_f( 'link', 'hp_cta_btn', 'Button' ),
        ),
    ) );
}
