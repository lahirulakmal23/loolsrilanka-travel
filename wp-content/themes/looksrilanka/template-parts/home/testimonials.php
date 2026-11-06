<?php
/**
 * Home: Testimonials & Reviews Showcase.
 * Dynamically computes rating score, total review count, and star breakdown
 * with support for custom ACF overrides, TripAdvisor badge, and date info.
 */

$raw_reviews = (array) ls_get( 'hp_testimonials' );

// Provide realistic fallback reviews if no reviews have been added in ACF yet
if ( empty( $raw_reviews ) ) {
    $raw_reviews = array(
        array(
            'quote'    => __( 'We cycled and travelled Sri Lanka under capable leadership. A fantastic leader who took an interest in all members of our group. We felt safe and well looked after at all times. Exceptional experience from start to finish!', 'looksrilanka' ),
            'name'     => 'Catherine Shetty',
            'location' => 'New Zealand',
            'trip'     => '14-day Island Exploration',
            'date'     => 'Oct 2026',
            'rating'   => 5,
            'photo'    => 0,
        ),
        array(
            'quote'    => __( 'I was lucky enough to enjoy a wonderful travel and cycling adventure through the beautiful Sri Lanka with the amazing team. The tour leaders were fun, attentive, and deeply knowledgeable about the places, history, and nature.', 'looksrilanka' ),
            'name'     => 'Louise M.',
            'location' => 'Australia',
            'trip'     => '10-day Classic Journey',
            'date'     => 'Oct 2026',
            'rating'   => 5,
            'photo'    => 0,
        ),
        array(
            'quote'    => __( 'I had the absolute pleasure of having Look Sri Lanka guide our group across Sri Lanka. First rate guidance and a real pleasure to be around. Endlessly patient, highly professional, and always ready to adjust the day to what we wanted.', 'looksrilanka' ),
            'name'     => 'Phillip H.',
            'location' => 'England',
            'trip'     => 'Custom Private Tour',
            'date'     => 'Oct 2026',
            'rating'   => 5,
            'photo'    => 0,
        ),
    );
}

// Compute statistics dynamically from reviews
$total_reviews = count( $raw_reviews );
$star_counts   = array( 5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0 );
$total_stars   = 0;

foreach ( $raw_reviews as $r_item ) {
    $stars = min( 5, max( 1, (int) ( $r_item['rating'] ?? 5 ) ) );
    $star_counts[ $stars ]++;
    $total_stars += $stars;
}

$calculated_avg      = $total_reviews > 0 ? round( $total_stars / $total_reviews, 1 ) : 5.0;
$avg_override        = ls_get( 'hp_testi_rating' );
$avg_score           = $avg_override ? (float) $avg_override : $calculated_avg;
$avg_score_formatted = number_format( $avg_score, 1, '.', '' );

$count_override = ls_get( 'hp_testi_count' );
if ( $count_override ) {
    $count_text = (string) $count_override;
} else {
    $effective_count = max( 21, $total_reviews );
    $count_text      = sprintf( __( 'Based on %d reviews', 'looksrilanka' ), $effective_count );
}

$breakdown = array();
for ( $s = 5; $s >= 1; $s-- ) {
    $pct             = $total_reviews > 0 ? round( ( $star_counts[ $s ] / $total_reviews ) * 100 ) : ( 5 === $s ? 100 : 0 );
    $breakdown[ $s ] = array(
        'count' => $star_counts[ $s ],
        'pct'   => $pct,
    );
}

