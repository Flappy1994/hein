<?php

function SPDSGVOUserPrivacySettingsFormShortcode($atts)
{
    $atts = shortcode_atts(array(
    ), $atts);
    
    ob_start();
    ?>

<form method="post" action="<?= admin_url('/admin-ajax.php'); ?>"
	class="sp-dsgvo-framework">
	<input type="hidden" name="action" value="user-permissions">
	<div class="container container-no-padding">
		<div class="row">
			<div class="column strong"><?php _e('Service','shapepress-dsgvo')?></div>
			<div class="column column-50 strong"><?php _e('Reason for use','shapepress-dsgvo')?></div>
			<div class="column strong"><?php _e('Terms','shapepress-dsgvo')?></div>
			<div class="column strong"><?php _e('Enabled','shapepress-dsgvo')?></div>
		</div>
		<hr />
		<?php foreach(SPDSGVOSettings::get('services') as $slug => $service): ?>
    		<div class="row">
    			<div class="column"><?= $service['name'] ?></div>
    			<div class="column column-50"><?= $service['reason'] ?></div>
    			<div class="column">
    				<?php if ($service['name'] !== 'Cookies'):?>
    				<a href="<?= @$service['link'] ?>" target="_blank"><?php _e('Terms','shapepress-dsgvo')?></a>
    				<?php endif;?>
    			</div>
    			<div class="column"><select name="services[<?= $slug ?>]">
							<option
								<?= (hasUserGivenPermissionFor($service['slug']))? ' selected ' : '' ?>
								value="1"><?php _e('Yes','shapepress-dsgvo')?></option>
							<option
								<?= (hasUserGivenPermissionFor($service['slug']))? '' : ' selected ' ?>
								value="0"><?php _e('No','shapepress-dsgvo')?></option>
					</select></div>
    		</div>
    		<hr />
		<?php endforeach; ?>
	</div>
	
			<?php if(!is_user_logged_in()): ?>
				<p>
		<small><?php _e('Since you are not logged in we save these settings in a cookie. These settings are thus only active on this PC.','shapepress-dsgvo')?></small>
	</p>
			<?php endif; ?>

			<input type="submit" value="<?php _e('Save','shapepress-dsgvo')?>">
</form>

<?php
    return ob_get_clean();
}

add_shortcode('user_privacy_settings_form', 'SPDSGVOUserPrivacySettingsFormShortcode');
