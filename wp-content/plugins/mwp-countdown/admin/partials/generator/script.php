jQuery(document).ready(function($) {
	<?php if ($param['type'] == 1){;?>	
	utask<?php echo $val->id;?> = new Date(<?php echo $param['year'];?>, <?php echo $param['month'];?>, <?php echo $param['day'];?>);		
	<?php } if ($param['type'] == 2){;?>
	utask<?php echo $val->id;?> = (new Date()).getTime() + <?php echo $param['day'];?>*86400000+<?php echo $param['hour'];?>*3600000+<?php echo $param['minut'];?>*60000;	
<?php } if ($param['type'] == 3){;?>
	if(Cookies.get('wow-countdown-id-<?php echo $val->id; ?>')){
		utask<?php echo $val->id;?> = Cookies.get('wow-countdown-id-<?php echo $val->id; ?>');
	} 
	else {			
		utask<?php echo $val->id;?> = (new Date()).getTime() + <?php echo $param['day'];?>*86400000+<?php echo $param['hour'];?>*3600000+<?php echo $param['minut'];?>*60000;		
		Cookies.set('wow-countdown-id-<?php echo $val->id; ?>', utask<?php echo $val->id;?>, {expires: <?php if(empty($param['cookie'])){echo '1';}else{echo $param['cookie'];}?>});
	}
	<?php } if ($param['type'] == 4){;?>
	ucountleft<?php echo $val->id;?> = <?php echo $param['nfirst'];?>;
	<?php } if ($param['type'] == 5){;?>
	if(Cookies.get('wow-countdown-id-<?php echo $val->id; ?>')){
		ucountleft<?php echo $val->id;?> = Cookies.get('wow-countdown-id-<?php echo $val->id; ?>');
	} 
	else {			
		ucountleft<?php echo $val->id;?> = <?php echo $param['nfirst'];?>;		
	}
	<?php };?>
<?php if ($param['type'] == 1 || $param['type'] == 2 || $param['type'] == 3){;?>
	wowcountdown<?php echo $val->id;?>();
	function wowcountdown<?php echo $val->id;?>(){	
			ucountleft<?php echo $val->id;?> = Math.floor((utask<?php echo $val->id;?> - (new Date())) / 1000);			
			if(ucountleft<?php echo $val->id;?> < 0){
				ucountleft<?php echo $val->id;?> = 0;								
				return;
			}			
			var uday = Math.floor(ucountleft<?php echo $val->id;?> / 86400);			
			if (uday < 10){
				var rday = '0'+uday;
			}
			else {
				var rday = uday;
			}
			ucountleft<?php echo $val->id;?> -= uday*86400;
			var uhour = Math.floor(ucountleft<?php echo $val->id;?> / 3600);
			if (uhour < 10){
				var rhour = '0'+uhour;
			}
			else {
				var rhour = uhour;
				}
			ucountleft<?php echo $val->id;?> -= uhour*3600;
			var uminut = Math.floor(ucountleft<?php echo $val->id;?> / 60);
			if (uminut < 10){
				var rmin = '0'+uminut;
			}
			else {
				var rmin = uminut;
			}
			ucountleft<?php echo $val->id;?> -= uminut*60;
			var usecond = ucountleft<?php echo $val->id;?>;
			if (usecond < 10){
				var rsec = '0'+usecond;
			}
			else {
				var rsec = usecond;
			}
			var message<?php echo $val->id;?> = "<div class='wowcountdown-<?php echo $val->id;?>'>";
			<?php if ($param['hide_days'] == 'no'){;?>
			message<?php echo $val->id;?> += "<span class='wowcontnumber-<?php echo $val->id;?>'>"+rday +"</span> <?php if (!empty($param['show_title_days'])){ echo "<span class='wowc-title-".$val->id."'>".$param['title_days']."</span> ";} else {echo "<span class='wowc-delimiter-".$val->id."'>".$param['type_delimiter']."</span> ";};?>";
			<?php };?>
			<?php if ($param['hide_hours'] == 'no'){;?>
			message<?php echo $val->id;?> += "<span class='wowcontnumber-<?php echo $val->id;?>'>"+rhour + "</span> <?php if (!empty($param['show_title_hours'])){ echo "<span class='wowc-title-".$val->id."'>".$param['title_hours']."</span> ";} else {echo "<span class='wowc-delimiter-".$val->id."'>".$param['type_delimiter']."</span> ";};?>";
			<?php };?>
			<?php if ($param['hide_minutes'] == 'no'){;?>
			message<?php echo $val->id;?> += "<span class='wowcontnumber-<?php echo $val->id;?>'>"+rmin + "</span> <?php if (!empty($param['show_title_minutes'])){ echo "<span class='wowc-title-".$val->id."'>".$param['title_minutes']."</span> ";} else {echo "<span class='wowc-delimiter-".$val->id."'>".$param['type_delimiter']."</span> ";};?>";
			<?php };?>
			<?php if ($param['hide_seconds'] == 'no'){;?>
			message<?php echo $val->id;?> += "<span class='wowcontnumber-<?php echo $val->id;?>'>"+rsec+"</span> <?php if (!empty($param['show_title_seconds'])){ echo "<span class='wowc-title-".$val->id."'>".$param['title_seconds']."</span> ";} else {};?>";
			<?php };?>
			message<?php echo $val->id;?> += "</div>";			
			$('#wow-countdown-id-<?php echo $val->id;?>').html(message<?php echo $val->id;?>);
			setTimeout(wowcountdown<?php echo $val->id;?>, 1000);
		}	
<?php };?>
<?php if ($param['type'] == 4 || $param['type'] == 5){;?>
wowcountdown<?php echo $val->id;?>();
function wowcountdown<?php echo $val->id;?>(){
			<?php if ($param['sec_step'] == 'stable'){;?>
			var speed = <?php echo $param['speed'];?>;
			<?php } else {;?>
			var speed = Math.floor(Math.random() * (<?php echo $param['speed_max'];?> - <?php echo $param['speed_min'];?>)) + <?php echo $param['speed_min'];?>;
			<?php };?>
			<?php if ($param['amount_step'] == 'stable'){;?>
			var amount = <?php echo $param['amount'];?>;
			<?php } else {;?>
			var amount = Math.floor(Math.random() * (<?php echo $param['amount_max'];?> - <?php echo $param['amount_min'];?>)) + <?php echo $param['amount_min'];?>;
			<?php };?>
			<?php if ($param['direction'] == 1){;?>
			ucountleft<?php echo $val->id;?>= ucountleft<?php echo $val->id;?>-amount*1;
			if(ucountleft<?php echo $val->id;?> < <?php echo $param['nsecond'];?>){				
				var message<?php echo $val->id;?> = "<div class='wowcountdown-<?php echo $val->id;?> wowcontnumber-<?php echo $val->id;?>'><?php echo $param['nsecond'];?></div>";				
				$('#wow-countdown-id-<?php echo $val->id;?>').html(message<?php echo $val->id;?>);				
				return;
			}		
			<?php } else {;?>
			ucountleft<?php echo $val->id;?>= ucountleft<?php echo $val->id;?>*1+amount*1;
			if(ucountleft<?php echo $val->id;?> >= <?php echo $param['nsecond'];?>){
				var message<?php echo $val->id;?> = "<div class='wowcountdown-<?php echo $val->id;?> wowcontnumber-<?php echo $val->id;?>'><?php echo $param['nsecond'];?></div>";
				$('#wow-countdown-id-<?php echo $val->id;?>').html(message<?php echo $val->id;?>);							
				return;
			}		
			<?php };?>
			var message<?php echo $val->id;?> = "<div class='wowcountdown-<?php echo $val->id;?> wowcontnumber-<?php echo $val->id;?>'>"+ucountleft<?php echo $val->id;?>+"</div>";		
			$('#wow-countdown-id-<?php echo $val->id;?>').html(message<?php echo $val->id;?>);
			setTimeout(wowcountdown<?php echo $val->id;?>, speed*1000);
			<?php if ($param['type'] == 5){;?>
			Cookies.set('wow-countdown-id-<?php echo $val->id; ?>', ucountleft<?php echo $val->id;?>, {expires: <?php if(empty($param['cookie'])){echo '1';}else{echo $param['cookie'];}?>});
			<?php };?>
		}	
<?php };?>
}); 