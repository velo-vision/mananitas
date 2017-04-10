<?php
if(!function_exists('pinar_ajax_insert_testimonials'))
{
	function pinar_ajax_insert_testimonials()
	{
		$firstName    = isset($_POST['firstName']) ? sanitize_text_field($_POST['firstName']) : '';
		$email        = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
		$tel          = isset($_POST['tel']) ? sanitize_text_field($_POST['tel']) : '';
		$title        = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';
		$testimonials = isset($_POST['testimonials']) ? sanitize_text_field($_POST['testimonials']) : '';

		if($firstName !== '' && $title !== '' && $testimonials !=='')
		{
			// Create post object
			$testimonial = array(
				'post_type'    => 'guest_book',
				'post_title'   => esc_html($title),
				'post_content' => esc_html($testimonials ),
				'post_status'  => 'pending'
			);

			// Insert the post into the database
			$post_id =wp_insert_post( $testimonial );
			if($post_id !==0 )
			{
				add_post_meta( $post_id, 'testimonials_guest_name', $firstName );
				add_post_meta( $post_id, 'testimonials_guest_email', $email );
				add_post_meta( $post_id, 'testimonials_guest_phone', $tel );

				$result['status']  = true;
				$result['message'] = esc_html__("Your feedback will be listed after confirmation.", 'pinar');
				echo json_encode($result);				
			}
		}
		else{
			$result['status']  = false;
			$result['message'] = esc_html__("Please refresh the page and fill all required fields.", 'pinar');
			echo json_encode($result);
		}

		die();
	}	
}
add_action('wp_ajax_nopriv_insert_testimonials', 'pinar_ajax_insert_testimonials');
add_action('wp_ajax_insert_testimonials', 'pinar_ajax_insert_testimonials');