<?php 
/**
 *	booking.php
 * 	Booking Page of Gallery
 *  Template Name: Booking Page
 */	
global $pinar_opt, $post;

get_header();

if($_POST)
{
	$check_in_date  = ( isset($_POST['start']) ? $_POST['start'] : '');
	$check_out_date = ( isset($_POST['end']) ? $_POST['end'] : '');
	$adult_guest    = ( isset($_POST['adult']) ? intval($_POST['adult']) : '');
	$child_guest    = ( isset($_POST['child']) ? intval($_POST['child']) : '');
}
if(isset($_GET['package']))
{
	$package_id = intval($_GET['package']);
}
?>
<div id="booking-page-content">
	<div class="booking-container container">
		<div class="heading-box">
			<h2><?php echo ravis_fn_title_effect(esc_html__($pinar_opt['pinar-booking-title'], 'pinar')) ?></h2>
		</div>
		<?php 
		if(isset($pinar_opt['pinar-booking-desc']) && $pinar_opt['pinar-booking-desc'] !=='')
		{
			echo '
				<div class="main-booking-description">
					'.esc_html__($pinar_opt['pinar-booking-desc'], 'pinar').'
				</div>';
		}
		?>
		<ul class="nav nav-tabs nav-justified" id="booking-tabs">
	        <li class="active">
	            <div class="tab-boxes">
	                <span class="title"><?php echo ravis_fn_title_effect(esc_html__('Choose Date', 'pinar')) ?></span>
	            </div>
	        </li>
	        <li>
	            <div class="tab-boxes">
	                <span class="title"><?php echo ravis_fn_title_effect(esc_html__('Choose Room', 'pinar')) ?></span>
	            </div>
	        </li>
	        <li>
	            <div class="tab-boxes">
	                <span class="title"><?php echo ravis_fn_title_effect(esc_html__('Reservation', 'pinar')) ?></span>
	            </div>
	        </li>
	        <li>
	            <div class="tab-boxes">
	                <span class="title"><?php echo ravis_fn_title_effect(esc_html__('Confirmation', 'pinar')) ?></span>
	            </div>
	        </li>
	    </ul>

		<div id="booking-tab-contents" class="tab-content">
		<?php
		$adult_select_option = $child_select_option = '';
		for ($i=0; $i < 7; $i++) { 
			$adult_select_option .='<option value="'. esc_attr( $i ) .'" '. ( isset($adult_guest) && $adult_guest == $i &&  $adult_guest != 0 ? esc_attr('selected="selected"') : '') .' >'. esc_html($i) .'</option>';
			$child_select_option .='<option value="'. esc_attr( $i ) .'" '. ( isset($child_guest) && $child_guest == $i &&  $child_guest != 0 ? esc_attr('selected="selected"') : '') .' >'. esc_html($i) .'</option>';
		}
		?>
			<input type="hidden" id="step" value="1">
			<input type="hidden" id="package_id" value="<?php echo (isset($package_id) ? esc_attr ( $package_id ) : '' ); ?>">
			<div class="loader"></div>
			<div class="error-message-box"></div>
			<div class="tab-pane fadeInUp in active clearfix" id="booking-choose-date">
                <div class="input-daterange booking-dates col-xs-12 col-lg-8">
                    <div class="booking-date-fields-container col-xs-12 col-sm-6">
                        <h4><?php echo ravis_fn_title_effect(esc_html__('Check in', 'pinar' )) ?></h4>
                        <input type="hidden" class="check-in-date" value="<?php echo (isset($check_in_date) ? esc_attr( $check_in_date ) : ''); ?>">
                    </div>
                    <div class="booking-date-fields-container col-xs-12 col-sm-6">
                        <h4><?php echo ravis_fn_title_effect(esc_html__('Check out', 'pinar' )) ?></h4>
                        <input type="hidden" class="check-out-date" value="<?php echo (isset($check_out_date) ? esc_attr( $check_out_date ) : ''); ?>">
                    </div>
                </div>

                <div class="more-details-container col-xs-12 col-lg-4">
					<h4><?php echo ravis_fn_title_effect(esc_html__('Other details', 'pinar' )) ?></h4>
                    
                    <div class="field-container">
                        <label for="adult-guest"><?php esc_html_e('Adult :', 'pinar' ); ?></label>
                        <select name="adult-guest" id="adult-guest">
                        	<?php echo balancetags($adult_select_option ); ?>
                        </select>
                    </div>
                    <div class="field-container">
                        <label for="child-guest"><?php esc_html_e('Children :', 'pinar' ); ?></label>
                        <select name="child-guest" id="child-guest">
                        	<?php echo balancetags($child_select_option ); ?>
                        </select>
                    </div>
                    <div class="field-container">
                		<input type="submit" class="btn btn-default check-availability-butt" value="<?php esc_html_e('Check Availability', 'pinar' ); ?>">
                    </div>
                </div>
            </div>            
		</div>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
	"use strict"
	
	// Check availability function
	jQuery(".check-availability-butt").on("click", function (e){
		e.preventDefault();
		var chooseDateContainer = jQuery("#booking-choose-date"),
			step 				= jQuery('#step').val(),
			tabContentMainBox	= jQuery("#booking-tab-contents"),
			checkInDate 		= chooseDateContainer.find(".check-in-date").val(),
			checkOutDate 		= chooseDateContainer.find(".check-out-date").val(),
			packageID 			= jQuery("#package_id").val(),
			adultGuest 			= jQuery("#adult-guest").val(),
			childGuest 			= ( jQuery("#child-guest").val() ? jQuery("#child-guest").val() : 0 ),
			errorBox 			= tabContentMainBox.find(".error-message-box").hide(),
			errorMessage		= "";

		if(checkInDate == "" || checkOutDate == "")
		{
			errorMessage = errorMessage + "<?php echo esc_js(esc_html__('Please fill both Check in and Check out dates', 'pinar')) ?><br />";
		} 
		if(checkInDate == checkOutDate)
		{
			errorMessage = errorMessage + "<?php echo esc_js(esc_html__('Please change the dates to cover at-least a night', 'pinar')) ?><br />";
		} 
		if(adultGuest == "" || adultGuest == 0)
		{
			errorMessage = errorMessage + " <?php echo esc_js(esc_html__('Please add how many guest we have!', 'pinar')) ?><br />";
		}
		if(errorMessage != "")
		{
			errorBox.show().addClass("active alert alert-danger").html(errorMessage);
			jQuery("body,html").animate({
	            scrollTop: errorBox.offset().top - 100
	        }, 1000);
			return false;	
		}
		tabContentMainBox.addClass("loading");
		var data = {
			action: "booking_form",
			checkIn: checkInDate,
			checkOut: checkOutDate,
			adultGuest: adultGuest,
			childGuest: childGuest,
			packageID: packageID,
			step: step,
		};
		jQuery.post("<?php echo esc_js( admin_url() ); ?>admin-ajax.php", data, function(data){

			if(jQuery.trim(data) =='0')
			{
				tabContentMainBox.removeClass("loading");
				errorBox.show().addClass("active alert alert-danger").html("<?php echo esc_js( esc_html__('Sorry, but we don\'t have any room available', 'pinar') ); ?>");
			}
			else
			{
				jQuery('#booking-tab-contents').removeClass("loading");
				jQuery('#booking-tab-contents').html(data);
				jQuery("body,html").animate({
		            scrollTop: tabContentMainBox.offset().top - 100
		        }, 1000);
				var currentStep = jQuery('#booking-tab-contents #step').val(),
					bookinTabContainer  = jQuery('#booking-tabs');

				bookinTabContainer.find('li').removeClass('active');
				jQuery('#booking-tabs li:eq('+ (currentStep - 1) +')').addClass('active');						
			}
		});
	});

});
</script>

<?php
get_footer();