<?php
/**
* Ravis Short code Class 
*/
class Ravis_booking_shortcode
{
	
	function __construct()
	{
		add_action( 'init', array($this, 'init') );
		
	}

	/**
	 * Add all the pinar Shortcodes to the theme
	 */
	public function init()
	{
		add_shortcode('pinar-main-slider', array($this, 'pinar_main_slider'));
		add_shortcode('pinar-service-slider', array($this, 'pinar_service_slider'));
		add_shortcode('pinar-social-icons', array($this, 'ravis_social_icon'));
		add_shortcode('pinar-luxury-rooms', array($this, 'pinar_luxury_rooms'));
		add_shortcode('pinar-availability-form', array($this, 'pinar_availability_form'));
		add_shortcode('pinar-packages', array($this, 'pinar_packages'));
		add_shortcode('pinar-call-to-action', array($this, 'pinar_call_to_action'));
		add_shortcode('pinar-main-gallery', array($this, 'pinar_main_gallery'));
		add_shortcode('pinar-staff', array($this, 'pinar_staff'));
		add_shortcode('pinar-send-feedback', array($this, 'pinar_send_feedback'));
		add_shortcode('pinar-other-rooms', array($this, 'pinar_other_rooms'));
		add_shortcode('pinar-video', array($this, 'pinar_video'));
		add_shortcode('pinar-text-slider', array($this, 'pinar_text_slider'));
		add_shortcode('pinar-room-list', array($this, 'pinar_room_list'));
		add_shortcode('pinar-latest-post', array($this, 'pinar_latest_post'));
		add_filter('widget_text', 'do_shortcode');
	}

	/**
	 * ------------------------------------------------------------------------------------------
	 * Generate the luxury rooms list
	 * ------------------------------------------------------------------------------------------
	 */
	function pinar_availability_form($attr)
	{
		/**
		 * Availability form's Attribute
		 */
		$pinar_availability_form_attr = shortcode_atts(
			array(
				/**
				 * Values that this attribute can handle are:
				 * "vertical" , "horizontal" and "simple"
				 * Default value : 'vertical'
				 */
				'type'  => 'vertical',
				/**
				 * For using the Circular form leave this attribute blank like : 'style' => '',
				 * if you want to use the simple form add the "style-2" value for this attribute
				 * Default value : 'style-2'
				 */
				'style' => 'style-2',
				'title' => __('Find A <b>Room</b>', 'ravis')
			), $attr );  

		$select_options ='';
		for ($i=1; $i < 7; $i++)
	    { 
	    	$select_options .= '<option value="'. esc_attr( $i ) .'">'. esc_html( $i ) .'</option>';
	    }
		switch ($pinar_availability_form_attr['type']) {
			case 'vertical':

				$pinar_availability_form_str = '
					<div class="booking-form-container container">
						<div id="main-booking-form" class="'.esc_attr($pinar_availability_form_attr['style']).'">
							<h2>'.balancetags($pinar_availability_form_attr['title']).'</h2>
							<form class="booking-form clearfix" action="'. esc_url( RAVIS_BOOKING_PAGE_URL ) .'" method="post" autocomplete="off">
								<div class="input-daterange clearfix">
						            <div class="booking-fields col-xs-6 col-md-12">
						                <input placeholder="'.esc_attr__('Choose check in date', 'ravis').'" class="datepicker-fields check-in" type="text" name="start" />
						                <i class="fa fa-calendar"></i>
						            </div>
						            <div class="booking-fields col-xs-6 col-md-12">
						                <input placeholder="'.esc_attr__('Choose check out date', 'ravis').'" class="datepicker-fields check-out" type="text" name="end" />
						                <i class="fa fa-calendar"></i>
						            </div>
						        </div>
					            <div class="booking-fields col-xs-6 col-md-12">

					                <select name="adult">
					                    <option value="">'.esc_attr__('How Many Adult?', 'ravis').'</option>
					                    '.balancetags($select_options).'
					                </select>
					            </div>
					            <div class="booking-fields col-xs-6 col-md-12">
					                <select name="child">
					                    <option value="">'.esc_attr__('How Many Children ?', 'ravis').'</option>
					                    '.balancetags($select_options).'
					                </select>
					            </div>
					            <div class="booking-button-container">
					                <input class="btn btn-default" value="'.esc_attr__('Check Availability', 'ravis').'" type="submit"/>
					            </div>
					        </form>
						</div>
					</div>';
				break;
			case 'horizontal':
				$pinar_availability_form_str ='
			    	<form class="booking-form horizontal container" action="'.esc_url( RAVIS_BOOKING_PAGE_URL ).'" method="post">
						<div class="input-daterange col-md-6">
				            <div class="booking-fields col-md-6">
				                <input placeholder="'.esc_attr__('Check-in', 'ravis').'" class="datepicker-fields check-in" type="text" name="start" />
				                <i class="fa fa-calendar"></i>
				            </div>
				            <div class="booking-fields col-md-6">
				                <input placeholder="'.esc_attr__('Check-out', 'ravis').'" class="datepicker-fields check-out" type="text" name="end" />
				                <i class="fa fa-calendar"></i>
				            </div>
				        </div>
			            <div class="booking-fields col-md-3">
			                <select name="adult" id="booking-field2">
			                    <option value="">'.esc_attr__('Adult', 'ravis').'</option>
			                    '.balancetags($select_options).'
			                </select>
			            </div>
			            <div class="booking-fields col-md-3">
			                <select name="child" id="booking-field3">
			                    <option value="1">'.esc_attr__('Children', 'ravis').'</option>
			                    '.balancetags($select_options).'
			                </select>
			            </div>
			            <div class="booking-button-container">
			                <input class="btn btn-default" value="'.esc_attr__('Book Now', 'ravis').'" type="submit"/>
			            </div>
			        </form>';		
				break;
			case 'simple':
				$pinar_availability_form_str ='
				<div id="booking-form" class="clearfix">
					<form class="booking-form" action="'.esc_url( RAVIS_BOOKING_PAGE_URL ).'" method="post">
						<div class="input-daterange clearfix">
				            <div class="booking-fields col-xs-6 col-md-12">
								<input placeholder="'.esc_attr__('Check-in', 'ravis').'" class="datepicker-fields check-in" type="text" name="start" />
				                <i class="fa fa-calendar"></i>
				            </div>
				            <div class="booking-fields col-xs-6 col-md-12">
				            	<input placeholder="'.esc_attr__('Check-out', 'ravis').'" class="datepicker-fields check-out" type="text" name="end" />
				                <i class="fa fa-calendar"></i>
				            </div>
				        </div>
			            <div class="booking-fields col-xs-6 col-md-12">
			                <select name="adult" id="booking-field2">
			                    <option value="">'.esc_attr__('Adult', 'ravis').'</option>
			                    '.balancetags($select_options).'
			                </select>
			            </div>
			            <div class="booking-fields col-xs-6 col-md-12">
			                <select name="child" id="booking-field3">
			                    <option value="1">'.esc_attr__('Children', 'ravis').'</option>
			                    '.balancetags($select_options).'
			                </select>
			            </div>
			            <div class="booking-button-container col-xs-12">
			                <input class="btn btn-default" value="'.esc_attr__('Book Now', 'ravis').'" type="submit"/>
			            </div>
			        </form>
				</div>';
				break;
		}		
		return $pinar_availability_form_str;
	}
	
