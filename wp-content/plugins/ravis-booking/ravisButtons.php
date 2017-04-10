<?php 
if (!defined('ABSPATH')) {
	die( 'Your are in wrong place.' );
}
define('RAVIS_BOOKING_SHORTCODE_WIZARD', true);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php wp_head(); ?>	
</head>
<body>
	<form action="#" id="shortcode-form">
		<div class="button-container">
			<input type="submit" value="<?php esc_html_e('Insert', RAVIS_PLG_TEXT_DOMAIN); ?>">
		</div>
		<div class="inner-container">
			<div class="rows" id="shortcode-item-container">
				<label for="shortcode-item"><?php esc_html_e('ShortCode : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
				<select name="shortcode-item" id="shortcode-item">
					<option value="0"><?php esc_html_e('Select a shortcode' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
					<option value="pinar-main-slider"><?php esc_html_e('Main Slider' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
					<option value="pinar-service-slider"><?php esc_html_e('Service Slider' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
					<option value="pinar-social-icons"><?php esc_html_e('Social Icons' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
					<option value="pinar-luxury-rooms"><?php esc_html_e('Luxury Rooms' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
					<option value="pinar-availability-form"><?php esc_html_e('Availability Form' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
					<option value="pinar-packages"><?php esc_html_e('Packages' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
					<option value="pinar-call-to-action"><?php esc_html_e('Call to Action' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
					<option value="pinar-main-gallery"><?php esc_html_e('Gallery' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
					<option value="pinar-staff"><?php esc_html_e('Staff' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
					<option value="pinar-send-feedback"><?php esc_html_e('Send Feedback' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
					<option value="pinar-other-rooms"><?php esc_html_e('Other Rooms' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
					<option value="pinar-video"><?php esc_html_e('Video' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
					<option value="pinar-text-slider"><?php esc_html_e('Text Slider' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
					<option value="pinar-room-list"><?php esc_html_e('Room List' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
					<option value="pinar-latest-post"><?php esc_html_e('Latest Posts' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
				</select>
				<div class="hint"><?php esc_html_e('Please select the shortcode you want to add.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
			</div>
			<div class="rows no-attributes hide"><?php esc_html_e( 'This shortcode doesn\'t have any attributes', RAVIS_PLG_TEXT_DOMAIN ); ?></div>
			<div id="pinar-service-slider" class="hide">
				<div class="rows">
					<label for="service-slider-title"><?php esc_html_e('Title : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="title" id="service-slider-title" placeholder="<?php esc_html_e('Our Services', RAVIS_PLG_TEXT_DOMAIN) ?>">
					<div class="hint"><?php esc_html_e('Add title of service slider section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="service-slider-class"><?php esc_html_e('Class : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="class" id="service-slider-class">
					<div class="hint"><?php esc_html_e('If you need that this section has a class, add it here.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
			</div>
			<div id="pinar-social-icons" class="hide">
				<div class="row">
					<label for="spcial-icon-id"><?php esc_html_e('Title : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="id" id="spcial-icon-id" placeholder="social-icons">
					<div class="hint"><?php esc_html_e('Add the class of this section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="social-icons-print"><?php esc_html_e('Print : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<select class="form-item" name="print" id="social-icons-print">
						<option value="false" selected="selected"><?php esc_html_e('No' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
						<option value="true"><?php esc_html_e('Yes' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
					</select>
					<div class="hint"><?php esc_html_e('Select that you want to print the icons or not?', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
			</div>
			<div id="pinar-luxury-rooms" class="hide">
				<div class="rows">
					<label for="luxury-rooms-title"><?php esc_html_e('Title : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="title" id="luxury-rooms-title" placeholder="<?php esc_html_e('Luxury Rooms', RAVIS_PLG_TEXT_DOMAIN) ?>">
					<div class="hint"><?php esc_html_e('Add title of luxury rooms section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="luxury-rooms-subtitle"><?php esc_html_e('Subtitle : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="subtitle" id="luxury-rooms-subtitle" placeholder="<?php esc_html_e('Best rooms with Best services', RAVIS_PLG_TEXT_DOMAIN) ?>">
					<div class="hint"><?php esc_html_e('Add Subtitle of luxury rooms section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="luxury-rooms-count"><?php esc_html_e('Count : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="number" class="form-item" name="room_count" id="luxury-rooms-count" placeholder="3">
					<div class="hint"><?php esc_html_e('Add how many rooms you want to show.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
			</div>
			<div id="pinar-availability-form" class="hide">
				<div class="rows">
					<label for="availability-form-type"><?php esc_html_e('Type : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<select class="form-item" name="type" id="availability-form-type">
						<option value="vertical" selected="selected"><?php esc_html_e('Vertical' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
						<option value="horizontal"><?php esc_html_e('Horizontal' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
					</select>
					<div class="hint"><?php esc_html_e('Select which type of form you want to use.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows availability-form-style-box">
					<label for="availability-form-style"><?php esc_html_e('Style : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<select class="form-item" name="style" id="availability-form-style">
						<option value="style-2" selected="selected"><?php esc_html_e('Simple' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
						<option value=" "><?php esc_html_e('Circle' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
					</select>
					<div class="hint"><?php esc_html_e('Select which type of form you want to use.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="availability-form-title"><?php esc_html_e('Title : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="title" id="availability-form-title" placeholder="<?php esc_html_e('Find A Room', RAVIS_PLG_TEXT_DOMAIN) ?>">
					<div class="hint"><?php esc_html_e('Add title of availability form section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
			</div>
			<div id="pinar-packages" class="hide">
				<div class="rows">
					<label for="packages-title"><?php esc_html_e('Title : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="title" id="packages-title" placeholder="<?php esc_html_e('Packages', RAVIS_PLG_TEXT_DOMAIN) ?>">
					<div class="hint"><?php esc_html_e('Add title of packages section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="packages-subtitle"><?php esc_html_e('Subtitle : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="subtitle" id="packages-subtitle" placeholder="<?php esc_html_e('Choose your desired package and book NOW!', RAVIS_PLG_TEXT_DOMAIN) ?>">
					<div class="hint"><?php esc_html_e('Add subtitle of packages section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="packages-desc"><?php esc_html_e('Description : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<textarea name="description" id="packages-desc" class="form-item"></textarea>
					<div class="hint"><?php esc_html_e('Add description of packages section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="packages-type"><?php esc_html_e('Type : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<select class="form-item" name="type" id="packages-type">
						<option value="compact" selected="selected"><?php esc_html_e('Compact' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
						<option value="expand"><?php esc_html_e('Expand' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
					</select>
					<div class="hint"><?php esc_html_e('Select which type of packages you want to use.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="packages-count"><?php esc_html_e('Count : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="number" class="form-item" name="per_page" id="packages-count" placeholder="<?php esc_html_e('All', RAVIS_PLG_TEXT_DOMAIN) ?>">
					<div class="hint"><?php esc_html_e('Add how many packages you want to show.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
			</div>
			<div id="pinar-call-to-action" class="hide">
				<div class="rows">
					<label for="call-action-title"><?php esc_html_e('Title : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="title" id="call-action-title" placeholder="<?php esc_html_e('Do you need to have Hotel / Resort template?', RAVIS_PLG_TEXT_DOMAIN) ?>">
					<div class="hint"><?php esc_html_e('Add title of call to action section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="call-action-button"><?php esc_html_e('Button Text : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="button_text" id="call-action-button" placeholder="<?php esc_html_e('Purchase this template', RAVIS_PLG_TEXT_DOMAIN) ?>">
					<div class="hint"><?php esc_html_e('Add text of button in call to action section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="call-action-url"><?php esc_html_e('Button URL : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="link" id="call-action-url" placeholder="http://themeforest.net/item/pinar-hotel-responsive-booking-template/11369156/?ref=RavisTheme">
					<div class="hint"><?php esc_html_e('Add url of button in call to action section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
			</div>
			<div id="pinar-main-gallery" class="hide">
				<div class="rows">
					<label for="gallery-title"><?php esc_html_e('Title : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="title" id="gallery-title" placeholder="<?php esc_html_e('Pinar Gallery', RAVIS_PLG_TEXT_DOMAIN) ?>">
					<div class="hint"><?php esc_html_e('Add title of gallery section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="gallery-sort"><?php esc_html_e('Sort Options : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="sort_option" id="gallery-sort">
					<div class="hint"><?php esc_html_e('Add sort option of gallery in CSV format in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="gallery-count"><?php esc_html_e('Count : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="number" class="form-item" name="img_count" id="gallery-count" placeholder="8">
					<div class="hint"><?php esc_html_e('Add how many images you want to show in gallery.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="gallery-more"><?php esc_html_e('More Button : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<select class="form-item" name="more_link" id="gallery-more">
						<option value="true" selected="selected"><?php esc_html_e('Yes' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
						<option value=" "><?php esc_html_e('No' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
					</select>
					<div class="hint"><?php esc_html_e('Select that you want to show the more button in gallery or not?', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>


			</div>
			<div id="pinar-staff" class="hide">
				<div class="rows">
					<label for="staff-title"><?php esc_html_e('Title : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="title" id="staff-title" placeholder="<?php esc_html_e('Our Staff', RAVIS_PLG_TEXT_DOMAIN) ?>">
					<div class="hint"><?php esc_html_e('Add title of staff section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="staff-subtitle"><?php esc_html_e('Subtitle : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="subtitle" id="staff-subtitle" placeholder="<?php esc_html_e('Professional & Experienced team', RAVIS_PLG_TEXT_DOMAIN) ?>">
					<div class="hint"><?php esc_html_e('Add Subtitle of staff section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="staff-type"><?php esc_html_e('Type : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<select class="form-item" name="type" id="staff-type">
						<option value="slider" selected="selected"><?php esc_html_e('Slider' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
						<option value="tiled"><?php esc_html_e('Tiled' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
						<option value="single"><?php esc_html_e('Single' , RAVIS_PLG_TEXT_DOMAIN); ?></option>
					</select>
					<div class="hint"><?php esc_html_e('Select which type of staff box you want to use.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="staff-class"><?php esc_html_e('Class : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="class" id="staff-class">
					<div class="hint"><?php esc_html_e('Add Class of staff section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows hide" id="staff-id-box">
					<label for="staff-id"><?php esc_html_e('Class : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="number" class="form-item" name="staff_id" id="staff-id">
					<div class="hint"><?php esc_html_e('Add ID of staff section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
			</div>
			<div id="pinar-send-feedback" class="hide">
				<div class="rows">
					<label for="feedback-description"><?php esc_html_e('Description : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<textarea  class="form-item" name="description" id="feedback-description"></textarea>
					<div class="hint"><?php esc_html_e('Add description of send feedback section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="feedback-class"><?php esc_html_e('Class : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="class" id="feedback-class" placeholder="container">
					<div class="hint"><?php esc_html_e('Add class of send feedback section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
			</div>
			<div id="pinar-other-rooms" class="hide">
				<div class="rows">
					<label for="other-rooms-title"><?php esc_html_e('Title : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="title" id="other-rooms-title" placeholder="<?php esc_html_e('Other Rooms', RAVIS_PLG_TEXT_DOMAIN) ?>">
					<div class="hint"><?php esc_html_e('Add title of other rooms section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="other-rooms-count"><?php esc_html_e('Count : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="number" class="form-item" name="room_count" id="other-rooms-count" placeholder="2">
					<div class="hint"><?php esc_html_e('Add how many rooms you want to show in other rooms section?.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
			</div>
			<div id="pinar-video" class="hide">
				<div class="rows">
					<label for="video-title"><?php esc_html_e('Title : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="title" id="video-title" placeholder="<?php esc_html_e('This moment is your life.', RAVIS_PLG_TEXT_DOMAIN) ?>">
					<div class="hint"><?php esc_html_e('Add title of video section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="video-subtitle"><?php esc_html_e('Subtitle : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="sub_title" id="video-subtitle" placeholder="<?php esc_html_e('Be happy for this moment.', RAVIS_PLG_TEXT_DOMAIN) ?>">
					<div class="hint"><?php esc_html_e('Add Subtitle of video section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="video-id"><?php esc_html_e('Video ID : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="video_id" id="video-id" placeholder="1">
					<div class="hint"><?php esc_html_e('Add ID of video section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="video-url"><?php esc_html_e('Video URL : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="video_url" id="video-url" placeholder="THEME_URL/assets/video/">
					<div class="hint"><?php esc_html_e('Add URL of video section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="video-class"><?php esc_html_e('Class : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="video_class" id="video-class">
					<div class="hint"><?php esc_html_e('Add class of video section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>

			</div>
			<div id="pinar-room-list" class="hide">
				<div class="rows">
					<label for="room-list-title"><?php esc_html_e('Title : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="title" id="room-list-title" placeholder="<?php esc_html_e('Our Rooms', RAVIS_PLG_TEXT_DOMAIN) ?>">
					<div class="hint"><?php esc_html_e('Add title of room list section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="room-list-subtitle"><?php esc_html_e('Subtitle : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="sub_title" id="room-list-subtitle" placeholder="<?php esc_html_e('Be our guest in our luxury rooms', RAVIS_PLG_TEXT_DOMAIN) ?>">
					<div class="hint"><?php esc_html_e('Add Subtitle of room list section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="room-list-count"><?php esc_html_e('Count : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="number" class="form-item" name="room_count" id="room-list-count" placeholder="6">
					<div class="hint"><?php esc_html_e('Add how many rooms you want to show.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="room-list-class"><?php esc_html_e('Class : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="class" id="room-list-class">
					<div class="hint"><?php esc_html_e('Add class of room list section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
			</div>
			<div id="pinar-latest-post" class="hide">
				<div class="rows">
					<label for="latest-post-title"><?php esc_html_e('Title : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="title" id="latest-post-title" placeholder="<?php esc_html_e('Latest Blog Posts', RAVIS_PLG_TEXT_DOMAIN) ?>">
					<div class="hint"><?php esc_html_e('Add title of room list section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="latest-post-subtitle"><?php esc_html_e('Subtitle : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="sub_title" id="latest-post-subtitle">
					<div class="hint"><?php esc_html_e('Add Subtitle of room list section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="latest-post-count"><?php esc_html_e('Post Count : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="number" class="form-item" name="post_count" id="latest-post-count" placeholder="3">
					<div class="hint"><?php esc_html_e('Add how many posts you want to show.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="latest-post-length"><?php esc_html_e('Content Length : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="number" class="form-item" name="content_length" id="latest-post-length">
					<div class="hint"><?php esc_html_e('Add how many character you to show in the posts as their description.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>
				<div class="rows">
					<label for="latest-post-class"><?php esc_html_e('Class : ', RAVIS_PLG_TEXT_DOMAIN ); ?></label>
					<input type="text" class="form-item" name="class" id="latest-post-class" placeholder="container">
					<div class="hint"><?php esc_html_e('Add class of latest posts section in this field.', RAVIS_PLG_TEXT_DOMAIN) ?></div>
				</div>

			</div>
		</div>
	</form>	
	<?php wp_footer(); ?>	
	</body>
</html>