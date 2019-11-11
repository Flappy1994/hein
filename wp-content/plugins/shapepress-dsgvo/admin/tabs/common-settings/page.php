<form method="post" action="<?= admin_url('/admin-ajax.php'); ?>">
	<input type="hidden" name="action" value="admin-common-settings-activate">

	<h1><?php _e('Activate Blog/Premium','shapepress-dsgvo')?></h1>

	<table class="form-table">
	<tr>
			<th scope="row"><?php _e('License','shapepress-dsgvo')?></th>
			<td><label for="dsgvo_licence"> <input name="dsgvo_licence"
									type="text" id="dsgvo_licence" style="width: 200px"
									value="<?= SPDSGVOSettings::get('dsgvo_licence');  ?>">
							</label>
							<?php if(SPDSGVOSettings::get('license_activated') === '1'): ?>
							<span class="info-text">
							<?php if(isPremiumEdition()): ?>
							<?= isValidPremiumEdition() ? _e('Premium version has been activated','shapepress-dsgvo') : _e('Invalid or expired license.','shapepress-dsgvo');  ?>
							<?php endif; ?>
							<?php if(isBlogEdition()): ?>
							<?= isValidBlogEdition() ? _e('Blog version has been activated','shapepress-dsgvo') : _e('Invalid license.','shapepress-dsgvo');  ?>
							<?php endif; ?>
							</span>
								<?php if(isPremiumEdition() && SPDSGVOSettings::get('licence_details_fetched') === '1'): ?>
								<span class="info-text"><?php _e('Activated on:','shapepress-dsgvo'); ?> <?= date("d.m.Y", strtotime(SPDSGVOSettings::get('licence_activated_on'))); ?>
								<?php _e('Valid to:','shapepress-dsgvo');  ?> <?= date("d.m.Y", strtotime(SPDSGVOSettings::get('licence_valid_to'))); ?></span>
								<?php endif; ?>
							<?php submit_button(__('Deactivate license','shapepress-dsgvo')); ?>
							<?php else: ?>
							<span class="info-text"><?php _e('Activating the license unlocks more features.','shapepress-dsgvo'); ?></span>
							<?php submit_button(__('Activate license','shapepress-dsgvo')); ?>
							<?php endif; ?>
							</td>
		</tr>
     </table>
</form>

<form method="post" action="<?= admin_url('/admin-ajax.php'); ?>">
	<input type="hidden" name="action" value="admin-common-settings">

