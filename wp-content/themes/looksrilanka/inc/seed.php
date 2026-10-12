<?php
/**
 * One-time content setup for the redesign.
 *
 * Fills the new ACF fields with starting content (taken from the existing
 * site where possible) so every section is editable in wp-admin right away.
 * Only empty fields are written, so it never overwrites the client's edits.
 * Runs when the theme is activated, or manually: wp eval 'ls_seed_content();'
 */

add_action( 'after_switch_theme', 'ls_seed_content' );

add_action( 'admin_init', function () {
    if ( get_option( 'ls_seeded_version' ) !== LS_VERSION ) {
        ls_seed_content();
    }
} );

/**
 * Finds an attachment ID by its path under wp-content/uploads (e.g. "2025/02/Ella-Home.jpg").
 */
function ls_seed_attachment( $path ) {
    $uploads = wp_get_upload_dir();
    return (int) attachment_url_to_postid( trailingslashit( $uploads['baseurl'] ) . $path );
}

function ls_seed_link( $path, $title ) {
    return array( 'url' => home_url( $path ), 'title' => $title, 'target' => '' );
}

/**
 * Converts rows keyed by sub field name into rows keyed by sub field key.
 */
function ls_seed_rows( $parent, $rows ) {
    $keyed = array();
    foreach ( $rows as $row ) {
        $out = array();
        foreach ( $row as $name => $value ) {
            $out[ 'field_ls_' . $parent . '__' . $name ] = $value;
        }
        $keyed[] = $out;
    }
    return $keyed;
}

function ls_seed_field( $name, $value, $post_id ) {
    $current = get_field( $name, $post_id, false );
    if ( ! empty( $current ) || ( is_string( $current ) && '' !== $current ) ) {
        return;
    }
    update_field( 'field_ls_' . $name, $value, $post_id );
}

