/**
 * JavaScript enqueued on wp-admin/users.php
 *
 * @package WW_Support_Me
 * @since 1.0.0
 */

( function( $ ) {

	var	addUsersButton   = $( '.page-title-action' )
		addAccountForm   = $( '#add-account-panel-form' ),
		addAccountHeader = $( 'h3.add-account-panel-header' ),
		noticeDiv        = $( '.wwsm-notice' ),
		body             = $( document.body );

	if ( addUsersButton !== 'undefined' ) {
		// Clone the Add New button and change up the attributes.
		newButton = addUsersButton
			.clone()
			.text( wwsmi10n.addAccountButtonText )
			.addClass( 'wwsm-toggle-panel' )
			.attr( 'href', '#add-account' );

		addUsersButton.parent( 'h1' ).append( newButton );
	}

	var togglePanel = function( event ) {
		event.preventDefault();

		body.toggleClass( 'show-add-account-panel' );
		addAccountForm.attr( 'aria-expanded', body.hasClass( 'show-add-account-panel' ) );
		noticeDiv.hide();
	}

	var togglePanelAddNew = function( event ) {
		event.preventDefault();

		noticeDiv.hide();
		accountResultPanel.hide();

		addAccountForm.show();
		addAccountHeader.text( wwsmi10n.addAccountButtonText );

		if ( event.data !== 'undefined' ) {
			if ( 'reset' == event.data.context ) {
				togglePanel( event );
			}
		}
	}

	// Handle toggling the panel(s).
	$( '.add-account-panel .add-account-panel-dismiss' ).on( 'click', togglePanel );
	$( '.wwsm-toggle-panel' ).on( 'click', togglePanel );
	$( '#wwsm-close' ).on( 'click', { context: 'reset' }, togglePanelAddNew );
	$( '#add-addl-account' ).on( 'click', { context: 'new' }, togglePanelAddNew );

	// Creating accounts.
	var	generateButton     = $( '#add-account-submit' ),
		accountResultPanel = $( '.add-account-result' );

	var	usernameResult = $( '.username-result' ),
		tokenResult    = $( '.token-result' ),
		expiresResult  = $( '.expires-result' );

	generateButton.on( 'click', function( event ) {
		event.preventDefault();

		wp.ajax.send( 'add_support_account', {
			success: addAccountSuccess,
			failure: addAccountFailure,
			data: {
				nonce:    $( '#wwsm_add_account_nonce' ).val(),
				formdata: addAccountForm.serialize()
			}
		} );
	} );

	var addAccountSuccess = function( data ) {

		triggerResult( 'success' );

		usernameResult.text( data.username );
		tokenResult.text( data.url );
		expiresResult.text( data.expires );
	}

	var addAccountFailure = function( data ) {
		triggerResult( 'failure' );
	}

	var triggerResult = function( type ) {
		addAccountForm.hide();

		if ( 'success' == type ) {
			addAccountHeader.text( wwsmi10n.accountInformation );

			$( '#wwsm-success' ).show();
			accountResultPanel.show();
		} else {
			addAccountHeader.text( wwsmi10n.addAccountError );

			$( '#wwsm-failure' ).show();
		}
	}

} )( jQuery );
