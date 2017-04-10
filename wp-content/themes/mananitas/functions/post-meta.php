<?php
if ( ! function_exists( 'ravis_fn_entry_meta' ) )
{
	function ravis_fn_entry_meta()
	{
		if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) )
		{
			$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) )
			{
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
			}

			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				get_the_date(),
				esc_attr( get_the_modified_date( 'c' ) ),
				get_the_modified_date()
			);

			printf( '<div class="post-date">%1$s</div>',
				balancetags( $time_string )
			);
		}

		if ( 'post' == get_post_type() )
		{
			printf( '<div class="post-author">%1$s <a href="%2$s">%3$s</a></div>',
				esc_html__( 'By', 'pinar' ),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				get_the_author()
			);
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) )
		{
			echo '<div class="post-comment"><i class="fa fa-comment"></i>';
			comments_popup_link( esc_html__( 'Leave a comment', 'pinar' ), esc_html__( '1 Comment', 'pinar' ), esc_html__( '% Comments', 'pinar' ) );
			echo '</div>';
		}
		if ( is_single() )
		{
			echo '<div class="post-cats">';
			the_category(', ');
			echo '</div>';			
		}
	}
}