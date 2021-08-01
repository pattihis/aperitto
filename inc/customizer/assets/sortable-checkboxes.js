jQuery( document ).ready( function($) {

	var $bsc = $( ".aperitto-sortable-checkboxes" );

	$bsc.sortable();
	$bsc.disableSelection();
	$bsc.on( "sortstop", function( event, ui ) {

		checkbox_values = $( this ).find( 'input[type="checkbox"]:checked' ).map(
			function() {
				return this.value;
			}
		).get().join( '_' );

		$( this ).find( 'input[type="hidden"]' ).val( checkbox_values ).trigger( 'change' );
	} );


	// Checkbox Multiple Control
	$( '.aperitto-sortable-checkboxes input[type="checkbox"]' ).on(
		'change',
		function() {

			checkbox_values = $( this ).parents( '.aperitto-sortable-checkboxes' ).find( 'input[type="checkbox"]:checked' ).map(
				function() {
					return this.value;
				}
			).get().join( '_' );

			$( this ).parents( '.aperitto-sortable-checkboxes' ).find( 'input[type="hidden"]' ).val( checkbox_values ).trigger( 'change' );
		}
	);


} ); // jQuery( document ).ready
