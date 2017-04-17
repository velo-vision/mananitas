<?php
/**
 *	rooms-list.php
 * 	Room List template
 *  Template Name: Room List view
 */
global $post, $pinar_opt;

$args = array(
    'post_type'   => 'rooms',
    'post_status' => 'publish',
    'order'       => 'DESC',
    'orderby'     => 'date',
    'paged'		  => intval(get_query_var('paged' ))
);
$pinar_rooms_list  = new WP_Query( $args );

get_header();

	if($pinar_rooms_list->have_posts())
	{
		echo '<div class="room-container container room-list clearfix">';
		while ($pinar_rooms_list->have_posts()) {
			$pinar_rooms_list->the_post();
			if(function_exists('icl_object_id'))
        	{
        		$post_id = icl_object_id(get_the_id(), 'post', false);
        	}
        	else{
        		$post_id          = get_the_id();
        	}
			$post_id              = get_the_id();
			$thumb_size           = array('580', '400' );
			$raw_rooms_price      = get_post_meta( $post_id, 'rooms_price', true );
			$raw_rooms_short_desc = get_post_meta( $post_id, 'rooms_short_desc', true );
			$rooms_price          = !empty($raw_rooms_price) ? $raw_rooms_price : '';
			$rooms_short_desc     = !empty($raw_rooms_short_desc) ? $raw_rooms_short_desc : '';
			$room_imgs_id         = explode( ',' , get_post_meta( $post_id, 'rooms_slideshow_images', true ));
			$room_cover           = trim($room_imgs_id[0]);
			$features_list        = '';
			$room_services        = get_post_meta( $post_id, 'rooms_services_checkboxes',true);
			if(!empty($room_services )){
				foreach ($room_services as $room_service) {
	                $service_post   = get_post($room_service);
	                if(!empty($service_post->post_title))
	                {
	             		$features_list .= '<li><i class="fa fa-check"></i>'.esc_html($service_post->post_title).'</li>';
	                }
	            }
			}
			$rooms_max_guest = get_post_meta($post_id, 'rooms_max_guest', true);
			$rooms_room_size = get_post_meta($post_id, 'rooms_room_size', true);
			$rooms_room_view = get_post_meta($post_id, 'rooms_room_view', true);
			if(!empty($rooms_max_guest))
			{
				$features_list .= '<li><i class="fa fa-check"></i>'.sprintf(esc_html__('Max %s people', 'pinar'), $rooms_max_guest).'</li>';
			}
			if(!empty($rooms_room_size))
			{
				$features_list .= '<li><i class="fa fa-check"></i>'.sprintf(esc_html__('Room Size : %s sqf', 'pinar'), $rooms_room_size).'</li>';
			}
			if(!empty($rooms_room_view))
			{
				$features_list .= '<li><i class="fa fa-check"></i>'.sprintf(esc_html__('View: %s', 'pinar'), $rooms_room_view).'</li>';
			}

			echo '
			<div class="room-box clearfix">
				<div class="img-container col-xs-6 size-rooms">';

				if($room_cover != '')
                {
                	echo wp_get_attachment_image( $room_cover, $thumb_size );
                }
                else
                {
                	echo '<img class="size-rooms" src="'. esc_url ( PINAR_IMG_PATH ).'room-placeholder.jpg" alt="'. esc_attr( esc_html__('No Image','pinar') ).'" />';
                }

			echo '
					<a href="'.esc_url(get_permalink()).'" class="btn btn-default btn-out-border">'.esc_html__('Más Detalles', 'pinar').'</a>
				</div>
				<div class="details col-xs-6">
					<div class="title"><a href="'.esc_url(get_permalink()).'">'.ravis_fn_title_effect(esc_html(get_the_title())).'</a></div>
					<div class="desc">
						'.esc_html($rooms_short_desc).'
						<ul class="facilities list-inline">
							'.$features_list.'
						</ul>
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
	ravis_fn_pagination($pinar_rooms_list);
  // <div class="price">
  //   <span>'.esc_html(ravis_fn_price_value($rooms_price)).'</span>
  //   '.esc_html__('- Per Night', 'pinar').'
  // </div>
get_footer();
