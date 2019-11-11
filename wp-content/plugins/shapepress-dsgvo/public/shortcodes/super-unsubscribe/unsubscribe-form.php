<?php

function SPDSGVOUnsubscribeShortcode($atts){

    $firstName = '';
    $lastName  = '';
    $email     = '';

    if(is_user_logged_in()){
        $firstName = wp_get_current_user()->user_firstname;
        $lastName  = wp_get_current_user()->user_lastname;
        $email     = wp_get_current_user()->user_email;
    }      

    ob_start();
    ?>  
        <?php if(isset($_REQUEST['result']) && $_REQUEST['result'] === 'success'): ?>

            <p><?php _e('Request sent successfully. You will receive an email in a few minutes.','shapepress-dsgvo')?></p>

        <?php elseif(isset($_REQUEST['result']) && $_REQUEST['result'] === 'confirmed'): ?>

			<p><?php _e('Request successfully completed. Your data has been completely deleted.','shapepress-dsgvo')?></p>

        <?php else: ?>
            <form method="post" action="<?= SPDSGVOSuperUnsubscribeFormAction::url() ?>" class="sp-dsgvo-framework">
                <fieldset>
                    <div class="row">
                        <div class="column">
                            <label for="email-field"><?php _e('First name','shapepress-dsgvo')?></label>
                            <input required type="text" id="first-name-field" name="first_name" value="<?= $firstName ?>" placeholder="<?php _e('First name','shapepress-dsgvo')?>" spellcheck="false" />
                        </div>

                        <div class="column">
                            <label for="email-field"><?php _e('Last name','shapepress-dsgvo')?></label>
                            <input required type="text" id="last-name-field" name="last_name" value="<?= $lastName ?>" placeholder="<?php _e('Last name','shapepress-dsgvo')?>" spellcheck="false" />
                        </div>
                    </div>

					<div class="row">
						<div class="column">
                    		<label for="email-field"><?php _e('Email','shapepress-dsgvo')?></label>
                   			 <input required type="email" id="email-field" name="email" value="<?= $email ?>" placeholder="<?php _e('Email','shapepress-dsgvo')?>" spellcheck="false" />
						</div>
                    </div>
                    <div class="row">
						<div class="column">
                    		<label for="dsgvo-checkbox">
                   			 	<input required type="checkbox" id="dsgvo-checkbox" name="dsgvo_checkbox" value="1" />
                                <?php
                                $accept_text = convDeChars(SPDSGVOSettings::get('su_dsgvo_accepted_text'));
                                if(function_exists('icl_translate')) {
                                    $accept_text = icl_translate('shapepress-dsgvo', 'su_dsgvo_accepted_text', $accept_text);
                                }
                                ?>
                   			 	<span style="font-weight:normal"><?= spdsgvoUseWpml() ? __('I agree to the storage of the data for processing within the meaning of the GDPR.','shapepress-dsgvo') : $accept_text;  ?></span>
                   			 </label>
						</div>
                    </div>
                    <br>
                    <input type="submit" value="<?php _e('Create delete request','shapepress-dsgvo')?>" />
                </fieldset>
            </form>
        <?php endif; ?>
    <?php

    return ob_get_clean();
}

add_shortcode('unsubscribe_form', 'SPDSGVOUnsubscribeShortcode');