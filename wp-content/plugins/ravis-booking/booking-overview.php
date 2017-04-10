<div id="booking-overview-page">
	<h1><?php esc_html_e( 'Booking Overview', 'ravis' ); ?></h1>
	<div id="calendar"></div>
</div>
<script type="text/javascript" src="<?php echo RAVIS_PLG_JS_PATH; ?>moment.min.js"></script>
<script type="text/javascript" src="<?php echo RAVIS_PLG_JS_PATH; ?>fullcalendar.min.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function() {
		"use strict";
		jQuery('#calendar').fullCalendar({
			eventMouseover: function( event, jsEvent, view ) {
				var eventURL   = event.url,
					eventTitle = event.title;

				jQuery('.fc-event').each(function(index, el) {
					var eventHref = jQuery(this).attr('href'),
						eventText = jQuery(this).find('.fc-title').text();

					if( eventHref == eventURL && eventText == eventTitle )
					{
						jQuery(this).addClass('hover-event');
					}
				});
					

			},
			eventMouseout: function( event, jsEvent, view ) {
				jQuery('.fc-event').removeClass('hover-event');
			},
			eventSources: [
				{
					events: function(start, end, timezone, callback) {
				        jQuery.ajax({
				            url: '<?php echo esc_url( admin_url()) ?>admin-ajax.php ',
				            dataType: 'json',
				            method: 'post',
				            data: {
				            	action: "ravis_get_booking_info",
				                start: start.unix(),
				                end: end.unix()
				            }				            
				        }).done(function(dataBooking) {
			            	var events = [];
			                jQuery(dataBooking).each(function() {
			                    events.push({
			                        title: jQuery(this).attr('title'),
			                        start: jQuery(this).attr('start'), 
			                        end: jQuery(this).attr('end'), 
			                        url: jQuery(this).attr('url'),
			                        rendering: jQuery(this).attr('rendering'),
			                        color: jQuery(this).attr('color') 
			                    });
			                });
			                callback(events);
			            });
				    }
				}
			]
		});
	});
</script>