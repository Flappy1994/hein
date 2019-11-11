<form method="post" action="<?= admin_url('/admin-ajax.php'); ?>">
	<input type="hidden" name="action" value="admin-cookie-notice">

	<h1><?php _e('Cookie Notice','shapepress-dsgvo')?></h1>

	<table class="form-table">
		<tr>
			<th scope="row"><?php _e('Tracker initialization:','shapepress-dsgvo')?></th>
			<td>
			<?php $cnTrackerInit = SPDSGVOSettings::get('cn_tracker_init'); ?>
			<label for="cn_tracker_init"> <select name="cn_tracker_init"
					id="cn_tracker_init">
						<option value="on_load" <?= selected($cnTrackerInit == 'on_load') ?>> <?php _e('When loading the page','shapepress-dsgvo')?></option>
						<option value="after_confirm" <?= selected($cnTrackerInit == 'after_confirm') ?>><?php _e('After approval of the cookie','shapepress-dsgvo')?></option>
				</select>
			</label> <span class="info-text"><?php _e('Specifies when the trackers should be active. Whether before the consent of the cookie or after clicking on Ok. For After approval Reload after approval must be checked.','shapepress-dsgvo')?></span>
			</td>
		</tr>
   </table>

	<table class="form-table" style="margin-top: 0">
		<tbody>
			<tr>
				<td style="width: 50%;">
					<table class="form-table">
						<tr>
							<th scope="row"><?php _e('Google Analyics','shapepress-dsgvo')?></th>
							<td><label for="ga_enable_analytics"> <input
									name="ga_enable_analytics" type="checkbox"
									id="ga_enable_analytics" value="1"
									<?= (SPDSGVOSettings::get('ga_enable_analytics') === '1')? ' checked ' : '';  ?>>
							</label></td>
						</tr>
						<tr>
							<th scope="row"><?php _e('GTAG number:','shapepress-dsgvo')?></th>
							<td><label for="ga_tag_number"> <input name="ga_tag_number"
									type="text" id="ga_tag_number" placeholder="XX-XXXXXX-X"
									value="<?= SPDSGVOSettings::get('ga_tag_number');  ?>">
							</label></td>
						</tr>

						<tr>
							<td colspan="2" class="info-text"><?php _e('The IP address will be anonymously and visitors get the option refuse tracking. <br />Tip: Country specific geodata will be further tracked even with anonymization.','shapepress-dsgvo')?>
							</td>
						</tr>
					</table>
				</td>
				<td style="width: 50%:">
					<table class="form-table">
						<tr>
							<th scope="row"><?php _e('Facebook Pixel','shapepress-dsgvo')?></th>
							<td><label for="fb_enable_pixel"> <input name="fb_enable_pixel"
									type="checkbox" id="fb_enable_pixel" value="1"
									<?= (SPDSGVOSettings::get('fb_enable_pixel') === '1')? ' checked ' : '';  ?>>
							</label></td>
						</tr>
						<tr>
							<th scope="row"><?php _e('FB Pixel Id:','shapepress-dsgvo')?></th>
							<td><label for="fb_pixel_number"> <input name="fb_pixel_number"
									type="text" id="fb_pixel_number" placeholder="123456789"
									value="<?= SPDSGVOSettings::get('fb_pixel_number');  ?>">
							</label></td>
						</tr>

						<tr>
							<td colspan="2" style="vertical-align: top" class="info-text"><?php _e('Visitors maintained the opportunity to reject the tracking.','shapepress-dsgvo')?></td>
						</tr>
					</table>
				</td>
			</tr>

			<!-- i592995 -->
			<?php $disableOwnTracker = (isValidBlogEdition() || isValidPremiumEdition()) == false; ?>
			<tr>
				<th scope="row">
					<?php _e('Use your own Codes (at own risk)','shapepress-dsgvo')?>
					<label for="own_code"> <input
						name="own_code" type="checkbox"
						id="own_code" value="1"
						<?= $disableOwnTracker ? 'disabled' : true;  ?>
						<?= (SPDSGVOSettings::get('own_code') === '1')? ' checked ' : '';  ?>>
				</label>
				</th>
				<td>
					</td>
			</tr>

			<tr>
				<td>
					<table class="form-table">

						<?php
						$ga_code = SPDSGVOSettings::get('ga_code', '');
						if($ga_code == '') {
							$ga_code = googleAnalyticsScript(true);
						}
						?>

						<tr>
							<th scope="row"><?php _e('Google Analytics code:','shapepress-dsgvo')?></th>
							<td>
								<label for="ga_code">
									<textarea id="ga_code" name="ga_code" class="ga-code" <?= (SPDSGVOSettings::get('own_code') === '1')? '' : 'disabled';  ?>>
										<?php echo $ga_code; ?>
									</textarea>
									<?php _e('If left blank, the standard GA script will be used','shapepress-dsgvo'); ?>
								</label>
							</td>
						</tr>
						<!-- .i592995 -->
					</table>
				</td>
				<td>
					<table class="form-table">
						<!-- .i592995 -->

						<?php
						$fb_pixel_code = SPDSGVOSettings::get('fb_pixel_code', '');
						if($fb_pixel_code == '') {
							$fb_pixel_code = facebookPixelScript(true);
						}
						?>

						<tr>
							<th scope="row"><?php _e('Facebook Pixel code:','shapepress-dsgvo')?></th>
							<td>
								<label for="fb_pixel_code">
									<textarea id="fb_pixel_code" name="fb_pixel_code" class="fb-pixel-code" <?= (SPDSGVOSettings::get('own_code') === '1')? '' : 'disabled';  ?>>
										<?php echo $fb_pixel_code; ?>
									</textarea>
									<?php _e('If left blank, the standard FB Pixel script will be used. [pixel_number] will be replaced with FB Pixel ID.','shapepress-dsgvo'); ?>
								</label>
							</td>
						</tr>
					</table>
				</td>
			</tr>

			<!-- i592995 -->

	</table>
	<hr class="sp-dsgvo">

	<!-- i592995 -->
	<table class="form-table">
		<tr>
			<th scope="row"><?php _e('Notice type','shapepress-dsgvo')?></th>
			<td>
				<label for="cookie_notice_display">
					<select id="cookie_notice_display" name="cookie_notice_display">
						<option value="no_popup" <?php if(SPDSGVOSettings::get('cookie_notice_display') == 'no_popup') {echo 'selected';} ?>><?php _e('No notice','shapepress-dsgvo')?></option>
						<option value="cookie_notice" <?php if(SPDSGVOSettings::get('cookie_notice_display') == 'cookie_notice') {echo 'selected';} ?>><?php _e('Cookie Notice','shapepress-dsgvo')?></option>
						<?php if(isValidPremiumEdition()):?>
						<option value="policy_popup" <?php if(SPDSGVOSettings::get('cookie_notice_display') == 'policy_popup') {echo 'selected';} ?>><?php _e('Privacy Popup','shapepress-dsgvo')?></option>
						<?php endif?>
					</select><!-- #cookie_notice_display -->
				</label>
			</td>
		</tr>
	</table>

	<table class="form-table policy-popup-settings" id="policy_popup_settings">
	
			<tr>
			<th scope="row"><?php _e('Validity:','shapepress-dsgvo')?></th>
			<td>
			<?php $cnCookieValidity = SPDSGVOSettings::get('cn_cookie_validity'); ?>
			<label for="cn_cookie_validity"> <select name="cn_cookie_validity"
					id="cn_cookie_validity">
						<option value="86400" <?= selected($cnCookieValidity == 86400) ?>>1
							<?php _e('Tag','shapepress-dsgvo')?></option>
						<option value="604800" <?= selected($cnCookieValidity == 604800) ?>>1
							<?php _e('Woche','shapepress-dsgvo')?></option>
						<option value="2592000"
						<?= selected($cnCookieValidity == 2592000) ?>>1 <?php _e('Month','shapepress-dsgvo')?></option>
						<option value="7862400"
						<?= selected($cnCookieValidity == 7862400) ?>>2 <?php _e('Month','shapepress-dsgvo')?></option>
						<option value="15811200"
						<?= selected($cnCookieValidity == 15811200) ?>>6 <?php _e('Month','shapepress-dsgvo')?></option>
						<option value="31536000"
						<?= selected($cnCookieValidity == 31536000) ?>>1 <?php _e('Year','shapepress-dsgvo')?></option>
				</select>
			</label> <span class="info-text"><?php _e('For this period, the cookie is navigation use validly.','shapepress-dsgvo')?></span>
			</td>
		</tr>
	
		<tr>
			<th scope="row"><?php _e('Popup logo','shapepress-dsgvo')?></th>
			<td>
				<?php
				$src = '';
				$img_id = '';
				if(SPDSGVOSettings::get('logo_image_id', '') != '') {
					$img_id = SPDSGVOSettings::get('logo_image_id');
					$src = wp_get_attachment_url(intval($img_id));
				}
				?>
				<?php $disableUploadButton = (isValidBlogEdition() || isValidPremiumEdition()) == false; ?>
				<div class="dsgvo-image-upload">
					<div class='image-preview-wrapper'>
						<img id='logo_image-preview' class="image-preview" src='<?php echo $src; ?>' style="width: 200px">
					</div>
					<input id="logo_upload_image_button" type="button"
					class="button"
					<?= $disableUploadButton ? 'disabled' : true;  ?>
					value="<?php _e( 'Upload image', 'shapepress-dsgvo' ); ?>" />
					<input type='hidden' class="image-id" name='logo_image_id' id='logo_image_id' value='<?php echo $img_id; ?>'>
				</div><!-- .dsgvo-image-upload -->
			</td>
		</tr>

		<tr>
			<th scope="row"><?php _e('Close button action','shapepress-dsgvo')?></th>
			<td>
				<label for="close_button_action">
					<select id="close_button_action" name="close_button_action">
						<option value="0" <?php if(SPDSGVOSettings::get('close_button_action') == '0') {echo 'selected';} ?>><?php _e('Close popup','shapepress-dsgvo')?></option>
						<option value="1" <?php if(SPDSGVOSettings::get('close_button_action') == '1') {echo 'selected';} ?>><?php _e('Redirect to URL','shapepress-dsgvo')?></option>
					</select><!-- #close_button_action -->
				</label>
			</td>
		</tr>

		<tr>
			<th scope="row"><?php _e('Reload after confirm:','shapepress-dsgvo')?></th>

			<td><label for="cn_reload_on_confirm"> <input
					name="cn_reload_on_confirm" type="checkbox"
					id="cn_reload_on_confirm" value="1"
					<?= (SPDSGVOSettings::get('cn_reload_on_confirm') === '1')? ' checked ' : '';  ?>>
			</label><span class="info-text"><?php _e('Enable this option to reload the page after accepting cookies.','shapepress-dsgvo')?></span></td>

		</tr>

		<tr>
			<th scope="row"><?php _e('Accept button custom text','shapepress-dsgvo')?></th>
			<td>
				<label for="accept_button_text">
					<input type="text" value="<?php echo SPDSGVOSettings::get('accept_button_text', ''); ?>" name="accept_button_text" id="accept_button_text" />
				</label>
			</td>
		</tr>

		<tr>
			<th scope="row"><?php _e('More Options button custom text','shapepress-dsgvo')?></th>
			<td>
				<label for="more_options_button_text">
					<input type="text" value="<?php echo SPDSGVOSettings::get('more_options_button_text', ''); ?>" name="more_options_button_text" id="more_options_button_text" />
				</label>
			</td>
		</tr>

		<tr>
			<th scope="row"><?php _e('Close button URL','shapepress-dsgvo')?></th>
			<td>
				<label for="close_button_url">
					<input type="text" value="<?php echo SPDSGVOSettings::get('close_button_url', ''); ?>" name="close_button_url" id="close_button_url" />
				</label>
			</td>
		</tr>

		<tr>
			<th scope="row"><?php _e('Accordion title text','shapepress-dsgvo')?></th>
			<td>
				<label for="accordion_top">
					<input type="text" value="<?php echo SPDSGVOSettings::get('accordion_top', ''); ?>" name="accordion_top" id="accordion_top" />
				</label>
			</td>
		</tr>

		<tr>
			<?php
			$val = SPDSGVOSettings::get('popup_background');
			if($val == '') {
				$val = '#ffffff';
			}
			?>
			<td style="width: 200px"><?php _e('Popup background:','shapepress-dsgvo')?></td>
			<td><label for="popup_background"> <input
					name="popup_background" type="color" id="popup_background"
					value="<?php echo $val; ?>">
			</label>
			</td>
		</tr>

		<tr>
			<?php
			$val = SPDSGVOSettings::get('separators_color');
			if($val == '') {
				$val = '#f1f1f1';
			}
			?>
			<td style="width: 200px"><?php _e('Separators color:','shapepress-dsgvo')?></td>
			<td><label for="separators_color"> <input
					name="separators_color" type="color" id="separators_color"
					value="<?php echo $val; ?>">
			</label>
			</td>
		</tr>

		<tr>
			<?php
			$val = SPDSGVOSettings::get('text_color');
			if($val == '') {
				$val = '#222222';
			}
			?>
			<td style="width: 200px"><?php _e('Font color:','shapepress-dsgvo')?></td>
			<td><label for="text_color"> <input
					name="text_color" type="color" id="text_color"
					value="<?php echo $val; ?>">
			</label>
			</td>
		</tr>

		<tr>
			<?php
			$val = SPDSGVOSettings::get('links_color');
			if($val == '') {
				$val = '#4285f4';
			}
			?>
			<td style="width: 200px"><?php _e('Links color:','shapepress-dsgvo')?></td>
			<td><label for="links_color"> <input
					name="links_color" type="color" id="links_color"
					value="<?php echo $val; ?>">
			</label>
			</td>
		</tr>

		<tr>
			<?php
			$val = SPDSGVOSettings::get('links_color_hover');
			if($val == '') {
				$val = '#4285f4';
			}
			?>
			<td style="width: 200px"><?php _e('Links color (hover):','shapepress-dsgvo')?></td>
			<td><label for="links_color_hover"> <input
					name="links_color_hover" type="color" id="links_color_hover"
					value="<?php echo $val; ?>">
			</label>
			</td>
		</tr>

		<tr>
			<?php
			$val = SPDSGVOSettings::get('accept_button_text_color');
			if($val == '') {
				$val = '#ffffff';
			}
			?>
			<td style="width: 200px"><?php _e('Accept button font color:','shapepress-dsgvo')?></td>
			<td><label for="accept_button_text_color"> <input
					name="accept_button_text_color" type="color" id="accept_button_text_color"
					value="<?php echo $val; ?>">
			</label>
			</td>
		</tr>

		<tr>
			<?php
			$val = SPDSGVOSettings::get('accept_button_bg_color');
			if($val == '') {
				$val = '#4285f4';
			}
			?>
			<td style="width: 200px"><?php _e('Accept button background color:','shapepress-dsgvo')?></td>
			<td><label for="accept_button_bg_color"> <input
					name="accept_button_bg_color" type="color" id="accept_button_bg_color"
					value="<?php echo $val; ?>">
			</label>
			</td>
		</tr>

	</table>

	<table class="form-table cookie-notice-settings">
		<?php /*
		<tr>

			<th scope="row"><?php _e('Cookie Notice','shapepress-dsgvo')?></th>
			<td><label for="display_cookie_notice"> <input
					name="display_cookie_notice" type="checkbox"
					id="display_cookie_notice" value="1"
					<?= (SPDSGVOSettings::get('display_cookie_notice') === '1')? ' checked ' : '';  ?>>
			</label></td>
		</tr>

		*/ ?>

		<!-- i592995 -->

		<tr>
			<th scope="row"><?php _e('Notice text:','shapepress-dsgvo')?></th>
			<td><textarea name="cookie_notice_custom_text"
					placeholder="<?php _e('Insert the text here', 'shapepress-dsgvo'); ?>" id="cookie_notice_custom_text" rows="10"
					style="width: 100%"><?= SPDSGVOSettings::get('cookie_notice_custom_text') ?></textarea></td>
		</tr>
		<tr>
			<td><?php _e('Validity:','shapepress-dsgvo')?></td>
			<td>
			<?php $cnCookieValidity = SPDSGVOSettings::get('cn_cookie_validity'); ?>
			<label for="cn_cookie_validity"> <select name="cn_cookie_validity"
					id="cn_cookie_validity">
						<option value="86400" <?= selected($cnCookieValidity == 86400) ?>>1
							<?php _e('Tag','shapepress-dsgvo')?></option>
						<option value="604800" <?= selected($cnCookieValidity == 604800) ?>>1
							<?php _e('Woche','shapepress-dsgvo')?></option>
						<option value="2592000"
						<?= selected($cnCookieValidity == 2592000) ?>>1 <?php _e('Month','shapepress-dsgvo')?></option>
						<option value="7862400"
						<?= selected($cnCookieValidity == 7862400) ?>>2 <?php _e('Month','shapepress-dsgvo')?></option>
						<option value="15811200"
						<?= selected($cnCookieValidity == 15811200) ?>>6 <?php _e('Month','shapepress-dsgvo')?></option>
						<option value="31536000"
						<?= selected($cnCookieValidity == 31536000) ?>>1 <?php _e('Year','shapepress-dsgvo')?></option>
				</select>
			</label> <span class="info-text"><?php _e('For this period, the cookie is navigation use validly.','shapepress-dsgvo')?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"></th>
			<td></td>
		</tr>

		<tr>
			<th scope="row"><?php _e('Confirmation','shapepress-dsgvo')?></th>
			<td></td>
		</tr>

		<tr>
			<td><?php _e('Button text:','shapepress-dsgvo')?></td>

			<td><label for="cn_button_text_ok"> <input name="cn_button_text_ok"
					style="width: 300px" type="text" id="cn_button_text_ok"
					value="<?= SPDSGVOSettings::get('cn_button_text_ok');  ?>"
					placeholder="<?php _e('zB.: Ok', 'shapepress-dsgvo'); ?>">
			</label><span class="info-text"><?php _e('The text to be displayed is to accept the note and hide the message.','shapepress-dsgvo')?></span></td>

		</tr>

		<tr>
			<td><?php _e('Reload after confirm:','shapepress-dsgvo')?></td>

			<td><label for="cn_reload_on_confirm"> <input
					name="cn_reload_on_confirm" type="checkbox"
					id="cn_reload_on_confirm" value="1"
					<?= (SPDSGVOSettings::get('cn_reload_on_confirm') === '1')? ' checked ' : '';  ?>>
			</label><span class="info-text"><?php _e('Enable this option to reload the page after accepting cookies.','shapepress-dsgvo')?></span></td>

		</tr>

		<tr>
			<th scope="row"><?php _e('Decline','shapepress-dsgvo')?></th>
			<td></td>
		</tr>

		<tr>
			<td><?php _e('Button active:','shapepress-dsgvo')?></td>

			<td><label for="cn_activate_cancel_btn"> <input
					name="cn_activate_cancel_btn" type="checkbox"
					id="cn_activate_cancel_btn" value="1"
					<?= (SPDSGVOSettings::get('cn_activate_cancel_btn') === '1')? ' checked ' : '';  ?>>
			</label></td>

		</tr>
		<tr>
			<td><?php _e('Button text:','shapepress-dsgvo')?></td>

			<td><label for="cn_button_text_cancel"> <input
					name="cn_button_text_cancel" type="text" id="cn_button_text_cancel"
					style="width: 300px"
					value="<?= SPDSGVOSettings::get('cn_button_text_cancel');  ?>"
					placeholder="<?php _e('eg.: Decline','shapepress-dsgvo')?>">
			</label><span class="info-text"><?php _e('The text of the option to decline cookies.','shapepress-dsgvo')?></span></td>

		</tr>

		<tr>
			<td><?php _e('Link target for rejection:','shapepress-dsgvo')?></td>

			<td><label for="cn_decline_target_url"> <input
					name="cn_decline_target_url" type="text" id="cn_decline_target_url"
					style="width: 300px"
					value="<?= SPDSGVOSettings::get('cn_decline_target_url');  ?>"
					placeholder="<?php _e('zb.: www.google.at','shapepress-dsgvo')?>">
			</label><span class="info-text"><?php _e('Specifies the destination where visitors who want to reject the message should be forwarded.','shapepress-dsgvo')?></span></td>

		</tr>
		<tr>
			<td><?php _e('Do not set a cookie on forwarding:','shapepress-dsgvo')?></td>
			<td><label for="cn_decline_no_cookie"> <input
					name="cn_decline_no_cookie" type="checkbox"
					id="cn_decline_no_cookie" value="1"
					<?= (SPDSGVOSettings::get('cn_decline_no_cookie') === '1')? ' checked ' : '';  ?>>
			</label><span class="info-text"><?php _e('If active, the visitor refuses and returns to the page, the notice will reappear.','shapepress-dsgvo')?></span></td>
		</tr>

		<tr>
			<th scope="row"><?php _e('Read more','shapepress-dsgvo')?></th>
			<td></td>
		</tr>

		<tr>
			<td><?php _e('Button active:','shapepress-dsgvo')?></td>

			<td><label for="cn_activate_more_btn"> <input
					name="cn_activate_more_btn" type="checkbox"
					id="cn_activate_more_btn" value="1"
					<?= (SPDSGVOSettings::get('cn_activate_more_btn') === '1')? ' checked ' : '';  ?>>
			</label></td>

		</tr>

		<tr>
			<td><?php _e('Button text:','shapepress-dsgvo')?></td>

			<td><label for="cn_button_text_more"> <input
					name="cn_button_text_more" type="text" id="cn_button_text_more"
					style="width: 300px"
					value="<?= SPDSGVOSettings::get('cn_button_text_more');  ?>"
					placeholder="<?php _e('zB.: Erfahre mehr','shapepress-dsgvo')?>">
			</label><span class="info-text"><?php _e('The text of the option to obtain more information','shapepress-dsgvo')?></span></td>

		</tr>
		<tr>
			<td><?php _e('Link destination to read on:','shapepress-dsgvo')?></td>

			<td>
			<?php $readMorePage = SPDSGVOSettings::get('cn_read_more_page'); ?>
						<label for="cn_read_more_page"><select style="width: 300px"
					name="cn_read_more_page" id="cn_read_more_page">
						<option value="0">W&auml;hlen</option>
								<?php foreach(get_pages(array('number' => 0)) as $key => $page): ?>
									<option <?= selected($readMorePage == $page->ID) ?>
							value="<?= $page->ID ?>">
										<?= $page->post_title ?>
									</option>
								<?php endforeach; ?>
							</select> </label><span class="info-text"><?php _e('Specifies the destination to where visitors will find more information about cookies.','shapepress-dsgvo')?></span>
			</td>

		</tr>

		<tr>
			<th scope="row" colspan="2"><?php _e('Options for displaying the cookie notice.','shapepress-dsgvo')?></th>
		</tr>

		<tr>
			<td><?php _e('Position:','shapepress-dsgvo')?></td>
			<td>
			<?php $cnNoticePosition = SPDSGVOSettings::get('cn_position'); ?>
			<label for="cn_position"> <select name="cn_position" id="cn_position">
						<option value="top" <?= selected($cnNoticePosition == 'top') ?>><?php _e('On top','shapepress-dsgvo')?></option>
						<option value="bottom"
							<?= selected($cnNoticePosition == 'bottom') ?>><?php _e('Bottom','shapepress-dsgvo')?></option>
				</select>
			</label> <span class="info-text"><?php _e('Specifies the location where the cookie notice should be displayed.','shapepress-dsgvo')?></span>
			</td>
		</tr>
		<tr>
			<td><?php _e('Animation','shapepress-dsgvo')?></td>
			<td>
			<?php $cnNoticeAnimation = SPDSGVOSettings::get('cn_animation'); ?>
			<label for="cn_animation"> <select name="cn_animation"
					id="cn_animation">
						<option value="none" <?= selected($cnNoticeAnimation == 'none') ?>><?php _e('None','shapepress-dsgvo')?></option>
						<option value="fade"
						<?= selected($cnNoticeAnimation == 'fade') ?>><?php _e('fade','shapepress-dsgvo')?></option>
						<option value="hide"
						<?= selected($cnNoticeAnimation == 'hide') ?>><?php _e('hide','shapepress-dsgvo')?></option>
				</select>
			</label> <span class="info-text"><?php _e('Animation when accepting the cookie message.','shapepress-dsgvo')?></span>
			</td>
		</tr>
				</tbody>
		</table>

		<?php $disableCnStylingOptionTableInput = (isValidBlogEdition() || isValidPremiumEdition()) == false; ?>
   <table class="form-table cookie-notice-settings" id="cnStylingOptionTable">
    <tbody>
		<tr>
		    <?php if (isValidBlogEdition() || isValidPremiumEdition()) :  ?>
    		<th scope="row" colspan="2"><?php _e('Color adjustment','shapepress-dsgvo')?></th>
    		<?php else :  ?>
    		<th scope="row" colspan="2"><?php _e('Color adjustment','shapepress-dsgvo')?><span style="color: orange"><?php _e('Possible with blog or premium edition','shapepress-dsgvo')?></span>
    		<small><a href="https://www.wp-dsgvo.eu/shop"><?php _e('Click here to get a license','shapepress-dsgvo')?></a></small>
    		</th>
    		<?php endif;  ?>
		</tr>
		<tr>
			<td style="width: 200px"><?php _e('Background:','shapepress-dsgvo')?></td>
			<td><label for="cn_background_color"> <input
					name="cn_background_color" type="color" id="cn_background_color"
					<?= $disableCnStylingOptionTableInput ? 'disabled' : true;  ?>
					value="<?= SPDSGVOSettings::get('cn_background_color');  ?>">
			</label>
			</td>
		</tr>
		<tr>
			<td><?php _e('Text:','shapepress-dsgvo')?></td>
			<td><label for="cn_text_color"> <input
					name="cn_text_color" type="color" id="cn_text_color"
					<?= $disableCnStylingOptionTableInput ? 'disabled' : true;  ?>
					value="<?= SPDSGVOSettings::get('cn_text_color');  ?>">
			</label></td>
		</tr>
		<tr>
			<td><?php _e('Buttons','shapepress-dsgvo')?></td>
			<td><?php _e('Background','shapepress-dsgvo')?> <label for="cn_background_color"> <input
					name="cn_background_color_button" type="color" id="cn_background_color_button"
					<?= $disableCnStylingOptionTableInput ? 'disabled' : true;  ?>
					value="<?= SPDSGVOSettings::get('cn_background_color_button');  ?>">
			</label>
			<?php _e('Font:','shapepress-dsgvo')?> <label for="cn_text_color_button"> <input
					name="cn_text_color_button" type="color" id="cn_text_color_button"
					<?= $disableCnStylingOptionTableInput ? 'disabled' : true;  ?>
					value="<?= SPDSGVOSettings::get('cn_text_color_button');  ?>">
			</label></td>
		</tr>
		<tr>
    		<th scope="row"><?php _e('CSS Classes','shapepress-dsgvo')?></th>
    		<td><span class="info-text"><?php _e('The colors listed under "Color Changes“ must be overwritten with !Important.','shapepress-dsgvo')?></span></td>
		</tr>
		<tr>
			<td><?php _e('Cookie notice:','shapepress-dsgvo')?></td>
			<td><label for="cn_custom_css_container"> <input
					name="cn_custom_css_container" type="text" id="cn_custom_css_container"
					<?= $disableCnStylingOptionTableInput ? 'disabled' : true;  ?>
					value="<?= SPDSGVOSettings::get('cn_custom_css_container');  ?>">
			</label></td>
		</tr>
		<tr>
			<td><?php _e('Text','shapepress-dsgvo')?></td>
			<td><label for="cn_custom_css_text"> <input
					name="cn_custom_css_text" type="text" id="cn_custom_css_text"
					<?= $disableCnStylingOptionTableInput ? 'disabled' : true;  ?>
					value="<?= SPDSGVOSettings::get('cn_custom_css_text');  ?>">
			</label></td>
		</tr>
		<tr>
			<td><?php _e('Buttons:','shapepress-dsgvo')?></td>
			<td><label for="cn_custom_css_buttons"> <input
					name="cn_custom_css_buttons" type="text" id="cn_custom_css_buttons"
					<?= $disableCnStylingOptionTableInput ? 'disabled' : true;  ?>
					value="<?= SPDSGVOSettings::get('cn_custom_css_buttons');  ?>">
			</label></td>
		</tr>
		<tr>
    		<th scope="row" colspan="2"><?php _e('Further display options','shapepress-dsgvo')?></th>
		</tr>
		<tr>
			<td><?php _e('Font size','shapepress-dsgvo')?></td>
			<td><label for="cn_size_text">

				    <?php $cnSizeText = SPDSGVOSettings::get('cn_size_text'); ?>
					<select name="cn_size_text"
					  <?= $disableCnStylingOptionTableInput ? 'disabled' : true;  ?>
					  id="cn_size_text">
					    <option value="auto" <?= selected($cnSizeText == '11px') ?>><?php _e('Default','shapepress-dsgvo')?></option>
						<option value="11px" <?= selected($cnSizeText == '11px') ?>>11px</option>
						<option value="12px" <?= selected($cnSizeText == '12px') ?>>12px</option>
						<option value="13px" <?= selected($cnSizeText == '13px') ?>>13px</option>
						<option value="14px" <?= selected($cnSizeText == '14px') ?>>14px</option>
						<option value="15px" <?= selected($cnSizeText == '15px') ?>>15px</option>
						<option value="16px" <?= selected($cnSizeText == '16px') ?>>16px</option>
						<option value="17px" <?= selected($cnSizeText == '17px') ?>>17px</option>
						<option value="18px" <?= selected($cnSizeText == '18px') ?>>18px</option>
						<option value="19px" <?= selected($cnSizeText == '19px') ?>>19px</option>
						<option value="20px" <?= selected($cnSizeText == '20px') ?>>20px</option>
				</select>

			</label></td>
		</tr>
		<tr>
			<td><?php _e('Height of cookie notice','shapepress-dsgvo')?></td>
			<td><label for="cn_height_container">

					 <?php $cnHeightContainer = SPDSGVOSettings::get('cn_height_container'); ?>
					<select name="cn_height_container"
					  <?= $disableCnStylingOptionTableInput ? 'disabled' : true;  ?>
					  id="cn_height_container">
						<option value="auto" <?= selected($cnHeightContainer == 'auto') ?>><?php _e('Default','shapepress-dsgvo')?></option>
						<option value="40px" <?= selected($cnHeightContainer == '40px') ?>>40px</option>
						<option value="45px" <?= selected($cnHeightContainer == '45px') ?>>45px</option>
						<option value="50px" <?= selected($cnHeightContainer == '50px') ?>>50px</option>
						<option value="55px" <?= selected($cnHeightContainer == '55px') ?>>55px</option>
						<option value="60px" <?= selected($cnHeightContainer == '60px') ?>>60px</option>
						<option value="65px" <?= selected($cnHeightContainer == '65px') ?>>65px</option>
						<option value="70px" <?= selected($cnHeightContainer == '70px') ?>>70px</option>
						<option value="75px" <?= selected($cnHeightContainer == '75px') ?>>75px</option>
						<option value="80px" <?= selected($cnHeightContainer == '80px') ?>>80px</option>
				</select>

			</label></td>
		</tr>
		<tr>
			<td><?php _e('Show icon:','shapepress-dsgvo')?></td>
			<td><label for="cn_show_dsgvo_icon"> <input
									name="cn_show_dsgvo_icon" type="checkbox"
									<?= $disableCnStylingOptionTableInput ? 'disabled' : true;  ?>
									id="cn_show_dsgvo_icon" value="1"
									<?= (SPDSGVOSettings::get('cn_show_dsgvo_icon') === '1')? ' checked ' : '';  ?>>
							</label></td>
		</tr>
		<tr>
			<td><?php _e('Use overlay','shapepress-dsgvo')?></td>
			<td><label for="cn_use_overlay"> <input
					name="cn_use_overlay" type="checkbox"
					<?= $disableCnStylingOptionTableInput ? 'disabled' : '';  ?>
					id="cn_use_overlay" value="1"
					<?= (SPDSGVOSettings::get('cn_use_overlay') === '1')? ' checked ' : '';  ?>>
			</label><span class="info-text"><?php _e('Displays a gray background and prevents the visitor from interacting with the site before making a choice.','shapepress-dsgvo')?></span></td>
		</tr>
		</tbody>
	</table>

	<hr class="sp-dsgvo">




	<br>
    <?php submit_button(); ?>
</form>
