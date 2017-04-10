<?php 
/**
 * archive-rooms.php
 * 
 * Archive of Rooms file
 */
global $post, $pinar_opt;

$price_unit = !empty($pinar_opt['pinar-booking-currency']) ? ravis_currency_converter($pinar_opt['pinar-booking-currency']) : '&#36;';
get_header();

/**
 * Get the booking page URL
 */
$tax_args = array(
	'post_type'   => 'rooms',
	'post_status' => 'publish',
	'tax_query' => array(
		array(
			'taxonomy' => get_query_var( 'taxonomy' ),
			'field'    => 'slug',
			'terms'    => array( get_query_var( 'term' ) ),
		)
	)
);
	
$tax_query = new WP_Query( $tax_args );


	if($tax_query->have_posts())
	{
		echo '<div class="room-container container room-masonry">';
		while ($tax_query->have_posts()) {
			$tax_query->the_post();
			$post_id          = get_the_id();
			// $thumb_size       = array('580', '380' );
			$rooms_price      = get_post_meta( $post_id, 'rooms_price', true );
			$rooms_short_desc = get_post_meta( $post_id, 'rooms_short_desc', true );
			$room_imgs_id     = explode( ',' , get_post_meta( $post_id, 'rooms_slideshow_images', true ));
			$room_cover       = trim($room_imgs_id[0]);

			echo '
			<div class="room-box col-xs-6 col-md-4">
				<div class="img-container">';

                    if($room_cover != '')
                    {
                    	echo wp_get_attachment_image( $room_cover, 'full' ); 
                    }
                    else
                    {
                    	echo '<img src="'. esc_url ( PINAR_IMG_PATH ).'room-placeholder.jpg" alt="'. esc_attr( esc_html__('No Image','pinar') ).'" />';
                    }

				echo '<a href="'.esc_url(get_permalink()).'" class="btn btn-default btn-out-border">'.esc_html__('More Details', 'pinar').'</a>
				</div>
				<div class="details">
					<div class="title"><a href="'.esc_url(get_permalink()).'">'.ravis_fn_title_effect(esc_html(get_the_title())).'</a></div>
					<div class="desc">'.esc_html($rooms_short_desc).'</div>
					<div class="price">
						<span>'.esc_html($price_unit.number_format($rooms_price)).'</span>
						'.esc_html__('- Per Night', 'pinar').'
					</div>
				</div>
			</div>';
		}
		echo '</div>';
	}
	else
	{
		esc_html_e('There is not any rooms!', 'pinar');
	}
	wp_reset_postdata();

	ravis_fn_pagination($tax_query);

get_footer();