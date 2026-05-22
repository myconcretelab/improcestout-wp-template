( function () {
	var header = document.querySelector( '.impro-site-header' );
	var headerWrap = header ? header.parentElement : null;
	var root = document.documentElement;
	var isCondensed = false;

	if ( ! header ) {
		return;
	}

	if ( headerWrap && headerWrap.classList.contains( 'wp-block-template-part' ) ) {
		headerWrap.classList.add( 'impro-site-header-wrap' );
	}

	function getAdminBarHeight() {
		var adminBar = document.getElementById( 'wpadminbar' );

		if ( ! adminBar ) {
			return 0;
		}

		return adminBar.getBoundingClientRect().height || adminBar.offsetHeight || 0;
	}

	function updateHeaderMetrics() {
		root.style.setProperty( '--impro-admin-bar-height', getAdminBarHeight() + 'px' );
	}

	function updateHeaderState() {
		var threshold = 32 + getAdminBarHeight();
		var condenseAt = threshold + 64;
		var expandAt = 0;
		var shouldCondense = isCondensed ? window.scrollY > expandAt : window.scrollY > condenseAt;

		if ( shouldCondense === isCondensed ) {
			return;
		}

		isCondensed = shouldCondense;
		header.classList.toggle( 'is-condensed', isCondensed );
	}

	function updateHeader() {
		updateHeaderMetrics();
		updateHeaderState();
	}

	updateHeader();
	window.addEventListener( 'scroll', updateHeaderState, { passive: true } );
	window.addEventListener( 'resize', updateHeader, { passive: true } );
}() );
