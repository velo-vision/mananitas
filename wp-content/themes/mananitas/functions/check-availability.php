<?php 
if(!function_exists('ravis_fn_pinar_check_availability'))
{
	function ravis_fn_pinar_check_availability()
	{
		global $wpdb, $post;

		$check_in_date  = (isset($_POST['checkIn']) ? strtotime($_POST['checkIn']) : '' );
		$check_out_date = (isset($_POST['checkOut']) ? strtotime($_POST['checkOut']) : '' );
		$booking_id     = (isset($_POST['bookingID']) ? intval($_POST['bookingID']) : '' );
		$room_id        = (isset($_POST['newRoomID']) ? intval($_POST['newRoomID']) : '' );
		$adult_guest	= (isset($_POST['adultGuest']) ? intval($_POST['adultGuest']) : '' );
		$child_guest	= (isset($_POST['childGuest']) ? intval($_POST['childGuest']) : '' );
		$total_guest	= intval($adult_guest + $child_guest);

		$table_name     = $wpdb->prefix . 'ravis_booking';
		if( isset($check_in_date) and isset($check_out_date) and isset($room_id) and isset($adult_guest) and isset($booking_id))
		{

			$room_capacity = (string)get_post_meta( $room_id , 'rooms_max_guest', true);
			$room_count = (string)get_post_meta( $room_id , 'rooms_count', true);

			if( $total_guest > $room_capacity )
			{
				$result['status'] = false;
				$result['message'] = esc_html__( "Count of guests are more than the room's capacity.", 'pinar');
				echo json_encode($result);
			}
			else{
				/**
				 * Check the previous booking data
				 */
				$affected_booking = $wpdb->get_row(
										$wpdb->prepare("
											SELECT * FROM  $table_name
											WHERE
											    (
											    	(check_in <= %d AND check_out > %d)
												    OR
												    (check_in >= %d AND check_in < %d)
												)
											    AND room_id = %d
											",
											array(
												$check_in_date,
												$check_in_date,
												$check_in_date,
												$check_out_date,
												$room_id
											)
										)
									);
				$affected_rows_number = $wpdb->num_rows;
				/**
				 * Check the block dates
				 */
				$args = array(
				    'post_type'   => 'block_dates',
				    'post_status' => 'publish',
				    'order'       => 'DESC',
				    'orderby'     => 'date',
				    'nopaging'    => true,
				);
				$pinar_block_dates_list  = new WP_Query( $args );

				/**
				 * Loading post for making the services_list
				 */
				$in_blocked_dates = false;
				if ( $pinar_block_dates_list->have_posts() ) 
				{
				    global $post;
				    /**
				     * Loop for getting post data
				     */
				    $in_blocked_dates = '';
				    while ( $pinar_block_dates_list->have_posts() )
				    {
				        $pinar_block_dates_list->the_post();

						$from_date       = get_post_meta( get_the_id(), 'block_dates_from', true);
						$to_date         = get_post_meta( get_the_id(), 'block_dates_to', true);
						$block_rooms_ids = get_post_meta( get_the_id(), 'block_dates_blocked_rooms', true);

						if( 
							( 
								( $check_in_date >= $from_date && $check_in_date <= $to_date ) || 
								( $from_date >= $check_in_date && $from_date <= $check_out_date )
							) && 
							( in_array($room_id, $block_rooms_ids) ) 
						)
						{
							$in_blocked_dates = true;
						}
				    }
				}

				if($in_blocked_dates)
				{
					$result['status']  = false;
					$result['message'] = esc_html__("This room is NOT available.", 'pinar');
					echo json_encode($result);
				}
				elseif( isset($affected_booking)  && ( $affected_rows_number >= $room_count   )  )
				{
					$result['status']  = false;
					$result['message'] = esc_html__("This room is NOT available.", 'pinar');
					echo json_encode($result);
				}
				else
				{
					$wpdb->insert( 
						$table_name, 
						array( 
							'booking_id' => $booking_id,
							'room_id'    => $room_id,
							'check_in'   => $check_in_date,
							'check_out'  => $check_out_date,
							'adult'      => $adult_guest,
							'child'      => $child_guest,
						),
						array(
							'%d',
							'%d',
							'%d',
							'%d',
							'%d',
							'%d'
						)
					);
					$result['status']    = true;
					$result['insert_id'] = $wpdb->insert_id;
					echo  json_encode($result);
				}
			}			 
		}
		die();
	}	
}
add_action('wp_ajax_nopriv_check_availability', 'ravis_fn_pinar_check_availability');
add_action('wp_ajax_check_availability', 'ravis_fn_pinar_check_availability');


/**
 * ------------------------------------------------------------------------------------------
 * 22.1 - DB ajax operation function 
 * ------------------------------------------------------------------------------------------
 */

if(!function_exists('pinar_ajax_db_functions'))
{
	function pinar_ajax_db_functions()
	{
		global $wpdb;

		$booking_id     = intval($_POST['bookingID']);
		$table_name     = $wpdb->prefix . 'ravis_booking';

		if($booking_id !== 0)
		{
			$wpdb->delete( $table_name, array( 'id' => $booking_id ), array( '%d' ) );
		}
	}	
}
add_action('wp_ajax_nopriv_ajax_db_func', 'pinar_ajax_db_functions');
add_action('wp_ajax_ajax_db_func', 'pinar_ajax_db_functions');