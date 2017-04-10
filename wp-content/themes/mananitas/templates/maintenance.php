<?php
/**
 *	notifier.php
 * 	notifier Mode template
 *  Template Name: Coming Soon
 */
global $pinar_opt;
wp_head();
$bg = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
?>
<body class="internal-pages coming-soon" <?php echo (isset($bg) && $bg !=='' ? 'style="background-image: url('.$bg.')"' : '') ?>>
	<div class="coming-soon-inner-box">
		<h1><?php esc_html_e( 'Coming Soon', 'pinar' ); ?></h1>
		<div class="desc">
			<?php esc_html_e( 'We\'re currently working on creating something fantastic. ', 'pinar' ); ?>			
			<br> 
			<?php esc_html_e( 'We\'ll be here soon, subscribe to be notified.', 'pinar' ); ?>
		</div>

		<!-- Search Box -->
		<div class="search-box">
			<form class="search-form">
				<input type="email" placeholder="<?php esc_html_e('Enter your email ...', 'pinar') ?>" value="" name="s" title="Search ">
				<input type="submit" value="<?php esc_html_e('Notify Me', 'pinar') ?>">
				<div class="message-container"></div>
			</form>
		</div>
		<?php echo do_shortcode('[pinar-social-icons]' ); ?>
		<script type="text/javascript">
			function IsEmail(email) {
				var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				return regex.test(email);
			}
			jQuery(document).ready(function(){
				"use strict"
				jQuery(".search-form").on("submit", function(e){
					e.preventDefault();
					var formContainer   = jQuery(this),
						messageContainer  = formContainer.find(".message-container"),
						userEmail         = formContainer.find("input[type=email]").val();
					messageContainer.removeClass("active").html("");

					if( IsEmail(userEmail) == false ) {
						messageContainer.addClass("active").html("<?php echo esc_html__( "Please add a valid email" ,'pinar') ?>");
						return false;
			        }
					var data = {
						action: "ravis_notifier_emails",
						email: userEmail,
					};
					jQuery.post("<?php echo esc_url( admin_url() ); ?>admin-ajax.php", data, function(data){
						var returnData = JSON.parse(jQuery.trim(data));
							messageContainer.addClass("active").html(returnData.message);
					});
				});
			});
		</script>
	</div>
</body>
<?php 
wp_footer();