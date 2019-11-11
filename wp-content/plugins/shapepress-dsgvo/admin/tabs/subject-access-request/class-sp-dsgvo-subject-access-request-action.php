<?php

Class SPDSGVOAdminSubjectAccessRequestAction extends SPDSGVOAjaxAction{

    protected $action = 'admin-subject-access-request';

    protected function run(){
        $this->requireAdmin();

        SPDSGVOSettings::set('sar_cron', $this->get('sar_cron', '0'));
        if (isValidPremiumEdition())
        {
            SPDSGVOSettings::set('sar_email_notification', $this->get('sar_email_notification', '0'));
        }
        
        SPDSGVOSettings::set('sar_dsgvo_accepted_text', $this->get('sar_dsgvo_accepted_text', ''));

        if($this->has('sar_page')){
            SPDSGVOSettings::set('sar_page', $this->get('sar_page'));
        }

        if($this->has('process')){
            $ID = $this->get('process');
            SPDSGVOSubjectAccessRequest::doByID($ID);
        }

        if($this->get('all') == '1'){
            foreach(SPDSGVOSubjectAccessRequest::finder('pending') as $sar){
                $sar->doSubjectAccessRequest();
            }
        }


    	$this->returnBack();
    }
}

SPDSGVOAdminSubjectAccessRequestAction::listen();
