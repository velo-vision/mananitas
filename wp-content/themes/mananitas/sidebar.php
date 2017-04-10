<?php
if ( ! is_active_sidebar( 'main-side-bar' ) )
{
	return;
}
?>
<!-- Sidebar Section -->
<aside class="sidebar right-sidebar col-md-3">
	<?php dynamic_sidebar( 'main-side-bar' ); ?>                
</aside>
<!-- Sidebar Section -->