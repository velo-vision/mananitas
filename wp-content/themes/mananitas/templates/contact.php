<?php
/**
 *	contact.php
 * 	Contact template 
 *  Template Name: Contact
 */	
global $pinar_opt;
get_header();
?>
<div class="contact-page-container container">
	<!-- Contact Info -->
	<div class="contact-info-main-box clearfix">
		<div class="contact-info-box col-md-4">
			<div class="inner-content">
				<i class="fa fa-envelope-o"></i><div class="info"><?php echo esc_html( $pinar_opt['opt-hotel-email'] ); ?></div>
			</div>
		</div>
		<div class="contact-info-box col-md-4">
			<div class="inner-content">
				<i class="fa fa-phone"></i><div class="info"><?php echo esc_html( $pinar_opt['opt-hotel-phone'] ); ?></div>
			</div>
		</div>
		<div class="contact-info-box col-md-4">
			<div class="inner-content">
				<i class="fa fa-map-marker "></i><div class="info"><?php echo esc_html( $pinar_opt['opt-hotel-address'] ); ?></div>
			</div>
		</div>
	</div>

	<!-- Contact Form -->
		<div class="contact-form-container">
			<div class="how-contact col-md-4">
				<div class="title"><?php echo ravis_fn_title_effect(esc_html__('How to contact', 'pinar') ); ?></div>
				<div class="desc"><?php echo esc_html($pinar_opt['opt-contact-text']); ?></div>
			</div>
			<div class="contact-form-box col-md-8">
				<?php 
					if(have_posts())
					{
						while (have_posts()) {
							the_post();
							the_content();
						}
					}
				?>
			</div>
		</div>
</div>
<?php
get_footer();