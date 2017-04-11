<?php
// archive-rooms.php
// Room Archive

global $post, $pinar_opt;
get_header();

	if(have_posts())
	{
		echo '<div class="room-container container room-grid">';
		while (have_posts()) {
			the_post();
			$post_id          = get_the_id();
			$thumb_size       = array('580', '380' );
			$rooms_price      = get_post_meta( $post_id, 'rooms_price', true );
			$rooms_short_desc = get_post_meta( $post_id, 'rooms_short_desc', true );
			$room_imgs_id     = explode( ',' , get_post_meta( $post_id, 'rooms_slideshow_images', true ));
			$room_cover       = trim($room_imgs_id[0]);

			echo '
			<div class="room-box col-xs-6">
				<div class="img-container">';

                    if($room_cover != '')
                    {
                    	echo wp_get_attachment_image( $room_cover, $thumb_size );
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
						<span>'.esc_html(ravis_fn_price_value($rooms_price)).'</span>
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
	ravis_fn_pagination();
get_footer();
