<?php
/**
 * Starting content for the inner pages (About, Contact, Tailor-Made,
 * listing pages, tours, destinations and experiences). Called from
 * ls_seed_content(); like the rest of the seed it only fills empty fields.
 */
function ls_seed_inner_pages() {
    $o         = 'option';
    $tour_form = '[contact-form-7 id="69fc35b" title="Tour page form"]';

    /* Tour & listing pages (options) ----------------------------------- */

    ls_seed_field( 'ls_tour_form', $tour_form, $o );

    $fallbacks = array_filter( array_map( 'ls_seed_attachment', array(
        '2025/02/Sigiriya-Home-01.jpg',
        '2025/02/Ella-Home.jpg',
        '2025/02/Yala-Home-02.jpg',
        '2025/02/Mirissa-Home-01.jpg',
        '2025/02/Kandy-Home-01.jpg',
        '2025/02/Weligama-Home-01.jpg',
        '2025/02/Front-Nuwaraeliya.jpg',
        '2025/02/Trincomalee-Front.jpg',
        '2024/12/Arugambay-copy-scaled.jpg',
    ) ) );
    if ( $fallbacks ) {
        ls_seed_field( 'ls_fallback_images', array_values( $fallbacks ), $o );
    }

    ls_seed_field( 'it_list_heading', 'Multi-day itineraries across Sri Lanka', $o );
    ls_seed_field( 'it_list_text', (string) get_field( 'tour_page_content', $o ), $o );
    ls_seed_field( 'it_list_all', 'All Itineraries', $o );
    ls_seed_field( 'it_list_cta_heading', 'None of these quite fit?', $o );
    ls_seed_field( 'it_list_cta_text', 'Every itinerary here started as someone\'s rough idea. Tell us yours and we\'ll draft one from scratch.', $o );
    ls_seed_field( 'it_list_cta_btn', ls_seed_link( '/tailor-made-2/', 'Start a Custom Itinerary' ), $o );

    ls_seed_field( 'it_customise_btn', ls_seed_link( '/tailor-made-2/', 'Customise This Trip' ), $o );
    ls_seed_field( 'it_trust', ls_seed_rows( 'it_trust', array(
        array( 'text' => 'Tripadvisor Certificate of Excellence' ),
        array( 'text' => 'Licensed chauffeur guides' ),
        array( 'text' => '100% customisable itinerary' ),
    ) ), $o );
    ls_seed_field( 'it_book_note', 'No payment required to enquire', $o );
    ls_seed_field( 'it_faq_heading', 'Before you enquire', $o );
    ls_seed_field( 'it_faq', ls_seed_rows( 'it_faq', array(
        array( 'question' => 'Can we change the route or add days?', 'answer' => 'Yes — every itinerary is a starting point. Tell us your priorities and we\'ll rebuild the day-by-day plan around them.' ),
        array( 'question' => 'Is the pace fixed?', 'answer' => 'No. We can slow it down with fewer stops per day, or add extra activities and hikes on request.' ),
    ) ), $o );
    ls_seed_field( 'it_single_cta_heading', 'Want a different pace, budget, or route?', $o );
    ls_seed_field( 'it_single_cta_text', 'Every itinerary on this site is a starting point — tell us what matters to you and we\'ll rebuild it around that.', $o );
    ls_seed_field( 'it_single_cta_btn', ls_seed_link( '/tailor-made-2/', 'Start a Custom Itinerary' ), $o );

    ls_seed_field( 'dt_list_heading', 'Short on time? See more of Sri Lanka in a day.', $o );
    ls_seed_field( 'dt_list_text', 'Full-day trips to the island\'s great sites — perfect as add-ons to a longer stay or a stopover between flights.', $o );
    ls_seed_field( 'dt_list_image', ls_seed_attachment( '2024/11/Sigiriya-Rock-Fortres.jpg' ), $o );
    ls_seed_field( 'dt_list_all', 'All Tours', $o );
    ls_seed_field( 'dt_book_btn', 'Book', $o );
    ls_seed_field( 'dt_good_for_label', 'Good for:', $o );
    ls_seed_field( 'dt_book_heading', 'Request a Day Tour Booking', $o );
    ls_seed_field( 'dt_book_text', 'Tell us the date and how many travellers — we\'ll confirm availability and pricing within one business day.', $o );
    ls_seed_field( 'dt_selected_label', 'Selected tour:', $o );
    ls_seed_field( 'dt_book_note', 'No payment required to request · Reply within 1 business day', $o );
    ls_seed_field( 'dt_steps_heading', 'What happens next', $o );
    ls_seed_field( 'dt_steps', ls_seed_rows( 'dt_steps', array(
        array( 'text' => 'We confirm availability for your date' ),
        array( 'text' => 'You get a firm price and pickup time' ),
        array( 'text' => 'You confirm, and we pick you up on the day' ),
    ) ), $o );
    ls_seed_field( 'dt_wa_text', 'Need it faster? Book via WhatsApp', $o );
    ls_seed_field( 'dt_combo_heading', 'Combine two or three day tours into a mini-itinerary', $o );
    ls_seed_field( 'dt_combo_text', 'Tell us your base city and free days — we\'ll stitch together the best day trips around your schedule.', $o );
    ls_seed_field( 'dt_combo_btn', ls_seed_link( '/contact-us/', 'Ask About Combos' ), $o );
    ls_seed_field( 'dt_view_btn', 'View Tour Details', $o );
    ls_seed_field( 'dt_overview_label', 'Overview', $o );
    ls_seed_field( 'dt_highlights_heading', 'Highlights', $o );
    ls_seed_field( 'dt_schedule_heading', 'Hour-by-hour schedule', $o );
    ls_seed_field( 'dt_itinerary_heading', 'The day', $o );
    ls_seed_field( 'dt_meeting_heading', 'Meeting point & pickup', $o );
    ls_seed_field( 'dt_tips_heading', 'Good to know', $o );
    ls_seed_field( 'dt_faq_heading', 'Frequently asked', $o );
    ls_seed_field( 'dt_related_heading', 'Other day tours you might like', $o );

    ls_seed_field( 'ds_list_heading', 'Where you\'ll actually go', $o );
    ls_seed_field( 'ds_list_text', (string) get_field( 'destination_page_content', $o ), $o );
    ls_seed_field( 'ds_list_all', 'All Regions', $o );
    ls_seed_field( 'ds_list_cta_heading', 'See two or more of these in one trip', $o );
    ls_seed_field( 'ds_list_cta_text', 'Our itineraries combine these destinations — or we\'ll build a route around the ones you pick.', $o );
    ls_seed_field( 'ds_list_cta_btn', ls_seed_link( '/tour/', 'Browse Itineraries' ), $o );
    ls_seed_field( 'ds_single_cta_heading', 'Ready to add {destination} to your trip?', $o );
    ls_seed_field( 'ds_single_cta_text', 'See it as part of a full itinerary, or tell us to build a route around it.', $o );
    ls_seed_field( 'ds_single_cta_btn', ls_seed_link( '/tailor-made-2/', 'Plan My Trip' ), $o );

    ls_seed_field( 'ex_list_heading', 'Experiences', $o );
    ls_seed_field( 'ex_list_text', (string) get_field( 'escapades_page_content', $o ), $o );
    ls_seed_field( 'ex_list_cta_heading', 'Add an adventure to your trip', $o );
    ls_seed_field( 'ex_list_cta_text', 'Any of these experiences can be built into your itinerary.', $o );
    ls_seed_field( 'ex_list_cta_btn', ls_seed_link( '/tailor-made-2/', 'Plan My Trip' ), $o );
    ls_seed_field( 'ex_single_cta_heading', 'Want to try {experience}?', $o );
    ls_seed_field( 'ex_single_cta_text', 'Tell us your dates and we\'ll fit it into your Sri Lanka itinerary.', $o );
    ls_seed_field( 'ex_single_cta_btn', ls_seed_link( '/tailor-made-2/', 'Plan My Trip' ), $o );

    ls_seed_field( 'nw_list_kicker', 'Travel news & stories', $o );
    ls_seed_field( 'nw_list_heading', 'From the blog', $o );
    ls_seed_field( 'nw_list_text', 'Travel news, tips and stories from our team on the ground in Sri Lanka.', $o );
    ls_seed_field( 'nw_more_heading', 'More articles', $o );
    ls_seed_field( 'nw_recent_heading', 'Recent Posts', $o );
    ls_seed_field( 'nw_cta_heading', 'Ready to see Sri Lanka for yourself?', $o );
    ls_seed_field( 'nw_cta_text', 'Browse our itineraries or tell us what you\'d like to see.', $o );
    ls_seed_field( 'nw_cta_btn', ls_seed_link( '/tour/', 'Browse Itineraries' ), $o );

    ls_seed_field( 'ls_404_heading', 'This page seems to have wandered off the map', $o );
    ls_seed_field( 'ls_404_text', 'The page you are looking for has moved or no longer exists. Try a search, or start from one of these:', $o );
    ls_seed_field( 'ls_404_image', ls_seed_attachment( '2025/02/Ella-Home.jpg' ), $o );
    ls_seed_field( 'ls_404_links', ls_seed_rows( 'ls_404_links', array(
        array( 'link' => ls_seed_link( '/tour/', 'Tour Itineraries' ) ),
        array( 'link' => ls_seed_link( '/destination/', 'Destinations' ) ),
        array( 'link' => ls_seed_link( '/contact-us/', 'Contact Us' ) ),
    ) ), $o );

    /* FAQ ---------------------------------------------------------------- */

    $faq = get_page_by_path( 'faq' );
    if ( $faq ) {
        $id = $faq->ID;
        ls_seed_field( 'fq_hero_kicker', (string) get_field( 'sub_title', $id ), $id );
        ls_seed_field( 'fq_hero_heading', 'Frequently asked questions', $id );
        ls_seed_field( 'fq_hero_text', 'Booking, transport, health and everything else travellers usually ask us before a Sri Lanka trip.', $id );
        ls_seed_field( 'fq_side_heading', 'Still have a question?', $id );
        ls_seed_field( 'fq_side_text', 'Our team is happy to help with anything not covered here.', $id );
        ls_seed_field( 'fq_side_btn', ls_seed_link( '/contact-us/', 'Contact Us' ), $id );
        ls_seed_field( 'fq_whatsapp_text', 'Ask us on WhatsApp', $id );
        ls_seed_field( 'fq_cta_heading', 'Ready to start planning?', $id );
        ls_seed_field( 'fq_cta_text', 'Tell us your dates and interests and we\'ll draft an itinerary for you.', $id );
        ls_seed_field( 'fq_cta_btn', ls_seed_link( '/tailor-made-2/', 'Plan My Trip' ), $id );
    }

    /* Gallery -------------------------------------------------------------- */

    $gallery = get_page_by_path( 'gallery' );
    if ( ! $gallery ) {
        $new_id  = wp_insert_post( array(
            'post_type'   => 'page',
            'post_title'  => 'Gallery',
            'post_name'   => 'gallery',
            'post_status' => 'publish',
        ) );
        $gallery = $new_id && ! is_wp_error( $new_id ) ? get_post( $new_id ) : null;
    }
    if ( $gallery ) {
        $id = $gallery->ID;
        if ( ! get_page_template_slug( $id ) ) {
            update_post_meta( $id, '_wp_page_template', 'page-gallery.php' );
        }
        if ( ! has_post_thumbnail( $id ) && ( $banner = ls_seed_attachment( '2024/12/Galle-scaled.jpg' ) ) ) {
            set_post_thumbnail( $id, $banner );
        }

        ls_seed_field( 'gl_hero_heading', 'Our Gallery', $id );
        ls_seed_field( 'gl_hero_text', 'Explore the beauty of Sri Lanka through our lens.', $id );
        ls_seed_field( 'gl_per_page', 8, $id );
        ls_seed_field( 'gl_categories', "Beaches\nMountains\nCulture\nWildlife\nCities", $id );
        ls_seed_field( 'gl_all_label', 'All', $id );
        ls_seed_field( 'gl_search_label', 'Search gallery…', $id );
        ls_seed_field( 'gl_empty_text', 'No photos match your search.', $id );

        $photos = array();
        foreach ( array(
            array( '2025/02/Sigiriya-Home-01.jpg', 'Sigiriya', 'Culture' ),
            array( '2025/02/Ella-Home.jpg', 'Ella', 'Mountains' ),
            array( '2025/02/Mirissa-Home-01.jpg', 'Mirissa', 'Beaches' ),
            array( '2025/02/Yala-Home-02.jpg', 'Yala', 'Wildlife' ),
            array( '2025/02/Kandy-Home-01.jpg', 'Kandy', 'Culture' ),
            array( '2024/12/Arugambay-copy-scaled.jpg', 'Arugam Bay', 'Beaches' ),
            array( '2024/12/Galle-scaled.jpg', 'Galle', 'Cities' ),
            array( '2024/12/Hatton-scaled.jpg', 'Hatton', 'Mountains' ),
            array( '2024/11/Dambulla-Cave-Temple-Sri-Lanka.jpg', 'Dambulla', 'Culture' ),
            array( '2024/12/Leopard-Sri-Lanka-scaled.jpg', 'Yala', 'Wildlife' ),
            array( '2024/12/Trincomalee-Cover-scaled.jpg', 'Trincomalee', 'Beaches' ),
            array( '2024/12/COlombo-scaled.jpg', 'Colombo', 'Cities' ),
            array( '2024/12/Nuwaraeliya-copy-scaled.jpg', 'Nuwara Eliya', 'Mountains' ),
        ) as $photo ) {
            if ( $image = ls_seed_attachment( $photo[0] ) ) {
                $photos[] = array( 'image' => $image, 'place' => $photo[1], 'category' => $photo[2] );
            }
        }
        if ( $photos ) {
            ls_seed_field( 'gl_photos', ls_seed_rows( 'gl_photos', $photos ), $id );
        }

        ls_seed_field( 'gl_share_heading', 'Share Your Memories', $id );
        ls_seed_field( 'gl_share_text', 'Tag us @looksrilanka and be part of our travel community.', $id );
    }

    /* Destinations: region for the filter ------------------------------ */

    $regions = array(
        'Cultural Triangle' => array( 'Anuradhapura', 'Polonnaruwa', 'Habarana', 'Sigiriya', 'Dambulla' ),
        'Hill Country'      => array( 'Kandy', 'Ella', 'Nuwaraeliya', 'Hatton', 'Rathnapura', 'Mahiyanganaya' ),
        'South Coast'       => array( 'Galle', 'Mirissa', 'Weligama', 'Hikkaduwa', 'Bentota' ),
        'West Coast'        => array( 'Colombo', 'Negombo', 'Kalpitiya' ),
        'East & North'      => array( 'Trincomalee', 'Passikuda', 'Arugambay', 'Jaffna' ),
        'Wildlife'          => array( 'Yala', 'Udawalawa', 'Galoya', 'Wilpattu' ),
    );
    $destinations = get_posts( array( 'post_type' => 'destination', 'numberposts' => -1, 'post_status' => 'any' ) );
    foreach ( $destinations as $destination ) {
        foreach ( $regions as $region => $places ) {
            foreach ( $places as $place ) {
                if ( 0 === stripos( $destination->post_title, $place ) ) {
                    ls_seed_field( 'ds_region', $region, $destination->ID );
                    break 2;
                }
            }
        }
    }

    /* About -------------------------------------------------------------- */

    $about = get_page_by_path( 'about-us' );
    if ( $about ) {
        $id    = $about->ID;
        $happy = get_field( 'make_you_happy', $id );
        $story = is_array( $happy ) && ! empty( $happy[0]['timage'] ) ? attachment_url_to_postid( $happy[0]['timage'] ) : 0;

        ls_seed_field( 'ab_hero_kicker', (string) get_field( 'sub_title', $id ), $id );
        ls_seed_field( 'ab_hero_heading', 'We grew up on this island. We just get to share it for a living.', $id );
        ls_seed_field( 'ab_hero_text', 'L S L Adventure Travels & Tours is a Sri Lanka-based tour operator. We design and run private tours across the island for independent travellers and for the travel agents who trust us with their clients.', $id );
        ls_seed_field( 'ab_story_kicker', 'Our story', $id );
        ls_seed_field( 'ab_story_heading', 'Personalised Sri Lanka journeys since 2010', $id );
        if ( $story ) {
            ls_seed_field( 'ab_story_image', $story, $id );
        }
        ls_seed_field( 'ab_guides_kicker', 'Our guides', $id );
        ls_seed_field( 'ab_guides_heading', 'Crafting your journey', $id );
        ls_seed_field( 'ab_stats', ls_seed_rows( 'ab_stats', array(
            array( 'number' => '2010', 'label' => 'Founded' ),
            array( 'number' => '14+', 'label' => 'Years of expertise' ),
            array( 'number' => '10K+', 'label' => 'Clients worldwide' ),
            array( 'number' => '4.9', 'label' => 'Rated on Tripadvisor' ),
        ) ), $id );
        ls_seed_field( 'ab_values_heading', 'What guides how we operate', $id );
        ls_seed_field( 'ab_values_intro', 'The same principles apply whether we\'re planning a two-person honeymoon or a large group for a partner agency.', $id );
        ls_seed_field( 'ab_values', ls_seed_rows( 'ab_values', array(
            array( 'icon' => 'shield', 'title' => 'Licensed, knowledgeable guides', 'text' => 'Professional chauffeur guides who are local storytellers and history keepers — for safe, comfortable and insightful journeys.' ),
            array( 'icon' => 'sliders', 'title' => 'Tailored to your style', 'text' => 'Every itinerary is matched to your interests, schedule and travel style, from tranquil retreats to adrenaline-packed adventures.' ),
            array( 'icon' => 'tag', 'title' => 'Honest, competitive pricing', 'text' => 'Reliable service at competitive prices, with no hidden extras and no surprises.' ),
        ) ), $id );
        ls_seed_field( 'ab_team_heading', 'The people behind the itineraries', $id );
        ls_seed_field( 'ab_team_intro', 'A small core team, backed by a wider network of licensed guides across the island.', $id );
        ls_seed_field( 'ab_cta_heading', 'Curious if we\'re the right fit for your trip?', $id );
        ls_seed_field( 'ab_cta_text', 'A quick conversation usually tells you more than a hundred reviews. We\'re happy to have one.', $id );
        ls_seed_field( 'ab_cta_btn', ls_seed_link( '/contact-us/', 'Get In Touch' ), $id );
    }

    /* Contact ------------------------------------------------------------ */

    $contact = get_page_by_path( 'contact-us' );
    if ( $contact ) {
        $id      = $contact->ID;
        $address = (string) get_field( 'address', 'option' );

        ls_seed_field( 'ct_hero_kicker', (string) get_field( 'sub_title', $id ), $id );
        ls_seed_field( 'ct_hero_heading', 'Let\'s plan your Sri Lanka trip', $id );
        ls_seed_field( 'ct_hero_text', 'Whether you\'re a traveller building a holiday or an agent building a programme, tell us where to start.', $id );
        ls_seed_field( 'ct_form_shortcode', '[contact-form-7 id="da98f42" title="Contact form 1"]', $id );
        ls_seed_field( 'ct_form_label', 'I\'m a Traveller', $id );
        ls_seed_field( 'ct_agent_label', 'I\'m a Travel Agent', $id );
        ls_seed_field( 'ct_whatsapp_text', 'Prefer chat? Message us on WhatsApp', $id );
        ls_seed_field( 'ct_map_heading', 'Find us', $id );
        if ( $address ) {
            ls_seed_field( 'ct_map_embed', '<iframe src="https://www.google.com/maps?q=' . rawurlencode( $address ) . '&output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Map"></iframe>', $id );
        }
        ls_seed_field( 'ct_faq_heading', 'Common questions', $id );
        ls_seed_field( 'ct_faq', ls_seed_rows( 'ct_faq', array(
            array( 'question' => 'How fast will I get a reply?', 'answer' => 'We aim to reply to every enquiry within one business day.' ),
            array( 'question' => 'Can I book a tour directly?', 'answer' => 'Yes — every itinerary on this site can be requested directly from its tour page, or we can tailor a trip for you.' ),
            array( 'question' => 'Do I need to pay to get a quote?', 'answer' => 'No. Quotes and draft itineraries are free.' ),
        ) ), $id );
        ls_seed_field( 'ct_faq_link', ls_seed_link( '/faq/', 'See all FAQs →' ), $id );
    }

    /* Tailor-made -------------------------------------------------------- */

    $tailor = get_page_by_path( 'tailor-made-2' );
    if ( $tailor ) {
        $id = $tailor->ID;
        if ( ! get_page_template_slug( $id ) ) {
            update_post_meta( $id, '_wp_page_template', 'page-tailor-made.php' );
        }

        ls_seed_field( 'tm_hero_kicker', 'Tailor-Made Tours', $id );
        ls_seed_field( 'tm_hero_heading', 'Skip the templates. Tell us what you actually want to see.', $id );
        ls_seed_field( 'tm_hero_text', 'Answer a few questions below and a trip designer will draft a route built entirely around your dates, pace and interests.', $id );
        ls_seed_field( 'tm_how_kicker', 'How it works', $id );
        ls_seed_field( 'tm_how_heading', 'From your answers to a draft itinerary', $id );
        ls_seed_field( 'tm_steps', ls_seed_rows( 'tm_steps', array(
            array( 'title' => 'Tell us your interests', 'text' => 'Dates, pace, budget range, and what you actually want to do.' ),
            array( 'title' => 'We draft a route', 'text' => 'A trip designer builds a day-by-day plan matched to your answers.' ),
            array( 'title' => 'You refine it', 'text' => 'Swap stops, add days, change hotels — until it feels right.' ),
            array( 'title' => 'Confirm & travel', 'text' => 'Confirm your dates and we take care of the rest.' ),
        ) ), $id );
        ls_seed_field( 'tm_inspo_kicker', 'For inspiration', $id );
        ls_seed_field( 'tm_inspo_heading', 'A few directions your trip could take', $id );
        ls_seed_field( 'tm_inspo', ls_seed_rows( 'tm_inspo', array(
            array( 'image' => ls_seed_attachment( '2025/06/A-Sri-Lankan-Safari-Symphony.jpg' ), 'label' => 'Wildlife & safari', 'link' => ls_seed_link( '/tour-type/wildlife-safari/', 'Wildlife & safari' ) ),
            array( 'image' => ls_seed_attachment( '2025/06/Kite-Surfing-Sri-Lanka.jpg' ), 'label' => 'Beach & island getaway', 'link' => ls_seed_link( '/tour-type/beach-island-getaway/', 'Beach & island getaway' ) ),
            array( 'image' => ls_seed_attachment( '2025/06/Soulful-Serendib-A-Wellness-Odyssey-in-Sri-Lanka.jpg' ), 'label' => 'Wellness & Ayurveda', 'link' => ls_seed_link( '/tour-type/wellness-ayurveda/', 'Wellness & Ayurveda' ) ),
            array( 'image' => ls_seed_attachment( '2025/06/From-Temples-to-Trails-A-Sri-Lankan-Story-for-Families.jpg' ), 'label' => 'Family-friendly', 'link' => ls_seed_link( '/tour-type/family-friendly/', 'Family-friendly' ) ),
        ) ), $id );
        ls_seed_field( 'tm_note', 'No payment required to enquire', $id );
        ls_seed_field( 'tm_side_heading', 'Why go custom', $id );
        ls_seed_field( 'tm_side_text', 'Our ready-made itineraries cover the most-requested routes, but every trip can be changed. Starting from your answers means the first draft already fits how you like to travel.', $id );
        ls_seed_field( 'tm_whatsapp_text', 'Prefer to talk it through? Message us', $id );
    }
}