	/**
	 * ------------------------------------------------------------------------------------------
	 * Generate the luxury rooms list
	 * ------------------------------------------------------------------------------------------
	 */
	function pinar_luxury_rooms($attr)
	{
		global $post, $pinar_opt;

		/**
		 * Testimonial's Attribute
		 */
		$pinar_luxury_rooms_attr = shortcode_atts(
			array(
				'title'      => esc_html__('Luxury Rooms', 'ravis'),
				'subtitle'   => esc_html__('Best rooms with Best services', 'ravis'),
				'room_count' => 3
			), $attr );

		/**
		 * Generate the Query for getting the posts
		 * @var array 	$args
		 */
		$args = array(
			'post_type'   => 'rooms',
			'post_status' => 'publish',
			'order'       => 'DESC',
			'orderby'     => 'date',
			'meta_key'    => 'rooms_luxury',
			'meta_value'  => 'on',

		);
		$pinar_luxury_rooms  = new WP_Query( $args );

		/**
		 * Loading post for making the testimonials
		 */
		if ( $pinar_luxury_rooms->have_posts() ) 
		{
			/**
			 * Generating the testimonials HTML codes
			 * @var string 	 pinar_luxury_rooms_str
			 */
	                    
			$pinar_luxury_rooms_str = '

			<div id="luxury-rooms">
				<div class="heading-box">
					<h2>'. ravis_fn_title_effect(esc_html($pinar_luxury_rooms_attr['title'])) .'</h2>
					<div class="subtitle">'. esc_html($pinar_luxury_rooms_attr['subtitle']) .'</div>
				</div>				
				<div class="room-container container">
				';
			    /**
			     * Loop for getting post data
			     */
			    $i = 1;
			    $price_unit = !empty($pinar_opt['pinar-booking-currency']) ? ravis_currency_converter($pinar_opt['pinar-booking-currency']) : '&#36;';
				while ( $pinar_luxury_rooms->have_posts() )
				{
					$pinar_luxury_rooms->the_post();
					$post_id          = get_the_id();
					$rooms_price      = get_post_meta( $post_id, 'rooms_price', true );
					$room_imgs_id     = explode( ',' , get_post_meta( $post_id, 'rooms_slideshow_images' , true ));
					$room_cover       = $room_imgs_id[0];
					$box_grid_classes = 'col-xs-6 col-md-4';
					$rooms_short_desc = get_post_meta( $post_id, 'rooms_short_desc', true );

					if( $i > $pinar_luxury_rooms_attr['room_count']) continue;
					$pinar_luxury_rooms_str .= '
					<div class="room-boxes '.($i%2 == 0 ? 'right' : '').' wow fadeInLeft">
						<div class="img-container col-xs-6 col-md-7">';
							if($room_cover != '')
		                    {
		                    	$pinar_luxury_rooms_str .= wp_get_attachment_image( $room_cover, 'full', '', 'class=room-img' ); 
		                    }
		                    else
		                    {
		                    	$pinar_luxury_rooms_str .= '<img src="'. esc_url ( PINAR_IMG_PATH ).'room-placeholder.jpg" alt="'. esc_attr( esc_html__('No Image','ravis') ).'" />';
		                    }
	                    $pinar_luxury_rooms_str .= '
	                    </div>
						<div class="room-details col-xs-6 col-md-5">
							<div class="title">'.esc_html(get_the_title()).'</div>
							<div class="description">'.esc_html($rooms_short_desc).'</div>
							<a href="'.get_permalink().'" class="btn btn-default">'.esc_html__('Details', 'ravis').'</a>
						</div>
						<div class="price-container col-xs-6 col-md-7">
							<div class="price">
								<span>'.esc_html(ravis_fn_price_value($rooms_price)).'</span>
								'.esc_html__('- Per Night', 'ravis').'
							</div>
						</div>
					</div>';
					$i++;
				}
			$pinar_luxury_rooms_str .= '
					</div>
				</div>';
		} 
		else 
		{
			// no posts found
			$pinar_luxury_rooms_str = esc_html__('There is not any rooms','ravis');
		}

		/**
		 * Restore original Post Data
		 */
		wp_reset_postdata();
		return balancetags( $pinar_luxury_rooms_str );
	}

	/**
	 * ------------------------------------------------------------------------------------------
	 * Generate the main image slider
	 * ------------------------------------------------------------------------------------------
	 */
	function pinar_main_slider($attr)
	{
		global $pinar_opt;
		$pinar_main_slider_code ='';
		$slider_items_id        = isset($pinar_opt["pinar-main-slider"] ) ? explode(',', $pinar_opt["pinar-main-slider"]) : '';

		if (isset($pinar_opt["pinar-main-slider"]))
		{
			$pinar_main_slider_code .='
				<div id="main-slider">';
				if($slider_items_id[0] !=='')
				{
					foreach ($slider_items_id as $slider_item_id) {
						$slide = get_post( intval( $slider_item_id ) );				
						$pinar_main_slider_code .='
							<div class="items">
					            <img src="'.esc_url( $slide->guid ).'" alt="3"/>
					        </div>';
					}					
				}
				else
				{
					$pinar_main_slider_code .='
						<div class="items">
				            <img src="'.PINAR_IMG_PATH.'slider-placeholder.png" alt="'.esc_attr__( 'No Image',  'ravis').'"/>
				        </div>';
				}

			$pinar_main_slider_code .='</div>';
		}
		else
		{
			esc_html_e('There is not any slides', 'ravis');
		}

		/**
		 * Restore original Post Data
		 */
		wp_reset_postdata();
		return balancetags( $pinar_main_slider_code );
	}

	/**
	 * ------------------------------------------------------------------------------------------
	 * Generate the price table of packages
	 * ------------------------------------------------------------------------------------------
	 */

