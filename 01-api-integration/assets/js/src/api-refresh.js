function apiRefresh() {
	var data = {
		'action': 'fishrules_api_refresh',
		'type': this.value,
		'_ajax_nonce': ajaxData.nonce,
	};
	jQuery.post( ajaxData.ajax_url, data, function( response ) {
		alert( response );
	});
}
document.getElementById( 'comregs' ).addEventListener( 'click', apiRefresh );
document.getElementById( 'recregs' ).addEventListener( 'click', apiRefresh );
document.getElementById( 'species' ).addEventListener( 'click', apiRefresh );