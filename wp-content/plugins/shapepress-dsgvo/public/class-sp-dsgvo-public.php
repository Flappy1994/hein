<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wp-dsgvo.eu
 * @since      1.0.0
 *
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package WP DSGVO Tools
 * @subpackage WP DSGVO Tools/public
 * @author Shapepress eU
 */
class SPDSGVOPublic
{

    /**
     * Initialize the class and set its properties.
     *
     * @since 1.0.0
     * @param string $sp_dsgvo
     *            The name of the plugin.
     * @param string $version
     *            The version of this plugin.
     */
    public function __construct()
    {
    }

    private static $cookie = array(
        'name' => 'sp_dsgvo_cn_accepted',
        'value' => 'TRUE'
    );
    
    private static $cookiePopup = array(
        'name' => 'sp_dsgvo_popup',
        'value' => '1'
    );

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since 1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style(sp_dsgvo_NAME, plugin_dir_url(__FILE__) . 'css/sp-dsgvo-public.css', array(), sp_dsgvo_VERSION, 'all');
        /* i592995 */
        wp_enqueue_style('simplebar', plugin_dir_url(__FILE__) . 'css/simplebar.css');
        /* i592995 */
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since 1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script(sp_dsgvo_NAME, plugin_dir_url(__FILE__) . 'js/sp-dsgvo-public.js', array(
            'jquery'
        ), sp_dsgvo_VERSION, FALSE);

        $cf7AccText = SPDSGVOSettings::get('spdsgvo_comments_checkbox_text');
        if(function_exists('icl_translate')) {
            $cf7AccText = icl_translate('shapepress-dsgvo', 'spdsgvo_comments_checkbox_text', $cf7AccText);
        }

