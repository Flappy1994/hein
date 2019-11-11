<?php
if ( ! defined( 'ABSPATH' ) ) exit;
// Get the german days
$germanDays = bhp_getWeekdayTranslated();


if(get_option('fulldate') == 1){
    $currentDay = date("d.m.");
} else {
	$currentDay = date( 'd' );
}
$currentDayName = $germanDays[strtolower(date('l'))];

?>

<div class="bh-page">
	<div class="widget_item strappy">
		<div class="widget_3">
            
			<div class="container-fluid">
				<div class="widget_header" style="background-color: <?php echo $styling_colors_background_primary; ?>; color: <?php echo $styling_colors_text_primary; ?>;">

				<?php if($bh_title): ?>
				<div class="col-sm-12 notop nobottom">
					<p class= "bhtitle" style="color:<?php echo $styling_colors_text_primary; ?>"><?php echo $bh_title; ?></p>
				</div>
				<?php endif; ?>	
				
					<div class="col-xs-6">
						<!-- div class="header_icon" -->
							<div>
								<i class="<?php echo $styling_icon_header; ?>" aria-hidden="true"></i>
							</div>
						<!-- /div -->
					</div>

					<div class="col-xs-6 pullup">
						<div class="header_title text-center">
							<p class="nobottom">
								<span class='day-number'><?php echo $currentDay; ?></span>
							</p>
							<p class="notop">
								<span class="text-uppercase margin_none"><?php echo $currentDayName; ?></span>
							</p>
						</div>
					</div>

				</div>
			</div>		

			<div class="container-fluid">
				<div class="widget_body clear_fix" style="background-color: <?php echo $styling_colors_background_secondary; ?>; color: <?php echo $styling_colors_text_secondary; ?>;">
					<div class="col-sm-6 border_right_dashed">
						<div class="company_name">
							<p class="text-uppercase margin_none font_bold font_size_18" style="color: <?php echo $styling_colors_text_secondary; ?>;">
								<?php if(isset($business_name) && !empty($business_name)) echo $business_name ?>
							</p>

							<p class="text-capitalize">
								<?php if(isset($business_contact_person) && !empty($business_contact_person)) echo $business_contact_person ?>
							</p>
						</div>
						<div class="company_details smlrtxt">
							<?php if(isset($business_phone_number) && !empty($business_phone_number)) {
								echo sprintf('<p class="phone"><span>%s: </span><span>%s</span></p>', __('Telephone', 'offen'), $business_phone_number);
							} ?>

							<?php if(isset($business_fax_number) && !empty($business_fax_number)) {
								echo sprintf('<p class="fax margin_none"><span class="fax_first_child">%s:</span><span>%s</span></p>', __('Fax', 'offen'), $business_fax_number);
							} ?>

							<?php if(isset($business_email) && !empty($business_email)) {
								echo sprintf('<p class="email"><span>%s</span></p>', $business_email);
							} ?>

							<?php if(isset($business_website) && !empty($business_website)) {
								echo sprintf('<p class="website margin_bt_4"><span>%s</span></p>', $business_website);
							} ?>

							<?php if(isset($business_address) && !empty($business_address)) {
								echo sprintf('<p class="address margin_none"><span>%s</span><br><span>%s %s</span>', $business_address, $business_address_postal_code, $business_city);
							} ?>
						</div>
					</div>
					<div class="header_working_schedule col-sm-6">
						<p class="today">
							<span class="text-uppercase"><?php _e("Currently", 'offen'); ?></span>

							<?php
							if(isset($isOpen) && $isOpen) {
								echo sprintf('<span class="badge" style="background-color: %s; color: %s">%s</span>', $styling_colors_background_badge_open, $styling_colors_text_badge_open, $general_open_closed_badges_open);
							} else {
								echo sprintf('<span class="badge" style="background-color: %s; color: %s">%s</span>', $styling_colors_background_badge_closed, $styling_colors_text_badge_closed, $general_open_closed_badges_closed);
							}
							?>
						</p>
						<div class="working_hours working_days smlrtxt">
							<?php echo $openHours; ?>
						</div>
					</div>
				</div>
			</div>
				
			<div class="text-center widget_footer" style="background-color: <?php echo $styling_colors_background_tertiary; ?>; color: <?php echo $styling_colors_text_tertiary ?>;">
				<p class="margin_none force-center">
					<?php if(isset($openMessage) && !empty($openMessage)) echo $openMessage ?>
				</p>
			</div>
		</div>
	</div>
</div>