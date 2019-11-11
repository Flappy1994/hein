<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://logichunt.com
 * @since      1.0.0
 *
 * @package    Wp_Counter_Up
 * @subpackage Wp_Counter_Up/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Counter_Up
 * @subpackage Wp_Counter_Up/public
 * @author     LogicHunt <logichunt.info@gmail.com>
 */
class Wp_Counter_Up_Public {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

        $this->settings_api = new WP_Counter_Up_Settings_API($plugin_name, $version);

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Wp_Counter_Up_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wp_Counter_Up_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-counter-up-public.css', array(), $this->version, 'all' );

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Wp_Counter_Up_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wp_Counter_Up_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script( 'lgx-waypoints', plugin_dir_url( __FILE__ ) . 'js/waypoints.min.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script( 'lgx-milestone', plugin_dir_url( __FILE__ ) . 'js/jquery.counterup.min.js', array( 'jquery' ), $this->version, false );

        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-counter-up-public.js', array( 'jquery' ), $this->version, false );

    }



    /**
     * Define Short Code Function
     *
     * @param $atts
     *
     * @return mixed
     * @since 1.0.0
     */


    public function lgx_milestone_shortcode_function($atts) {

        $lgxwcu_set_item_row        = $this->settings_api->get_option('lgxwcu_set_item_row', 'lgxwcu_set_tab_basic', 1);
        $lgxwcu_set_text_color      = $this->settings_api->get_option('lgxwcu_set_text_color', 'lgxwcu_set_tab_basic', '#111111');
        $lgxwcu_set_number_color    = $this->settings_api->get_option('lgxwcu_set_number_color', 'lgxwcu_set_tab_basic', '#111111');
        $lgxwcu_set_order           = $this->settings_api->get_option('lgxwcu_set_order', 'lgxwcu_set_tab_basic', 'DESC');
        $lgxwcu_set_orderby         = $this->settings_api->get_option('lgxwcu_set_orderby', 'lgxwcu_set_tab_basic', 'orderby');


        $atts = shortcode_atts(array(
            'orderby'		=> $lgxwcu_set_orderby,
            'order'			=> $lgxwcu_set_order,
            'number_color'  => $lgxwcu_set_number_color,
            'text_color'    => $lgxwcu_set_text_color,
            'row_item'      => $lgxwcu_set_item_row,
            'custom_class'   => 'default'

        ), $atts, 'lgx-counter');

        $output = '';

        // Output view override from active theme ans plugin
        if ( file_exists(get_template_directory() . '/logichunt/plugin-public.php')){

            require_once get_template_directory() . '/logichunt/plugin-public.php';

            $method_name =trim(str_replace("-","_",$this->plugin_name.'_views'));

            if ( class_exists( 'LogicHuntPluginExtendedPublic' ) ) {

                $themeViews = new LogicHuntPluginExtendedPublic();

                if( method_exists($themeViews, $method_name)) {

                    $output = $themeViews->$method_name($atts);

                }else {

                    $output = $this->lgx_milestone_output_function($atts);
                }
            }

        } else{

            $output = $this->lgx_milestone_output_function($atts);
        }


        return $output;
    }



    public function lgx_milestone_output_function($params) {

        $text_color     = $params['text_color'];
        $number_color   = $params['number_color'];
        $custom_class   = esc_html($params['custom_class']);
        $row_item       = intval($params['row_item']);

        $total_grid     = 12;
        $row_col        = $total_grid / $row_item;


        // WP_Query arguments
        $args = array(
            'post_type' => array('lgx_counter'),
            'post_status' => array('publish'),
            'order' => $params['orderby'],
            'orderby' => $params['order'],
            'posts_per_page' => -1
        );

        // The Query
        $query = new WP_Query($args);

        $output = '';

        // Default Value

        $item = '';

        // The Loop
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $post_id = get_the_ID();
                $title = get_the_title();
                $metavalues     = get_post_meta( get_the_ID(), '_lgxmilestonemeta', true );
                $counter_number      = (float) $metavalues['counter_number'];

                $thumb_url = '';
                if (has_post_thumbnail($post_id)) {
                    $thumb_url = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), true);
                    $thumb_url = $thumb_url[0];
                }

                // Item
                $item .= '<div class="lgxmc-col-xs-6 lgxmc-col-sm-'.$row_col.'">';
                $item .= '<div class="lgx-counter-area">';
                $item .= '<img  src="'.$thumb_url.'" alt="Icon">';
                $item .= '<div class="counter-text">';
                $item .= '<span class="lgx-counter" style="color:'.$number_color.';">'.$counter_number.'</span>';
                $item .= '<small style="color:'.$text_color.';">'.$title.'</small> ';
                $item .= '</div>';
                $item .= '</div>';
                $item .= '</div>';

            }//foreach

            // Restore original Post Data
            wp_reset_postdata();

            $output .= '<div class="lgx-milestone-counter lgx-milestone lgx-milestone-'. $custom_class .'">';
            $output .= '<div class="lgx-mc-wrapper">';
            $output .= '<div class="lgxmc-row">';
            $output  .= $item;
            $output .= ' </div>';
            $output .= '</div>';
            $output .= '</div>';

        }

        // Return Output
        return $output;
    }

}
