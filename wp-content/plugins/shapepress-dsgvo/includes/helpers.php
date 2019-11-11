<?php
if (! function_exists('hasUserAgreedToTerms')) {

    function hasUserAgreedToTerms($user = NULL)
    {
        if (is_null($user)) {
            $user = wp_get_current_user();
        } elseif (! $user instanceof WP_User) {
            $user = get_user_by('ID', $user);
        }

        if (! $user instanceof WP_User) {
            if (! isset($_COOKIE['sp_dsgvo_explicit_permission_given'])) {
                return FALSE;
            }

            return wp_hash(SPDSGVOSettings::get('terms_conditions')) === @$_COOKIE['sp_dsgvo_explicit_permission_given'];
        }

        return get_user_meta($user->ID, 'sp_dsgvo_explicit_permission_granted', TRUE) === '1';
    }
}

if (! function_exists('hasUserDeclinedTerms')) {

    function hasUserDeclinedTerms()
    {
        $user = wp_get_current_user();
        if ($user instanceof WP_User && $user->ID) {
            return (get_user_meta($user->ID, 'sp_dsgvo_explicit_permission_declined', TRUE) === '1');
        } else {
            return (@$_COOKIE['sp_dsgvo_explicit_permission_declined'] === '1');
        }
    }
}

if (! function_exists('sp_dsgvo_CSRF_TOKEN')) {

    function sp_dsgvo_CSRF_TOKEN()
    {
        $user = wp_get_current_user();

        if ($user instanceof WP_User && $user->ID) {
            return get_user_meta($user->ID, 'sp_dsgvo_CSRF_token', TRUE);
        }
    }
}

if (! function_exists('pageContainsString')) {

    function pageContainsString($pageID, $string)
    {
        if (get_post_status($pageID) === FALSE) {
            return FALSE;
        }

        return (strpos(get_post($pageID)->post_content, $string) !== FALSE);
    }
}

/* i592995 */
if(!function_exists('hasUserAcceptedPopup')) :
    function hasUserAcceptedPopup()
    {
        $user = wp_get_current_user();
        $accept = false;
        if($user->ID != 0) {
            $meta = get_user_meta($user->ID, 'sp_dsgvo_popup', TRUE);
            if($meta != '') {
                $accept = true;
            }
        } else 
        {
            $accept = hasUserGivenPermissionFor('cookies') !== FALSE;
        }

        return $accept;
    }
endif;
/* i592995 */

function setPermissionsDefaults($perm) {
    $perm = array(
        'cookies' => '0',
        'google-analytics' => '0',
        'facebook-pixel' => '0'
    );
}

function checkCookies($perm) {
    if(!is_array($perm)) {
        setPermissionsDefaults($perm);
    }

    if(!isset($perm['cookies']) || !isset($perm['google-analytics']) || !isset($perm['facebook-pixel'])) {
        setPermissionsDefaults($perm);
    }

    if($perm['cookies'] != '0' && $perm['cookies'] != '1') {
        setPermissionsDefaults($perm);
    }

    if(!isset($perm['google-analytics']) || ($perm['google-analytics'] != '0' && $perm['google-analytics'] != '1')) {
        setPermissionsDefaults($perm);
    }

    if(!isset($perm['facebook-pixel']) || ($perm['facebook-pixel'] != '0' && $perm['facebook-pixel'] != '1')) {
        setPermissionsDefaults($perm);
    }
}

if (! function_exists('hasUserGivenPermissionFor')) {

    function hasUserGivenPermissionFor($slug)
    {
        //error_log('hasUserGivenPermissionFor: '.$slug);
        $user = wp_get_current_user();

        if ($slug === 'cookies') {
            $cnAccepted = sp_dsgvo_cn_cookies_accepted();

            if ($user instanceof WP_User && $user->ID) {
                $userPermissions = get_user_meta($user->ID, 'sp_dsgvo_user_permissions', TRUE);
            } else {
                $userPermissions = @$_COOKIE['sp_dsgvo_user_permissions'];
                $userPermissions = unserialize(stripslashes($userPermissions));
                checkCookies($userPermissions);
            }

            if (isset($userPermissions['cookies'])) {
                return $userPermissions['cookies'] == '1' || $cnAccepted;
            }

            // error_log('hasUserGivenPermissionFor: '.$slug .': '. 'NULL');
            return $cnAccepted; // at last its false -> opt-in
        }

        if ($user instanceof WP_User && $user->ID) {

            $userPermissions = get_user_meta($user->ID, 'sp_dsgvo_user_permissions', TRUE);
        } else {

            $userPermissions = @$_COOKIE['sp_dsgvo_user_permissions'];
            $userPermissions = unserialize(stripslashes($userPermissions));
            checkCookies($userPermissions);
        }

       // error_log('$userPermissions');
       // error_log(implode(',',$userPermissions));

        if (isset($userPermissions[$slug])) {
//             error_log('hasUserGivenPermissionFor: ' . $slug);
//             error_log($userPermissions[$slug]);
//             error_log($userPermissions[$slug] == '1');
            return $userPermissions[$slug] == '1';
        } else {
            $defaults = SPDSGVOSettings::get('services');

            if (isset($defaults[$slug])) {
                error_log('hasUserGivenPermissionFor: ' . $slug . ': ' . @$defaults[$slug]['default'] === '1');
                return @$defaults[$slug]['default'] === '1';
            }

            error_log('hasUserGivenPermissionFor: ' . $slug . ': ' . 'FALSE');
            return FALSE;
        }
    }
}

