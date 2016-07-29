<?php
/**
 * Support_Me\Account\Setup class
 *
 * @package Support_Me\Account\Setup
 * @since 1.0.0
 */
namespace Support_Me\Account;

/**
 * Implements methods for interacting with temporary accounts.
 *
 * @since 1.0.0
 */
class Setup {

	/**
	 * Support Admin role.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string
	 * @static
	 */
	public static $support_role = 'wwsm_support_admin';

	/**
	 * Logic for managing and creating support accounts.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var \Support_Me\Account\Management
	 */
	public $management;

	/**
	 * Logic for outputting the panel for adding support accounts.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var \Support_Me\Account\Panel
	 */
	public $panel;

	/**
	 * Utility functions.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var \Support_Me\Account\Utils
	 */
	public $utils;

	/**
	 * Accounts set up constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		// Capabilities.
		add_filter( 'user_has_cap',               array( $this, 'grant_caps'             )         );
		add_filter( 'map_meta_cap',               array( $this, 'map_meta_cap'           ), 100, 3 );

		// Expires column.
		add_filter( 'manage_users_columns',       array( $this, 'add_expires_column'     )         );
		add_filter( 'manage_users_custom_column', array( $this, 'display_expires_column' ), 10,  3 );

		// Miscellaneous.
		add_filter( 'editable_roles',             array( $this, 'hide_support_role'      ), 100    );

		// Accounts.
		$this->setup_accounts();
	}

	/**
	 * Sets up accounts logic.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function setup_accounts() {
		$this->management = new Management();
		$this->panel      = new Panel();
		$this->utils      = new Utils();
	}

	/**
	 * Grants capabilities to administrations for managing support accounts.
	 *
	 * Note: By design, the capability is explicitly NOT granted to the Support Account role.
	 * This serves as the primary differentiator between, say, support accounts and admins.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $caps Capabilities.
	 * @return array Filtered capabilities if admin.
	 */
	public function grant_caps( $caps ) {
		$roles = wp_get_current_user()->roles;

		// If the current user is a support admin, bail.
		if ( in_array( self::$support_role, $roles ) ) {
			return $caps;
		}

		// Grant 'manage_support_accounts' to admins.
		if ( in_array( 'administrator', $roles ) ) {
			$caps['manage_support_accounts'] = true;
		}

		return $caps;
	}

	/**
	 * Filters meta caps for support account users.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array  $caps    The user's actual capabilities.
	 * @param string $cap     Capability name.
	 * @param int    $user_id The user ID.
	 * @return string (Maybe) filtered cap.
	 */
	public function map_meta_cap( $caps, $cap, $user_id ) {
		$disallowed_caps = array( 'create_users', 'edit_user', 'delete_user', 'promote_users' );

		/**
		 * Filters the list of meta and primitive capabilities to disallow for support accounts.
		 *
		 * The default array contains:
		 *
		 * - create_users
		 * - edit_user
		 * - delete_user
		 * - promote users
		 *
		 * Note the explicit checking of meta caps like 'delete_user' and 'edit_user' over
		 * their primitive 'delete_users' or 'edit_users' counterparts. This is to ensure
		 * plugins that rely on functions like is_super_admin() returning true -- i.e. Debug
		 * Bar -- will still work for support admins.
		 *
		 * @since 1.0.0
		 *
		 * @param array                     $disallowed_caps Capabilities to explicitly disallow for support accounts.
		 * @param \Support_Me\Account\Setup $this            Setup instance.
		 */
		$disallowed_caps = apply_filters( 'wwsm_disallowed_caps', $disallowed_caps, $this );

		// Support accounts shouldn't be able to create, edit, promote, or delete any accounts.
		if ( Utils::is_support_account( $user_id ) && in_array( $cap, $disallowed_caps, true ) ) {
			$caps[] = 'manage_support_accounts';
		}

		return $caps;
	}

	/**
	 * Adds the 'Expires' column to the Users list table.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $columns Users list table columns.
	 * @return array Filtered columns.
	 */
	public function add_expires_column( $columns ) {
		$expires_column = array( 'expiration' => _x( 'Expires', 'column header' 'support-me' ) );

		// Add after the 'Name' column.
		return array_merge( array_slice( $columns, 0, 3 ), $expires_column, array_slice( $columns, 3 ) );
	}

	/**
	 * Handles display of the 'Expires' column.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param WP_User $user Current user object.
	 */
	public function display_expires_column( $output, $column_name, $user_id ) {
		// Bail if this isn't the 'Expires' column.
		if ( 'expiration' !== $column_name ) {
			return $output;
		}

		if ( $user = get_user_by( 'id', $user_id ) ) {
			if ( in_array( self::$support_role, $user->roles ) ) {
				$expiration = get_user_meta( $user->ID, 'wwsm_expiration', true );
				$output     = $expiration ? human_time_diff( time(), $expiration )  : __( 'Never Expires', 'support-me' );
			} else {
				$output = '&mdash;';
			}
		}

		return $output;
	}

	/**
	 * Hide the 'Support Admin' role from the roles drop-down.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $roles All user roles.
	 * @return array Filtered roles.
	 */
	public function hide_support_role( $roles ) {
		if ( 'user-new.php' === $GLOBALS['pagenow'] || ! current_user_can( 'manage_support_accounts' ) ) {
			unset( $roles[ self::$support_role ] );
		}

		return $roles;
	}

	/**
	 * Adds the Support Account user role.
	 *
	 * Fired only once on activation.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function add_support_role() {
		$admin = get_role( 'administrator' );

		add_role(
			self::$support_role,
			_x( 'Support Account', 'user role name', 'support-me' ),
			$admin->capabilities
		);
	}
}
