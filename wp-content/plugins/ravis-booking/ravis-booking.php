<?php 
/**
 * Plugin Name: Ravis Booking System
 * Plugin URI: http://themeforest.net/user/RavisTheme
 * Description: Integrated booking system for hotels and resort with RavisTheme templates.
 * Version: 1.9.8
 * Author: RavisTheme
 * Author URI: http://themeforest.net/user/RavisTheme
 * Text Domain: ravis
 * Domain Path:  /languages
 * This is not a free software and you can only use it with RavisTheme templates.
 * 
 */

if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if(!defined('PINAR_THEMEROOT'))
{
	define('PINAR_THEMEROOT', get_template_directory());
}

if(!defined('PINAR_BASE_URL'))
{
	if (get_template_directory_uri() === get_stylesheet_directory_uri())
	{
		define('PINAR_BASE_URL', get_stylesheet_directory_uri());
    }
    else
    {
		define('PINAR_BASE_URL', get_template_directory_uri());
    }
}
if(!defined('RAVIS_PLG_BASE_URL'))
{
	define('RAVIS_PLG_BASE_URL', esc_url( plugin_dir_url( __FILE__ ) ));
}
if(!defined('RAVIS_PLG_IMG_PATH'))
{
	define('RAVIS_PLG_IMG_PATH', RAVIS_PLG_BASE_URL.'assets/img/');
}
if(!defined('RAVIS_PLG_JS_PATH'))
{
	define('RAVIS_PLG_JS_PATH', RAVIS_PLG_BASE_URL.'assets/js/');
}

register_activation_hook( __FILE__, array( 'Ravis_Booking_main', 'ravis_booking_activate' ) );
register_deactivation_hook( __FILE__, array( 'Ravis_Booking_main', 'ravis_booking_deactivate' ) );
// register_uninstall_hook( __FILE__, array( 'Ravis_Booking_main', 'uninstall' ) );

/**
 * ------------------------------------------------------------------------------------------
 * Define Constants and Variables
 * ------------------------------------------------------------------------------------------
 */
$ravis_booking_base = __FILE__;
define('RAVIS_BOOKING_BASE', $ravis_booking_base);
define('RAVIS_BOOKING_PATH', plugin_dir_path($ravis_booking_base));
define('RAVIS_BOOKING_URL', plugins_url('/', $ravis_booking_base));
define('RAVIS_BOOKING_MAIN_FILE', $ravis_booking_base);
define('RAVIS_BOOKING_FIELDS', RAVIS_BOOKING_PATH.'fields/');
define('RAVIS_BOOKING_SHORTCODES', RAVIS_BOOKING_PATH.'shortcodes/');

/**
 * ------------------------------------------------------------------------------------------
 * Add required functions from theme
 * ------------------------------------------------------------------------------------------
 */

require_once( PINAR_THEMEROOT.'/functions/currency-converter.php');

/**
 * ------------------------------------------------------------------------------------------
 * Include Meta box classes 
 * ------------------------------------------------------------------------------------------
 */

require_once( RAVIS_BOOKING_FIELDS.'block_dates.php');
require_once( RAVIS_BOOKING_FIELDS.'packages.php');
require_once( RAVIS_BOOKING_FIELDS.'services.php');
require_once( RAVIS_BOOKING_FIELDS.'staff.php');
require_once( RAVIS_BOOKING_FIELDS.'staff-type.php');
require_once( RAVIS_BOOKING_FIELDS.'testimonials.php');
require_once( RAVIS_BOOKING_FIELDS.'page_id_class.php');
require_once( RAVIS_BOOKING_FIELDS.'booking-details.php');
require_once( RAVIS_BOOKING_FIELDS.'booking-price.php');
require_once( RAVIS_BOOKING_FIELDS.'booking-rooms.php');
require_once( RAVIS_BOOKING_FIELDS.'rooms_info.php');
require_once( RAVIS_BOOKING_FIELDS.'rooms_price.php');
require_once( RAVIS_BOOKING_FIELDS.'rooms_services.php');
require_once( RAVIS_BOOKING_FIELDS.'rooms_gallery.php');
require_once( RAVIS_BOOKING_FIELDS.'rooms-luxury.php');

