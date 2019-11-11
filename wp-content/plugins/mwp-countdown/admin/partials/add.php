<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php include ('include/data.php'); ?>
<form action="admin.php?page=<?php echo $pluginname;?>" method="post">
	<div class="wowcolom">
		<div id="wow-leftcol">
			<input placeholder="Name is used only for admin purposes" type='text' name='title' value="<?php echo $title; ?>" class="wow-title"/>
			<div class="tab-box">
				<ul class="tab-nav">					
					<li><a href="#t1"><i class="fa fa-cogs"></i> Settings</a></li>					
					<li><a href="#t2"><i class="fa fa-dot-circle-o"></i> Trigger</a></li>
					<li><a href="#t3"><i class="fa fa-css3"></i> Style</a></li>
				</ul>
				<div class="tab-panels">
					<div id="t1">
						<div class="itembox">
							<div class="item-title">
								<h3>Settings</h3>									
							</div>
							<div class="inside" style="display: block;">
								<div class="wow-admin-col">
									<div class="wow-admin-col-4">
										Countdown type:<br/>
										<select name='param[type]' onchange="changetype();" id="type">        
											<option value="1" <?php if($param['type']=='1') { echo 'selected="selected"'; } ?>>To date</option>
											<option value="2" <?php if($param['type']=='2') { echo 'selected="selected"'; } ?>>Time</option>
											<option value="3" <?php if($param['type']=='3') { echo 'selected="selected"'; } ?>>Time with cookies</option> 
											<option value="4" <?php if($param['type']=='4') { echo 'selected="selected"'; } ?>>Amount</option>
											<option value="5" <?php if($param['type']=='5') { echo 'selected="selected"'; } ?>>Amount with cookies</option>
										</select>
									</div>
									<div class="wow-admin-col-4"></div>
									<div class="wow-admin-col-4">
										<div id="cookie">											
											Reset in (days):<br/>
											<input  placeholder="1" type='text' name='param[cookie]' value="<?php if(!empty($param['cookie'])) echo $param['cookie']; ?>"/> 			
										</div>
									</div>	
								</div>
								<div class="wow-admin-col">
									<div class="wow-admin-col-4" id="day">
										<span id="days">Day</span>:<br/>
										<input  placeholder="1" type='text' name='param[day]' value="<?php echo $param['day'];?>"/>
									</div>
									<div class="wow-admin-col-4" id="month">
										Month:<br/>
										<select name="param[month]">
											<option value="0" <?php if($param['month']=='0') { echo 'selected="selected"'; } ?>>January</option>
											<option value="1" <?php if($param['month']=='1') { echo 'selected="selected"'; } ?>>February</option>
											<option value="2" <?php if($param['month']=='2') { echo 'selected="selected"'; } ?>>March</option>
											<option value="3" <?php if($param['month']=='3') { echo 'selected="selected"'; } ?>>April</option>
											<option value="4" <?php if($param['month']=='4') { echo 'selected="selected"'; } ?>>May</option>
											<option value="5" <?php if($param['month']=='5') { echo 'selected="selected"'; } ?>>June</option>
											<option value="6" <?php if($param['month']=='6') { echo 'selected="selected"'; } ?>>July</option>
											<option value="7" <?php if($param['month']=='7') { echo 'selected="selected"'; } ?>>August</option>
											<option value="8" <?php if($param['month']=='8') { echo 'selected="selected"'; } ?>>September</option>
											<option value="9" <?php if($param['month']=='9') { echo 'selected="selected"'; } ?>>October</option>
											<option value="10" <?php if($param['month']=='10') { echo 'selected="selected"'; } ?>>November</option>
											<option value="11" <?php if($param['month']=='11') { echo 'selected="selected"'; } ?>>December</option>
											
										</select>
									</div>
									<div class="wow-admin-col-4" id="year">
										Year<br/>
										<input type="text" name="param[year]" placeholder="<?php echo date("Y");?>" value="<?php if(!empty($param['year'])) echo $param['year']; ?>">
									</div>
									<div class="wow-admin-col-4" id="hour">
										Hours:<br/>
										<input  placeholder="1" type='text' name='param[hour]' value="<?php if(!empty($param['hour'])) echo $param['hour']; ?>"/>
									</div>
									<div class="wow-admin-col-4" id="minut">
										Minutes:<br/>
										<input  placeholder="1" type='text' name='param[minut]' value="<?php if(!empty($param['minut'])) echo $param['minut']; ?>"/>
									</div>
									
									<div class="wow-admin-col-4" id="nfirst">
										Starting number:<br/>
										<input  placeholder="399" type='text' name='param[nfirst]' value="<?php if(!empty($param['nfirst'])) echo $param['nfirst']; ?>"/>
									</div>
									<div class="wow-admin-col-4" id="nsecond">
										End number:<br/>
										<input  placeholder="155" type='text' name='param[nsecond]' value="<?php if(!empty($param['nsecond'])) echo $param['nsecond']; ?>"/>
									</div>
									<div class="wow-admin-col-4" id="direction">
										Direction:<br/>
										<select name='param[direction]'>        
											<option value="1" <?php if($param['direction']=='1') { echo 'selected="selected"'; } ?>>down</option>
											<option value="2" <?php if($param['direction']=='2') { echo 'selected="selected"'; } ?>>up</option>
										</select>
									</div>
								</div>
								
								<div id="speed">
									<div class="wow-admin-col">
										<div class="wow-admin-col-4">
											Time increment mode <a href='admin.php?page=<?php echo $pluginname;?>&tool=pro' title="Only Pro version"><span class="dashicons dashicons-lock" style="color:#37c781;"></span></a>:<br/>
											<select name='param[sec_step]' onchange="steps();">        
												<option value="stable" <?php if($param['sec_step']=='stable') { echo 'selected="selected"'; } ?>>stable</option>												
											</select>
										</div>
										<div class="wow-admin-col-4">
											Increment every (sec):<br/>
											<input type='text' name='param[speed]' value="<?php if(!empty($param['speed'])) echo $param['speed']; ?>"/>
										</div>										
									</div>								
									<div class="wow-admin-col">
										<div class="wow-admin-col-4">
											Amount increment mode <a href='admin.php?page=<?php echo $pluginname;?>&tool=pro' title="Only Pro version"><span class="dashicons dashicons-lock" style="color:#37c781;"></span></a>:<br/>
											<select name='param[amount_step]' onchange="amountstep();">        
												<option value="stable" <?php if($param['amount_step']=='stable') { echo 'selected="selected"'; } ?>><?php esc_attr_e("stable", "wow-marketings") ?></option>											
											</select>
										</div>
										<div class="wow-admin-col-4">
											Amount:<br/>
											<input type='text' name='param[amount]' value="<?php if(!empty($param['amount'])) echo $param['amount']; ?>"/>
										</div>									
									</div>
								</div>
								<div id="titles">
									<div class="wow-admin-col">
										<div class="wow-admin-col-4">
											<input type="checkbox" name="param[show_title_days]" value="1" <?php if(!empty($param['show_title_days'])) echo 'checked="checcked"'; ?>> Title for Days: <br/>
											<div id="title_days" style="display:none;">
												<input type='text' name='param[title_days]' value="<?php if(!empty($param['title_days'])) echo $param['title_days']; ?>"/>
											</div>
											</div>
											
											<div class="wow-admin-col-4">
												<input type="checkbox" name="param[show_title_hours]" value="1" <?php if(!empty($param['show_title_hours'])) echo 'checked="checcked"'; ?>> Title for Hours <br/>
												<div id="title_hours" style="display:none;">
													<input type='text' name='param[title_hours]' value="<?php if(!empty($param['title_hours'])) echo $param['title_hours']; ?>"/>
												</div>
											</div>
											
											<div class="wow-admin-col-4">
												<input type="checkbox" name="param[show_title_minutes]" value="1" <?php if(!empty($param['show_title_minutes'])) echo 'checked="checcked"'; ?>> Title for Minutes <br/>
												<div id="title_minutes" style="display:none;">
													<input type='text' name='param[title_minutes]' value="<?php if(!empty($param['title_minutes'])) echo $param['title_minutes']; ?>"/>
												</div>
											</div>
											
									</div>
									
									<div class="wow-admin-col">
										<div class="wow-admin-col-4">
											<input type="checkbox" name="param[show_title_seconds]" value="1" <?php if(!empty($param['show_title_seconds'])) echo 'checked="checcked"'; ?>> Title for Seconds <br/>
											<div id="title_seconds" style="display:none;">
												<input type='text' name='param[title_seconds]' value="<?php if(!empty($param['title_seconds'])) echo $param['title_seconds']; ?>"/>
											</div>
										</div>
										
										<div class="wow-admin-col-4">
											
										</div>
										
										<div class="wow-admin-col-4">
											
										</div>
										
									</div>
									
									
									
								</div>
								
							</div>
						</div>
					</div>
					
					<div id="t2">
						<div class="itembox">
							<div class="item-title">
								<h3>Trigger settings</h3>									
							</div>
							<div class="inside" style="display: block;">
								<div class="wow-admin-col">
									<div class="wow-admin-col-4">
										How many triggers you want <a href='admin.php?page=<?php echo $pluginname;?>&tool=pro' title="Only Pro version"><span class="dashicons dashicons-lock" style="color:#37c781;"></span></a>:<br/>
										<select name='param[many_trigger]' onchange="triggerrs();"> 
											<option value="0">0</option>		
										</select>
									</div>
									<div class="wow-admin-col-4"></div>
									<div class="wow-admin-col-4"></div>
								</div>
							</div>
						</div>
					</div>
					<div id="t3">
						<div class="itembox">
							<div class="item-title">
								<h3>Style settings</h3>									
							</div>
							<div class="inside" style="display: block;">
								<div id="fordate">
									<div class="wow-admin-col">
										<div class="wow-admin-col-4">
											Hide days:<br/>
											<select name='param[hide_days]'> 
												<option value="no" <?php if($param['hide_days']=='no') { echo 'selected="selected"'; } ?>>no</option>       
												<option value="yes" <?php if($param['hide_days']=='yes') { echo 'selected="selected"'; } ?>>yes</option>        	
											</select>
										</div>
										<div class="wow-admin-col-4">
											Hide hours:<br/>
											<select name='param[hide_hours]'> 
												<option value="no" <?php if($param['hide_hours']=='no') { echo 'selected="selected"'; } ?>>no</option>       
												<option value="yes" <?php if($param['hide_hours']=='yes') { echo 'selected="selected"'; } ?>>yes</option>        	
											</select>
										</div>
										<div class="wow-admin-col-4">
											Hide minutes:<br/>
											<select name='param[hide_minutes]'> 
												<option value="no" <?php if($param['hide_minutes']=='no') { echo 'selected="selected"'; } ?>>no</option>       
												<option value="yes" <?php if($param['hide_minutes']=='yes') { echo 'selected="selected"'; } ?>>yes</option>        	
											</select>
										</div>
									</div>
									<div class="wow-admin-col">
										<div class="wow-admin-col-4">
											Hide seconds:<br/>
											<select name='param[hide_seconds]'> 
												<option value="no" <?php if($param['hide_seconds']=='no') { echo 'selected="selected"'; } ?>>no</option>       
												<option value="yes" <?php if($param['hide_seconds']=='yes') { echo 'selected="selected"'; } ?>>yes</option>        	
											</select>
										</div>
										<div class="wow-admin-col-4"></div>
										<div class="wow-admin-col-4"></div>
									</div>
								</div>
								<div class="wow-admin-col">
									<div class="wow-admin-col-4 fieldform">
										Countdown width <a href='admin.php?page=<?php echo $pluginname;?>&tool=pro' title="Only Pro version"><span class="dashicons dashicons-lock" style="color:#37c781;"></span></a>: <br/>
										<input type='text' placeholder="auto" disabled="disabled"/> <br/>
										<input type="radio" disabled="disabled" checked="checked">auto <input type="radio" disabled="disabled">px <input type="radio" disabled="disabled">%
									</div>
									<div class="wow-admin-col-4 fieldform">
										Countdown height <a href='admin.php?page=<?php echo $pluginname;?>&tool=pro' title="Only Pro version"><span class="dashicons dashicons-lock" style="color:#37c781;"></span></a>: <br/>
										<input type='text' placeholder="auto" disabled="disabled"/> <br/>
										<input type="radio" disabled="disabled" checked="checked">auto <input type="radio" disabled="disabled">px 
									</div>
									<div class="wow-admin-col-4">
										Padding top  (px) <a href='admin.php?page=<?php echo $pluginname;?>&tool=pro' title="Only Pro version"><span class="dashicons dashicons-lock" style="color:#37c781;"></span></a>:<br/>
										<input type='text' placeholder="10" disabled="disabled">
									</div>								
								</div>
								
								<div class="wow-admin-col">
									<div class="wow-admin-col-4">
										Padding bottom (px) <a href='admin.php?page=<?php echo $pluginname;?>&tool=pro' title="Only Pro version"><span class="dashicons dashicons-lock" style="color:#37c781;"></span></a>:<br/>
										<input type='text' placeholder="10" disabled="disabled">
									</div>
									<div class="wow-admin-col-4">
										Padding left (px) <a href='admin.php?page=<?php echo $pluginname;?>&tool=pro' title="Only Pro version"><span class="dashicons dashicons-lock" style="color:#37c781;"></span></a>:<br/>
										<input type='text' placeholder="10" disabled="disabled">
									</div>
									<div class="wow-admin-col-4">
										Padding right (px) <a href='admin.php?page=<?php echo $pluginname;?>&tool=pro' title="Only Pro version"><span class="dashicons dashicons-lock" style="color:#37c781;"></span></a>:<br/>
										<input type='text' placeholder="10" disabled="disabled">
									</div>
								</div>
								<div class="wow-admin-col">
									<div class="wow-admin-col-4">
										Border width (px) <a href='admin.php?page=<?php echo $pluginname;?>&tool=pro' title="Only Pro version"><span class="dashicons dashicons-lock" style="color:#37c781;"></span></a>:<br/>
										<input type='text' placeholder="0" disabled="disabled">
									</div>
									<div class="wow-admin-col-4">
										Border radius (px) <a href='admin.php?page=<?php echo $pluginname;?>&tool=pro' title="Only Pro version"><span class="dashicons dashicons-lock" style="color:#37c781;"></span></a>:<br/>
										<input type='text' placeholder="0" disabled="disabled">
									</div>
									<div class="wow-admin-col-4">
										Number font size (px):<br/>
										<input type='text'  placeholder="14" name='param[font_size]' value="<?php if(!empty($param['font_size'])) echo $param['font_size']; ?>"/>
									</div>
								</div>
								
								<div class="wow-admin-col">
									<div class="wow-admin-col-4">
										Delimiter font size (px):<br/>
										<input type='text'  placeholder="5" name='param[delimiter_size]' value="<?php if(!empty($param['delimiter_size'])) echo $param['delimiter_size']; ?>"/>
									</div>
									<div class="wow-admin-col-4">
										Title font size (px):<br/>
										<input type='text'  placeholder="10" name='param[title_font_size]' value="<?php if(!empty($param['title_font_size'])) echo $param['title_font_size']; ?>"/>
									</div>
									<div class="wow-admin-col-4">
										Type of delimeter:<br/>
										<select name='param[type_delimiter]'>        
											<option value=":" <?php if($param['type_delimiter']==':') { echo 'selected="selected"'; } ?>>:</option>
											<option value="." <?php if($param['type_delimiter']=='.') { echo 'selected="selected"'; } ?>>.</option>
											<option value="-" <?php if($param['type_delimiter']=='-') { echo 'selected="selected"'; } ?>>-</option>       
											<option value="|" <?php if($param['type_delimiter']=='|') { echo 'selected="selected"'; } ?>>|</option>
											<option value="/" <?php if($param['type_delimiter']=='/') { echo 'selected="selected"'; } ?>>/</option>		
										</select>
									</div>									
								</div>								
								<div class="wow-admin-col">
									<div class="wow-admin-col-4">
										Background color <a href='admin.php?page=<?php echo $pluginname;?>&tool=pro' title="Only Pro version"><span class="dashicons dashicons-lock" style="color:#37c781;"></span></a>:<br/>
										<img src="<?php echo plugin_dir_url( __FILE__ ); ?>img/white.jpg">
									</div>
									<div class="wow-admin-col-4">
										Border color <a href='admin.php?page=<?php echo $pluginname;?>&tool=pro' title="Only Pro version"><span class="dashicons dashicons-lock" style="color:#37c781;"></span></a>:<br/>
										<img src="<?php echo plugin_dir_url( __FILE__ ); ?>img/white.jpg">
									</div>
									<div class="wow-admin-col-4">
										Digits text color <a href='admin.php?page=<?php echo $pluginname;?>&tool=pro' title="Only Pro version"><span class="dashicons dashicons-lock" style="color:#37c781;"></span></a>:<br/>
										<img src="<?php echo plugin_dir_url( __FILE__ ); ?>img/black.jpg">
									</div>
								</div>
								
								<div class="wow-admin-col">
									
									<div class="wow-admin-col-4">
										Delimiter text color <a href='admin.php?page=<?php echo $pluginname;?>&tool=pro' title="Only Pro version"><span class="dashicons dashicons-lock" style="color:#37c781;"></span></a>:<br/>
										<img src="<?php echo plugin_dir_url( __FILE__ ); ?>img/black.jpg">
									</div>
									
									<div class="wow-admin-col-4">
										Title text color <a href='admin.php?page=<?php echo $pluginname;?>&tool=pro' title="Only Pro version"><span class="dashicons dashicons-lock" style="color:#37c781;"></span></a>:<br/>
										<img src="<?php echo plugin_dir_url( __FILE__ ); ?>img/white.jpg">
									</div>
									
									<div class="wow-admin-col-4"></div>
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="wow-rightcol">
			<div class="wowbox">
				<h3>Publish</h3>
				<div class="wow-admin" style="display: block;">
					<div class="wow-admin-col">
						<div class="wow-admin-col-6">
							<?php if ($id != ""){ echo '<p class="wowdel"><a href="admin.php?page='.$pluginname.'&info=del&did='.$id.'">Delete</a></p>';}; ?>
						</div>
						<div class="wow-admin-col-6 right">
							<p/>
							<input name="submit" id="submit" class="button button-primary" value="<?php echo $btn; ?>" type="submit">
						</div>
					</div>
				</div>
			</div>
			<div class="wowbox">
				<h3>Display</h3>
				<div class="inside" style="display: block;">
					<div class="wow-admin-col wow-wrap">
						<div class="wow-admin-col-12">
							Show for users: <br/>
							<input type="radio" checked="checked"> All users <br />
							<input type="radio" disabled="disabled"> If a user logged in <a href='admin.php?page=<?php echo $pluginname;?>&tool=pro' title="Only Pro version"><span class="dashicons dashicons-lock" style="color:#37c781;"></span></a><br />
							<input type="radio" disabled="disabled"> If user not logged <a href='admin.php?page=<?php echo $pluginname;?>&tool=pro' title="Only Pro version"><span class="dashicons dashicons-lock" style="color:#37c781;"></span></a> 
						</div>
						
						<div class="wow-admin-col-12">
							<input type="checkbox" disabled="disabled"> Depending on the language <a href='admin.php?page=<?php echo $pluginname;?>&tool=pro' title="Only Pro version"><span class="dashicons dashicons-lock" style="color:#37c781;"></span></a>
						</div>
						
						<div class="wow-admin-col-12" style="display:none;" id="shortcode" >
							<b>[Wow-Countdowns id=<?php echo $id; ?>]</b>
						</div>	
						
					</div>
				</div>
			</div>
			<div class="wowbox">
				<center><img src="<?php echo plugin_dir_url( __FILE__ ); ?>thankyou.png" alt=""  /></center>
				<hr/>				
				<div class="wow-admin wow-plugins">
					<p>We will be very grateful if you <a href="https://wordpress.org/plugins/mwp-countdown/" target="_blank"><b>leave a review about the plugin</b></a>.</p>
					<p>If you have suggestions on how to improve the plugin or create a new plugin, write to us via the <a href="admin.php?page=<?php echo $pluginname;?>&tool=support" target="_blank"><b>support form</b></a></p>					
					<p>We really appreciate your reviews and suggestions for improving the plugin.</p>
					<p>					
					<b><em>Thank you for choosing the plugin from Wow-Company! </em></b></p>
					<em><b>Best Regards</b>,<br/>						
						<a href="https://wow-estore.com/" target="_blank">Wow-Company Team</a><br/>
						Dmytro Lobov<br/>
						<a href="mailto:support@wow-company.com">support@wow-company.com</a>
					</em>
					
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" name="add" value="<?php echo $hidval; ?>" />    
	<input type="hidden" name="id" value="<?php echo $id; ?>" />
	<input type="hidden" name="data" value="<?php echo $data; ?>" />
	<input type="hidden" name="page" value="<?php echo $pluginname;?>" />	
	<input type="hidden" name="plugdir" value="<?php echo $pluginname;?>" />		
	<?php wp_nonce_field('wow_plugin_action','wow_plugin_nonce_field'); ?>
</form>