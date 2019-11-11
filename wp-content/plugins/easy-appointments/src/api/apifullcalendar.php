<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

class EAApiFullCalendar
{
    /**
     * The namespace.
     *
     * @var string
     */
    protected $namespace;

    /**
     * Rest base for the current object.
     *
     * @var string
     */
    protected $rest_base;

    /**
     * @var EADBModels
     */
    protected $db_models;

    /**
     * Category_List_Rest constructor.
     * @param $db_models
     */
    public function __construct($db_models) {
        $this->namespace = 'easy-appointments/v1';
        $this->rest_base = 'appointments';
        $this->db_models = $db_models;
    }

    /**
     * Register the routes for the objects of the controller.
     */
    public function register_routes() {
        register_rest_route( $this->namespace, '/' . $this->rest_base, array(
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array( $this, 'get_items' ),
                'permission_callback' => array( $this, 'get_items_permissions_check' ),
            ),
            'schema' => null,
        ) );
    }
    /**
     * Check permissions for the read.
     *
     * @param WP_REST_Request $request get data from request.
     *
     * @return bool|WP_Error
     */
    public function get_items_permissions_check( $request ) {
        if ( ! current_user_can( 'read' ) ) {
            return new WP_Error( 'rest_forbidden', esc_html__( 'You cannot view the category resource.' ), array( 'status' => $this->authorization_status_code() ) );
        }
        return true;
    }

    /**
     * Check permissions for the update
     *
     * @param WP_REST_Request $request get data from request.
     *
     * @return bool|WP_Error
     */
    public function update_item_permissions_check( $request ) {
        if ( ! current_user_can( 'manage_options' ) ) {
            return new WP_Error( 'rest_forbidden', esc_html__( 'You cannot update the category resource.' ), array( 'status' => $this->authorization_status_code() ) );
        }
        return true;
    }

    /**
     * Grabs all the category list.
     *
     * @param WP_REST_Request $request get data from request.
     *
     * @return mixed|WP_REST_Response
     */
    public function get_items( $request ) {

        $params = array(
            'from' => $request->get_param('start'),
            'to'   => $request->get_param('end'),
        );

        $res = $this->db_models->get_all_appointments($params);

        $res = array_map(function($element){
            return array(
                'title' => 'Title',
                'start' => $element->date . 'T' . $element->start,
                'end'   => $element->end_date . 'T' . $element->end,
            );
        }, $res);

        // Return all of our comment response data.
        return rest_ensure_response( $res );
    }

    /**
     * Sets up the proper HTTP status code for authorization.
     *
     * @return int
     */
    public function authorization_status_code() {
        $status = 401;
        if ( is_user_logged_in() ) {
            $status = 403;
        }
        return $status;
    }

}