<?php
// Check the Season
if (!function_exists('ravis_fn_check_season')) {
	function ravis_fn_check_season()
	{
		global $pinar_opt, $current_season;

		$current_time_stamp = time();
		$high_season_start  = !empty($pinar_opt['pinar-high-season-start']) ? strtotime($pinar_opt['pinar-high-season-start']) : '';
		$high_season_end    = !empty($pinar_opt['pinar-high-season-end']) ? strtotime($pinar_opt['pinar-high-season-end']) : '';

		$low_season_start = !empty($pinar_opt['pinar-low-season-start']) ? strtotime($pinar_opt['pinar-low-season-start']) : '';
		$low_season_end   = !empty($pinar_opt['pinar-low-season-end']) ? strtotime($pinar_opt['pinar-low-season-end']) : '';

		$current_time_stamp >= $high_season_start && $current_time_stamp <= $high_season_end ? $current_season = 1 : '';
		$current_time_stamp >= $low_season_start && $current_time_stamp <= $low_season_end ? $current_season = 2 : '';

	}
}
add_action('init', 'ravis_fn_check_season');