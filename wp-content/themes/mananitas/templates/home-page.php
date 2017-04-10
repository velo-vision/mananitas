<?php
/**
 *	home-page.php
 * 	Home page template of Pinar
 *  Template Name: Home Page
 */
global $pinar_opt;

get_header();

echo '<div id="home-top-section">';
echo do_shortcode('[pinar-main-slider]' );
echo do_shortcode('[pinar-availability-form]' );
echo '</div>';

if(have_posts())
{
	global $pinar_opt;
	while (have_posts())
	{
		the_post();
		the_content();
	}
}

echo do_shortcode('[pinar-luxury-rooms type="wide"]' );
echo do_shortcode('[pinar-main-gallery]' );
echo do_shortcode('[pinar-video]' );
echo do_shortcode('[pinar-packages]' );
get_footer();