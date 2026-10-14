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
                ls_f( 'textarea', 'ct_map_embed', 'Google Maps embed code', array( 'rows' => 3, 'new_lines' => '', 'instructions' => 'Paste the embed code (it starts with &lt;iframe) from Google Maps → Share → Embed a map. Optional.' ) ),
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
    // The day-by-day "itinerary" repeater lives in the older "Tours" group (database);
    // this adds a "Tip" to each day without editing that group.
    add_filter( 'acf/load_field/key=field_674f030fbbae9', function ( $field ) {
        $field['sub_fields'][] = acf_get_valid_field( array(
            'key'          => 'field_ls_it_day_tip',
            'name'         => 'tip',
            'label'        => 'Tip',
            'type'         => 'text',
            'parent'       => $field['key'],
            'instructions' => 'Optional. Shown in a blue box under the day, e.g. "Most international flights land after dark, so day 1 is kept free."',
        ) );
        return $field;
    } );

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

    /* Day tour ----------------------------------------------------------- */
    acf_add_local_field_group( array(
        'key'        => 'group_ls_day_tour',
        'title'      => 'Day Tour Details (New Design)',
        'menu_order' => -10,
        'position'   => 'acf_after_title',
        'location'   => $post_rule( 'day-tour' ),
        'fields'     => array(
            ls_tab( 'Card & hero' ),
            ls_f( 'text', 'dt_badge', 'Badge', array( 'instructions' => 'e.g. "Full Day" or "Half Day"', 'wrapper' => array( 'width' => 25 ) ) ),
            ls_f( 'text', 'dt_duration', 'Duration', array( 'instructions' => 'e.g. "10–11 hrs"', 'wrapper' => array( 'width' => 25 ) ) ),
            ls_f( 'text', 'dt_from', 'Starting point', array( 'instructions' => 'e.g. "From Colombo"', 'wrapper' => array( 'width' => 25 ) ) ),
            ls_f( 'text', 'dt_price_note', 'Price note', array( 'instructions' => 'Small text under the price, e.g. "per person"', 'wrapper' => array( 'width' => 25 ) ) ),
            ls_f( 'text', 'dt_good_for', 'Good for', array( 'instructions' => 'e.g. "first-timers, history lovers"', 'wrapper' => array( 'width' => 50 ) ) ),
            ls_f( 'textarea', 'dt_summary', 'Card summary', array( 'rows' => 2, 'new_lines' => '', 'instructions' => 'Short text for the listing card. Leave empty to use the start of the description.', 'wrapper' => array( 'width' => 50 ) ) ),
            ls_f( 'post_object', 'dt_destination', 'Destination guide card', array( 'post_type' => array( 'destination' ), 'return_format' => 'id', 'allow_null' => 1, 'instructions' => 'Shown as the last "Other day tours" card. Leave empty to match the "destinations" field automatically.' ) ),
            ls_f( 'message', 'dt_card_note', 'Photos, price & filters', array( 'message' => 'The photos are the Featured Image plus the "gallery" field further down. The price is the "price" field. Listing filters are the Day Tour Categories (right-hand sidebar).' ) ),

            ls_tab( 'Overview' ),
            ls_f( 'text', 'dt_heading', 'Overview heading', array( 'instructions' => 'e.g. "The Cultural Triangle\'s two biggest sites, done in one long day". The overview text is the "description" field further down.' ) ),

            ls_tab( 'Schedule' ),
            ls_repeater( 'dt_schedule', 'Hour-by-hour schedule', array(
                ls_f( 'text', 'time', 'Time', array( 'instructions' => 'e.g. "5:00 AM"', 'wrapper' => array( 'width' => 20 ) ) ),
                ls_f( 'text', 'title', 'Title', array( 'wrapper' => array( 'width' => 30 ) ) ),
                ls_f( 'textarea', 'text', 'Text', array( 'rows' => 2, 'new_lines' => '' ) ),
            ), array( 'button_label' => 'Add stop', 'instructions' => 'When empty, the "itinerary" text further down is shown instead.' ) ),

            ls_tab( 'Meeting point' ),
            ls_f( 'wysiwyg', 'dt_meeting', 'Meeting point & pickup', array( 'tabs' => 'visual', 'toolbar' => 'basic', 'media_upload' => 0, 'instructions' => 'Pickup place, time and vehicle. The map next to it is the "iframe" field further down.' ) ),

            ls_tab( 'Good to know' ),
            ls_repeater( 'dt_tips', 'Good to know', array(
                ls_f( 'text', 'title', 'Title', array( 'instructions' => 'e.g. "What to wear"', 'wrapper' => array( 'width' => 30 ) ) ),
                ls_f( 'textarea', 'text', 'Text', array( 'rows' => 2, 'new_lines' => '' ) ),
            ), array( 'button_label' => 'Add card' ) ),
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
                'instructions'  => 'Itineraries that visit this destination. Leave empty to list them automatically from the tour day titles (plus matching day tours).',
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
                ls_tab( 'Day tours page' ),
                ls_f( 'text', 'dt_list_heading', 'Heading', array( 'instructions' => 'Leave empty to use the page title.' ) ),
                ls_f( 'textarea', 'dt_list_text', 'Intro text', array( 'rows' => 2, 'new_lines' => '' ) ),
                ls_f( 'image', 'dt_list_image', 'Banner photo', array( 'return_format' => 'id', 'preview_size' => 'medium', 'instructions' => 'Optional. Leave empty for a plain blue banner (or the Day Tours page\'s Featured Image).' ) ),
                ls_f( 'text', 'dt_list_all', '"All" filter label', array( 'default_value' => 'All Tours', 'instructions' => 'Filter buttons are the Day Tour Categories that have tours (Day Tours → Categories).', 'wrapper' => array( 'width' => 34 ) ) ),
                ls_f( 'text', 'dt_book_btn', 'Card button', array( 'default_value' => 'Book', 'wrapper' => array( 'width' => 33 ) ) ),
                ls_f( 'text', 'dt_good_for_label', '"Good for" label', array( 'default_value' => 'Good for:', 'wrapper' => array( 'width' => 33 ) ) ),
                ls_f( 'text', 'dt_book_heading', 'Booking form heading', array( 'wrapper' => array( 'width' => 50 ) ) ),
                ls_f( 'text', 'dt_selected_label', '"Selected tour" label', array( 'default_value' => 'Selected tour:', 'wrapper' => array( 'width' => 50 ) ) ),
                ls_f( 'textarea', 'dt_book_text', 'Booking form intro', array( 'rows' => 2, 'new_lines' => '' ) ),
                ls_f( 'text', 'dt_book_form', 'Day tour booking form shortcode', array( 'instructions' => 'Contact Form 7 shortcode, used on the listing and on every day tour. Leave empty to use the tour enquiry form (Booking form tab). The chosen tour name is sent in the form\'s hidden "page_title" field.' ) ),
                ls_f( 'text', 'dt_detail_form', 'Day tour page form shortcode', array( 'instructions' => 'Shorter form for the booking card on each day tour. Leave empty to use the form above.' ) ),
                ls_f( 'text', 'dt_book_note', 'Note under the form', array( 'instructions' => 'e.g. "No payment required to request"' ) ),
                ls_f( 'text', 'dt_steps_heading', '"What happens next" heading', array( 'wrapper' => array( 'width' => 50 ) ) ),
                ls_f( 'text', 'dt_wa_text', 'WhatsApp card text', array( 'wrapper' => array( 'width' => 50 ) ) ),
                ls_repeater( 'dt_steps', '"What happens next" steps', array( ls_f( 'text', 'text', 'Step' ) ), array( 'button_label' => 'Add step' ) ),
                ls_f( 'text', 'dt_combo_heading', 'Combo band heading', array( 'instructions' => 'Leave empty to hide the band.', 'wrapper' => array( 'width' => 50 ) ) ),
                ls_f( 'link', 'dt_combo_btn', 'Combo band button', array( 'wrapper' => array( 'width' => 50 ) ) ),
                ls_f( 'textarea', 'dt_combo_text', 'Combo band text', array( 'rows' => 2, 'new_lines' => '' ) ),
                ls_repeater( 'dt_combos', 'Example combos', array( ls_f( 'text', 'text', 'Combo', array( 'instructions' => 'e.g. "Sigiriya + Kandy Temple — 2 days from Colombo"' ) ) ), array( 'button_label' => 'Add combo' ) ),

                ls_tab( 'Day tour detail' ),
                ls_repeater( 'dt_trust', 'Trust points (booking card)', array( ls_f( 'text', 'text', 'Text' ) ), array( 'button_label' => 'Add point' ) ),
                ls_f( 'text', 'dt_view_btn', 'Button on "other tours" cards', array( 'default_value' => 'View Tour', 'wrapper' => array( 'width' => 50 ) ) ),
                ls_f( 'text', 'dt_overview_label', '"Overview" label', array( 'default_value' => 'Overview', 'wrapper' => array( 'width' => 50 ) ) ),
                ls_f( 'text', 'dt_highlights_heading', 'Highlights heading', array( 'default_value' => 'Highlights', 'wrapper' => array( 'width' => 50 ) ) ),
                ls_f( 'text', 'dt_schedule_heading', 'Schedule heading', array( 'default_value' => 'Hour-by-hour schedule', 'wrapper' => array( 'width' => 50 ) ) ),
                ls_f( 'text', 'dt_itinerary_heading', 'Itinerary heading (when there is no schedule)', array( 'default_value' => 'The day', 'wrapper' => array( 'width' => 50 ) ) ),
                ls_f( 'text', 'dt_meeting_heading', 'Meeting point heading', array( 'default_value' => 'Meeting point & pickup', 'wrapper' => array( 'width' => 50 ) ) ),
                ls_f( 'text', 'dt_tips_heading', '"Good to know" heading', array( 'default_value' => 'Good to know', 'wrapper' => array( 'width' => 50 ) ) ),
                ls_f( 'text', 'dt_faq_heading', 'Questions heading', array( 'default_value' => 'Frequently asked', 'wrapper' => array( 'width' => 50 ) ) ),
                ls_f( 'text', 'dt_related_heading', '"Other day tours" heading', array( 'default_value' => 'Other day tours you might like' ) ),
                ls_f( 'text', 'dt_dest_title', 'Destination guide card title', array( 'default_value' => '%s Destination Guide', 'instructions' => '%s is the destination name.', 'wrapper' => array( 'width' => 50 ) ) ),
                ls_f( 'text', 'dt_dest_text', 'Destination guide card text', array( 'default_value' => 'Learn more about this site', 'wrapper' => array( 'width' => 50 ) ) ),

                ls_tab( 'Destinations page' ),
                ls_f( 'message', 'ds_list_note', 'Banner', array( 'message' => 'The background photo is "destination_page_banner" under Theme Settings.' ) ),
                ls_f( 'text', 'ds_list_heading', 'Heading' ),
                ls_f( 'textarea', 'ds_list_text', 'Intro text', array( 'rows' => 3, 'new_lines' => '' ) ),
                ls_f( 'text', 'ds_list_all', '"All" filter label', array( 'default_value' => 'All Regions' ) ),
            ),
            ls_cta_fields( 'ds_list' ),
            array(
                ls_tab( 'Destination detail' ),
                ls_f( 'text', 'ds_gallery_heading', 'Photos heading', array( 'default_value' => 'Photos of {destination}', 'instructions' => '{destination} is the destination name. Photos are the destination\'s own gallery plus the Gallery page photos whose "Place" matches the destination name.', 'wrapper' => array( 'width' => 50 ) ) ),
                ls_f( 'text', 'ds_gallery_link', '"View all photos" link', array( 'default_value' => 'View all photos →', 'wrapper' => array( 'width' => 50 ) ) ),
            ),
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

    /* Gallery page ------------------------------------------------------- */
    acf_add_local_field_group( array(
        'key'        => 'group_ls_gallery',
        'title'      => 'Gallery Page (New Design)',
        'menu_order' => -10,
        'position'   => 'acf_after_title',
        'location'   => $page_rule( 'page-gallery.php' ),
        'fields'     => array_merge(
            array( ls_tab( 'Hero' ) ),
            ls_hero_fields( 'gl_hero', $hero_note ),
            array(
                ls_tab( 'Photos' ),
                ls_repeater( 'gl_photos', 'Photos', array(
                    ls_f( 'image', 'image', 'Photo', array( 'return_format' => 'id', 'preview_size' => 'thumbnail', 'wrapper' => array( 'width' => 30 ) ) ),
                    ls_f( 'text', 'place', 'Place', array( 'instructions' => 'e.g. "Sigiriya"', 'wrapper' => array( 'width' => 35 ) ) ),
                    ls_f( 'text', 'category', 'Category', array( 'instructions' => 'One of the filter categories, e.g. "Beaches"', 'wrapper' => array( 'width' => 35 ) ) ),
                ), array( 'button_label' => 'Add photo' ) ),
                ls_f( 'number', 'gl_per_page', 'Photos per page', array( 'default_value' => 8, 'min' => 1, 'wrapper' => array( 'width' => 50 ) ) ),

                ls_tab( 'Filters & search' ),
                ls_f( 'textarea', 'gl_categories', 'Filter categories', array( 'rows' => 6, 'new_lines' => '', 'instructions' => 'One per line, in the order the buttons should appear. Categories with no photos are hidden; categories used by photos but not listed here are added at the end.' ) ),
                ls_f( 'text', 'gl_all_label', '"All" filter label', array( 'default_value' => 'All', 'wrapper' => array( 'width' => 50 ) ) ),
                ls_f( 'text', 'gl_search_label', 'Search box placeholder', array( 'default_value' => 'Search gallery…', 'wrapper' => array( 'width' => 50 ) ) ),
                ls_f( 'text', 'gl_empty_text', 'Text when no photos match', array( 'default_value' => 'No photos match your search.' ) ),

                ls_tab( 'Share band' ),
                ls_f( 'text', 'gl_share_heading', 'Heading', array( 'instructions' => 'Leave empty to hide this band.', 'wrapper' => array( 'width' => 50 ) ) ),
                ls_f( 'link', 'gl_share_btn', 'Button', array( 'instructions' => 'Leave empty to use the Instagram link from Theme Settings → Site Settings.', 'wrapper' => array( 'width' => 50 ) ) ),
                ls_f( 'textarea', 'gl_share_text', 'Text', array( 'rows' => 2, 'new_lines' => '' ) ),
            )
        ),
    ) );
}
