<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://logichunt.com
 * @since      1.0.0
 *
 * @package    Wp_Counter_Up
 * @subpackage Wp_Counter_Up/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Counter_Up
 * @subpackage Wp_Counter_Up/admin
 * @author     LogicHunt <logichunt.info@gmail.com>
 */
class Wp_Counter_Up_Admin {

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
     * @var Lgx_Carousel_Settings_API
     */
    private $settings_api;

    /**
     * The plugin plugin_base_file of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string plugin_base_file The plugin plugin_base_file of the plugin.
     */
    protected $plugin_base_file;



    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

        $this->settings_api = new WP_Counter_Up_Settings_API($plugin_name, $version);

        $this->plugin_base_file = plugin_basename(plugin_dir_path(__FILE__).'../' . $this->plugin_name . '.php');


    }




    /**
     * Ensure post thumbnail support is turned on.
     * Since 1.1.0
     */
    public function add_thumbnail_support() {
        if ( ! current_theme_supports( 'post-thumbnails' ) ) {
            add_theme_support( 'post-thumbnails' );
        }
        add_post_type_support( 'lgx_counter', 'thumbnail' );
    }




    /**
     * Add support link to plugin description in /wp-admin/plugins.php
     *
     * @param  array  $plugin_meta
     * @param  string $plugin_file
     *
     * @return array
     */
    public function support_link($plugin_meta, $plugin_file) {

        if ($this->plugin_base_file == $plugin_file) {
            $plugin_meta[] = sprintf(
                '<a href="%s">%s</a>', 'http://logichunt.com/support', __('Support',  $this->plugin_name)
            );
        }

        return $plugin_meta;
    }




    /**
     * Register the stylesheets for the admin area.
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

        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-counter-up-admin.css', array(), $this->version, 'all' );

    }

    /**
     * Register the JavaScript for the admin area.
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

        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-counter-up-admin.js', array( 'jquery' ), $this->version, false );

    }

    /**
     * Add metabox for custom post type
     *
     * @since    1.0.0
     */
    public function add_meta_boxes_metabox() {

        // meta box
        add_meta_box(
            'metabox_milestone', __( 'Counter Up Fields', $this->plugin_name ), array(
            $this,
            'metabox_lgx_milestone_display'
        ), 'lgx_counter', 'normal', 'high'
        );
    }




    /**
     * Register Custom Post Type For Portfolio Pro
     *
     * @since    1.0.0
     */
    public function lgx_milestone_post_type() {

        $labels_post = array(
            'name'               => _x( 'Counter Up', 'Counter Up', $this->plugin_name ),
            'singular_name'      => _x( 'Counter Up', 'Counter Up', $this->plugin_name ),
            'menu_name'          => __( 'Counter Up', $this->plugin_name ),
            'parent_item_colon'  => __( 'Parent Item:', $this->plugin_name ),
            'all_items'          => __( 'All Item', $this->plugin_name ),
            'view_item'          => __( 'View Item', $this->plugin_name ),
            'add_new_item'       => __( 'Add New Item', $this->plugin_name ),
            'add_new'            => __( 'Add Item', $this->plugin_name ),
            'edit_item'          => __( 'Edit Item', $this->plugin_name ),
            'update_item'        => __( 'Update Item', $this->plugin_name ),
            'search_items'       => __( 'Search Item', $this->plugin_name ),
            'not_found'          => __( 'Not found', $this->plugin_name ),
            'not_found_in_trash' => __( 'Not found in Trash', $this->plugin_name ),
        );

        $args_post   = array(
            'labels'              => $labels_post,
            'supports'            => array( 'title','thumbnail' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => true,
            'menu_icon'				=> 'dashicons-awards',
            'capability_type'     => 'post',
        );
        register_post_type( 'lgx_counter', $args_post );


        // Register Taxonomy

        //Categories
        $cat_args = array(
            'hierarchical'   => true,
            'label'          => 'Categories',
            'show_ui'        => true,
            'query_var'      => true,
            'rewrite'        => array('slug' => 'cat'),
            'singular_label' => 'Categories'
        );
        //  register_taxonomy('lgx_milestone_cat', array('lgx_milestone'), $cat_args);

    }



    /**
     * Render Metabox under Portfolio
     *
     * portfoliopro meta field
     *
     * @param $post
     *
     * @since 1.0
     *
     */

    public function metabox_lgx_milestone_display( $post ) {

        $fieldValues = get_post_meta( $post->ID, '_lgxmilestonemeta', true );

        wp_nonce_field( 'metaboxlgxmilestone', 'metaboxlgxmilestone[nonce]' );

        echo '<div id="lgxmilestone_metabox_wrapper">';

        $counter_number        = isset( $fieldValues['counter_number'] ) ? $fieldValues['counter_number'] : '';
        ?>


        <table class="form-table">
            <tbody>

            <?php do_action( 'lgxmilestone_meta_fields_before_start', $fieldValues ); ?>

            <tr valign="top">
                <td><?php _e( 'Counter Number', $this->plugin_name ) ?></td>
                <td>
                    <input type="number" name="metaboxlgxmilestone[counter_number]" value='<?php echo $counter_number; ?>'/>
                    <p class="description"><?php _e( 'Add Number for Count', $this->plugin_name ); ?></p>
                </td>
            </tr>

            <?php
            //allow others to show more custom fields at end
            do_action( 'lgxmilestone_meta_fields_after_start', $fieldValues );
            ?>

            </tbody>
        </table>

        <?php
        echo '</div>';


    }



    /**
     * Determines whether or not the current user has the ability to save meta data associated with this post.
     *
     * Save portfoliopro Meta Field
     *
     * @param        int $post_id //The ID of the post being save
     * @param         bool //Whether or not the user has the ability to save this post.
     */
    public function save_post_metabox_lgx_milestone( $post_id, $post ) {

        $post_type = 'lgx_counter';

        // If this isn't a 'book' post, don't update it.
        if ( $post_type != $post->post_type ) {
            return;
        }

        if ( ! empty( $_POST['metaboxlgxmilestone'] ) ) {

            $postData = $_POST['metaboxlgxmilestone'];

            $saveableData = array();

            if ( $this->user_can_save( $post_id, 'metaboxlgxmilestone', $postData['nonce'] ) ) {

                $saveableData['counter_number']        = sanitize_text_field( $postData['counter_number'] );

                update_post_meta( $post_id, '_lgxmilestonemeta', $saveableData );
            }
        }
    }// End  Meta Save


    /**
     * Determines whether or not the current user has the ability to save meta data associated with this post.
     *
     * user_can_save
     *
     * @param        int $post_id // The ID of the post being save
     * @param        bool /Whether or not the user has the ability to save this post.
     *
     * @since 1.0
     */
    public function user_can_save( $post_id, $action, $nonce ) {

        $is_autosave    = wp_is_post_autosave( $post_id );
        $is_revision    = wp_is_post_revision( $post_id );
        $is_valid_nonce = ( isset( $nonce ) && wp_verify_nonce( $nonce, $action ) );

        // Return true if the user is able to save; otherwise, false.
        return ! ( $is_autosave || $is_revision ) && $is_valid_nonce;

    }

    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */
    public function add_plugin_admin_menu() {

        $this->plugin_screen_hook_suffix  = add_submenu_page(
            'edit.php?post_type=lgx_counter',
            __('Setting', 'wp-counter-up'),
            __('Settings', 'wp-counter-up'),
            'manage_options',
            'lgxcountersettings',
            array($this, 'display_plugin_admin_settings')
        );

    }



    /**\
     *  Display Admin Settings
     */
    public function display_plugin_admin_settings() {

        $plugin_data = get_plugin_data(plugin_dir_path(__DIR__) . '/../' . $this->plugin_base_file);

        include('partials/admin-settings-display.php');
    }



    /**
     * Settings init
     */
    public function wp_conter_up_setting_init() {
        //set the settings
        $this->settings_api->set_sections($this->get_settings_sections());
        $this->settings_api->set_fields($this->get_settings_fields());

        //initialize settings
        $this->settings_api->admin_init();

    }


    /**
     * Setings Sections
     * @return array|mixed|void
     */

    public function get_settings_sections() {

        $sections = array(
            array(
                'id'    => 'lgxwcu_set_tab_basic',
                'title' => __('General Settings', 'wp-counter-up'),
                'desc' => '<p class="lgx-update"><strong>'. __('This is default value for WP Counter Up plugin. But this value will be override by shortcode params.', 'wp-counter-up') .'<p><strong>'
            ),

        );

        $sections = apply_filters('lgxwcu_settings_sections', $sections);

        return $sections;
    }




    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    public  function get_settings_fields() {


        $settings_fields = array(

            'lgxwcu_set_tab_basic' => array(

                array(
                    'name'             => 'lgxwcu_set_item_row',
                    'label'            => __('Items Per Row', 'wp-counter-up'),
                    'desc'             => __('Set items for per row.', 'wp-counter-up'),
                    'type'             => 'select',
                    'default'          => 1,
                    'options'          => array(
                        1=>'One',
                        2=>'Two',
                        3 =>'Three',
                        4 =>'Four',
                        6=>'Six',
                        12=>'Twelve' ,
                    ),
                ),

                array(
                    'name'    => 'lgxwcu_set_text_color',
                    'label'   => __('Text Color', 'wp-counter-up'),
                    'desc'    => __('Please select Text Color.', 'wp-counter-up'),
                    'type'    => 'color',
                    'default' => '#ffffff'
                ),

                array(
                    'name'    => 'lgxwcu_set_number_color',
                    'label'   => __('Number Color', 'wp-counter-up'),
                    'desc'    => __('Please select Number color.', 'wp-counter-up'),
                    'type'    => 'color',
                    'default' => '#ffffff'
                ),


                array(
                    'name'             => 'lgxwcu_set_order',
                    'label'            => __('Item Order', 'wp-counter-up'),
                    'desc'             => __('Direction to sort item.', 'wp-counter-up'),
                    'type'             => 'select',
                    'default'          => 'DESC',
                    'options'          => array(
                        'ASC' => __( 'Ascending', 'wp-counter-up' ),
                        'DESC'   => __( 'Descending', 'wp-counter-up' ),
                    ),
                ),

                array(
                    'name'             => 'lgxwcu_set_orderby',
                    'label'            => __('Item Order By', 'wp-counter-up'),
                    'desc'             => __('Sort retrieved item.', 'wp-counter-up'),
                    'type'             => 'select',
                    'default'          => 'date',
                    'options'          => array(
                        'date'      => __( 'Date', 'wp-counter-up' ),
                        'ID'        => __( 'ID', 'wp-counter-up' ),
                        'title'     => __( 'Title', 'wp-counter-up' ),
                        'modified'  => __( 'Modified', 'wp-counter-up' ),
                        'rand'      => __( 'Random', 'wp-counter-up' ),
                    ),
                ),

            ),// Single


        );//Filed

        $settings_fields = apply_filters('lgxwcu_settings_fields', $settings_fields);

        return $settings_fields;
    }


}
