jQuery(document).ready(function($){
	"use strict"
    jQuery(".datepicker").datepicker({
        dateFormat: "yy-mm-dd" 
    });
	jQuery('.custom_upload_image_button').on('click', function(event) {
        event.preventDefault();
        var formfield 	= jQuery(this).siblings('.custom_upload_image'),
        	preview 	= jQuery(this).siblings('.custom_preview_image');
        tb_show('', 'media-upload.php?type=image&TB_iframe=true');
        window.send_to_editor = function(html) {

            if(jQuery(html).find("img").length > 0){
                var imgurl 	= jQuery('img',html).attr('src'),
                    classes = jQuery('img', html).attr('class'),
                    id 		= classes.replace(/(.*?)wp-image-/, '');
            } else {
                var imgurl 	= jQuery(html).attr('src'),
                    classes = jQuery(html).attr('class'),
                    id 		= classes.replace(/(.*?)wp-image-/, '');
            }

            formfield.val(id);
            preview.attr('src', imgurl);
            tb_remove();
        }
        return false;
    });
     
    jQuery('.custom_clear_image_button').on('click', function(event) {
        event.preventDefault();
        var defaultImage = jQuery(this).parents('.img_uploader_post_meta').siblings('.custom_default_image').text();
        jQuery(this).parent().siblings('.custom_upload_image').val('');
        jQuery(this).parent().siblings('.custom_preview_image').attr('src', defaultImage);
        return false;
    });
});