<input type="hidden" value="<?= SPDSGVOSettings::get('dsgvo_licence'); ?>" id="dsgvo_licence_hidden" name="dsgvo_licence_hidden" />

	<h1><?php _e('Common Settings','shapepress-dsgvo')?></h1>

	<table class="form-table">
		<tr>
			<th scope="row"><?php _e('Admin Email','shapepress-dsgvo')?></th>
			<td><label for="admin_email"> <input name="admin_email"
									type="text" id="admin_email" style="width: 300px"
									value="<?= SPDSGVOSettings::get('admin_email');  ?>">
							</label><span class="info-text"><?php _e('Used by sending emails.','shapepress-dsgvo')?></span></td>
		</tr>
	   <tr>
			<th scope="row"><?php _e('Use WPML Strings','shapepress-dsgvo')?></th>
			<td><label for="use_wpml_strings"> <input
					name="use_wpml_strings" type="checkbox"
					id="use_wpml_strings" value="1"
					<?= (SPDSGVOSettings::get('use_wpml_strings') === '1')? ' checked ' : '';  ?>>
							</label><span class="info-text"><?php _e('Use WPML String Translation for text inputs. (E.g. Checkbox for comments.)','shapepress-dsgvo')?></span></td>
		</tr>
	 </table>

   		<?php if (isLicenceValid()) :  ?>
		 <h2><?php _e('Comments','shapepress-dsgvo')?></h2>
		<?php else :  ?>
		 <h2><?php _e('Comments','shapepress-dsgvo')?></h2><span style="color: orange"><?php _e('Customizing possible with Blog/Premium edition.','shapepress-dsgvo')?></span>
		<small><a href="https://www.wp-dsgvo.eu/shop"><?php _e('Click here to get a license.','shapepress-dsgvo')?></a></small>
		<?php endif;  ?>
	   <?php $disableCommentInputs = isLicenceValid() == false; ?>
	   <table class="form-table">
		<tr>
			<th scope="row"><?php _e('Checkbox for comments:','shapepress-dsgvo')?></th>
			<td><label for="sp_dsgvo_comments_checkbox"> <input
					name="sp_dsgvo_comments_checkbox" type="checkbox"
					id="sp_dsgvo_comments_checkbox" value="1"
					<?= (SPDSGVOSettings::get('sp_dsgvo_comments_checkbox') === '1')? ' checked ' : '';  ?>>
			</label><span class="info-text"><?php _e('Displays at checkbox which requires confirmation when creating a comment.','shapepress-dsgvo')?></span></td>
		</tr>
		<?php if (class_exists('WPCF7_ContactForm')) :  ?>
		<tr>

			<td><?php _e('Replace CF7 Acceptance text','shapepress-dsgvo')?></td>
			<td><label for="sp_dsgvo_cf7_acceptance_replace"> <input
					name="sp_dsgvo_cf7_acceptance_replace" type="checkbox"
					id="sp_dsgvo_cf7_acceptance_replace" value="1"
					<?php /* i592995 */ ?>
					<?= $disableCommentInputs ? 'disabled' : '';  ?>
					<?= (SPDSGVOSettings::get('sp_dsgvo_cf7_acceptance_replace') === '1')? ' checked ' : '';  ?>>
			</label><span class="info-text"><?php _e('Replaces the text of CF7 Acceptance Checkboxes with following text. (Add to your form: [acceptance dsgvo] Text[/acceptance])','shapepress-dsgvo')?></span></td>
		</tr>
		<?php endif;  ?>
		<tr>
		<th scope="row"><?php _e('Text','shapepress-dsgvo')?></th>
		<td><label for="spdsgvo_comments_checkbox_text"> <textarea name="spdsgvo_comments_checkbox_text"
					placeholder="<?php _e('Message text:','shapepress-dsgvo')?>" id="spdsgvo_comments_checkbox_text" rows="3"
					<?= $disableCommentInputs ? 'disabled' : '';  ?>
					style="width: 100%"><?= htmlentities(SPDSGVOSettings::get('spdsgvo_comments_checkbox_text')) ?></textarea>
			</label></td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Info text:','shapepress-dsgvo')?></th>
			<td><label for="spdsgvo_comments_checkbox_info"> <input
					name="spdsgvo_comments_checkbox_info" type="text" style="width: 500px"
					<?= $disableCommentInputs ? 'disabled' : '';  ?>
					id="spdsgvo_comments_checkbox_info" value="<?= htmlentities(SPDSGVOSettings::get('spdsgvo_comments_checkbox_info'));  ?>">
			</label></td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Confirmation text','shapepress-dsgvo')?></th>
			<td><label for="spdsgvo_comments_checkbox_confirm"> <input
					name="spdsgvo_comments_checkbox_confirm" type="text" style="width: 300px"
				    <?= $disableCommentInputs ? 'disabled' : '';  ?>
					id="spdsgvo_comments_checkbox_confirm" value="<?= htmlentities(SPDSGVOSettings::get('spdsgvo_comments_checkbox_confirm'));  ?>">
			</label></td>
		</tr>
     </table>

	<hr class="sp-dsgvo">