	function pinar_packages($attr)
	{
		global $post, $pinar_opt;

		/**
		 * Package Attribute
		 */
		$pinar_packages_attr = shortcode_atts(
				array(
				'title'       => esc_html__('Special Packages', 'ravis'),
				'subtitle'    => esc_html__('Choose one of our special offers', 'ravis'),
				'description' => '',
				/**
				 * Type of packages can be changed to "compact" and "expand"
				 * Default value is 'compact'
				 */
				'type'        => 'compact',
				'per_page'    => -1,

			), $attr );

		/**
		 * Generate the Query for getting the posts
		 * @var array 	$args
		 */
		$args = array(
			'post_type'      => 'packages',
			'post_status'    => 'publish',
			'order'          => 'DESC',
			'orderby'        => 'date',
			'posts_per_page' => intval($pinar_packages_attr['per_page'])
		);
		$pinar_packages_query = new WP_Query( $args );
		$price_unit = !empty($pinar_opt['pinar-booking-currency']) ? ravis_currency_converter($pinar_opt['pinar-booking-currency']) : '&#36;';

		/**
		 * Loading post for making the package
		 */
		if ( $pinar_packages_query->have_posts() ) 
		{
			/**
			 * Generating the Package HTML codes
			 * @var string 	 pinar_packages
			 */
			if(isset($pinar_packages_attr['type']) && $pinar_packages_attr['type'] =='compact')
			{
				$pinar_packages = '

				<div id="special-packages" class="container">

					<div class="heading-box">
						<h2>'. ravis_fn_title_effect(esc_html($pinar_packages_attr['title'])) .'</h2>';

				if($pinar_packages_attr['subtitle'])
				{
		            $pinar_packages .= '<div class="subtitle">'.esc_html($pinar_packages_attr['subtitle']).'</div>';
				}
				$pinar_packages .= '</div>';
		        
		        $pinar_packages .= '<div class="package-container clearfix">';
				    /**
				     * Loop for getting post data
				     */
				    $package_booking_url = '';
					while ( $pinar_packages_query->have_posts() )
					{
						$pinar_packages_query->the_post();
						$package_price = get_post_meta( $post->ID, 'package_price' , true );

						if ( get_option('permalink_structure') )
						{
							$package_booking_url = esc_url(RAVIS_BOOKING_PAGE_URL).'?package='.get_the_id();
						}
						else
						{
							$package_booking_url = esc_url(RAVIS_BOOKING_PAGE_URL).'&package='.get_the_id();						
						}

						$pinar_packages .= '
						<div class="package-box col-sm-6 col-md-4 wow fadeInUp">
							<div class="package-inner">
								<div class="title">'.get_the_title().'</div>
								<div class="price"><span>'.esc_html($price_unit.$package_price).'</span>'.esc_html__("per night", 'ravis').'</div>
								<div class="package-details">'.get_the_content().'</div>
								<a href="'. esc_url( $package_booking_url ) .'" class="btn btn-default">'.esc_html__("Select Package" , 'ravis').'</a>
							</div>
						</div>';
					}
				$pinar_packages .= '
					</div>
				</div>';
			}
			elseif(isset($pinar_packages_attr['type']) && $pinar_packages_attr['type'] =='expand')
			{
				$pinar_packages = '				
				<div id="welcome" class="container">					
					<div class="heading-box">
						<h2>'. ravis_fn_title_effect(esc_html($pinar_packages_attr['title'])) .'</h2>';
						if($pinar_packages_attr['subtitle'])
						{
				            $pinar_packages .= '<div class="subtitle">'.esc_html($pinar_packages_attr['subtitle']).'</div>';
						}
				$pinar_packages .= '</div>';

				if($pinar_packages_attr['description'])
				{
					$pinar_packages .= '
					<div class="inner-content">
						<div class="desc">'.$pinar_packages_attr['description'].'</div>
					</div>';
				}
				$pinar_packages .= '</div>				
				<div id="special-packages-type-2" class="container">					
					<div class="package-container">';
						
						$package_booking_url = '';
						$package_i = 1;
						while ( $pinar_packages_query->have_posts() )
						{
							$pinar_packages_query->the_post();
							$package_price = get_post_meta( $post->ID, 'package_price' , true );

							if ( get_option('permalink_structure') )
							{
								$package_booking_url = esc_url(RAVIS_BOOKING_PAGE_URL).'?package='.get_the_id();
							}
							else
							{
								$package_booking_url = esc_url(RAVIS_BOOKING_PAGE_URL).'&package='.get_the_id();						
							}
							$post_id       = get_the_id();
							$thumb_classes = array(
								'alt'   => get_the_title(),
								'class' => 'package-img',
							);
							$pinar_packages .= '
							<div class="package-boxes wow '.($package_i%2 == 0 ? 'right fadeInLeft' : 'fadeInRight').'">
								<div class="img-container col-xs-6 col-md-7">
									'.get_the_post_thumbnail( $post_id, '', $thumb_classes ).'
								</div>
								<div class="package-details col-xs-6 col-md-5">
									<div class="title">'.get_the_title().'</div>
									<div class="description">'.get_the_content().'</div>
									<div class="button-price clearfix">
										<a href="'. esc_url( $package_booking_url ) .'" class="btn btn-default">'.esc_html__("Select Package" , 'ravis').'</a>
										<div class="price"><span>'.esc_html($price_unit.$package_price).'</span>'.esc_html__("per night", 'ravis').'</div>
									</div>
								</div>
							</div>';
							$package_i ++;
						}
				$pinar_packages .= '</div>
				</div>';
			}
		} 
		else 
		{
			// no posts found
			$pinar_packages = esc_html__('There is not any packages','ravis');
		}

		/**
		 * Restore original Post Data
		 */
		wp_reset_postdata();
		return balancetags( $pinar_packages );
	}

