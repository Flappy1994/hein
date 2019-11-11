<h1><?php _e('Privacy: Settings and 3rd party plugins','shapepress-dsgvo')?></h1>
<p><?php _e('All 3rd Party Plugins (Google Analytics, Facebook Pixel, ..) can be listed here to give their users a selective opt-in / opt-out.','shapepress-dsgvo')?></p>
<p><?php _e('With the shortcode <code>[display_services]</code> these services can then be displayed to the user.','shapepress-dsgvo')?></p>


<form method="post" action="<?= admin_url('/admin-ajax.php'); ?>">
	<input type="hidden" name="action" value="admin-services">

	<table class="form-table btn-settings-show" >
		<tbody>
			<tr>
				<th scope="row"><?php _e('Datenschutz Seite für ihre Benutzer','shapepress-dsgvo')?></th>
				<td>

						<ul>
							<li>
								<label for="user_permissions_page"><?php _e('Page','shapepress-dsgvo')?>
									<select name="user_permissions_page" id="user_permissions_page">
										<option value="0"><?php _e('Select','shapepress-dsgvo')?></option>

										<?php $userPermissionsPage = SPDSGVOSettings::get('user_permissions_page'); ?>
										<?php foreach(get_pages(array('number' => 0)) as $key => $page): ?>
											<option <?= selected($userPermissionsPage == $page->ID) ?> value="<?= $page->ID ?>">
												<?= $page->post_title ?>
											</option>
										<?php endforeach; ?>
									</select>
								</label>
								<span class="info-text"><?php _e('Specifies the page where users have the option to customize their privacy settings (selective opt-in / opt-out).','shapepress-dsgvo')?></span>
							</li>
						</ul>

						<?php if($userPermissionsPage == '0'): ?>
							<p>
							<?php _e('Create a page that uses the shortcode <code>[user_privacy_settings_form]</code>.','shapepress-dsgvo')?>
							<a class="button button-default"
								href="<?= SPDSGVOCreatePageAction::url(array('user_privacy_settings_page' => '1')) ?>"><?php _e('Create page','shapepress-dsgvo')?></a>
						   </p>

						<?php elseif($userPermissionsPage != '0' && strpos(get_post($userPermissionsPage)->post_content, 'user_privacy_settings_form') === FALSE): ?>
							<p><?php _e('Attention: The shortcode <code>[user_privacy_settings_form]</code> was not found on the selected page. The form will not be displayed.','shapepress-dsgvo')?> <a href="<?= get_edit_post_link($userPermissionsPage) ?>"><?php _e('Edit page','shapepress-dsgvo')?></a></p>
						<?php else: ?>
						<a href="<?= get_edit_post_link($userPermissionsPage) ?>"><?php _e('Edit page','shapepress-dsgvo')?></a> <br/>
						   <?php _e('The shortcode <code>[user_privacy_settings_form]</code> allows the user to activate or deactivate services on the selected page.','shapepress-dsgvo')?>

						<?php endif; ?>
				</td>
			</tr>
		</tbody>
	</table>
	<hr class="sp-dsgvo">



    <table class="widefat fixed" cellspacing="0">
	    <thead>
		    <tr>
				<th id="slug" class="manage-column column-slug" scope="col" style="width:12%"><?php _e('Slug','shapepress-dsgvo')?></th>
				<th id="name" class="manage-column column-name" scope="col"><?php _e('Name','shapepress-dsgvo')?></th>
				<th id="reason" class="manage-column column-reason" scope="col"><?php _e('Reason','shapepress-dsgvo')?></th>
				<th id="reason" class="manage-column column-link" scope="col"><?php _e('Terms Url','shapepress-dsgvo')?></th>
				<th id="default" class="manage-column column-default" scope="col" style="width:10%"><?php _e('Default','shapepress-dsgvo')?></th>
				<th id="image" class="manage-column column-image" scope="col" style="width:10%"><?php _e('Image','shapepress-dsgvo')?></th>
				<th id="delete" class="manage-column column-delete" scope="col" style="width:10%"><?php _e('Delete','shapepress-dsgvo')?></th>
		    </tr>
	    </thead>

	    <tbody>
			<?php $i = 0; // AB: This is justified ?>
	    	<?php foreach(SPDSGVOSettings::get('services') as $slug => $service): ?>

		        <tr class="<?= ($i % 2 == 0)? 'alternate' : '' ?>">
		            <td class="column-slug">
		            	<span><?= $slug ?></span>
		            	<input type="hidden" name="services[<?= $slug ?>][slug]" value="<?= $slug ?>">
		            </td>
		            <td class="column-name">
		            	<input type="text" class="aio-transparent" name="services[<?= $slug ?>][name]" value="<?= $service['name'] ?>">
		            </td>
		            <td class="column-reason">
		            	<textarea class="aio-transparent" name="services[<?= $slug ?>][reason]" id="" cols="30" rows="5"><?= $service['reason'] ?></textarea>
					</td>

		            <td class="column-link">
		            	<input type="text" class="aio-transparent" placeholder="<?php _e('Terms & Conditions link', 'shapepress-dsgvo'); ?>" name="services[<?= $slug ?>][link]" value="<?= $service['link'] ?>">
		            </td>
		            <td class="column-default">
						<select name="services[<?= $slug ?>][default]">
							<option <?= ($service['default'] == '1')? ' selected ' : '' ?> value="1"><?php _e('Enabled','shapepress-dsgvo')?></option>
							<option <?= ($service['default'] == '0')? ' selected ' : '' ?> value="0"><?php _e('Disabled','shapepress-dsgvo')?></option>
						</select>
					</td>
					<!-- i592995 -->
					<td class="column-image">
						<?php
						$src = '';
						$img_id = '';
						if(isset($service['image'])) {
							$img_id = $service['image'];
							$src = wp_get_attachment_url(intval($img_id));
						}
						?>

						<div class="dsgvo-image-upload">
							<div class='image-preview-wrapper'>
								<img id='<?= $slug ?>_image-preview' class="image-preview" src='<?php echo $src; ?>' style="width: 100%">
							</div>
							<input id="<?= $slug ?>_upload_image_button" type="button" class="button" value="<?php _e( 'Upload image', 'shapepress-dsgvo' ); ?>" />
							<input type='hidden' class="image-id" name='services[<?= $slug ?>][image]' id='<?= $slug ?>_image_id' value='<?php echo $img_id; ?>'>
						</div><!-- .dsgvo-image-upload -->
					</td>
					<!-- i592995 -->
		            <td class="column-reason">
		            	<a href="<?= SPDSGVODeleteServiceAction::url(['slug' => $slug]) ?>"><?php _e('Delete','shapepress-dsgvo')?></a>
					</td>
		        </tr>

				<?php $i++; ?>
	    	<?php endforeach; ?>
	    </tbody>

	    <tfoot>
		    <tr>
				<th class="manage-column column-slug" scope="col"><?php _e('Slug','shapepress-dsgvo')?></th>
				<th class="manage-column column-name" scope="col"><?php _e('Name','shapepress-dsgvo')?></th>
				<th class="manage-column column-reason" scope="col"><?php _e('Reason','shapepress-dsgvo')?></th>
				<th class="manage-column column-link" scope="col"><?php _e('Terms Url','shapepress-dsgvo')?></th>
				<th class="manage-column column-default" scope="col"><?php _e('Default','shapepress-dsgvo')?></th>
				<th class="manage-column column-delete" scope="col"><?php _e('Delete','shapepress-dsgvo')?></th>
		    </tr>
	    </tfoot>
	</table>

	<?php submit_button(); ?>
