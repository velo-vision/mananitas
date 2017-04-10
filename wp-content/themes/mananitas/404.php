<?php
/**
 *	home-page.php
 * 	Home page template of Pinar
 *  Template Name: Home Page
 */
global $pinar_opt;

get_header();
?>
<div id="not-found-page" class="container">
	<h2><?php esc_html_e( '404', 'pinar' ); ?></h2>
	<h3>
		<?php esc_html_e( 'It looks like that page no longer exists.', 'pinar' ); ?>
		<br>
		<?php 
		echo sprintf( wp_kses( __( 'Would you like to go to <a href="%s">homepage</a> instead?', 'pinar' ), array(  'a' => array( 'href' => array() ) ) ), esc_url( home_url('/') ) )
		 ?>
	</h3>
	
	<!-- Search Box -->
	<div class="search-box">
		<form class="search-form" role="search" action="<?php echo esc_attr(site_url('/')); ?>">
			<input type="search" class="search-field" placeholder="<?php esc_html_e('Search …', 'pinar'); ?>" value="" name="s" title="Search ">
			<div class="submit-container">
				<input type="submit" class="search-submit" value="<?php esc_html_e('Search', 'pinar'); ?>">
			</div>
		</form>
	</div>

</div>
<?php

get_footer();