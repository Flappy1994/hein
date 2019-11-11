<?php

Class SPDSGVOTermsConditionsAction extends SPDSGVOAjaxAction{

    protected $action = 'terms-conditions';

    protected function run(){
        $this->requireAdmin();


        // Set T&C's Page
        if($this->has('terms_conditions_page')){
            SPDSGVOSettings::set('terms_conditions_page', $this->get('terms_conditions_page'));
        }

        // Set force explicit permission for authenticated users
        if($this->has('force_explicit_permission_authenticated')){
            SPDSGVOSettings::set('force_explicit_permission_authenticated', $this->get('force_explicit_permission_authenticated', '0'));
        }

        // Set force explicit permission for non-authenticated users
        if($this->has('force_explicit_permission_public')){
            SPDSGVOSettings::set('force_explicit_permission_public', $this->get('force_explicit_permission_public', '0'));
        }

        // Set explicit permission_page
        if($this->has('explicit_permission_page')){
            SPDSGVOSettings::set('explicit_permission_page', $this->get('explicit_permission_page'));
        }

        // Set opt out page
        if($this->has('opt_out_page')){
            SPDSGVOSettings::set('opt_out_page', $this->get('opt_out_page'));
        }

        // Update Terms & Conditions
    	if($this->has('terms_conditions')){
    		$version = SPDSGVOSettings::get('terms_conditions_version');
    		$version = intval($version);
    		$version++;
    		$version = SPDSGVOSettings::set('terms_conditions_version', $version);
    		SPDSGVOSettings::set('terms_conditions_hash', wp_hash($this->get('terms_conditions')));

    		SPDSGVOSettings::set('terms_conditions', $this->get('terms_conditions'));
            SPDSGVOLog::insert("Terms and Conditions updated by {$this->user->user_email}");
    	}


        $this->returnBack();
    }
}

SPDSGVOTermsConditionsAction::listen();
