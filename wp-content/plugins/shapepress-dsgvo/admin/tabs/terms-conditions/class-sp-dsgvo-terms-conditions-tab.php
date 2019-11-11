<?php

class SPDSGVOTermsConditionsTab extends SPDSGVOAdminTab{
	
	public $title = 'Terms Conditions';
	public $slug  = 'terms-conditions';
    public $isHidden = TRUE;

	public function __construct(){}
	
    public function page(){
        include plugin_dir_path(__FILE__) .'page.php';
    }
}	