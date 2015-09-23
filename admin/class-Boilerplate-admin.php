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

   	//Add meta fields

    public function add_custom_meta_box( $post_type ){
    	$post_types = array( 'bp_calender' );
 		if ( in_array( $post_type, $post_types )) {
 			add_meta_box("event_start_date", "Create Event", array(&$this, "create_start_box"), $post_type, 'side', 'high' );
 		}
 		
   	}//END fundtion

   	//show meta fields
    public function create_start_box( $post ){
	    wp_nonce_field(basename(__FILE__), "meta-box-nonce");
	    
	    // if(get_post_meta($post->ID, '_bp_calender_title', true) ){
	    //	 $meta_box_title = get_post_meta( $post->ID, '_bp_calender_title', true );
		// }
		// else{
		// 	$meta_box_title = "";
		// }
		
		if(get_post_meta($post->ID, '_bp_calender_start_date', true) ){
	    	$meta_box_start_date = get_post_meta( $post->ID, '_bp_calender_start_date', true );
		}
		else{
			$meta_box_start_date = "";
		}
		
		if(get_post_meta($post->ID, '_bp_calender_end_date', true ) ){
	    	$meta_box_end_date = get_post_meta( $post->ID, '_bp_calender_end_date', true );
		}
		else{
			$meta_box_end_date = "";
		}
		
		if(get_post_meta($post->ID, '_bpj_calender_end_date', true) ){
	    	$meta_box_url = get_post_meta( $post->ID, '_bp_calender_url', true );
		}
		else{
			$meta_box_url = "";
		}
	    
	    // Use get_post_meta to retrieve an existing value from the database.
	    ?>
	    	<table>
	    		<!--<tr>
	        		<td><label>Event :&nbsp;</label></td><td><input type="text" size="14px" name="meta_box_title" id="meta_box_title" value="<?php if($meta_box_title){ echo $meta_box_title; } ?>" /></td>
	        	</tr>-->
	        	<tr>
	        		<td><label>Start From :&nbsp;</label></td><td><input type="text" name="meta_box_start_date" id="meta_box_start_date" size="14px" value="<?php echo $meta_box_start_date;  ?>" /></td>
	        	</tr>
	        	<tr>
	        		<td><label>Open Till :&nbsp;</label></td><td><input type="text" name="meta_box_end_date" id="meta_box_end_date" size="14px" value="<?php echo $meta_box_end_date; ?>"/></td>
	        	</tr>
	        	<tr>
	        		<td><label>URL :&nbsp;</label></td><td><input type="text" name="meta_box_url" id="meta_box_url" size="14px" value="<?php echo $meta_box_url; ?>" placeholder="http://"/></td>
	        	</tr>
	        </table>
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

}
