<?php

/* ==========================================================================
 *  Theme settings
 * ========================================================================== */
if ( ! function_exists( 'aperitto_setup' ) ) :
	function aperitto_setup() {

		if ( ! isset( $content_width ) ) {
			$content_width = 725;
		}

		load_theme_textdomain( 'aperitto', get_template_directory() . '/languages' );

		add_theme_support( 'woocommerce' );
		add_theme_support( 'bbpress' );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

		add_theme_support( "wp-block-styles" );
		add_theme_support( "responsive-embeds" );
		add_theme_support( "align-wide" );


		add_theme_support( 'custom-background', apply_filters( 'aperitto_custom_background_args', array( 'default-color' => 'eeeeee' ) ) );
		add_theme_support( 'custom-header', array(
			'width'       => 1080,
			'height'      => 190,
			'flex-height' => true,
			'flex-width' => true,
		) );

		register_nav_menus( array(
			'top'    => __( 'Main Menu', 'aperitto' ),
			'bottom' => __( 'Footer Menu', 'aperitto' )
		) );


		// logo
		$args = array();
		$lpos = get_theme_mod( 'display_logo_and_title' );
		if ( false === $lpos || 'image' == $lpos ) {
			$args['header-text'] = array( 'blog-name' );
		}
		add_theme_support( 'custom-logo', $args );

	}
endif;
add_action( 'after_setup_theme', 'aperitto_setup' );


/* ==========================================================================
 *  Load scripts and styles
 * ========================================================================== */
if ( ! function_exists( 'aperitto_enqueue_style_and_script' ) ) :
	function aperitto_enqueue_style_and_script() {

		// STYLES
		wp_enqueue_style( 'aperitto-style', get_stylesheet_uri(), array(), true );

		// SCRIPTS
		wp_enqueue_script( 'aperitto-html5shiv', get_template_directory_uri() . '/js/html5shiv.min.js', array(), '3.7.3', true );
		wp_script_add_data( 'aperitto-html5shiv', 'conditional', 'lt IE 9' );

		wp_enqueue_script( 'aperitto-scripts', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), true, true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply', false, true, true );
		}

	}
endif;
add_action( 'wp_enqueue_scripts', 'aperitto_enqueue_style_and_script' );


/* ==========================================================================
 *  admin area
 * ========================================================================== */
if ( ! function_exists( 'aperitto_editor_styles' ) ) :
	function aperitto_editor_styles() {
		add_editor_style( 'editor-style.css' );
	}
endif;
add_action( 'admin_init', 'aperitto_editor_styles' );


/* ==========================================================================
 *  Register widget area
 * ========================================================================== */
if ( ! function_exists( 'aperitto_widgets_init' ) ) :
	function aperitto_widgets_init() {

		register_sidebar( array(
			'name'          => __( 'Sidebar', 'aperitto' ),
			'id'            => 'sidebar',
			'description'   => __( 'Add widgets here to appear in your sidebar.', 'aperitto' ),
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget'  => '</li>',
			'before_title'  => '<p class="wtitle">',
			'after_title'   => '</p>',
		) );

	}
endif;
add_action( 'widgets_init', 'aperitto_widgets_init' );



/* ========================================================================== *
 * default COMMENT callback
 * ========================================================================== */
if ( ! function_exists( 'aperitto_html5_comment' ) ) :
	function aperitto_html5_comment( $comment, $args, $depth ) {

		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
		?>
		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">

			<footer class="comment-meta">
				<div class="comment-author">
					<?php if ( 0 != $args['avatar_size'] ) {
						echo get_avatar( $comment, $args['avatar_size'] );
					} ?>
					<b class="fn"><?php comment_author_link(); ?></b>
				</div>

				<div class="comment-metadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php printf( __( '%1$s at %2$s', 'aperitto' ), get_comment_date(), get_comment_time() ); ?>
						</time>
					</a>
					<?php edit_comment_link( __( 'Edit', 'aperitto' ), '<span class="edit-link">', '</span>' ); ?>
				</div>

				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'aperitto' ); ?></p>
				<?php endif; ?>
			</footer>

			<div class="comment-content">
				<?php comment_text(); ?>
			</div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array(
						'add_below' => 'div-comment',
						'depth'     => $depth,
						'max_depth' => $args['max_depth']
					)
				) ); ?>
			</div>

		</div>

		<?php

	}
endif;


/* ==========================================================================
 *  Include libs
 * ========================================================================== */

// functions to display some page parts
require_once( get_template_directory() . '/inc/html-blocks.php' );

// layout functions and filters
require_once( get_template_directory() . '/inc/layout.php' );

// hooks
require_once( get_template_directory() . '/inc/hooks.php' );
require_once( get_template_directory() . '/inc/woo-hooks.php' );

// theme options with Customizer API
require_once( get_template_directory() . '/inc/admin/options.php' );
require_once( get_template_directory() . '/inc/customizer/customizer-controls.php' );
require_once( get_template_directory() . '/inc/customizer/customizer-settings.php' );
require_once( get_template_directory() . '/inc/customizer/customizer.php' );

if ( is_admin() ) :
	// meta-box for layout control
	require_once( get_template_directory() . '/inc/admin/meta-boxes.php' );

endif;
