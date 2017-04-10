<?php
// Create Required DB tables for theme
if(!function_exists('ravis_fn_create_required_tables'))
{
	function ravis_fn_create_required_tables()
	{
		global $wpdb;

		$table_name      = $wpdb->prefix . "ravis_booking"; 
		$charset_collate = $wpdb->get_charset_collate();

		/**
		 * Create Booking Room table 
		 * @var string table_name
		 */
		$sql = "CREATE TABLE $table_name (
			id int NOT NULL AUTO_INCREMENT,
			room_id int NOT NULL,
			booking_id int NOT NULL,
			check_in int NOT NULL,
			check_out int NOT NULL,
			adult int NOT NULL,
			child int NOT NULL,
			status int NOT NULL DEFAULT '1',
			confirmed int NOT NULL DEFAULT '0',
			UNIQUE KEY id (id)
		) $charset_collate;";
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		$table_notifier_name = $wpdb->prefix . "ravis_notifier";
		$charset_collate        = $wpdb->get_charset_collate();
		$sql3 = "CREATE TABLE $table_notifier_name (
			id int NOT NULL AUTO_INCREMENT,
			email text NOT NULL,
			UNIQUE KEY id (id)
		) $charset_collate;";
		dbDelta( $sql3 );
		
	}
}
add_action( 'after_setup_theme', 'ravis_fn_create_required_tables' );

if(!function_exists('create_widget_tables'))
{
	function create_widget_tables()
	{
		global $wpdb;
		/**
		 * Create Booking Events table 
		 * @var string table_name
		 */
		if(is_active_widget( false, false, "ravis_news_letter" ))
		{
			$table_newsletter_name = $wpdb->prefix . "ravis_newsletter";
			$charset_collate       = $wpdb->get_charset_collate();
			$sql2 = "CREATE TABLE $table_newsletter_name (
				id int NOT NULL AUTO_INCREMENT,
				email text NOT NULL,
				UNIQUE KEY id (id)
			) $charset_collate;";
			dbDelta( $sql2 );				
		}
	}	
}
add_action( 'init', 'create_widget_tables' );