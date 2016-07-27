<?php
/**
 * Support_Me\Account\Utils class
 *
 * @package Support_Me\Account\Utilities
 * @since 1.0.0
 */
namespace Support_Me\Account;

/**
 * Implements utility functions for Support Me.
 *
 * @since 1.0.0
 */
class Utils {

	/**
	 * Generates a "random" email address.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string "Random" email address.
	 */
	public static function generate_email_address() {
		$name = $host = wp_generate_password( 5, false );

		return "{$name}@{$host}.wwsm";
	}

	/**
	 * Determines if the given user is a support account.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @param \WP_User|int $user User object or ID.
	 * @return bool Whether the give user is a support account. Default false.
	 */
	public static function is_support_account( $user ) {
		if ( is_int( $user ) ) {
			$user = get_user_by( 'id', $user );
		}

		if ( $user && in_array( Setup::$support_role, $user->roles ) ) {
			return true;
		}

		return false;
	}
}
