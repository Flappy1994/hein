<h1><?php _e('Subject Access Requests','shapepress-dsgvo')?></h1>
<p><?php _e('This feature allows users to request a digest of all data stored by you. <br> All data in your database is checked for confidential data and sent to the User by email.','shapepress-dsgvo')?>
</p>

<form method="post" action="<?= admin_url('/admin-ajax.php'); ?>">
	<input type="hidden" name="action"
		value="<?= SPDSGVOAdminSubjectAccessRequestAction::getActionName(); ?>">

<?php $disablePremiumFeatures =  isValidPremiumEdition() == false; ?>

	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row"><?php _e('Automatic processing','shapepress-dsgvo')?></th>
				<td>
				<?php $sarCron = SPDSGVOSettings::get('sar_cron'); ?>
    			<label for="sar_cron"> <select name="sar_cron"
    					id="sar_cron">
    						<option value="0" <?= selected($sarCron === '0') ?>><?php _e('none','shapepress-dsgvo')?></option>
    						<option value="1" <?= selected($sarCron === '1') ?>>1 <?php _e('day','shapepress-dsgvo')?></option>
    						<option value="2" <?= selected($sarCron === '2') ?>>2 <?php _e('days','shapepress-dsgvo')?></option>
    						<option value="3" <?= selected($sarCron === '3') ?>>3 <?php _e('days','shapepress-dsgvo')?></option>
    						<option value="7" <?= selected($sarCron === '4') ?>>1 <?php _e('weeks','shapepress-dsgvo')?></option>
    				</select>
    			</label>
					<span class="info-text"><?php _e('Requests will be automatically processed after the set time and sent to the user.','shapepress-dsgvo')?></span></td>
			</tr>

            <tr>
                <th scope="row"><?php _e('Email for new application:','shapepress-dsgvo')?></th>
                <td>
                	<input
					name="sar_email_notification" type="checkbox"
					id="sar_email_notification" value="1"
					<?= $disablePremiumFeatures ? 'disabled' : true;  ?>
					<?= (SPDSGVOSettings::get('sar_email_notification') === '1')? ' checked ' : '';  ?>>
                	<span class="info-text"><?php _e('Send a notification for a new application to the admin email address.','shapepress-dsgvo')?></span>
                </td>
            </tr>
            <tr>
                <td><?php _e('GDPR consent text:','shapepress-dsgvo')?></td>
                <td>
                	<input
					name="sar_dsgvo_accepted_text" type="text"  style="width: 550px;"
					id="sar_dsgvo_accepted_text" 	value="<?= SPDSGVOSettings::get('sar_dsgvo_accepted_text');  ?>">
                	<span class="info-text"><?php _e('The text to be displayed in the GDPR checkbox for data storage.','shapepress-dsgvo')?></span>
                </td>
            </tr>

			<tr>
				<th scope="row"><?php _e('Request page:','shapepress-dsgvo')?></th>
				<td>

						<?php $sarPage = SPDSGVOSettings::get('sar_page'); ?>
						<label for="sar_page"><select name="sar_page" id="sar_page">
								<option value="0"><?php _e('Select','shapepress-dsgvo')?></option>
								<?php foreach(get_pages(array('number' => 0)) as $key => $page): ?>
									<option <?= selected($sarPage == $page->ID) ?>
									value="<?= $page->ID ?>">
										<?= $page->post_title ?>
									</option>
								<?php endforeach; ?>
							</select>
						</label>
						<span class="info-text"><?php _e('Specifies the page on which users have the option to request their data extract.','shapepress-dsgvo')?></span>

						<?php if($sarPage == '0'): ?>
							<p>
							<?php _e('Create a page using the shortcode <code>[sar_form]</code>.','shapepress-dsgvo')?>
							<a class="button button-default"
								href="<?= SPDSGVOCreatePageAction::url(array('sar' => '1')) ?>"><?php _e('Create page','shapepress-dsgvo')?></a>
						</p>
						<?php elseif(!pageContainsString($sarPage, 'sar_form')): ?>
							<p>
							<?php _e('Attention: The shortcode <code>[sar_form]</code> of the selected page was not found. Thus, the user has no opportunity to request the data.','shapepress-dsgvo')?> <a
								href="<?= get_edit_post_link($sarPage) ?>"><?php _e('Edit page','shapepress-dsgvo')?></a>
						</p>
						<?php else: ?>
							<a href="<?= get_edit_post_link($sarPage) ?>"><?php _e('Edit page','shapepress-dsgvo')?></a>
						<?php endif; ?>
				</td>
			</tr>

			<tr>
				<th><?php submit_button(); ?></th>
				<td></td>
			</tr>
		</tbody>
	</table>

	<hr class="sp-dsgvo">
</form>


