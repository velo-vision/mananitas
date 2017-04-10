<?php
/**
 *	home-page-alt.php
 * 	Home page Alternative template of Pinar
 *  Template Name: Home Page Alt
 */
global $pinar_opt;

get_header();

echo '<div id="home-top-section">';
echo do_shortcode('[pinar-text-slider]' );
echo do_shortcode('[pinar-availability-form type="horizontal"]' );
echo '</div>';

if(have_posts())
{
	global $pinar_opt;
	while (have_posts())
	{
		the_post();
		$post_id = get_the_id();
		echo '
			<div class="page-container-box">
				<div class="inner-container container">';
		if(has_post_thumbnail( $post_id ))
		{
			echo '<div class="left-sec col-md-4 wow fadeInLeft">'.get_the_post_thumbnail($post_id).'</div>';
		}
		echo '		<div class="right-sec wow fadeInUp '. (has_post_thumbnail( $post_id ) ? 'col-md-8' : '') .'">
						<h1>'.balancetags(get_the_title()).'</h1>
						<div class="content">'.balancetags(get_the_content()).'</div>
					</div>
				</div>
			</div>
		';
	}
}

echo do_shortcode('[pinar-room-list]' );
echo do_shortcode('[pinar-video]' );
echo '<div class="package-container-box">'.do_shortcode('[pinar-packages]' ).'</div>';
echo do_shortcode('[pinar-latest-post]' );
get_footer();