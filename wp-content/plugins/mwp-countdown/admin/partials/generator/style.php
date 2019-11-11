.wowcountdown-<?php echo $val->id;?> {
	display: inline-block;	
	background: none; 	
	padding:10px;
	border: none; 	
	text-align: center;
	width: auto;
	height: auto;	
}
.wowcontnumber-<?php echo $val->id;?> {
	font-size:<?php if(empty($param['font_size'])){echo "14";}else{echo $param['font_size'];}?>px;		
}
.wowc-delimiter-<?php echo $val->id;?> {
	font-size:<?php if(empty($param['delimiter_size'])){echo "5";}else{echo $param['delimiter_size'];}?>px;		
}
.wowc-title-<?php echo $val->id;?> {
	font-size:<?php if(empty($param['title_font_size'])){echo "10";}else{echo $param['title_font_size'];}?>px;	
}