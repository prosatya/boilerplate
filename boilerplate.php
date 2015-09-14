<?php
/*
Plugin Name: Boilerplate
Plugin URI: http://www.matictechnology.com
Description: Event Calander Plugin.
Version: 1.0
Author: Satyanarayan Verma
Author URI: http://www.matictechnology.com
*/


if(!class_exists('Boilerplate_Plugin'))
{
    class Boilerplate_Plugin
    {
        /**
         * Construct the plugin object
         */
        public function __construct()
        {
           add_action('init', array(&$this, 'plugin_init'));
           add_action('init', array(&$this, 'create_posttype_calander'));
		   add_action('admin_init', array(&$this, 'admin_init'));
		   add_action('admin_menu', array(&$this, 'add_menu'));
		   add_filter( 'event_calender', array( $this, 'event_calender_callback' ) );
		   add_shortcode( 'eventcal', array( $this, 'event_calender_callback' ) );

        } // END public function __construct
    
        /**
         * Activate the plugin
         */
        public static function activate()
        {
            // TODO:Something here

            global $wpdb;
			$charset_collate = $wpdb->get_charset_collate();
			$table_name = $wpdb->prefix . 'boilerplate';
			$sql = "CREATE TABLE $table_name (
						id mediumint(9) NOT NULL AUTO_INCREMENT,
						time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
						views smallint(5) NOT NULL,
						clicks smallint(5) NOT NULL,
						UNIQUE KEY id (id)
					) $charset_collate;";
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
        } // END public static function activate
    
        /**
         * Deactivate the plugin
         */     
        public static function deactivate()
        {

			// TODO:Something here
			global $wpdb;	//required global declaration of WP variable
			$table_name = $wpdb->prefix.boilerplate;
			$sql = "DROP TABLE ". $table_name;
			$wpdb->query($sql);

        } // END public static function deactivate

        /**
		 * hook into WP's admin_init action hook
		 */
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
           
        	include(sprintf("%s/templates/frontend.php", dirname(__FILE__)));
           

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


    } // END class Boilerplate_Plugin
} // END if(!class_exists('Boilerplate_Plugin'))


if(class_exists('Boilerplate_Plugin'))
{
    // Installation and uninstallation hooks
    register_activation_hook(__FILE__, array('Boilerplate_Plugin', 'activate'));
    register_deactivation_hook(__FILE__, array('Boilerplate_Plugin', 'deactivate'));

    // instantiate the plugin class
    $Boilerplate_Plugin = new Boilerplate_Plugin();
}
