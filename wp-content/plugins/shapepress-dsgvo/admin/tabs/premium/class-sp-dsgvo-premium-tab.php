<?php

class SPDSGVOPremiumTab extends SPDSGVOAdminTab{
    
    public $title = 'Premium';
    public $slug  = 'premium';
    public $isHidden = FALSE;
    public $isHighlighted = TRUE;
    
    public function __construct(){}
    
    public function page(){
        include plugin_dir_path(__FILE__) .'page.php';
    }
}	