	/**
	 * ------------------------------------------------------------------------------------------
	 * Generate the service slider
	 * ------------------------------------------------------------------------------------------
	 */
	function pinar_service_slider($attr)
	{
		global $post;

		/**
		 * Service Slider's Attribute
		 */
		$pinar_service_slider_attr = shortcode_atts(
			array(
				'title' => esc_html__('Our Services', 'ravis'),
				'class' => ''
			), $attr );

		/**
		 * Generate the Query for getting the posts
		 * @var array 	$args
		 */
		$args = array(
			'post_type'   => 'service',
			'post_status' => 'publish',
			'order'       => 'DESC',
			'orderby'     => 'date',
			//Custom Field Parameters
			'meta_query'     => array(
				array(
					'key' => 'services_in_slider',
					'value' => 'on',
				),
			)
		);
		$pinar_service_slider  = new WP_Query( $args );

		/**
		 * Loading post for making the service_slider
		 */
		if ( $pinar_service_slider->have_posts() ) 
		{
			/**
			 * Generating the service_slider HTML codes
			 * @var string 	 pinar_service_slider_code
			 */
	                    
			$pinar_service_slider_code = '
			<div id="our-services" class="services-container '. esc_attr( $pinar_service_slider_attr['class'] ) .'">
	            <div class="heading-box"><h2>'. ravis_fn_title_effect(esc_html($pinar_service_slider_attr['title'] )) .'</h2></div>
					<div id="services-box" class="owl-carousel owl-theme">';
			    /**
			     * Loop for getting post data
			     */
				while ( $pinar_service_slider->have_posts() )
				{
					$pinar_service_slider->the_post();
					$thumb_size  = array('600', '300');
					$service_img = ( get_the_post_thumbnail( $post->ID, $thumb_size, 'alt='. get_the_title()) ? get_the_post_thumbnail( $post->ID, $thumb_size, 'alt='. get_the_title()) : '<img src="'. PINAR_IMG_PATH.'service-placeholder.jpg' .'" alt="'.__('No Image','ravis').'" />');
					$pinar_service_slider_code .= '
					<div class="item">
		                '.balancetags($service_img).'
		                <div class="title">'. esc_html( get_the_title() ) .'</div>
		                <div class="short-desc">'. wp_kses_post( get_the_content() ) .'</div>
		            </div>';
				}
			$pinar_service_slider_code .= ' 
				</div>
	        </div>';
		} 
		else 
		{
			// no posts found
			$pinar_service_slider_code = esc_html__('There is not any services','ravis');
		}

		/**
		 * Restore original Post Data
		 */
		wp_reset_postdata();
		return balancetags( $pinar_service_slider_code );
	}
	/**
	 * ------------------------------------------------------------------------------------------
	 * Generate Social icons 
	 * ------------------------------------------------------------------------------------------
	 */
	function ravis_social_icon( $attr )
	{
	    global $pinar_opt;

	    /**
		 * Service Slider's Attribute
		 */
		$pinar_social_icon_attr = shortcode_atts(
			array(
				'id'    => 'social-icons',
				'print' => false
			), $attr );


	    $shocial_icons_codes = '<ul class="list-inline list-unstyled social-icons">';
	    if(isset($pinar_opt['opt-social-twitter']) and trim($pinar_opt['opt-social-twitter'])!==''):
	        $shocial_icons_codes .='<li><a href="'. esc_url( $pinar_opt['opt-social-twitter'] ) .'" class="ravis-icon-twitter"></a></li>';
	    endif;
	    if(isset($pinar_opt['opt-social-facebook']) and trim($pinar_opt['opt-social-facebook'])!==''):
	        $shocial_icons_codes .='<li><a href="'. esc_url( $pinar_opt['opt-social-facebook'] ) .'" class="ravis-icon-facebook"></a></li>';
	    endif;
	    if(isset($pinar_opt['opt-social-gplus']) and trim($pinar_opt['opt-social-gplus'])!==''):
	        $shocial_icons_codes .='<li><a href="'. esc_url( $pinar_opt['opt-social-gplus'] ) .'" class="ravis-icon-google-plus"></a></li>';
	    endif;
	    if(isset($pinar_opt['opt-social-flickr']) and trim($pinar_opt['opt-social-flickr'])!==''):
	        $shocial_icons_codes .='<li><a href="'. esc_url( $pinar_opt['opt-social-flickr'] ) .'" class="ravis-icon-flickr"></a></li>';
	    endif;
	    if(isset($pinar_opt['opt-social-rss']) and trim($pinar_opt['opt-social-rss'])!==''):
	        $shocial_icons_codes .='<li><a href="'. esc_url( $pinar_opt['opt-social-rss'] ) .'" class="ravis-icon-rss"></a></li>';
	    endif;
	    if(isset($pinar_opt['opt-social-vimeo']) and trim($pinar_opt['opt-social-vimeo'])!==''):
	        $shocial_icons_codes .='<li><a href="'. esc_url( $pinar_opt['opt-social-vimeo'] ) .'" class="ravis-icon-vimeo"></a></li>';
	    endif;
	    if(isset($pinar_opt['opt-social-youtube']) and trim($pinar_opt['opt-social-youtube'])!==''):
	        $shocial_icons_codes .='<li><a href="'. esc_url( $pinar_opt['opt-social-youtube'] ) .'" class="ravis-icon-youtube"></a></li>';
	    endif;
	    if(isset($pinar_opt['opt-social-pinterest']) and trim($pinar_opt['opt-social-pinterest'])!==''):
	        $shocial_icons_codes .='<li><a href="'. esc_url( $pinar_opt['opt-social-pinterest'] ) .'" class="ravis-icon-pinterest"></a></li>';
	    endif;
	    if(isset($pinar_opt['opt-social-tumblr']) and trim($pinar_opt['opt-social-tumblr'])!==''):
	        $shocial_icons_codes .='<li><a href="'. esc_url( $pinar_opt['opt-social-tumblr'] ) .'" class="ravis-icon-tumblr"></a></li>';
	    endif;
	    if(isset($pinar_opt['opt-social-dribbble']) and trim($pinar_opt['opt-social-dribbble'])!==''):
	        $shocial_icons_codes .='<li><a href="'. esc_url( $pinar_opt['opt-social-dribbble'] ) .'" class="ravis-icon-dribbble"></a></li>';
	    endif;
	    if(isset($pinar_opt['opt-social-digg']) and trim($pinar_opt['opt-social-digg'])!==''):
	        $shocial_icons_codes .='<li><a href="'. esc_url( $pinar_opt['opt-social-digg'] ) .'" class="ravis-icon-digg"></a></li>';
	    endif;
	    if(isset($pinar_opt['opt-social-linkedin']) and trim($pinar_opt['opt-social-linkedin'])!==''):
	        $shocial_icons_codes .='<li><a href="'. esc_url( $pinar_opt['opt-social-linkedin'] ) .'" class="ravis-icon-linkedin"></a></li>';
	    endif;
	    if(isset($pinar_opt['opt-social-blogger']) and trim($pinar_opt['opt-social-blogger'])!==''):
	        $shocial_icons_codes .='<li><a href="'. esc_url( $pinar_opt['opt-social-blogger'] ) .'" class="ravis-icon-blogger"></a></li>';
	    endif;
	    if(isset($pinar_opt['opt-social-skype']) and trim($pinar_opt['opt-social-skype'])!==''):
	        $shocial_icons_codes .='<li><a href="'. esc_url( $pinar_opt['opt-social-skype'] ) .'" class="ravis-icon-skype"></a></li>';
	    endif;
	    if(isset($pinar_opt['opt-social-forrst']) and trim($pinar_opt['opt-social-forrst'])!==''):
	        $shocial_icons_codes .='<li><a href="'. esc_url( $pinar_opt['opt-social-forrst'] ) .'" class="ravis-icon-forrst"></a></li>';
	    endif;
	    if(isset($pinar_opt['opt-social-deviantart']) and trim($pinar_opt['opt-social-deviantart'])!==''):
	        $shocial_icons_codes .='<li><a href="'. esc_url( $pinar_opt['opt-social-deviantart'] ) .'" class="ravis-icon-deviantart"></a></li>';
	    endif;
	    if(isset($pinar_opt['opt-social-yahoo']) and trim($pinar_opt['opt-social-yahoo'])!==''):
	        $shocial_icons_codes .='<li><a href="'. esc_url( $pinar_opt['opt-social-yahoo'] ) .'" class="ravis-icon-yahoo"></a></li>';
	    endif;
	    if(isset($pinar_opt['opt-social-reddit']) and trim($pinar_opt['opt-social-reddit'])!==''):
	        $shocial_icons_codes .='<li><a href="'. esc_url( $pinar_opt['opt-social-reddit'] ) .'" class="ravis-icon-reddit"></a></li>';
	    endif;

	     $shocial_icons_codes.='</ul>';

	    if((!isset($pinar_social_icon_attr['print']) or $pinar_social_icon_attr['print'] == false ) && $shocial_icons_codes !='')
	    {
	        return '<div class="social-icons-box" '.(isset($pinar_social_icon_attr['id']) && $pinar_social_icon_attr['id'] !=='' ? 'id="'.esc_attr($pinar_social_icon_attr['id']).'"' : '').'>'.balancetags($shocial_icons_codes).'</div>';
	    }
	    else
	    {
	    	if($shocial_icons_codes !='')
	    	{
	        	echo '<div class="social-icons-box" '.(isset($pinar_social_icon_attr['id']) && $pinar_social_icon_attr['id'] !=='' ? 'id="'.esc_attr($pinar_social_icon_attr['id']).'"' : '').'>'.balancetags($shocial_icons_codes).'</div>';
	    	}
	    }
	}

