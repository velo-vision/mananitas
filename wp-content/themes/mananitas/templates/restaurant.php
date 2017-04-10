<?php
/**
 *	restaurant.php
 * 	Restaurant template
 *  Template Name: Restaurant
 */
global $pinar_opt;
$price_unit = !empty($pinar_opt['pinar-booking-currency']) ? ravis_currency_converter($pinar_opt['pinar-booking-currency']) : '&#36;';

get_header();
?>
<div id="welcome" class="container">
	<?php 
	if(!empty($pinar_opt['restaurant-welcome-title']))
	{
		echo '
			<div class="heading-box">
				<h2>'.esc_html__($pinar_opt['restaurant-welcome-title'], 'pinar').'</h2>';
				if(!empty($pinar_opt['restaurant-welcome-subtitle']))
				{
					echo '<div class="subtitle">'.esc_html__($pinar_opt['restaurant-welcome-subtitle'], 'pinar').'</div>';
				}				
		echo '</div>';
	}
	?>

	<div class="inner-content">
		<?php 
		if(!empty($pinar_opt['restaurant-welcome-banner']['url']))
		{
			echo '
			<div class="img-frame " data-parallax="scroll" data-image-src="'.esc_attr($pinar_opt['restaurant-welcome-banner']['url']).'">
			</div>';			
		}
		if(!empty($pinar_opt['restaurant-welcome-text']))
		{
			echo '
				<div class="desc">
					'.esc_html__($pinar_opt['restaurant-welcome-text'], 'pinar');
			if(!empty($pinar_opt['restaurant-welcome-cite']))
			{
				echo '<cite>'.esc_html__($pinar_opt['restaurant-welcome-cite'], 'pinar').'</cite>';
			}
			echo '</div>';
		}
		?>
	</div>
</div>

<div id="special-dishes" class="container">
	
	<?php 
	if(!empty($pinar_opt['restaurant-dishes-title']))
	{
		echo '
			<div class="heading-box">
				<h2>'.ravis_fn_title_effect(esc_html__($pinar_opt['restaurant-dishes-title'], 'pinar')).'</h2>
			</div>
		';
	}
	?>
	<div class="room-container">

		<?php 
		$dishes_i   = 1;
		foreach ($pinar_opt['restaurant-dishes-slides'] as $resaurant_dishes) {
			if($resaurant_dishes['title'] =='') continue;
			
			echo '
				<div class="room-boxes wow fade '.($dishes_i % 2 == 0 ? esc_attr('fadeInLeft right') :  'fadeInRight' ).'">
					<div class="img-container col-xs-6 col-md-7">
						<img src="'.esc_attr($resaurant_dishes['image']).'" alt="'.esc_attr($resaurant_dishes['title']).'" class="room-img">
					</div>
					<div class="room-details col-xs-6 col-md-5">
						<div class="title">'.esc_html__($resaurant_dishes['title'], 'pinar').'</div>
						<div class="description">'.esc_html__($resaurant_dishes['description'], 'pinar').'</div>';
					if(!empty($resaurant_dishes['url']))
					{
						echo '<div class="btn btn-default">'.esc_html($price_unit.$resaurant_dishes['url']).'</div>';	
					}
				echo '</div>
				</div>
			';
			$dishes_i ++;
		}
		 ?>

	</div>
</div>

<?php 
// Promo Section
$promo_bg       = (!empty($pinar_opt['restaurant-promo-background']['url']) ? $pinar_opt['restaurant-promo-background']['url'] : '');
$promo_title    = (!empty($pinar_opt['restaurant-promo-title']) ? $pinar_opt['restaurant-promo-title'] : '');
$promo_subtitle = (!empty($pinar_opt['restaurant-promo-subtitle']) ? $pinar_opt['restaurant-promo-subtitle'] : '');

if($promo_bg!='' && $promo_title!='')
{
	echo '
		<div id="great-taste" data-parallax="scroll" data-image-src="'.esc_attr($promo_bg).'">
			<h2>'.ravis_fn_title_effect(esc_html__($promo_title, 'pinar')).'</h2>
			<h3>'.esc_html__($promo_subtitle, 'pinar').'</h3>
		</div>';
}
?>

