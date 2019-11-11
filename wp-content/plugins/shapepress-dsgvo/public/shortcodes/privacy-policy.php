<?php

/*
 * params to replace
 * 
 * [Einsetzen: DemoShop e.K., Inhaber: Max Muster Demostraße 1, 12345 Demostadt]
 * [BITTE DATUM DER LETZTEN AKTUALISIERUNG EINTRAGEN]
 * 
 */

function SPDSGVOPrivacyPolicyShortcode(){
    
    $privacyPolicy = SPDSGVOSettings::get('privacy_policy');
    if(function_exists('icl_translate')) {
        $privacyPolicy = icl_translate('shapepress-dsgvo', 'privacy_policy', $privacyPolicy);
    }

    if (spdsgvoUseWpml())
    {
        $privacyPolicy = file_get_contents(SPDSGVO::pluginDir('/templates/'.get_locale().'/privacy-policy.txt'));
    }
    
    $privacyPolicy = str_replace('[company_name]', SPDSGVOSettings::get('spdsgvo_company_info_name'), $privacyPolicy);
    $privacyPolicy = str_replace('[company_owner]', SPDSGVOSettings::get('spdsgvo_company_law_person'), $privacyPolicy);
    $privacyPolicy = str_replace('[adress_street]', SPDSGVOSettings::get('spdsgvo_company_info_street'), $privacyPolicy);
    $privacyPolicy = str_replace('[adress_zip_location]', SPDSGVOSettings::get('spdsgvo_company_info_loc_zip'), $privacyPolicy);
    
    $privacyPolicy = str_replace('[company_management]', SPDSGVOSettings::get('spdsgvo_company_chairmen'), $privacyPolicy);
    $privacyPolicy = str_replace('[comm_phone]', SPDSGVOSettings::get('spdsgvo_company_info_phone'), $privacyPolicy);
    $privacyPolicy = str_replace('[comm_email]', SPDSGVOSettings::get('spdsgvo_company_info_email'), $privacyPolicy);
    
    $privacyPolicy = str_replace('[company_register_court]', SPDSGVOSettings::get('spdsgvo_company_law_loc'), $privacyPolicy);
    $privacyPolicy = str_replace('[company_register_nr]', SPDSGVOSettings::get('spdsgvo_company_fn_nr'), $privacyPolicy);
    $privacyPolicy = str_replace('[company_uid]', SPDSGVOSettings::get('spdsgvo_company_uid_nr'), $privacyPolicy);
    
    $privacyPolicy = str_replace('[content_responsible]', SPDSGVOSettings::get('spdsgvo_company_resp_content'), $privacyPolicy);
    
    $privacyPolicy = str_replace('[newsletter_service]', SPDSGVOSettings::get('spdsgvo_newsletter_service'), $privacyPolicy);
    $newsletterTerms = SPDSGVOSettings::get('spdsgvo_newsletter_service_privacy_policy_url');
    $privacyPolicy = str_replace('[newsletter_service_privacy_policy]', '<a target="_blank" href="'.$newsletterTerms.'">'.$newsletterTerms.'</a>' , $privacyPolicy);
    
    $privacyPolicyPage = SPDSGVOSettings::get('privacy_policy_page');

    if(get_post($privacyPolicyPage) instanceof WP_POST) {
        $privacyPolicy = str_replace('[save_date]', date('d.m.Y H:i',strtotime(get_post($privacyPolicyPage)->post_modified)), $privacyPolicy);
    }

    return apply_filters('the_content', $privacyPolicy);
}

add_shortcode('privacy_policy', 'SPDSGVOPrivacyPolicyShortcode');