	/**
	 * ------------------------------------------------------------------------------------------
	 * Generate Call to action boxes
	 * ------------------------------------------------------------------------------------------
	 */
	function pinar_call_to_action($attr)
	{
		/**
		 * Pinar call to action's Attribute
		 */
		$pinar_call_to_action_attr = shortcode_atts(
			array(
				'title' => __('Do you need to have <span>Hotel</span> / <span>Resort</span> template?', 'ravis'),
				'button_text' => __('Purchase this template', 'ravis'),
				'link' => esc_url('http://themeforest.net/item/pinar-hotel-responsive-booking-template/11369156/?ref=RavisTheme'),
			), $attr );
		echo '
			<div class="call-to-action-box">
				<div class="inner-container container">
					<div class="title">'.balancetags($pinar_call_to_action_attr['title']).'</div>
					<a href="'.esc_url($pinar_call_to_action_attr['link']).'" class="btn btn-secondary">'.esc_html($pinar_call_to_action_attr['button_text']).'</a>
				</div>
			</div>';
	}

	/**
	 * ------------------------------------------------------------------------------------------
	 * Generate the main Gallery
	 * ------------------------------------------------------------------------------------------
	 */
	function pinar_main_gallery($attr)
	{
		global $pinar_opt;

		/**
		 * Main Gallery's Attribute
		 */
		$pinar_main_gallery_attr = shortcode_atts(
			array(
				'title'       => esc_html__('Pinar Gallery', 'ravis'),
				'sort_option' => $pinar_opt['pinar-gallery-sort'],
				'img_count'   => 8,
				'more_link'	  => TRUE
			), $attr );


		$pinar_main_gallery_code = $sort_options = $sort_options_li = $img_list_class = '';
		$gallery_items_id        = isset($pinar_opt["pinar-main-gallery"] ) ? explode(',', $pinar_opt["pinar-main-gallery"]) : '';

		if (isset($pinar_opt["pinar-main-gallery"]))
		{
			$pinar_main_gallery_code .='
				<div id="gallery">';
				if(isset($pinar_main_gallery_attr['title']) && $pinar_main_gallery_attr['title'] !='')
				{
					$pinar_main_gallery_code .='
					<div class="heading-box">
						<h2>'.ravis_fn_title_effect($pinar_main_gallery_attr['title']).'</h2>
					</div>';					
				}

				if($gallery_items_id[0] !=='')
				{
					$sort_options = explode(',', $pinar_main_gallery_attr['sort_option']);
					foreach ($sort_options as $sort_options_list) {
						if($sort_options_list === 'All')
						{
							$sort_options_li .='<li><a href="#" data-filter="*" class="active">'.esc_html__('All', 'ravis').'</a></li>';
						}
						else
						{
							$sort_options_li .='<li><a href="#" data-filter=".'.esc_attr(str_replace(' ', '-', trim(strtolower($sort_options_list)))).'">'.esc_html($sort_options_list).'</a></li>';
						}
					}

					$pinar_main_gallery_code .='<div class="gallery-container">
						<div class="sort-section">
							<div class="sort-section-container">
								<div class="sort-handle">'.esc_html__('Filters', 'ravis').'</div>
								<ul class="list-inline">
									'.$sort_options_li.'
								</ul>
							</div>
						</div>
						<ul class="image-main-box clearfix">';						

					$img_i = 1;
					foreach ($gallery_items_id as $gallery_item_id) {
						if(isset($pinar_main_gallery_attr['img_count']) && $pinar_main_gallery_attr['img_count']!='')
						{
							if( $img_i > $pinar_main_gallery_attr['img_count'] ) continue;							
						}
						$image = get_post( intval( $gallery_item_id ) );
						$pinar_main_gallery_code .='
							<li class="item '.( (isset($image->post_title) && $image->post_title !=='' && strpos($image->post_title, 'col-') !== false ) ? esc_attr($image->post_title) : 'col-xs-6 col-md-3').' '.(isset($image->post_content) && $image->post_content !=='' ? esc_attr(str_replace(' ', '-', trim(strtolower($image->post_content)))) : '').'">
								<figure>
									<img src="'.esc_url( $image->guid ).'" alt="11"/>
									<a href="'.esc_url( $image->guid ).'" class="more-details" data-title="'.esc_attr($image->post_excerpt).'"></a>
									<figcaption>
										<h4>'.ravis_fn_title_effect(esc_html($image->post_excerpt )).'</h4>
									</figcaption>
								</figure>
							</li>';
						$img_i ++;	
					}
					$pinar_main_gallery_code .='</ul>';

					if(trim($pinar_main_gallery_attr['more_link']) == TRUE)
					{
						$pinar_main_gallery_code .='<a href="'.esc_url( RAVIS_GALLERY_PAGE_URL ).'" class="btn btn-default btn-sm">'.esc_html__('More ...', 'ravis').'</a>';						
					}

					$pinar_main_gallery_code .='</div>';		
				}
				else
				{
					$pinar_main_gallery_code .='
						<div class="items">
				            <img src="'.PINAR_IMG_PATH.'slider-placeholder.png" alt="'.esc_attr__( 'No Image',  'ravis').'"/>
				        </div>';
				}

			$pinar_main_gallery_code .='</div>';
		}
		else
		{
			esc_html_e('There is not any slides', 'ravis');
		}

		/**
		 * Restore original Post Data
		 */
		wp_reset_postdata();
		return balancetags( $pinar_main_gallery_code );
	}


