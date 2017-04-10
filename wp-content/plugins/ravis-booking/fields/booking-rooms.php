<?php

/**
 * ------------------------------------------------------------------------------------------
 * Booking Rooms Meta box file
 * ------------------------------------------------------------------------------------------
 */
class Ravis_booking_rooms_meta_box
{
	/**
	 * Array of meta data list for the block dates
	 * @var array
	 */
	public $booking_rooms_meta_fields = array();

	function __construct()
	{
		Ravis_Booking_main::load_plugin_text_domain();
		// Field Array
		$prefix                          = 'booking_rooms_';
		$this->booking_rooms_meta_fields = array(
			array(
				'label' => esc_html__('Choose the room', 'ravis'),
				'desc'  => esc_html__('Choose the room for this booking', 'ravis'),
				'id'    => $prefix . 'room',
				'type'  => 'link'
			)
		);

		add_action('add_meta_boxes', array($this, 'add_booking_rooms_meta_box'));
		add_action('admin_head', array($this, 'booking_rooms_box'));
		add_action('save_post', array($this, 'save_booking_rooms_meta'));
	}

	// Add the Meta Box
	function add_booking_rooms_meta_box()
	{
		add_meta_box(
			'booking_rooms_meta_box', // $id
			esc_html__('Choose Room', 'ravis'), // $title
			array($this, 'show_booking_rooms_meta_box'), // $callback
			'booking', // $page
			'normal', // $context
			'high'); // $priority
	}


	// Show the Fields in the Post Type section
	function show_booking_rooms_meta_box()
	{
		global $post, $wpdb;
		$past_booking         = null;
		$current_time_stamp   = time();
		$pinar_check_out_date = get_post_meta($post->ID, 'pinar_booking_check_out', true);

		if ($pinar_check_out_date < $current_time_stamp) {
			$past_booking = true;
		}

		$table_name = $wpdb->prefix . 'ravis_booking';
		// Use nonce for verification
		echo '<input type="hidden" name="booking_rooms_meta_box_nonce" value="' . esc_attr(wp_create_nonce(basename(__FILE__))) . '" />';

		// Begin the field table and loop
		echo '<table class="form-table">';
		foreach ($this->booking_rooms_meta_fields as $field) {
			// get value of this field if it exists for this post
			$meta = get_post_meta($post->ID, $field['id'], true);
			// begin a table row with
			echo '<tr>
		                <td>
		                	<div id="add_room_container">';

			$wpdb->delete($table_name, array('booking_id' => $post->ID, 'status' => 1));

			$selected_room_info = $wpdb->get_results("SELECT * FROM " . $table_name . " WHERE booking_id=" . $post->ID . " AND status=2");
			$saved_rooms        = '';
			foreach ($selected_room_info as $select_room_info) {

				$booked_room_title = $wpdb->get_results("SELECT post_title FROM " . $wpdb->prefix . "posts WHERE ID=" . $select_room_info->room_id);

				$saved_rooms .= $select_room_info->id . ',';
				echo '
								<div class="dynamic-room booked">
					                <div class="rooms-container room_select">
					                	<label for="select-room">' . esc_html__("Room Title", 'ravis') . '</label>
					                	<input type="text"size="15" name="booked_rooms_' . esc_attr($select_room_info->id) . '[room]" value="' . esc_attr($booked_room_title[0]->post_title) . '" disabled />
					                </div>
					                <div class="rooms-container adult-select">
					                	<label for="adult-guest">' . esc_html__("Adult Guests", 'ravis') . '</label>
					                	<input type="text"size="15" name="booked_rooms_' . esc_attr($select_room_info->id) . '[adult]" value="' . esc_attr($select_room_info->adult) . '" disabled />
					                </div>
					                <div class="rooms-container children-select">
					                	<label for="child-guest">' . esc_html__("Children Guests", 'ravis') . '</label>
					                	<input type="text"size="15" name="booked_rooms_' . esc_attr($select_room_info->id) . '[child]" value="' . esc_attr($select_room_info->child) . '" disabled />
					                </div>';
				if (!$past_booking) {
					echo '
									<div class="rooms-container btn-container">
					                	<button class="remove-room old button" data-room=' . esc_attr($select_room_info->id) . '>' . esc_html__("Remove", 'ravis') . '</button>
					                </div>
								';
				}

				echo '</div>';
			}

			switch ($field['type']) {
				// Link
				case 'link':
					if (!$past_booking) {
						echo '<div id="add_room_container"></div><button id="add_room_booking" class="button-primary">' . esc_html__('Add a room', 'ravis') . '</button>';
					}
					break;
			} //end switch
			echo '<input type="hidden" name="booking_saved_rooms" id="booking_saved_rooms" value="' . esc_attr(trim($saved_rooms, ',')) . '" />
		        	</div></td></tr>';
		} // end foreach
		echo '</table>'; // end table
	}