function ls_seed_content() {
    if ( ! function_exists( 'update_field' ) ) {
        return;
    }

    $front = (int) get_option( 'page_on_front' );
    $brand = 'L S L Adventure Travels & Tours';

    /* Site settings ---------------------------------------------------- */

    ls_seed_field( 'ls_header_cta', ls_seed_link( '/tailor-made-2/', 'Plan My Trip' ), 'option' );
    ls_seed_field( 'ls_whatsapp', '94766603699', 'option' );
    ls_seed_field( 'ls_whatsapp_message', 'Hello! I would like to plan a trip to Sri Lanka.', 'option' );
    ls_seed_field( 'ls_social', ls_seed_rows( 'ls_social', array(
        array( 'network' => 'instagram', 'url' => 'https://www.instagram.com/lsladventuretours/' ),
        array( 'network' => 'facebook', 'url' => 'https://web.facebook.com/lsladventuretours.srilanka' ),
        array( 'network' => 'tiktok', 'url' => 'https://www.tiktok.com/@lsladventuretourslk' ),
        array( 'network' => 'tripadvisor', 'url' => 'https://www.tripadvisor.com/Attraction_Review-g297897-d11660643-Reviews-LSL_Adventure_Tours-Negombo_Western_Province.html' ),
    ) ), 'option' );
    ls_seed_field( 'ls_footer_about', 'A Sri Lanka-based inbound tour operator crafting private, tailor-made journeys across the island with licensed chauffeur guides.', 'option' );
    ls_seed_field( 'ls_footer_explore_title', 'Explore', 'option' );
    ls_seed_field( 'ls_footer_company_title', 'Company', 'option' );
    ls_seed_field( 'ls_footer_contact_title', 'Reach us', 'option' );
    ls_seed_field( 'ls_footer_legal', ls_seed_rows( 'ls_footer_legal', array(
        array( 'link' => ls_seed_link( '/privacy-policy/', 'Privacy Policy' ) ),
        array( 'link' => ls_seed_link( '/terms-conditions/', 'Terms & Conditions' ) ),
    ) ), 'option' );

    /* Home page -------------------------------------------------------- */

    if ( $front ) {
        ls_seed_field( 'hp_slides', ls_seed_rows( 'hp_slides', array(
            array(
                'image'   => ls_seed_attachment( '2025/02/Sigiriya-Home-01.jpg' ),
                'eyebrow' => 'Cultural Triangle',
                'heading' => 'The island, planned by the people who actually live here.',
                'lead'    => $brand . ' designs private, small-group and tailor-made tours across Sri Lanka — with licensed chauffeur guides and support from enquiry to departure.',
                'badge'   => '+10K travellers from around the world',
            ),
            array(
                'image'   => ls_seed_attachment( '2025/02/Ella-Home.jpg' ),
                'eyebrow' => 'Hill Country',
                'heading' => 'Tea estates, mist and the train ride everyone talks about.',
                'lead'    => 'Kandy to Ella through rolling tea country, with stops built around the view, not the clock.',
                'badge'   => 'Featured in our 7 to 16 day itineraries',
            ),
            array(
                'image'   => ls_seed_attachment( '2025/02/Yala-Home-02.jpg' ),
                'eyebrow' => 'Wildlife',
                'heading' => 'Leopards, elephants, and a tracker who knows their routines.',
                'lead'    => 'Game drives at Yala timed for dawn and dusk sightings.',
                'badge'   => 'A Sri Lankan Safari Symphony · 9 days',
            ),
            array(
                'image'   => ls_seed_attachment( '2025/02/Mirissa-Home-01.jpg' ),
                'eyebrow' => 'Southern Coast',
                'heading' => 'Colonial ramparts by day, whales offshore by morning.',
                'lead'    => 'Galle Fort, Mirissa\'s boats and slow beach days to end your journey.',
                'badge'   => 'Whale watching, seasonal Nov–Apr',
            ),
            array(
                'image'   => ls_seed_attachment( '2025/02/Kandy-Home-01.jpg' ),
                'eyebrow' => 'Tailor-Made',
                'heading' => 'Your dates, your pace, your Sri Lanka.',
                'lead'    => 'Tell us how you like to travel and we will build the route around it — with no hidden charges.',
                'badge'   => '100% customisable itineraries',
            ),
        ) ), $front );
        ls_seed_field( 'hp_hero_btn_1', ls_seed_link( '/tour/', 'Browse Itineraries' ), $front );
        ls_seed_field( 'hp_hero_btn_2', ls_seed_link( '/tailor-made-2/', 'Talk to a Trip Designer' ), $front );
        ls_seed_field( 'hp_hero_interval', 6, $front );

        ls_seed_field( 'hp_trust', ls_seed_rows( 'hp_trust', array(
            array( 'text' => 'Tripadvisor Certificate of Excellence' ),
            array( 'text' => 'Rated 4.9 on Tripadvisor' ),
            array( 'text' => '10K+ Clients Worldwide' ),
            array( 'text' => 'Licensed Chauffeur Guides' ),
        ) ), $front );

        ls_seed_field( 'hp_ways_kicker', 'Where to begin', $front );
        ls_seed_field( 'hp_ways_heading', 'Three ways to explore the island', $front );
        ls_seed_field( 'hp_ways_intro', 'Whether you need a ready-made route, a single day out from your hotel, or a fully bespoke itinerary — start here.', $front );
        ls_seed_field( 'hp_ways', ls_seed_rows( 'hp_ways', array(
            array(
                'image' => ls_seed_attachment( '2025/01/Explore-the-Heart-of-Sri-Lankas-Culture-and-Heritage-scaled.jpg' ),
                'title' => 'Multi-Day Itineraries',
                'count' => '{tours} routes',
                'text'  => 'Curated routes through the hill country, coast and cultural triangle — fixed or fully customisable.',
                'link'  => ls_seed_link( '/tour/', 'View itineraries →' ),
            ),
            array(
                'image' => ls_seed_attachment( '2024/12/Arugambay-copy-scaled.jpg' ),
                'title' => 'Experiences',
                'count' => '{experiences} activities',
                'text'  => 'Surfing, rafting, hot-air ballooning, whale watching and more — add an adventure to any trip.',
                'link'  => ls_seed_link( '/experiences/', 'See experiences →' ),
            ),
            array(
                'image' => ls_seed_attachment( '2025/02/Weligama-Home-01.jpg' ),
                'title' => 'Tailor-Made & Group Tours',
                'count' => '',
                'text'  => 'Tell us your dates and interests and we will design a private or group itinerary around you.',
                'link'  => ls_seed_link( '/tailor-made-2/', 'Start planning →' ),
            ),
        ) ), $front );

        ls_seed_field( 'hp_why_kicker', 'Why book through us', $front );
        ls_seed_field( 'hp_why_heading', 'Ground knowledge you can\'t get from a listing page', $front );
        ls_seed_field( 'hp_why', ls_seed_rows( 'hp_why', array(
            array( 'icon' => 'star', 'title' => 'Local expertise', 'text' => 'A friendly team of knowledgeable travel consultants who guide you with your best interests in mind.' ),
            array( 'icon' => 'support', 'title' => 'Support from enquiry to departure', 'text' => 'From your first question until the end of your tour, we give every detail our full attention.' ),
            array( 'icon' => 'tag', 'title' => 'No hidden charges', 'text' => 'Travel permits, lodging and meals are included as quoted. No surprises with hidden costs.' ),
            array( 'icon' => 'sliders', 'title' => '100% customisable', 'text' => 'Tell us your travel needs and we will tailor the trip to them for an unforgettable experience.' ),
        ) ), $front );
        ls_seed_field( 'hp_why_caption', 'A classic route: Sigiriya, Kandy, Ella and Galle', $front );

        ls_seed_field( 'hp_b2b_show', 1, $front );
        ls_seed_field( 'hp_b2b_heading', 'Selling Sri Lanka to your clients? Let us run the ground.', $front );
        ls_seed_field( 'hp_b2b_text', 'We partner with international travel agents: tailored itineraries, competitive rates and one operations contact for every group you send.', $front );
        ls_seed_field( 'hp_b2b_btn', ls_seed_link( '/contact-us/', 'Become a Partner Agent' ), $front );

        ls_seed_field( 'hp_testi_kicker', 'In their words', $front );
        ls_seed_field( 'hp_testi_heading', 'Trusted by travellers from around the world', $front );
        ls_seed_field( 'hp_testimonials', ls_seed_rows( 'hp_testimonials', ls_seed_existing_reviews( $front ) ), $front );

        ls_seed_field( 'hp_cta_heading', 'Ready to see the island properly?', $front );
        ls_seed_field( 'hp_cta_text', 'Tell us your dates and interests — we\'ll send a draft itinerary within one business day.', $front );
        ls_seed_field( 'hp_cta_btn', ls_seed_link( '/contact-us/', 'Get a Custom Quote' ), $front );
    }

    ls_seed_inner_pages();

    update_option( 'ls_seeded_version', LS_VERSION );
}

/**
 * Copies reviews from the old home page "review" repeater.
 */
function ls_seed_existing_reviews( $front ) {
    $rows = array();
    $old  = get_field( 'review', $front );

    if ( ! is_array( $old ) ) {
        return $rows;
    }

    foreach ( $old as $review ) {
        $name  = trim( (string) ( $review['name_rw'] ?? '' ) );
        $place = trim( (string) ( $review['place_rw'] ?? '' ) );
        $photo = $review['image_rw'] ?? '';

        if ( is_array( $photo ) ) {
            $photo = $photo['ID'] ?? 0;
        } elseif ( is_string( $photo ) && '' !== $photo ) {
            $photo = attachment_url_to_postid( $photo );
        }

        $rows[] = array(
            'quote'  => trim( wp_strip_all_tags( (string) ( $review['review_ew'] ?? '' ) ) ),
            'name'   => $place ? $name . ', ' . $place : $name,
            'trip'   => '',
            'rating' => 5,
            'photo'  => (int) $photo,
        );
    }

    return $rows;
}
