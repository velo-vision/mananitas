<?php 
/*
 * Plugin Name: Ravis Recent Post with Thumbnail
 * Plugin URI: http://www.RavisTheme.com
 * Description: Show the recent post with the thumbnail
 * Version: 1.0
 * Author: Joseph_a
 * Author URI: http://themeforest.net/user/RavisTheme
 */

class Ravis_recent_post_thumb extends WP_Widget
{
	
	function __construct()
	{
		parent::__construct(
	 		'ravis_recent_post_thumb', // Base ID
			esc_html__( 'Ravis Recent Post', 'pinar' ), // Name
			array( 'description' => esc_html__( 'Show the recent post with thumbnail.', 'pinar' ), ) // Args
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
		$recent_post_args = array(
			'numberposts' => ($instance['post_num'] != '' ? $instance['post_num'] : 3),
			'orderby'     => 'post_date',
			'order'       => 'DESC',
			'post_type'   => 'post',
			'post_status' => 'publish');

		$recent_posts = wp_get_recent_posts( $recent_post_args );
		if($recent_posts)
		{
			echo '<ul>';
				foreach ($recent_posts as $recent_post) {
					$size = array(85, 44); 
					$post_thumb = ( get_the_post_thumbnail( $recent_post['ID'] ) ? get_the_post_thumbnail( $recent_post['ID'], 'full' , 'class=post-img' ) : '' );
					echo '
                        <li>
                            <a href="'. esc_url(get_permalink($recent_post["ID"])) .'">
                            	'. balancetags($post_thumb) .'
                            </a>
                            <a href="'. esc_url(get_permalink($recent_post["ID"])) .'" class="post-title">'. esc_html($recent_post['post_title']) .'</a>
                            <div class="date">'. esc_html($recent_post['post_date']) .'</div>
                        </li>';
				}
			echo '</ul>';
		}
		echo balancetags($args['after_widget']);

	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title    = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'pinar' );
		$post_num = ! empty( $instance['post_num'] ) ? $instance['post_num'] : 3;
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'pinar'); ?></label> 
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'post_num' )); ?>"><?php esc_html_e( 'Post Count:', 'pinar' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'post_num' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'post_num' )); ?>" type="text" value="<?php echo esc_attr( $post_num ); ?>">
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
		$instance             = array();
		$instance['title']    = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['post_num'] = ( ! empty( $new_instance['post_num'] ) ) ? strip_tags( $new_instance['post_num'] ) : '';

		return $instance;
	}

}
register_widget( 'Ravis_recent_post_thumb' );