	/**
	 * ------------------------------------------------------------------------------------------
	 * Generate Staff Box and slider
	 * ------------------------------------------------------------------------------------------
	 */
	function pinar_staff($attr)
	{
		global $post, $pinar_opt;
		/**
		 * Pinar staff's Attribute
		 */
		$pinar_staff_attr = shortcode_atts(
			array(
				'title'    => __('Our Staff', 'ravis'),
				'subtitle' => __('Professional & Experienced team', 'ravis'),
				/**
				 * Staff boxes can have "single", "slider" and "tiled"
				 * Default value is "slider"
				 */
				'type'     => 'slider',
				'class'    => '',
				'staff_id' => ''

			), $attr );

		if(isset($pinar_staff_attr['type']) && $pinar_staff_attr['type'] == 'single')
		{

			if(isset($pinar_staff_attr['staff_id']) and $pinar_staff_attr['staff_id'] !=='')
			{
				$args = array(
					'post_type'   => 'staff',
					'post_status' => 'publish',
					'order'       => 'DESC',
					'orderby'     => 'date',
					'p'           => $pinar_staff_attr['staff_id']
				);
				$pinar_staff_query  = new WP_Query( $args );

				if($pinar_staff_query->have_posts())
				{
					while ($pinar_staff_query->have_posts()) {
						$pinar_staff_query->the_post();

						$postID            = get_the_id();
						$staff_title       = get_post_meta( $postID , 'staff_title', true );
						$staff_img         = get_the_post_thumbnail( $postID, '', '' );
						
						$staff_facebook    = get_post_meta( $postID , 'staff_facebook', true );
						$staff_twitter     = get_post_meta( $postID , 'staff_twitter', true );
						$staff_google_plus = get_post_meta( $postID , 'staff_google_plus', true );
						$staff_skype       = get_post_meta( $postID , 'staff_skype', true );
						$staff_email       = get_post_meta( $postID , 'staff_email', true );


						$pinar_staff_code ='
							<div class="staff-box large '.(!empty($pinar_staff_attr['class']) ? esc_attr($pinar_staff_attr['class']) : '' ).'">
								<div class="img-box">'.balancetags($staff_img).'
								</div>
								<div class="details">
									<div class="name">'.esc_html(get_the_title()).'</div>
									<div class="title">'.esc_html($staff_title).'</div>
									<div class="desc">'.balancetags(get_the_content()).'</div>
									<ul class="list-inline social-icons">
										'.(isset($staff_email) && $staff_email !='' ? '<li><a href="'.esc_attr($staff_email).'"><i class="fa fa-envelope "></i></a></li>' : '').'
										'.(isset($staff_facebook) && $staff_facebook !='' ? '<li><a href="'.esc_attr($staff_facebook).'"><i class="fa fa-facebook "></i></a></li>' : '').'
										'.(isset($staff_twitter) && $staff_twitter !='' ? '<li><a href="'.esc_attr($staff_twitter).'"><i class="fa fa-twitter "></i></a></li>' : '').'
										'.(isset($staff_google_plus) && $staff_google_plus !='' ? '<li><a href="'.esc_attr($staff_google_plus).'"><i class="fa fa-google-plus "></i></a></li>' : '').'
										'.(isset($staff_skype) && $staff_skype !='' ? '<li><a href="'.esc_attr($staff_skype).'"><i class="fa fa-skype "></i></a></li>' : '').'
									</ul>
								</div>			
							</div>
						';
					}
				}
				else{
					$pinar_staff_code =esc_html__( 'There is not any staff with this ID.', 'ravis' );
				}
				wp_reset_postdata();
			}
			else
			{
				$pinar_staff_code =esc_html__( 'Please add the staff ID.', 'ravis' );
			}
		}
		elseif(isset($pinar_staff_attr['type']) && $pinar_staff_attr['type'] == 'tiled')
		{

			$pinar_staff_code ='
				<div id="our-staff" '.(!empty($pinar_staff_attr['class']) ? esc_attr('class="'.$pinar_staff_attr['class'].'"' ) : '' ).'>';
				if(isset($pinar_staff_attr['title']) && $pinar_staff_attr['title'] !='')
				{
					$pinar_staff_code .='
					<div class="heading-box">
						<h2>'.ravis_fn_title_effect(esc_html($pinar_staff_attr['title'])).'</h2>';
						if(isset($pinar_staff_attr['subtitle']) && $pinar_staff_attr['subtitle'] !='')
						{
							$pinar_staff_code .='<div class="subtitle">'.esc_html($pinar_staff_attr['subtitle']).'</div>';							
						}
					$pinar_staff_code .='</div>';					
				}
				$pinar_staff_code .='<ul class="staff-list clearfix">';

			$args = array(
				'post_type'   => 'staff',
				'post_status' => 'publish',
				'order'       => 'DESC',
				'orderby'     => 'date'
			);
			$pinar_staff_query  = new WP_Query( $args );

			/**
			 * Loading post for making the Staff Boxes
			 */
			if ( $pinar_staff_query->have_posts() ) 
			{
				while ($pinar_staff_query->have_posts()) {
					$pinar_staff_query->the_post();
					$postID            = get_the_id();
					$in_tile           = get_post_meta( $postID , 'staff_box_tile', true );
					if(!isset($in_tile) or $in_tile !=='on') continue;

					$staff_title       = get_post_meta( $postID , 'staff_title', true );
					$staff_img         = wp_get_attachment_url( get_post_thumbnail_id($postID) );

					$pinar_staff_code .='
						<li style="background-image: url('.esc_attr($staff_img).');"">
			                <div class="name">'.ravis_fn_title_effect(esc_html(get_the_title())).'</div>
			                <div class="staff-title">'.esc_html($staff_title).'</div>
			            </li>';
				}
				wp_reset_postdata();
			}		            

			$pinar_staff_code .='</ul>
				</div>';
		}
		else
		{
			$pinar_staff_code ='
				<div id="staff-slider" class="owl-carousel owl-theme '.(isset($pinar_staff_attr['class']) ? esc_attr($pinar_staff_attr['class'] ) : '' ).'">';

			$args = array(
				'post_type'   => 'staff',
				'post_status' => 'publish',
				'order'       => 'DESC',
				'orderby'     => 'date'
			);
			$pinar_staff_query  = new WP_Query( $args );

			/**
			 * Loading post for making the Staff Boxes
			 */
			if ( $pinar_staff_query->have_posts() ) 
			{
				while ($pinar_staff_query->have_posts()) {
					$pinar_staff_query->the_post();
					$postID            = get_the_id();
					$in_slider         = get_post_meta( $postID , 'staff_box_in_slider', true );
					if(!isset($in_slider) or $in_slider !=='on') continue;

					$staff_title       = get_post_meta( $postID , 'staff_title', true );
					$staff_img         = get_the_post_thumbnail( $postID, '', '' );
					
					$staff_facebook    = get_post_meta( $postID , 'staff_facebook', true );
					$staff_twitter     = get_post_meta( $postID , 'staff_twitter', true );
					$staff_google_plus = get_post_meta( $postID , 'staff_google_plus', true );
					$staff_skype       = get_post_meta( $postID , 'staff_skype', true );
					$staff_email       = get_post_meta( $postID , 'staff_email', true );

					$pinar_staff_code .='
						<div class="staff-box small item">
							<div class="img-box">'.balancetags($staff_img).'</div>
							<div class="details">
								<div class="name">'.esc_html(get_the_title()).'</div>
								<div class="title">'.esc_html($staff_title).'</div>
								<div class="desc">'.balancetags(get_the_content()).'</div>
								<ul class="list-inline social-icons">
									'.(isset($staff_email) && $staff_email !='' ? '<li><a href="'.esc_attr($staff_email).'"><i class="fa fa-envelope "></i></a></li>' : '').'
									'.(isset($staff_facebook) && $staff_facebook !='' ? '<li><a href="'.esc_attr($staff_facebook).'"><i class="fa fa-facebook "></i></a></li>' : '').'
									'.(isset($staff_twitter) && $staff_twitter !='' ? '<li><a href="'.esc_attr($staff_twitter).'"><i class="fa fa-twitter "></i></a></li>' : '').'
									'.(isset($staff_google_plus) && $staff_google_plus !='' ? '<li><a href="'.esc_attr($staff_google_plus).'"><i class="fa fa-google-plus "></i></a></li>' : '').'
									'.(isset($staff_skype) && $staff_skype !='' ? '<li><a href="'.esc_attr($staff_skype).'"><i class="fa fa-skype "></i></a></li>' : '').'
								</ul>
							</div>			
						</div>';
				}
				wp_reset_postdata();
			}		            

			$pinar_staff_code .='</div>';

		}



		return balancetags( $pinar_staff_code );
	}

