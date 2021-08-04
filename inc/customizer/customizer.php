<?php

/** =============================================================================
 * CUSTOM STYLES
 * ============================================================================= */
function aperitto_customizer_css() {

	$style = '';


	// ---- header -----
	$bgimg = esc_url(get_header_image());

	if ( ! empty( $bgimg ) ) {

		$header_h   = (int)get_custom_header()->height;
		$fit_height = aperitto_get_theme_option( 'fix_header_height' );
		if ( ! empty( $fit_height ) && ! empty( $header_h ) ) {
			$fit_height = "@media screen and (min-width:1024px){.header-top-wrap{min-height:{$header_h}px}}";
		} else {
			$fit_height = '';
		}

		//-----------------

		$himg_position = aperitto_get_theme_option( 'header_image_position' );
		switch ( $himg_position ) {
			case 'before':
				add_action( 'aperitto_header_top_wrap_begin', 'aperitto_the_header_image' );
				break;
			case 'after':
				add_action( 'aperitto_header_top_wrap_end', 'aperitto_the_header_image' );
				break;
			case 'background_no_repeat':
			default:
				$style .= '.sitetitle{position:relative}.logo{position:absolute;top:0;left:0;width:100%;z-index:1;}';
				add_action( 'aperitto_header_top_wrap_end', 'aperitto_the_header_image' );
				break;
			case 'background_repeat':
				$style .= ".header-top-wrap{background:url('$bgimg') top center repeat;}";
				break;
			case 'background_repeat_x':
				$style .= ".header-top-wrap{background:url('$bgimg') top center repeat-x}" . $fit_height;
				break;
			case 'background_repeat_y':
				$style .= ".header-top-wrap{background:url('$bgimg') top center repeat-y}" . $fit_height;
				break;
		}
	}
	//-----------------


	$header_textcolor = esc_html(get_theme_mod( 'header_textcolor', false ));
	if ( ! empty( $header_textcolor ) ) {
		$style .= apply_filters( 'aperitto_customizer_header_textcolor_css', "#logo{color:#$header_textcolor!important}" );
	}


	$main_color = esc_html(aperitto_get_theme_option( 'maincolor' ));
	if ( ! empty( $main_color ) && '#137dad' != $main_color ) {

		$main_color_css = "a:hover,#logo,.bx-controls a:hover .fa{color:$main_color}";
		$main_color_css .= "a:hover{color:$main_color}";
		$main_color_css .= "blockquote,q,input:focus,textarea:focus,select:focus{border-color:$main_color}";
		$main_color_css .= "input[type=submit],input[type=button],button,.submit,.button,.woocommerce #respond input#submit.alt,.woocommerce a.button.alt,.woocommerce button.button.alt, .woocommerce input.button.alt,.woocommerce #respond input#submit.alt:hover,.woocommerce a.button.alt:hover,.woocommerce button.button.alt:hover,.woocommerce input.button.alt:hover,#mobile-menu,.top-menu,.top-menu .sub-menu,.top-menu .children,.more-link,.nav-links a:hover,.nav-links .current,#footer{background-color:$main_color}";
		$main_color_css .= "@media screen and (max-width:1023px){.topnav{background-color:$main_color}}";

		$style .= apply_filters( 'aperitto_customizer_main_color_css', $main_color_css );
	}

	$style = apply_filters( 'aperitto_customizer_css', $style );

	if ( is_customize_preview() && empty( $style ) ) {
		$style = 'body{}';
	}

	echo ( $style )
		? "<!-- BEGIN Customizer CSS -->\n<style type='text/css' id='aperitto-customizer-css'>$style</style>\n<!-- END Customizer CSS -->\n"
		: "";

}

add_action( 'wp_head', 'aperitto_customizer_css' );


/* ======================================================================== *
 * Customizer functions
 * ======================================================================== */

// ------------------------
function aperitto_sanitize_text( $value ) {
	return sanitize_text_field( $value );
}


// ------------------------
function aperitto_sanitize_html( $value ) {
	return esc_html( $value );
}


// ------------------------
function aperitto_sanitize_textarea( $value ) {
	return esc_textarea( $value );
}


// ------------------------
function aperitto_is_single() {
	return is_single();
}

// ------------------------
function aperitto_is_page() {
	return is_page();
}

// ------------------------
function aperitto_is_singular() {
	return is_singular();
}

// ------------------------
function aperitto_is_default_layout() {
	return ! is_singular() && ! is_page() && ! is_home();
}

// ------------------------
function aperitto_show_on_home_posts( $control ) {

	$on_front = $control->manager->get_setting( 'show_on_front' )->value();

	if ( $on_front == 'posts' ) {
		return true;
	} else {
		return false;
	}

}

// ------------------------
function aperitto_custom_home_h1( $control ) {

	$on_front = $control->manager->get_setting( 'show_on_front' )->value();
	$home_h1  = $control->manager->get_setting( 'home_h1_type' )->value();

	if ( $on_front == 'posts' && $home_h1 == 'customtitle' ) {
		return true;
	} else {
		return false;
	}

}

// ------------------------
if ( class_exists( 'WP_Customize_Control' ) ) {
	class Aperitto_Group_Title_Control extends WP_Customize_Control {
		public function render_content() {
			echo ( ! empty( $this->label ) ) ? '<h2 style="margin:20px 0 3px">' . esc_html( $this->label ) . '</h2>' : '';
			echo ( ! empty( $this->description ) ) ? '<p class="description">' . esc_html( $this->description ) . '</p>' : '';
			echo '<hr />';
		}
	}
}


/* ========================================================================
 *            script & styles for CUSTOMIZER
 * ======================================================================== */
if ( ! function_exists( 'aperitto_customizer_live' ) ):
	function aperitto_customizer_live() {

		wp_enqueue_script(
			'aperitto-customizer-js',
			get_template_directory_uri() . '/inc/customizer/assets/customizer-preview.js',
			array( 'jquery', 'customize-preview' ), null, true
		);
		wp_localize_script( 'aperitto-customizer-js', 'optname', [APERITTO_OPTION]);

	}
endif;
add_action( 'customize_preview_init', 'aperitto_customizer_live' );

if ( ! function_exists( 'aperitto_customizer_control_toggle' ) ):
	function aperitto_customizer_control_toggle() {

		wp_enqueue_script(
			'aperitto-customizer-js',
			get_template_directory_uri() . '/inc/customizer/assets/customizer-control-toggle.js',
			array( 'jquery', 'customize-preview' ), null, true
		);

	}
endif;
add_action( 'customize_controls_enqueue_scripts', 'aperitto_customizer_control_toggle' );

