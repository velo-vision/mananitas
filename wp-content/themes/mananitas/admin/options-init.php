<?php

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    // This is your option name where all the Redux data is stored.
    $opt_name = "pinar_opt";

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    load_theme_textdomain( 'pinar', get_template_directory() . '/languages' );

	Redux::setExtensions( $opt_name, dirname( __FILE__ ) . '/extensions/' );

    $args = array(
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => 'Pinar Theme Options',
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => esc_html__( 'Pinar Theme Options', 'pinar' ),
        'page_title'           => esc_html__( 'Pinar Theme Options', 'pinar' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => true,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '_options',
        // Page slug used to denote the panel
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        
        'compiler'             => true,

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'light',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    Redux::setArgs( $opt_name, $args );

    // Set the help sidebar
    $content = '';
    Redux::setHelpSidebar( $opt_name, $content );

    Redux::setSection( $opt_name, array(
        'title'     => esc_html__('Main Settings', 'pinar'),
        'desc'      => esc_html__('Main setting of Pinar theme is', 'pinar'),
        'icon'      => 'el-icon-home',
        // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
        'fields'    => array(
            array(
                'id'        => 'opt-preset',
                'type'      => 'image_select',
                'title'     => esc_html__('Preset Colors', 'pinar'),
                'subtitle'  => esc_html__('Select the default preset color for the theme.', 'pinar'),
                'options'   => array(
                    '0' => array('title' => esc_html__('Preset 1','pinar'), 'img' => PINAR_IMG_PATH.'presets/1.png'),
                    '1' => array('title' => esc_html__('Preset 2','pinar'), 'img' => PINAR_IMG_PATH.'presets/3.png'),
                    '2' => array('title' => esc_html__('Preset 3','pinar'), 'img' => PINAR_IMG_PATH.'presets/4.png'),
                    '3' => array('title' => esc_html__('Preset 4','pinar'), 'img' => PINAR_IMG_PATH.'presets/2.png'),
                    '4' => array('title' => esc_html__('Preset 5','pinar'), 'img' => PINAR_IMG_PATH.'presets/5.png'),
                    '5' => array('title' => esc_html__('Preset 6','pinar'), 'img' => PINAR_IMG_PATH.'presets/7.png'),
                    '6' => array('title' => esc_html__('Preset 7','pinar'), 'img' => PINAR_IMG_PATH.'presets/8.png'),
                    '7' => array('title' => esc_html__('Preset 8','pinar'), 'img' => PINAR_IMG_PATH.'presets/6.png'),
                ),
                'default'   => '0'
            ),
            array(
                'id'        => 'opt-layout',
                'type'      => 'image_select',
                'title'     => esc_html__('Main Layout', 'pinar'),
                'subtitle'  => esc_html__('Select the default layout of the theme.', 'pinar'),
                'options'   => array(
                    '1' => array('title' => esc_html__('Wide', 'pinar'), 'img' => PINAR_IMG_PATH.'layout/1.png'),
                    '2' => array('title' => esc_html__('Boxed', 'pinar'), 'img' => PINAR_IMG_PATH.'layout/2.png'),
                ),
                'default'   => '1'
            ),
            array(
                'id'        => 'opt-pattern',
                'type'      => 'image_select',
                'title'     => esc_html__('Background Pattern', 'pinar'),
                'subtitle'  => esc_html__('Select the background pattern. Note: it will be shown JUST in "Boxed" layout.', 'pinar'),
                'options'   => array(
                    '1' => array('title' => esc_html__('Pattern 1','pinar'), 'img' => PINAR_IMG_PATH.'pattern/thumb/1.png'),
                    '2' => array('title' => esc_html__('Pattern 2','pinar'), 'img' => PINAR_IMG_PATH.'pattern/thumb/2.png'),
                    '3' => array('title' => esc_html__('Pattern 3','pinar'), 'img' => PINAR_IMG_PATH.'pattern/thumb/3.png'),
                    '4' => array('title' => esc_html__('Pattern 4','pinar'), 'img' => PINAR_IMG_PATH.'pattern/thumb/4.png'),
                    '5' => array('title' => esc_html__('Pattern 5','pinar'), 'img' => PINAR_IMG_PATH.'pattern/thumb/5.png'),
                    '6' => array('title' => esc_html__('Pattern 6','pinar'), 'img' => PINAR_IMG_PATH.'pattern/thumb/6.png'),
                    '7' => array('title' => esc_html__('Pattern 7','pinar'), 'img' => PINAR_IMG_PATH.'pattern/thumb/7.png'),
                    '8' => array('title' => esc_html__('Pattern 8','pinar'), 'img' => PINAR_IMG_PATH.'pattern/thumb/8.png'),
                    '9' => array('title' => esc_html__('Pattern 9','pinar'), 'img' => PINAR_IMG_PATH.'pattern/thumb/9.png'),
                    '10' => array('title' => esc_html__('Pattern 10','pinar'), 'img' => PINAR_IMG_PATH.'pattern/thumb/10.png'),
                    '11' => array('title' => esc_html__('Pattern 11','pinar'), 'img' => PINAR_IMG_PATH.'pattern/thumb/11.png'),
                    '12' => array('title' => esc_html__('Pattern 12','pinar'), 'img' => PINAR_IMG_PATH.'pattern/thumb/12.png'),
                ),
                'default'   => '1'
            ),
            array(
                'id'        => 'opt-hotel-name',
                'type'      => 'text',
                'title'     => esc_html__('Hotel Name', 'pinar'),
                'subtitle'  => esc_html__('This name will be replaced with the "Pinar" in the top logo of website.', 'pinar'),
                'desc'      => esc_html__('Please add one word like "Pinar", "Hilton", "Armani" and etc.', 'pinar'),
                'default'   => 'Pinar'
            ),
            array(
                'id'        => 'opt-hotel-stars',
                'type'      => 'select',
                'title'     => esc_html__('Hotel Stars', 'pinar'),
                'subtitle'  => esc_html__('Select how many stars your hotel has.', 'pinar'),
                'options'  => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                ),
                'default'  => '5',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'        => 'logo-image-normal',
                'type'      => 'media',
                'title'     => esc_html__('Your Logo', 'pinar'),
                'desc'      => esc_html__('Please provide ".png" or ".jpg" format of your logo and upload suitable size of it. Leave it blank if you want to use the default format of template\'s logo', 'pinar'),
                'subtitle'  => esc_html__('Upload your Hotel\'s Logo. It will be replaced with the default logo of template.', 'pinar'),
            ),
            array(
                'id'        => 'opt-footer-text',
                'type'      => 'textarea',
                'title'     => esc_html__('Footer Text', 'pinar'),
                'subtitle'  => esc_html__('Putt the text you want to be shown in footer in this field.', 'pinar'),
                'desc'      => esc_html__('Do not use HTML tags.', 'pinar'),
                'validate'  => 'no_html',
                'default'   => esc_html__('© 2014 Pinar. All Rights Reserved.','pinar')
            ),
            array(
                'id'        => 'opt-sticky-header',
                'type'      => 'switch',
                'title'     => esc_html__('Sticky Header', 'pinar'),
                'subtitle'  => esc_html__('Enable / Disable the sticky header in all pages.', 'pinar'),
                'default'   => true,
            ),
            array(
                'id'        => 'opt-trans-header',
                'type'      => 'switch',
                'title'     => esc_html__('Transparent Header', 'pinar'),
                'subtitle'  => esc_html__('Enable / Disable the transparency of header in all pages.', 'pinar'),
                'default'   => true,
            ),
            array(
                'id'        => 'opt-call-action',
                'type'      => 'switch',
                'title'     => esc_html__('Call to Action Box', 'pinar'),
                'subtitle'  => esc_html__('Enable / Disable the default call to action box in footer.', 'pinar'),
                'default'   => true,
            ),
            array(
                'id'        => 'opt-breadcrumb-bg',
                'type'      => 'media',
                'title'     => esc_html__('Default Breadcrumb Background', 'pinar'),
                'desc'      => esc_html__('Please provide ".png" or ".jpg" format as background of breadcrumb in all pages.', 'pinar'),
            ),
            array(
                'id'        => 'opt-search-in-pages',
                'type'      => 'switch',
                'title'     => esc_html__('Include Pages in search result', 'pinar'),
                'subtitle'  => esc_html__('By enabling or disabling this option you can include/exclude the pages from the search result', 'pinar'),
                'default'   => false,
            ),
            array(
                'id'        => 'opt-smooth-scroll',
                'type'      => 'switch',
                'title'     => esc_html__('Enable Smooth Scrolling', 'pinar'),
                'subtitle'  => esc_html__('Enable/Disable smooth scrolling on your website.', 'pinar'),
                'default'   => true,
            ),
            array(
                'id'        => 'opt-custom-css',
                'type'      => 'ace_editor',
                'title'     => esc_html__('CSS Code', 'pinar'),
                'subtitle'  => esc_html__('Paste your CSS code here.', 'pinar'),
                'mode'      => 'css',
                'theme'     => 'monokai',
                'desc'      => esc_html__('These codes will be added to all pages before </head>', 'pinar'),
            ),
            array(
                'id'       => 'opt-google-analytics',
                'type'     => 'ace_editor',
                'title'    => __('CSS Code', 'pinar'),
                'subtitle' => __('Paste your Google Analytics code code here.', 'pinar'),
                'mode'     => 'html',
                'theme'    => 'monokai'
            )
        ),
    ) );

    Redux::setSection( $opt_name, array(
        'title'     => esc_html__('Contact Information', 'pinar'),
        'desc'      => esc_html__('Manage the contact information of Hotel', 'pinar'),
        'icon'      => 'el-icon-envelope',
        // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
        'fields'    => array(
            array(
                'id'        => 'opt-contact-text',
                'type'      => 'textarea',
                'title'     => esc_html__('Contact page text', 'pinar'),
                'subtitle'  => esc_html__('This text will be shown in the contact page ( above all the text )', 'pinar'),
            ),
            array(
                'id'        => 'opt-hotel-address',
                'type'      => 'text',
                'title'     => esc_html__('Address', 'pinar'),
                'subtitle'  => esc_html__('Put the address of Hotel in this field', 'pinar'),
            ),
            array(
                'id'        => 'opt-hotel-email',
                'type'      => 'text',
                'title'     => esc_html__('Email', 'pinar'),
                'subtitle'  => esc_html__('Put the email of the hotel in this field.', 'pinar'),
                'validate'  => 'email',
                'msg'       => esc_html__('', 'pinar'),
                'default'   => 'Pinar@gmail.com',
            ),
            array(
                'id'        => 'opt-hotel-phone',
                'type'      => 'text',
                'title'     => esc_html__('Phone', 'pinar'),
                'subtitle'  => esc_html__('Add the phone number of your hotel.', 'pinar'),
            ),
			array(
				'id'        => 'opt-map-marker',
				'type'      => 'media',
				'title'     => esc_html__('Map Marker', 'pinar'),
				'desc'      => esc_html__('Please provide ".png" format for showing your location on Map.', 'pinar'),
			),
            array(
                'id'        => 'opt-map-lat',
                'type'      => 'text',
                'title'     => esc_html__('Location Latitude', 'pinar'),
                'subtitle'  => esc_html__('Add the latitude of your website in this field.', 'pinar'),
                'default'   => 40.6700
            ),
            array(
                'id'        => 'opt-map-lng',
                'type'      => 'text',
                'title'     => esc_html__('Location Longitude', 'pinar'),
                'subtitle'  => esc_html__('Add the latitude of your website in this field.', 'pinar'),
                'default'   => -73.9400
            ),
            array(
                'id'        => 'opt-map-api',
                'type'      => 'text',
                'title'     => esc_html__('Google Map API Key', 'pinar'),
                'subtitle'  => esc_html__('Please add your Google map API key in this field.', 'pinar'),
                'desc'      => esc_html__('You can create your own API key from https://developers.google.com/maps/documentation/javascript/get-api-key', 'pinar'),
            ),
        ),
    ) );  

    Redux::setSection( $opt_name, array(
        'title'     => esc_html__('Blog Setting', 'pinar'),
        'desc'      => esc_html__('Manage the setting of Blog page.', 'pinar'),
        'icon'      => 'el el-list-alt',
        // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
        'fields'    => array(
            array(
                'id'        => 'pinar-blog-type',
                'type'     => 'button_set',
                'title'     => esc_html__('Excerpt Or Full Blog Content', 'pinar'),
                'subtitle'  => esc_html__('Show excerpt or Full Blog Content On Blog Pages.', 'pinar'),
                'options'  => array(
                    '1' => esc_html__('Excerpt', 'pinar'),
                    '2' => esc_html__('Full', 'pinar')
                ),
                'default'  => '1'
            ),
            array(
                'id'        => 'opt-excerpt-length',
                'type'      => 'text',
                'title'     => esc_html__('Excerpt Length', 'pinar'),
                'subtitle'  => esc_html__('Set how many character do you want to show in excerpts.', 'pinar'),
                'default'   => '65',
            ),
            array(
                'id'        => 'opt-read-more-text',
                'type'      => 'text',
                'title'     => esc_html__('Read More Text', 'pinar'),
                'subtitle'  => esc_html__('Change the "Read More" text of Post archive.', 'pinar'),
                'default'   => esc_html__('Continue Reading ...', 'pinar')
            ),
            array(
                'id'        => 'opt-blog-breadcrumb-bg',
                'type'      => 'media',
                'title'     => esc_html__('Blog Breadcrumb Background', 'pinar'),
                'desc'      => esc_html__('Please provide ".png" or ".jpg" format as background of breadcrumb in all pages.', 'pinar'),
            ),
        ),
    ) );

    Redux::setSection( $opt_name, array(
       'title'     => esc_html__('Typography', 'pinar'),
        'desc'      => esc_html__('Customize font of all section of theme', 'pinar'),
        'icon'      => 'el-icon-font',
        'fields'    => array(
            array(
                'id'            => 'opt-main-font',
                'type'          => 'typography',
                'title'         => esc_html__('Main Font and Color', 'pinar'),
                'font-backup'   => false,    // Select a backup non-google font in addition to a google font
                'subsets'       => false, // Only appears if google is true and subsets not set to false
                'preview'       => false, // Disable the previewer
                'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                'units'         => 'px', // Defaults to px
                'output'        => array('body'), // An array of CSS selectors to apply this font style to dynamically
                'subtitle'      => esc_html__('Setting of the main font of the theme.', 'pinar')
            ),
            array(
                'id'        => 'pinar-latin-ext',
                'type'      => 'switch',
                'title'     => esc_html__('Latin Extended Support', 'pinar'),
                'subtitle'  => esc_html__('Enable / Disable Latin Extended support for the Google fonts', 'pinar'),
                'default'   => false,
            ),
            array(
                'id'        => 'pinar-cyrillic',
                'type'      => 'switch',
                'title'     => esc_html__('Cyrillic Extended Support', 'pinar'),
                'subtitle'  => esc_html__('Enable / Disable Cyrillic Extended support for the Google fonts', 'pinar'),
                'default'   => false,
            ),
        ), 

    ) );

    Redux::setSection( $opt_name, array(
        'title'     => esc_html__('Social Icons', 'pinar'),
        'desc'      => esc_html__('Manage the hotel social links. The empty field will not be shown in frontend.', 'pinar'),
        'icon'      => 'el-icon-facebook',
        'fields'    => array(
            array(
                'id'        => 'opt-social-twitter',
                'type'      => 'text',
                'title'     => esc_html__('Twitter', 'pinar'),
                'subtitle'  => esc_html__('Add twitter google plus link in this field.', 'pinar')
            ),
            array(
                'id'        => 'opt-social-facebook',
                'type'      => 'text',
                'title'     => esc_html__('Facebook', 'pinar'),
                'subtitle'  => esc_html__('Add the facebook plus link in this field.', 'pinar')
            ),
            array(
                'id'        => 'opt-social-gplus',
                'type'      => 'text',
                'title'     => esc_html__('Google Plus', 'pinar'),
                'subtitle'  => esc_html__('Add gplus google plus link in this field.', 'pinar')
            ),
            array(
                'id'        => 'opt-social-flickr',
                'type'      => 'text',
                'title'     => esc_html__('Flickr', 'pinar'),
                'subtitle'  => esc_html__('Add flickr google plus link in this field.', 'pinar')
            ),
            array(
                'id'        => 'opt-social-vimeo',
                'type'      => 'text',
                'title'     => esc_html__('Vimeo', 'pinar'),
                'subtitle'  => esc_html__('Add vimeo google plus link in this field.', 'pinar')
            ),
            array(
                'id'        => 'opt-social-youtube',
                'type'      => 'text',
                'title'     => esc_html__('Youtube', 'pinar'),
                'subtitle'  => esc_html__('Add youtube google plus link in this field.', 'pinar')
            ),
            array(
                'id'        => 'opt-social-pinterest',
                'type'      => 'text',
                'title'     => esc_html__('Pinterest', 'pinar'),
                'subtitle'  => esc_html__('Add the pinterest plus link in this field.', 'pinar')
            ),
            array(
                'id'        => 'opt-social-tumblr',
                'type'      => 'text',
                'title'     => esc_html__('Tumblr', 'pinar'),
                'subtitle'  => esc_html__('Add tumblr google plus link in this field.', 'pinar')
            ),
            array(
                'id'        => 'opt-social-dribbble',
                'type'      => 'text',
                'title'     => esc_html__('Dribbble', 'pinar'),
                'subtitle'  => esc_html__('Add the dribbble plus link in this field.', 'pinar')
            ),
            array(
                'id'        => 'opt-social-digg',
                'type'      => 'text',
                'title'     => esc_html__('Digg', 'pinar'),
                'subtitle'  => esc_html__('Add digg google plus link in this field.', 'pinar')
            ),
            array(
                'id'        => 'opt-social-linkedin',
                'type'      => 'text',
                'title'     => esc_html__('Linkedin', 'pinar'),
                'subtitle'  => esc_html__('Add the linkedin plus link in this field.', 'pinar')
            ),
            array(
                'id'        => 'opt-social-blogger',
                'type'      => 'text',
                'title'     => esc_html__('Blogger', 'pinar'),
                'subtitle'  => esc_html__('Add blogger google plus link in this field.', 'pinar')
            ),
            array(
                'id'        => 'opt-social-skype',
                'type'      => 'text',
                'title'     => esc_html__('Skype', 'pinar'),
                'subtitle'  => esc_html__('Add skype google plus link in this field.', 'pinar')
            ),
            array(
                'id'        => 'opt-social-forrst',
                'type'      => 'text',
                'title'     => esc_html__('Forrst', 'pinar'),
                'subtitle'  => esc_html__('Add forrst google plus link in this field.', 'pinar')
            ),
            array(
                'id'        => 'opt-social-deviantart',
                'type'      => 'text',
                'title'     => esc_html__('Deviantart', 'pinar'),
                'subtitle'  => esc_html__('Add the deviantart plus link in this field.', 'pinar')
            ),
            array(
                'id'        => 'opt-social-yahoo',
                'type'      => 'text',
                'title'     => esc_html__('Yahoo', 'pinar'),
                'subtitle'  => esc_html__('Add yahoo google plus link in this field.', 'pinar')
            ),
            array(
                'id'        => 'opt-social-reddit',
                'type'      => 'text',
                'title'     => esc_html__('Reddit', 'pinar'),
                'subtitle'  => esc_html__('Add reddit google plus link in this field.', 'pinar')
            ),
        ),

    ) );

    Redux::setSection( $opt_name, array(
        'title'     => esc_html__('Breadcrumb Setting', 'pinar'),
        'desc'      => esc_html__('Manage the image background of breadcrumb in some special pages. These images will be overridden the default background image.', 'pinar'),
        'icon'      => 'el el-website',
        'fields'    => array(
            array(
                'id'        => 'opt-guestbook-breadcrumb-bg',
                'type'      => 'media',
                'title'     => esc_html__('Guest Book Breadcrumb Background', 'pinar'),
                'desc'      => esc_html__('Please provide ".png" or ".jpg" format as background of breadcrumb in all pages.', 'pinar'),
            ),
            array(
                'id'        => 'opt-rooms-breadcrumb-bg',
                'type'      => 'media',
                'title'     => esc_html__('Room Breadcrumb Background', 'pinar'),
                'desc'      => esc_html__('Please provide ".png" or ".jpg" format as background of breadcrumb in all pages.', 'pinar'),
            ),
            array(
                'id'        => 'opt-gallery-breadcrumb-bg',
                'type'      => 'media',
                'title'     => esc_html__('Gallery Breadcrumb Background', 'pinar'),
                'desc'      => esc_html__('Please provide ".png" or ".jpg" format as background of breadcrumb in all pages.', 'pinar'),
            ),
            array(
                'id'        => 'opt-404-breadcrumb-bg',
                'type'      => 'media',
                'title'     => esc_html__('404 Breadcrumb Background', 'pinar'),
                'desc'      => esc_html__('Please provide ".png" or ".jpg" format as background of breadcrumb in all pages.', 'pinar'),
            )
        ),

    ) );
    
    Redux::setSection( $opt_name, array(
        'title'     => esc_html__('Gallery', 'pinar'),
        'desc'      => esc_html__('Manage the images which is shown in the Gallery pages and the Gallery shortcode', 'pinar'),
        'icon'      => 'el-icon-picture',
        'fields'    => array(
            array(
                'id'        => 'opt-default-gallery',
                'type'      => 'select',
                'title'     => esc_html__('Default Gallery Layout', 'pinar'),
                'subtitle'  => esc_html__('Select the default layout of your Gallery, the "More ..." url of shortcode gallery will be generated based in this field.', 'pinar'),
                'options'  => array(
                    '1' => 'Masonry',
                    '2' => 'Grid',
                    '3' => 'FullScreen',
                ),
                'default'  => '1',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'        => 'pinar-gallery-sort',
                'type'      => 'text',
                'title'     => esc_html__('Sort Options', 'pinar'),
                'subtitle'  => esc_html__('Add the sort option and separate them with "," like "<b>All,Bars,Pools</b>"', 'pinar'),
                'default'   => 'All,Restaurant,Bars,Pool,Rooms,Lobby'
            ),
            array(
                'id'        => 'pinar-main-gallery',
                'type'      => 'gallery',
                'title'     => esc_html__('Manage The Main Gallery', 'pinar'),
                'subtitle'  => esc_html__('Manage the image you want to show in Gallery Pages and Gallery shortcode.', 'pinar'),
            ),
            array(
                'id'        => 'pinar-fullscreen-gallery',
                'type'      => 'gallery',
                'title'     => esc_html__('Manage The Image of Fullscreen Gallery', 'pinar'),
                'subtitle'  => esc_html__('Manage the image you want to show in Fullscreen gallery page.', 'pinar'),
            )
        ),

    ) );

    Redux::setSection( $opt_name, array(
        'title'     => esc_html__('Booking Setting', 'pinar'),
        'desc'      => esc_html__('Manage some setting of Booking Page of template', 'pinar'),
        'icon'      => 'el-icon-file-edit',
        'fields'    => array(
            array(
                'id'       => 'pinar-booking-currency',
                'type'     => 'select',
                'title'    => esc_html__( 'Booking Currency', 'pinar' ),
                'subtitle' => esc_html__( 'Select the currency of website.', 'pinar' ),
                'desc'     => esc_html__( 'This is the description field, again good for additional info.', 'pinar' ),
                'options' => array(
                    '\u60b;'  => '&#1547;', 
                    '\u0024;' => '&#36;',
                    '\u9f3;'  => '&#2547;',
                    '\u17db;' => '&#6107;',
                    '\u00a5;' => '&#165;',
                    '\u20a1;' => '&#8353;',
                    '\u20b1;' => '&#8369;',                            
                    '\u00a3;' => '&#163;',
                    '\u20a1;' => '&#8353;',
                    '\u20ac;' => '&#8364;',                          
                    '\u20b5;' => '&#8373;',
                    '\u20b9;' => '&#8377;',
                    '\u20bd;' => '&#8381;',
                    '\ufdfc;' => '&#65020;',                            
                    '\u20aa;' => '&#8362;',
                    '\u00a5;' => '&#165;',
                    '\u20b8;' => '&#8376;',
                    '\u20a9;' => '&#8361;',                            
                    '\u20ad;' => '&#8365;',
                    '\u20ae;' => '&#8366;',
                    '\u20a6;' => '&#8358;',
                    '\u20b2;' => '&#8370;',
                    '\u20b1;' => '&#8369;',
                    '\u0e3f;' => '&#3647;',
                    '\u20b4;' => '&#8372;',
                    '\u20ab;' => '&#8363;',
                    '\ufdfc;' => '&#65020;',
                    '\u058F;' => '&#1423;',
                    '\u5270;' => '&#82;&#112;',
                    'MAD'     => 'MAD',
                    'AED'     => 'AED'                    

                ),
                'default'  => '&#36;',
                'select2'  => array( 'allowClear' => false )
            ),
            array(
                'id'        => 'pinar-booking-title',
                'type'      => 'text',
                'title'     => esc_html__('Booking Title', 'pinar'),
                'subtitle'  => esc_html__('Add the title of Booking Section', 'pinar'),
                'default'   => 'Book Now'
            ),
            array(
                'id'        => 'pinar-booking-desc',
                'type'      => 'textarea',
                'title'     => esc_html__('Booking Description', 'pinar'),
                'subtitle'  => esc_html__('Add the text you want to be shown in the booking page.', 'pinar'),
                'desc'      => esc_html__('Do not use HTML tags.', 'pinar'),
                'validate'  => 'no_html',
            ),
            array(
                'id'        => 'pinar-booking-complete-text',
                'type'      => 'textarea',
                'title'     => esc_html__('Booking Complete Text', 'pinar'),
                'subtitle'  => esc_html__('Putt the text you want to be shown in last steps of booking in this field.', 'pinar'),
                'desc'      => esc_html__('Do not use HTML tags.', 'pinar'),
                'validate'  => 'no_html',
                'default'   => esc_html__('For more information you can contact us via contact form of website!','pinar')
            ),
            array(
                'id'        => 'pinar-email-notification',
                'type'      => 'switch',
                'title'     => esc_html__('Email Notification', 'pinar'),
                'subtitle'  => esc_html__('Enable / Disable email notification system of booking process', 'pinar'),
                'default'   => true,
            ),
            array(
                'id'       => 'pinar-email-sender',
                'type'     => 'text',
                'title'    => esc_html__('Email Sender', 'pinar'),
                'subtitle' => esc_html__('Add an email that you want all email will be sent by it.', 'pinar'),
                'desc'     => esc_html__('Please create an email in your host and add it here. Example : "noreply@example.com"', 'pinar'),
                'validate' => 'email',
            ),
            array(
                'id'       => 'pinar-email-receiver',
                'type'     => 'multi_text',
                'title'    => esc_html__( 'Email Receiver', 'pinar' ),
                'desc'     => esc_html__( 'Add the emails you want to receive the notifications.', 'pinar' ),
                'validate' => 'email',
            ),
            array(
                'id'         => 'pinar-admin-email-template',
                'type'       => 'editor',
                'title'      => esc_html__( 'Email template of admins', 'pinar' ),
                'subtitle'   => esc_html__('This template will be used for emails which will be sent for admin of website.', 'pinar'),
                'desc'       => esc_html__( 'For putting the booking url with the text please use this shortcode in the above editor.[user-booking-url]YOUR TEXT[/user-booking-url], here is the list of shortcode that you can use in this field : [guest-first-name], [guest-last-name], [guest-email], [guest-tel], [guest-city], [guest-address], [guest-special-requirement], [guest-check-in], [guest-check-out], [guest-adult], [guest-child], [guest-room-list], [guest-booking-total-price]', 'pinar' ),
                'default'    => esc_html__('Please check the new booking information and confirmed it if it was OK, here is the edit link : [user-booking-url]link[/user-booking-url]', 'pinar'),
                'full_width' => true
            ),
            array(
                'id'         => 'pinar-users-email-template',
                'type'       => 'editor',
                'title'      => esc_html__( 'Email template of users', 'pinar' ),    
                'subtitle'   => esc_html__('This template will be used for users who booked on your website.', 'pinar'),                    
                'desc'       => esc_html__( 'For using the booking ID in your message, please use this shortcode( [user-booking-id] ). Also you can use [guest-name] and [guest-family-name] in your message', 'pinar' ),
                'default'    => esc_html__('Congratulations, [guest-name] [guest-family-name],<br> Your booking information with the ID of [user-booking-id] is confirmed now and we are glad to be your host in our Hotel.' , 'pinar'),
                'full_width' => true
            )
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'     => esc_html__('Restaurant', 'pinar'),
        'desc'      => esc_html__('Manage the restaurant setting of hotel', 'pinar'),
        'icon'      => 'el-icon-glass'
    ) );

    Redux::setSection( $opt_name, array(
        'title'     => esc_html__('Welcome Section', 'pinar'),
        'subsection' => true,
        'fields'    => array(
            array(
                'id'        => 'restaurant-welcome-title',
                'type'      => 'text',
                'title'     => esc_html__('Welcome Title', 'pinar'),
                'subtitle'  => esc_html__('Add the title of Welcome section of Restaurant', 'pinar'),
            ),
            array(
                'id'        => 'restaurant-welcome-subtitle',
                'type'      => 'text',
                'title'     => esc_html__('Welcome Subtitle', 'pinar'),
                'subtitle'  => esc_html__('Add some text as subtitle of Welcome section of Restaurant. Leave it blank if you don\'t want to have subtitle', 'pinar'),
            ),
            array(
                'id'        => 'restaurant-welcome-banner',
                'type'      => 'media',
                'title'     => esc_html__('Welcome Banner', 'pinar'),
                'desc'      => esc_html__('Upload an image as a welcome banner.', 'pinar'),
            ),
            array(
                'id'        => 'restaurant-welcome-text',
                'type'      => 'textarea',
                'title'     => esc_html__('Welcome Text', 'pinar'),
                'subtitle'  => esc_html__('Add some text as welcome text.', 'pinar'),
                'desc'      => esc_html__('Do not use HTML tags.', 'pinar'),
                'validate'  => 'no_html'
            ),
            array(
                'id'        => 'restaurant-welcome-cite',
                'type'      => 'text',
                'title'     => esc_html__('Welcome text author', 'pinar'),
                'subtitle'  => esc_html__('Add the author of welcome text like "John Doe - Kitchen Lead"', 'pinar'),
            )
        ),

    ) );

    Redux::setSection( $opt_name, array(
        'title'     => esc_html__('Special Dishes', 'pinar'),
        'subsection' => true,
        'fields'    => array(
            array(
                'id'        => 'restaurant-dishes-title',
                'type'      => 'text',
                'title'     => esc_html__('Special Dishes Title', 'pinar'),
                'subtitle'  => esc_html__('Add the title of Special Dishes section of Restaurant', 'pinar'),
            ),
            array(
                'id'          => 'restaurant-dishes-slides',
                'type'        => 'slides',
                'title'       => esc_html__( 'Special Dishes', 'pinar' ),
                'subtitle'    => esc_html__( 'Add Special Dishes details in every slides.', 'pinar' ),
                'placeholder' => array(
                    'title'       => esc_html__( 'Title', 'pinar' ),
                    'description' => esc_html__( 'Description', 'pinar' ),
                    'url'         => esc_html__( 'Price', 'pinar' ),
                ),
            ),
        ),

    ) );

    Redux::setSection( $opt_name, array(
        'title'     => esc_html__('Promo Section', 'pinar'),
        'subsection' => true,
        'fields'    => array(
            array(
                'id'        => 'restaurant-promo-background',
                'type'      => 'media',
                'title'     => esc_html__('Background', 'pinar'),
                'desc'      => esc_html__('Upload an image as background.', 'pinar'),
            ),
            array(
                'id'        => 'restaurant-promo-title',
                'type'      => 'text',
                'title'     => esc_html__('Promo Title', 'pinar'),
                'subtitle'  => esc_html__('Add some text as Title of Promo section of Restaurant.', 'pinar'),
            ),
            array(
                'id'        => 'restaurant-promo-subtitle',
                'type'      => 'text',
                'title'     => esc_html__('Promo Subtitle', 'pinar'),
                'subtitle'  => esc_html__('Add some text as subtitle of Promo section of Restaurant. Leave it blank if you don\'t want to have subtitle', 'pinar'),
            ),
        ),

    ) );

    Redux::setSection( $opt_name, array(
        'title'     => esc_html__('Menu', 'pinar'),
        'subsection' => true,
        'fields'    => array(
            array(
                'id'        => 'restaurant-menu-title',
                'type'      => 'text',
                'title'     => esc_html__('Menu Title', 'pinar'),
                'subtitle'  => esc_html__('Add some text as Title of Menu section of Restaurant.', 'pinar'),
            ),
            array(
                'id'        => 'restaurant-menu-subtitle',
                'type'      => 'text',
                'title'     => esc_html__('Menu Subtitle', 'pinar'),
                'subtitle'  => esc_html__('Add some text as subtitle of Menu section of Restaurant. Leave it blank if you don\'t want to have subtitle', 'pinar'),
            ),
            array(
                'id'        => 'restaurant-menu-breakfast-chef',
                'type'      => 'text',
                'title'     => esc_html__('Breakfast Chef Selection', 'pinar'),
                'subtitle'  => esc_html__('Add the title of food which is selected as "Chef Selection"', 'pinar'),
            ),
            array(
                'id'       => 'restaurant-menu-breakfast',
                'type'     => 'multi_text',
                'title'    => esc_html__( 'Breakfast Menu', 'pinar' ),
                'desc'     => esc_html__( 'Separate the title and price with "---" for example "<b>Crab With Curry Sources---14.10</b>"', 'pinar' )
            ),
            array(
                'id'        => 'restaurant-menu-lunch-chef',
                'type'      => 'text',
                'title'     => esc_html__('Lunch Chef Selection', 'pinar'),
                'subtitle'  => esc_html__('Add the title of food which is selected as "Chef Selection"', 'pinar'),
            ),
            array(
                'id'       => 'restaurant-menu-lunch',
                'type'     => 'multi_text',
                'title'    => esc_html__( 'Lunch Menu', 'pinar' ),
                'desc'     => esc_html__( 'Separate the title and price with "---" for example "<b>Crab With Curry Sources---14.10</b>"', 'pinar' )
            ),
            array(
                'id'        => 'restaurant-menu-dinner-chef',
                'type'      => 'text',
                'title'     => esc_html__('Dinner Chef Selection', 'pinar'),
                'subtitle'  => esc_html__('Add the title of food which is selected as "Chef Selection"', 'pinar'),
            ),
            array(
                'id'       => 'restaurant-menu-dinner',
                'type'     => 'multi_text',
                'title'    => esc_html__( 'Dinner Menu', 'pinar' ),
                'desc'     => esc_html__( 'Separate the title and price with "---" for example "<b>Crab With Curry Sources---14.10</b>"', 'pinar' )
            ),
        ),

    ) );

    Redux::setSection( $opt_name, array(
        'title'     => esc_html__('Sliders', 'pinar'),
        'desc'      => esc_html__('Manage the slider images which is generated by [pinar-main-slider] shortcode', 'pinar'),
        'icon'      => 'el-icon-photo',
        'fields'    => array(
            array(
                'id'        => 'pinar-main-slider',
                'type'      => 'gallery',
                'title'     => esc_html__('Manage The Main Slider', 'pinar'),
                'subtitle'  => esc_html__('Create a new Slider by selecting existing or uploading new images using the WordPress native uploader.', 'pinar'),
            ),
            array(
                'id'        => 'pinar-text-slider-background',
                'type'      => 'media',
                'title'     => esc_html__('Background of Text Slider', 'pinar'),
                'subtitle'  => esc_html__('If you use the "Home Page Alt" as your your home page page template, you can upload your background image of text slider by this field.', 'pinar'),
                'desc'      => esc_html__('Upload an image as background.', 'pinar'),
            ),
            array(
                'id'       => 'pinar-text-slider-items',
                'type'     => 'multi_text',
                'title'    => esc_html__( 'Text Slider Items', 'pinar' ),
                'subtitle' => esc_html__( 'Add your text you want to show in text slider in "Home Page Alt" page template.', 'pinar' )
            )
        ),

    ) );


    Redux::setSection( $opt_name, array(
        'title'     => esc_html__('Price Setting', 'pinar'),
        'desc'      => esc_html__('You can set your seasonal price for your rooms in this section.', 'pinar'),
        'icon'      => 'el-icon-usd',
        'fields'    => array(
            array(
                'id'        => 'pinar-high-season-start',
                'type'      => 'date',
                'title'     => esc_html__('High Season Start Date', 'pinar'),
                'subtitle'  => esc_html__('Insert the start date of your High Season. Date format "mm-dd-yy".', 'pinar'),
            ),
			array(
                'id'        => 'pinar-high-season-end',
                'type'      => 'date',
                'title'     => esc_html__('High Season End Date', 'pinar'),
                'subtitle'  => esc_html__('Insert the end date of your High Season. Date format "mm-dd-yy".', 'pinar'),
            ),
			array(
                'id'        => 'pinar-high-season-percent',
                'type'      => 'text',
                'title'     => esc_html__('High Season Percent', 'pinar'),
                'subtitle'  => esc_html__('Add the percent (%) you want to increase the prices in High Season.', 'pinar'),
				'desc'      => esc_html__('Do NOT use "%" in the field, just add the digit.', 'pinar'),
            ),
			array(
                'id'        => 'pinar-low-season-start',
                'type'      => 'date',
                'title'     => esc_html__('Low Season Start Date', 'pinar'),
                'subtitle'  => esc_html__('Insert the start date of your Low Season. Date format "mm-dd-yy".', 'pinar'),
            ),
			array(
                'id'        => 'pinar-low-season-end',
                'type'      => 'date',
                'title'     => esc_html__('Low Season End Date', 'pinar'),
                'subtitle'  => esc_html__('Insert the end date of your Low Season. Date format "mm-dd-yy".', 'pinar'),
            ),
			array(
                'id'        => 'pinar-low-season-percent',
                'type'      => 'text',
                'title'     => esc_html__('Low Season Percent', 'pinar'),
                'subtitle'  => esc_html__('Add the percent (%) you want to increase the prices in Low Season.', 'pinar'),
				'desc'      => esc_html__('Do NOT use "%" in the field, just add the digit.', 'pinar'),
            ),
        )

    ) );