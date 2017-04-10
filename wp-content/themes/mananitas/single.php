<?php 
// single.php
// Post Details

global $post;
get_header();
?>
<!-- Main Container -->
<div class="main-content container">
	<!-- Page Content -->
	<div class="page-content col-md-9">
		<!-- Post Container -->
		<div class="post-container">
		<?php 
		if(have_posts())
		{
			global $pinar_opt;
			while (have_posts()) {
				the_post();
				$post_id        = get_the_id();
				$post_class_arr = get_post_class();
				$post_classes   = '';
				foreach ($post_class_arr as $post_class) {
					$post_classes .= $post_class.' ';
				}
				$post_format = get_post_format($post_id) !== false ? get_post_format($post_id) : '';

				if ($post_format == 'link' || $post_format == 'quote')
				{
					$link = ravis_fn_get_link_url();
				}
				else
				{
					$link = get_permalink();
				}

				echo '
					<div class="post-box '.esc_attr($post_classes).' '.esc_attr($post_format).'">';
					if(get_the_post_thumbnail( $post_id ) !=='')
					{
	                    echo '<a href="'. esc_url( $link ) .'">
	                    	'. get_the_post_thumbnail( $post_id ).'
	                    </a>';						
					}
					if(get_the_title() !=='')
					{
						echo '<a href="'.esc_url( $link ).'" class="post-title">'.get_the_title().'</a>';
					}

                echo '<div class="post-desc">';
	                    	the_content();
	                    
		                    wp_link_pages( array(
								'before'      => '<div class="post-pagination-box clearfix">',
								'after'       => '</div>',
								'link_before' => '',
								'link_after'  => '',
								'pagelink'    => '<span>%</span>',
								'separator'   => '',
							) );
	                echo '</div>
	                	<div class="post-meta clearfix">';
	                		ravis_fn_entry_meta();
					echo '</div>';

					if(wp_get_post_tags($post_id))
		            {
		            	echo '<div class="post-tags"><ul class="list-inline">';

		                    $tag_list = get_the_tags( $post_id );
		                	foreach ($tag_list as $single_tag) {
		                		echo '<li><a href="'.esc_url( home_url('/') ) .'/tag/'.esc_attr( $single_tag->slug ).'">'. esc_html( $single_tag->name ) .'</a><li>';
		                	}
		            	echo '</ul></div>';
		            }

		            echo '
					<div class="comments-container">
			            <h3>';
			            
			        comments_number( '', ravis_fn_title_effect(esc_html__( '1 Comment', 'pinar' )), ravis_fn_title_effect(esc_html__( '% Comments', 'pinar' )) );
			      	echo '</h3>';
			            comments_template();
			            $comment_form_fields =  array(
											'author'   =>'<div class="field-row"><input type="text" id="author" name="author" placeholder="Name *" required="required"></div>',
											'email'  =>'<div class="field-row"><input type="text" id="email" name="email" placeholder="Email *" required="required"></div>',
			                            );
			            $comment_form_arg = array(
			                'title_reply'          => ravis_fn_title_effect(esc_html__('Leave a Message', 'pinar')),
			                'title_reply_to'       => ravis_fn_title_effect(esc_html__('Leave a Reply to %s', 'pinar')),
			                'cancel_reply_link'    => esc_html__('Cancel', 'pinar'),
			                // 'logged_in_as'         => '', 
			                'comment_field'        => '
			                                        <div class="message-field row">
			                                            <textarea name="comment" id="comment" placeholder="Message *" required="required"></textarea>
			                                        </div>',
			                'must_log_in'          => '<p class="must-log-in">' .  sprintf( balancetags( esc_html__( 'You must be <a href="%s">logged in</a> to share your review.' , 'pinar' ) ), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',                                
			                'fields'               => apply_filters( 'comment_form_default_fields', $comment_form_fields ),
			            );

			            comment_form($comment_form_arg);
					echo '</div>';
				echo '</div>';
			}
		}
		?>	
		</div>
	</div>
	<?php
	get_sidebar();
	?>
</div>
<?php
get_footer();