<?php
/* i592995 */
/**
* Adds alternative version of privacy settings shortcode (visual changes)
*/
function SPDSGVOUserPrivacySettingsFormShortcodeAlt($atts)
{
    $atts = shortcode_atts(array(
    ), $atts);

    ob_start();
    global $post;
    ?>

<form method="post" class="privacy-settings-form" action="<?= admin_url('/admin-ajax.php'); ?>"
	class="sp-dsgvo-framework">
	<input type="hidden" name="action" value="user-permissions">
	<div class="container container-no-padding">

		<?php foreach(SPDSGVOSettings::get('services') as $slug => $service): ?>
    		<div class="row">
                <div class="column column-25"></div>
                <div class="column column-75">
                    <h5><?= $service['name'] ?></h5>
                </div>
                <div class="column column-25">
                    <?php if(isset($service['image'])) : ?>
                        <img src="<?php echo wp_get_attachment_url(intval($service['image'])); ?>" />
                    <?php endif; ?>
                </div>
                <div class="column column-75">
                    <?php
                    if($service['link'] == get_home_url()) {
                        $page_id = (int) get_option( 'page_on_front' );
                    } else {
                        $page_id = url_to_postid($service['link']);
                    }
                    ?>
                    <p>
                        <?= $service['reason'] ?>
                        <?php if ($service['name'] !== 'Cookies'):?>
                            <?php if($page_id == 0) : ?>
                                (<a href="<?= @$service['link'] ?>" target="_blank"><?php _e('Terms','shapepress-dsgvo')?></a>)
                            <?php else: ?>
                                (<a href="#" class="dsgvo-terms-toggle" data-id="<?php echo $page_id; ?>"><?php _e('Terms','shapepress-dsgvo')?></a>)
                                <?php
                                $page = get_post($page_id);
                                $temp = $post;
                                $post = $page;
                                setup_postdata($post);
                                ?>
                                <div class="dsgvo-terms-content" id="terms_content_<?php echo $page_id; ?>">
                                    <?php the_content(); ?>
                                </div><!-- .dsgvo-terms-content -->
                                <?php
                                $post = $temp;
                                setup_postdata($post);
                                ?>
                            <?php endif; ?>
                          <?php endif; ?>
                    </p>
                    <select name="<?= $slug ?>">
    					<option
    						<?= (hasUserGivenPermissionFor($service['slug']))? ' selected ' : '' ?>
    						value="1"><?php _e('Yes','shapepress-dsgvo')?></option>
    					<option
    						<?= (hasUserGivenPermissionFor($service['slug']))? '' : ' selected ' ?>
    						value="0"><?php _e('No','shapepress-dsgvo')?></option>
    				</select>
                </div>
    		</div>
    		<hr />
		<?php endforeach; ?>
	</div>

			<?php if(!is_user_logged_in()): ?>
				<p>
		<small><?php _e('Since you are not logged in we save these settings in a cookie. These settings are thus only active on this PC.','shapepress-dsgvo')?></small>
	</p>
			<?php endif; ?>

</form>

<?php
    return ob_get_clean();
}

add_shortcode('user_privacy_settings_form_alt', 'SPDSGVOUserPrivacySettingsFormShortcodeAlt');
/* i592995 */
