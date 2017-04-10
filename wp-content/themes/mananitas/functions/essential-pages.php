<?php
if(!function_exists('ravis_fn_pinar_required_pages'))
{
	function ravis_fn_pinar_required_pages()
	{
		global $post;

		$pages_list = array(
			array(
				'title'     => esc_html__( 'Booking', 'pinar' ), 
				'content'   => '', 
				'post_name' => 'pinar-booking',
				'template'  => 'templates/booking.php', 
			),
			array(
				'title'     => esc_html__( 'Gallery', 'pinar' ), 
				'content'   => '', 
				'post_name' => 'pinar-gallery',
				'template'  => 'templates/gallery-masonry.php', 
			),
		);

		foreach ($pages_list as $new_page) {

			$page_check = get_page_by_title($new_page['title']);
	        $new_page_arr = array(
					'post_type'    => 'page',
					'post_title'   => $new_page['title'],
					'post_content' => $new_page['content'],
					'post_name'    => $new_page['post_name'],
					'post_status'  => 'publish',
					'post_author'  => 1,
	        );

	        if(!isset($page_check->ID))
	        {
	        	$new_page_id = wp_insert_post($new_page_arr);
                if(!empty($new_page['template'])){
                        update_post_meta($new_page_id, '_wp_page_template', $new_page['template']);
                }
	        }
		}
	}
}
add_action( 'after_setup_theme', 'ravis_fn_pinar_required_pages' );

