<?php

Class SPDSGVODeleteServiceAction extends SPDSGVOAjaxAction{

    protected $action = 'delete-service';

    protected function run(){
        $this->requireAdmin();


		$services = SPDSGVOSettings::get('services');

        if(is_array($services)){
            $meta = array();
            foreach($services as $slug => $service){
                if($slug !== $this->get('slug')){
                    $meta[$slug] = $service;
                }
            }

            SPDSGVOSettings::set('services', $meta);
            SPDSGVOLog::insert(__('Third-party service deleted by', 'shapepress-dsgvo') . " {$this->user->user_email}");
        }

        $this->returnBack();
    }
}

SPDSGVODeleteServiceAction::listen();
