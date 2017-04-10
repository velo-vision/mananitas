<?php

if (!function_exists('ravis_fn_pinar_booking_form_func')) {
	function ravis_fn_pinar_booking_form_func()
	{
		global $wpdb, $post, $pinar_opt, $current_season;

		$check_in_date  = isset($_POST['checkIn']) ? strtotime($_POST['checkIn']) : '';
		$check_out_date = isset($_POST['checkOut']) ? strtotime($_POST['checkOut']) : '';
		$adult_guest    = isset($_POST['adultGuest']) ? intval($_POST['adultGuest']) : '';
		$child_guest    = isset($_POST['childGuest']) ? intval($_POST['childGuest']) : '';
		$package_id     = isset($_POST['packageID']) ? intval($_POST['packageID']) : '';
		$package_price  = ($package_id !== 0 ? get_post_meta($package_id, 'package_price', true) : 0);
		$total_guest    = intval($adult_guest + $child_guest);
		$step           = intval($_POST['step']);
		$selectedItems  = isset($_POST['selectedItems']) ? trim($_POST['selectedItems'], '/-/') : '';
		$reservInfo     = isset($_COOKIE['reserved_info_cookie']) ? $_COOKIE['reserved_info_cookie'] : '';
		$price_unit     = !empty($pinar_opt['pinar-booking-currency']) ? ravis_currency_converter($pinar_opt['pinar-booking-currency']) : '&#36;';

		$firstName          = isset($_POST['firstName']) ? trim($_POST['firstName']) : '';
		$lastName           = isset($_POST['lastName']) ? trim($_POST['lastName']) : '';
		$email              = isset($_POST['email']) ? trim($_POST['email']) : '';
		$tel                = isset($_POST['tel']) ? trim($_POST['tel']) : '';
		$city               = isset($_POST['city']) ? trim($_POST['city']) : '';
		$address            = isset($_POST['address']) ? trim($_POST['address']) : '';
		$specialRequirement = isset($_POST['specialRequirement']) ? trim($_POST['specialRequirement']) : '';
		$captcha            = isset($_POST['captcha']) ? trim($_POST['captcha']) : '';

		$html = '';
		if (isset($step) && $step != 0) {
			switch ($step) {
				case 2:
					// Create captcha for the form
					$captcha_instance                   = new ReallySimpleCaptcha();
					$captcha_instance->fg               = array(197, 164, 109);
					$captcha_instance->file_mode        = 0755;
					$captcha_instance->answer_file_mode = 0755;
					$word                               = $captcha_instance->generate_random_word();
					$prefix                             = mt_rand();
					$captcha_img                        = $captcha_instance->generate_image($prefix, $word);
					$captcha_temp_dir                   = plugin_dir_url($captcha_instance->tmp_dir) . 'tmp/';
					if (isset($_COOKIE['captcha_prefix'])) {
						unset($_COOKIE['captcha_prefix']);
					}
					setcookie('captcha_prefix', $prefix, time() + 3600);

					$reservInfo_part = explode(',,,', $reservInfo);
					$selected_rooms  = explode('/-/', $selectedItems);

					// Calculate the booking duration ( night )
					$booking_duration = ($reservInfo_part[2] - $reservInfo_part[1]) / 86400;
					$total_price      = '';

					setcookie('reserved_info_cookie', $reservInfo . ',,,' . $selectedItems, time() + 3600);


					echo '
						<div class="loader"></div>
						<div class="error-message-box"></div>
						<div class="fadeInUp clearfix" id="booking-reservation">
							<input type="hidden" id="step" value="3">
							<div class="reservation-summary col-md-4">
								<h4>' . ravis_fn_title_effect(esc_html__('Reservation Summary', 'pinar')) . '</h4>
								<div class="info-boxes">
									<div class="title"><span>' . ravis_fn_title_effect(esc_html__('Reservation Info', 'pinar')) . '</span></div>
									<ul>
										<li>
											<div class="info">' . esc_html__('Check in :', 'pinar') . '</div>
											<div class="value">' . date('Y-m-d', intval($reservInfo_part[1])) . '</div>
										</li>
										<li>
											<div class="info">' . esc_html__('Check out :', 'pinar') . '</div>
											<div class="value">' . date('Y-m-d', intval($reservInfo_part[2])) . '</div>
										</li>
										<li>
											<div class="info">' . esc_html__('Adult :', 'pinar') . '</div>
											<div class="value">' . intval($reservInfo_part[3]) . '</div>
										</li>
										<li>
											<div class="info">' . esc_html__('Child :', 'pinar') . '</div>
											<div class="value">' . intval($reservInfo_part[4]) . '</div>
										</li>
									</ul>
									<div class="title"><span>' . ravis_fn_title_effect(esc_html__('Room Info', 'pinar')) . '</span></div>
									<ul>';
					foreach ($selected_rooms as $select_room_id) {
						$root_title  = get_post($select_room_id)->post_title;
						$rooms_price = get_post_meta($select_room_id, 'rooms_price', true);
						$total_price += ($booking_duration * ravis_fn_price_value($rooms_price, true));
						echo '
											<li>
												<div class="info">' . esc_html($root_title) . '</div>
												<div class="value">' . esc_html(ravis_fn_price_value($rooms_price)) . '</div>
											</li>

											';
					}
					if ($reservInfo_part[0] != 0) {
						echo '
											<li>
												<div class="info">' . esc_html__('Extra Packages', 'pinar') . ' : ' . get_the_title($reservInfo_part[0]) . '</div>
												<div class="value">' . esc_html($price_unit) . number_format(get_post_meta($reservInfo_part[0], 'package_price', true)) . '</div>
											</li>
											';
					}
					echo '
									</ul>
									<div class="total-cost">
										<div class="info">' . esc_html__('Total Cost :', 'pinar') . '</div>
										<div class="value">' . esc_html($price_unit) . number_format($total_price + (get_post_meta($reservInfo_part[0], 'package_price', true) * $booking_duration)) . '</div>
									</div>
								</div>
							</div>
							<div class="reservation-info col-md-8">
								<h4>' . ravis_fn_title_effect(esc_html__('Reservation Info', 'pinar')) . '</h4>
								<div class="col-md-6">
									<div class="field-container">
			                            <input type="text" placeholder="' . esc_html__('First Name *', 'pinar') . '" class="first-name">
			                        </div>
			                        <div class="field-container">
			                            <input type="text" placeholder="' . esc_html__('Last Name *', 'pinar') . '" class="last-name">
			                        </div>
			                        <div class="field-container">
			                            <input type="email" placeholder="' . esc_html__('Email *', 'pinar') . '" class="email">
			                        </div>
			                        <div class="field-container">
			                            <input type="text" placeholder="' . esc_html__('Phone *', 'pinar') . '" class="tel">
			                        </div>
			                        <div class="field-container">
			                            <input type="text" placeholder="' . esc_html__('City', 'pinar') . '" class="city">
			                        </div>
			                        <div class="field-container">
			                            <input type="text" placeholder="' . esc_html__('Address', 'pinar') . '" class="address">
			                        </div>
								</div>
								<div class="col-md-6">
									<div class="field-container message-field">
				                        <textarea id="message-field" placeholder="' . esc_html__('Special Requirements', 'pinar') . '" class="special-requirement"></textarea>
				                    </div>
				                    <div class="field-container captcha-container clearfix">
			                            <input type="text" placeholder="' . esc_html__('Enter the Code *', 'pinar') . '" class="captcha">
			                            <img src="' . esc_attr($captcha_temp_dir . $captcha_img) . '">
			                        </div>
									<div class="field-container btn-field">
				                    	<input type="submit" class="btn btn-default submit-booking-butt" value="' . esc_html__('Submit', 'pinar') . '">
				                    </div>
								</div>
							</div>
						</div>							

	                    <script type="text/javascript">
				                function IsEmail(email) {
									var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
									return regex.test(email);
								}
							    jQuery(document).ready(function(){
						            "use strict";

									//Confirm the guest info
									jQuery(".submit-booking-butt").on("click", function(e){
										e.preventDefault();
										var guestInfoForm 	   = jQuery("#booking-reservation"),
											step               = jQuery("#step").val(),
											tabContentMainBox  = jQuery("#booking-tab-contents"),
											firstName          = guestInfoForm.find(".first-name").val(),
											lastName           = guestInfoForm.find(".last-name").val(),
											email              = guestInfoForm.find(".email").val(),
											tel                = guestInfoForm.find(".tel").val(),
											city               = guestInfoForm.find(".city").val(),
											address            = guestInfoForm.find(".address").val(),
											specialRequirement = guestInfoForm.find(".special-requirement").val(),
											captcha 		   = guestInfoForm.find(".captcha").val(),
											errorBox 		   = tabContentMainBox.find(".error-message-box").hide(),
											errorMessage	   = "";

										if( firstName =="" || lastName == "" || tel =="" || email =="" || captcha =="" )
										{
											errorMessage += "' . esc_html__("Please fill required ", 'pinar') . '";
										}
										else if ( IsEmail(email) == false ) {
											errorMessage += "' . esc_html__("Please add a valid email", 'pinar') . '";
								        }
								        if(errorMessage !=="")
								        {
								        	errorBox.show().addClass("active alert alert-danger").html(errorMessage);
								        	return false;
								        }

										tabContentMainBox.addClass("loading");

										var data = {
											action: "booking_form",
											step: step,
											firstName: firstName,
											lastName: lastName,
											email: email,
											tel: tel,
											city: city,
											address: address,
											specialRequirement: specialRequirement,
											captcha: captcha
										};
										jQuery.post("' . esc_url(admin_url()) . 'admin-ajax.php", data, function(data){
											tabContentMainBox.removeClass("loading");
											tabContentMainBox.html(data);
											jQuery("body,html").animate({
									            scrollTop: tabContentMainBox.offset().top - 100
									        }, 1000);
											var currentStep = jQuery("#booking-tab-contents #step").val(),
												bookinTabContainer  = jQuery("#booking-tabs");

											bookinTabContainer.find("li").removeClass("active");
											jQuery("#booking-tabs li:eq("+ (currentStep - 1) +")").addClass("active");	
										});
									});
							    });
							</script>
					';
					die();
					break;
				case 3:
					$captcha_instance = new ReallySimpleCaptcha();
					$captcha_prefix   = (isset($_COOKIE['captcha_prefix']) && $_COOKIE['captcha_prefix'] !== '' ? trim($_COOKIE['captcha_prefix']) : '');
					$captcha_status   = $captcha_instance->check($captcha_prefix, $captcha);

					if (isset($captcha_status) && $captcha_status === true) {
						$reserved_info_data = explode(',,,', $reservInfo);
						$selected_rooms     = explode('/-/', $selectedItems);

						/**
						 * insert a post in booking post_type
						 * @var array $post_info
						 */
						$post_info        = array(
							'post_title'  => $firstName . ' ' . $lastName . ' - ' . $tel,
							'post_type'   => 'booking',
							'post_status' => 'pending'
						);
						$inserted_post_id = wp_insert_post($post_info);

						/**
						 * update the post_meta of inserted booking post
						 * @var string $prefix "post meta prefix"
						 * @var array $post_meta_array "it contains post_meta IDs and their values"
						 */
						$prefix          = 'pinar_booking_';
						$post_meta_array = array(
							array(
								'id'    => $prefix . 'name',
								'value' => $firstName,
							),
							array(
								'id'    => $prefix . 'fname',
								'value' => $lastName,
							),
							array(
								'id'    => $prefix . 'email',
								'value' => $email,
							),
							array(
								'id'    => $prefix . 'phone',
								'value' => $tel,
							),
							array(
								'id'    => $prefix . 'city',
								'value' => $city,
							),
							array(
								'id'    => $prefix . 'address',
								'value' => $address,
							),
							array(
								'id'    => $prefix . 'special_requirements',
								'value' => $specialRequirement,
							),
							array(
								'id'    => $prefix . 'package',
								'value' => $reserved_info_data[0],
							),
							array(
								'id'    => $prefix . 'check_in',
								'value' => $reserved_info_data[1],
							),
							array(
								'id'    => $prefix . 'check_out',
								'value' => $reserved_info_data[2],
							),
							array(
								'id'    => $prefix . 'season',
								'value' => $current_season,
							)
						);

						// loop through fields and save the data
						foreach ($post_meta_array as $field) {
							update_post_meta($inserted_post_id, $field['id'], $field['value']);
						}

						/**
						 * insert booking info in ravis_booking table
						 */

						$table_name        = $wpdb->prefix . 'ravis_booking';
						$reserved_room_ids = explode('/-/', trim($reserved_info_data[5], '/-/'));
						$total_price       = 0;
						$room_list_li      = '';
						$room_list_box     = '<ul>';
						// insert a record for every reserved rooms
						foreach ($reserved_room_ids as $reserved_room_id) {
							$booking_data        = array(
								'booking_id' => $inserted_post_id,
								'check_in'   => $reserved_info_data[1],
								'check_out'  => $reserved_info_data[2],
								'adult'      => $reserved_info_data[3],
								'child'      => $reserved_info_data[4],
								'room_id'    => $reserved_room_id,
								'status'     => '2',
							);
							$booking_data_format = array(
								'%d',
								'%d',
								'%d',
								'%d',
								'%d',
								'%d',
								'%d'
							);

							$wpdb->insert($table_name, $booking_data, $booking_data_format);

							$booking_duration = ($reserved_info_data[2] - $reserved_info_data[1]) / 86400;
							$room_title       = get_post($reserved_room_id)->post_title;
							$rooms_price      = get_post_meta($reserved_room_id, 'rooms_price', true);
							$total_price 	 += ($booking_duration * ravis_fn_price_value($rooms_price, true));

							$room_list_li
								.= '
								<li>
									<div class="info">' . esc_html($room_title) . '</div>
									<div class="value">' . esc_html(ravis_fn_price_value($rooms_price)) . '</div>
								</li>';

							$room_list_box .= '<li>' . esc_html($room_title) . ' : ' . esc_html(ravis_fn_price_value($rooms_price)) .'</li>';
						}
						if ($reserved_info_data[0] != 0) {
							$package_id    = intval($reserved_info_data[0]);
							$package_price = get_post_meta($package_id, 'package_price', true);
							$room_list_li
								.= '
								<li>
									<div class="info">' . esc_html__('Extra Packages', 'pinar') . ' : ' . get_the_title($reserved_info_data[0]) . '</div>
									<div class="value">' . esc_html($price_unit) . number_format(get_post_meta($reserved_info_data[0], 'package_price', true)) . '</div>
								</li>';

							$room_list_box .= '<li>' . get_the_title($reserved_info_data[0]) . ' : ' . esc_html($price_unit) . number_format(get_post_meta($reserved_info_data[0], 'package_price', true)) .'</li>';
						}
						echo '
							<div class="fadeInUp clearfix" id="booking-confirmation">
								<input type="hidden" id="step" value="4">
			                    <h3>' . ravis_fn_title_effect(esc_html__("Reservation Complete!", 'pinar')) . '</h3>
			                    <div class="description">
			                    	' . (!empty($pinar_opt['pinar-booking-complete-text']) ? esc_html($pinar_opt['pinar-booking-complete-text']) : '') . '
			                    </div>
								
								<div class="reservation-summary col-md-4">
									<h4>' . ravis_fn_title_effect(esc_html__('Reservation Summary', 'pinar')) . '</h4>
									<div class="info-boxes">
										<div class="title"><span>' . ravis_fn_title_effect(esc_html__('Reservation Info', 'pinar')) . '</span></div>
										<ul>
											<li>
												<div class="info">' . esc_html__('Check in :', 'pinar') . '</div>
												<div class="value">' . date('Y-m-d', intval($reserved_info_data[1])) . '</div>
											</li>
											<li>
												<div class="info">' . esc_html__('Check out :', 'pinar') . '</div>
												<div class="value">' . date('Y-m-d', intval($reserved_info_data[2])) . '</div>
											</li>
											<li>
												<div class="info">' . esc_html__('Adult :', 'pinar') . '</div>
												<div class="value">' . intval($reserved_info_data[3]) . '</div>
											</li>
											<li>
												<div class="info">' . esc_html__('Child :', 'pinar') . '</div>
												<div class="value">' . intval($reserved_info_data[4]) . '</div>
											</li>
										</ul>
										<div class="title"><span>' . ravis_fn_title_effect(esc_html__('Room Info', 'pinar')) . '</span></div>
										<ul>
											' . balancetags($room_list_li) . '
										</ul>
										<div class="total-cost">
											<div class="info">' . esc_html__('Total Cost :', 'pinar') . '</div>
											<div class="value">' . esc_html($price_unit) . number_format($total_price + (get_post_meta($reserved_info_data[0], 'package_price', true) * $booking_duration)) . '</div>
										</div>
									</div>
								</div>
								<div class="reservation-info col-md-8">
									<h4>' . ravis_fn_title_effect(esc_html__('Reservation Info', 'pinar')) . '</h4>
									<div class="col-md-6">
										<ul>
											<li>
												<div class="info">' . esc_html__("First Name :", 'pinar') . '</div>
												<div class="value">' . esc_html($firstName) . '</div>
											</li>
											<li>
												<div class="info">' . esc_html__("Last Name :", 'pinar') . '</div>
												<div class="value">' . esc_html($lastName) . '</div>
											</li>
											<li>
												<div class="info">' . esc_html__("Email :", 'pinar') . '</div>
												<div class="value">' . esc_html($email) . '</div>
											</li>
											<li>
												<div class="info">' . esc_html__("Phone :", 'pinar') . '</div>
												<div class="value">' . esc_html($tel) . '</div>
											</li>
											<li>
												<div class="info">' . esc_html__("City :", 'pinar') . '</div>
												<div class="value">' . esc_html($city) . '</div>
											</li>
											<li>
												<div class="info">' . esc_html__("Address :", 'pinar') . '</div>
												<div class="value">' . esc_html($address) . '</div>
											</li>
										</ul>
									</div>
									<div class="col-md-6">
										<ul>
											<li>
												<div class="info">' . esc_html__("Special Requirements :", 'pinar') . '</div>
												<div class="value">' . esc_html($specialRequirement) . '</div>
											</li>
										</ul>
									</div>
								</div>
			                </div>
			                <script type="text/javascript">
								jQuery(document).ready(function(){
									var currentStep = jQuery("#booking-tab-contents #step").val(),
										bookinTabContainer  = jQuery("#booking-tabs");

									bookinTabContainer.find("li").removeClass("active");
									jQuery("#booking-tabs li:eq("+ (currentStep - 1) +")").addClass("active");	
								})
			                </script>
						';
						$captcha_instance->remove($captcha_prefix);
						unset($_COOKIE['captcha_prefix']);


						/**
						 * ------------------------------------------------------------------------------------------
						 * Send Notification Emails to the admins of website
						 * ------------------------------------------------------------------------------------------
						 */

						$edit_post_url = esc_url(admin_url()) . 'post.php?post=' . $inserted_post_id . '&action=edit';
						if (isset($pinar_opt['pinar-email-notification']) && $pinar_opt['pinar-email-notification'] == '1') {
							$email_sender        = (!empty($pinar_opt['pinar-email-sender']) ? $pinar_opt['pinar-email-sender'] : get_option('admin_email'));
							$multiple_recipients = (isset($pinar_opt['pinar-email-receiver']) ? $pinar_opt['pinar-email-receiver'] : '');
							$subj                = esc_html__('New Booking Information was  in your website. Booking ID : ', 'pinar') . $inserted_post_id;
							$headers             = "MIME-Version: 1.0" . "\r\n";
							$headers 			.= "Content-type:text/html;charset=UTF-8" . "\r\n";
							$headers 			.= 'From: "' . get_bloginfo('name') . '" <' . $email_sender . '>';
							$room_list_box 		.= '</ul>';

							$link_shortcodes   = array('[user-booking-url]', '[/user-booking-url]', '[guest-first-name]', '[guest-last-name]', '[guest-email]', '[guest-tel]', '[guest-city]', '[guest-address]', '[guest-special-requirement]', '[guest-check-in]', '[guest-check-out]', '[guest-adult]', '[guest-child]', '[guest-room-list]', '[guest-booking-total-price]');
							$link_replace_text = array('<a href="' . esc_url($edit_post_url) . '" target="_blank">', '</a>', $firstName, $lastName, $email, $tel, $city, $address, $specialRequirement, date('Y-m-d', intval($reserved_info_data[1])), date('Y-m-d', intval($reserved_info_data[2])), $reserved_info_data[3], $reserved_info_data[4], $room_list_box, $total_price);
							$body              = str_replace($link_shortcodes, $link_replace_text, $pinar_opt['pinar-admin-email-template']);

							if (!empty($multiple_recipients)) {
								foreach ($multiple_recipients as $receiver_email) {
									wp_mail($receiver_email, $subj, $body, $headers);
								}
							}
						}

						die();
						break;
					} else {
						echo '<div id="booking-confirmation"><h3>' . ravis_fn_title_effect(esc_html__("Wrong Security code, please try again!", 'pinar')) . '</h3></div>';
						$captcha_instance->remove($captcha_prefix);
						unset($_COOKIE['captcha_prefix']);
						die();
					}
				default:

					if (isset($check_in_date) and isset($check_out_date) and isset($adult_guest)) {
						$booking_duration = ($check_out_date - $check_in_date) / 86400;
						$table_name       = $wpdb->prefix . 'ravis_booking';
						$room_args        = array(
							'post_type'   => 'rooms',
							'post_status' => 'publish',
							'order'       => 'DESC',
							'orderby'     => 'date',
							'nopaging'    => true,
						);
						$pinar_room_list  = new WP_Query($room_args);
						$room_html        = '';

						if ($pinar_room_list->have_posts()) {
							while ($pinar_room_list->have_posts()) {
								$pinar_room_list->the_post();
								$room_id = get_the_id();

								$room_capacity = intval(get_post_meta($room_id, 'rooms_max_guest', true));
								$room_count    = (string)get_post_meta($room_id, 'rooms_count', true);
								$room_min_stay = intval(get_post_meta($room_id, 'rooms_min_stay', true));

								if ($total_guest > $room_capacity) {
									$result['status'] = false;
								} else {
									/**
									 * Check the previous booking data
									 */
									$affected_booking     = $wpdb->get_row(
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

										));
									$affected_rows_number = $wpdb->num_rows;

									$room_posts = $post;
									/**
									 * Check the block dates
									 */
									$args                   = array(
										'post_type'   => 'block_dates',
										'post_status' => 'publish',
										'order'       => 'DESC',
										'orderby'     => 'date',
										'nopaging'    => true,
									);
									$pinar_block_dates_list = new WP_Query($args);

									/**
									 * Loading post for making the services_list
									 */
									if ($pinar_block_dates_list->have_posts()) {
										global $post;
										/**
										 * Loop for getting post data
										 */
										$in_blocked_dates = '';
										while ($pinar_block_dates_list->have_posts()) {
											$pinar_block_dates_list->the_post();

											$from_date       = get_post_meta(get_the_id(), 'block_dates_from', true);
											$to_date         = get_post_meta(get_the_id(), 'block_dates_to', true);
											$block_rooms_ids = get_post_meta(get_the_id(), 'block_dates_blocked_rooms', true);

											if (!empty($block_rooms_ids)) {
												if (
													(
														($check_in_date >= $from_date && $check_in_date <= $to_date) ||
														($from_date >= $check_in_date && $from_date <= $check_out_date)
													) &&
													(in_array($room_id, $block_rooms_ids))
												) {
													$in_blocked_dates = true;
												}
											}
										}
									}
									wp_reset_postdata();
									$post = $room_posts;
									if (isset($in_blocked_dates) && $in_blocked_dates === true) {
										$result[ get_the_title() ] = false;
									} elseif (isset($affected_booking) && ($affected_rows_number >= $room_count)) {
										$result['status'] = false;
									} elseif ($booking_duration < $room_min_stay) {
										$result['status'] = false;
									} else {
										$post_id      = get_the_id();
										$thumb_size   = array('600', '400');
										$rooms_price  = get_post_meta($post_id, 'rooms_price', true);
										$rooms_desc   = get_post_meta($post_id, 'rooms_short_desc', true);
										$room_imgs_id = explode(',', get_post_meta($post_id, 'rooms_slideshow_images', true));
										$room_cover   = trim($room_imgs_id[0]);
										$room_html
											.= '
											<div class="room-box col-xs-6">
												<div class="img-container">
													<div class="check-box-container">
														<input type="checkbox" value="' . esc_attr($post_id) . '" id="room-' . esc_attr($post_id) . '">
														<label for="room-' . esc_attr($post_id) . '">
															<span></span>
															' . balancetags(__('Select This <b>Room</b>', 'pinar')) . '
														</label>
													</div>';
										if ($room_cover != '') {
											$room_html .= wp_get_attachment_image($room_cover, $thumb_size);
										} else {
											$room_html .= '<img src="' . esc_url(PINAR_IMG_PATH) . 'room-placeholder.jpg" alt="' . esc_attr(esc_html__('No Image', 'pinar')) . '" />';
										}
										$room_html
											.= '
													<a href="' . esc_url(get_permalink()) . '" class="btn btn-default btn-out-border" href="_blank">' . esc_html__('More Details', 'pinar') . '</a>
												</div>
												<div class="details">
													<div class="title"><a href="' . esc_url(get_permalink()) . '" href="_blank">' . ravis_fn_title_effect(esc_html(get_the_title())) . '</a></div>
													<div class="desc">' . esc_html($rooms_desc) . '</div>
													<div class="price">
														<span>' . esc_html(ravis_fn_price_value($rooms_price)) . '</span>
														' . esc_html__('- Per Night', 'pinar') . '
													</div>
												</div>
											</div>';
									}
								}
							}
						} else {
							$html = '<h2><span><b>' . esc_html__('No Rooms Available for your criteria.', 'pinar') . '</b></span></h2><h3>' . esc_html__('Please try other dates.', 'pinar') . '</h3>';
						}
					}

					if (isset($room_html) && $room_html != '') {
						$reserve_info = $package_id . ',,,' . $check_in_date . ',,,' . $check_out_date . ',,,' . $adult_guest . ',,,' . $child_guest;
						setcookie('reserved_info_cookie', esc_html($reserve_info), time() + 3600);

						$html
							.= '
							<input type="hidden" id="step" value="2">
							<div class="loader"></div>
							<div class="error-message-box"></div>
							<div class="fadeInUp" id="booking-choose-room">
								<div class="room-container room-grid clearfix">
									' . balancetags($room_html) . '
								</div>
								<div class="btn-container-box">
		                    		<button class="btn btn-md btn-default confirm-room-butt">' . esc_html__("Confirm the room", 'pinar') . '</button>
		                    	</div>
							</div>
			                <script type="text/javascript">
							    jQuery(document).ready(function(){
						            "use strict";

									//Confirm the rooms
									jQuery(".confirm-room-butt").on("click", function (e){
										e.preventDefault();
										var chooseRoomContainer  = jQuery("#booking-choose-room"),
											step 				 = jQuery("#step").val(),
											tabContentMainBox	 = jQuery("#booking-tab-contents"),
											errorBox 			 = tabContentMainBox.find(".error-message-box").hide(),
											errorMessage		 = "",
											selectedItems		 = "";

										chooseRoomContainer.find("input[type=checkbox]").each(function(){
											if(jQuery(this).is(":checked"))
											{
												selectedItems += jQuery(this).val() + "/-/";
											}
										});
										if(selectedItems == "")
										{
											errorBox.show().addClass("active alert alert-danger").html("' . esc_html__('Please choose at least one room.', 'pinar') . '");
											jQuery("body,html").animate({
									            scrollTop: errorBox.offset().top - 100
									        }, 1000);

											return false;
										} 
										tabContentMainBox.addClass("loading");
										var data = {
											action: "booking_form",
											selectedItems: selectedItems,
											step: step,
										};
										jQuery.post("' . esc_url(admin_url()) . 'admin-ajax.php", data, function(data){
											tabContentMainBox.removeClass("loading");
											tabContentMainBox.html(data);
											jQuery("body,html").animate({
									            scrollTop: tabContentMainBox.offset().top - 100
									        }, 1000);
											var currentStep 		= jQuery("#booking-tab-contents #step").val(),
												bookinTabContainer  = jQuery("#booking-tabs");

											bookinTabContainer.find("li").removeClass("active");
											jQuery("#booking-tabs li:eq("+ (currentStep - 1) +")").addClass("active");	
										});
									});
							    });
							</script>';
					}
					break;
			}
		}

		if ($html != '') {
			echo balancetags($html);
		} else {
			return false;
		}
		die();

	}
}
add_action('wp_ajax_nopriv_booking_form', 'ravis_fn_pinar_booking_form_func');
add_action('wp_ajax_booking_form', 'ravis_fn_pinar_booking_form_func');