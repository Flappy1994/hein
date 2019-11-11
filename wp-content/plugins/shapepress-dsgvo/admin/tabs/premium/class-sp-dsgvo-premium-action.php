<?php

Class SPDSGVOPremiumAction extends SPDSGVOAjaxAction{

    protected $action = 'premium';

    protected function run(){
        $this->requireAdmin();
        

        $this->returnBack();
    }
}

SPDSGVOPremiumAction::listen();
