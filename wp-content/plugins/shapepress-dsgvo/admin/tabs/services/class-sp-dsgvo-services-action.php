<?php

Class SPDSGVOServicesAction extends SPDSGVOAjaxAction{

    protected $action = 'admin-services';

    protected function run(){
        $this->requireAdmin();


        // User permissons page
        if($this->has('user_permissions_page')){
            SPDSGVOSettings::set('user_permissions_page', $this->get('user_permissions_page'));
        }

        // Update Services
        if($this->has('services')){
	        $services = $this->get('services', NULL, FALSE);
	    	$meta = array();
	    	if(is_array($services)){
                /* i592995 */
	    		foreach($services as $key => $service){
	    			$meta[$service['slug']] = array(
	                    'slug'      => stripslashes($service['slug']),
	                    'name'      => stripslashes($service['name']),
	                    'reason'    => stripslashes($service['reason']),
	                    'link'      => stripslashes($service['link']),
                        'image'     => stripslashes($service['image']),
	    				'default'   => stripslashes($service['default']),
	    			);
	    		}
                /* i592995 */
	   		}

	        SPDSGVOSettings::set('services', $meta);
	    }


	    $this->returnBack();
    }
}

SPDSGVOServicesAction::listen();
