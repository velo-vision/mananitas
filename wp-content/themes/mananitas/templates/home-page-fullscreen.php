<?php
/**
 *	home-page-fullscreen.php
 * 	Home page fullscreen template of Pinar
 *  Template Name: Home Page Fullscreen
 */
global $pinar_opt;

get_header();
$slider_items_id        = isset($pinar_opt["pinar-main-slider"] ) ? explode(',', $pinar_opt["pinar-main-slider"]) : '';

?>

<div class="gallery-container gallery-fullscreen">

	<?php 
	if (isset($pinar_opt["pinar-main-slider"]))
	{
		echo '
			<div id="fullscreen-slider">';
			if($slider_items_id[0] !=='')
			{
				foreach ($slider_items_id as $slider_item_id) {
					$slide = get_post( intval( $slider_item_id ) );				
					echo '
						<div class="items">
				            <img src="'.esc_url( $slide->guid ).'" alt="3"/>
				        </div>';
				}					
			}
			else
			{
				echo '
					<div class="items">
			            <img src="'.PINAR_IMG_PATH.'slider-placeholder.png" alt="'.esc_attr__( 'No Image',  'pinar').'"/>
			        </div>';
			}

		echo '</div>';
	}
	else
	{
		esc_html_e('There is not any slides', 'pinar');
	}
	?>
    <div id="fullscreen-welcome" class="col-md-3">
	    <?php 
	    	if (have_posts()) {
	    		while (have_posts()) {
	    			the_post();
	    			echo '
						<div class="heading-box">
							<h2>'.ravis_fn_title_effect(esc_html( get_the_title() )).'</h2>
						</div>
						<div class="welcome-text">
							'.esc_html( get_the_content() ).'
						</div>
	    			';
	    		}
	    	}
	    	echo do_shortcode('[pinar-availability-form type="simple"]' );
	    ?>
	</div>

</div>





<?php
get_footer();