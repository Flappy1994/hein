<h1><?php _e('Delete Requests','shapepress-dsgvo')?></h1>
<p><?php _e('Here you will find all deletion requests that users have made on their site. With a click on "delete now " you delete all stored data of the user on their side including Plugins.','shapepress-dsgvo')?>
</p>

<form method="post" action="<?= admin_url('/admin-ajax.php'); ?>">
	<input type="hidden" name="action"
		value="<?= SPDSGVOSuperUnsubscribeAction::getActionName(); ?>"> <input
		type="hidden" name="CSRF" value="<?= sp_dsgvo_CSRF_TOKEN() ?>">
<?php $disablePremiumFeatures =  isValidPremiumEdition() == false; ?>

	<table class="form-table">
		<tbody>
            <tr>
            <th scope="row"><?php _e('Automatic processing','shapepress-dsgvo')?></th>
            <td></td>
            </tr>
			<tr>
				<td><?php _e('Immediately on request','shapepress-dsgvo')?></td>
				<td><label for="unsubscribe_auto_delete"> <input
						name="unsubscribe_auto_delete" type="checkbox"
						id="unsubscribe_auto_delete" value="1"
						<?= (SPDSGVOSettings::get('unsubscribe_auto_delete') === '1')? ' checked ' : '';  ?>>
				</label>
					<span class="info-text"><?php _e('If enabled, delete requests are performed immediately.','shapepress-dsgvo')?></span></td>
			</tr>
			<tr>
                <td><?php _e('Email for new application:','shapepress-dsgvo')?></td>
                <td>
                	<input
					name="su_email_notification" type="checkbox"
					id="su_email_notification" value="1"
					<?= $disablePremiumFeatures ? 'disabled' : true;  ?>
					<?= (SPDSGVOSettings::get('su_email_notification') === '1')? ' checked ' : '';  ?>>
                	<span class="info-text"><?php _e('Send a notification for a new application to the admin email address.','shapepress-dsgvo')?></span>
                </td>
            </tr>
            <tr>
                <td><?php _e('GDPR confirmation text:','shapepress-dsgvo')?></td>
                <td>
                	<input
					name="su_dsgvo_accepted_text" type="text"  style="width: 550px;"
					id="su_dsgvo_accepted_text" 	value="<?= SPDSGVOSettings::get('su_dsgvo_accepted_text');  ?>">
                	<span class="info-text"><?php _e('The text to be displayed in the GDPR checkbox for data deletion.','shapepress-dsgvo')?></span>
                </td>
            </tr>
			<tr>
				<td><?php _e('After period','shapepress-dsgvo')?></td>
				<td>
				<?php $suAutoDelTime = SPDSGVOSettings::get('su_auto_del_time'); ?>
    			<label for="su_auto_del_time"> <select name="su_auto_del_time"
    					id="su_auto_del_time">
    						<option value="0" <?= selected($suAutoDelTime === '0') ?>><?php _e('none','shapepress-dsgvo')?></option>
    						<option value="1m" <?= selected($suAutoDelTime === '1m') ?>>1 <?php _e('month','shapepress-dsgvo')?></option>
    						<option value="3m" <?= selected($suAutoDelTime === '3m') ?>>3 <?php _e('months','shapepress-dsgvo')?></option>
    						<option value="6m" <?= selected($suAutoDelTime === '6m') ?>>6 <?php _e('months','shapepress-dsgvo')?></option>
    						<option value="1y" <?= selected($suAutoDelTime === '1y') ?>>1 <?php _e('year','shapepress-dsgvo')?></option>
    						<option value="6y" <?= selected($suAutoDelTime === '6y') ?>>6 <?php _e('years','shapepress-dsgvo')?></option>
    						<option value="7y" <?= selected($suAutoDelTime === '7y') ?>>7 <?php _e('years','shapepress-dsgvo')?></option>
    				</select>
    			</label>
					<span class="info-text"><?php _e('Data is automatically deleted after the set time. Ensures the maximum retention time.','shapepress-dsgvo')?></span></td>
			</tr>

			<?php if (isValidPremiumEdition()) :  ?>
            <tr>
				<td><?php _e('WooCommerce Data','shapepress-dsgvo')?></td>
				<td>
				<?php $wooDataAction = SPDSGVOSettings::get('su_woo_data_action'); ?>
    			<label for="su_woo_data_action"> <select name="su_woo_data_action"
    					id="su_woo_data_action">
    						<option value="ignore" <?= selected($wooDataAction === 'ignore') ?>><?php _e('No action','shapepress-dsgvo')?></option>
    						<option value="pseudo" <?= selected($wooDataAction === 'pseudo') ?>><?php _e('Pseudonymise','shapepress-dsgvo')?></option>
    						<option value="del" <?= selected($wooDataAction === 'del') ?>><?php _e('Delete','shapepress-dsgvo')?></option>
    				</select>
    			</label>
					<span class="info-text"><?php _e('Specifies what should happen to personal data of orders.','shapepress-dsgvo')?></span></td>
			</tr>
			<tr>
				<td><?php _e('bbPress Data','shapepress-dsgvo')?></td>
				<td>
				<?php $bbPDataAction = SPDSGVOSettings::get('su_bbpress_data_action'); ?>
    			<label for="su_bbpress_data_action"> <select name="su_bbpress_data_action"
    					id="su_bbpress_data_action">
    						<option value="ignore" <?= selected($bbPDataAction === 'ignore') ?>><?php _e('No action','shapepress-dsgvo')?></option>
    						<option value="pseudo" <?= selected($wooDataAction === 'pseudo') ?>><?php _e('Pseudonymise','shapepress-dsgvo')?></option>
    						<option value="del" <?= selected($bbPDataAction === 'del') ?>><?php _e('Delete','shapepress-dsgvo')?></option>
    				</select>
    			</label>
					<span class="info-text"><?php _e('Specifies what should happen with forum entries.','shapepress-dsgvo')?></span></td>
			</tr>
			<tr>
				<td><?php _e('buddyPress Data','shapepress-dsgvo')?></td>
				<td>
				<?php $buddyPressDataAction = SPDSGVOSettings::get('su_buddypress_data_action'); ?>
    			<label for="su_buddypress_data_action"> <select name="su_buddypress_data_action"
    					id="su_buddypress_data_action">
    						<option value="ignore" <?= selected($buddyPressDataAction === 'ignore') ?>><?php _e('No action','shapepress-dsgvo')?></option>
    						<option value="pseudo" <?= selected($buddyPressDataAction === 'pseudo') ?>><?php _e('Pseudonymise','shapepress-dsgvo')?></option>
    						<option value="del" <?= selected($buddyPressDataAction === 'del') ?>><?php _e('Delete','shapepress-dsgvo')?></option>
    				</select>
    			</label>
					<span class="info-text"><?php _e('Specifies what should happen with PNs and extended profile fields.','shapepress-dsgvo')?></span></td>
			</tr>
			<tr>
				<td><?php _e('CF7/Flamingo Data','shapepress-dsgvo')?></td>
				<td>
				<?php $cf7DataAction = SPDSGVOSettings::get('su_cf7_data_action'); ?>
    			<label for="su_cf7_data_action"> <select name="su_cf7_data_action"
    					id="su_cf7_data_action">
    						<option value="ignore" <?= selected($cf7DataAction === 'ignore') ?>><?php _e('No action','shapepress-dsgvo')?></option>
    						<option value="pseudo" <?= selected($cf7DataAction === 'pseudo') ?>><?php _e('Pseudonymise','shapepress-dsgvo')?></option>
    						<option value="del" <?= selected($cf7DataAction === 'del') ?>><?php _e('Delete','shapepress-dsgvo')?></option>
    				</select>
    			</label>
					<span class="info-text"><?php _e('Specifies what to do with contact entries and messages.','shapepress-dsgvo')?></span></td>
			</tr>
			<?php endif;?>

			<tr>
				<th scope="row"><?php _e('Page for deletion request:','shapepress-dsgvo')?></th>
				<td>

						<?php $unsubscribePage = SPDSGVOSettings::get('super_unsubscribe_page'); ?>
						<label for="super_unsubscribe_page"><select
							name="super_unsubscribe_page" id="super_unsubscribe_page">
								<option value="0"><?php _e('Select','shapepress-dsgvo')?></option>
								<?php foreach(get_pages(array('number' => 0)) as $key => $page): ?>
									<option <?= selected($unsubscribePage == $page->ID) ?>
									value="<?= $page->ID ?>">
										<?= $page->post_title ?>
									</option>
								<?php endforeach; ?>
							</select>
						</label>

						<?php if($unsubscribePage == '0'): ?>
							<p>
							<?php _e('Create a page using the shortcode <code>[unsubscribe_form]</code>.','shapepress-dsgvo')?>
							<a class="button button-default"
								href="<?= SPDSGVOCreatePageAction::url(array('super_unsubscribe_page' => '1')) ?>"><?php _e('Create page','shapepress-dsgvo')?></a>
						</p>
						<?php elseif(!pageContainsString($unsubscribePage, 'unsubscribe_form')): ?>
							<p>
							<?php _e('Attention: The shortcode <code>[unsubscribe_form]</code> that should be on the selected page was not found. Thus, the user has no opportunity to ask a deletion request.','shapepress-dsgvo')?> <a
								href="<?= get_edit_post_link($unsubscribePage) ?>"><?php _e('Edit page','shapepress-dsgvo')?></a>
						</p>
						<?php else: ?>
							<a href="<?= get_edit_post_link($unsubscribePage) ?>"><?php _e('Edit page','shapepress-dsgvo')?></a>
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

