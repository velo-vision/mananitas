<?php 
// archive-guest_book.php
// Guest Book Archive

global $post, $pinar_opt;
get_header();

echo do_shortcode('[pinar-send-feedback description="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatem dolorum, molestias, reprehenderit rem officiis quis animi, magni a quisquam mollitia fuga eveniet atque delectus vel?"]' );
?>
<div id="testimonials-container-box" class="container">
	<?php 
	if(have_posts())
	{
		while (have_posts()) {
			the_post();
			$guest_name = get_post_meta( $post->ID, 'testimonials_guest_name', true);

			echo '
				<div class="testimonial-box item col-xs-6 col-md-4">
					<div class="inner-box">
						<div class="title">'.esc_html(get_the_title()).'</div>
						<div class="description">'.get_the_content().'</div>
						<cite>'.(isset($guest_name) ? esc_html($guest_name ) : '').'</cite>
					</div>
				</div>
			';
		}
	}
	?>
</div>
<?php
ravis_fn_pagination();
get_footer();
