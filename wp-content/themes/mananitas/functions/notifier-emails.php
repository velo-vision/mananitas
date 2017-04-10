<?php
if(!function_exists('ravis_notifier_add_email')){

	/**
	 * Create Ajax Function for adding email to the notifier table
	 */
	function ravis_notifier_add_email()
	{
		global $wpdb;
		$user_email = $_POST['email'];
		$result     = array();

		// filter the variable
		if (filter_var($user_email, FILTER_VALIDATE_EMAIL))
		{
			$table_name  = $wpdb->prefix .'ravis_notifier';
			$check_query = $wpdb->get_results(
								$wpdb->prepare("
									SELECT id FROM $table_name
									WHERE email = %s
									",
									array(
										$user_email
									)
								)
							);

			if($check_query)
			{
				$result['message'] = esc_html__( "You have already subscribed.", 'pinar');			
			}
			else
			{
				$wpdb->insert( 
					$table_name, 
					array( 
						'email' => $user_email,
					),
					array('%s')
				);
				if($wpdb->insert_id)
				{
					$result['message'] = esc_html__( "Thanks for your subscription.", 'pinar');			

					/**
					 * Create the emails csv file
					 */
					$email_list = $wpdb->get_results("SELECT email FROM $table_name");
					foreach ($email_list as $emails_item) {
						$new_email_list[] = $emails_item->email;
					}
					$fp = fopen(PINAR_THEMEROOT.'/notifier_emails.csv', 'w');
				    fputcsv($fp, $new_email_list);
					fclose($fp);
				}
				else{
					$result['message'] = esc_html__( "Email was not added!", 'pinar');
				}
			}
		}
		else
		{
			$result['message'] = esc_html__( "Please add a valid email format", 'pinar');
		}
		echo json_encode($result);
		die();
	}
}
add_action('wp_ajax_nopriv_ravis_notifier_emails', 'ravis_notifier_add_email');
add_action('wp_ajax_ravis_notifier_emails', 'ravis_notifier_add_email');