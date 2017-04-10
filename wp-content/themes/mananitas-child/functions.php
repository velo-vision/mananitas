<?php 

function mananitas_child_latest_enqueue()
{
	wp_register_style( 'child-theme-style', get_stylesheet_directory_uri() . '/style.css','1.0.0');
	wp_enqueue_style( 'child-theme-style');

	//add your scripts
	//wp_register_script( 'my-child-script', get_stylesheet_directory_uri() . '/js/my-scripts.js', '1.0', true );
	//wp_enqueue_script('my-child-script');

}
add_action("wp_enqueue_scripts", "mananitas_child_latest_enqueue", 10000);