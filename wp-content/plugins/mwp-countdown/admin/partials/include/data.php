<?php if ( ! defined( 'ABSPATH' ) ) exit; 
$act = (isset($_REQUEST["act"])) ? sanitize_text_field($_REQUEST["act"]) : '';
if ($act == "update") {	
	$recid = sanitize_text_field($_REQUEST["id"]);
	$result = $wpdb->get_row("SELECT * FROM $data WHERE id=$recid");
    if ($result){
        $id = $result->id;
        $title = $result->title;
		$param = unserialize($result->param);
		$param['font_size'] = !empty($param['font_size']) ? $param['font_size'] : "16";
		$param['delimiter_size'] = !empty($param['delimiter_size']) ? $param['delimiter_size'] : "16";
		$param['title_font_size'] = !empty($param['title_font_size']) ? $param['title_font_size'] : "16";
		$btn = "Update";
        $hidval = 2;
    }
}
else if ($act == "duplicate") {
	$recid = sanitize_text_field($_REQUEST["id"]);
	$result = $wpdb->get_row("SELECT * FROM $data WHERE id=$recid");
   if ($result){   
        $id = "";
        $title = "";
		$param = unserialize($result->param);
		$param['font_size'] = !empty($param['font_size']) ? $param['font_size'] : "16";
		$param['delimiter_size'] = !empty($param['delimiter_size']) ? $param['delimiter_size'] : "16";
		$param['title_font_size'] = !empty($param['title_font_size']) ? $param['title_font_size'] : "16";
		$btn = "Save";
        $hidval = 1;
    }
}
 else {
        $btn = "Save";
        $id = "";
        $title = "";
		$param['type'] = "";
		$param['day'] = "1";
		$param['month'] = "11";
		$param['year'] = date ('Y');
		$param['hour'] = "1";
		$param['minut'] = "1";
		$param['nfirst'] = "399";
		$param['nsecond'] = "150";
		$param['direction'] = "";
		$param['cookie'] = "";
		$param['sec_step'] = "";
		$param['speed'] = "5";		
		$param['amount_step'] = "";
		$param['amount'] = "1";		
		$param['show_title_days'] = "";
		$param['show_title_hours'] = "";
		$param['show_title_minutes'] = "";
		$param['show_title_seconds'] = "";
		$param['title_days'] = "Days";
		$param['title_hours'] = "Hours";
		$param['title_minutes'] = "Minutes";
		$param['title_seconds'] = "Seconds";
		$param['hide_days'] = "";
		$param['hide_hours'] = "";
		$param['hide_minutes'] = "";
		$param['hide_seconds'] = "";
		$param['type_delimiter'] = "";
		$param['font_size'] = "16";
		$param['delimiter_size'] = "16";
		$param['title_font_size'] = "16";
        $hidval = 1;	
}
?>