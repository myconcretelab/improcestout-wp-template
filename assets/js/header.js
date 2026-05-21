( function () {
	var header = document.querySelector( '.impro-site-header' );

	if ( ! header ) {
		return;
	}

	function updateHeaderState() {
		header.classList.toggle( 'is-condensed', window.scrollY > 32 );
	}

	updateHeaderState();
	window.addEventListener( 'scroll', updateHeaderState, { passive: true } );
}() );
