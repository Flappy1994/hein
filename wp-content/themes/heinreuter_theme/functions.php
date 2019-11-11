<?php

@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );
function wpdocs_custom_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );

register_nav_menus( "menus" );
function shapeSpace_display_search_form() {
	return get_search_form(false);
}
add_shortcode('display_search_form', 'shapeSpace_display_search_form');
// Create New Menu
If(function_exists("register_nav_menus")){
  register_nav_menus( array( $location => $description ) );
}

//This is to activate the featured image in Posts
if(function_exists("add_theme_support")){
    add_theme_support( 'post-thumbnails' );
}

if(function_exists('add_image_size')){
  add_image_size( 'featured', 400, 250, true );
  add_image_size( 'post-thumb', 125, 75, true );
}

function create_post_type(){
  register_post_type( 'post-type-slug-name', 
    array() 
  );
  
}

// Register menu "footer"
function register_my_menus()
{
register_nav_menus( 
	array(
	'footer' => __('Footer-Menu'),
	'header' => __('Header-Menu')
	)
);
}
add_action ('init', 'register_my_menus');
//Prevents the <p> tag from getting automatically insterted
remove_filter('the_content', 'wpautop');

add_action( 'init', 'create_post_type' );




// Dropdown-Bootstrap
require_once get_template_directory() . '/wp-bootstrap-navwalker.php';

function catch_that_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches [1] [0];

  if(empty($first_img)){ //Defines a default image
    $first_img = "/images/default.jpg";
  }
  return $first_img;
}



// Überschreiben der the_excerpt() Funktion, damit html5-Tags angezeigt werden können.
function wpse_allowedtags() {
    // Add custom tags to this string
        return '<h1>,<script>,<style>,<br>,<em>,<i>,<ul>,<ol>,<li>,<a>,<p>,<img>,<video>,<audio>'; 
    }

if ( ! function_exists( 'wpse_custom_wp_trim_excerpt' ) ) : 

    function wpse_custom_wp_trim_excerpt($wpse_excerpt) {
    $raw_excerpt = $wpse_excerpt;
        if ( '' == $wpse_excerpt ) {

            $wpse_excerpt = get_the_content('');
            $wpse_excerpt = strip_shortcodes( $wpse_excerpt );
            $wpse_excerpt = apply_filters('the_content', $wpse_excerpt);
            $wpse_excerpt = str_replace(']]>', ']]&gt;', $wpse_excerpt);
           

            //Set the excerpt word count and only break after sentence is complete.
                $excerpt_word_count = 75;
                $excerpt_length = apply_filters('excerpt_length', $excerpt_word_count); 
                $tokens = array();
                $excerptOutput = '';
                $count = 0;

                // Divide the string into tokens; HTML tags, or words, followed by any whitespace
                preg_match_all('/(<[^>]+>|[^<>\s]+)\s*/u', $wpse_excerpt, $tokens);

                foreach ($tokens[0] as $token) { 

                    if ($count >= $excerpt_length && preg_match('/[\,\;\?\.\!]\s*$/uS', $token)) { 
                    // Limit reached, continue until , ; ? . or ! occur at the end
                        $excerptOutput .= trim($token);
                        break;
                    }

                    // Add words to complete sentence
                    $count++;

                    // Append what's left of the token
                    $excerptOutput .= $token;
                }

            $wpse_excerpt = trim(force_balance_tags($excerptOutput));

               // $excerpt_end = ' <a href="'. esc_url( get_permalink() ) . '">' . '&nbsp;&raquo;&nbsp;' . sprintf(__( 'Read more about: %s &nbsp;&raquo;', 'wpse' ), get_the_title()) . '</a>'; 
                $excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end); 

                //$pos = strrpos($wpse_excerpt, '</');
                //if ($pos !== false)
                // Inside last HTML tag
                //$wpse_excerpt = substr_replace($wpse_excerpt, $excerpt_end, $pos, 0); /* Add read more next to last word */
                //else
                // After the content
                $wpse_excerpt .= $excerpt_more; /*Add read more in new paragraph */

            return $wpse_excerpt;   

        }
        return apply_filters('wpse_custom_wp_trim_excerpt', $wpse_excerpt, $raw_excerpt);
    }

