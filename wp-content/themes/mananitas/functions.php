<?php
/**
 *	function.php
 *	Function of the theme are listed in this file.
 * ------------------------------------------------------------------------------------------
 * 1.0 - Define Constant
 * ------------------------------------------------------------------------------------------
 */

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
if(!defined('PINAR_FRAMEWORK'))
{
	define('PINAR_FRAMEWORK', PINAR_THEMEROOT.'/admin/');
}
if(!defined('PINAR_WIDGET_PATH'))
{
	define('PINAR_WIDGET_PATH', PINAR_THEMEROOT.'/widgets/');
}
if(!defined('PINAR_FUNCTIONS_PATH'))
{
	define('PINAR_FUNCTIONS_PATH', PINAR_THEMEROOT.'/functions/');
}
if(!defined('PINAR_PLUGIN_PATH'))
{
	define('PINAR_PLUGIN_PATH', PINAR_THEMEROOT.'/includes/plugins/');
}
if(!defined('PINAR_CSS_PATH'))
{
	define('PINAR_CSS_PATH', PINAR_BASE_URL.'/assets/css/');
}
if(!defined('PINAR_IMG_PATH'))
{
	define('PINAR_IMG_PATH', PINAR_BASE_URL.'/assets/img/');
}
if(!defined('PINAR_JS_PATH'))
{
	define('PINAR_JS_PATH', PINAR_BASE_URL.'/assets/js/');
}

if ( ! isset( $content_width ) ) $content_width = 1200;

$current_season = 0;

/**
 * ------------------------------------------------------------------------------------------
 * 2.0 - Include the framework options
 * ------------------------------------------------------------------------------------------
 */

if ( !class_exists( 'ReduxFramework' ) && file_exists( PINAR_FRAMEWORK . 'core/framework.php' ) )
{
    require_once( PINAR_FRAMEWORK . 'core/framework.php' );
}

if ( !isset( $redux_demo ) && file_exists( PINAR_FRAMEWORK . 'options-init.php' ) )
{
    require_once( PINAR_FRAMEWORK . 'options-init.php' );
}

/**
 * ------------------------------------------------------------------------------------------
 * 3.0 - Pinar Function Setup
 * ------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'ravis_fn_pinar_setup' ) )
{

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ravis_fn_pinar_setup()
	{

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Pinar Theme, use a find and replace
		 * to change 'pinar' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'pinar', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 */
		add_theme_support( 'title-tag' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'pinar' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5', array(
				'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
			)
		);

		/**
		 * Enable support for Post Thumbnails, and declare two sizes.
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Enable support for Post Formats.
		 */
		add_theme_support( 'post-formats', array(
			'aside', 'image', 'video', 'quote', 'link', 'gallery', 'audio',
		) );
	}
} // ravis_fn_pinar_setup
add_action( 'after_setup_theme', 'ravis_fn_pinar_setup' );

