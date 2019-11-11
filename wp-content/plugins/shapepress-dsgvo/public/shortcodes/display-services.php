<?php

function SPDSGVODisplayServicesShortcode(){
    ob_start();
    ?>
    	<ul>
    		<?php foreach(SPDSGVOSettings::get('services') as $slug => $service): ?>
	    		<li>
	    			<strong><?= $service['name'] ?>: </strong>

                    <?php
                    $reason = $service['reason'];
                    if(function_exists('icl_translate')) {
                        if($slug == 'cookies') {
                            $reason = icl_translate('shapepress-dsgvo', 'services_cookies_reason', $reason);
                        } else if($slug == 'google-analytics') {
                            $reason = icl_translate('shapepress-dsgvo', 'services_google-analytics_reason', $reason);
                        } else if($slug == 'facebook-pixel') {
                            $reason = icl_translate('shapepress-dsgvo', 'services_facebook-pixel_reason', $reason);
                        }
                    }
                    echo $reason;
                    ?>

	    			<?php if($service['link']): ?>
	    				<a href="<?= $service['link'] ?>"><?php _e('Open Terms of service','shapepress-dsgvo')?></a>
	    			<?php endif; ?>
	    		</li>
    		<?php endforeach; ?>
    	</ul>
	<?php
	return ob_get_clean();
}

add_shortcode('display_services', 'SPDSGVODisplayServicesShortcode');
