<?php

Class SPDSGVOImprintAction extends SPDSGVOAjaxAction{

    protected $action = 'imprint';

    protected function run(){
        $this->requireAdmin();

        if($this->has('imprint_page')){
            SPDSGVOSettings::set('imprint_page', $this->get('imprint_page', '0'));
        }
        
        // Update privacy policy
        if($this->has('imprint')){
            SPDSGVOSettings::set('imprint_hash', wp_hash($this->get('imprint')));
            SPDSGVOSettings::set('imprint', $this->get('imprint'));
            SPDSGVOLog::insert("Imprint updated by {$this->user->user_email}");
        }
        

        $this->returnBack();
    }
}

SPDSGVOImprintAction::listen();
