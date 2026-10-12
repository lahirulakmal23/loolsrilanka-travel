<?php
/**
 * ACF field groups for the inner pages: About, Contact, Tailor-Made,
 * tours, destinations, experiences and the listing pages.
 * Uses the ls_f / ls_tab / ls_sub helpers from acf-fields.php.
 */

add_action( 'acf/init', 'ls_register_page_settings_page', 5 );

function ls_register_page_settings_page() {
    if ( function_exists( 'acf_add_options_sub_page' ) ) {
        acf_add_options_sub_page( array(
            'page_title'  => 'Tour & Listing Pages',
            'menu_title'  => 'Tour & Listing Pages',
            'menu_slug'   => 'ls-page-settings',
            'parent_slug' => 'theme-general-settings',
        ) );
    }
}

/**
 * Fields shared by every call-to-action band.
 */
function ls_cta_fields( $prefix, $label = 'Call to action' ) {
    return array(
        ls_f( 'text', $prefix . '_cta_heading', $label . ' heading', array( 'wrapper' => array( 'width' => 50 ) ) ),
        ls_f( 'link', $prefix . '_cta_btn', $label . ' button', array( 'wrapper' => array( 'width' => 50 ) ) ),
        ls_f( 'textarea', $prefix . '_cta_text', $label . ' text', array( 'rows' => 2, 'new_lines' => '' ) ),
    );
}

function ls_hero_fields( $prefix, $image_note = '' ) {
    return array(
        ls_f( 'text', $prefix . '_kicker', 'Small label', array( 'wrapper' => array( 'width' => 35 ) ) ),
        ls_f( 'text', $prefix . '_heading', 'Heading', array( 'wrapper' => array( 'width' => 65 ), 'instructions' => 'Leave empty to use the page title.' ) ),
        ls_f( 'textarea', $prefix . '_text', 'Intro text', array( 'rows' => 3, 'new_lines' => '', 'instructions' => $image_note ) ),
    );
}

function ls_repeater( $name, $label, $sub_fields, $extra = array() ) {
    return ls_f( 'repeater', $name, $label, array_merge( array(
        'layout'       => 'table',
        'button_label' => 'Add row',
        'sub_fields'   => ls_sub( $name, $sub_fields ),
    ), $extra ) );
}

add_action( 'acf/init', 'ls_register_page_field_groups' );

