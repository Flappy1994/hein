<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Class EAFullCalendar
 */
class EAFullCalendar
{

    /**
     * @var EAOptions
     */
    protected $options;

    /**
     * @var EADBModels
     */
    protected $models;

    /**
     * @var EADateTime
     */
    protected $datetime;

    /**
     * @param EADBModels $models
     * @param EAOptions $options
     * @param $datetime
     */
    function __construct($models, $options, $datetime)
    {
        $this->options  = $options;
        $this->models   = $models;
        $this->datetime = $datetime;
    }

    public function init()
    {
        // register JS
         add_action('wp_enqueue_scripts', array($this, 'init_scripts'));
        // add_action( 'admin_enqueue_scripts', array( $this, 'init' ) );

        // add shortcode standard
        add_shortcode('ea_full_calendar', array($this, 'ea_full_calendar'));
    }

    public function init_scripts()
    {
        // bootstrap script
        wp_register_script(
            'ea-full-calendar',
            EA_PLUGIN_URL . 'js/libs/fullcalendar/fullcalendar.min.js',
            array('jquery', 'ea-momentjs', 'wp-api'),
            '2.0.0',
            true
        );

        wp_register_style(
            'ea-full-calendar-style',
            EA_PLUGIN_URL . 'js/libs/fullcalendar/fullcalendar.css'
        );
    }

    public function ea_full_calendar($atts)
    {
        // scripts that are going to be used
        wp_enqueue_script('underscore');
        wp_enqueue_script('ea-validator');
        wp_enqueue_script('ea-full-calendar');

        wp_enqueue_style('ea-full-calendar-style');

        $id = '12345';

        $script = <<<EOT
  jQuery(document).ready(function() {

    jQuery('#ea-full-calendar-{$id}').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,basicWeek,basicDay'
      },
      defaultDate: '2019-01-12',
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      events: {
        url: wpApiSettings.root + 'easy-appointments/v1/appointments',
        type: 'GET',
        data: {
          _wpnonce: wpApiSettings.nonce, 
          custom_param1: 'something',
          custom_param2: 'somethingelse'
        },
        error: function() {
          alert('there was an error while fetching events!');
        },
        color: 'yellow',   // a non-ajax option
        textColor: 'black' // a non-ajax option
      }
    });

  });
EOT;

        wp_add_inline_script( 'ea-full-calendar', $script);

        return "<div id='ea-full-calendar-{$id}'></div>";
    }
}