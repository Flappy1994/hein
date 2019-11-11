<?php

class SPDSGVOCommonSettingsActivateAction extends SPDSGVOAjaxAction
{

    protected $action = 'admin-common-settings-activate';

    protected function run()
    {
        $this->requireAdmin();

        $oldLicenceKey = SPDSGVOSettings::get('dsgvo_licence');
        $licenceKey = $this->get('dsgvo_licence', '');

        if (SPDSGVOSettings::get('license_activated') === '0')
        {
            //error_log('activating licence '.$licenceKey);
            SPDSGVOSettings::set('license_activated', '0');
            SPDSGVOSettings::set('license_key_error', '1');

            $url = 'https://wp-dsgvo.eu/spdsgvo-bin/activate.php';
            $url .= '?license_key=' .$licenceKey;

            $request = wp_remote_get($url);

            if( is_wp_error( $request ) ) {

                error_log(__('error during license activation: ', 'shapepress-dsgvo') . $request); // Bail early
            } else {
                $result = wp_remote_retrieve_body( $request );
                if (strpos($result, 'OK') !== false) {
                    SPDSGVOSettings::set('license_key_error', '0');
                    SPDSGVOSettings::set('license_activated', '1');
                } else
                {
                    SPDSGVOSettings::set('license_activation_error', $result);
                    SPDSGVOSettings::set('license_key_error', '1');
                }

            }
        } elseif(SPDSGVOSettings::get('license_activated') === '1')
        {
            $url = 'https://wp-dsgvo.eu/spdsgvo-bin/deactivate.php';
            $url .= '?license_key=' .$licenceKey;

            $request = wp_remote_get($url);

            if( is_wp_error( $request ) ) {

                error_log(__('error during license activation: ', 'shapepress-dsgvo').$request); // Bail early
            } else {
                $result = wp_remote_retrieve_body( $request );
                if (strpos($result, 'OK') !== false) {
                    SPDSGVOSettings::set('license_key_error', '1');
                    SPDSGVOSettings::set('license_activated', '0');
                    SPDSGVOSettings::set('licence_valid_to', '');
                    SPDSGVOSettings::set('licence_activated_on', '');
                } else
                {

                }
            }
        }


        if ($licenceKey !== '' && SPDSGVOSettings::get('license_activated') === '1') {

            //error_log('validating licence '.$licenceKey);

            $url = 'https://wp-dsgvo.eu/spdsgvo-bin/licensedetails.php';
            $url .= '?license_key=' .$licenceKey;

            $request = wp_remote_get($url);

            if( is_wp_error( $request ) ) {

                error_log(__('error during license details: ', 'shapepress-dsgvo').$request); // Bail early
            } else {

                $body = wp_remote_retrieve_body( $request );

                if ($body !== false)
                {
                    $data = json_decode( $body );
                    SPDSGVOSettings::set('licence_activated_on', $data->activation_date);
                    SPDSGVOSettings::set('licence_valid_to', $data->expiration_date);

                    SPDSGVOSettings::set('licence_details_fetched', '1');
                }
            }
        }

        SPDSGVOSettings::set('dsgvo_licence', $licenceKey);

        $this->returnBack();
    }
}

SPDSGVOCommonSettingsActivateAction::listen();
