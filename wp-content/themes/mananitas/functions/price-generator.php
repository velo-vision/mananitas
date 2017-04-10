<?php
if(!function_exists('ravis_fn_price_value'))
{
	function ravis_fn_price_value($def_price, $digit = false, $season = null)
	{

		global $pinar_opt, $current_season;
		$price_unit = !empty($pinar_opt['pinar-booking-currency']) ? ravis_currency_converter($pinar_opt['pinar-booking-currency']) : '&#36;';

		$high_season_percent = ((int) $pinar_opt['pinar-high-season-percent'])/100;
		$low_season_percent = ((int) $pinar_opt['pinar-low-season-percent'])/100;

		if($season == null){
			$season = $current_season;
		}

//		Generate High Season Price
		$season === 1 ? $def_price += $def_price * $high_season_percent : '';
//		Generate Low Season Price
		$season === 2 ? $def_price -= $def_price * $low_season_percent : '';

		if($digit == false){
			return $price_unit.number_format($def_price);
		}
		else{
			return $def_price;
		}
	}
}