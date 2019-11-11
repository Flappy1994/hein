<?php

class SPDSGVOImprintTab extends SPDSGVOAdminTab{

	public $title = 'Impressum';
	public $slug  = 'imprint';
    public $isHidden = TRUE;

	public function __construct(){

	    $this->title = __('Imprint','shapepress-dsgvo');
	}

    public function page(){
        include plugin_dir_path(__FILE__) .'page.php';
    }
}