	// Save the Data
	function save_booking_rooms_meta($post_id)
	{
		global $post, $wpdb;
		$security_code = '';

		if (isset($_POST['booking_rooms_meta_box_nonce']) && $_POST['booking_rooms_meta_box_nonce'] != '') {
			$security_code = sanitize_text_field($_POST['booking_rooms_meta_box_nonce']);
		}

		// verify nonce
		if (!wp_verify_nonce($security_code, basename(__FILE__)))
			return $post_id;
		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			return $post_id;
		// check permissions
		if ('booking' == $_POST['post_type']) {
			if (!current_user_can('edit_page', $post_id))
				return $post_id;
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
		}

		/**
		 * Insert the room's data in DB
		 * @var string $table_name
		 */
		$table_name = $wpdb->prefix . 'ravis_booking';
		foreach ($_POST as $key => $value) {
			$matches = preg_match('/booked_rooms_(\d)+/i', $key);
			if ($matches) {

				$wpdb->update(
					$table_name,
					array(
						'status' => 2,
					),
					array(
						'room_id'   => $_POST[ $key ]["room"],
						'check_in'  => (get_post_meta($post->ID, "pinar_booking_check_in") != null ? get_post_meta($post->ID, "pinar_booking_check_in", true) : ''),
						'check_out' => (get_post_meta($post->ID, "pinar_booking_check_out") != null ? get_post_meta($post->ID, "pinar_booking_check_out", true) : ''),
						'adult'     => $_POST[ $key ]["adult"]
					)
				);

				/**
				 * Create the array of inserted IDs
				 */
				$booking_arr_ids[] = $wpdb->insert_id;
			}
		}

		/**
		 * Create insterted ID string
		 */
		if ($booking_arr_ids) {
			foreach ($booking_arr_ids as $booking_id) {
				$booking_id_list .= $booking_id . ',';
			}
		}

		/**
		 * Compare the rooms id with the saved ids in DB and remove the deleted rooms
		 */
		$new_save_booked_rooms     = str_replace(',,', ',', trim($_POST['booking_saved_rooms'], ','));
		$new_save_booked_rooms_arr = explode(',', $new_save_booked_rooms);
		$old_save_booked_rooms_arr = explode(',', get_post_meta($post_id, 'bookin_room', true));

		foreach ($old_save_booked_rooms_arr as $old_save_booked_room) {
			if (!in_array($old_save_booked_room, $new_save_booked_rooms_arr)) {
				$wpdb->delete($table_name, array('id' => $old_save_booked_room));
			}
		}

		/**
		 * Create new Room's id string to be saved in DB as post_data of the room
		 */
		if ($new_save_booked_rooms != '') {
			$booking_id_list = $new_save_booked_rooms . ',' . $booking_id_list;
		}

		update_post_meta($post_id, 'bookin_room', trim($booking_id_list, ','));
	}