endif; 

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'wpse_custom_wp_trim_excerpt'); 

add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);

function special_nav_class ($classes, $item) {
    if (in_array('current-menu-item', $classes) ){
        $classes[] = 'active ';
    }
    return $classes;
}

add_filter('wp_nav_menu', 'menu_enable_shortcode', 20, 2);

function  menu_enable_shortcode ( $menu, $args ) {
return do_shortcode( $menu );
}

// Hier werden im WP-Backend Sidebars registriert und können unter Widgets angeschaut und editiert werden.
if ( function_exists('register_sidebar') ) {

   register_sidebar(array(
   'name' => 'Cards',
   'before_widget' => '<div class="col-lg-4">
			<div class="card w-100 h-100">
			<div class="card-body">',
   'after_widget' => ' </div>
			</div></div>',
   'before_title' => '<h2>',
   'after_title' => '</h2>'
    ));

   register_sidebar(array(
   'name' => 'Opening Hours',
   'before_widget' => '<div>',
   'after_widget' => '</div>',
   'before_title' => '<h3>',
   'after_title' => '</h3>'
   ));

}

class Bootstrap_Card_Widget extends WP_Widget {
	public function __construct() {
		$widget_options = array( 
		  'classname' => 'Bootstrap Card',
		  'description' => 'This is an Example Widget',
		);
		parent::__construct( 'bootstrap_card', 'Bootstrap Card', $widget_options );
 	}
function widget( $args, $instance ) {
	echo $args['before_widget']; 
	echo '<h2>'.$instance['title'].'</h2>';
	echo $instance['text'];
	$url = $instance['post'];
	if($instance['button'] == TRUE)
	{
		echo '</div><a class="btn btn-success" href="'.$url.'" >Mehr lesen </a><div>';
	}
	
	echo $args['after_widget'];
}
	function form($instance) {
 	$title = '';
	$text = '';
	$button = '';
	$post = '';

	// Check values
	if( $instance) {
		$title = esc_attr($instance['title']);
		$text = esc_html($instance['text']);
		$button = $instance[ 'your_checkbox_var' ] ? 'true' : 'false';
		$post = esc_textarea($instance['post']);
	} ?>
		 
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'wp_widget_plugin'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
		 
	<p>
		<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text', 'wp_widget_plugin'); ?></label>
		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
    
 
		
	</p>
	<p>
    <input class="checkbox" type="checkbox" <?php checked( $instance[ 'button' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'button' ); ?>" name="<?php echo $this->get_field_name( 'button' ); ?>" /> 
    <label for="<?php echo $this->get_field_id( 'Button' ); ?>">Button "Mehr lesen" aktivieren?</label>
</p>
	
	<p>
		<label for="<?php echo $this->get_field_id('post'); ?>"><?php _e('URL:', 'wp_widget_plugin'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('post'); ?>" name="<?php echo $this->get_field_name('post'); ?>" type="text" value="<?php echo $post; ?>" />
	</p>
		
<?php }
	
	function update($new_instance, $old_instance) {
	$instance = $old_instance;
	// Fields
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['text'] = strip_tags($new_instance['text'], '<ul><li>');
	$instance['button'] = strip_tags($new_instance['button']);
	$instance['post'] = strip_tags($new_instance['post']);
	return $instance;
}
	
	
 
}

function Bootstrap_Card_Widget() { 
  register_widget( 'Bootstrap_Card_Widget' );
}
add_action( 'widgets_init', 'Bootstrap_Card_Widget' );

include('customizer.php');
if ( ! isset( $content_width ) ) {
	$content_width = 900;
}

