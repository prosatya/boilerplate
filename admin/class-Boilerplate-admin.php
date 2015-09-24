<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.matictechnology.com
 * @since      1.0.0
 *
 * @package    Boilerplate
 * @subpackage Boilerplate/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Boilerplate
 * @subpackage Boilerplate/admin
 * @author     Your Name <http://www.matictechnology.com>
 */
class Boilerplate_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $boilerplate    The ID of this plugin.
	 */
	private $boilerplate;

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
	 * @param      string    $boilerplate       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $boilerplate, $version ) {
		$this->boilerplate = $boilerplate;
		$this->version = $version;

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
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->boilerplate, plugin_dir_url( __FILE__ ) . 'css/Boilerplate-admin.css', array(), $this->version, 'all' );	
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
		 * defined in Boilerplate_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Boilerplate_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->boilerplate, plugin_dir_url( __FILE__ ) . 'js/Boilerplate-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->boilerplate."1", plugin_dir_url( __FILE__ ) . 'js/jquery.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->boilerplate."2", plugin_dir_url( __FILE__ ) . 'js/datepiker1/jquery.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->boilerplate."3", plugin_dir_url( __FILE__ ) . 'js/datepiker1/jquery.datetimepicker.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->boilerplate."4", plugin_dir_url( __FILE__ ) . 'js/datepiker1/custom.js', array( 'jquery' ), $this->version, false );


	}


	public function admin_init()
	{
	   // TODO:Something here
	} // END public static function activate


    /**
	 * hook into WP's init action hook
	 */
	public function plugin_init()
	{
	   
		/* TODO: Register our stylesheet. */
   		// wp_register_style( 'boilerplate-style', plugins_url('fullcalendar.css', __FILE__) );
   		// wp_register_style( 'boilerplate-style-print', plugins_url('fullcalendar.print.css', __FILE__) );
	   // TODO:Something here

	} // END public static function activate

	/**
	* add a menu
	*/     
	public function add_menu()
	{
	add_options_page('Boilerplate Plugin Settings', 'Boilerplate Plugin', 'manage_options', 'Boilerplate_Plugin', array(&$this, 'plugin_settings_page'));
	} // END public function add_menu()


	/**
	* Menu Callback
	*/     
	public function plugin_settings_page()
	{
		if(!current_user_can('manage_options'))
		{
		wp_die(__('You do not have sufficient permissions to access this page.'));
		}
	
		// TODO:Something here
		// Render the settings template
			 include(sprintf("%s/templates/settings.php", dirname(__FILE__)));
		
	} // END public function plugin_settings_page()


	
	public function event_calender_callback($atts)
    {
    	?>
		<script>
			jQuery(document).ready(function() {
				jQuery('#calendar').fullCalendar({
					defaultDate: new Date(),
					editable: true,
					eventLimit: true, // allow "more" link when too many events
					events: <?php 
						include(sprintf("%s/templates/get-events.php", dirname(__FILE__)));
					?>
				});
				
			});
		</script>
		<div id='calendar'></div>
		<?php
    } // END  function 
	

	// Create Custom post type  for calender 
	function create_posttype_calander() {
	  register_post_type( 'bp_calender',
	    array(
	      'labels' => array(
	        'name' => __( 'Calenders' ),
	        'singular_name' => __( 'Calnder' )
	      ),
	      'public' => true,
	      'has_archive' => true,
	      'rewrite' => array('slug' => 'calenders'),
	    )
	  );
	}


	function my_theme_register_required_plugins() {
		/*
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */

		$plugins = array(

			array(
					'name'         => 'Meta Box Plugin', // The plugin name.
					'slug'         => 'meta-box', // The plugin slug (typically the folder name).
					'source'       => dirname(__FILE__)."/includes/meta-box.zip", // The plugin source.
					'required'     => true, // If false, the plugin is only 'recommended' instead of required.
					'external_url' => 'https://metabox.io/', // If set, overrides default API URL and points to an external URL.
				 ),
			);

		/*
		 * Array of configuration settings. Amend each line as needed.
		 *
		 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
		 * strings available, please help us make TGMPA even better by giving us access to these translations or by
		 * sending in a pull-request with .po file(s) with the translations.
		 *
		 * Only uncomment the strings in the config array if you want to customize the strings.
		 */
		$config = array(
			'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'parent_slug'  => 'themes.php',            // Parent menu slug.
			'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
		);

		tgmpa( $plugins, $config );
	}


	function Boilerplate_register_meta_boxes( $meta_boxes )
	{
	    $prefix = 'bp_calender_';
	    // 1st meta box
	    $meta_boxes[] = array(
	        'id'       => 'personal',
	        'title'    => 'Description',
	        'pages'    => array( 'bp_calender' ),
	        'context'  => 'normal',
	        'priority' => 'high',
	        'fields' => array(
	            array(
	                'name'  => 'Start from',
	                'desc'  => 'Format: 0000-00-00 00:00',
	                'id'    => $prefix . 'start_date',
	                'type'  => 'datetime',
	                'std'   => '',
	                'class' => '',
	                'clone' => false,
	            ),
	            array(
	                'name'  => 'Open Till',
	                'desc'  => 'Format: 0000-00-00 00:00',
	                'id'    => $prefix . 'end_date',
	                'type'  => 'datetime',
	                'std'   => '',
	                'class' => '',
	                'clone' => false,
	            ),
	            array(
	                'name'  => 'URL',
	                'desc'  => 'Format: http://',
	                'id'    => $prefix . 'url',
	                'type'  => 'URL',
	                'std'   => '',
	                'class' => '',
	                'clone' => false,
	            ),
	        )
	    );
	    return $meta_boxes;
	}

}
