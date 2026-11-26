<?php
/*
 * Plugin Name: Relay Point for WooCommerce
 * Description: Manually create relay points on WooCommerce and display them in an improved selection format.
 * Version: 2.0.2
 * Tags: WooCommerce, Shipping
 * Author: Lionel Bataille
 * Author URI: mailto:lionel.bataille@hotmail.com
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: relay-point-for-woocommerce
 * Domain Path: /languages
 */

if (!defined('ABSPATH') && !defined('WPINC')) {
	exit;
}

class Woo_Relay_Shipping
{
	public function __construct()
	{
		if (!class_exists('WC_Point_relais'))
			include_once plugin_dir_path(__FILE__) . 'modules/class_relay_shipping.php';

		add_filter('woocommerce_locate_template', 'plugin_override_woocommerce_locate_template', 10, 3);

		function plugin_override_woocommerce_locate_template($template, $template_name, $template_path)
		{
			global $woocommerce;
			$_template = $template;
			if (!$template_path)
				$template_path = $woocommerce->template_url;
			$plugin_path = untrailingslashit(plugin_dir_path(__FILE__)) . '/woocommerce/';

			$template = locate_template(
				array(
					$template_path . $template_name,
					$template_name
				)
			);

			if (!$template && file_exists($plugin_path . $template_name))
				$template = $plugin_path . $template_name;

			if (!$template)
				$template = $_template;

			return $template;
		}

		add_action('plugins_loaded', [$this, 'load_plugin_text_domain']);
		add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
	}

	public function enqueue_assets()
	{
		if (!function_exists('is_cart') || !(is_cart() || is_checkout())) {
			return;
		}

		$path = plugin_dir_path(__FILE__) . 'assets/relay-select.js';

		wp_enqueue_script('relay-point-select', plugins_url('assets/relay-select.js', __FILE__), array('jquery'), filemtime($path), true);
	}

	public function load_plugin_text_domain()
	{
		load_plugin_textdomain('relay-point-for-woocommerce', false, dirname(plugin_basename(__FILE__)) . '/languages/');
	}
}

/**
 * Tell whether WooCommerce is active on this site or network-activated on a multisite
 * @return bool
 */
function woo_relay_shipping_is_woocommerce_active()
{
	$plugin = 'woocommerce/woocommerce.php';

	if (in_array($plugin, apply_filters('active_plugins', get_option('active_plugins')), true)) {
		return true;
	}

	return is_multisite() && isset(get_site_option('active_sitewide_plugins', array())[$plugin]);
}

if (woo_relay_shipping_is_woocommerce_active()) {
	new Woo_Relay_Shipping();
}