<h2><?php _e('Company data','shapepress-dsgvo')?></h2>
<p><?php _e('The following input fields represent the basic data necessary for the creation of GDPR compliant data protection regulations and an imprint.<br />All entries made here are automatically used in the privacy policy and imprint generated by the WP DSGVO Tools Plugin.','shapepress-dsgvo')?></p>

	<table class="form-table">
		<tr>
			<td><?php _e('Company name:','shapepress-dsgvo')?></td>
			<td><label for="spdsgvo_company_info_name"> <input name="spdsgvo_company_info_name"
									type="text" id="spdsgvo_company_info_name" style="width: 300px"
									value="<?= SPDSGVOSettings::get('spdsgvo_company_info_name');  ?>">
							</label><span class="info-text"></span></td>
		</tr>
		<tr>
			<td><?php _e('Street:','shapepress-dsgvo')?></td>
			<td><label for="spdsgvo_company_info_street"> <input name="spdsgvo_company_info_street"
									type="text" id="spdsgvo_company_info_street" style="width: 300px"
									value="<?= SPDSGVOSettings::get('spdsgvo_company_info_street');  ?>">
							</label><span class="info-text"></span></td>
		</tr>
		<tr>
			<td><?php _e('ZIP + Location:','shapepress-dsgvo')?></td>
			<td><label for="spdsgvo_company_info_loc_zip"> <input name="spdsgvo_company_info_loc_zip"
									type="text" id="spdsgvo_company_info_loc_zip" style="width: 300px"
									value="<?= SPDSGVOSettings::get('spdsgvo_company_info_loc_zip');  ?>">
							</label><span class="info-text"></span></td>
		</tr>
		<tr>
			<td><?php _e('Commercial book no.:','shapepress-dsgvo')?></td>
			<td><label for="spdsgvo_company_fn_nr"> <input name="spdsgvo_company_fn_nr"
									type="text" id="spdsgvo_company_fn_nr" style="width: 300px"
									value="<?= SPDSGVOSettings::get('spdsgvo_company_fn_nr');  ?>">
							</label><span class="info-text"></span></td>
		</tr>
		<tr>
			<td><?php _e('§11 Place of Jurisdiction:','shapepress-dsgvo')?></td>
			<td><label for="spdsgvo_company_law_loc"> <input name="spdsgvo_company_law_loc"
									type="text" id="spdsgvo_company_law_loc" style="width: 300px"
									value="<?= SPDSGVOSettings::get('spdsgvo_company_law_loc');  ?>">
							</label><span class="info-text"></span></td>
		</tr>
		<tr>
			<td><?php _e('VAT No.:','shapepress-dsgvo')?></td>
			<td><label for="spdsgvo_company_uid_nr"> <input name="spdsgvo_company_uid_nr"
									type="text" id="spdsgvo_company_uid_nr" style="width: 300px"
									value="<?= SPDSGVOSettings::get('spdsgvo_company_uid_nr');  ?>">
							</label><span class="info-text"></span></td>
		</tr>
		<tr>
			<td><?php _e('Legal representatives:','shapepress-dsgvo')?></td>
			<td><label for="spdsgvo_company_law_person"> <input name="spdsgvo_company_law_person"
									type="text" id="spdsgvo_company_law_person" style="width: 300px"
									value="<?= SPDSGVOSettings::get('spdsgvo_company_law_person');  ?>">
							</label><span class="info-text"><?php _e('The person who legally represents the company.','shapepress-dsgvo')?></span></td>
		</tr>
		<tr>
			<td><?php _e('Shareholder','shapepress-dsgvo')?></td>
			<td><label for="spdsgvo_company_chairmen"> <input name="spdsgvo_company_chairmen"
									type="text" id="spdsgvo_company_chairmen" style="width: 300px"
									value="<?= SPDSGVOSettings::get('spdsgvo_company_chairmen');  ?>">
							</label><span class="info-text"><?php _e('In case of companies please contact all shareholders here.','shapepress-dsgvo')?></span></td>
		</tr>
		<tr>
			<td><?php _e('Responsible for content:','shapepress-dsgvo')?></td>
			<td><label for="spdsgvo_company_resp_content"> <input name="spdsgvo_company_resp_content"
									type="text" id="spdsgvo_company_resp_content" style="width: 300px"
									value="<?= SPDSGVOSettings::get('spdsgvo_company_resp_content');  ?>">
							</label><span class="info-text"><?php _e('The person responsible for the content on this website.','shapepress-dsgvo')?></span></td>
		</tr>
		<tr>
			<td><?php _e('Phone:','shapepress-dsgvo')?></td>
			<td><label for="spdsgvo_company_info_phone"> <input name="spdsgvo_company_info_phone"
									type="text" id="spdsgvo_company_info_phone" style="width: 300px"
									value="<?= SPDSGVOSettings::get('spdsgvo_company_info_phone');  ?>">
							</label><span class="info-text"></span></td>
		</tr>
		<tr>
			<td><?php _e('Email:','shapepress-dsgvo')?></td>
			<td><label for="spdsgvo_company_info_email"> <input name="spdsgvo_company_info_email"
									type="text" id="spdsgvo_company_info_email" style="width: 300px"
									value="<?= SPDSGVOSettings::get('spdsgvo_company_info_email');  ?>">
							</label><span class="info-text"></span></td>
		</tr>
		<tr>
			<td><?php _e('Newsletter service:','shapepress-dsgvo')?></td>
			<td><label for="spdsgvo_newsletter_service"> <input name="spdsgvo_newsletter_service"
									type="text" id="spdsgvo_newsletter_service" style="width: 300px"
									value="<?= SPDSGVOSettings::get('spdsgvo_newsletter_service');  ?>">
							</label><span class="info-text"><?php _e('Name of the shipping service provider with which the newsletters will be sent.','shapepress-dsgvo')?></span></td>
		</tr>
		<tr>
			<td><?php _e('URL Privacy Police of Newsletter Service:','shapepress-dsgvo')?></td>
			<td><label for="spdsgvo_newsletter_service_privacy_policy_url"> <input name="spdsgvo_newsletter_service_privacy_policy_url"
									type="text" id="spdsgvo_newsletter_service_privacy_policy_url" style="width: 300px"
									value="<?= SPDSGVOSettings::get('spdsgvo_newsletter_service_privacy_policy_url');  ?>">
							</label><span class="info-text"><?php _e('The URL to the terms of the newsletter service.','shapepress-dsgvo')?></span></td>
		</tr>
   </table>


	<br>
    <?php submit_button(); ?>
</form>
