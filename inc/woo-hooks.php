<?php
/**
 * WooCommerce Hooks
 *
 * @since 1.0.0
 *
 */


/**
 *
 * @return string
 */
if ( ! function_exists( 'aperitto_woo_custom_cart_button_text' ) ) :
	function aperitto_woo_custom_cart_button_text() {

		return __( 'Add to Cart', 'aperitto' );

	}
endif;
add_filter( 'woocommerce_product_single_add_to_cart_text', 'aperitto_woo_custom_cart_button_text' );
add_filter( 'woocommerce_product_add_to_cart_text', 'aperitto_woo_custom_cart_button_text' );


/**
 *
 * @param $cols
 *
 * @return int
 */
if ( ! function_exists( 'aperitto_woo_custom_cols' ) ) :
	function aperitto_woo_custom_cols( $cols ) {

		return 12;

	}
endif;
add_filter( 'loop_shop_per_page', 'aperitto_woo_custom_cols', 20 );