	/**
	 * Booking Required js file
	 */
	function booking_rooms_box()
	{
		global $booking_rooms_meta_box, $post, $pinar_opt;
		$post_ID                 = isset($post->ID) ? $post->ID : '';
		$pinar_booking_check_in  = get_post_meta($post_ID, "pinar_booking_check_in") != NULL ? get_post_meta($post_ID, "pinar_booking_check_in") : '';
		$pinar_booking_check_out = get_post_meta($post_ID, "pinar_booking_check_out") != NULL ? get_post_meta($post_ID, "pinar_booking_check_out") : '';

		$pinar_booking_check_in  = $pinar_booking_check_in != NULL ? date("Y-m-d", $pinar_booking_check_in[0]) : '';
		$pinar_booking_check_out = $pinar_booking_check_out != NULL ? date("Y-m-d", $pinar_booking_check_out[0]) : '';

		/**
		 * Generating the room options
		 */
		$room_args       = array(
			'post_type'   => 'rooms',
			'post_status' => 'publish',
			'orderby'     => 'date',
			'order'       => 'DESC',
			'nopaging'    => true,
		);
		$room_options    = '<option value="">--------</option>';
		$adult_guests    = $child_guests = '';
		$room_list_query = get_posts($room_args);

		foreach ($room_list_query as $single_post) {
			$room_price = get_post_meta($single_post->ID, 'rooms_price', true);
			$room_options .= '<option value="' . esc_attr($single_post->ID) . '">' . esc_html($single_post->post_title) . ' (' . esc_html(ravis_fn_price_value($room_price)) . ')</option>';
		}

		for ($i = 0; $i < 7; $i++) {
			$adult_guests .= '<option value="' . esc_attr($i) . '">' . $i . '</option>';
			$child_guests .= '<option value="' . esc_attr($i) . '">' . $i . '</option>';
		}

		$output
			= '
	    	<script type="text/javascript">
	            jQuery(document).ready(function(){
	            	"use strict"
					jQuery.activeRoomDetails = function() {

				        jQuery("button.remove-room").on("click",function(event){
							event.preventDefault();
							var deleteConfirm = confirm("' . esc_js(esc_html__("Are you sure to remove this room?", 'ravis')) . '");
							if(deleteConfirm == true)
							{
								jQuery(this).parents(".dynamic-room").remove();

								var oldBookedRoom = jQuery("#booking_saved_rooms").val(),
									removedRoom   = (jQuery(this).data("room")).toString();
								jQuery("#booking_saved_rooms").val(oldBookedRoom.replace(removedRoom, ""));

								var data = {
									action: "ajax_db_func",
									bookingID: removedRoom
								};
								jQuery.post("' . esc_js(admin_url()) . 'admin-ajax.php", data);
							}
						});

						jQuery("button.check-availability").on("click", function(e){
							e.preventDefault();
							
							var parentDynamicRoom 	= jQuery(this).parents(".dynamic-room"),
								checkInDate 		= ' . (!empty($pinar_booking_check_in) ? '"' . esc_js($pinar_booking_check_in) . '"' : balancetags('jQuery("#pinar_booking_check_in").val()')) . ',
								checkOutDate 		= ' . (!empty($pinar_booking_check_out) ? '"' . esc_js($pinar_booking_check_out) . '"' : balancetags('jQuery("#pinar_booking_check_out").val()')) . ',
								newRoomID 			= parentDynamicRoom.find(".room_select select").val(),
								adultGuest 			= parentDynamicRoom.find(".adult-select select").val(),
								childGuest 			= parentDynamicRoom.find(".children-select select").val(),
								bookingID 			= ' . esc_js($post_ID) . '
							
							if(newRoomID == "")
							{
								alert("' . esc_js(esc_html__("You forgot to add the room, please add room.", 'ravis')) . '");
								return false;
							}
							if(adultGuest == "" || adultGuest == 0)
							{
								alert("' . esc_js(esc_html__("Please add how many guest we have!", 'ravis')) . '");
								return false;
							} 
							parentDynamicRoom.find(".status_message").html(\'<img src="../../wp-includes/images/spinner.gif" />\');
							var data = {
								action: "check_availability",
								checkIn: checkInDate,
								checkOut: checkOutDate,
								newRoomID: newRoomID,
								adultGuest: adultGuest,
								childGuest: childGuest,
								bookingID: bookingID
							};
							jQuery.post("' . esc_js(admin_url()) . 'admin-ajax.php", data, function(data){
								var returnData = JSON.parse(jQuery.trim(data));
								if(returnData.status == true)
								{
									parentDynamicRoom.find(".remove-room").attr("data-room", returnData.insert_id);
									parentDynamicRoom.removeClass("pending filled").addClass("available").find(".status_message").html("' . esc_js(esc_html__("This room is available.", 'ravis')) . '");
								}
								if(returnData.status == false)
								{
									parentDynamicRoom.removeClass("available").addClass("filled").find(".status_message").html(returnData.message);
								}
							});
						});

				    	jQuery(".datepicker.check-in").datepicker({ 
				    		dateFormat: "yy-mm-d",
				    		minDate: 0,
				    		onClose: function( selectedDate ) {
						        jQuery( ".datepicker.check-out" ).datepicker( "option", "minDate", selectedDate );
						    }
				    	});
						jQuery(".datepicker.check-out").datepicker({ 
				    		dateFormat: "yy-mm-d",
				    		minDate: 0,
				    		onClose: function( selectedDate ) {
						        jQuery( ".datepicker.check-in" ).datepicker( "option", "maxDate", selectedDate );
						    }
				    	});
				    }
				    jQuery.activeRoomDetails();
					var roomID = 0;
					jQuery("#add_room_booking").on("click",function(e){
						++roomID;
						var booking_add_room_box = \'<div class="dynamic-room pending"><div class="rooms-container room_select"><label for="select-room">' . esc_js(esc_html__("Select room *", 'ravis')) . '</label><select name="booked_rooms_\'+ roomID +\'[room]" required>' . balancetags($room_options) . '</select></div><div class="rooms-container adult-select"><label for="adult-guest">' . esc_js(esc_html__("Adult *", 'ravis')) . '</label><select name="booked_rooms_\'+ roomID +\'[adult]" required>' . balancetags($adult_guests) . '</select></div><div class="rooms-container children-select"><label for="child-guest">' . esc_js(esc_html__("Children", 'ravis')) . '</label><select name="booked_rooms_\'+ roomID +\'[child]">' . balancetags($child_guests) . '</select></div><div class="rooms-container btn-container"><button class="check-availability button">' . esc_js(esc_html__("Check Availability", 'ravis')) . '</button><button class="remove-room button">' . esc_js(esc_html__("Remove", 'ravis')) . '</button><span class="status_message"></span></div></div>\';
						e.preventDefault();
						jQuery("#add_room_container").append(booking_add_room_box);
						jQuery.activeRoomDetails();
					});
					jQuery(".post-type-booking form").on("submit",function(){
						window.noConfirmed = 0;
						jQuery(this).parsley();						
						if((jQuery(body).hasClass("post-php") || jQuery(body).hasClass("post-new-php") ) && jQuery(".dynamic-room").length == 0 )
						{
							alert("' . esc_js(esc_html__("You forgot to add the room, please add room.", 'ravis')) . '");
							return false;
						}
						jQuery(".dynamic-room").each(function(){
							if( jQuery(this).hasClass("filled") && !jQuery(this).hasClass("booked") )
							{
								noConfirmed = 1;
								alert("' . esc_js(esc_html__("Please choose available room.", 'ravis')) . '");
								return false;
							}
							if( jQuery(this).hasClass("pending") )
							{
								noConfirmed = 1;
								alert("' . esc_js(esc_html__("Please check availability of you room.", 'ravis')) . '");
								return false;
							}
						})
						if(noConfirmed == 1)
						{
							return false;
						}
					});
					
				});


	        </script>';
		echo balancetags($output);
	}

}

$booking_rooms_meta_box_obj = new Ravis_booking_rooms_meta_box;
