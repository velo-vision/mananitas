<?php 
/**
 * Remove the booking records from its table when a booking post is deleting
 */

if( !function_exists("ravis_fn_update_pinar_booking_table") )
{
	function ravis_fn_update_pinar_booking_table ($post_id) {
		global $post, $wpdb;

		$post_type  = get_post_type( $post_id );
		$table_name = $wpdb->prefix . 'ravis_booking';
	    if($post_type == 'booking')
	    {
	    	$wpdb->delete( $table_name, array( 'booking_id' => $post_id ), array( '%d' ) );
	    }
	}
	add_action('wp_trash_post', 'ravis_fn_update_pinar_booking_table');
}