<?php
/**
 *	gallery-fullscreen.php
 * 	FullScreen layout of Gallery
 *  Template Name: Gallery FullScreen
 */	
global $pinar_opt;
get_header();
$gallery_items_id        = isset($pinar_opt["pinar-fullscreen-gallery"] ) ? explode(',', $pinar_opt["pinar-fullscreen-gallery"]) : '';
?>
<div class="gallery-container gallery-fullscreen">

	<div id="fullscreen-slider">
		<?php
			foreach ($gallery_items_id as $gallery_item_id) 
			{

				$image = get_post( intval( $gallery_item_id ) );
				echo '
					<div class="items">
			            <img src="'.esc_url( $image->guid ).'" />
			        </div>';
			}

		?>
    </div>

</div>

<?php
get_footer();