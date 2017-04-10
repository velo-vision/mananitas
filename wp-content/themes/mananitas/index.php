<?php 
// Index.php
// Pinar Index Page

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
	                    	if(isset($pinar_opt['pinar-blog-type']) && $pinar_opt['pinar-blog-type'] == '2')
		                    {
		                    	echo ($post_format == 'quote' ? '<blockquote>' : '');
		                    	the_content( esc_html__('Continue Reading ...', 'pinar'));
		                    	echo ($post_format == 'quote' ? '</blockquote>' : '');
		                    }
		                    elseif($post_format == 'image' || $post_format == 'gallery')
		                    {
		                    	the_content();
		                    }
		                    else
		                    {
		                    	echo ($post_format == 'quote' ? '<blockquote>' : '');
		                    	the_excerpt();                    	
		                    	echo ($post_format == 'quote' ? '</blockquote>' : '');
		                    }
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
					echo '</div>
					</div>';
			}
		}
		else{
			if(is_search())
			{
				echo '<div id="search-no-result">';
					echo '<h3><b>'.esc_html__('Sorry, but nothing matched your search terms.', 'pinar').'</b></h3>';
					echo '<h5>'. esc_html__( 'Please try again with some different keywords.', 'pinar' ).'</h5>';
					get_search_form();			
				echo '</div>';
			}
		}
		ravis_fn_pagination();
		?>	
		</div>
	</div>
	<?php
	get_sidebar();
	?>
</div>

<?php
get_footer();