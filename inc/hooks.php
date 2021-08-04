<?php

/**
 * show 20 posts in search page
 *
 * @param $query WP_Query
 * ========================================================================== */
function aperitto_pre_get_posts( $query ) {

	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( is_search() ) {
		$query->set( 'posts_per_page', 20 );
	}
}

add_action( 'pre_get_posts', 'aperitto_pre_get_posts' );


/**
 * @param $args
 *
 * @return mixed
 * ========================================================================== */
function aperitto_comment_form_defaults( $args ) {

	$commenter = wp_get_current_commenter();
	$consent   = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';

	$fields                = apply_filters( 'aperitto_comment_form_defaults', array(
		'author'  => '<div class="rinput rauthor"><input type="text" placeholder="' . esc_attr__( 'Your Name', 'aperitto' ) . '" name="author" id="author" class="required" value="'
		             . esc_attr( $commenter['comment_author'] ) . '" /></div>',
		'email'   => '<div class="rinput remail"><input type="text" placeholder="' . esc_attr__( 'Your E-mail', 'aperitto' ) . '" name="email" id="email" class="required" value="'
		             . esc_attr( $commenter['comment_author_email'] ) . '" /></div>',
		'url'     => '<div class="rinput rurl"><input type="text" placeholder="' . esc_attr__( 'Your Website', 'aperitto' ) . '" name="url" id="url" class="last-child" value="'
		             . esc_attr( $commenter['comment_author_url'] ) . '"  /></div>',
		'cookies' => '<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" '
		             . $consent . ' />' .
		             '<label for="wp-comment-cookies-consent">' . esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'aperitto' ) . '</label></p>',
	) );
	$args['fields']        = apply_filters( 'comment_form_default_fields', $fields );
	$args['comment_field'] = '<div class="rcomment"><textarea id="comment" name="comment" cols="45" rows="8" placeholder="' . esc_attr__('Message', 'aperitto' ) . '" aria-required="true"></textarea></div>';

	return $args;
}

add_filter( 'comment_form_defaults', 'aperitto_comment_form_defaults', 10 );


/**
 * customize excerpt text
 *
 * @param $more
 *
 * @return string
 * ========================================================================== */
function aperitto_change_the_excerpt( $more ) {
	return ' ...';
}

add_action( 'excerpt_more', 'aperitto_change_the_excerpt' );



/* ==========================================================================
 * echo custom script in footer from options
 * ========================================================================== */
function aperitto_singular_thumbnail_attr( $args ) {

	$show_mobile_thumb = get_theme_mod( 'show_mobile_thumb' );

	if ( ! empty( $show_mobile_thumb ) ) {
		$old           = ( array_key_exists( 'class', $args ) ) ? $args['class'] : '';
		$args['class'] = "$old show";
	}

	return $args;

}

apply_filters( 'aperitto_singular_thumbnail_attr', 'aperitto_singular_thumbnail_attr' );



/* ========================================================================== *
 * Wrap content with entry class
 * ========================================================================== */
if ( ! function_exists( 'aperitto_the_content_entry' ) ) :
	function aperitto_the_content_entry( $content ) {

		return '<div class="entry">' . "\n\n" . $content . "\n\n" . '</div>';

	}
endif;
add_action( 'the_content', 'aperitto_the_content_entry', 1 );




/* ==========================================================================
 * Highlight search results
 * ========================================================================== */
if ( ! function_exists( 'aperitto_search_highlight' ) ) :
	function aperitto_search_highlight( $text ) {

		$s = get_query_var( 's' );

		if ( is_search() && '' != $s && in_the_loop() ) :

			$style       = 'color:red;font-weight:bold;';
			$query_terms = get_query_var( 'search_terms' );

			if ( empty( $query_terms ) ) {
				$query_terms = explode( ' ', $s );
			}
			if ( empty( $query_terms ) ) {
				return '';
			}

			foreach ( $query_terms as $term ) {
				$term  = preg_quote( $term, '/' ); // like in search string
				$term1 = mb_strtolower( $term ); // lowercase
				$term2 = mb_strtoupper( $term ); // uppercase
				$term3 = mb_convert_case( $term, MB_CASE_TITLE, "UTF-8" );    // capitalise
				$term4 = mb_strtolower( mb_substr( $term, 0, 1 ) ) . mb_substr( $term2, 1 );    // first lowercase
				$text  = preg_replace( "@(?<!<|</)($term|$term1|$term2|$term3|$term4)@i", "<span style=\"{$style}\">$1</span>", $text );
			}

		endif; // is_search;

		return $text;

	}
endif;
add_filter( 'the_content', 'aperitto_search_highlight' );
add_filter( 'the_excerpt', 'aperitto_search_highlight' );
add_filter( 'the_title', 'aperitto_search_highlight' );


/**
 * @param $item_output
 * @param $item
 * @param $depth
 * @param $args
 *
 * @return mixed
 */
function aperitto_nav_menu_item_add_submenu_arrow( $item_output, $item, $depth, $args ) {

	if ( 'top' == $args->theme_location && in_array( 'menu-item-has-children', $item->classes ) ) {
		$item_output .= '<span class="open-submenu"></span>';
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'aperitto_nav_menu_item_add_submenu_arrow', 10, 4 );


function aperitto_the_header_image(){

	$header_image = get_header_image_tag();

	if ( $header_image  ){ ?>
		<div class="header-image">
			<?php echo $header_image; ?>
		</div>
	<?php }

}
