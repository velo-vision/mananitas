<?php
if(!function_exists('ravis_fn_excerpt_more'))
{
	function ravis_fn_excerpt_more($more) {
	    global $post, $pinar_opt;
	    
	    return '...<br><br><a class="more-link" href="' . esc_url( get_permalink($post->ID) ) . '">' . esc_html__($pinar_opt['opt-read-more-text'], 'pinar') . '</a>';
	}
}
add_filter('excerpt_more', 'ravis_fn_excerpt_more');


if(!function_exists('ravis_fn_excerpt_length'))
{
	function ravis_fn_excerpt_length($len) {
	    global $pinar_opt;
	    return $pinar_opt['opt-excerpt-length'];
	}
}
add_filter('excerpt_length', 'ravis_fn_excerpt_length', 999);


/**
 * ------------------------------------------------------------------------------------------
 * Function that return the excerpt
 * with the given character length
 * ------------------------------------------------------------------------------------------
 */
if(!function_exists('the_excerpt_max_charlength'))
{
	function the_excerpt_max_charlength($charlength, $post_id) {
		global $post, $pinar_opt;

		(empty($post_id)) ?  $post_id= $post->ID : $post_id ;
		
		$excerpt = get_the_excerpt();
		$charlength++;

		if ( mb_strlen( $excerpt ) > $charlength ) {
			$subex   = mb_substr( $excerpt, 0, $charlength - 5 );
			$exwords = explode( ' ', $subex );
			$excut   = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
			if ( $excut < 0 ) {
				$excerpt_text = mb_substr( $subex, 0, $excut );
			} else {
				$excerpt_text = $subex;
			}
			$excerpt_text .= '...<br><a class="more-link" href="' . esc_url( get_permalink($post_id) ) . '">' . esc_html($pinar_opt['opt-read-more-text']) . '</a>';
		} else {
			$excerpt_text = $excerpt;
		}
		return $excerpt_text;
	}
}