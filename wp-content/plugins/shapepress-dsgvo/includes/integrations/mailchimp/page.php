<form method="post" action="<?= SPDSGVOMailchimpIntegration::formURL() ?> ">
	<input type="hidden" name="action" value="<?= SPDSGVOMailchimpIntegration::action() ?>">

	<table class="form-table">
		<tbody>	
			<tr>
				<th scope="row"><label for="mailchimp_api_token"><?php _e('Mailchimp API Key','shapepress-dsgvo')?></label></th>
				<td>
					<input name="mailchimp_api_token" type="text" id="mailchimp_api_token" aria-describedby="admin-email-description" value="<?= get_option('mailchimp_api_token'); ?>" class="regular-text ltr">
					<p class="description" id="admin-email-description">
						<a href="https://kb.mailchimp.com/integrations/api-integrations/about-api-keys" target="_blank"><?php _e('Click here','shapepress-dsgvo')?> </a> 
						<?php _e('to get an API key','shapepress-dsgvo')?>
					</p>
				</td>
			</tr>
		</tbody>
	</table>

	<?php submit_button(); ?>
</form>