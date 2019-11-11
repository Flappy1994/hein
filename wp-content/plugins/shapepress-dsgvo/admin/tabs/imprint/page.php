<h1><?php _e('Imprint', 'shapepress-dsgvo'); ?></h1>
<p><?php _e('With the shortcode <code>[imprint]</code> an inprint automatically gets generated. The data will be taken from general settings.', 'shapepress-dsgvo'); ?></p>

<form method="post" action="<?= admin_url('/admin-ajax.php'); ?>">
	<input type="hidden" name="action" value="imprint">

	<table class="form-table btn-settings-show">
		<tbody>
			<tr>
				<th scope="row"><?php _e('Imprint Page','shapepress-dsgvo')?></th>
				<td>

						<?php $imprintPage = SPDSGVOSettings::get('imprint_page'); ?>
						<label for="imprint_page"><?php _e('Page', 'shapepress-dsgvo'); ?>:
							<select name="imprint_page" id="imprint_page">
								<option value="0"><?php _e('Select','shapepress-dsgvo')?></option>
								<?php foreach(get_pages(array('number' => 0)) as $key => $page): ?>
									<option <?= selected($imprintPage == $page->ID) ?> value="<?= $page->ID ?>">
										<?= $page->post_title ?>
									</option>
								<?php endforeach; ?>
							</select>
						</label>

						<?php if($imprintPage == '0'): ?>
							<p><?php _e('Create a page that uses the shortcode <code>[imprint]</code>.','shapepress-dsgvo')?><a class="button button-default" href="<?= SPDSGVOCreatePageAction::url(array('imprint_page' => '1')) ?>"><?php _e('Create page','shapepress-dsgvo')?></a></p>
						<?php elseif(!pageContainsString($imprintPage, 'imprint')): ?>
							<p><?php _e('Attention: The shortcode <code>[imprint]</code> was not found on the page you selected.','shapepress-dsgvo')?> <a href="<?= get_edit_post_link($imprintPage) ?>"><?php _e('Edit page','shapepress-dsgvo')?></a></p>
						<?php else: ?>
							<a href="<?= get_edit_post_link($imprintPage) ?>"><?php _e('Edit page','shapepress-dsgvo')?></a>
						<?php endif; ?>
				</td>
			</tr>


		</tbody>
	</table>
	<hr class="sp-dsgvo">
		<br>
	<span class="info-text" style="margin-bottom: 20px;"><?php _e('Note: In order to be able to reset or reload the text (eg: after changing the language), highlight the text, delete it and click save. Thus, the text is reloaded.','shapepress-dsgvo')?></span>
	<div style="clear: both"></div>
	<br>
	<?php
	$imprintContent = SPDSGVOSettings::get('imprint');
	if ($imprintContent == NULL || strlen($imprintContent) < 10)
	{
	    $imprintContent = file_get_contents(SPDSGVO::pluginDir('/templates/'.get_locale().'/imprint.txt'));


	}
	wp_editor($imprintContent, 'imprint', array('textarea_rows'=> '20'));

	?>
    <?php submit_button(); ?>
</form>
