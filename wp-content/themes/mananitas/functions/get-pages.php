<?php
if(!function_exists('ravis_fn_get_pages_url'))
{
	function ravis_fn_get_pages_url()
	{
		global $post, $pinar_opt;

		if(!empty($pinar_opt['opt-default-gallery'])){
			switch ($pinar_opt['opt-default-gallery']) {
				case '2':
					$default_gallery_layout = 'gallery-grid.php';
					break;
				case '3':
					$default_gallery_layout = 'gallery-fullscreen.php';
					break;
				default:
					$default_gallery_layout = 'gallery-masonry.php';
					break;
			}
		}
		else{
			$default_gallery_layout = 'gallery-masonry.php';
		}

		/**
		 * Get the booking page URL
		 */
		$pages_list = array(
			array(
				'post_type'   => 'page',
				'post_status' => 'publish',
				'meta_key'    => '_wp_page_template',
				'meta_value'  => 'templates/booking.php',
			),
			array(
				'post_type'   => 'page',
				'post_status' => 'publish',
				'meta_key'    => '_wp_page_template',
				'meta_value'  => 'templates/'.$default_gallery_layout,
			)
		);
		foreach ($pages_list as $pages_args) {
			$pages_query = new WP_Query( $pages_args );

			if($pages_query->have_posts())
			{
				while ( $pages_query->have_posts()) {
					$pages_query->the_post();
					$pages_slug   = $post->post_name;
				}				
			}
			$pages_slug = (isset($pages_slug) && $pages_slug != '' ? $pages_slug : '');

			wp_reset_postdata();

			$get_page_url = esc_url(get_permalink( get_page_by_path( $pages_slug ) ));

			if( strpos(get_page_template(),'booking.php') )
			{
				define( 'RAVIS_BOOKING_PAGE_URL', (!empty($get_page_url) ? $get_page_url : '') );
			}
			elseif( strpos(get_page_template(), $default_gallery_layout) )
			{
				define( 'RAVIS_GALLERY_PAGE_URL', (!empty($get_page_url) ? $get_page_url : '') );
			}
		}
	}
}
add_action( 'init', 'ravis_fn_get_pages_url' );