<?php
/**
 *	gallery-grid.php
 * 	Grid layout of Gallery
 *  Template Name: Gallery Grid
 */	
global $pinar_opt;
get_header();
$sort_options = $sort_options_li = $img_list_class = '';
$gallery_items_id        = isset($pinar_opt["pinar-main-gallery"] ) ? explode(',', $pinar_opt["pinar-main-gallery"]) : '';
?>
<div class="gallery-container  container gallery-grid">
 	<div class="gallery-container">
		<div class="sort-section">
			<div class="sort-section-container">
				<div class="sort-handle"><?php esc_html__('Filters', 'pinar')  ?></div>
				<ul class="list-inline">
					<?php 
						$sort_options = explode(',', $pinar_opt['pinar-gallery-sort']);
						foreach ($sort_options as $sort_options_list) {
							if($sort_options_list === 'All')
							{
								echo '<li><a href="#" data-filter="*" class="active">'.esc_html__('All', 'pinar').'</a></li>';
							}
							else
							{
								echo '<li><a href="#" data-filter=".'.esc_attr(str_replace(' ','-', trim(strtolower($sort_options_list)))).'">'.esc_html__($sort_options_list, 'pinar').'</a></li>';
							}
						}
					?>
				</ul>
			</div>
		</div>
		<ul class="image-main-box clearfix">
			<?php 
				foreach ($gallery_items_id as $gallery_item_id) 
				{

					$image = get_post( intval( $gallery_item_id ) );
					echo '
						<li class="item col-xs-6 col-md-4 '.(isset($image->post_content) && $image->post_content !=='' ? esc_attr(str_replace(' ', '-', trim(strtolower($image->post_content)))) : '').'">
							<figure>
								<img src="'.esc_url( $image->guid ).'" alt="11"/>
								<a href="'.esc_url( $image->guid ).'" class="more-details" data-title="'.esc_attr($image->post_excerpt).'"></a>
								<figcaption>
									<h4>'.ravis_fn_title_effect(esc_html($image->post_excerpt )).'</h4>
								</figcaption>
							</figure>
						</li>';
				}
			?>
		</ul>
	</div>
</div>

<?php
get_footer();