	/**
	 * ------------------------------------------------------------------------------------------
	 * Send Feedback Form 
	 * ------------------------------------------------------------------------------------------
	 */
	function pinar_send_feedback($attr)
	{
		/**
		 * Pinar staff's Attribute
		 */
		$pinar_send_feedback_attr = shortcode_atts(
			array(
				'description'    => '',
				'class'			=> 'container'
			), $attr );

		$pinar_send_feedback_form ='
			<div class="add-testimonials-box '.(isset($pinar_send_feedback_attr['class']) && $pinar_send_feedback_attr['class'] !=='' ? $pinar_send_feedback_attr['class'] : '' ).'">
				<div class="front-box">
					<div class="title">'.esc_html__('Click Here to', 'ravis' ).'</div>
					<h2>'.ravis_fn_title_effect(esc_html__('Share your Experience', 'ravis' )).'</h2>
					<div class="title">'.esc_html__('about staying at Pinar Hotel', 'ravis' ).'</div>
				</div>
				<div class="back-box clearfix hide">
					<div class="fa fa-close"></div>
					<form class="add-testimonials clearfix" data-parsley-validate>
						<div class="col-md-4">
							<div class="title">'.sprintf('%s<b>%s</b>', esc_html__('Your Feedback is ', 'ravis'), esc_html__('Valuable', 'ravis')) .'</div>
							<div class="description">'.esc_html( $pinar_send_feedback_attr['description'] ) .'</div>
						</div>
						<div class="col-md-4">
							<input type="text" name="fname" class="fname" placeholder="'.esc_attr__('Full Name :', 'ravis') .'" required>
							<input type="email" name="email" class="email" placeholder="'.esc_attr__('Email :', 'ravis') .'">
							<input type="text" name="phone" class="phone" placeholder="'.esc_attr__('Phone :', 'ravis') .'">
							<input type="text" name="title" class="testimonial-title" placeholder="'.esc_attr__('Testimonial title :', 'ravis') .'" required>
						</div>
						<div class="col-md-4">
							<textarea name="testimonial" class="testimonial" placeholder="'.esc_attr__('Your Testimonial :', 'ravis') .'" required></textarea>
							<input type="submit" class="btn btn-default" value="'.esc_attr__('Submit', 'ravis') .'">
						</div>
					</form>
				</div>
			</div>
		';
		return balancetags( $pinar_send_feedback_form );
	}

	/**
	 * ------------------------------------------------------------------------------------------
	 * Other Rooms
	 * ------------------------------------------------------------------------------------------
	 */
	function pinar_other_rooms($attr)
	{
		global $pinar_opt, $post;
		/**
		 * Pinar Other Rooms Attribute
		 */
		$pinar_other_rooms_attr = shortcode_atts(
			array(
				'title'      => esc_html__('Other Rooms', 'ravis'),
				'room_count' => 2
			), $attr );

		$args = array(
			'post_type'      => 'rooms',
			'post_status'    => 'publish',
			'orderby'        => 'rand',
			'post__not_in'   => array( $post->ID ),
			'posts_per_page' => intval( $pinar_other_rooms_attr['room_count'] )
		);
		$pinar_rooms_list  = new WP_Query( $args );
		$price_unit = !empty($pinar_opt['pinar-booking-currency']) ? ravis_currency_converter($pinar_opt['pinar-booking-currency']) : '&#36;';

		$pinar_other_rooms = '
			<div class="room-container container room-grid">';
				if(!empty($pinar_other_rooms_attr['title']))
				{
					$pinar_other_rooms .= '
						<div class="heading-box">
							<h2>'.ravis_fn_title_effect(esc_html($pinar_other_rooms_attr['title'])).'</h2>
						</div>
					';
				}

				if($pinar_rooms_list->have_posts())
				{
					while ($pinar_rooms_list->have_posts()) {
						$pinar_rooms_list->the_post();
						$post_id          = get_the_id();
						$thumb_size       = array('580', '380' );
						$rooms_price      = get_post_meta( $post_id, 'rooms_price', true );
						$rooms_short_desc = get_post_meta( $post_id, 'rooms_short_desc', true );
						$room_imgs_id     = explode( ',' , get_post_meta( $post_id, 'rooms_slideshow_images' , true ));
						$room_cover       = trim($room_imgs_id[0]);

						$pinar_other_rooms .= '
						<div class="room-box col-xs-6">
							<div class="img-container">';
							if($room_cover != '')
		                    {
		                    	$pinar_other_rooms .= wp_get_attachment_image( $room_cover, $thumb_size ); 
		                    }
		                    else
		                    {
		                    	$pinar_other_rooms .= '<img src="'. esc_url ( PINAR_IMG_PATH ).'room-placeholder.jpg" alt="'. esc_attr( esc_html__('No Image','ravis') ).'" />';
		                    }
							
							$pinar_other_rooms .= '<a href="'.esc_url(get_permalink()).'" class="btn btn-default btn-out-border">'.esc_html__('More Details', 'ravis').'</a>
							</div>
							<div class="details">
								<div class="title"><a href="'.esc_url(get_permalink()).'">'.ravis_fn_title_effect(esc_html(get_the_title())).'</a></div>
								<div class="desc">'.esc_html($rooms_short_desc).'</div>
								<div class="price">
									<span>'.esc_html($price_unit.number_format($rooms_price)).'</span>
									'.esc_html__('- Per Night', 'ravis').'
								</div>
							</div>
						</div>';
					}	
				}

			$pinar_other_rooms .= '</div> ';
		
		return balancetags( $pinar_other_rooms );
	}


	/**
	 * ------------------------------------------------------------------------------------------
	 * Video Codes
	 * ------------------------------------------------------------------------------------------
	 */
	function pinar_video($attr)
	{
		global $pinar_opt;
		/**
		 * Pinar Other Rooms Attribute
		 */
		$pinar_video_attr = shortcode_atts(
			array(
				'title'     => __('This moment is your life.', 'ravis'),
				'sub_title' => __('Be happy for this moment.', 'ravis'),
				'video_id'  => 1,
				'video_url' => PINAR_BASE_URL.'/assets/video/',
				'class'     => ''
			), $attr );

		wp_register_script( 'pinar-video-script', PINAR_BASE_URL . '/assets/js/video.js', '', true );
		wp_enqueue_script('pinar-video-script');

		$pinar_video_content ='
			<div class="pinar-video-container '.$pinar_video_attr['class'].'" data-video-number="'.$pinar_video_attr['video_id'].'" data-video-path="'.$pinar_video_attr['video_url'].'">
				<div class="video-caption">';

		$pinar_video_content .= (!empty($pinar_video_attr['sub_title']) ? '<div class="subtitle">'.esc_html__($pinar_video_attr['sub_title'], 'ravis').'</div>' : '');

		$pinar_video_content .='
					<h3>
						'.esc_html__($pinar_video_attr['title'], 'ravis').'
					</h3>
					<div class="action-btn play">
						<span class="primary">'.esc_html__('Expanded view', 'ravis').'</span>
						<span class="secondry">'.esc_html__('Click to Play', 'ravis').'</span>
					</div>
					<div class="action-btn pause">'.esc_html__('Click to Pause', 'ravis').'</div>
				</div>
			</div>
		';

		return balancetags( $pinar_video_content );
	}

