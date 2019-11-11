<?php if ( ! defined( 'ABSPATH' ) ) exit;	
	if (get_option( 'wow_countdowns_data') === false){		
		global $wpdb;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');	
		$table = $wpdb->prefix . 'wow_'.self::PREF;	
		$sql = "CREATE TABLE " . $table." (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		title VARCHAR(200) NOT NULL,  
		param TEXT,
		UNIQUE KEY id (id)
		) DEFAULT CHARSET=utf8;";
		dbDelta($sql);	
		$old_data = $wpdb->prefix . 'mwp_countdown_free';
		$arrresult = $wpdb->get_results("select * from ".$old_data);
		$columns = count($arrresult);
		for ($i = 0; $i < $columns; $i++) {
			$arr = array();
			foreach ($arrresult[$i] as $key => $val) {
				if ($key == 'title'){
					$title = $val;
				}
				else if ($key == 'id'){
					$id = $val;
				}
				else {
					$arr[$key] = $val;
				}
			}
			$param = serialize($arr);
			$data = array (
			'id' => $id,
			'title' => $title,			
			'param' => $param,
			);
			$wpdb->insert(	$table,$data);
		}		
		update_option( 'wow_countdowns_data', '3.0' );				
	}
	
