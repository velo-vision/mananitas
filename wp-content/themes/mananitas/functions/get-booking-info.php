<?php
if(!function_exists('ravis_get_booking_info_fn'))
{
	function ravis_get_booking_info_fn()
	{
		global $wpdb, $post;

		$start_date     = intval($_POST['start']);
		$end_date       = intval($_POST['end']);
		
		// Get the Booking items
		$table_name     = $wpdb->prefix . 'ravis_booking';
		$booking_result = $wpdb->get_results(
								$wpdb->prepare("
									SELECT * FROM  $table_name 
									WHERE check_in >= %d
									AND check_in <= %d
									AND confirmed = %d 
									",
									array(
										$start_date,
										$end_date,
										1
									)
								)
							);
		if(!empty($booking_result))
		{
			foreach ($booking_result as $booking_item)
			{
				$room_details    = get_post( $booking_item->room_id );
				
				$result[] = array(
					'title' => $room_details->post_title.' - '.esc_html__('Booking ID', 'pinar').': '.$booking_item->booking_id,
					'start' => date("Y-m-d", $booking_item->check_in),
					'end'   => date("Y-m-d", $booking_item->check_out),
					'url'   => esc_url( admin_url() ).'post.php?post='.$booking_item->booking_id.'&action=edit'
				);
			}
		}

		// Get the block dates
		$args = array(
		    'post_type'   => 'block_dates',
		    'post_status' => 'publish',
		    'order'       => 'DESC',
		    'orderby'     => 'date',
		    'nopaging'    => true,
		);
		$pinar_block_dates_list  = new WP_Query( $args );
		if ( $pinar_block_dates_list->have_posts() ) 
		{
		    global $post;
		    $block_dates_arr_str ='';
		    /**
		     * Loop for getting post data
		     */
		    while ( $pinar_block_dates_list->have_posts() )
		    {
		        $pinar_block_dates_list->the_post();
		        $from_date       = get_post_meta( get_the_id(), 'block_dates_from', true);
				$to_date         = get_post_meta( get_the_id(), 'block_dates_to', true);
				$result[] = array(
					'title'     => get_the_title(),
					'start'     => date("Y-m-d", $from_date),
					'end'       => date("Y-m-d", $to_date),
					'url'		=> '',
					'rendering' => 'background',
					'color'     => '#ff9f89'
				);
		    }
		    echo rtrim( $block_dates_arr_str, ',');
		}

		// Return the result
		echo json_encode($result);
		die();
	}	
}
add_action('wp_ajax_nopriv_ravis_get_booking_info', 'ravis_get_booking_info_fn');
add_action('wp_ajax_ravis_get_booking_info', 'ravis_get_booking_info_fn');