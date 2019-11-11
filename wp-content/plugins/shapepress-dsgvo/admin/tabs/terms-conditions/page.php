<h1>Terms &amp; Conditions</h1>
<p>Use the shortcode <code>[terms_conditions]</code> to display the terms and conditions.</p>
<a href="#" class="button button-default btn-settings" data-state="closed"><span class="state">Show</span> Settings</a>


<form method="post" action="<?= admin_url('/admin-ajax.php'); ?>">
	<input type="hidden" name="action" value="terms-conditions">

	<table class="form-table btn-settings-show" style="display: none;">
		<tbody>
			<tr>
				<th scope="row">Terms &amp; Conditions page</th>
				<td>
					<fieldset>
						<legend class="screen-reader-text">
							<span>Terms &amp; Conditions page</span>
						</legend>
						
						<?php $termsConditionsPage = SPDSGVOSettings::get('terms_conditions_page'); ?>
						<label for="terms_conditions_page">Page:
							<select name="terms_conditions_page" id="terms_conditions_page">
								<option value="0">Select</option>
								<?php foreach(get_pages(array('number' => 0)) as $key => $page): ?>
									<option <?= selected($termsConditionsPage == $page->ID) ?> value="<?= $page->ID ?>">
										<?= $page->post_title ?>
									</option>
								<?php endforeach; ?>
							</select>
						</label>							

						<?php if($termsConditionsPage == '0'): ?>
							<p>Create a page that use <a class="button button-default" href="<?= SPDSGVOCreatePageAction::url(array('terms_conditions_page' => '1')) ?>">Create page</a></p>
						<?php elseif(!pageContainsString($termsConditionsPage, 'terms_conditions')): ?>
							<p>Warning: The shortcode <code>[terms_conditions]</code> was not detected on the page you have selected. <a href="<?= get_edit_post_link($termsConditionsPage) ?>">Edit Page</a></p>
						<?php else: ?>
							<a href="<?= get_edit_post_link($termsConditionsPage) ?>">Edit page</a>
						<?php endif; ?>
					</fieldset>
				</td>
			</tr>

			<tr>
				<th scope="row">Require users to give agree</th>
				<td>
					<fieldset>
						<legend class="screen-reader-text">
							<span>Require users to give agree</span>
						</legend>

						<p>
							<label for="force_explicit_permission_authenticated">
								<input name="force_explicit_permission_authenticated" type="checkbox" id="force_explicit_permission_authenticated" value="1" <?= checked(SPDSGVOSettings::get('force_explicit_permission_authenticated') === '1') ?>>
								Logged in users
							</label>
						</p>

						<p>
							<label for="force_explicit_permission_public">
								<input name="force_explicit_permission_public" type="checkbox" id="force_explicit_permission_public" value="1" <?= checked(SPDSGVOSettings::get('force_explicit_permission_public') === '1') ?>>
								Not logged in users
							</label>
							<p class="description">This will redirect users to your terms and conditions page, they will have to agree to your T&amp;C’s to access the site.</p>
						</p>


						<?php $explicitPermissionPage = SPDSGVOSettings::get('explicit_permission_page'); ?>
						<label for="explicit_permission_page">Page:
							<select name="explicit_permission_page" id="explicit_permission_page">
								<option value="0">Select</option>
								<?php foreach(get_pages(array('number' => 0)) as $key => $page): ?>
									<option <?= selected($explicitPermissionPage == $page->ID) ?> value="<?= $page->ID ?>">
										<?= $page->post_title ?>
									</option>
								<?php endforeach; ?>
							</select>
						</label>							

						<?php if($explicitPermissionPage == '0'): ?>
							<p>Create a page that uses the shortcode <code>[explicit_permission]</code> <a class="button button-default" href="<?= SPDSGVOCreatePageAction::url(array('explicit_permission_page' => '1')) ?>">Create page</a></p>
						<?php elseif(!pageContainsString($explicitPermissionPage, 'explicit_permission')): ?>
							<p>Warning: The shortcode <code>[explicit_permission]</code> was not detected on the page you have selected. <a href="<?= get_edit_post_link($explicitPermissionPage) ?>">Edit Page</a></p>
						<?php else: ?>
							<a href="<?= get_edit_post_link($explicitPermissionPage) ?>">Edit page</a>
						<?php endif; ?>
					</fieldset>
				</td>
			</tr>

			<tr>
				<th scope="row">Opt-out</th>
				<td>
					<fieldset>
						<legend class="screen-reader-text">
							<span>Opt-out</span>
						</legend>

						<?php $optOutPage = SPDSGVOSettings::get('opt_out_page'); ?>
						<label for="opt_out_page">Page:
							<select name="opt_out_page" id="opt_out_page">
								<option value="0">Select</option>
								<?php foreach(get_pages(array('number' => 0)) as $key => $page): ?>
									<option <?= selected($optOutPage == $page->ID) ?> value="<?= $page->ID ?>">
										<?= $page->post_title ?>
									</option>
								<?php endforeach; ?>
							</select>
						</label>							

						<?php if($optOutPage == '0'): ?>
							<p>Create a page that uses the shortcode <code>[decline_permission]</code> <a class="button button-default" href="<?= SPDSGVOCreatePageAction::url(array('opt_out_page' => '1')) ?>">Create page</a></p>
						<?php elseif(!pageContainsString($optOutPage, 'decline_permission')): ?>
							<p>Warning: The shortcode <code>[decline_permission]</code> was not detected on the page you have selected. <a href="<?= get_edit_post_link($optOutPage) ?>">Edit Page</a></p>
						<?php else: ?>
							<a href="<?= get_edit_post_link($optOutPage) ?>">Edit page</a>
						<?php endif; ?>
					</fieldset>
				</td>
			</tr>
		</tbody>
	</table>
	<hr class="sp-dsgvo">


	<br>
	<?php wp_editor(SPDSGVOSettings::get('terms_conditions'), 'terms_conditions', array('textarea_rows'=> '20')); ?>    
    <?php submit_button(); ?>
</form>

