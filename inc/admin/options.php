<?php

if ( ! defined( 'APERITTO_APP_NAME' ) ) {
	$theme_name = sanitize_key( '' . wp_get_theme() );
	define( 'APERITTO_APP_NAME', $theme_name );
}

if ( ! defined( 'APERITTO_URI' ) ) {
	define( 'APERITTO_URI', 'https://wordpress.org/themes/aperitto/' );
}

define( 'APERITTO_OPTION', 'aperitto_theme_options_' . APERITTO_APP_NAME );


/* ==========================================================================
* 	customize get_option for theme options
* ========================================================================== */
if ( ! function_exists( 'aperitto_get_theme_option' ) ) :
	function aperitto_get_theme_option( $key, $default = false ) {

		$cache = wp_cache_get( APERITTO_OPTION );
		if ( $cache ) {
			return ( isset( $cache[ $key ] ) ) ? $cache[ $key ] : $default;
		}

		$opt = get_option( APERITTO_OPTION );

		wp_cache_add( APERITTO_OPTION, $opt );

		return ( isset( $opt[ $key ] ) ) ? $opt[ $key ] : $default;
	}
endif;


/* ==========================================================================
* 	customize get_option for theme options
* ========================================================================== */
function aperitto_backward_compatible_theme_option_name() {

	$old_option_name = 'theme_options_' . get_template();
	$old_option      = get_option( $old_option_name );

	if ( false == $old_option ) {
		return;
	}

	delete_option( APERITTO_OPTION );
	update_option( APERITTO_OPTION, $old_option );

	delete_option( $old_option_name );

}

add_action( 'init', 'aperitto_backward_compatible_theme_option_name' );

