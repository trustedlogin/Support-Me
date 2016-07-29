<?php
/**
 * Support_Me\Account\Panel class
 *
 * @package Support_Me\Account
 * @since 1.0.0
 */
namespace Support_Me\Account;

/**
 * Implements methods for creating and managing support accounts.
 *
 * @since 1.0.0
 */
final class Panel {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'wwsm_new_account',              array( $this, 'new_account_panel'   ) );
		add_filter( 'views_users',                   array( $this, 'new_account_action'  ) );

		add_action( 'admin_print_styles-users.php',  array( $this, 'admin_print_styles'  ) );
		add_action( 'admin_print_scripts-users.php', array( $this, 'admin_print_scripts' ) );
	}

	/**
	 * Outputs the form for adding a new support account.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function new_account_panel() {
		if ( ! current_user_can( 'manage_support_accounts' ) ) {
			return;
		}
		?>
		<div class="add-account-panel">
			<div id="wwsm-success" class="notice notice-success wwsm-notice is-dismissible">
				<?php esc_html_e( 'The new support account was created.', 'support-me' ); ?>
			</div>
			<div id="wwsm-failure" class="notice notice-warning wwsm-notice is-dismissible">
				<?php esc_html_e( 'The new support account could not be created. Please try again.', 'support-me' ); ?>
			</div>
			<a class="add-account-panel-dismiss" href="#add-account-dismiss"><?php echo esc_html_e( 'Close Panel', 'support-me' ); ?></a>
			<h3 class="add-account-panel-header"><?php esc_html_e( 'Add Support Account', 'support-me' ); ?></h3>
			<div class="add-account-result">
				<p><?php _e( 'Copy and paste the account information below into whichever <em>private</em> support channel you&#8217;re providing login credentials for.', 'support-me' ); ?></p>
				<p><?php _e( '<strong>Important Notes:</strong>', 'support-me' ); ?></p>
				<ul>
					<li><?php _e( 'You should <strong>never</strong> post login credentials in a public support forum -- anyone could click it and gain instant access to your website.', 'support-me' ); ?></li>
					<li><?php _e( 'Once the password URL has been used to set an account password, it will never work again.', 'support-me' ); ?></li>
				</ul>

				<blockquote>
					<span class="wwsm-username">
						<?php
						/* translators: 1: Generated username */
						printf( __( '<strong>Username:</strong> %s', 'support-me' ),
							'<span class="username-result"></span>'
						);
						?>
					</span>
					<span class="wwsm-token">
						<?php
						/* translators: 1: Password reset URL */
						printf( __( '<strong>Password URL:</strong> %s', 'support-me' ),
							'<span class="token-result"></span>'
						);
						?>
					</span>
					<p>
						<span class="wwsm-expires">
							<?php
							/* translators: 1: Expiration date (UTC) */
							printf( __( '<strong>Account Expires:</strong> %s', 'support-me' ),
								'<span class="expires-result"></span>'
							);
							?>
						</span>
					</p>
				</blockquote>

				<p>
					<button id="wwsm-close" class="button button-primary"><?php esc_html_e( 'Close Panel', 'support-me' ); ?></button>
					<button id="add-addl-account" class="button button-secondary"><?php esc_html_e( 'Add Another Account', 'support-me' ); ?></button>
				</p>
			</div>
			<form id="add-account-panel-form" aria-expanded="false">
				<table class="form-table">
					<tr class="form-field">
						<th scope="row">
							<?php esc_html_e( 'Expiration', 'support-me' ); ?>
						</th>
						<td>
							<fieldset>
								<legend class="screen-reader-text"><?php esc_html_e( 'Type of account expiration', 'support-me' ); ?></legend>

								<label class="wwsm-choice">
									<?php
									$minutes = __( 'Minutes', 'support-me' );
									$hours   = __( 'Hours', 'support-me' );
									$days    = __( 'Days', 'support-em' );
									?>
									<input type="radio" name="expire-type" value="time" checked="checked" />
									<?php
									/* translators: 1: Number of time interval input, 2: Time interval input (minutes, hours, days) */
									printf( __( 'Expires in: %s %s', 'support-me' ),
										'<input name="expire-amount" type="number" min="1" id="expire-amount" value="4" />',
										'<select id="expire-interval" name="expire-interval" class="expire-interval">'
											. '<option value="minutes">' . esc_html( $minutes ) . '</option>'
											. '<option value="hours" selected="selected">' . esc_html( $hours ) . '</option>'
											. '<option value="days">' . esc_html( $days ) . '</option>'
										. '</select>'
									);
									?>
									<p>
										<em><?php esc_html_e( 'Expired support accounts will be automatically deleted.', 'support-me' ); ?></em>
									</p>
								</label>
								<label class="wwsm-choice">
									<input type="radio" name="expire-type" value="none" />
									<?php esc_html_e( 'This account should never expire.', 'support-me' ); ?>
								</label>
							</fieldset>
						</td>
					</tr>
				</table>
				<?php wp_nonce_field( 'wwsm_add_account', 'wwsm_add_account_nonce' ); ?>
				<input type="submit" id="add-account-submit" class="button button-primary" value="<?php esc_attr_e( 'Add Support Account', 'support-me' ); ?>" />
			</form>
		</div>
		<?php
	}

	/**
	 * Fires the {@see 'wwsm_new_account'} action in a semi-hacky way to the top
	 * of the Users list table.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $views Users table views.
	 * @return array Users table views.
	 */
	public function new_account_action( $views ) {
		/**
		 * Fires above the 'Views' section in the Users list table.
		 *
		 * @since 1.0.0
		 *
		 * @param \Support_Me\Account\Panel $this Panel instance.
		 */
		do_action( 'wwsm_new_account', $this );

		return $views;
	}

	/**
	 * Enqueues stylesheets on wp-admin/users.php.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_print_styles() {
		wp_enqueue_style( 'wwsm-users-css', WWSM_PLUGIN_URL . 'assets/css/wwsm-users.css' );
	}

	/**
	 * Enqueues scripts on wp-admin/users.php.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_print_scripts() {
		wp_enqueue_script( 'wwsm-users-js', WWSM_PLUGIN_URL . 'assets/js/wwsm-users.js', array( 'wp-util' ), false, true );

		wp_localize_script( 'wwsm-users-js', 'wwsmi10n', array(
			'addAccountButtonText' => __( 'Add Support Account', 'support-me' ),
			'accountInformation'   => __( 'Support Account Information', 'support-me' ),
			'addAccountError'      => __( 'An Error Occurred', 'support-me' ),
		) );
	}

}