if (! function_exists('isBlogEdition')) {

    function isBlogEdition()
    {
        $license = SPDSGVOSettings::get('dsgvo_licence');
        if ($license === '' || strlen($license) < 2) return false;
        
        return substr( $license, 0, 2 ) === "PB";
    }
}

if (! function_exists('isPremiumEdition')) {
    
    function isPremiumEdition()
    {
        $license = SPDSGVOSettings::get('dsgvo_licence');
        if ($license === '' || strlen($license) < 2) return false;
        
        return substr( $license, 0, 2 ) === "PR" // 
                || substr( $license, 0, 2 ) === "PP" //  plus
                || substr( $license, 0, 2 ) === "PD" // dev
                || substr( $license, 0, 4 ) === "DEMO";
    }
}

if (! function_exists('isLicenceValid')) {

    function isLicenceValid()
    {
        if (isBlogEdition())
        {
            return SPDSGVOSettings::get('dsgvo_licence') !== '' &&
            // && SPDSGVOSettings::get('license_key_error') === '0'
            SPDSGVOSettings::get('license_activated') === '1';
        } else
        {
            return SPDSGVOSettings::get('dsgvo_licence') !== '' &&
            // && SPDSGVOSettings::get('license_key_error') === '0'
            SPDSGVOSettings::get('license_activated') === '1'
                && (strtotime('today') <= strtotime(SPDSGVOSettings::get('licence_valid_to')));
        }
       
    }
}

if (! function_exists('isValidBlogEdition')) {
    
    function isValidBlogEdition()
    {
        return isLicenceValid() && isBlogEdition();
    }
}

if (! function_exists('isValidPremiumEdition')) {
    
    function isValidPremiumEdition()
    {
        return isLicenceValid() && isPremiumEdition();
    }
}

if (! function_exists('createLog')) {

    function createLog($content)
    {
        return SPDSGVOLog::insert($content);
    }
}

if (! function_exists('spdsgvoUseWpml')) {

    function spdsgvoUseWpml()
    {
        return SPDSGVOSettings::get('use_wpml_strings') === '1';
    }
}

if (! function_exists('convDeChars')) {

    function convDeChars($content)
    {
        $content = str_replace('Ã¤', 'ä', $content);
        $content = str_replace('Ã„', 'Ä', $content);
        $content = str_replace('Ã¼', 'ü', $content);
        $content = str_replace('Ãœ', 'Ü', $content);
        $content = str_replace('Ã¶', 'ö', $content);
        $content = str_replace('Ã–', 'Ö', $content);
        $content = str_replace('ÃŸ', 'ß', $content);
        $content = str_replace('ÃŸ', 'ß', $content);
        
        $content = str_replace('ä', '&auml;', $content);
        $content = str_replace('Ä', '&Auml;', $content);
        $content = str_replace('ü', '&uuml;', $content);
        $content = str_replace('Ü', '&Uuml;', $content);
        $content = str_replace('ö', '&ouml;', $content);
        $content = str_replace('Ö', '&Ouml;', $content);
        $content = str_replace('ß', '&szlig;', $content);
        $content = str_replace('ß', '$szlig;', $content);

        return $content;
    }
}