<div id="restaurant-menu" class="container">

	<?php 
	if(!empty($pinar_opt['restaurant-menu-title']))
	{
		echo '
			<div class="heading-box">
				<h2>'.ravis_fn_title_effect(esc_html__($pinar_opt['restaurant-menu-title'], 'pinar')).'</h2>';
			if(!empty($pinar_opt['restaurant-menu-subtitle']))
			{
				echo '<div class="subtitle">'.esc_html__($pinar_opt['restaurant-menu-subtitle'], 'pinar').'</div>';		
			}
		echo '</div>';
	}
	?>
	
	<div class="package-container clearfix">
		
		<div class="package-box wow fadeInUp col-md-4">
			<div class="package-inner">
				<div class="title"><?php esc_html_e('Breakfast', 'pinar') ?></div>
				<?php 
				if(!empty($pinar_opt['restaurant-menu-breakfast-chef']))
				{
					echo '<div class="selection"><span>'.esc_html__($pinar_opt['restaurant-menu-breakfast-chef'], 'pinar').'</span>'.esc_html__( 'Chef Selection', 'pinar' ).'</div>';	
				}
				?>
				<div class="package-details">
					<ul>
						<?php
						foreach ($pinar_opt['restaurant-menu-breakfast'] as $menu_list) {
							$menu_list_parts = explode('---', $menu_list);
							if(!empty($menu_list_parts[0]))
							{
								echo '<li>'.esc_html__($menu_list_parts[0], 'pinar').(!empty($menu_list_parts[1]) ? ' <span>'.esc_html__($price_unit.$menu_list_parts[1], 'pinar').'</span>' : '').'</li>';
							}
						}
						?>
					</ul>
				</div>
			</div>
		</div>
		
		<div class="package-box wow fadeInUp col-md-4" data-wow-delay="0.5s">
			<div class="package-inner">
				<div class="title"><?php esc_html_e('Lunch', 'pinar') ?></div>
				<?php 
				if(!empty($pinar_opt['restaurant-menu-lunch-chef']))
				{
					echo '<div class="selection"><span>'.esc_html__($pinar_opt['restaurant-menu-lunch-chef'], 'pinar').'</span>'.esc_html__( 'Chef Selection', 'pinar' ).'</div>';	
				}
				?>
 				<div class="package-details">
					<ul>
						<?php
						foreach ($pinar_opt['restaurant-menu-lunch'] as $menu_list) {
							$menu_list_parts = explode('---', $menu_list);
							if(!empty($menu_list_parts[0]))
							{
								echo '<li>'.esc_html__($menu_list_parts[0], 'pinar').(!empty($menu_list_parts[1]) ? ' <span>'.esc_html__($price_unit.$menu_list_parts[1], 'pinar').'</span>' : '').'</li>';
							}
						}
						?>			
					</ul>
				</div>
			</div>
		</div>

		
		<div class="package-box wow fadeInUp col-md-4" data-wow-delay="1s">
			<div class="package-inner">
				<div class="title"><?php esc_html_e('Dinner', 'pinar') ?></div>
				<?php 
				if(!empty($pinar_opt['restaurant-menu-dinner-chef']))
				{
					echo '<div class="selection"><span>'.esc_html__($pinar_opt['restaurant-menu-dinner-chef'], 'pinar').'</span>'.esc_html__( 'Chef Selection', 'pinar' ).'</div>';	
				}
 				?>
				<div class="package-details">
					<ul>
						<?php
						foreach ($pinar_opt['restaurant-menu-dinner'] as $menu_list) {
							$menu_list_parts = explode('---', $menu_list);
							if(!empty($menu_list_parts[0]))
							{
								echo '<li>'.esc_html__($menu_list_parts[0], 'pinar').(!empty($menu_list_parts[1]) ? ' <span>'.esc_html__($price_unit.$menu_list_parts[1], 'pinar').'</span>' : '').'</li>';
							}
						}
						?>
					</ul>
				</div>
			</div>
		</div>

	</div>
</div>
<?php
get_footer();