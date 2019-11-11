<?php

class SPDSGVOCommonSettingsAction extends SPDSGVOAjaxAction
{

    protected $action = 'admin-common-settings';

    protected function run()
    {
        $this->requireAdmin();

        SPDSGVOSettings::set('admin_email', $this->get('admin_email', ''));
        SPDSGVOSettings::set('use_wpml_strings', $this->get('use_wpml_strings', '0'));

        SPDSGVOSettings::set('sp_dsgvo_comments_checkbox', $this->get('sp_dsgvo_comments_checkbox', '0'));
        if (isValidBlogEdition() || isValidPremiumEdition())
        {
            SPDSGVOSettings::set('spdsgvo_comments_checkbox_info', $this->get('spdsgvo_comments_checkbox_info', ''));
            SPDSGVOSettings::set('spdsgvo_comments_checkbox_confirm', $this->get('spdsgvo_comments_checkbox_confirm', ''));
            SPDSGVOSettings::set('spdsgvo_comments_checkbox_text', $this->get('spdsgvo_comments_checkbox_text', ''));
            SPDSGVOSettings::set('sp_dsgvo_cf7_acceptance_replace', $this->get('sp_dsgvo_cf7_acceptance_replace', ''));
        }

        SPDSGVOSettings::set('spdsgvo_company_info_name', $this->get('spdsgvo_company_info_name', ''));
        SPDSGVOSettings::set('spdsgvo_company_info_street', $this->get('spdsgvo_company_info_street', ''));
        SPDSGVOSettings::set('spdsgvo_company_info_loc_zip', $this->get('spdsgvo_company_info_loc_zip', ''));
        SPDSGVOSettings::set('spdsgvo_company_fn_nr', $this->get('spdsgvo_company_fn_nr', ''));
        SPDSGVOSettings::set('spdsgvo_company_law_loc', $this->get('spdsgvo_company_law_loc', ''));
        SPDSGVOSettings::set('spdsgvo_company_uid_nr', $this->get('spdsgvo_company_uid_nr', ''));
        SPDSGVOSettings::set('spdsgvo_company_law_person', $this->get('spdsgvo_company_law_person', ''));
        SPDSGVOSettings::set('spdsgvo_company_chairmen', $this->get('spdsgvo_company_chairmen', ''));
        SPDSGVOSettings::set('spdsgvo_company_resp_content', $this->get('spdsgvo_company_resp_content', ''));
        SPDSGVOSettings::set('spdsgvo_company_info_phone', $this->get('spdsgvo_company_info_phone', ''));
        SPDSGVOSettings::set('spdsgvo_company_info_fax', $this->get('spdsgvo_company_info_fax', ''));
        SPDSGVOSettings::set('spdsgvo_company_info_email', $this->get('spdsgvo_company_info_email', ''));
        SPDSGVOSettings::set('spdsgvo_newsletter_service', $this->get('spdsgvo_newsletter_service', ''));
        SPDSGVOSettings::set('spdsgvo_newsletter_service_privacy_policy_url', $this->get('spdsgvo_newsletter_service_privacy_policy_url', ''));

        $this->returnBack();
    }
}

SPDSGVOCommonSettingsAction::listen();
