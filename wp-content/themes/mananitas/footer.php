<?php 
/**
 * Footer.php
 * The footer section of the theme 
 */
global $pinar_opt;

if(!is_page_template( 'templates/gallery-fullscreen.php' ) && !is_page_template( 'templates/home-page-fullscreen.php' ))
{

		if(!empty($pinar_opt['opt-call-action']))
		{
			do_shortcode('[pinar-call-to-action]' );
		}
		?>
		<!-- Top Footer -->
		<div id="top-footer">
			<div id="go-up-box"><i class="fa fa-chevron-up"></i></div>
			<div class="inner-container container">
				<?php 
	            /**
	             * Load the "Top Footer" sidebar
	             */
	            dynamic_sidebar("top-footer" );
	            ?>
			</div>
		</div>
		<!-- End of Top Footer -->

		<!-- Footer -->
		<footer id="footer">
			<?php
	        $menu_arg = array(
	            'theme_location'  => 'footer-menu',
	        	'container'       => 'nav',
	            'menu_class'      => 'footer-menu list-inline'
	        );
	        wp_nav_menu( $menu_arg );
	        ?>  
			<div class="copy-right">
				<?php 
	                /**
	                 * Add the footer text which is set by user                     * 
	                 */
	                if (isset($pinar_opt['opt-footer-text']) && $pinar_opt['opt-footer-text'] !=='' ) 
	                {
	                    esc_html_e( $pinar_opt['opt-footer-text'], 'pinar' );
	                }
	            ?>
			</div>
		</footer>
		<!-- End of Footer -->
	</div>	
	<?php 
}
		wp_footer();
	?>
</body>
</html>