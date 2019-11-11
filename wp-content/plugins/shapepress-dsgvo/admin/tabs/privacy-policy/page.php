<h1><?php _e('Privacy policy','shapepress-dsgvo')?></h1>
<p>
	<?php _e('The shortcode <code>[privacy_policy]</code> generates a privacy page from the input made under General Settings.','shapepress-dsgvo')?>
</p>
<p><?php _e('Initially, this text is filled with a template. The text blocks in the square brackets ([]) are filled with the values ​​that you entered in the General Settings. You can customize the entire text to your requirements, as well as delete passages if they do not apply to them.','shapepress-dsgvo')?>
</p>

<form method="post" action="<?= admin_url('/admin-ajax.php'); ?>">
	<table class="form-table btn-settings-show">
		<tbody>
			<tr>
				<th scope="row"><?php _e('Privacy policy page','shapepress-dsgvo')?></th>
				<td>
						<?php $privacyPolicyPage = SPDSGVOSettings::get('privacy_policy_page'); ?>
						<label for="privacy_policy_page"><?php _e('Page', 'shapepress-dsgvo'); ?>:
							<select name="privacy_policy_page" id="privacy_policy_page">
								<option value="0"><?php _e('Select', 'shapepress-dsgvo'); ?></option>
								<?php foreach(get_pages(array('number' => 0)) as $key => $page): ?>
									<option <?= selected($privacyPolicyPage == $page->ID) ?> value="<?= $page->ID ?>">
										<?= $page->post_title ?>
									</option>
								<?php endforeach; ?>
							</select>
						</label>

						<?php if($privacyPolicyPage == '0'): ?>
							<p><?php _e('Create a page that uses the shortcode <code>[privacy_policy]</code>.','shapepress-dsgvo')?> <a class="button button-default" href="<?= SPDSGVOCreatePageAction::url(array('privacy_policy_page' => '1')) ?>"><?php _e('Create page','shapepress-dsgvo')?></a></p>
						<?php elseif(!pageContainsString($privacyPolicyPage, 'privacy_policy')): ?>
							<p><?php _e('Attention: The shortcode <code>[privacy_policy]</code> was not found on the page you selected.','shapepress-dsgvo')?> <a href="<?= get_edit_post_link($privacyPolicyPage) ?>"><?php _e('Edit page','shapepress-dsgvo')?></a></p>
						<?php else: ?>
							<a href="<?= get_edit_post_link($privacyPolicyPage) ?>"><?php _e('Edit page','shapepress-dsgvo')?></a>
						<?php endif; ?>
				</td>
			</tr>
			<?php if (isValidPremiumEdition()) :  ?>
			<tr>
    			<th scope="row"><?php _e('Show checkbox at WooCommerce checkout to confirm privacy policy','shapepress-dsgvo')?></th>
    			<td><label for="woo_show_privacy_checkbox"> <input
    					name="woo_show_privacy_checkbox" type="checkbox"
    					id="woo_show_privacy_checkbox" value="1"
    					<?= (SPDSGVOSettings::get('woo_show_privacy_checkbox') === '1')? ' checked ' : '';  ?>>
    			</label></td>
			</tr>

			<!-- i592995 -->			
			<tr>
				<?php
				$privacy_text = SPDSGVOSettings::get('woo_privacy_text', '');
				if($privacy_text == '') {
					$privacy_text = __('I have read and accepted the Privacy Policy.','shapepress-dsgvo');
				}
				?>
    			<th scope="row"><?php _e('WooCommerce privacy policy text','shapepress-dsgvo')?></th>
    			<td><label for="woo_privacy_text">
					<input type="text" name="woo_privacy_text" id="woo_privacy_text" class="woo-privacy-text" value="<?php echo $privacy_text; ?>" />
    			</label></td>
			</tr>
			<!-- i592995 -->
			<?php endif; ?>
		</tbody>
	</table>
	<hr class="sp-dsgvo">
		<br>
	<span class="info-text" style="margin-bottom: 20px;"><?php _e('Note: In order to be able to reset or reload the text (eg: after changing the language), highlight the text, delete it and click save. Thus, the text is reloaded.','shapepress-dsgvo')?></span>
	<div style="clear: both"></div>
	<br>

	<input type="hidden" name="action" value="privacy-policy">

	<br>
	<?php
    	$pageContent = SPDSGVOSettings::get('privacy_policy');
    	if ($pageContent == NULL || strlen($pageContent) < 10)
    	{
    	    $pageContent = file_get_contents(SPDSGVO::pluginDir('/templates/'.get_locale().'/privacy-policy.txt'));

    	    //$pageContent = mb_convert_encoding($pageContent, 'HTML-ENTITIES', "UTF-8");
    	}

    	wp_editor($pageContent, 'privacy_policy', array('textarea_rows'=> '20'));
	?>
    <?php submit_button(); ?>

</form>