/**
 * ------------------------------------------------------------------------------------------
 * Add shortcode class
 * ------------------------------------------------------------------------------------------
 */

require_once( RAVIS_BOOKING_PATH.'shortcode.class.php');

/**
 * ------------------------------------------------------------------------------------------
 * Main Class of Ravis Booking
 * ------------------------------------------------------------------------------------------
 */
class Ravis_Booking_main {

	public function __construct() 
	{

		add_action( 'init', array( $this, 'load_plugin_text_domain' ), 0 );
		add_action( 'init', array( $this, 'register_custom_post_type' ), 0 );
		add_action( 'admin_menu', array( $this, 'ravis_add_submenu_page' ), 0 );

		// Add Button to TinyMCE Functions
		add_filter( 'mce_external_plugins', array( $this, 'ravis_booking_add_buttons' ) );
		add_filter( 'mce_buttons', array( $this, 'ravis_booking_register_buttons' ) );
		add_action( 'wp_ajax_ravis_tinymce', array( $this, 'ravis_booking_ajax_tinymce' ) );

	}

	public static function ravis_booking_activate()
	{

	}
	/**
	 * Load plugin text domain
	 */
	public static function load_plugin_text_domain()
	{
		load_plugin_textdomain( 'ravis', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	public function ravis_booking_ajax_tinymce()
	{
		if ( current_user_can( 'edit_posts' ) or current_user_can( 'edit_pages' ) )
		{
			include_once( RAVIS_BOOKING_PATH . 'ravisButtons.php' );
			die();
		}
		else
		{
			die( esc_html__( "You are not allowed to be here", 'ravis' ) );
		}
	}

	/*
	 * Adding button to MCE
	 */

	public function ravis_booking_add_buttons( $plugin_array )
	{
		$plugin_array['ravisButtons'] = RAVIS_PLG_JS_PATH . 'ravisButtons.js';

		return $plugin_array;
	}

	/*
	 * Registering button to MCE
	 */

	public function ravis_booking_register_buttons( $buttons )
	{
		array_push( $buttons, 'ravisShortcodes' );

		return $buttons;
	}

	/**
	 * Register All required post types for Plugin
	 */
	public static function register_custom_post_type()
	{

		/**
		 * ------------------------------------------------------------------------------------------
		 * Guest Book post_type
		 * ------------------------------------------------------------------------------------------
		 */
		register_post_type(
			'guest_book',
		    array(
				'label'               => esc_html__( 'Guest Book' , 'ravis' ),
				'description'         => esc_html__('Manage the testimonials which is given by hotel\'s guests.' , 'ravis' ),
				'exclude_from_search' => true,
				'public'              => true,
				'has_archive'         => true,
				'rewrite'             => array('slug' => 'guest-book'),
				'menu_icon'           => esc_url(RAVIS_PLG_IMG_PATH) . 'post_type/testimonials.png'
		    )
		);
		/**
		 * ------------------------------------------------------------------------------------------
		 * Rooms post_type
		 * ------------------------------------------------------------------------------------------
		 */
		register_post_type(
			'rooms',
		    array(
				'label'               => esc_html__( 'Rooms' , 'ravis' ),
				'description'         => esc_html__('Manage the rooms of hotel.' , 'ravis' ),
				'public'              => true,
				'exclude_from_search' => true,
				'has_archive'         => true,
				'rewrite'             => array('slug' => 'rooms'),
				'supports'            => array( 'title', 'editor', 'comments' ),
				'menu_icon'           => esc_url(RAVIS_PLG_IMG_PATH) . 'post_type/rooms.png'
		    )
		);

		$labels = array(
			'name'					=> _x( 'Room Categories', 'Taxonomy plural name', 'ravis' ),
			'singular_name'			=> _x( 'Room Category', 'Taxonomy singular name', 'ravis' ),
		);
	
		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_admin_column' => true,
			'hierarchical'      => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'room-category' ),
		);
	
		register_taxonomy( 'room-category', array( 'rooms' ), $args );
		/**
		 * ------------------------------------------------------------------------------------------
		 * Services post_type
		 * ------------------------------------------------------------------------------------------
		 */
		register_post_type(
			'service',
		    array(
				'label'               => esc_html__( 'Service' , 'ravis' ),
				'description'         => esc_html__('Manage the services that your hotel provide.' , 'ravis' ),
				'public'              => true,
				'has_archive'         => false,
				'exclude_from_search' => true,
				'rewrite'             => array('slug' => 'service'),
				'supports'            => array( 'title', 'editor', 'thumbnail' ),
				'menu_icon'           => esc_url(RAVIS_PLG_IMG_PATH) . 'post_type/service.png'
		    )
		);
		/**
		 * ------------------------------------------------------------------------------------------
		 * Staff post_type
		 * ------------------------------------------------------------------------------------------
		 */
		register_post_type(
			'staff',
		    array(
				'label'               => esc_html__( 'Staff' , 'ravis' ),
				'description'         => esc_html__('Manage the staff of hotel.' , 'ravis' ),
				'public'              => true,
				'has_archive'         => true,
				'exclude_from_search' => true,
				'rewrite'             => array('slug' => 'staff'),
				'supports'            => array( 'title', 'editor', 'thumbnail' ),
				'menu_icon'           => esc_url(RAVIS_PLG_IMG_PATH) . 'post_type/staff.png'
		    )
		);
		/**
		 * ------------------------------------------------------------------------------------------
		 * Booking post_type
		 * ------------------------------------------------------------------------------------------
		 */
		register_post_type(
			'booking',
		    array(
				'label'               => esc_html__( 'Booking' , 'ravis' ),
				'description'         => esc_html__('Manage the Booking posts.' , 'ravis' ),
				'public'              => true,
				'has_archive'         => true,
				'exclude_from_search' => true,
				'rewrite'             => array('slug' => 'booking'),
				'supports'            => array( 'title'),
				'menu_icon'           => esc_url(RAVIS_PLG_IMG_PATH) . 'post_type/booking.png'
		    )
		);
		/**
		 * ------------------------------------------------------------------------------------------
		 * Block dates post_type
		 * ------------------------------------------------------------------------------------------
		 */
		register_post_type(
			'block_dates',
		    array(
				'label'               => esc_html__( 'Block Dates' , 'ravis' ),
				'description'         => esc_html__('Manage the Block Dates.' , 'ravis' ),
				'public'              => true,
				'has_archive'         => true,
				'exclude_from_search' => true,
				'rewrite'             => array('slug' => 'block-dates'),
				'supports'            => array( 'title'),
				'menu_icon'           => esc_url(RAVIS_PLG_IMG_PATH) . 'post_type/block_date.png'
		    )
		);
		/**
		 * ------------------------------------------------------------------------------------------
		 * Package post_type
		 * ------------------------------------------------------------------------------------------
		 */
		register_post_type(
			'packages',
		    array(
				'label'               => esc_html__( 'Packages' , 'ravis' ),
				'description'         => esc_html__('Manage Special offer packages.' , 'ravis' ),
				'public'              => true,
				'has_archive'         => true,
				'exclude_from_search' => true,
				'rewrite'             => array('slug' => 'packages'),
				'supports'            => array( 'title', 'editor', 'thumbnail' ),
				'menu_icon'           => esc_url(RAVIS_PLG_IMG_PATH) . 'post_type/package.png'
		    )
		);
	}

	public function ravis_add_submenu_page()
	{
		add_submenu_page( 'edit.php?post_type=booking', esc_html__( 'Booking Overview', 'ravis' ), esc_html__( 'Booking Overview', 'ravis' ), 'level_7', 'booking-overview', array($this, 'load_overview') );
	}

	public function load_overview()
	{
		include 'booking-overview.php';
	}

	public static function ravis_booking_deactivate() {}


/*
	public static function uninstall() {
		if ( __FILE__ != WP_UNINSTALL_PLUGIN )
			return;
	}
*/
}
$ravis_booking_obj = new Ravis_Booking_main;