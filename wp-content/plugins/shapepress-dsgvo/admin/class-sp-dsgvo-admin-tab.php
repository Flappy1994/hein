<?php

/**
 * Abstract class that provides boilerplate methods for an extension.
 *
 * @link       https://wp-dsgvo.eu
 * @since      1.0.0
 *
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/includes
 */

/**
 * Abstract class that provides boilerplate methods for an extension.
 *
 *
 * @since      1.0.0
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/includes
 * @author     Shapepress eU
 */
abstract class SPDSGVOAdminTab{

	public $isHidden = false;
	public $isHighlighted = false;

	public function uri(){
        return sprintf('%sadmin.php?page=sp-dsgvo&tab=%s', get_admin_url(), $this->slug); 
    }

    public function isHidden(){
    	if(!isset($this->isHidden)){
    		return false;
    	}
    	
    	return $this->isHidden;
    }
    
    public function isHighlighted(){
        if(!isset($this->isHighlighted)){
            return false;
        }
        
        return $this->isHighlighted;
    }
}