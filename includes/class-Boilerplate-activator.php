<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 * @author     Your Name <email@example.com>
 */
class Plugin_Name_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
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
	}

}
