jQuery(document).ready(function($) {
	jQuery('title').text('Shortcode Wizard');
	jQuery('#shortcode-item').on('change', function(event) {
		event.preventDefault();
		var shortcodeVal = jQuery(this).val();
		if(jQuery('#'+shortcodeVal).length !== 0)
		{
			jQuery('#'+shortcodeVal).removeClass('hide').siblings().not('#shortcode-item-container').addClass('hide');
		}
		else
		{
			jQuery('.no-attributes').removeClass('hide').siblings().not('#shortcode-item-container').addClass('hide');
		}

	});
	jQuery('#availability-form-type').on('change', function(event) {
		event.preventDefault();
		var availabilityForm = jQuery('.availability-form-style-box');
		jQuery(this).val() == 'horizontal' ? availabilityForm.addClass('hide') : availabilityForm.removeClass('hide');
	});

	jQuery('#staff-type').on('change', function(event) {
		event.preventDefault();
		var staffID = jQuery('#staff-id-box');
		jQuery(this).val() == 'single' ? staffID.removeClass('hide') : staffID.addClass('hide');
	});


	jQuery('#shortcode-form').on('submit', function(event) {
		event.preventDefault();
		var newShortcode = '',
			shortCodeVal = jQuery('#shortcode-item').val();

		if( shortCodeVal !== '0'){
			newShortcode += '['+ shortCodeVal;

			jQuery('#' + shortCodeVal + ' .form-item').each(function(index, el) {
				if(jQuery(this).val() != ''){
					newShortcode += ' ' + jQuery(this).attr('name') +'="' + jQuery(this).val() + '" ';					
				}
			});
 			
 			newShortcode += ']';
		}

		// inserts the shortcode into the active editor
		tinyMCE.activeEditor.execCommand('mceInsertContent', 0, newShortcode);

		// closes Thickbox
		tinyMCEPopup.close();
	});	
});