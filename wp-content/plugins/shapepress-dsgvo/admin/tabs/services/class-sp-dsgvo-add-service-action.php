<?php

Class SPDSGVOAddServiceAction extends SPDSGVOAjaxAction{

    protected $action = 'admin-add-service';

    protected function run(){
        $this->requireAdmin();

        if(!empty($this->get('new_name')) && !empty($this->get('new_reason'))){

            // Make Slug
            $slug = $slug_ = SPDSGVO::slugify($this->get('new_name'));
            $tries = 0;
            while(in_array($slug, array_keys($meta))){
                $tries++;
                $slug = ($slug_ .'-'. $tries);
            }

            /* i592995 */
            // Append new service to services
            $meta = SPDSGVOSettings::get('services');
            if(!is_array($meta)){ $meta = array(); }
            $meta[$slug] = array(
                'slug'      => $slug,
                'name'      => $this->get('new_name'),
                'reason'    => $this->get('new_reason'),
                'link'      => $this->get('new_link'),
                'default'   => $this->get('new_default'),
                'image'     => $this->get('new_image')
            );
            /* i592995 */
            SPDSGVOSettings::set('services', $meta);
        }

        $this->returnBack();
    }
}

SPDSGVOAddServiceAction::listen();
