<?php 
/*
 * Plugin Name: Ravis Newsletter sign up form and 
 * Plugin URI: http://www.RavisTheme.com
 * Description: Show the newsletter sign up form
 * Version: 1.0
 * Author: Joseph_a
 * Author URI: http://themeforest.net/user/RavisTheme
 */

class Ravis_news_letter extends WP_Widget
{
	
	function __construct()
	{
		parent::__construct(
	 		'ravis_news_letter', // Base ID
			esc_html__( 'Ravis Newsletter', 'pinar' ), // Name
			array( 'description' => esc_html__( 'Show newsletter subscription form.', 'pinar' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget
	**/
	public function widget( $args, $instance ) {
				
		echo balancetags($args['before_widget']);
		if ( ! empty( $instance['title'] ) ) {
			echo balancetags($args['before_title']) . apply_filters( 'widget_title', $instance['title'] ). balancetags($args['after_title']);
		}
		echo '
			<div class="newletter-container">
				<p>'.wp_kses_post($instance['user_description']).'</p>
				<form class="news-letter-form">
					<input class="email_address" placeholder="'.esc_attr(__("Email", 'pinar')).'" type="email"/>
					<div class="message-container"></div>
					<input type="submit" class="btn btn-default" value="'.esc_html__("Sign Up Now", 'pinar').'">
				</form>
		';
		echo balancetags($args['after_widget']);

		echo '
			<script type="text/javascript">
				function IsEmail(email) {
					var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
					return regex.test(email);
				}
				jQuery(document).ready(function(){
					"use strict"
					jQuery("#'.esc_js($args['widget_id']).'").find(".btn").on("click", function(e){
						e.preventDefault();
						var widgetContainer   = jQuery("#'.esc_js($args['widget_id']).'"),
							messageContainer  = widgetContainer.find(".message-container"),
							userEmail         = widgetContainer.find("input[type=email]").val();
						messageContainer.removeClass("active").html("");

						if( IsEmail(userEmail) == false ) {
							messageContainer.addClass("active").html("'.esc_js(__( "Please add a valid email" ,'pinar')).'");
							return false;
				        }
						var data = {
							action: "ravis_newsletter_add_email",
							email: userEmail,
						};
						jQuery.post("'.esc_url( admin_url() ).'admin-ajax.php", data, function(data){
							var returnData = JSON.parse(jQuery.trim(data));
								messageContainer.addClass("active").html(returnData.message);
						});
					});
				});
			</script>
		</div>';
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title            = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'pinar' );
		$user_description = ! empty( $instance['user_description'] ) ? $instance['user_description'] : 3;
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'pinar'); ?></label> 
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'user_description' )); ?>"><?php esc_html_e( 'Newsletter description:', 'pinar' ); ?></label>
			<textarea  class="widefat" name="<?php echo esc_attr($this->get_field_name( 'user_description' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'user_description' )); ?>" cols="20" rows="7"><?php echo esc_textarea( $user_description ); ?></textarea>
		</p>
		<p>
			<a href="<?php echo esc_url(PINAR_BASE_URL).'/newsletter_emails.csv' ?>" target="_blank"><?php esc_html_e( 'Download the subscriber\'s email', 'pinar' ); ?></a>
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                     = array();
		$instance['title']            = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['user_description'] = ( ! empty( $new_instance['user_description'] ) ) ? strip_tags( $new_instance['user_description'] ) : '';

		return $instance;
	}
}
register_widget( 'Ravis_news_letter' );


/**
 * Create Ajax Function for adding email to the newsletter table
 */

function ravis_newsletter_add_email()
{
	global $wpdb;
	$user_email = $_POST['email'];
	$result     = array();

	// filter the variable
	if (filter_var($user_email, FILTER_VALIDATE_EMAIL))
	{
		$table_name  = $wpdb->prefix .'ravis_newsletter';
		$check_query = $wpdb->get_results(
							$wpdb->prepare("
								SELECT id FROM $table_name
								WHERE email = %s
								",
								array(
									$user_email
								)
							)
						);

		if($check_query)
		{
			$result['message'] = esc_html__( "You have already subscribed.", 'pinar');			
		}
		else
		{
			$wpdb->insert( 
				$table_name, 
				array( 
					'email' => $user_email,
				),
				array('%s')
			);
			if($wpdb->insert_id)
			{
				$result['message'] = esc_html__( "Thanks for your subscription.", 'pinar');			

				/**
				 * Create the emails csv file
				 */
				$email_list = $wpdb->get_results("SELECT email FROM $table_name");
				foreach ($email_list as $emails_item) {
					$new_email_list[] = $emails_item->email;
				}
				$fp = fopen(PINAR_THEMEROOT.'/newsletter_emails.csv', 'w');
			    fputcsv($fp, $new_email_list);
				fclose($fp);
			}
			else{
				$result['message'] = esc_html__( "Email was not added!", 'pinar');
			}
		}
	}
	else
	{
		$result['message'] = esc_html__( "Please add a valid email format", 'pinar');
	}
	echo json_encode($result);
	die();
}
add_action('wp_ajax_nopriv_ravis_newsletter_add_email', 'ravis_newsletter_add_email');
add_action('wp_ajax_ravis_newsletter_add_email', 'ravis_newsletter_add_email');