<?php
$statuses = array(
    'pending',
    'done'
);
if (isset($_GET['status']) && in_array($_GET['status'], $statuses)) {
    $status = $_GET['status'];
} else {
    $status = 'pending';
}
?>

<ul class="subsubsub">
		<li>
			<a
		href="<?= SPDSGVO::adminURL(array('tab' => 'super-unsubscribe', 'status' => 'pending')) ?>"
		class="<?= ($status === 'pending')? 'current' : '';  ?>" aria-current="page">
				<?php _e('Pending','shapepress-dsgvo')?>
			</a>
	</li>
	<li>
			<a
		href="<?= SPDSGVO::adminURL(array('tab' => 'super-unsubscribe', 'status' => 'done')) ?>"
		class="<?= ($status === 'done')? 'current' : '';  ?>" aria-current="page">
				<?php _e('Done','shapepress-dsgvo')?>
			</a>
	</li>
</ul>
<br>
<br>

<?php $confirmed = SPDSGVOUnsubscriber::finder('status', array('status' => $status)); ?>
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
			<th id="status" class="manage-column column-status" scope="col"
				style="width: 15%"><?php _e('State','shapepress-dsgvo')?></th>
			<th id="process" class="manage-column column-process" scope="col"
				style="width: 15%"><?php _e('Delete now','shapepress-dsgvo')?></th>
			<!-- .i592995 -->
			<th id="dismiss" class="manage-column column-dismiss" scope="col"
				style="width: 15%"><?php _e('Dismiss','shapepress-dsgvo')?></th>
			<!-- .i592995 -->
		</tr>
	</thead>

	<tbody>
		<?php if(count($confirmed) !== 0): ?>
			<?php foreach($confirmed as $key => $confirmedRequest): ?>

				<tr class="<?= ($key % 2 == 0)? 'alternate' : '' ?>">
			<td class="column-request-id">
						<?= $confirmedRequest->ID ?>
					</td>
			<td class="column-email"><strong><?= $confirmedRequest->email ?></strong>
			</td>
			<td class="column-integrations">
						<?= $confirmedRequest->first_name ?>
					</td>
			<td class="column-auto-deleting-on">
						<?= $confirmedRequest->last_name ?>
					</td>
			<td class="column-auto-deleting-on">
						<?= $confirmedRequest->dsgvo_accepted === '1' ? 'Ja' : 'Nein' ?>
			</td>
			<td class="column-auto-deleting-on">
						<?= ucfirst($confirmedRequest->status) ?>
					</td>
			<td class="column-unsubscribe-user">

						<?php if($status == 'done'): ?>
							<a class="button-primary disabled" href="#"><?php _e('Delete now','shapepress-dsgvo')?></a>
						<?php else: ?>
							<a class="button-primary"
				href="<?= SPDSGVOSuperUnsubscribeAction::url(array('process' => $confirmedRequest->ID)) ?>"><?php _e('Delete now','shapepress-dsgvo')?></a>
						<?php endif; ?>
					</td>
			<!-- .i592995 -->
			<td class="column-dismiss">
				<svg class="unsubscribe-dismiss" width="10" height="10" data-id="<?php echo $confirmedRequest->ID; ?>">
					<line x1="0" y1="0" x2="10" y2="10" />
					<line x1="0" y1="10" x2="10" y2="0" />
				</svg>
			</td>
			<!-- .i592995 -->
		</tr>

			<?php endforeach; ?>
		<?php else: ?>
			<tr>
			<td class="column-slug" colspan="2">
					<?php if($status == 'done'): ?>
						<h4><?php _e('No requests done','shapepress-dsgvo')?></h4>
					<?php else: ?>
						<h4><?php _e('No pending requests','shapepress-dsgvo')?></h4>
					<?php endif; ?>
				</td>
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
			<th class="manage-column column-status" scope="col"><?php _e('State','shapepress-dsgvo')?></th>
			<th class="manage-column column-process" scope="col"><?php _e('Delete now','shapepress-dsgvo')?></th>
			<!-- .i592995 -->
			<th class="manage-column column-dismiss" scope="col"><?php _e('Dismiss','shapepress-dsgvo')?></th>
			<!-- .i592995 -->
		</tr>
	</tfoot>
</table>

<?php if(isset($pending) && count($pending) !== 0): ?>
<p>
	<a class="button-primary"
		href="<?= SPDSGVOSuperUnsubscribeAction::url(array('all' => '1')) ?>"><?php _e('Delete all','shapepress-dsgvo')?></a>
</p>
<?php endif; ?>


<br>
<form method="post" action="<?= admin_url('/admin-ajax.php'); ?>">
	<input type="hidden" name="action"
		value="<?= SPDSGVOSuperUnsubscribeFormAction::getActionName(); ?>"> <input
		type="hidden" name="is_admin" value="1"> <br>
	<br>

	<h3><?php _e('Add entry','shapepress-dsgvo')?></h3>
	<span style="color:red"><?php _e('ATTENTION: Executing this action deletes the account (except administrators).','shapepress-dsgvo')?></span>
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
				<th scope="row"><label for="process_now"><?php _e('Run without user confirmation','shapepress-dsgvo')?></label></th>
				<td><input name="process_now" type="checkbox" id="process_now"
					value="1"></td>
			</tr>
		</tbody>
	</table>

	<?php submit_button(__('Add','shapepress-dsgvo')); ?>
</form>
