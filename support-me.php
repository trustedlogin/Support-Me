<?php
/**
 * Plugin Name: Support Me
 * Description: Allows you to generate temporary user accounts intended for support purposes.
 * Plugin Author: Drew Jaynes
 * Plugin URI: https://wordpress.org/plugins/support-me/
 * Author URI: http://werdswords.com
 * Version: 1.0.6
 * License: GPLv2
 * Text Domain: support-me
 */

// Bail if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Displays an admin notice denoting the too-old version of PHP.
 *
 * @since 1.0.0
 */
function ww_support_me_admin_notice() {
	$notice  = '<div class="error notice is-dismissible">';
		$notice .= '<p>' . esc_html__( 'Your version of PHP is below the minimum required by the Support Me plugin. Please contact your web host and request that your PHP version be upgraded to 5.3 or later.', 'support-me' ) . '</p>';
	$notice .= '</div>';

	echo $notice;
}

/*
 * Requires PHP 5.4 minimum. If below 5.4, bail and show an admin notice.
 * 
 * If at or above PHP 5.3, bring in the loader.
 *
 * The loader is handled in such a way that namespaces are never exposed to <= PHP 5.2.
 */
if ( version_compare( PHP_VERSION, '5.3', '<' ) ) {
	add_action( 'admin_notices', 'ww_support_me_admin_notice' );
} else {
	register_activation_hook( __FILE__, array( 'Support_Me\Account\Setup', 'add_support_role' ) );

	if ( ! defined( 'WWSM_PLUGIN_DIR' ) ) {
		/**
		 * Support Me plugin directory.
		 *
		 * @since 1.0.0
		 * @var string
		 */
		define( 'WWSM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
	}

	if ( ! defined( 'WWSM_PLUGIN_URL' ) ) {
		/**
		 * Support Me plugin directory URL.
		 *
		 * @since 1.0.0
		 * @var string
		 */
		define( 'WWSM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	}

	// Load the plugin.
	require_once( WWSM_PLUGIN_DIR . 'includes/wwsm-loader.php' );
}