<?php $pending = SPDSGVOSubjectAccessRequest::finder('pending'); ?>
<table class="widefat fixed" cellspacing="0">
	<thead>
		<tr>
			<th id="request_id" class="manage-column column-request_id"
				scope="col" style="width: 10%"><?php _e('ID','shapepress-dsgvo')?></th>
			<th id="email" class="manage-column column-email" scope="col"
				style="width: 20%"><?php _e('Email','shapepress-dsgvo')?></th>
			<th id="first_name" class="manage-column column-first_name"
				scope="col" style="width: 15%"><?php _e('First name','shapepress-dsgvo')?></th>
			<th id="last_name" class="manage-column column-last_name" scope="col"
				style="width: 15%"><?php _e('Last name','shapepress-dsgvo')?></th>
			<th id="dsgvo_accepted" class="manage-column column-dsgvo_accepted" scope="col"
				style="width: 15%"><?php _e('GDPR approval','shapepress-dsgvo')?></th>
			<th id="process" class="manage-column column-process" scope="col"
				style="width: 15%"><?php _e('Run','shapepress-dsgvo')?></th>
			<!-- i592995 -->
			<th id="dismiss" class="manage-column column-dismiss" scope="col"
				style="width: 15%"><?php _e('Dismiss','shapepress-dsgvo')?></th>
			<!-- i592995 -->
		</tr>
	</thead>

	<tbody>
		<?php if(count($pending) !== 0): ?>
			<?php foreach($pending as $key => $pendingRequest): ?>

				<tr class="<?= ($key % 2 == 0)? 'alternate' : '' ?>">
			<td class="column-request-id">
						<?= $pendingRequest->ID ?>
					</td>
			<td class="column-email"><strong><?= $pendingRequest->email ?></strong>
			</td>
			<td class="column-integrations">
						<?= $pendingRequest->first_name ?>
					</td>
			<td class="column-auto-deleting-on">
						<?= $pendingRequest->last_name ?>
					</td>
			<td class="column-auto-deleting-on">
						<?= $pendingRequest->dsgvo_accepted === '1' ? 'Yes' : 'No' ?>
			</td>
			<td class="column-unsubscribe-user"><a class="button-primary"
				href="<?= SPDSGVOAdminSubjectAccessRequestAction::url(array('process' => $pendingRequest->ID)) ?>"><?php _e('Run', 'shapepress-dsgvo'); ?></a></td>
			<!-- i592995 -->
			<td class="column-dismiss">
				<svg class="unsubscribe-dismiss" width="10" height="10" data-id="<?php echo $pendingRequest->ID; ?>">
					<line x1="0" y1="0" x2="10" y2="10" />
					<line x1="0" y1="10" x2="10" y2="0" />
				</svg>
			</td>
			<!-- i592995 -->
		</tr>

			<?php endforeach; ?>
		<?php else: ?>
			<tr>
			<td class="column-slug" colspan="2"><?php _e('No open requests','shapepress-dsgvo')?></td>
			<td class="column-default"></td>
			<td class="column-reason"></td>
		</tr>
		<?php endif; ?>
	</tbody>

	<tfoot>
		<tr>
			<th class="manage-column column-request_id" scope="col"><?php _e('ID','shapepress-dsgvo')?></th>
			<th class="manage-column column-email" scope="col"><?php _e('Email','shapepress-dsgvo')?></th>
			<th class="manage-column column-first_name" scope="col"><?php _e('First name','shapepress-dsgvo')?></th>
			<th class="manage-column column-last_name" scope="col"><?php _e('Last name','shapepress-dsgvo')?></th>
			<th class="manage-column column-dsgvo_accepted" scope="col"><?php _e('GDPR approval','shapepress-dsgvo')?></th>
			<th class="manage-column column-process" scope="col"><?php _e('Run','shapepress-dsgvo')?></th>
			<!-- i592995 -->
			<th class="manage-column column-dismiss" scope="col"><?php _e('Dismiss','shapepress-dsgvo')?></th>
			<!-- i592995 -->
		</tr>
	</tfoot>
</table>

<?php if(count($pending) !== 0): ?>
<p>
	<a class="button-primary"
		href="<?= SPDSGVOAdminSubjectAccessRequestAction::url(array('all' => '1')) ?>"><?php _e('Run all','shapepress-dsgvo')?></a>
</p>
<?php endif; ?>



<form method="post" action="<?= admin_url('/admin-ajax.php'); ?>">
	<input type="hidden" name="action"
		value="<?= SPDSGVOSubjectAccessRequestAction::getActionName(); ?>"> <input
		type="hidden" name="is_admin" value="1"> <br>
	<br>

	<h3><?php _e('Add entry','shapepress-dsgvo')?></h3>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row"><label for="email"><?php _e('Email','shapepress-dsgvo')?> <span style="color: #F00">*</span></label></th>
				<td><input name="email" type="email" id="email" value=""
					class="regular-text ltr" required></td>
			</tr>
			<tr>
				<th scope="row"><label for="first_name"><?php _e('First name','shapepress-dsgvo')?></label></th>
				<td><input name="first_name" type="text" id="first_name" value=""
					class="regular-text ltr"></td>
			</tr>
			<tr>
				<th scope="row"><label for="last_name"><?php _e('Last name','shapepress-dsgvo')?></label></th>
				<td><input name="last_name" type="text" id="last_name" value=""
					class="regular-text ltr"></td>
			</tr>
			<tr>
				<th scope="row"><label for="dsgvo_checkbox"><?php _e('GDPR approval','shapepress-dsgvo')?></label></th>
				<td><input name="dsgvo_checkbox" type="checkbox" id="dsgvo_checkbox"
					value="1"></td>
			</tr>
			<tr>
				<th scope="row"><label for="process_now"><?php _e('Run now','shapepress-dsgvo')?></label></th>
				<td><input name="process_now" type="checkbox" id="process_now"
					value="1"></td>
			</tr>
			<tr style="display: none;">
				<th scope="row"><label for="display_email"><?php _e('Show email','shapepress-dsgvo')?></label></th>
				<td><input name="display_email" type="checkbox" id="display_email"
					value="1"></td>
			</tr>
		</tbody>
	</table>

	<?php submit_button(__('Add','shapepress-dsgvo')); ?>
</form>
