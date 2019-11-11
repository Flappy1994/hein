<?php

function SPDSGVOTermsConditionsShortcode(){
    return apply_filters('the_content', SPDSGVOSettings::get('terms_conditions'));
}

add_shortcode('terms_conditions', 'SPDSGVOTermsConditionsShortcode');
