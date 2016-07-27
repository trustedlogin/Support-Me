<?php
/**
 * Support_Me\Account\Management class
 *
 * @package Support_Me\Account
 * @since 1.0.0
 */
namespace Support_Me\Account;

use Support_Me\Setup;
use Support_Me\Account\Utils;

/**
 * Implements methods for creating and managing support accounts.
 *
 * @since 1.0.0
 */
class Management {

	/**
	 * Generated user data.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var object
	 */
	private $user;

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'wp_ajax_add_support_account', array( $this, 'add_account' ) );

		add_action( 'wwsm_delete_account', array( $this, 'delete_account' ) );
	}

	/**
	 * Handles adding a support account via Ajax.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function add_account() {
		check_ajax_referer( 'wwsm_add_account', 'nonce' );

		// If no data, bail.
		if ( empty( $_REQUEST['formdata'] ) ) {
			wp_send_json_error(
				new \WP_Error( 'wwsm_no_data', __( 'No data was found.', 'support-me' ) )
			);
		}

		wp_parse_str( $_REQUEST['formdata'], $data );

		$user_id = wp_insert_user( array(
			'user_login'   => strtolower( 'support_' . wp_generate_password( 6, false ) ),
			'user_pass'    => wp_generate_password( 24, true ),
			'user_email'   => Utils::generate_email_address(),
			'display_name' => _x( 'Support Account', 'support account name', 'support-me' ),
			'role'         => Setup::$support_role,
		) );

		// If the user couldn't be created, bail.
		if ( is_wp_error( $user_id ) ) {
			wp_send_json_error( $user_id );
		}

		// Handle account expiration.
		$expiration = $this->calculate_expiration( $data );

		if ( $expiration > 0 ) {
			// Set the expiration time in user meta if the account is expireable.
			update_user_meta( $user_id, 'wwsm_expiration', $expiration );

			// Schedule the user for deletion.
			wp_schedule_single_event( $expiration, 'wwsm_delete_account', array( $user_id ) );

			$format = sprintf( '%1$s %2$s', get_option( 'date_format' ), get_option( 'time_format' ) );

			$expires_string = date( $format, $expiration ) . ' UTC';
		} else {
			$expires_string = __( 'Never', 'support-me' );
		}

		/** @var \WP_User $user */
		$user = get_user_by( 'id', $user_id );

		// Start building the response.
		$key = get_password_reset_key( $user );

		$url = add_query_arg( array(
			'action' => 'rp',
			'key'    => $key,
			'login'  => rawurlencode( $user->user_login )
		), 'wp-login.php' );

		$response = array(
			'username' => $user->user_login,
			'url'      => network_site_url( $url, 'login' ),
			'expires'  => $expires_string
		);

		wp_send_json_success( $response );
	}

	/**
	 * Calculates the expiration timestamp.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $data Ajax $_REQUEST data.
	 * @return int Expiration timestamp or 0 if not set to expire.
	 */
	public function calculate_expiration( $data ) {
		if ( empty( $data['expire-type'] ) ) {
			$data['expire-type'] = 'none';
		}

		$expiration = 0;

		if ( 'time' === $data['expire-type'] ) {
			$amount = empty( $data['expire-amount'] ) ? 4 : absint( $data['expire-amount'] );

			// If the interval is invalid for whatever reason, default to 'hours'.
			if ( empty( $data['expire-interval'] )
			     || ( ! empty( $data['expire-interval'] )
					&& ! in_array( $data['expire-interval'], array( 'minutes', 'hours', 'days' ) )
			     )
			) {
				$interval = 'hours';
			} else {
				$interval = sanitize_key( $data['expire-interval'] );
			}

			switch( $interval ) {
				case 'minutes':
					$expiration = $amount * MINUTE_IN_SECONDS;
					break;
				case 'hours':
					$expiration = $amount * HOUR_IN_SECONDS;
					break;
				case 'days':
					$expiration = $amount * DAY_IN_SECONDS;
					break;
			}
			$expiration = time() + $expiration;
		}

		return $expiration;
	}

	/**
	 * Deletes a support account.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param int $user_id User ID.
	 */
	public function delete_account( $user_id ) {
		if ( ! function_exists( 'wp_delete_user' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/user.php' );
		}
		\wp_delete_user( $user_id );
	}
}
