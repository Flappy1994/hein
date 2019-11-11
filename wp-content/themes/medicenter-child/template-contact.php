<?php 
/*
Template Name: Contact
*/
get_header();
setPostViews(get_the_ID());
?>
<div class="theme_page relative">
	<div class="page_layout page_margin_top clearfix">
		<div class="page_header clearfix">
			<div class="page_header_left">
				<h1 class="page_title"><?php the_title(); ?></h1>
				<ul class="bread_crumb">
					<li>
						<a href="<?php echo get_home_url(); ?>" title="<?php _e('Home', 'medicenter'); ?>">
							<?php _e('Home', 'medicenter'); ?>
						</a>
					</li>
					<li class="separator icon_small_arrow right_gray">
						&nbsp;
					</li>
					<li>
						<?php the_title(); ?>
					</li>
				</ul>
			</div>
			<?php
			/*get page with single post template set*/
			$post_template_page_array = get_pages(array(
				'post_type' => 'page',
				'post_status' => 'publish',
				'meta_key' => '_wp_page_template',
				'meta_value' => 'single.php'
			));
			$post_template_page = $post_template_page_array[0];
			$sidebar = get_post(get_post_meta($post_template_page->ID, "page_sidebar_header", true));
			if(!(int)get_post_meta($sidebar->ID, "hidden", true) && is_active_sidebar($sidebar->post_name)):
			?>
			<div class="page_header_right">
				<?php
				dynamic_sidebar($sidebar->post_name);
				?>
			</div>
			<?php
			endif;
			?>
		</div>
		<div class="clearfix">
			<div class="vc_row wpb_row vc_row-fluid">
				<div class="wpb_column vc_column_container vc_col-sm-8">
					<div class="wpb_wrapper">
						<?php
						echo do_shortcode("[box_header title='Philosophie' bottom_border='1' animation='0' top_margin='page_margin_top']");

						if(have_posts()) : while (have_posts()) : the_post();
							the_content();
						endwhile; endif;

						echo do_shortcode("[map height='427px' lat='50.231940' lng='8.611684' marker_lat='50.231940' marker_lng='8.611684' zoom='16' map_icon_url='http://heinreuter.de.new/wp-content/uploads/2013/04/map_pointer2.png' icon_width='38' icon_height='45' icon_anchor_x='18' icon_anchor_y='44' icon_url='http://quanticalabs.com/wp_themes/wp-content/themes/medicenter/images/map_pointer.png' el_position='first last']");
						?>
					</div>
				</div>
				<div class="wpb_column vc_column_container vc_col-sm-4 page_margin_top">
					<div class="wpb_wrapper">
						<div class="wpb_widgetised_column wpb_content_element clearfix">
							<div class="wpb_wrapper">
								<?php if ( is_active_sidebar( 'sidebar-home-right-style-2' ) ) : ?>
									<?php dynamic_sidebar( 'sidebar-home-right-style-2' ); ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
get_footer();
?>