	/**
	 * ------------------------------------------------------------------------------------------
	 * Pinar Text Slider
	 * ------------------------------------------------------------------------------------------
	 */
	function pinar_text_slider($attr)
	{
		global $pinar_opt;

		$backgroun_img = (!empty($pinar_opt['pinar-text-slider-background']['url']) ? $pinar_opt['pinar-text-slider-background']['url'] : '');

		$pinar_text_slider_content ='
			<div class="text-slider" data-parallax="scroll" data-image-src="'.esc_attr($backgroun_img).'">
		';
		if(!empty($pinar_opt['pinar-text-slider-items']))
		{
			$pinar_text_slider_content .='<div class="text-slides-container">';

			foreach ($pinar_opt['pinar-text-slider-items'] as $text_slide) {
				$pinar_text_slider_content .='<div class="text-slide-box">'.balancetags( $text_slide ).'</div>';	
			}
			$pinar_text_slider_content .='</div>';
		}

		$pinar_text_slider_content .='
			</div>
		';
		return balancetags( $pinar_text_slider_content );
	}

	/**
	 * ------------------------------------------------------------------------------------------
	 * Pinar Room Listing
	 * ------------------------------------------------------------------------------------------
	 */
	function pinar_room_list($attr)
	{
		global $post, $pinar_opt;
		$price_unit = !empty($pinar_opt['pinar-booking-currency']) ? ravis_currency_converter($pinar_opt['pinar-booking-currency']) : '&#36;';
		/**
		 * Pinar Rooms Listing Attribute
		 */
		$pinar_room_listing_attr = shortcode_atts(
			array(
				'title'      => __('Our Rooms', 'ravis'),
				'sub_title'  => __('Be our guest in our luxury rooms', 'ravis'),
				'room_count' => 6,
				'class'      => ''
			), $attr );

		$args = array(
			'post_type'      => 'rooms',
			'post_status'    => 'publish',
			'order'          => 'DESC',
			'orderby'        => 'date',
			'posts_per_page' => $pinar_room_listing_attr['room_count']
		);
		$pinar_rooms_list      = new WP_Query( $args );

		if($pinar_rooms_list->posts)
		{
			$pinar_room_listing_content = '
			<div class="room-listing-container clearfix">
				<div class="heading-box">
					<h2>'.ravis_fn_title_effect(esc_html($pinar_room_listing_attr['title'] )).'</h2>';
					if(!empty($pinar_room_listing_attr['sub_title']))
					{
						$pinar_room_listing_content .= '<div class="subtitle">'.esc_html($pinar_room_listing_attr['sub_title']).'</div>';
					}
				$pinar_room_listing_content .= '</div>
				<div class="room-container room-masonry '.esc_attr($pinar_room_listing_attr['class']).'">';
					

				foreach ( $pinar_rooms_list->posts as $pinar_rooms_list_itme ) {
					$post_id          = $pinar_rooms_list_itme->ID;
					$thumb_size       = array('580', '380' );
					$rooms_price      = get_post_meta( $post_id, 'rooms_price', true );
					$rooms_short_desc = get_post_meta( $post_id, 'rooms_short_desc', true );
					$room_imgs_id     = explode( ',' , get_post_meta( $post_id, 'rooms_slideshow_images' , true ));
					$room_cover       = trim($room_imgs_id[0]);

					$pinar_room_listing_content .= '
					<div class="room-box col-xs-6 col-md-4">
						<div class="img-container">';

		                    if($room_cover != '')
		                    {
		                    	$pinar_room_listing_content .= wp_get_attachment_image( $room_cover, $thumb_size ); 
		                    }
		                    else
		                    {
		                    	$pinar_room_listing_content .= '<img src="'. esc_url ( PINAR_IMG_PATH ).'room-placeholder.jpg" alt="'. esc_attr( esc_html__('No Image','ravis') ).'" />';
		                    }

						$pinar_room_listing_content .= '<a href="'.esc_url(get_permalink( $post_id )).'" class="btn btn-default btn-out-border">'.esc_html__('More Details', 'ravis').'</a>
						</div>
						<div class="details">
							<div class="title"><a href="'.esc_url(get_permalink( $post_id )).'">'.ravis_fn_title_effect(esc_html($pinar_rooms_list_itme->post_title)).'</a></div>
							<div class="desc">'.esc_html($rooms_short_desc).'</div>
							<div class="price">
								<span>'.esc_html($price_unit.number_format($rooms_price)).'</span>
								'.esc_html__('- Per Night', 'ravis').'
							</div>
						</div>
					</div>';
				}
				$pinar_room_listing_content .= '</div>
				</div>';
		}
		else
		{
			$pinar_room_listing_content = esc_html__('There is not any rooms!', 'ravis');
		}

		return balancetags( $pinar_room_listing_content );
	}


	/**
	 * ------------------------------------------------------------------------------------------
	 * Pinar Latest Post
	 * ------------------------------------------------------------------------------------------
	 */
	function pinar_latest_post($attr)
	{
		global $post, $pinar_opt;
		/**
		 * Pinar Rooms Listing Attribute
		 */
		$pinar_latest_posts_attr = shortcode_atts(
			array(
				'title'          => __('Latest Blog Posts', 'ravis'),
				'sub_title'      => __('', 'ravis'),
				'post_count'     => 3,
				'content_length' => $pinar_opt['opt-excerpt-length'],
				'class'          => 'container'
			), $attr );

		$args = array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'order'               => 'DESC',
			'orderby'             => 'date',
			'ignore_sticky_posts' => true,
			'posts_per_page'      => $pinar_latest_posts_attr['post_count']
		);
		$pinar_latest_post      = new WP_Query( $args );


		if($pinar_latest_post->posts)
		{
			$pinar_latest_posts_content = '
			<div class="latest-post-container clearfix">
				<div class="heading-box">
					<h2>'.ravis_fn_title_effect(esc_html($pinar_latest_posts_attr['title'] )).'</h2>';
					if(!empty($pinar_latest_posts_attr['sub_title']))
					{
						$pinar_latest_posts_content .= '<div class="subtitle">'.esc_html($pinar_latest_posts_attr['sub_title']).'</div>';
					}
				$pinar_latest_posts_content .= '</div>
				<div class="posts-container '.esc_attr($pinar_latest_posts_attr['class']).'">';


				foreach ( $pinar_latest_post->posts as $pinar_latest_post_itme ) {
					$pinar_latest_post->the_post();
					$post_id          = $pinar_latest_post_itme->ID;

					$pinar_latest_posts_content .= '
					<div class="post-box clearfix wow fadeInUp">
						';
						if(has_post_thumbnail( $post_id ))
						{
		                    $pinar_latest_posts_content .= '
							<div class="img-container col-md-6">
			                    <a href="'. esc_url( get_permalink($post_id) ) .'">
			                    	'. get_the_post_thumbnail( $post_id ).'
			                    </a>
							</div>
			                ';						
						}

						$pinar_latest_posts_content .= '
						<div class="details '.( has_post_thumbnail( $post_id ) ? 'col-md-6' : '' ).'">
							<div class="title"><a href="'.esc_url(get_permalink($post_id)).'">'.esc_html($pinar_latest_post_itme->post_title).'</a></div>
							<div class="content">
								'.the_excerpt_max_charlength($pinar_latest_posts_attr['content_length'], $post_id).'
							</div>

						</div>
					</div>';
				}
				$pinar_latest_posts_content .= '</div>
				</div>';
		}
		else
		{
			$pinar_latest_posts_content = esc_html__('There is not any rooms!', 'ravis');
		}

		return balancetags( $pinar_latest_posts_content );
	}

	
	

}

$ravis_shortcode_obj = new Ravis_booking_shortcode;