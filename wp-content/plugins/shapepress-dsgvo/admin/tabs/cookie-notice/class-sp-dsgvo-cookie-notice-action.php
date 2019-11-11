<?php

Class SPDSGVOCookieNoticeAction extends SPDSGVOAjaxAction{

    protected $action = 'admin-cookie-notice';

    protected function run(){
        $this->requireAdmin();

        SPDSGVOSettings::set('cn_tracker_init', $this->get('cn_tracker_init', 'on_load'));

        SPDSGVOSettings::set('ga_enable_analytics', $this->get('ga_enable_analytics', '0'));
        SPDSGVOSettings::set('ga_tag_number', $this->get('ga_tag_number', ''));

        SPDSGVOSettings::set('fb_enable_pixel', $this->get('fb_enable_pixel', '0'));
        SPDSGVOSettings::set('fb_pixel_number', $this->get('fb_pixel_number', ''));

        SPDSGVOSettings::set('display_cookie_notice', $this->get('display_cookie_notice', '0'));
        SPDSGVOSettings::set('cookie_notice_custom_text', $this->get('cookie_notice_custom_text', ''));
        SPDSGVOSettings::set('cn_cookie_validity', $this->get('cn_cookie_validity', '86400'));

        SPDSGVOSettings::set('cn_button_text_ok', $this->get('cn_button_text_ok', ''));
        SPDSGVOSettings::set('cn_reload_on_confirm', $this->get('cn_reload_on_confirm', '0'));

        SPDSGVOSettings::set('cn_activate_cancel_btn', $this->get('cn_activate_cancel_btn', '0'));
        SPDSGVOSettings::set('cn_button_text_cancel', $this->get('cn_button_text_cancel', ''));
        SPDSGVOSettings::set('cn_decline_target_url', $this->get('cn_decline_target_url', ''));
        SPDSGVOSettings::set('cn_decline_no_cookie', $this->get('cn_decline_no_cookie', '0'));

        SPDSGVOSettings::set('cn_activate_more_btn', $this->get('cn_activate_more_btn', '0'));
        SPDSGVOSettings::set('cn_button_text_more', $this->get('cn_button_text_more', ''));
        SPDSGVOSettings::set('cn_read_more_page', $this->get('cn_read_more_page', ''));

        SPDSGVOSettings::set('cn_position', $this->get('cn_position', 'bottom'));
        SPDSGVOSettings::set('cn_animation', $this->get('cn_animation', 'none'));
        SPDSGVOSettings::set('cookie_notice_display', $this->get('cookie_notice_display', 'no_popup'));

        if (isValidBlogEdition() || isValidPremiumEdition())
        {
            SPDSGVOSettings::set('cn_background_color', $this->get('cn_background_color', '#333333'));
            SPDSGVOSettings::set('cn_text_color', $this->get('cn_text_color', '#ffffff'));
            SPDSGVOSettings::set('cn_background_color_button', $this->get('cn_background_color_button', '#F3F3F3'));
            SPDSGVOSettings::set('cn_text_color_button', $this->get('cn_text_color_button', '#333333'));
            SPDSGVOSettings::set('cn_custom_css_container', $this->get('cn_custom_css_container', ''));
            SPDSGVOSettings::set('cn_custom_css_text', $this->get('cn_custom_css_text', ''));
            SPDSGVOSettings::set('cn_custom_css_buttons', $this->get('cn_custom_css_buttons', ''));

            SPDSGVOSettings::set('cn_size_text', $this->get('cn_size_text', 'auto'));
            SPDSGVOSettings::set('cn_height_container', $this->get('cn_height_container', 'auto'));
            SPDSGVOSettings::set('cn_show_dsgvo_icon', $this->get('cn_show_dsgvo_icon', '0'));
            SPDSGVOSettings::set('cn_use_overlay', $this->get('cn_use_overlay', '0'));
        }

        if (isValidPremiumEdition())
        {
        /* i592995 */
            SPDSGVOSettings::set('logo_image_id', $this->get('logo_image_id', ''));
            SPDSGVOSettings::set('close_button_action', $this->get('close_button_action', '0'));
            SPDSGVOSettings::set('close_button_url', $this->get('close_button_url', ''));
            SPDSGVOSettings::set('accept_button_text', $this->get('accept_button_text', ''));
            SPDSGVOSettings::set('more_options_button_text', $this->get('more_options_button_text', ''));
            SPDSGVOSettings::set('accordion_top', $this->get('accordion_top', ''));
            SPDSGVOSettings::set('popup_background', $this->get('popup_background', '#ffffff'));
            SPDSGVOSettings::set('separators_color', $this->get('separators_color', '#f1f1f1'));
            SPDSGVOSettings::set('text_color', $this->get('text_color', '#222222'));
            SPDSGVOSettings::set('links_color', $this->get('links_color', '#4285f'));
            SPDSGVOSettings::set('links_color_hover', $this->get('links_color_hover', '#4285f'));
            SPDSGVOSettings::set('accept_button_text_color', $this->get('accept_button_text_color', '#ffffff'));
            SPDSGVOSettings::set('accept_button_bg_color', $this->get('accept_button_bg_color', '#4285f'));
            SPDSGVOSettings::set('ga_code', $this->get('ga_code', ''));
            SPDSGVOSettings::set('fb_pixel_code', $this->get('fb_pixel_code', ''));
            SPDSGVOSettings::set('own_code', $this->get('own_code', ''));
            /* i592995 */
        }

        $this->returnBack();
    }
}

SPDSGVOCookieNoticeAction::listen();
