<?php

/* set custom body classes
 * ========================================================================== */
if ( ! function_exists( 'aperitto_set_body_class' ) ) :
	function aperitto_set_body_class( $classes ) {

		// page layout
		$classes[] = 'layout-' . aperitto_get_layout();

		return $classes;
	}
endif;
add_filter( 'body_class', 'aperitto_set_body_class' );


/* set page layout
 * ========================================================================== */
if ( ! function_exists( 'aperitto_get_layout' ) ) :
	function aperitto_get_layout() {
		global $post;

		$layout = 'rightbar';

		$layout_def  = aperitto_get_theme_option( 'layout_default' );
		$layout_home = aperitto_get_theme_option( 'layout_home' );
		$layout_post = aperitto_get_theme_option( 'layout_post' );
		$layout_page = aperitto_get_theme_option( 'layout_page' );
		$layout_page = ( ! empty( $layout_page ) ) ? $layout_page : 'center';

		// get custom page layout
		if ( is_singular() ) {

			if ( is_singular('product') ){
				$layout_post = get_theme_mod( 'layout_product', 'rightbar' );
			}

			$custom = get_post_meta( $post->ID, 'aperitto_page_layout', true );
			if ( '' == $custom || 'default' == $custom ) {
				unset( $custom );
			}
		}

		// get settings for 'post' layout
		if ( is_single() && isset( $layout_post ) ) {
			$layout = ( isset( $custom ) )
				? $custom
				: $layout_post;
		}
		// get settings for 'page' layout
		elseif ( is_page() && isset( $layout_page ) ) {
			// other static pages
			$layout = ( isset( $custom ) )
				? $custom
				: $layout_page;
		}
		// get home layout settings
		elseif ( is_home() && $layout_home ) {
			$layout = $layout_home;
		}
		// woocommerce shop
		elseif ( function_exists( 'is_shop' )  ) {

			if ( is_shop() ){
				$layout = get_theme_mod( 'layout_shop', 'full' );
			}

			if ( is_tax('product_cat') ) {
				$layout = get_theme_mod( 'layout_product_cat', 'rightbar' );
			}
		}
		// get default layout settings
		elseif ( $layout_def ) {
			$layout = $layout_def;
			if ( is_search() ) {
				$layout = get_theme_mod( 'layout_search', 'center' );
			}
		}

		return $layout;
	}
endif;


/* set custom posts classes
 * ========================================================================== */
if ( ! function_exists( 'aperitto_set_post_class' ) ) :
	function aperitto_set_post_class( $classes ) {

		if ( ! is_singular() && 'post' == get_post_type() ) {
			$classes[] = 'anons';
		}

		if ( is_search() ) {
			$classes[] = 'serp';
		}

		$hentry_pos = array_search( 'hentry', $classes );
		if ( $hentry_pos !== false ) {
			unset( $classes[ $hentry_pos ] );
		}

		return $classes;
	}
endif;
add_filter( 'post_class', 'aperitto_set_post_class' );


/* set default setting for galleries
 * ========================================================================== */
if ( ! function_exists( 'aperitto_set_gallery_defaults' ) ) :
	function aperitto_set_gallery_defaults( $attr ) {

		$attr['itemtag']    = 'div';
		$attr['icontag']    = 'div';
		$attr['captiontag'] = 'p';

		return $attr;
	}
endif;
add_filter( 'shortcode_atts_gallery', 'aperitto_set_gallery_defaults' );