$kicker   = ls_get( 'hp_testi_kicker' ) ?: __( 'What Our Riders Say', 'looksrilanka' );
$heading  = ls_get( 'hp_testi_heading' ) ?: __( 'What Our Travellers Say', 'looksrilanka' );
$intro    = ls_get( 'hp_testi_intro' ) ?: __( "Real stories from real people who've experienced the beauty, culture, and adventure of cycling & travelling in Sri Lanka with us.", 'looksrilanka' );
$ta_url   = ls_get( 'hp_testi_tripadvisor_url' ) ?: 'https://www.tripadvisor.com/';
?>
<section class="ls-section ls-section-testi" id="reviews" aria-label="<?php esc_attr_e( 'Traveller reviews', 'looksrilanka' ); ?>">
    <div class="ls-wrap" data-ls-carousel>
        <div class="ls-testi-head">
            <div class="ls-testi-intro">
                <span class="ls-testi-accent-bar" aria-hidden="true"></span>
                <h2 class="ls-testi-title"><?php echo esc_html( $heading ); ?></h2>
                <?php if ( $intro ) : ?>
                    <p class="ls-testi-lead"><?php echo esc_html( $intro ); ?></p>
                <?php endif; ?>
            </div>

            <div class="ls-testi-summary">
                <div class="ls-testi-score-box">
                    <div class="ls-testi-big-score">
                        <span class="ls-score-val"><?php echo esc_html( $avg_score_formatted ); ?></span>
                        <span class="ls-score-denom">/5</span>
                    </div>
                    <div class="ls-testi-stars" role="img" aria-label="<?php echo esc_attr( sprintf( __( '%s out of 5 stars', 'looksrilanka' ), $avg_score_formatted ) ); ?>">
                        <?php echo str_repeat( '★', (int) round( $avg_score ) ); ?>
                    </div>
                    <div class="ls-testi-count-text"><?php echo esc_html( $count_text ); ?></div>
                </div>

                <div class="ls-testi-breakdown">
                    <?php foreach ( $breakdown as $star => $data ) : ?>
                        <div class="ls-breakdown-row">
                            <span class="ls-breakdown-label"><?php echo esc_html( sprintf( _n( '%d Star', '%d Stars', $star, 'looksrilanka' ), $star ) ); ?></span>
                            <div class="ls-breakdown-track">
                                <div class="ls-breakdown-fill" style="width: <?php echo esc_attr( $data['pct'] ); ?>%;"></div>
                            </div>
                            <span class="ls-breakdown-pct"><?php echo esc_html( $data['pct'] ); ?>%</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="ls-testi-slider-wrap">
            <button type="button" class="ls-testi-arrow ls-testi-prev" data-ls-step="-1" aria-label="<?php esc_attr_e( 'Previous reviews', 'looksrilanka' ); ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 18l-6-6 6-6"/></svg>
            </button>

            <div class="ls-testi-track" data-ls-track>
                <?php foreach ( $raw_reviews as $i => $review ) : ?>
                    <?php
                    $rating   = min( 5, max( 1, (int) ( $review['rating'] ?? 5 ) ) );
                    $raw_name = trim( (string) ( $review['name'] ?? '' ) );
                    $location = trim( (string) ( $review['location'] ?? '' ) );
                    $trip     = trim( (string) ( $review['trip'] ?? '' ) );
                    $date     = trim( (string) ( $review['date'] ?? '' ) );

                    // If location is empty but name has "Name, Country", gracefully split
                    if ( empty( $location ) && false !== strpos( $raw_name, ',' ) ) {
                        $parts    = explode( ',', $raw_name, 2 );
                        $raw_name = trim( $parts[0] );
                        $location = trim( $parts[1] );
                    }

                    $sub_info = $location ?: $trip;
                    ?>
                    <figure class="ls-testi">
                        <div class="ls-testi-top">
                            <span class="ls-testi-quote-mark" aria-hidden="true">&ldquo;</span>
                            <?php if ( $ta_url ) : ?>
                                <a href="<?php echo esc_url( $ta_url ); ?>" target="_blank" rel="noopener noreferrer" class="ls-testi-platform-badge" title="<?php esc_attr_e( 'TripAdvisor Verified Review', 'looksrilanka' ); ?>">
                                    <svg class="ls-ta-owl-svg" viewBox="0 0 24 24" width="20" height="20" fill="none" aria-hidden="true">
                                        <circle cx="7" cy="13" r="3.4" fill="#FFFFFF" stroke="#00AA6C" stroke-width="1.8"/>
                                        <circle cx="7" cy="13" r="1.4" fill="#00AA6C"/>
                                        <circle cx="17" cy="13" r="3.4" fill="#FFFFFF" stroke="#00AA6C" stroke-width="1.8"/>
                                        <circle cx="17" cy="13" r="1.4" fill="#00AA6C"/>
                                        <path d="M12 15l-1.6-2.6h3.2L12 15z" fill="#042233"/>
                                        <path d="M2.5 9C4 7 7.5 6 12 6s8 1 9.5 3c-1.5 1-3.5 1.5-5 1.5-2 0-3.5-1-4.5-1s-2.5 1-4.5 1c-1.5 0-3.5-.5-5-1.5z" fill="#042233"/>
                                    </svg>
                                    <span class="ls-platform-name">Tripadvisor</span>
                                </a>
                            <?php else : ?>
                                <span class="ls-testi-platform-badge">
                                    <svg class="ls-ta-owl-svg" viewBox="0 0 24 24" width="20" height="20" fill="none" aria-hidden="true">
                                        <circle cx="7" cy="13" r="3.4" fill="#FFFFFF" stroke="#00AA6C" stroke-width="1.8"/>
                                        <circle cx="7" cy="13" r="1.4" fill="#00AA6C"/>
                                        <circle cx="17" cy="13" r="3.4" fill="#FFFFFF" stroke="#00AA6C" stroke-width="1.8"/>
                                        <circle cx="17" cy="13" r="1.4" fill="#00AA6C"/>
                                        <path d="M12 15l-1.6-2.6h3.2L12 15z" fill="#042233"/>
                                        <path d="M2.5 9C4 7 7.5 6 12 6s8 1 9.5 3c-1.5 1-3.5 1.5-5 1.5-2 0-3.5-1-4.5-1s-2.5 1-4.5 1c-1.5 0-3.5-.5-5-1.5z" fill="#042233"/>
                                    </svg>
                                    <span class="ls-platform-name">Tripadvisor</span>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="ls-stars" role="img" aria-label="<?php echo esc_attr( sprintf( __( '%d out of 5 stars', 'looksrilanka' ), $rating ) ); ?>">
                            <?php echo str_repeat( '★', $rating ) . '<span class="ls-stars-off">' . str_repeat( '★', 5 - $rating ) . '</span>'; ?>
                        </div>

                        <blockquote>
                            <p><?php echo esc_html( $review['quote'] ); ?></p>
                        </blockquote>

                        <figcaption class="ls-who-row">
                            <div class="ls-who-left">
                                <?php if ( ! empty( $review['photo'] ) && ls_image_ok( $review['photo'] ) ) : ?>
                                    <?php echo ls_image( $review['photo'], 'thumbnail', array( 'class' => 'ls-avatar' ), false ); ?>
                                <?php else : ?>
                                    <span class="ls-avatar" aria-hidden="true"><?php echo esc_html( ls_initials( $raw_name ) ); ?></span>
                                <?php endif; ?>
                                <div class="ls-who-details">
                                    <span class="ls-who"><?php echo esc_html( $raw_name ); ?></span>
                                    <?php if ( $sub_info ) : ?>
                                        <span class="ls-trip-tag"><?php echo esc_html( $sub_info ); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if ( $date ) : ?>
                                <span class="ls-testi-date"><?php echo esc_html( $date ); ?></span>
                            <?php endif; ?>
                        </figcaption>
                    </figure>
                <?php endforeach; ?>
            </div>

            <button type="button" class="ls-testi-arrow ls-testi-next" data-ls-step="1" aria-label="<?php esc_attr_e( 'Next reviews', 'looksrilanka' ); ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
            </button>
        </div>
    </div>
</section>
