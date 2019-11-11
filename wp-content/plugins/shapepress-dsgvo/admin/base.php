<div class="wrap dsgvo-wrap" style="">
	<h2><?php _e('WP DSGVO Tools', 'shapepress-dsgvo'); ?></h2>

	<h2 class="nav-tab-wrapper">
        <?php foreach($tabs as $t): ?>
        	<?php if(!$t->isHidden()): ?>
	            <a href="<?= $t->uri() ?>"
			class="nav-tab <?= ($tab === $t->slug)? 'nav-tab-active' : '' ?> <?= ($t->isHighlighted())? 'nav-tab-highlighted' : '' ?>">
	                <?= $t->title ?>
	            </a>
	        <?php endif; ?>
        <?php endforeach; ?>
    </h2>

    <?php
    if (isset($tabs[$tab])) {
        $tabs[$tab]->page();
    } else {
        $tabs['common-settings']->page();
    }
    ?>
</div>


<div class="wrap-premium">

	<form id="checklist-form" method="post"
		action="<?= admin_url('/admin-ajax.php'); ?>">
		<input type="hidden" name="action" value="admin-common-action">

		<div style="border: dashed 1px black; padding: 10px;">
			<span style="font-size: 1.2rem; line-height: 1.3rem;"><?php _e('WP DSGVO Tools is not binding and does not replace expert advice','shapepress-dsgvo')?></span>
		</div>
		<h2 style="margin-bottom: 0"><?php _e('GDPR website self check','shapepress-dsgvo')?></h2>
		<small>(<?php _e('Includes only your web presence!','shapepress-dsgvo')?>)</small>
		<ul id="dsgvo-checklist">
			<li><input id="cb_spdsgvo_cl_vdv" name="cb_spdsgvo_cl_vdv"
				type="checkbox" class="cbChecklist" value="1"
				<?= (SPDSGVOSettings::get('cb_spdsgvo_cl_vdv') === '1')? ' checked ' : '';  ?> /><span>
					<?php _e('VdV (directory of processing times)','shapepress-dsgvo')?> <a href="https://www.wp-dsgvo.eu/spdsgvo-bin/wp-dsgvp-tools-vdv.xls"><?php _e('downloaded','shapepress-dsgvo')?></a>
					&amp; <?php _e('filled','shapepress-dsgvo')?>
			</span></li>
			<li><input id="cb_spdsgvo_cl_filled_out"
				name="cb_spdsgvo_cl_filled_out" type="checkbox" class="cbChecklist"
				value="1"
				<?= (SPDSGVOSettings::get('cb_spdsgvo_cl_filled_out') === '1')? ' checked ' : '';  ?> /><span>
					<?php _e('WP DSGVO Tools plugin completely filled','shapepress-dsgvo')?></span></li>
			<li><input id="cb_spdsgvo_cl_maintainance"
				name="cb_spdsgvo_cl_maintainance" type="checkbox"
				class="cbChecklist" value="1"
				<?= (SPDSGVOSettings::get('cb_spdsgvo_cl_maintainance') === '1')? ' checked ' : '';  ?> /><span>
					<?php _e('Monthly maintenance of the website (maintenance contract with the web designer)','shapepress-dsgvo')?></span></li>
			<li><input id="cb_spdsgvo_cl_security" name="cb_spdsgvo_cl_security"
				type="checkbox" class="cbChecklist" value="1"
				<?= (SPDSGVOSettings::get('cb_spdsgvo_cl_security') === '1')? ' checked ' : '';  ?> /><span>
					<?php _e('Security Precautions (strong passwords, who has access, ...)','shapepress-dsgvo')?></span></li>
			<li><input id="cb_spdsgvo_cl_hosting" name="cb_spdsgvo_cl_hosting"
				type="checkbox" class="cbChecklist" value="1"
				<?= (SPDSGVOSettings::get('cb_spdsgvo_cl_hosting') === '1')? ' checked ' : '';  ?> /><span>
					<?php _e('GDPR compliant and secure web hosting? Our recommendation:','shapepress-dsgvo')?> <a
					href="https://raidboxes.de/?aid=14330" target="_blank">Raidboxes</a>
			</span></li>
			<li><input id="cb_spdsgvo_cl_plugins" name="cb_spdsgvo_cl_plugins"
				type="checkbox" class="cbChecklist" value="1"
				<?= (SPDSGVOSettings::get('cb_spdsgvo_cl_plugins') === '1')? ' checked ' : '';  ?> /><span>
					<?php _e('Check the security of unsupported plugins','shapepress-dsgvo')?></span></li>
			<li><input id="cb_spdsgvo_cl_experts" name="cb_spdsgvo_cl_experts"
				type="checkbox" class="cbChecklist" value="1"
				<?= (SPDSGVOSettings::get('cb_spdsgvo_cl_experts') === '1')? ' checked ' : '';  ?> /><span>
					<a href="https://www.wp-dsgvo.eu/experten/"
					target="_blank"><?php _e('Expert advice','shapepress-dsgvo')?></a> <?php _e('requested','shapepress-dsgvo')?>
			</span></li>
		</ul>
		<?php if (isValidPremiumEdition() == false && isValidBlogEdition() == false) :  ?>
		<h1 style="margin-top: 1em"><?php _e('Blog Edition','shapepress-dsgvo')?></h1>
		<ul id="dsgvo-premium-featurelist">
			<li><?php _e('Stylish Cookie Notice: Customize the look & feel of your Wordpress Page!','shapepress-dsgvo')?></li>
			<li><?php _e('Texts customizable with comment checkbox','shapepress-dsgvo')?></li>
		</ul>
		<div>
			<a href="https://www.wp-dsgvo.eu/shop" target="_blank"
				class="button button-primary" style="font-size: 1rem"><?php _e('Get the Blog Edition now','shapepress-dsgvo')?></a>
		</div>
		<?php endif;?>
		<?php if(isValidPremiumEdition() == false):?>
		<h1 style="margin-top: 1em"><?php _e('Upgrade to Premium','shapepress-dsgvo')?></h1>
		<ul id="dsgvo-premium-featurelist">
			<li><?php _e('Cookie Notice Popup','shapepress-dsgvo')?></li>
			<li><?php _e('Support & Community','shapepress-dsgvo')?></li>
			<li><?php _e('More Integrations','shapepress-dsgvo')?></li>
			<li><?php _e('Automatic user data reports','shapepress-dsgvo')?></li>
			<li><?php _e('Email notifications','shapepress-dsgvo')?></li>
			<li><?php _e('Style & Customization (from Blog Edition)','shapepress-dsgvo')?></li>
			<li><?php _e('and much more','shapepress-dsgvo')?></li>
		</ul>
		<div>
			<a href="https://www.wp-dsgvo.eu/shop" target="_blank"
				class="button button-primary" style="font-size: 1rem"><?php _e('Get Premium version now','shapepress-dsgvo')?></a>
		</div>
		<ul id="dsgvo-premium-featurelist-tipps">
			<li><?php _e('FAQ & checklists','shapepress-dsgvo')?></li>
			<li><?php _e('GDPR experts booking','shapepress-dsgvo')?></li>
			<li><?php _e('Book legal advice','shapepress-dsgvo')?></li>
		</ul>
		<?php endif;?>
		

</form>
</div>