        wp_localize_script(sp_dsgvo_NAME, 'cnArgs', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'hideEffect' => SPDSGVOSettings::get('cn_animation'),
            'onScroll' => false,
            'onScrollOffset' => 100,
            'cookieName' => self::$cookie['name'],
            'cookieValue' => self::$cookie['value'],
            'cookieTime' => SPDSGVOSettings::get('cn_cookie_validity'),
            'cookiePath' => (defined('COOKIEPATH') ? COOKIEPATH : ''),
            'cookieDomain' => (defined('COOKIE_DOMAIN') ? COOKIE_DOMAIN : ''),
            'redirection' => SPDSGVOSettings::get('cn_reload_on_confirm'),
            'reloadOnConfirm' => SPDSGVOSettings::get('cn_reload_on_confirm'),
            'trackerInitMoment' => SPDSGVOSettings::get('cn_tracker_init'),
            'gaTagNumber' => SPDSGVOSettings::get('ga_tag_number'),
            'cache' => defined('WP_CACHE') && WP_CACHE,
            'declineTargetUrl' => SPDSGVOSettings::get('cn_decline_target_url'),
            'declineNoCookie' => SPDSGVOSettings::get('cn_decline_no_cookie'),
            'commentsCb'=> SPDSGVOSettings::get('sp_dsgvo_comments_checkbox'),
            'cf7AccReplace' => SPDSGVOSettings::get('sp_dsgvo_cf7_acceptance_replace'),
            'cf7AccText' => $cf7AccText,
        ));

        /* i592995 */
        wp_enqueue_script('simplebar', plugin_dir_url(__FILE__) . 'js/simplebar.js', array(
            'jquery'
        ), null, true);
        /* i592995 */
    }

    /**
     * Print scripts for GA, FB Pixel,..
     * if enabled
     *
     * @return mixed
     */
    public function wp_print_footer_scripts()
    {
        // $allowed_html = apply_filters( 'cn_refuse_code_allowed_html', array_merge( wp_kses_allowed_html( 'post' ), array(
        // 'script' => array(
        // 'type' => array(),
        // 'src' => array(),
        // 'charset' => array(),
        // 'async' => array()
        // ),
        // 'noscript' => array()
        // ) ) );

        // $scripts = apply_filters( 'cn_refuse_code_scripts_html', html_entity_decode( trim( wp_kses( $this->options['general']['refuse_code'], $allowed_html ) ) ) );
        $scripts = ''; // 'place_for_scripts';

        if ($this->cookies_accepted() && ! empty($scripts)) {
            echo $scripts;
        }
    }

    /**
     * Checks if cookie is setted
     *
     * @return bool
     */
    public function cookies_set()
    {
        return apply_filters('cn_is_cookie_set', isset($_COOKIE[self::$cookie['name']]));
    }

    /**
     * Checks if third party non functional cookies are accepted
     *
     * @return bool
     */
    public static function cookies_accepted()
    {
        
        $noticeAccepted = isset($_COOKIE[self::$cookie['name']]) && strtoupper($_COOKIE[self::$cookie['name']]) === self::$cookie['value'];
        $popupAccepted  = isset($_COOKIE[self::$cookiePopup['name']]) && strtoupper($_COOKIE[self::$cookiePopup['name']]) === self::$cookiePopup['value'];
        
        return apply_filters('cn_is_cookie_accepted', $noticeAccepted || $popupAccepted);
    }

    public function cookieNotice()
    {
        /* i592995 */
        if (SPDSGVOSettings::get('cookie_notice_display') == 'cookie_notice') :
            /* i592995 */
            if (hasUserGivenPermissionFor('cookies') === FALSE) :
                ?>

             <?php if (SPDSGVOSettings::get('cn_use_overlay') === '1') : ?>
                     	<div id="cookie-notice-blocker"></div>
              <?php endif; ?>

<div id="cookie-notice" role="banner"
            	class="cn-<?= SPDSGVOSettings::get('cn_position') ?> <?= SPDSGVOSettings::get('cn_custom_css_container') !== '' ? SPDSGVOSettings::get('cn_custom_css_container'):'' ?>"
            	style="background-color: <?= SPDSGVOSettings::get('cn_background_color') ?>;
            	       color: <?= SPDSGVOSettings::get('cn_text_color') ?>;
            	       height: <?= SPDSGVOSettings::get('cn_height_container') ?>;">
	<div class="cookie-notice-container">

            	<?php if (SPDSGVOSettings::get('cn_show_dsgvo_icon') === '1') : ?>
            		<span id="cn-notice-icon"><a
			href="https://wp-dsgvo.eu" target="_blank"><img id="cn-notice-icon"
				src="<?= plugin_dir_url(__FILE__) . 'images/cookie-icon.png' ?>"
				alt="DSGVO Logo" style="display:block !important;" /></a></span>
            	<?php endif; ?>

            	<span id="cn-notice-text" class="<?= SPDSGVOSettings::get('cn_custom_css_text') !== '' ? SPDSGVOSettings::get('cn_custom_css_text'):'' ?>"
            		style="font-size:<?= SPDSGVOSettings::get('cn_size_text') ?>;"
            	><?= spdsgvoUseWpml() ? __('We use cookies to give you the best user experience. If you continue to use this site, we assume that you agree.','shapepress-dsgvo') : convDeChars(SPDSGVOSettings::get('cookie_notice_custom_text')) ?></span>

                <?php
                $button_ok = SPDSGVOSettings::get('cn_button_text_ok');
                if(function_exists('icl_translate')) {
                    $button_ok = icl_translate('shapepress-dsgvo', 'cn_button_text_ok', $button_ok);
                }
                ?>

				<a href="#" id="cn-accept-cookie" data-cookie-set="accept"
					class="cn-set-cookie button wp-default <?= SPDSGVOSettings::get('cn_custom_css_buttons') !== '' ? SPDSGVOSettings::get('cn_custom_css_buttons'):'' ?>"
					style="background-color: <?= SPDSGVOSettings::get('cn_background_color_button') ?>;
            	       color: <?= SPDSGVOSettings::get('cn_text_color_button') ?>;"
					><?= spdsgvoUseWpml() ? __('Ok','shapepress-dsgvo') : $button_ok; ?></a>

            <?php
            $button_cancel = SPDSGVOSettings::get('cn_button_text_cancel');
            if(function_exists('icl_translate')) {
                $button_cancel = icl_translate('shapepress-dsgvo', 'cn_button_text_cancel', $button_cancel);
            }
            ?>

	      <?php if(SPDSGVOSettings::get('cn_activate_cancel_btn') != '0'): ?>
				<a href="#" id="cn-refuse-cookie"
					data-cookie-set="refuse" class="cn-set-cookie button wp-default <?= SPDSGVOSettings::get('cn_custom_css_buttons') !== '' ? SPDSGVOSettings::get('cn_custom_css_buttons'):'' ?>"
					style="background-color: <?= SPDSGVOSettings::get('cn_background_color_button') ?>;
            	       color: <?= SPDSGVOSettings::get('cn_text_color_button') ?>;"
					><?= spdsgvoUseWpml() ? __('Decline','shapepress-dsgvo') : $button_cancel; ?></a>
		  <?php endif; ?>

          <?php
          $button_more = SPDSGVOSettings::get('cn_button_text_more');
          if(function_exists('icl_translate')) {
              $button_more = icl_translate('shapepress-dsgvo', 'cn_button_text_more', $button_more);
          }
          ?>

		  <?php if(SPDSGVOSettings::get('cn_activate_more_btn') != '0'): ?>
				<a
        			href="<?= get_permalink(SPDSGVOSettings::get('cn_read_more_page')) ?>"
        			id="cn-more-info"
        			target="<?= SPDSGVOSettings::get('cn_decline_target_url') ?>"
        			class="cn-more-info button wp-default <?= SPDSGVOSettings::get('cn_custom_css_buttons') !== '' ? SPDSGVOSettings::get('cn_custom_css_buttons'):'' ?>"
        			style="background-color: <?= SPDSGVOSettings::get('cn_background_color_button') ?> !important;
            	       color: <?= SPDSGVOSettings::get('cn_text_color_button') ?> !important;"
        			><?= spdsgvoUseWpml() ? __('Read more','shapepress-dsgvo') : $button_more; ?></a>
		  <?php endif; ?>

            	 </div>
</div>


<?php
			endif;
		endif;


    }

    /**
    * This function renders the privacy policy popup [i592995]
    */
    public function policyPopup()
    {
        if (SPDSGVOSettings::get('cookie_notice_display') == 'policy_popup') :
            $overlay_class = 'dsgvo-popup-overlay sp-dsgvo-framework dsgvo-overlay-hidden';
            if(!hasUserAcceptedPopup()) {
                $overlay_class .= ' not-accepted';
            }
            ?>
            <div class="<?php echo $overlay_class; ?>">
                <div class="dsgvo-privacy-popup">

                    <div class="dsgvo-popup-top">
                        <div class="dsgvo-logo-wrapper">
                            <?php
                            $src = sp_dsgvo_URL . 'public/images/logo-md.png';
                            $img_id = SPDSGVOSettings::get('logo_image_id', '');
                            if($img_id != '') {
                                $src = wp_get_attachment_url(intval($img_id));
                            }
                            ?>
                            <img src="<?php echo $src; ?>" class="dsgvo-popup-logo" />
                        </div><!-- .logo-wrapper -->

                        <div class="dsgvo-lang-wrapper">
                            <?php if(function_exists('icl_get_languages')) : ?>
                                <?php $langs = icl_get_languages('skip_missing=1'); ?>
                                <?php if(count($langs) > 0) : ?>
                                    <div class="dsgvo-popup-language-switcher">

                                        <?php foreach($langs as $lang) : ?>
                                            <?php if($lang['active'] == 1) : ?>
                                                <span class="dsgvo-lang-active">
                                                    <img src="<?php echo $lang['country_flag_url']; ?>" />
                                                    <span><?php echo $lang['native_name']; ?></span>
                                                    <svg width="10" height="6">
                                                         <line x1="0" y1="0" x2="5" y2="5" />
                                                         <line x1="5" y1="5" x2="10" y2="0" />
                                                    </svg>
                                                </span>
                                                <?php break; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>

                                        <div class="dsgvo-lang-dropdown">
                                            <?php foreach($langs as $lang) : ?>
                                                <a href="<?php echo $lang['url']; ?>">
                                                    <img src="<?php echo $lang['country_flag_url']; ?>" />
                                                    <span><?php echo $lang['native_name']; ?></span>
                                                </a>
                                            <?php endforeach; ?>
                                        </div><!-- .dsgvo-lang-dropdown -->

                                    </div><!-- .popup-language-switcher -->
                                <?php endif; ?>
                            <?php endif; ?>
                        </div><!-- .lang-wrapper -->

                        <?php
                        $url = SPDSGVOSettings::get('close_button_url', '#');
                        $action = SPDSGVOSettings::get('close_button_action', '0');
                        $additional_class = '';
                        if($url == '' || $action == '' || $action == '0') {
                            $url = '#';
                            $additional_class = 'close';
                        }
                        if(function_exists('icl_translate')) {
                            $url = icl_translate('shapepress-dsgvo', 'close_button_url', $url);
                        }
                        ?>

                        <a href="<?php echo $url; ?>" id="dsgvo_popup_close" class="dsgvo-popup-close <?php echo $additional_class; ?>">
                            <svg width="10" height="10">
                                <line x1="0" y1="0" x2="10" y2="10" />
                                <line x1="0" y1="10" x2="10" y2="0" />
                            </svg><!-- #dsgvo_popup_close -->
                        </a>

                    </div><!-- .popup-top -->

                    <div class="dsgvo-privacy-content">
                        <div class="dsgvo-privacy-inner">
                            <?php echo do_shortcode('[privacy_policy]'); ?>
                            <div class="dsgvo-popup-accordion" id="dsgvo_popup_accordion">

                                <div class="dsgvo-accordion-top">
                                    <?php
                                    $accordion_top = SPDSGVOSettings::get('accordion_top', '');
                                    if($accordion_top == '') {
                                        $accordion_top = __('More options', 'shapepress-dsgvo');
                                    }
                                    if(function_exists('icl_translate')) {
                                        $accordion_top = icl_translate('shapepress-dsgvo', 'accordion_top', $accordion_top);
                                    }
                                    ?>
                                    <span><?php echo $accordion_top; ?></span>
                                    <div class="toggle">
                                        <svg width="14" height="8">
                                             <line x1="0" y1="0" x2="7" y2="6" />
                                             <line x1="7" y1="6" x2="14" y2="0" />
                                        </svg>
                                    </div><!-- .toggle -->
                                </div><!-- .dsgvo-accordion-top -->

                                <div class="dsgvo-accordion-wrapper">
                                    <div class="dsgvo-accordion-inner">
                                        <?php echo do_shortcode('[user_privacy_settings_form_alt]'); ?>
                                    </div><!-- .dsgvo-accordion-inner -->
                                </div><!-- .dsgvo-accordion-wrapper -->

                            </div><!-- .dsgvo-popup-accordion -->
                        </div><!-- .dsgvo-privacy-inner -->
                    </div><!-- .dsgvo-privacy-content -->

                    <div class="dsgvo-popup-bottom">
                        <a href="#" id="more_options_button" class="dsgvo-more-options-button">
                            <?php
                            $more_text = SPDSGVOSettings::get('more_options_button_text', '');
                            if($more_text == '') {
                                $more_text = __('More options', 'shapepress-dsgvo');
                            }
                            if(function_exists('icl_translate')) {
                                $more_text = icl_translate('shapepress-dsgvo', 'more_options_button_text', $more_text);
                            }
                            echo $more_text;
                            ?>
                        </a>
                        <a href="#" id="popup_accept_button" class="dsgvo-accept-button">
                            <?php
                            $accept_text = SPDSGVOSettings::get('accept_button_text', '');
                            if($accept_text == '') {
                                $accept_text = __('Accept', 'shapepress-dsgvo');
                            }
                            if(function_exists('icl_translate')) {
                                $accept_text = icl_translate('shapepress-dsgvo', 'accept_button_text', $accept_text);
                            }
                            echo $accept_text;
                            ?>
                            <svg class="dsgvo-accept-loader" width="30" height="30">
                                <circle cx="15" cy="15" r="10" />
                            </svg><!-- .dsgvo-accept-loader -->
                        </a><!-- #popup_accept_button -->
                    </div><!-- .dsgvo-popup-bottom -->

                </div><!-- .dsgvo-privacy-popup -->
            </div><!-- .dsgvo-popup-overlay -->
        <?php
        endif;
    }

    public function writeHeaderScripts()
    {
        //error_log('cn_tracker_init: '. SPDSGVOSettings::get('cn_tracker_init'));
        if (SPDSGVOSettings::get('cn_tracker_init') === 'on_load') {
//             error_log('google-analytics: '. hasUserGivenPermissionFor('google-analytics'));
//             error_log('google-analytics permission: '. hasUserGivenPermissionFor('google-analytics') ? 'true': 'false');
            if (hasUserGivenPermissionFor('google-analytics')) {
                $this->writeGoogleAnalyticsOptOut();
                $this->writeGoogleAnalytics();
            }

            if (hasUserGivenPermissionFor('facebook-pixel')) {
                $this->writeFbPixelCode();
            }

        } else if (SPDSGVOSettings::get('cn_tracker_init') === 'after_confirm'
            && ($this->cookies_accepted() || hasUserGivenPermissionFor('cookies'))) {

//                 error_log('after_confirm logic');
//                 error_log('google-analytics: '. hasUserGivenPermissionFor('google-analytics'));
//                 error_log('google-analytics permission: '. hasUserGivenPermissionFor('google-analytics') ? 'true': 'false');

                if (hasUserGivenPermissionFor('google-analytics')) {
                    //error_log('after_confirm: user has given go to analytis, write it');
                    $this->writeGoogleAnalyticsOptOut();
                    $this->writeGoogleAnalytics();
                }

                if (hasUserGivenPermissionFor('facebook-pixel')) {
                    $this->writeFbPixelCode();
                }
        }
    }

    public function writeGoogleAnalytics()
    {
        //error_log('writeGoogleAnalytics: '.SPDSGVOSettings::get('ga_enable_analytics'));
        if (SPDSGVOSettings::get('ga_enable_analytics') === '1') :
        /* i592995 */

            $ga_code = SPDSGVOSettings::get('ga_code', '');
            if($ga_code == '' || SPDSGVOSettings::get('own_code') !== '1') {
                $ga_code = googleAnalyticsScript(true);
            }
            echo $ga_code;

        /* i592995 */
		endif;

    }

    public function writeGoogleAnalyticsOptOut()
    {
        // google analytics
        //if (SPDSGVOSettings::get('ga_enable_analytics') === '1') :
        if ($this->cookies_accepted() || hasUserGivenPermissionFor('google-analytics')) :
                ?>

<script>
            	window['ga-disable-<?= SPDSGVOSettings::get('ga_tag_number') ?>'] = false;
            </script>

<?php
            else :
                ?>
<script>
            	window['ga-disable-<?= SPDSGVOSettings::get('ga_tag_number') ?>'] = true;
            </script>
<?php
            endif;
		//endif;

    }

    public function writeFbPixelCode()
    {
        if (SPDSGVOSettings::get('fb_enable_pixel') === '1') :
            /* i592995 */
            $code = SPDSGVOSettings::get('fb_pixel_code', '');
            if($code == '' || SPDSGVOSettings::get('own_code') !== '1') {
                $code = facebookPixelScript(true);
            }
            $code = str_replace('[pixel_number]', SPDSGVOSettings::get('fb_pixel_number'), $code);
            echo $code;
            /* i592995 */

        endif;

    }

    public function writeFooterScripts()
    {
        $this->cookieNotice();
        /* i592995 */
        $this->policyPopup();
        /* i592995 */
    }

    public function addCommentsCheckBoxForDSGVO()
    {
        if (SPDSGVOSettings::get('sp_dsgvo_comments_checkbox') === '0') {} else {

            $validLicence = isValidBlogEdition() || isValidPremiumEdition();
            $infoText = $validLicence ? SPDSGVOSettings::get('spdsgvo_comments_checkbox_info') : htmlentities(SPDSGVOSettings::getDefault('spdsgvo_comments_checkbox_info'), ENT_IGNORE, 'UTF-8');
            if(function_exists('icl_translate')) {
                $infoText = icl_translate('shapepress-dsgvo', 'spdsgvo_comments_checkbox_info', $infoText);
            }
            $checkboxText = $validLicence ? SPDSGVOSettings::get('spdsgvo_comments_checkbox_text') : htmlentities(SPDSGVOSettings::getDefault('spdsgvo_comments_checkbox_text'), ENT_IGNORE, 'UTF-8');
            if(function_exists('icl_translate')) {
                $checkboxText = icl_translate('shapepress-dsgvo', 'spdsgvo_comments_checkbox_text', $checkboxText);
            }
            $confirmText = $validLicence ? SPDSGVOSettings::get('spdsgvo_comments_checkbox_confirm') : htmlentities(SPDSGVOSettings::getDefault('spdsgvo_comments_checkbox_confirm'), ENT_IGNORE, 'UTF-8');
            if(function_exists('icl_translate')) {
                $confirmText = icl_translate('shapepress-dsgvo', 'spdsgvo_comments_checkbox_confirm', $confirmText);
            }

            if (spdsgvoUseWpml())
            {
                $infoText = __('The confirmation to GDPR is mandatory.','shapepress-dsgvo');
                $checkboxText = __('This form stores your name, email address and content so that we can evaluate the comments on our site. For more information, visit our Privacy Policy page.','shapepress-dsgvo');
                $confirmText = __('I confirm','shapepress-dsgvo');
            }

            $privacy_policy_string = '';

            $privacy_policy_string .= "<p class='gdpr-cb-info-text'><small>* ".convDeChars($infoText)."</small></p>";

            $privacy_policy_string .= '<div class="info-text"><label for="gdpr-cb">'.convDeChars($checkboxText).'</label></div>';

            $privacy_policy_string .= '<p class="comment-form-gdpr"><input required="required" id="gdpr-cb" name="gdpr-cb" type="checkbox"  />';
            $privacy_policy_string .= convDeChars($confirmText);
            $privacy_policy_string .= "</p>";

            echo $privacy_policy_string;

        }
    }

    public function wpcf7AddDsgvoTag()
    {
        error_log('wpcf7AddDsgvoTag');
        wpcf7_add_form_tag( array('dsgvo','dsgvo*'), 'dsgvoTextTagHandler', true );
    }

    public function dsgvoTextTagHandler( $tag ) {

        $dsgvoText = $validLicence ? htmlentities(SPDSGVOSettings::get('spdsgvo_comments_checkbox_text'), ENT_IGNORE, 'UTF-8') : htmlentities(SPDSGVOSettings::getDefault('spdsgvo_comments_checkbox_text'), ENT_IGNORE, 'UTF-8');
        if(function_exists('icl_translate')) {
            $dsgvoText = icl_translate('shapepress-dsgvo', 'spdsgvo_comments_checkbox_text', $dsgvoText);
        }
        return $dsgvoText;
    }

    public function newUserRegistered($userID)
    {
        update_user_meta($userID, 'SPDSGVO_settings', json_encode('{}'));
    }

    public function allowJSON($mime_types)
    {
        $mime_types['json'] = 'application/json';
        return $mime_types;
    }

    public function publicInit()
    {
        load_plugin_textdomain( 'shapepress-dsgvo', false, basename(dirname(__FILE__)) . '/languages/' );

        if (SPDSGVOSettings::get('auto_delete_erasure_requests') === '1') {
            if (SPDSGVOSettings::get('last_auto_delete_cron') !== date('z')) {
                foreach (SPDSGVOUnsubscriber::all() as $unsubscriber) {
                    if ($unsubscriber->delete_on < time()) {
                        $unsubscriber->unsubscribe();
                    }
                }
                SPDSGVOSettings::set('last_auto_delete_cron', date('z'));
            }
        }
    }

    public function adminInit()
    {
        load_plugin_textdomain( 'shapepress-dsgvo', false, basename(dirname(__FILE__)) . '/languages/' );
    }

    public function wooAddCustomFields( $checkout)
    {
        if (SPDSGVOSettings::get('woo_show_privacy_checkbox') === '1') {
            echo '<div id="cb-spdsgvo-privacy-policy"><h3>'.__('Privacy Policy: ','shapepress-dsgvo').'</h3>';


            $privacyPolicyPage = SPDSGVOSettings::get('privacy_policy_page');
            /* i592995 */
            /*
            $cbLabel = __('I have read and accepted the PrivacyPolicyPlaceholder.','shapepress-dsgvo');
            if ($privacyPolicyPage > 0)
            {
                $ppUrl = get_post_permalink($privacyPolicyPage);


                $cbLabel = str_replace('PrivacyPolicyPlaceholder', '<a href="'.$ppUrl.'">'.__('Privacy policy','shapepress-dsgvo').'</a>', $cbLabel);
            }   else
            {
                $cbLabel = str_replace('PrivacyPolicyPlaceholder',  __('Privacy policy','shapepress-dsgvo'), $cbLabel);
            }
			*/
			
			 $cbLabel = SPDSGVOSettings::get('woo_privacy_text', '');
            if (spdsgvoUseWpml())
            {
                $cbLabel =  __('I have read and accepted the Privacy Policy.','shapepress-dsgvo');
            }

            /* i592995 */

            woocommerce_form_field( 'cb-spdsgvo-privacy-policy', array(
                'type'          => 'checkbox',
                'class'         => array('input-checkbox'),
                'label'         => $cbLabel,
                'required'  => true,
            ), $checkout->get_value( 'cb-spdsgvo-privacy-policy' ));

            echo '</div>';
        }
    }

    function wooAddCustomCheckout() {


        // Check if set, if its not set add an error.
        if (SPDSGVOSettings::get('woo_show_privacy_checkbox') === '1' && !$_POST['cb-spdsgvo-privacy-policy'])
            wc_add_notice( __('Consent to the privacy policy is mandatory.','shapepress-dsgvo'),'error' );
    }

    function wooUpdateOrderMeta($order_id)
    {
        if (SPDSGVOSettings::get('woo_show_privacy_checkbox') === '1') {
            if ($_POST['cb-spdsgvo-privacy-policy']) update_post_meta( $order_id, __('Privacy Policy accepted','shapepress-dsgvo'), esc_attr($_POST['cb-spdsgvo-privacy-policy']));
        }
    }


    public function forcePermisson()
    {
        $page = SPDSGVOSettings::get('explicit_permission_page');

        if (hasUserDeclinedTerms()) {
            return;
        }

        if ($page == '0') {
            return;
        }

        if (get_post($page) instanceof WP_Post) {
            return;
        }

        if (strpos(get_post($page)->post_content, 'explicit_permission_form') === FALSE) {
            return;
        }

        if (SPDSGVOSettings::get('force_explicit_permission_authenticated') == '1' && is_user_logged_in()) {

            if (! SPDSGVO::isAjax() && ! hasUserAgreedToTerms()) {
                if (get_the_ID() != $page) {
                    $url = get_permalink($page);
                    if (! is_admin()) {
                        wp_redirect($url);
                        exit();
                    }
                }
            }
        } elseif (SPDSGVOSettings::get('force_explicit_permission_public') == '1' && ! is_user_logged_in()) {

            if (! SPDSGVO::isAjax() && ! hasUserAgreedToTerms()) {
                if (get_the_ID() != $page) {
                    $url = get_permalink($page);
                    if (! is_admin()) {
                        wp_redirect($url);
                        exit();
                    }
                }
            }
        }
    }

}

/**
 * Get the cookie notice status
 *
 * @return boolean
 */
function sp_dsgvo_cn_cookies_accepted()
{
    return (bool) SPDSGVOPublic::cookies_accepted();
}
