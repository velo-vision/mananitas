<?php
/**
 *	home-page.php
 * 	Home page template of mananitas
 *  Template Name: Home Page Child
 */
global $pinar_opt;

get_header();

echo '<div id="home-top-section">';
echo do_shortcode('[pinar-main-slider]' );
echo '</div>';

echo '<div class="heading-box">
	<h2><b>Las Mañanitas</b></h2>';


if(have_posts())
{
	global $pinar_opt;
	while (have_posts())
	{
		the_post();
		the_content();
	}
}

echo do_shortcode('[pinar-luxury-rooms title="Habitaciones" subtitle="" room_count="5" type="wide"]' );
echo do_shortcode('[pinar-main-gallery title="Galería"]' );
// echo do_shortcode('[pinar-video]' );
// echo do_shortcode('[pinar-packages]' );
get_footer();