/* i592995 */
if(!function_exists('popup_styling')) :
    function popup_styling() {
        $background = SPDSGVOSettings::get('popup_background');
        if($background == '') {
            $background = '#ffffff';
        }
        $separators = SPDSGVOSettings::get('separators_color');
        if($separators == '') {
            $separators = '#f1f1f1';
        }
        $text_color = SPDSGVOSettings::get('text_color');
        if($text_color == '') {
            $text_color = '#f1f1f1';
        }
        $links_color = SPDSGVOSettings::get('links_color');
        if($links_color == '') {
            $links_color = '#4285f4';
        }
        $links_color_hover = SPDSGVOSettings::get('links_color_hover');
        if($links_color_hover == '') {
            $links_color_hover = '#4285f4';
        }
        $accept_button_text_color = SPDSGVOSettings::get('accept_button_text_color');
        if($accept_button_text_color == '') {
            $accept_button_text_color = '#ffffff';
        }
        $accept_button_bg_color = SPDSGVOSettings::get('accept_button_bg_color');
        if($accept_button_bg_color == '') {
            $accept_button_bg_color = '#4285f4';
        }
        ?>
        <style>
            .dsgvo-privacy-popup {
                background-color: <?php echo $background; ?>;
            }
            .dsgvo-privacy-popup .dsgvo-popup-bottom {
                border-top: 1px solid <?php echo $separators; ?>;
                background-color: <?php echo $background; ?>;
            }
            .dsgvo-privacy-popup .dsgvo-popup-top {
                border-bottom: 1px solid <?php echo $separators; ?>;
            }
            .dsgvo-lang-active svg line,
            .dsgvo-popup-close svg line {
                stroke: <?php echo $text_color; ?>;
            }
            .dsgvo-privacy-popup span,
            .dsgvo-accordion-top span,
            .dsgvo-privacy-popup p,
            .dsgvo-privacy-popup div,
            .dsgvo-privacy-popup strong,
            .dsgvo-privacy-popup h1,
            .dsgvo-privacy-popup h2,
            .dsgvo-privacy-popup h3,
            .dsgvo-privacy-popup h4,
            .dsgvo-privacy-popup h5,
            .dsgvo-privacy-popup h6 {
                color: <?php echo $text_color; ?>;
            }
            .dsgvo-privacy-popup a,
            .dsgvo-privacy-popup a span {
                color: <?php echo $links_color; ?>;
            }
            .dsgvo-privacy-popup a:hover,
            .dsgvo-privacy-popup a:hover span {
                color: <?php echo $links_color_hover; ?>;
            }
            .dsgvo-accept-button {
                color: <?php echo $accept_button_text_color; ?> !important;
                background-color: <?php echo $accept_button_bg_color; ?>;
            }
            .dsgvo-accept-button:hover {
                color: <?php echo $accept_button_text_color; ?> !important;
            }
            .dsgvo-accept-button .dsgvo-accept-loader circle {
                stroke: <?php echo $accept_button_text_color; ?>;
            }
        </style>
        <?php
    }
endif;
add_action('wp_head', 'popup_styling');
/* i592995 */

/* i592995 */
if(!function_exists('googleAnalyticsScript')) :
    function googleAnalyticsScript($return = false) {
        ob_start();
        ?>

        <!-- Google Analytics -->
        <script>
                    window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
                    ga('create', '<?= SPDSGVOSettings::get('ga_tag_number') ?>', 'auto');
                    ga('set', 'anonymizeIp', true);
                    ga('send', 'pageview');
                    </script>
        <script async src='https://www.google-analytics.com/analytics.js'></script>
        <!-- End Google Analytics -->

        <?php
        $code = ob_get_clean();
        if($return) {
            return $code;
        } else {
            echo $code;
        }
    }
endif;

if(!function_exists('facebookPixelScript')) :
    function facebookPixelScript($return = false) {
        ob_start();
        ?>

        <!-- Facebook Pixel Code -->
        <script>
                  !function(f,b,e,v,n,t,s)
                  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                  n.queue=[];t=b.createElement(e);t.async=!0;
                  t.src=v;s=b.getElementsByTagName(e)[0];
                  s.parentNode.insertBefore(t,s)}(window, document,'script',
                  'https://connect.facebook.net/en_US/fbevents.js');
                  fbq('init', '<?= SPDSGVOSettings::get('fb_pixel_number') ?>');
                  fbq('track', 'PageView');
                </script>
        <noscript>
        	<img height="1" width="1" style="display: none"
        		src="https://www.facebook.com/tr?id=[pixel_number]&ev=PageView&noscript=1" />
        </noscript>
        <!-- End Facebook Pixel Code -->

        <?php
        $code = ob_get_clean();
        if($return) {
            return $code;
        } else {
            echo $code;
        }
    }
endif;

/* i592995 */