/**
 *------------------------------------------------------------------------------------------
 * 4.0 Add required script files ( css / Js and etc )
 * ------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'ravis_fn_pinar_scripts' ) )
{
	function ravis_fn_pinar_scripts()
	{
		global $pinar_opt, $post;

		if ( ! defined( 'RAVIS_BOOKING_SHORTCODE_WIZARD' ) ){

			/**
			 * Add the css files of Pinar
			 */
			wp_enqueue_style( 'pinar-main-style-file', PINAR_CSS_PATH . ((isset($pinar_opt['opt-preset']) && $pinar_opt['opt-preset'] !=='0' ) ? 'styles_'.$pinar_opt['opt-preset'].'.css' : 'styles.css'));
			if ( file_exists( PINAR_FRAMEWORK . 'style.css' ) )
			{
				wp_enqueue_style( 'pinar-dynamic-style-file', PINAR_BASE_URL . '/admin/style.css' );
			}

			/**
			 * Add the JS files of Pinar
			 */
			wp_enqueue_script( "pinar-helper-js", PINAR_JS_PATH . 'helper.js', array( 'jquery' ), get_bloginfo('version') , true );

			$datepicker_current_locale = 'en';
			if(get_locale() !== 'en_US') {
				if ( file_exists( PINAR_THEMEROOT . '/assets/js/locales/locales.php' ) )
				{
					require_once( PINAR_THEMEROOT . '/assets/js/locales/locales.php' );
				}
				isset($datepicker_locales[get_locale()]) ? $datepicker_current_locale = $datepicker_locales[get_locale()] : '';

				wp_enqueue_script( "pinar-datepicker-locale-js", PINAR_JS_PATH . 'locales/'.get_locale().'.min.js', array( 'jquery' ), get_bloginfo('version') , true );
			}

			if(!empty($pinar_opt['opt-smooth-scroll']))
			{
				wp_enqueue_script( "pinar-smooth-scroll", PINAR_JS_PATH . 'jquery.SmoothScroll.js', array( 'jquery' ), get_bloginfo('version') , true );
			}

			wp_enqueue_script( "owl-carousel", PINAR_JS_PATH . 'owl.carousel.min.js', array( 'jquery' ), get_bloginfo('version') , true );
			wp_enqueue_script( "magnific-popup", PINAR_JS_PATH . 'jquery.magnific-popup.min.js', array( 'jquery' ), get_bloginfo('version') , true );
			wp_enqueue_script( "imageloaded-js", PINAR_JS_PATH . 'imagesloaded.pkgd.min.js', array( 'jquery' ), get_bloginfo('version') , true );
			wp_enqueue_script( "isotop-js", PINAR_JS_PATH . 'isotope.pkgd.min.js', array( 'jquery' ), get_bloginfo('version') , true );
			wp_enqueue_script( "pinar-template-js", PINAR_JS_PATH . 'template.js', array( 'jquery' ), get_bloginfo('version') , true );
			// Localized ajaxurl
		    wp_localize_script( 'pinar-template-js', 'pinar', array( 'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ), 'datePickerLang' => $datepicker_current_locale ) );


			if ( is_singular() )
			{
				wp_enqueue_script( "comment-reply" );
			}
		} else {
			wp_enqueue_style( 'ravis-booking-shortcode-wizard-style', PINAR_CSS_PATH . ( 'shortcode-wizard.css' ) );
			wp_enqueue_script( "ravis-booking-shortcode-tinyMCE-popup-js", site_url() . '/wp-includes/js/tinymce/tiny_mce_popup.js', array( 'jquery' ), true );
			wp_enqueue_script( "ravis-booking-shortcode-wizard-js", PINAR_JS_PATH . 'shortcode-wizard.js', array( 'jquery' ), true );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'ravis_fn_pinar_scripts' );


/**
 * Add admin required scripts and stylesheets
 */

if ( ! function_exists('ravis_fn_pinar_admin_scripts'))
{
	function ravis_fn_pinar_admin_scripts()
	{
		wp_enqueue_style('jquery-ui-custom', PINAR_CSS_PATH . 'jquery-ui.min.css');
		wp_enqueue_style('custom-admin-style', PINAR_CSS_PATH . 'admin.css');
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script('jquery-ui-slider');
		wp_enqueue_script('pinar-helper-js', PINAR_JS_PATH.'helper.js', array( 'jquery' ));
		wp_enqueue_script('custom-admin-js', PINAR_JS_PATH.'admin.js');
	}
}
add_action( 'admin_enqueue_scripts', 'ravis_fn_pinar_admin_scripts' );


/**
 * ------------------------------------------------------------------------------------------
 * 5.0 - Pagination function
 * ------------------------------------------------------------------------------------------
 */

include( PINAR_FUNCTIONS_PATH. 'ravis-pagination.php' );

/**
 * ------------------------------------------------------------------------------------------
 * 6.0 - Title Effect function - it will add "b" tag to the first word of $input
 * ------------------------------------------------------------------------------------------
 */

include( PINAR_FUNCTIONS_PATH. 'title-effect.php' );

/**
 * ------------------------------------------------------------------------------------------
 * 7.0 - Breadcrumb function
 * ------------------------------------------------------------------------------------------
 */

include( PINAR_FUNCTIONS_PATH. 'ravis-breadcrumb.php' );

/**
 * ------------------------------------------------------------------------------------------
 * 8.0 - Register SideBars
 * ------------------------------------------------------------------------------------------
 */

if(!function_exists('ravis_fn_register_sidebar'))
{
	function ravis_fn_register_sidebar()
	{
		register_sidebar(array(
			'name'          => esc_html__('Main Widget area', 'pinar'),
			'id'            => 'main-side-bar',
			'description'   => esc_html__('Appears to the right side of the blog page.', 'pinar'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="side-title">',
			'after_title'   => '</h3>',
		));
		register_sidebar(array(
			'name'          => esc_html__('Top Footer Widget area', 'pinar'),
			'id'            => 'top-footer',
			'description'   => esc_html__('Appears in top of the website footer.', 'pinar'),
			'before_widget' => '<div id="%1$s" class="widget col-xs-6 col-md-6 %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		));
	}
}
add_action( 'widgets_init', 'ravis_fn_register_sidebar' );


/**
 * ------------------------------------------------------------------------------------------
 * 9.0 - Register Menu
 * ------------------------------------------------------------------------------------------
 */

if(!function_exists('ravis_fn_register_menus'))
{
	function ravis_fn_register_menus()
	{
		register_nav_menus(array(
			'top-menu'    => esc_html__('Top Menu', 'pinar'),
			'footer-menu' => esc_html__('Footer Menu', 'pinar'),
		));
	}
}
add_action('init', 'ravis_fn_register_menus');


/**
 * ------------------------------------------------------------------------------------------
 * 10.0 - Load post_types in the menu section
 * ------------------------------------------------------------------------------------------
 */

include( PINAR_FUNCTIONS_PATH. 'post-type-in-menu.php' );

/**
 * ------------------------------------------------------------------------------------------
 * 11.0 - Include required plugins to theme
 * ------------------------------------------------------------------------------------------
 */

include( PINAR_FUNCTIONS_PATH. 'include-plugins.php' );

/**
 * ------------------------------------------------------------------------------------------
 * 12.0 - Determine whether blog/site has more than one category.
 * @return bool True of there is more than one category, false otherwise.
 * ------------------------------------------------------------------------------------------
 */

function ravis_fn_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'ravis_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'ravis_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so ravis_fn_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so ravis_fn_categorized_blog should return false.
		return false;
	}
}

/**
 * ------------------------------------------------------------------------------------------
 * 13.0 - Post Meta function
 * ------------------------------------------------------------------------------------------
 */

include( PINAR_FUNCTIONS_PATH. 'post-meta.php' );


/**
 * ------------------------------------------------------------------------------------------
 * 16.0 - Include Custom Ravis Widgets
 * ------------------------------------------------------------------------------------------
 */

include( PINAR_WIDGET_PATH . 'ravis-recent-post-thumb.php' );

/**
 * ------------------------------------------------------------------------------------------
 * 17.0 - Create required WP data based tables.
 * ------------------------------------------------------------------------------------------
 */

include( PINAR_FUNCTIONS_PATH . 'create-required-tables.php' );

/**
 * ------------------------------------------------------------------------------------------
 * 18.0 - Check availability function
 * ------------------------------------------------------------------------------------------
 */

include( PINAR_FUNCTIONS_PATH . 'check-availability.php' );

/**
 * ------------------------------------------------------------------------------------------
 * 19.0 - Create essential page for theme
 * ------------------------------------------------------------------------------------------
 */

include( PINAR_FUNCTIONS_PATH . 'essential-pages.php' );

/**
 * ------------------------------------------------------------------------------------------
 * 20.0 - Booking form functionality
 * ------------------------------------------------------------------------------------------
 */

include( PINAR_FUNCTIONS_PATH . 'booking-form-funcs.php' );

/**
 * ------------------------------------------------------------------------------------------
 * 21.0 - Get the Pages URL
 * ------------------------------------------------------------------------------------------
 */

include( PINAR_FUNCTIONS_PATH . 'get-pages.php' );

/**
 * ------------------------------------------------------------------------------------------
 * 24.0 - Update the booking table when a booking post was deleted
 * ------------------------------------------------------------------------------------------
 */

include( PINAR_FUNCTIONS_PATH . 'update-booking-table.php' );

/**
 * ------------------------------------------------------------------------------------------
 * 25.0 - Include Ravis NewsLetter Widget
 * ------------------------------------------------------------------------------------------
 */

include( PINAR_WIDGET_PATH . 'ravis-news-letter.php' );

/**
 * ------------------------------------------------------------------------------------------
 * 26 - Limit the search result for Posts
 * ------------------------------------------------------------------------------------------
 */

if( !function_exists('ravis_fn_search_filter') )
{
	function ravis_fn_search_filter($query)
	{
		global $pinar_opt;

		if(empty($pinar_opt['opt-search-in-pages'])){
			if ($query->is_search)
			{
				$query->set('post_type', 'post');
			}
			return $query;
		}
	}
}
add_filter('pre_get_posts','ravis_fn_search_filter');

/**
 * ------------------------------------------------------------------------------------------
 * 27 - Excerpt setting of blog
 * ------------------------------------------------------------------------------------------
 */

include( PINAR_FUNCTIONS_PATH . 'excerpt-setting.php' );

/**
 * ------------------------------------------------------------------------------------------
 * 28 - Link Posts links
 * ------------------------------------------------------------------------------------------
 */
if(!function_exists('ravis_fn_get_link_url'))
{
	function ravis_fn_get_link_url() {
		$has_url = get_url_in_content( get_the_content() );

		return $has_url ? $has_url : apply_filters( 'the_permalink', get_permalink() );
	}
}

/**
 * ------------------------------------------------------------------------------------------
 * 29 - Insert the Testimonials from frontend by Ajax
 * ------------------------------------------------------------------------------------------
 */

include( PINAR_FUNCTIONS_PATH . 'insert-testimonials.php' );

/**
 * ------------------------------------------------------------------------------------------
 * 30 - Breadcrumb background function
 * It will be generated the background image of breadcrumb
 * ------------------------------------------------------------------------------------------
 */
include( PINAR_FUNCTIONS_PATH . 'set-breadcrumb-bg.php' );


/**
 * ------------------------------------------------------------------------------------------
 * 31 - Booking Confirmation Notification Function
 * ------------------------------------------------------------------------------------------
 */
include( PINAR_FUNCTIONS_PATH . 'booking-confrim-notification.php' );

/**
 * ------------------------------------------------------------------------------------------
 * 32 - Include demo style if it was available in package
 * ------------------------------------------------------------------------------------------
 */
if(file_exists(PINAR_WIDGET_PATH . 'ravis-demo-styler.php'))
{
	include( PINAR_WIDGET_PATH . 'ravis-demo-styler.php' );
}

/**
 * ------------------------------------------------------------------------------------------
 * 33 - Get booking information by ajax ( used for booking overview )
 * ------------------------------------------------------------------------------------------
 */
include( PINAR_FUNCTIONS_PATH . 'get-booking-info.php' );


/**
 * ------------------------------------------------------------------------------------------
 * 34 - Convert the currency to HTML entity
 * ------------------------------------------------------------------------------------------
 */
include( PINAR_FUNCTIONS_PATH . 'currency-converter.php' );


/**
 * ------------------------------------------------------------------------------------------
 * 35 - Enqueue Google Font
 * ------------------------------------------------------------------------------------------
 */
include( PINAR_FUNCTIONS_PATH . 'google-font-enqueue.php' );

/**
 * ------------------------------------------------------------------------------------------
 * 36 - Email notification function
 * ------------------------------------------------------------------------------------------
 */
include( PINAR_FUNCTIONS_PATH . 'notifier-emails.php' );

/**
 * ------------------------------------------------------------------------------------------
 * 37 - Check the current season
 * ------------------------------------------------------------------------------------------
 */
include( PINAR_FUNCTIONS_PATH . 'check-season.php' );

/**
 * ------------------------------------------------------------------------------------------
 * 38 - Price Generator
 * ------------------------------------------------------------------------------------------
 */
include( PINAR_FUNCTIONS_PATH . 'price-generator.php' );

/**
 * ------------------------------------------------------------------------------------------
 * 39 - Google Analytics
 * ------------------------------------------------------------------------------------------
 */
if(!function_exists('add_googleanalytics')){
	function add_googleanalytics() {
		global $pinar_opt;
		if(!empty($pinar_opt['opt-google-analytics'])){
			echo  balancetags( $pinar_opt['opt-google-analytics'] );			
		}
	}
}
add_action('wp_footer', 'add_googleanalytics');