<?php
if(!function_exists('ravis_fn_pagination'))
{
	function ravis_fn_pagination($input_query_variable='')
	{  
		if(!empty($input_query_variable))
		{
			$wp_query = $input_query_variable;
		}
		else
		{
	 		global  $wp_query;
		}

		$wp_query->query_vars['paged'] > 1 ? $current = esc_html( $wp_query->query_vars['paged'] ) : $current = 1;			

		if ( get_option('permalink_structure') !='' )
		{
			$pagination = array(
				'base'               => get_pagenum_link(1) . '%_%',
				'format'             => 'page/%#%',
				'total'              => $wp_query->max_num_pages,
				'current'            => $current,
				'prev_text'          => '&laquo;',
				'next_text'          => '&raquo;',
				'show_all'           => true,
				'type'               => 'list',
				'before_page_number' => '<span>',
				'after_page_number'  => '</span>'
			);
		}
		else
		{
			$pagination = array(
				'base'               => get_pagenum_link(1) . '%_%',
				'format'             => '?paged=%#%',
				'total'              => $wp_query->max_num_pages,
				'current'            => $current,
				'prev_text'          => '&laquo;',
				'next_text'          => '&raquo;',
				'show_all'           => true,
				'type'               => 'list',
				'before_page_number' => '<span>',
				'after_page_number'  => '</span>'
			);
		}

		$pagination_links = paginate_links( $pagination );
		
		if($pagination_links != NULL)
		{
			echo '<div class="pagination-box clearfix">';
	    	echo balancetags($pagination_links);
			echo '</div>';			
		}
	}
}