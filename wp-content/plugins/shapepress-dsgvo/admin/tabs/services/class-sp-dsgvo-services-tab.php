<?php

class SPDSGVOServicesTab extends SPDSGVOAdminTab{

    public $title = 'Privacy policy & Plugins';
    public $slug = 'services';

    public function __construct(){

        $this->title = __('Privacy policy & Plugins','shapepress-dsgvo');
    }

    public function page(){
        include plugin_dir_path(__FILE__) .'page.php';
    }
}
