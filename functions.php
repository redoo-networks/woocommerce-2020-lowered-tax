<?php
/*
Plugin Name: Redoo Networks Temporarily Lower Tax
Plugin URI: https://github.com/redoo-networks/woocommerce-2020-lowered-tax
Description: Lower the german tax from 19 and 7 to 16 and 5 from 1st July 2020 until 1st January 2021, because of Corona rescue program.
Version: 1.0.0
Author: Redoo Networks GmbH
Author URI: https://redoo-networks.com/
GitHub Plugin URI: https://github.com/redoo-networks/woocommerce-2020-lowered-tax
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

add_filter('woocommerce_find_rates', 'redoo_lower_tax_rates', 10, 2);

function redoo_lower_tax_rates($matched_tax_rates, $args) {
	
	if(date('Y-m-d') < "2021-01-01") {
		foreach($matched_tax_rates as $index => $rate) {
			if($matched_tax_rates[$index]['rate'] == 19) {
				$matched_tax_rates[$index]['rate'] = 16;
			} elseif($matched_tax_rates[$index]['rate'] == 7) {
				$matched_tax_rates[$index]['rate'] = 5;
			}
		}
	}
	
	return $matched_tax_rates;
}

add_filter('init', 'redoo_lower_tax_init', 1);

function redoo_lower_tax_init() {
	$taxRates = WC_Tax::get_rates();
	$sumTaxRate = 0;
	foreach($taxRates as $taxRate) {
		$sumTaxRate += $taxRate['rate'];
	}
	define('CURRENT_TAX_RATE', $sumTaxRate);	
}