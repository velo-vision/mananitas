<?php

/**
 * ------------------------------------------------------------------------------------------
 * Booking Details Meta box file
 * ------------------------------------------------------------------------------------------
 */
class Ravis_booking_price_meta_box
{
	/**
	 * Array of meta data list for the block dates
	 * @var array
	 */
	public $booking_price_meta_fields = array();

	function __construct()
	{
		Ravis_Booking_main::load_plugin_text_domain();

		add_action('add_meta_boxes', array($this, 'add_booking_price_meta_box'));
		add_action('save_post', array($this, 'save_booking_price_meta'));
		add_action('init', array($this, 'init'));

	}

	/**
	 * Init function for generating $booking_price_meta_fields
	 * @return array list of metadata
	 */
	function init()
	{
		$prefix = 'pinar_booking_';

		/**
		 * Generate the Query for getting the posts
		 * @var array $args
		 */
		$args               = array(
			'post_type'   => 'packages',
			'post_status' => 'publish',
			'order'       => 'DESC',
			'orderby'     => 'date',
			'nopaging'    => true,
		);
		$pinar_package_list = new WP_Query($args);

		/**
		 * Loading post for making the package_list
		 */
		if ($pinar_package_list->have_posts()) {
			global $post;
			// Field Array
			/**
			 * Loop for getting post data
			 */
			while ($pinar_package_list->have_posts()) {
				$pinar_package_list->the_post();
				$pinar_package_list_items[] = array(
					'label' => get_the_title(),
					'value' => get_the_id(),
					'price' => get_post_meta(get_the_id(), 'package_price', true),
				);
			}
			$pinar_package_list_items[] = array(
				'label' => esc_html__("No Package", 'ravis'),
				'value' => '-',
				'price' => '0',
			);
		}

		$this->booking_price_meta_fields = array(
			array(
				'label'   => esc_html__('Package List', 'ravis'),
				'desc'    => esc_html__("Select the package.", 'ravis'),
				'id'      => $prefix . 'package',
				'type'    => 'radio',
				'options' => (isset($pinar_package_list_items) ? $pinar_package_list_items : ''),
			),
			array(
				'label' => esc_html__('Total Price', 'ravis'),
				'id'    => $prefix . 'total_price',
				'type'  => 'show',
			)
		);

		wp_reset_postdata();
	}

	// Add the Meta Box
	function add_booking_price_meta_box()
	{
		add_meta_box(
			'booking_price_meta_box', // $id
			esc_html__("Booking Price Details", 'ravis'), // $title
			array($this, 'show_booking_price_meta_box'), // $callback
			'booking', // $page
			'side', // $context
			'low'); // $priority
	}


	// Show the Fields in the Post Type section
	function show_booking_price_meta_box()
	{
		global $post, $wpdb, $pinar_opt;
		$past_booking         = null;
		$current_time_stamp   = time();
		$pinar_check_out_date = get_post_meta($post->ID, 'pinar_booking_check_out', true);

		if ($pinar_check_out_date < $current_time_stamp) {
			$past_booking = true;
		}


		$price_unit = !empty($pinar_opt['pinar-booking-currency']) ? ravis_currency_converter($pinar_opt['pinar-booking-currency']) : '&#36;';

		// Select booking items and their info
		$total_price       = 0;
		$table_name        = $wpdb->prefix . 'ravis_booking';
		$booking_items     = $wpdb->get_results("SELECT * FROM $table_name WHERE booking_id=$post->ID ");
		$booking_check_in  = get_post_meta($post->ID, 'pinar_booking_check_in') != NULL ? intval(get_post_meta($post->ID, 'pinar_booking_check_in', true)) : '';
		$booking_check_out = get_post_meta($post->ID, 'pinar_booking_check_out') != NULL ? intval(get_post_meta($post->ID, 'pinar_booking_check_out', true)) : '';
		$booking_season    = get_post_meta($post->ID, 'pinar_booking_season') != NULL ? intval(get_post_meta($post->ID, 'pinar_booking_season', true)) : '';

		$booking_duration = ($booking_check_out - $booking_check_in) / 86400;

		foreach ($booking_items as $booking_item) {
			$room_price = intval(get_post_meta($booking_item->room_id, 'rooms_price', true));
			$item_price = ravis_fn_price_value($room_price, true, $booking_season);
			$total_price += $booking_duration * $item_price;
		}

		$selected_package_id = (get_post_meta($post->ID, 'pinar_booking_package', true) !== null ? get_post_meta($post->ID, 'pinar_booking_package', true) : '');
		if (isset($selected_package_id) and $selected_package_id != '') {
			$selected_package_price = intval(get_post_meta($selected_package_id, 'package_price', true));
			$total_price += ($selected_package_price * $booking_duration);

		}

		// Use nonce for verification
		echo '<input type="hidden" name="booking_price_meta_box_nonce" value="' . esc_attr(wp_create_nonce(basename(__FILE__))) . '" />';

		// Begin the field table and loop
		echo '<table class="form-table">';
		foreach ($this->booking_price_meta_fields as $field) {
			// get value of this field if it exists for this post
			$meta = get_post_meta($post->ID, $field['id'], true);

			// begin a table row with
			echo '<tr>
    	                <td>
                            <h4>' . esc_html($field['label']) . '</h4>';
			switch ($field['type']) {
				// radio
				case 'radio':
					if ($field['options'] != '') {
						if (!$past_booking) {
							foreach ($field['options'] as $option) {
									echo '<input type="radio" name="' . esc_attr($field['id']) . '" id="' . esc_attr($option['value']) . '" value="' . esc_attr($option['value']) . '" ', $meta == $option['value'] || ( $meta == 0 && $option['value'] == '-' ) ? esc_attr(' checked="checked"') : '', ' />
                                            <label for="' . esc_attr($option['value']) . '">' . esc_html($option['label']) . ' ( <b>' . esc_html($price_unit . $option['price']) . '</b> / ' . esc_html__("per night", 'ravis') . ' )</label><br />';
							}
						} else {
							foreach ($field['options'] as $option) {
								echo $meta == $option['value'] ? esc_html($option['label']) . ' ( <b>' . esc_html($price_unit . $option['price']) . '</b> / ' . esc_html__("per night", 'ravis') . ' )' : '';
							}
						}
					}
					break;
				// Show
				case 'show':
					echo '<h2>' . esc_html($price_unit . number_format($total_price)) . '</h2>';
					break;

			} //end switch
			echo '</td></tr>';
		} // end foreach
		echo '</table>'; // end table
	}

	// Save the Data
	function save_booking_price_meta($post_id)
	{
		$security_code = '';

		if (isset($_POST['booking_price_meta_box_nonce']) && $_POST['booking_price_meta_box_nonce'] != '') {
			$security_code = sanitize_text_field($_POST['booking_price_meta_box_nonce']);
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

		// loop through fields and save the data
		foreach ($this->booking_price_meta_fields as $field) {
			$old = get_post_meta($post_id, $field['id'], true);
			$new = $_POST[ $field['id'] ];
			if ($new && $new != $old) {
				update_post_meta($post_id, $field['id'], $new);
			} elseif ('' == $new && $old) {
				delete_post_meta($post_id, $field['id'], $old);
			}
		} // end foreach
	}

}

$booking_price_meta_box_obj = new Ravis_booking_price_meta_box;