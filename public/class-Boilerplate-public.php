<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.matictechnology.com
 * @since      1.0.0
 *
 * @package    Boilerplate
 * @subpackage Boilerplate/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Boilerplate
 * @subpackage Boilerplate/public
 * @author     Satyanarayan Verma <http://www.matictechnology.com>
 */
class Boilerplate_Public {

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
	 * @param      string    $boilerplate       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $boilerplate, $version ) {
		$this->boilerplate = $boilerplate;
		$this->version = $version;

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
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->boilerplate, plugin_dir_url( __FILE__ ) . 'css/fullcalendar.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->boilerplate."1" , plugin_dir_url( __FILE__ ) . 'css/custom.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->boilerplate."2" , plugin_dir_url( __FILE__ ) . 'css/Boilerplate-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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
		wp_enqueue_script( $this->boilerplate, plugin_dir_url( __FILE__ ) . 'js/Boilerplate-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->boilerplate."1", plugin_dir_url( __FILE__ ) . 'js/moment.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->boilerplate."2", plugin_dir_url( __FILE__ ) . 'js/jquery.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->boilerplate."3", plugin_dir_url( __FILE__ ) . 'js/fullcalendar.js', array( 'jquery' ), $this->version, false );

	}

}
