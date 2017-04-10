<?php
if(!function_exists('ravis_currency_converter'))
{
	function ravis_currency_converter($in_currency)
	{
		$currency_array = array(
			'\u60b;'  => '&#1547;', 
			'\u0024;' => '&#36;',
			'\u9f3;'  => '&#2547;',
			'\u17db;' => '&#6107;',
			'\u00a5;' => '&#165;',
			'\u20a1;' => '&#8353;',
			'\u20b1;' => '&#8369;',
			'\u00a3;' => '&#163;',
			'\u20a1;' => '&#8353;',
			'\u20ac;' => '&#8364;',
			'\u20b5;' => '&#8373;',
			'\u20b9;' => '&#8377;',
			'\u20bd;' => '&#8381;',
			'\ufdfc;' => '&#65020;',
			'\u20aa;' => '&#8362;',
			'\u00a5;' => '&#165;',
			'\u20b8;' => '&#8376;',
			'\u20a9;' => '&#8361;',
			'\u20ad;' => '&#8365;',
			'\u20ae;' => '&#8366;',
			'\u20a6;' => '&#8358;',
			'\u20b2;' => '&#8370;',
			'\u20b1;' => '&#8369;',
			'\u0e3f;' => '&#3647;',
			'\u20b4;' => '&#8372;',
			'\u20ab;' => '&#8363;',
			'\ufdfc;' => '&#65020;',
			'\u058F;' => '&#1423;',
			'\u5270;' => '&#82;&#112;',
			'MAD'     => 'MAD',
			'AED'     => 'AED'
		);

		foreach ($currency_array as $hex_currency => $deci_currency) {
			if($in_currency === $hex_currency)
			{
				return $deci_currency;				
			}
		}
	}
}