</form>


<form method="post" action="<?= admin_url('/admin-ajax.php'); ?>">
	<input type="hidden" name="action" value="admin-add-service">
	<br><br>

	<h3><?php _e('Add service','shapepress-dsgvo')?></h3>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row"><label for="new_name"><?php _e('Name','shapepress-dsgvo')?></label></th>
				<td>
					<input name="new_name" type="text" id="new_name" value="" class="regular-text ltr">
					<p class="description" ><?php _e('Service name','shapepress-dsgvo')?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="new_reason"><?php _e('Reason','shapepress-dsgvo')?></label></th>
				<td>
					<input name="new_reason" type="text" id="new_reason" value="" class="regular-text ltr">
					<p class="description"><?php _e('Reason for use','shapepress-dsgvo')?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="new_link"><?php _e('Terms Url','shapepress-dsgvo')?></label></th>
				<td>
					<input name="new_link" type="text" id="new_link" value="" class="regular-text ltr">
					<p class="description"><?php _e('The URL pointing to the terms of the service','shapepress-dsgvo')?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="new_default"><?php _e('Default','shapepress-dsgvo')?></label></th>
				<td>
					<select name="new_default">
						<option value="1"><?php _e('Enabled','shapepress-dsgvo')?></option>
						<option value="0"><?php _e('Disabled','shapepress-dsgvo')?></option>
					</select>
					<p class="description"><?php _e('Indicates whether the service should be enabled by default or not.','shapepress-dsgvo')?></p>
				</td>
			</tr>
			<!-- i592995 -->
			<tr>
				<th scope="row"><label for="new_image"><?php _e('Image','shapepress-dsgvo')?></label></th>
				<td>
					<div class="dsgvo-image-upload">
						<div class='image-preview-wrapper'>
							<img id='image-preview-new' class="image-preview" src='' style="width: 200px">
						</div>
						<input id="upload_image_button_new" type="button" class="button" value="<?php _e( 'Upload image', 'shapepress-dsgvo' ); ?>" />
						<input type='hidden' class="image-id" name='new_image' id='new_image' value=''>
					</div><!-- .dsgvo-image-upload -->
				</td>
			</tr>
			<!-- i592995 -->
		</tbody>
	</table>

	<?php submit_button(__('Add service','shapepress-dsgvo')); ?>
</form>
