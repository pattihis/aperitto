<?php


/**
 * Add Meta Box
 *
 * ======================================================================== */
function aperitto_add_custom_box() {

	// Adding layout meta box for page / post / product

	add_meta_box(
        'aperitto-page-layout',
        __( 'Select Layout', 'aperitto' ),
        'aperitto_page_layout',
        array('post', 'page', 'product'),
        'side',
        'default'
    );

}

add_action( 'add_meta_boxes', 'aperitto_add_custom_box' );
/* ======================================================================== */


/* ======================================================================== */
function aperitto_get_default_page_layouts() {

	$page_layout = array(
		'default-layout' => array(
			'id'    => 'aperitto_page_layout',
			'value' => 'default',
			'label' => __( 'Default', 'aperitto' )
		),
		'rightbar'       => array(
			'id'    => 'aperitto_page_layout',
			'value' => 'rightbar',
			'label' => __( 'Rightbar', 'aperitto' )
		),
		'leftbar'        => array(
			'id'    => 'aperitto_page_layout',
			'value' => 'leftbar',
			'label' => __( 'Leftbar', 'aperitto' )
		),
		'full'           => array(
			'id'    => 'aperitto_page_layout',
			'value' => 'full',
			'label' => __( 'Fullwidth Content', 'aperitto' )
		),
		'center'         => array(
			'id'    => 'aperitto_page_layout',
			'value' => 'center',
			'label' => __( 'Centered Content', 'aperitto' )
		)
	);

	return $page_layout;

}


/* ========================================================================
 *
 * Displays metabox to for select layout option
 *
 * ======================================================================== */
function aperitto_page_layout() {
	global $post;

	$page_layout = aperitto_get_default_page_layouts();

	// Use nonce for verification
	wp_nonce_field( basename( __FILE__ ), 'aperitto_meta_box_nonce' );

	foreach ( $page_layout as $field ) {
		$layout_meta = get_post_meta( $post->ID, $field['id'], true );
		if ( empty( $layout_meta ) ) {
			$layout_meta = 'default';
		}
		?>
        <label class="aperitto-post-format-icon">
            <input class="aperitto-post-format" type="radio" name="<?php echo $field['id']; ?>" value="<?php echo $field['value']; ?>" <?php checked( $field['value'], $layout_meta ); ?>/>
			<?php echo $field['label']; ?></label><br />
		<?php
	}
}


/* ========================================================================
 *
 * save the custom metabox data
 *
 * ======================================================================== */
function aperitto_save_custom_meta( $post_id ) {

	$page_layout = aperitto_get_default_page_layouts();

	// Verify the nonce before proceeding.
	if ( ! isset( $_POST['aperitto_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['aperitto_meta_box_nonce'], basename( __FILE__ ) ) ) {
		return;
	}

	// Stop WP from clearing custom fields on autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}
	} elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	foreach ( $page_layout as $field ) {
		//Execute this saving function
		$old = get_post_meta( $post_id, $field['id'], true );
		$new = isset( $_POST[ $field['id'] ] ) ? $_POST[ $field['id'] ] : 'default';
		if ( $new && $new != $old ) {
			update_post_meta( $post_id, $field['id'], $new );
		} elseif ( '' == $new && $old ) {
			delete_post_meta( $post_id, $field['id'], $old );
		}
	} // end foreach
}

add_action( 'pre_post_update', 'aperitto_save_custom_meta' );


