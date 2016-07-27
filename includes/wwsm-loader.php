<?php
/**
 * Support Me loader
 *
 * @package Support_Me
 * @since 1.0.0
 */

namespace Support_Me {

	/**
	 * Support Me set up.
	 *
	 * @since 1.0.0
	 */
	final class Instance {

		/**
		 * Instance.
		 *
		 * @since 1.0.0
		 * @access private
		 * @static
		 * @var Instance
		 */
		private static $instance;

		/**
		 * Version.
		 *
		 * @since 1.0.0
		 * @access private
		 * @var string
		 */
		private $version = '1.0.2';

		/**
		 * Creates the single great instance of Support_Me.
		 *
		 * @since 1.0.0
		 * @access public
		 * @static
		 *
		 * @return \Support_Me\Instance Instance.
		 */
		public static function build() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Instance ) ) {
				self::$instance = new Instance();

				self::$instance->load_files();

				new Account\Setup();

				// 4.6 handles loading the plugin text domain just-in-time.
				if ( version_compare( $GLOBALS['wp_version'], '4.6', '<' ) ) {
					add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
				}
			}

			return self::$instance;
		}

		/**
		 * Loads plugin files.
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function load_files() {
			// Setup.
			require_once( 'accounts/wwsm-account-setup.php' );

			// Accounts.
			require_once( 'accounts/wwsm-account-management.php' );
			require_once( 'accounts/wwsm-account-panel.php' );
			require_once( 'accounts/wwsm-account-utils.php' );
		}

		/**
		 * Loads the text domain.
		 *
		 * Only fires pre-4.6.
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'support-me' );
		}

	}
}

namespace {
	/**
	 * Enables access to the Support_Me instance and sub-objects.
	 *
	 * @since 1.0.0
	 *
	 * @return \Support_Me\Instance Support Me instance.
	 */
	function ww_support_me() {
		return Support_Me\Instance::build();
	}
	ww_support_me();
}
