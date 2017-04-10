<?php
/**
 *	contact-alt.php
 * 	Contact Alternative template 
 *  Template Name: Contact Alternative
 */	
global $pinar_opt;
get_header();
?>
<div id="map"></div>
<div class="contact-page-container container">
	<!-- Contact Info -->
	<div class="contact-info-main-box clearfix">
		<div class="contact-info-inner clearfix">
			<div class="contact-info-box col-md-4">
				<div class="inner-content">
					<i class="fa fa-envelope-o"></i><div class="info"><?php echo esc_html( $pinar_opt['opt-hotel-email'] ); ?></div>
				</div>
			</div>
			<div class="contact-info-box col-md-4">
				<div class="inner-content">
					<i class="fa fa-phone"></i><div class="info"><?php echo esc_html( $pinar_opt['opt-hotel-phone'] ); ?></div>
				</div>
			</div>
			<div class="contact-info-box col-md-4">
				<div class="inner-content">
					<i class="fa fa-map-marker "></i><div class="info"><?php echo esc_html( $pinar_opt['opt-hotel-address'] ); ?></div>
				</div>
			</div>
		</div>
	</div>

	<!-- Contact Form -->
		<div class="contact-form-container">
			<div class="how-contact col-md-4">
				<div class="title"><?php echo ravis_fn_title_effect(esc_html__('How to contact', 'pinar') ); ?></div>
				<div class="desc"><?php echo balancetags($pinar_opt['opt-contact-text']); ?></div>
			</div>
			<div class="contact-form-box col-md-8">
				<?php 
					if(have_posts())
					{
						while (have_posts()) {
							the_post();
							the_content();
						}
					}
				?>
			</div>
		</div>
</div>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js<?php echo !empty($pinar_opt['opt-map-api']) ? '?key='.esc_attr($pinar_opt['opt-map-api']) : ''; ?>"></script>
<script type="text/javascript">
	"use strict";
    function initialize() {
        var myLatLng = new google.maps.LatLng(<?php echo  esc_js( $pinar_opt['opt-map-lat'].', '.$pinar_opt['opt-map-lng'] ) ?>);
        var mapOptions = {
            zoom: 12,
            center: myLatLng,
            // This is where you would paste any style found on Snazzy Maps.
            styles: [{featureType:"landscape",stylers:[{saturation:-100},{lightness:65},{visibility:"on"}]},{featureType:"poi",stylers:[{saturation:-100},{lightness:51},{visibility:"simplified"}]},{featureType:"road.highway",stylers:[{saturation:-100},{visibility:"simplified"}]},{featureType:"road.arterial",stylers:[{saturation:-100},{lightness:30},{visibility:"on"}]},{featureType:"road.local",stylers:[{saturation:-100},{lightness:40},{visibility:"on"}]},{featureType:"transit",stylers:[{saturation:-100},{visibility:"simplified"}]},{featureType:"administrative.province",stylers:[{visibility:"off"}]},{featureType:"administrative.locality",stylers:[{visibility:"off"}]},{featureType:"administrative.neighborhood",stylers:[{visibility:"on"}]},{featureType:"water",elementType:"labels",stylers:[{visibility:"off"},{lightness:-25},{saturation:-100}]},{featureType:"water",elementType:"geometry",stylers:[{hue:"#ffff00"},{lightness:-25},{saturation:-97}]}],

            // Extra options
            scrollwheel: false,
            mapTypeControl: false,
            panControl: false,
            zoomControlOptions: {
                style   : google.maps.ZoomControlStyle.SMALL,
                position: google.maps.ControlPosition.LEFT_BOTTOM
            }
        };
        var map = new google.maps.Map(document.getElementById('map'),mapOptions);

        var image = '<?php echo !empty($pinar_opt['opt-map-marker']['url']) ? esc_js($pinar_opt['opt-map-marker']['url']) : esc_js( PINAR_IMG_PATH.'marker.png' ); ?>';

        var beachMarker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            icon: image
        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>

<?php
get_footer();