function ls_register_page_field_groups() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    $page_rule = function ( $template ) {
        return array( array( array( 'param' => 'page_template', 'operator' => '==', 'value' => $template ) ) );
    };
    $post_rule = function ( $type ) {
        return array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => $type ) ) );
    };
    $hero_note = 'The background photo is the page\'s Featured Image.';

    /* About ------------------------------------------------------------ */
    acf_add_local_field_group( array(
        'key'        => 'group_ls_about',
        'title'      => 'About Page (New Design)',
        'menu_order' => -10,
        'position'   => 'acf_after_title',
        'location'   => $page_rule( 'page-about.php' ),
        'fields'     => array_merge(
            array( ls_tab( 'Hero' ) ),
            ls_hero_fields( 'ab_hero', $hero_note ),
            array(
                ls_tab( 'Our story' ),
                ls_f( 'text', 'ab_story_kicker', 'Small label', array( 'wrapper' => array( 'width' => 35 ) ) ),
                ls_f( 'text', 'ab_story_heading', 'Heading', array( 'wrapper' => array( 'width' => 65 ) ) ),
                ls_f( 'image', 'ab_story_image', 'Photo', array( 'return_format' => 'id', 'preview_size' => 'medium' ) ),
                ls_f( 'message', 'ab_story_note', 'Story text', array( 'message' => 'The story text is the "lscontent" field further down this page.' ) ),

                ls_tab( 'Our guides' ),
                ls_f( 'text', 'ab_guides_kicker', 'Small label', array( 'wrapper' => array( 'width' => 35 ) ) ),
                ls_f( 'text', 'ab_guides_heading', 'Heading', array( 'wrapper' => array( 'width' => 65 ) ) ),
                ls_f( 'message', 'ab_guides_note', 'Guides text & photo', array( 'message' => 'The text and photo are the "rscontent" and "rflimage" fields further down this page. Leave the text empty to hide this block.' ) ),

                ls_tab( 'Numbers' ),
                ls_repeater( 'ab_stats', 'Numbers band', array(
                    ls_f( 'text', 'number', 'Number', array( 'instructions' => 'e.g. 10K+' ) ),
                    ls_f( 'text', 'label', 'Label' ),
                ), array( 'button_label' => 'Add number' ) ),

                ls_tab( 'Values' ),
                ls_f( 'text', 'ab_values_heading', 'Heading' ),
                ls_f( 'textarea', 'ab_values_intro', 'Intro text', array( 'rows' => 2, 'new_lines' => '' ) ),
                ls_repeater( 'ab_values', 'Values', array(
                    ls_f( 'select', 'icon', 'Icon', array( 'choices' => ls_icon_choices(), 'wrapper' => array( 'width' => 20 ) ) ),
                    ls_f( 'text', 'title', 'Title', array( 'wrapper' => array( 'width' => 30 ) ) ),
                    ls_f( 'textarea', 'text', 'Text', array( 'rows' => 2, 'new_lines' => '' ) ),
                ), array( 'button_label' => 'Add value', 'layout' => 'block', 'collapsed' => 'field_ls_ab_values__title' ) ),

                ls_tab( 'Team' ),
                ls_f( 'text', 'ab_team_heading', 'Heading' ),
                ls_f( 'textarea', 'ab_team_intro', 'Intro text', array( 'rows' => 2, 'new_lines' => '', 'instructions' => 'Team members are edited in the "Our team" list further down this page.' ) ),

                ls_tab( 'Call to action' ),
            ),
            ls_cta_fields( 'ab' )
        ),
    ) );

    /* Contact ---------------------------------------------------------- */
    acf_add_local_field_group( array(
        'key'        => 'group_ls_contact',
        'title'      => 'Contact Page (New Design)',
        'menu_order' => -10,
        'position'   => 'acf_after_title',
        'location'   => $page_rule( 'page-contact.php' ),
        'fields'     => array_merge(
            array( ls_tab( 'Hero' ) ),
            ls_hero_fields( 'ct_hero', $hero_note ),
            array(
                ls_tab( 'Forms' ),
                ls_f( 'text', 'ct_form_label', 'Traveller tab label', array( 'wrapper' => array( 'width' => 50 ) ) ),
                ls_f( 'text', 'ct_form_heading', 'Traveller form heading', array( 'wrapper' => array( 'width' => 50 ) ) ),
                ls_f( 'textarea', 'ct_form_text', 'Traveller form intro', array( 'rows' => 2, 'new_lines' => '' ) ),
                ls_f( 'text', 'ct_form_shortcode', 'Traveller form shortcode', array( 'instructions' => 'Contact Form 7 shortcode, e.g. [contact-form-7 id="da98f42"]' ) ),
                ls_f( 'text', 'ct_agent_label', 'Travel agent tab label', array( 'wrapper' => array( 'width' => 50 ) ) ),
                ls_f( 'text', 'ct_agent_heading', 'Travel agent form heading', array( 'wrapper' => array( 'width' => 50 ) ) ),
                ls_f( 'textarea', 'ct_agent_text', 'Travel agent form intro', array( 'rows' => 2, 'new_lines' => '' ) ),
                ls_f( 'text', 'ct_agent_shortcode', 'Travel agent form shortcode', array( 'instructions' => 'Optional. When set, "Traveller / Travel Agent" tabs appear above the form.' ) ),

                ls_tab( 'Contact details' ),
                ls_f( 'message', 'ct_details_note', 'Phone, email & address', array( 'message' => 'Phone, email and address come from Theme Settings → Header / Footer.' ) ),
                ls_f( 'text', 'ct_hours', 'Office hours', array( 'instructions' => 'Shown under the phone number, e.g. "Mon–Sat, 8am–7pm (GMT+5:30)".' ) ),
                ls_f( 'text', 'ct_email_2', 'Second email line', array( 'instructions' => 'Optional, e.g. "B2B: partners@…".' ) ),
                ls_f( 'text', 'ct_whatsapp_text', 'WhatsApp card text', array( 'instructions' => 'The WhatsApp number is set under Theme Settings → Site Settings.' ) ),
                ls_f( 'text', 'ct_map_heading', 'Map card heading' ),
                ls_f( 'textarea', 'ct_map_embed', 'Google Maps embed code', array( 'rows' => 3, 'new_lines' => '', 'instructions' => 'Paste the <iframe> from Google Maps → Share → Embed a map. Optional.' ) ),
                ls_f( 'image', 'ct_map_image', 'Office photo', array( 'return_format' => 'id', 'preview_size' => 'medium', 'instructions' => 'Optional. Shown when there is no map.' ) ),

                ls_tab( 'FAQ' ),
                ls_f( 'text', 'ct_faq_heading', 'Heading' ),
                ls_repeater( 'ct_faq', 'Questions', array(
                    ls_f( 'text', 'question', 'Question' ),
                    ls_f( 'textarea', 'answer', 'Answer', array( 'rows' => 2, 'new_lines' => '' ) ),
                ), array( 'button_label' => 'Add question', 'layout' => 'block', 'collapsed' => 'field_ls_ct_faq__question' ) ),
                ls_f( 'link', 'ct_faq_link', 'Link below the questions', array( 'instructions' => 'e.g. "See all FAQs →" to the FAQ page.' ) ),
            )
        ),
    ) );

    /* Tailor-made ------------------------------------------------------ */
    acf_add_local_field_group( array(
        'key'        => 'group_ls_tailor',
        'title'      => 'Tailor-Made Page (New Design)',
        'menu_order' => -10,
        'position'   => 'acf_after_title',
        'location'   => $page_rule( 'page-tailor-made.php' ),
        'fields'     => array_merge(
            array( ls_tab( 'Hero' ) ),
            ls_hero_fields( 'tm_hero', $hero_note ),
            array(
                ls_tab( 'How it works' ),
                ls_f( 'text', 'tm_how_kicker', 'Small label', array( 'wrapper' => array( 'width' => 35 ) ) ),
                ls_f( 'text', 'tm_how_heading', 'Heading', array( 'wrapper' => array( 'width' => 65 ) ) ),
                ls_repeater( 'tm_steps', 'Steps', array(
                    ls_f( 'text', 'title', 'Title' ),
                    ls_f( 'textarea', 'text', 'Text', array( 'rows' => 2, 'new_lines' => '' ) ),
                ), array( 'button_label' => 'Add step' ) ),

                ls_tab( 'Inspiration' ),
                ls_f( 'text', 'tm_inspo_kicker', 'Small label', array( 'wrapper' => array( 'width' => 35 ) ) ),
                ls_f( 'text', 'tm_inspo_heading', 'Heading', array( 'wrapper' => array( 'width' => 65 ) ) ),
                ls_repeater( 'tm_inspo', 'Cards', array(
                    ls_f( 'image', 'image', 'Photo', array( 'return_format' => 'id', 'preview_size' => 'thumbnail' ) ),
                    ls_f( 'text', 'label', 'Label' ),
                    ls_f( 'link', 'link', 'Link (optional)' ),
                ), array( 'button_label' => 'Add card' ) ),

                ls_tab( 'Form' ),
                ls_f( 'text', 'tm_form_heading', 'Form heading' ),
                ls_f( 'textarea', 'tm_form_text', 'Form intro', array( 'rows' => 2, 'new_lines' => '', 'instructions' => 'The form itself is the page content in the editor below (the Contact Form 7 shortcode).' ) ),
                ls_f( 'text', 'tm_note', 'Small note under the form', array( 'instructions' => 'e.g. "No payment required to enquire".' ) ),
                ls_f( 'text', 'tm_side_heading', 'Side card heading', array( 'wrapper' => array( 'width' => 50 ) ) ),
                ls_f( 'text', 'tm_whatsapp_text', 'WhatsApp card text', array( 'wrapper' => array( 'width' => 50 ) ) ),
                ls_f( 'textarea', 'tm_side_text', 'Side card text', array( 'rows' => 3, 'new_lines' => '' ) ),
            )
        ),
    ) );

    /* Tour (multi-day itinerary) -------------------------------------- */
    acf_add_local_field_group( array(
        'key'        => 'group_ls_tour',
        'title'      => 'Itinerary Details (New Design)',
        'menu_order' => -10,
        'position'   => 'acf_after_title',
        'location'   => $post_rule( 'tour' ),
        'fields'     => array(
            ls_f( 'text', 'it_route', 'Route', array( 'instructions' => 'e.g. "Colombo → Kandy → Ella → Galle". Leave empty to build it from the itinerary day titles.', 'wrapper' => array( 'width' => 50 ) ) ),
            ls_f( 'text', 'it_pace', 'Pace', array( 'instructions' => 'e.g. "Moderate pace"', 'wrapper' => array( 'width' => 25 ) ) ),
            ls_f( 'text', 'it_group', 'Group size', array( 'instructions' => 'e.g. "Private, 1–8 guests"', 'wrapper' => array( 'width' => 25 ) ) ),
            ls_f( 'text', 'it_price_note', 'Price note', array( 'instructions' => 'Small text under the price, e.g. "per person, twin-share".', 'wrapper' => array( 'width' => 50 ) ) ),
            ls_f( 'textarea', 'it_summary', 'Card summary', array( 'rows' => 2, 'new_lines' => '', 'instructions' => 'Short text for the listing card. Leave empty to use the start of the description.', 'wrapper' => array( 'width' => 50 ) ) ),
            ls_repeater( 'it_drive_times', 'Drive times', array(
                ls_f( 'text', 'text', 'Text', array( 'instructions' => 'e.g. "Colombo → Kandy: ~3.5 hrs"' ) ),
            ), array( 'button_label' => 'Add drive time' ) ),
        ),
    ) );

    /* Destination ------------------------------------------------------ */
    acf_add_local_field_group( array(
        'key'        => 'group_ls_destination',
        'title'      => 'Destination Details (New Design)',
        'menu_order' => -10,
        'position'   => 'acf_after_title',
        'location'   => $post_rule( 'destination' ),
        'fields'     => array(
            ls_f( 'text', 'ds_region', 'Region', array( 'instructions' => 'e.g. "Hill Country". Destinations are grouped by this on the Destinations page.', 'wrapper' => array( 'width' => 35 ) ) ),
            ls_f( 'text', 'ds_heading', 'About heading', array( 'instructions' => 'e.g. "A 5th-century palace on top of a 200-metre rock"', 'wrapper' => array( 'width' => 65 ) ) ),
            ls_f( 'textarea', 'ds_summary', 'Card summary', array( 'rows' => 2, 'new_lines' => '', 'instructions' => 'Short text for the listing card. Leave empty to use the start of the description.' ) ),
            ls_repeater( 'ds_facts', 'Quick facts', array(
                ls_f( 'text', 'label', 'Label', array( 'instructions' => 'e.g. "Best time to visit"' ) ),
                ls_f( 'text', 'value', 'Value' ),
            ), array( 'button_label' => 'Add fact' ) ),
            ls_f( 'relationship', 'ds_related', 'Where this appears', array(
                'instructions'  => 'Itineraries that visit this destination.',
                'post_type'     => array( 'tour' ),
                'filters'       => array( 'search' ),
                'return_format' => 'id',
            ) ),
        ),
    ) );

    /* Tour & listing page settings (options) -------------------------- */
    acf_add_local_field_group( array(
        'key'      => 'group_ls_page_settings',
        'title'    => 'Tour & Listing Pages',
        'location' => array( array( array( 'param' => 'options_page', 'operator' => '==', 'value' => 'ls-page-settings' ) ) ),
        'fields'   => array_merge(
            array(
                ls_tab( 'Itineraries page' ),
                ls_f( 'message', 'it_list_note', 'Banner', array( 'message' => 'The background photo is "tour_page_banner" under Theme Settings.' ) ),
                ls_f( 'text', 'it_list_heading', 'Heading' ),
                ls_f( 'textarea', 'it_list_text', 'Intro text', array( 'rows' => 3, 'new_lines' => '' ) ),
                ls_f( 'text', 'it_list_all', '"All" filter label', array( 'default_value' => 'All Itineraries', 'instructions' => 'Filter buttons come from Appearance → Menus → "Tour menu".' ) ),
            ),
            ls_cta_fields( 'it_list' ),
            array(
                ls_tab( 'Itinerary detail' ),
                ls_f( 'link', 'it_customise_btn', 'Customise button' ),
                ls_repeater( 'it_trust', 'Trust points', array( ls_f( 'text', 'text', 'Text' ) ), array( 'button_label' => 'Add point' ) ),
                ls_f( 'text', 'it_book_note', 'Note under the form' ),
                ls_f( 'text', 'it_faq_heading', 'Questions heading' ),
                ls_repeater( 'it_faq', 'Questions (shown on every itinerary)', array(
                    ls_f( 'text', 'question', 'Question' ),
                    ls_f( 'textarea', 'answer', 'Answer', array( 'rows' => 2, 'new_lines' => '' ) ),
                ), array( 'button_label' => 'Add question', 'layout' => 'block', 'collapsed' => 'field_ls_it_faq__question' ) ),
            ),
            ls_cta_fields( 'it_single' ),
            array(
                ls_tab( 'Destinations page' ),
                ls_f( 'message', 'ds_list_note', 'Banner', array( 'message' => 'The background photo is "destination_page_banner" under Theme Settings.' ) ),
                ls_f( 'text', 'ds_list_heading', 'Heading' ),
                ls_f( 'textarea', 'ds_list_text', 'Intro text', array( 'rows' => 3, 'new_lines' => '' ) ),
                ls_f( 'text', 'ds_list_all', '"All" filter label', array( 'default_value' => 'All Regions' ) ),
            ),
            ls_cta_fields( 'ds_list' ),
            array( ls_tab( 'Destination detail' ) ),
            ls_cta_fields( 'ds_single', 'Call to action (use {destination} for the name)' ),
            array(
                ls_tab( 'Experiences page' ),
                ls_f( 'message', 'ex_list_note', 'Banner', array( 'message' => 'The background photo is "escapades_page_banner" under Theme Settings.' ) ),
                ls_f( 'text', 'ex_list_heading', 'Heading' ),
                ls_f( 'textarea', 'ex_list_text', 'Intro text', array( 'rows' => 3, 'new_lines' => '' ) ),
            ),
            ls_cta_fields( 'ex_list' ),
            array( ls_tab( 'Experience detail' ) ),
            ls_cta_fields( 'ex_single', 'Call to action (use {experience} for the name)' ),
            array(
                ls_tab( 'Blog / News' ),
                ls_f( 'message', 'nw_list_note', 'Banner', array( 'message' => 'The background photo is "blog_page_banner" (or "news_page_banner") under Theme Settings.' ) ),
                ls_f( 'text', 'nw_list_kicker', 'Small label', array( 'wrapper' => array( 'width' => 35 ) ) ),
                ls_f( 'text', 'nw_list_heading', 'Heading', array( 'wrapper' => array( 'width' => 65 ) ) ),
                ls_f( 'textarea', 'nw_list_text', 'Intro text', array( 'rows' => 2, 'new_lines' => '' ) ),
                ls_f( 'text', 'nw_more_heading', '"More articles" heading on article pages' ),
            ),
            ls_cta_fields( 'nw', 'Call to action (blog & articles)' ),
            array(
                ls_tab( 'Booking form' ),
                ls_f( 'text', 'ls_tour_form', 'Tour enquiry form shortcode', array( 'instructions' => 'Contact Form 7 shortcode used on every itinerary page.' ) ),
            )
        ),
    ) );

    /* FAQ page ----------------------------------------------------------- */
    acf_add_local_field_group( array(
        'key'        => 'group_ls_faq',
        'title'      => 'FAQ Page (New Design)',
        'menu_order' => -10,
        'position'   => 'acf_after_title',
        'location'   => $page_rule( 'page-faq.php' ),
        'fields'     => array_merge(
            array( ls_tab( 'Hero' ) ),
            ls_hero_fields( 'fq_hero', $hero_note ),
            array(
                ls_tab( 'Questions' ),
                ls_f( 'message', 'fq_note', 'How questions are shown', array( 'message' => 'Questions come from the "faq" list further down this page. Each row is a topic; inside it, start each question on its own line with "Q:" (bold) and its answer with "A:". Every Q/A pair becomes its own expandable question.' ) ),
                ls_tab( 'Side card' ),
                ls_f( 'text', 'fq_side_heading', 'Heading' ),
                ls_f( 'textarea', 'fq_side_text', 'Text', array( 'rows' => 2, 'new_lines' => '' ) ),
                ls_f( 'link', 'fq_side_btn', 'Button' ),
                ls_f( 'text', 'fq_whatsapp_text', 'WhatsApp card text' ),
                ls_tab( 'Call to action' ),
            ),
            ls_cta_fields( 'fq' )
        ),
    ) );
}
