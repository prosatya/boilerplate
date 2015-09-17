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
        // add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
        // add_action( 'save_post', array( $this, 'save' ) );
           add_action( 'init', array( &$this, 'plugin_init'));
           add_action( 'init', array( &$this, 'create_posttype_calander' ) );
		   add_action( 'admin_init', array( &$this, 'admin_init' ) );
		   add_action( 'admin_menu', array( &$this, 'add_menu' ) );
		   add_action( 'add_meta_boxes', array( $this, 'add_custom_meta_box' ) );
		   add_action( "save_post", array( $this, "save_created_meta_box" ) );
		   add_filter( 'event_calender', array( $this, 'event_calender_callback' ) );
		   add_shortcode( 'eventcal', array( $this, 'event_calender_callback' ) );
		   add_action("wp_enqueue_scripts", array( $this, 'event_scripts' ) );

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

       	//Add meta fields

        public function add_custom_meta_box( $post_type ){
     		$post_types = array( 'bp_calender' );
     		if ( in_array( $post_type, $post_types )) {
     			add_meta_box("event_start_date", "Create Event", array(&$this, "create_start_box"), $post_type );
     		}
       	}//END fundtion

       	//show meta fields
        public function create_start_box( $post ){
		    wp_nonce_field(basename(__FILE__), "meta-box-nonce");
		    $meta_box_title = get_post_meta( $post->ID, '_bp_calender_title', true );
		    $meta_box_start_date = get_post_meta( $post->ID, '_bp_calender_start_date', true );
		    $meta_box_end_date = get_post_meta( $post->ID, '_bp_calender_end_date', true );
		    $meta_box_url = get_post_meta( $post->ID, '_bp_calender_url', true );
		   // wp_nonce_field( 'myplugin_inner_custom_box', 'myplugin_inner_custom_box_nonce' );

		   // Use get_post_meta to retrieve an existing value from the database.
		    ?>
		        <div>
		        	<label>Short Summery :&nbsp;</label><input type="text" size="14px" name="meta_box_title" id="meta_box_title" value="<?php if($meta_box_title){ echo $meta_box_title; } ?>" /><br>
		        	<label>Start From :&nbsp;</label><input type="date" name="meta_box_start_date" id="meta_box_start_date" value="<?php if($meta_box_start_date){ echo $meta_box_start_date; } ?>" /><br>
		        	<label>Open Till :&nbsp;</label><input type="date" name="meta_box_end_date" id="meta_box_end_date" value="<?php if($meta_box_end_date){ echo $meta_box_end_date; } ?>"/><br>
		        	<label>URL :&nbsp;</label><input type="text" name="meta_box_url" id="meta_box_url" value="<?php if($meta_box_url){ echo $meta_box_url; } ?>" /><br>
		        </div>
		    <?php  
		}//END fundtion

		//save mata fields
		function save_created_meta_box( $post_id ){
				if ( array_key_exists('meta_box_title', $_POST ) ) {
			            update_post_meta( $post_id,
			               '_bp_calender_title',
			                $_POST['meta_box_title']
			            );
			        }
			    if ( array_key_exists('meta_box_start_date', $_POST ) ) {
		            update_post_meta( $post_id,
		               '_bp_calender_start_date',
		                $_POST['meta_box_start_date']
		            );
		        }
		        if ( array_key_exists('meta_box_end_date', $_POST ) ) {
		            update_post_meta( $post_id,
		               '_bp_calender_end_date',
		                $_POST['meta_box_end_date']
		            );
		        }
		        if ( array_key_exists('meta_box_url', $_POST ) ) {
		            update_post_meta( $post_id,
		               '_bp_calender_url',
		                $_POST['meta_box_url']
		            );
		        }
		}//END function


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

		/**
        *Add scripts and CSS to the plugin
        */

        //Add Scripts and Css
    	public function event_scripts(){
    		wp_enqueue_style( 'moment_js', plugins_url('/css/fullcalendar.css', __FILE__) );
		    wp_enqueue_style( 'moment_js', plugins_url('/css/fullcalendar.print.css', __FILE__) );
		    wp_enqueue_script( 'moment_js', plugins_url('/js/moment.min.js', __FILE__), '', '', true );
		    wp_enqueue_script( 'common_js', plugins_url('/js/jquery.min.js', __FILE__), '', '', true );
		    wp_enqueue_script( 'fullcalendar_js', plugins_url('/js/fullcalendar.js', __FILE__), '', '', true );
    	}//End Function








			 




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
