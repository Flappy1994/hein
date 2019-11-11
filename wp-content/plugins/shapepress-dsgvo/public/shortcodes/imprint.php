<?php

function SPDSGVOImprintShortcode(){
    
    
    $imprint = SPDSGVOSettings::get('imprint');
    if(function_exists('icl_translate')) {
        $imprint = icl_translate('shapepress-dsgvo', 'imprint', $imprint);
    }

    if (spdsgvoUseWpml())
    {
        $imprint = file_get_contents(SPDSGVO::pluginDir('/templates/'.get_locale().'/imprint.txt'));
    }
    
    $imprint = str_replace('[company_name]', SPDSGVOSettings::get('spdsgvo_company_info_name'), $imprint);
    $imprint = str_replace('[company_owner]', SPDSGVOSettings::get('spdsgvo_company_law_person'), $imprint);
    $imprint = str_replace('[adress_street]', SPDSGVOSettings::get('spdsgvo_company_info_street'), $imprint);
    $imprint = str_replace('[adress_zip_location]', SPDSGVOSettings::get('spdsgvo_company_info_loc_zip'), $imprint);
    
    $imprint = str_replace('[company_management]', SPDSGVOSettings::get('spdsgvo_company_chairmen'), $imprint);
    $imprint = str_replace('[company_law_person]', SPDSGVOSettings::get('spdsgvo_company_law_person'), $imprint);
    $imprint = str_replace('[comm_phone]', SPDSGVOSettings::get('spdsgvo_company_info_phone'), $imprint);
    $imprint = str_replace('[comm_email]', SPDSGVOSettings::get('spdsgvo_company_info_email'), $imprint);
    
    $imprint = str_replace('[company_register_court]', SPDSGVOSettings::get('spdsgvo_company_law_loc'), $imprint);
    $imprint = str_replace('[company_register_nr]', SPDSGVOSettings::get('spdsgvo_company_fn_nr'), $imprint);
    $imprint = str_replace('[company_uid]', SPDSGVOSettings::get('spdsgvo_company_uid_nr'), $imprint);
    
    $imprint = str_replace('[content_responsible]', SPDSGVOSettings::get('spdsgvo_company_resp_content'), $imprint);
    
    
    $imprint = str_replace('[newsletter_service]', SPDSGVOSettings::get('spdsgvo_newsletter_service'), $imprint);
    $imprint = str_replace('[newsletter_service_privacy_policy]', SPDSGVOSettings::get('spdsgvo_newsletter_service_privacy_policy_url'), $imprint);
    
    $imprintPage = SPDSGVOSettings::get('imprint_page');
    
    $imprint = str_replace('[save_date]', date('d.m.Y H:i',strtotime(get_post($imprintPage)->post_modified)), $imprint);
    
    
    return apply_filters('the_content', $imprint);
}

add_shortcode('imprint', 'SPDSGVOImprintShortcode');
