<?php

/* ==========================================================================
 *  customizer settings init
 * ========================================================================== */
/**
 * @param $wp_customize WP_Customize_Manager
 */
function aperitto_customizer_init( $wp_customize ) {

	$transport = 'postMessage';


	/* --------------  S I T E   T I T L E   ---------------- */

	// rename title setting
	$wp_customize->get_section( 'title_tagline' )->title = __( 'Header Logo/Title', 'aperitto' );
	$wp_customize->remove_control( 'display_header_text' );


	// ----

	$wp_customize->add_setting( 'display_logo_and_title',
		array(
			'default'           => 'image',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'display_logo_and_title_control',
		array(
			'settings' => 'display_logo_and_title',
			'label'    => __( "Logo image display options", 'aperitto' ),
			'section'  => 'title_tagline',
			'type'     => 'select',
			'choices'  => array(
				'image'  => __( 'Only image, without text', 'aperitto' ),
				'top'    => __( 'Picture above the text', 'aperitto' ),
				'left'   => __( 'Picture to the left of text', 'aperitto' ),
				'right'  => __( 'Picture to the right of text', 'aperitto' ),
				'bottom' => __( 'Picture under the text', 'aperitto' ),
			)
		)
	);


	// ----

	if ( class_exists( 'Aperitto_Group_Title_Control' ) ) {
		$wp_customize->add_setting( APERITTO_OPTION . '[group_site_title]', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_key'
		) );
		$wp_customize->add_control( new Aperitto_Group_Title_Control( $wp_customize, 'aperitto_group_site_title', array(
			'label'    => __( 'Site title', 'aperitto' ),
			'section'  => 'title_tagline',
			'priority' => 10,
			'settings' => APERITTO_OPTION . '[group_site_title]',
		) ) );
	}

	// change title setting transport
	$wp_customize->get_setting( 'blogname' )->transport = $transport;
	$wp_customize->get_control( 'blogname' )->priority  = 11;

	$wp_customize->get_setting( 'header_textcolor' )->transport = $transport;
	$wp_customize->get_control( 'header_textcolor' )->section   = 'title_tagline';
	$wp_customize->get_control( 'header_textcolor' )->priority  = 11;

	// ----

	if ( class_exists( 'Aperitto_Group_Title_Control' ) ) {
		$wp_customize->add_setting( APERITTO_OPTION . '[group_description_title]', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_key',
		) );
		$wp_customize->add_control( new Aperitto_Group_Title_Control( $wp_customize, 'aperitto_group_description_title', array(
			'label'    => __( 'Description', 'aperitto' ),
			'section'  => 'title_tagline',
			'priority' => 12,
			'settings' => APERITTO_OPTION . '[group_description_title]',
		) ) );
	}

	$wp_customize->get_setting( 'blogdescription' )->transport = $transport;
	$wp_customize->get_control( 'blogdescription' )->section   = 'title_tagline';
	$wp_customize->get_control( 'blogdescription' )->priority  = 13;

	// ---

	$wp_customize->add_setting(
		APERITTO_OPTION . '[title_position]',
		array(
			'type'              => 'option',
			'default'           => 'left',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'title_position_control',
		array(
			'settings' => APERITTO_OPTION . '[title_position]',
			'label'    => __( "Title position", 'aperitto' ),
			'section'  => 'title_tagline',
			'type'     => 'select',
			'choices'  => array(
				'left'   => __( "Left", 'aperitto' ),
				'right'  => __( "Right", 'aperitto' ),
				'center' => __( "Center", 'aperitto' )
			),
			'priority' => 11,
		)
	);

	if ( class_exists( 'Aperitto_Group_Title_Control' ) ) {
		$wp_customize->add_setting( 'group_blog_h1_title', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_key',
		) );
		$wp_customize->add_control( new Aperitto_Group_Title_Control( $wp_customize, 'aperitto_group_blog_h1_title', array(
			'label'    => __( 'Blog home page H1', 'aperitto' ),
			'section'  => 'title_tagline',
			'priority' => 11,
			'settings' => 'group_blog_h1_title',
			'active_callback' => 'aperitto_show_on_home_posts'
		) ) );
	}

	// ---

	$wp_customize->add_setting(
		'home_h1_type',
		array(
			'default'           => 'sitetitle',
			'sanitize_callback' => 'sanitize_key',
		)
	);
	$wp_customize->add_control( 'home_h1_type_control',
		array(
			'settings'    => 'home_h1_type',
			'label'       => __( "Home H1 position", 'aperitto' ),
			'description' => __( "This option not affect to other pages, for home blog page only.", 'aperitto' ),
			'section'     => 'title_tagline',
			'type'        => 'radio',
			'choices'     => array(
				'sitetitle'   => __( "Site title in header", 'aperitto' ),
				'customtitle' => __( "My custom title before posts", 'aperitto' ),
			),
			'active_callback' => 'aperitto_show_on_home_posts',
			'priority'    => 11,
		)
	);

	// ---

	$wp_customize->add_setting(
		'custom_home_h1',
		array(
			'default'           => get_bloginfo( 'sitetitle' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control( 'custom_home_h1_control',
		array(
			'settings'        => 'custom_home_h1',
			'label'           => __( "Custom blog home H1", 'aperitto' ),
			'section'         => 'title_tagline',
			'type'            => 'text',
			'active_callback' => 'aperitto_custom_home_h1',
			'priority'        => 11,
		)
	);
	// ---

	// site descriptions
	$wp_customize->add_setting( APERITTO_OPTION . '[showsitedesc]', array(
		'type'              => 'option',
		'default'           => '1',
		'sanitize_callback' => 'sanitize_key',
		'transport'         => $transport
	) );
	$wp_customize->add_control( 'showsitedesc_control',
		array(
			'label'    => __( 'Show site description', 'aperitto' ),
			'settings' => APERITTO_OPTION . '[showsitedesc]',
			'section'  => 'title_tagline',
			'type'     => 'checkbox',
			'priority' => 21,
		)
	);

	// ----

	if ( class_exists( 'Aperitto_Group_Title_Control' ) ) {
		$wp_customize->add_setting( APERITTO_OPTION . '[group_other_title]', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_key',
		) );
		$wp_customize->add_control( new Aperitto_Group_Title_Control( $wp_customize, 'aperitto_group_other_title', array(
			'label'    => __( 'Other', 'aperitto' ),
			'section'  => 'title_tagline',
			'priority' => 22,
			'settings' => APERITTO_OPTION . '[group_other_title]',
		) ) );
	}


	/*----------  H E A D E R    I M A G E   ----------*/

	$wp_customize->get_section( 'header_image' )->priority = 30;

	// ---

	$wp_customize->add_setting(
		APERITTO_OPTION . '[header_image_position]',
		array(
			'type'              => 'option',
			'default'           => 'background_no_repeat',
			'sanitize_callback' => 'sanitize_key',
		)
	);
	$wp_customize->add_control( 'header_image_position_control',
		array(
			'settings' => APERITTO_OPTION . '[header_image_position]',
			'label'    => __( "How to display image", 'aperitto' ),
			'section'  => 'header_image',
			'type'     => 'radio',
			'choices'  => array(
				'before'               => __( "Image before site title", 'aperitto' ),
				'after'                => __( "Image after site title", 'aperitto' ),
				'background_no_repeat' => __( "Background without repeat", 'aperitto' ),
				'background_repeat'    => __( "Background with full repeat", 'aperitto' ),
				'background_repeat_x'  => __( "Background with horizontal repeat", 'aperitto' ),
				'background_repeat_y'  => __( "Background with vertical repeat", 'aperitto' ),
			),
		)
	);

	// ---

	$wp_customize->add_setting(
		APERITTO_OPTION . '[fix_header_height]',
		array(
			'type'              => 'option',
			'default'           => 0,
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'fix_header_height_control',
		array(
			'settings' => APERITTO_OPTION . '[fix_header_height]',
			'label'    => __( "Fit minimal header height to image height", 'aperitto' ),
			'section'  => 'header_image',
			'type'     => 'checkbox',
		)
	);

	// ---

	/*----------  C O L O R S   &&   B A C K G R O U N D  ----------*/

	$wp_customize->get_section( 'background_image' )->title = __( 'Site Background', 'aperitto' );

	$wp_customize->get_control( 'background_color' )->priority = 30;
	$wp_customize->get_control( 'background_image' )->priority = 30;

	$wp_customize->get_control( 'background_color' )->section = 'background_image';
	$wp_customize->remove_section( 'colors' );


	/*----------  L A Y O U T   ----------*/

	// content custom section
	$wp_customize->add_section(
		'layout',
		array(
			'title'       => __( 'Color & Layout', 'aperitto' ),
			'priority'    => 80,
			'description' => __( 'Main theme options', 'aperitto' )
		)
	);

	// ----
	$wp_customize->add_setting(
		APERITTO_OPTION . '[maincolor]',
		array(
			'type'              => 'option',
			'default'           => '#137dad',
			'priority'          => 10,
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		APERITTO_OPTION . '[maincolor]',
		array(
			'label'       => __( "Main color", 'aperitto' ),
			'description' => __( "Choose main color", 'aperitto' ),
			'section'     => 'layout',
			'settings'    => APERITTO_OPTION . '[maincolor]',
		)
	) );

	// ----

	if ( class_exists( 'Aperitto_Group_Title_Control' ) ) {
		$wp_customize->add_setting( APERITTO_OPTION . '[group_layout_title]', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_key',
		) );
		$wp_customize->add_control( new Aperitto_Group_Title_Control( $wp_customize, 'aperitto_group_layout_title', array(
			'label'       => __( 'Layout', 'aperitto' ),
			'description' => __( 'Set up layout for site pages', 'aperitto' ),
			'section'     => 'layout',
			'settings'    => APERITTO_OPTION . '[group_layout_title]',
		) ) );
	}

	// ----

	$wp_customize->add_setting(
		APERITTO_OPTION . '[show_sidebar]',
		array(
			'type'              => 'option',
			'default'           => 0,
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'show_sidebar_control',
		array(
			'settings' => APERITTO_OPTION . '[show_sidebar]',
			'label'    => __( "Show sidebar on mobile", 'aperitto' ),
			'section'  => 'layout',
			'type'     => 'checkbox',
		)
	);

	// ----

	$wp_customize->add_setting( 'show_mobile_thumb',
		array(
			'default'           => 0,
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'show_mobile_thumb_control',
		array(
			'settings' => 'show_mobile_thumb',
			'label'    => __( "Show featured images on mobile", 'aperitto' ),
			'section'  => 'layout',
			'type'     => 'checkbox',
		)
	);

	// ----

	$wp_customize->add_setting(
		APERITTO_OPTION . '[layout_home]',
		array(
			'type'              => 'option',
			'default'           => 'rightbar',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'layout_home_control',
		array(
			'settings' => APERITTO_OPTION . '[layout_home]',
			'label'    => __( "Layout on Home", 'aperitto' ),
			'section'  => 'layout',
			'type'     => 'select',
			'choices'  => array(
				'rightbar' => __( "Rightbar", 'aperitto' ),
				'leftbar'  => __( "Leftbar", 'aperitto' ),
				'full'     => __( "Fullwidth Content", 'aperitto' ),
				'center'   => __( "Centered Content", 'aperitto' )
			),
		)
	);

	// ----

	$wp_customize->add_setting(
		APERITTO_OPTION . '[layout_post]',
		array(
			'type'              => 'option',
			'default'           => 'rightbar',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'layout_post_control',
		array(
			'settings' => APERITTO_OPTION . '[layout_post]',
			'label'    => __( "Layout on Post", 'aperitto' ),
			'section'  => 'layout',
			'type'     => 'select',
			'choices'  => array(
				'rightbar' => __( "Rightbar", 'aperitto' ),
				'leftbar'  => __( "Leftbar", 'aperitto' ),
				'full'     => __( "Fullwidth Content", 'aperitto' ),
				'center'   => __( "Centered Content", 'aperitto' )
			),
		)
	);

	// ----

	$wp_customize->add_setting(
		APERITTO_OPTION . '[layout_page]',
		array(
			'type'              => 'option',
			'default'           => 'center',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'layout_page_control',
		array(
			'settings' => APERITTO_OPTION . '[layout_page]',
			'label'    => __( "Layout on Page", 'aperitto' ),
			'section'  => 'layout',
			'type'     => 'select',
			'choices'  => array(
				'rightbar' => __( "Rightbar", 'aperitto' ),
				'leftbar'  => __( "Leftbar", 'aperitto' ),
				'full'     => __( "Fullwidth Content", 'aperitto' ),
				'center'   => __( "Centered Content", 'aperitto' )
			),
		)
	);


	// ----

	$wp_customize->add_setting(
		'layout_search',
		array(
			'type'              => 'option',
			'default'           => 'center',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'layout_search_control',
		array(
			'settings' => 'layout_search',
			'label'    => __( "Layout on Search results page", 'aperitto' ),
			'section'  => 'layout',
			'type'     => 'select',
			'choices'  => array(
				'rightbar' => __( "Rightbar", 'aperitto' ),
				'leftbar'  => __( "Leftbar", 'aperitto' ),
				'full'     => __( "Fullwidth Content", 'aperitto' ),
				'center'   => __( "Centered Content", 'aperitto' )
			),
		)
	);



	// ----

	$wp_customize->add_setting(
		APERITTO_OPTION . '[layout_default]',
		array(
			'type'              => 'option',
			'default'           => 'rightbar',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'layout_default_control',
		array(
			'settings'    => APERITTO_OPTION . '[layout_default]',
			'label'       => __( "Global layout", 'aperitto' ),
			'description' => __( "It is used when individual page layout is not set", 'aperitto' ),
			'section'     => 'layout',
			'type'        => 'select',
			'choices'     => array(
				'rightbar' => __( "Rightbar", 'aperitto' ),
				'leftbar'  => __( "Leftbar", 'aperitto' ),
				'full'     => __( "Fullwidth Content", 'aperitto' ),
				'center'   => __( "Centered Content", 'aperitto' )
			),
		)
	);

	// ----

	if ( function_exists( 'is_woocommerce' ) ) {


		if ( class_exists( 'Aperitto_Group_Title_Control' ) ) {
			$wp_customize->add_setting( 'group_woolayout_title', array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_key',
			) );
			$wp_customize->add_control( new Aperitto_Group_Title_Control( $wp_customize, 'aperitto_group_woolayout_title', array(
				'label'       => __( 'WooCommerce Layout', 'aperitto' ),
				'section'     => 'layout',
				'settings'    => 'group_woolayout_title',
			) ) );
		}

		// ---
		$wp_customize->add_setting(
			'layout_shop',
			array(
				'default'           => 'full',
				'sanitize_callback' => 'sanitize_key',
				'transport'         => $transport
			)
		);
		$wp_customize->add_control( 'layout_shop_control',
			array(
				'settings' => 'layout_shop',
				'label'    => __( "Layout on WooCommerce Shop page", 'aperitto' ),
				'section'  => 'layout',
				'type'     => 'select',
				'choices'  => array(
					'rightbar' => __( "Rightbar", 'aperitto' ),
					'leftbar'  => __( "Leftbar", 'aperitto' ),
					'full'     => __( "Fullwidth Content", 'aperitto' ),
					'center'   => __( "Centered Content", 'aperitto' )
				),
			)
		);

		// ---
		$wp_customize->add_setting(
			'layout_product',
			array(
				'default'           => 'rightbar',
				'sanitize_callback' => 'sanitize_key',
				'transport'         => $transport
			)
		);
		$wp_customize->add_control( 'layout_product_control',
			array(
				'settings' => 'layout_product',
				'label'    => __( "Layout on WooCommerce Product page", 'aperitto' ),
				'section'  => 'layout',
				'type'     => 'select',
				'choices'  => array(
					'rightbar' => __( "Rightbar", 'aperitto' ),
					'leftbar'  => __( "Leftbar", 'aperitto' ),
					'full'     => __( "Fullwidth Content", 'aperitto' ),
					'center'   => __( "Centered Content", 'aperitto' )
				),
			)
		);

		// ---
		$wp_customize->add_setting(
			'layout_product_cat',
			array(
				'default'           => 'rightbar',
				'sanitize_callback' => 'sanitize_key',
				'transport'         => $transport
			)
		);
		$wp_customize->add_control( 'layout_product_cat_control',
			array(
				'settings' => 'layout_product_cat',
				'label'    => __( "Layout on WooCommerce Product's category", 'aperitto' ),
				'section'  => 'layout',
				'type'     => 'select',
				'choices'  => array(
					'rightbar' => __( "Rightbar", 'aperitto' ),
					'leftbar'  => __( "Leftbar", 'aperitto' ),
					'full'     => __( "Fullwidth Content", 'aperitto' ),
					'center'   => __( "Centered Content", 'aperitto' )
				),
			)
		);


	}


	// ----

	if ( class_exists( 'Aperitto_Group_Title_Control' ) ) {
		$wp_customize->add_setting( APERITTO_OPTION . '[group_other_layout]', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_key'
		) );
		$wp_customize->add_control( new Aperitto_Group_Title_Control( $wp_customize, 'aperitto_group_other_layout', array(
			'label'    => __( 'Other options', 'aperitto' ),
			'section'  => 'layout',
			'settings' => APERITTO_OPTION . '[group_other_layout]',
		) ) );
	}

	// ----

	$wp_customize->add_setting( 'postmeta_list',
		array(
			'default'           => 'date_category_comments',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control(
		new Aperitto_Sortable_Checkboxes_WPCC(
			$wp_customize,
			'fx_share_services', /* control id */
			array(
				'settings'    => 'postmeta_list',
				'label'       => __( "Post meta", 'aperitto' ),
				'description' => __( "What meta information to display for posts", 'aperitto' ),
				'section'     => 'layout',
				'choices'     => array(
					'date'     => __( "Publication date", 'aperitto' ),
					'author'   => __( "Post author", 'aperitto' ),
					'category' => __( "Post categories", 'aperitto' ),
					'comments' => __( "Comments count", 'aperitto' ),
					'tags'     => __( "Post tags", 'aperitto' )
				),
			)
		)
	);


	// ----------  F O O T E R  ----------

	$wp_customize->add_section(
		'aperitto_footer_text',
		array(
			'title'       => __( 'Footer', 'aperitto' ),
			'description' => __( 'Customize footer', 'aperitto' ),
			'priority'    => 92,
		)
	);

	// ----

	$wp_customize->add_setting(
		APERITTO_OPTION . '[copyright_year]',
		array(
			'type'              => 'option',
			'default'           => '1',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'copyright_year_control',
		array(
			'settings' => APERITTO_OPTION . '[copyright_year]',
			'label'    => __( "Show 'Sitename © Year' in footer", 'aperitto' ),
			'section'  => 'aperitto_footer_text',
			'type'     => 'checkbox',
		)
	);

	// ----

	$wp_customize->add_setting(
		APERITTO_OPTION . '[powered_by]',
		array(
			'type'              => 'option',
			'default'           => '1',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'powered_by_control',
		array(
			'settings' => APERITTO_OPTION . '[powered_by]',
			'label'    => __( "Show 'Powered by' in footer", 'aperitto' ),
			'section'  => 'aperitto_footer_text',
			'type'     => 'checkbox',
		)
	);

	// ----

	$wp_customize->add_setting(
		APERITTO_OPTION . '[copyright_text]',
		array(
			'type'              => 'option',
			'default'           => __( 'All rights reserved', 'aperitto' ),
			'sanitize_callback' => 'aperitto_sanitize_text',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'copyright_text_control',
		array(
			'settings' => APERITTO_OPTION . '[copyright_text]',
			'label'    => __( "Custom copyright text", 'aperitto' ),
			'section'  => 'aperitto_footer_text',
			'type'     => 'text',
		)
	);

}

add_action( 'customize_register', 'aperitto_customizer_init' );
