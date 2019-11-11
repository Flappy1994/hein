<?php

require_once(get_stylesheet_directory() . '/shortcodes/shortcodes.php');
require_once(get_stylesheet_directory() . '/shortcodes/slider.php');
require_once(get_stylesheet_directory() . '/shortcodes/icon.php');
require_once(get_stylesheet_directory() . '/shortcodes/items_list.php');
require_once(get_stylesheet_directory() . '/shortcodes/blog.php');
require_once(get_stylesheet_directory() . '/shortcodes/columns.php');
require_once(get_stylesheet_directory() . '/shortcodes/map.php');
require_once(get_stylesheet_directory() . '/shortcodes/single-post.php');

function child_theme_enqueue_styles()
{
	wp_enqueue_style("parent-style", get_template_directory_uri() . "/style.css", array("reset", "superfish", "jquery-fancybox", "jquery-qtip", "jquery-ui-custom"));
}
add_action("wp_enqueue_scripts", "child_theme_enqueue_styles");

function child_theme_enqueue_scripts(){
	wp_enqueue_script( 'timeago-de',  get_stylesheet_directory_uri() . '/js/jquery.timeago.de.js', array(), '1.5.3', true );
}
add_action( 'wp_enqueue_scripts', 'child_theme_enqueue_scripts', 99999 );

function theme_enqueue_scripts2(){
	wp_enqueue_script("google-maps-v3", "//maps.google.com/maps/api/js?sensor=false", false, array(), false, true);
}
add_action("wp_enqueue_scripts", "theme_enqueue_scripts2");


//--------------- Disable Wordpress from adding <p> tags  --------------------
//https://stackoverflow.com/a/12269549
remove_filter( 'the_content', 'wpautop' );
//remove_filter( 'the_excerpt', 'wpautop' );

//--------------- Grid shortcode --------------------
//vc_row
function vc_theme_row($atts, $content = null)
{	
	extract(shortcode_atts(array(
		"class" => "",
		"top_margin" => ""
	), $atts));
	return '<div class="vc_row wpb_row vc_row-fluid' . ($class!='' ? ' ' . $class : '') . ($top_margin!='' ? ' ' . $top_margin : '') . '">' . do_shortcode($content) . '</div>';
}
add_shortcode("vc_row", "vc_theme_row");

//Convert a string fraction to float. For example "1/2" to 0.25
function calculate_string( $mathString )    {
    $mathString = trim($mathString);
    $mathString = str_replace ('[^0-9\+-\*\/\(\) ]', '', $mathString); 

    $compute = create_function("", "return (" . $mathString . ");" );
    return 0 + $compute();
}
//vc_column
function vc_theme_column($atts, $content = null)
{
	extract(shortcode_atts(array(
		"class" => "",
		"width" => "",
		"top_margin" => ""
	), $atts));
	if($width!=''){
		$columnSize = calculate_string($width)*12;
	}
	return '<div class="wpb_column vc_column_container vc_col-sm-'. ($width!='' ? $columnSize : '12').''.($class!='' ? ' ' . $class : '') . ($top_margin!='' ? ' ' . $top_margin : '') .'"><div class="wpb_wrapper">' . do_shortcode($content) . '</div></div>';
}
add_shortcode("vc_column", "vc_theme_column");

function theme_column($atts, $content = null) {
	extract(shortcode_atts(array(
		"class" => ""
	), $atts));
	return '<div class="wpb_column vc_column_container vc_col-sm-6 page_margin_top"><div class="wpb_wrapper">' . do_shortcode($content) . '</div></div>';
}
add_shortcode("column", "theme_column");

//vc_column_text
function vc_theme_column_text($atts, $content = null)
{	
	extract(shortcode_atts(array(
		"class" => "",
		"el_class" => ""
	), $atts));
	return '<div class="wpb_text_column wpb_content_element' . ($class!='' ? ' ' . $class : '') ." ". $el_class .'"><div class="wpb_wrapper"><p>' . do_shortcode($content) . '</p></div></div>';
}
add_shortcode("vc_column_text", "vc_theme_column_text");

//vc_row_inner
function vc_theme_row_inner($atts, $content = null)
{	
	extract(shortcode_atts(array(
		"class" => ""
	), $atts));
	return '<div class="vc_row wpb_row vc_inner vc_row-fluid' . ($class!='' ? ' ' . $class : '') . '">' . do_shortcode($content) . '</div>';
}
add_shortcode("vc_row_inner", "vc_theme_row_inner");

//vc_column_inner
function vc_theme_column_inner($atts, $content = null)
{	
	extract(shortcode_atts(array(
		"class" => ""
	), $atts));
	return '<div class="wpb_column vc_column_container vc_col-sm-12' . ($class!='' ? ' ' . $class : '') . '"><div class="wpb_wrapper">' . do_shortcode($content) . '</div></div>';
}
add_shortcode("vc_column_inner", "vc_theme_column_inner");
//--------------- End Grid Shortcode ------------------

//Sidebar Shortcode
function widget_sidebar($atts){
	extract(shortcode_atts(array(
		"sidebar_id" => ""
	), $atts));

	if ( is_active_sidebar( $sidebar_id ) ){
		$output = '<div class="wpb_widgetised_column wpb_content_element clearfix"><div class="wpb_wrapper">'.dynamic_sidebar( $sidebar_id ).'</div></div>';
		return $output;
	}

/*	if ( is_active_sidebar( $sidebar_id ) ){
		return '<div class="wpb_widgetised_column wpb_content_element clearfix"><div class="wpb_wrapper">'.dynamic_sidebar($sidebar_id).'</div></div>';
	}*/
}
add_shortcode("vc_widget_sidebar", "widget_sidebar");

