<?php
// Register Custom Post Type for members only
function arkiesaw_members_function() {

	$labels = array(
		'name'                => _x( 'Members', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Member', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Member', 'text_domain' ),
		'name_admin_bar'      => __( 'Members', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Member:', 'text_domain' ),
		'all_items'           => __( 'All Members', 'text_domain' ),
		'add_new_item'        => __( 'Add New Member', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'new_item'            => __( 'New Member', 'text_domain' ),
		'edit_item'           => __( 'Edit Member', 'text_domain' ),
		'update_item'         => __( 'Update Member', 'text_domain' ),
		'view_item'           => __( 'View Member', 'text_domain' ),
		'search_items'        => __( 'Search Member', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'Member', 'text_domain' ),
		'description'         => __( 'Member post designed to show a network of community members', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'			  => 'dashicons-tickets',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,		
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'member', $args );

}
add_action( 'init', 'arkiesaw_members_function', 0 );

// Register Custom Taxonomy for area information
function arkiesaw_taxonomy_register() {

	$labels = array(
		'name'                       => _x( 'Areas', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Area', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Edit Areas', 'text_domain' ),
		'all_items'                  => __( 'All Areas', 'text_domain' ),
		'parent_item'                => __( 'Parent Area', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Area:', 'text_domain' ),
		'new_item_name'              => __( 'New Area', 'text_domain' ),
		'add_new_item'               => __( 'Add Area', 'text_domain' ),
		'edit_item'                  => __( 'Edit Area', 'text_domain' ),
		'update_item'                => __( 'Update Area', 'text_domain' ),
		'view_item'                  => __( 'View Area', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate areas with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove areas', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose From Most Used', 'text_domain' ),
		'popular_items'              => __( 'Popular Areas', 'text_domain' ),
		'search_items'               => __( 'Search Areas', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'area', array( 'member' ), $args );

}
add_action( 'init', 'arkiesaw_taxonomy_register', 0 );

//Let's make sure we get some address information to use for generating a static map

function address_information_get_meta( $value ) {
	global $post;

	$field = get_post_meta( $post->ID, $value, true );
	if ( ! empty( $field ) ) {
		return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
	} else {
		return false;
	}
}

function address_information_add_meta_box() {
	add_meta_box(
		'address_information-address-information',
		__( 'Address Information', 'address_information' ),
		'address_information_html',
		'member',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'address_information_add_meta_box' );

function address_information_html( $post) {
	wp_nonce_field( '_address_information_nonce', 'address_information_nonce' ); ?>

	<p>Adds a nice address portion to our member entries</p>

	<p>
		<label for="address_information_address_line_1"><?php _e( 'Address Line #1', 'address_information' ); ?></label><br>
		<input type="text" name="address_information_address_line_1" id="address_information_address_line_1" value="<?php echo address_information_get_meta( 'address_information_address_line_1' ); ?>">
	</p>	<p>
		<label for="address_information_address_line_2"><?php _e( 'Address Line #2', 'address_information' ); ?></label><br>
		<input type="text" name="address_information_address_line_2" id="address_information_address_line_2" value="<?php echo address_information_get_meta( 'address_information_address_line_2' ); ?>">
	</p>	<p>
		<label for="address_information_city"><?php _e( 'City', 'address_information' ); ?></label><br>
		<input type="text" name="address_information_city" id="address_information_city" value="<?php echo address_information_get_meta( 'address_information_city' ); ?>">
	</p>	<p>
		<label for="address_information_state_province"><?php _e( 'State / Province', 'address_information' ); ?></label><br>
		<input type="text" name="address_information_state_province" id="address_information_state_province" value="<?php echo address_information_get_meta( 'address_information_state_province' ); ?>">
	</p>	<p>
		<label for="address_information_postal_code"><?php _e( 'Postal Code', 'address_information' ); ?></label><br>
		<input type="text" name="address_information_postal_code" id="address_information_postal_code" value="<?php echo address_information_get_meta( 'address_information_postal_code' ); ?>">
	</p><?php
}

function address_information_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['address_information_nonce'] ) || ! wp_verify_nonce( $_POST['address_information_nonce'], '_address_information_nonce' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	if ( isset( $_POST['address_information_address_line_1'] ) )
		update_post_meta( $post_id, 'address_information_address_line_1', esc_attr( $_POST['address_information_address_line_1'] ) );
	if ( isset( $_POST['address_information_address_line_2'] ) )
		update_post_meta( $post_id, 'address_information_address_line_2', esc_attr( $_POST['address_information_address_line_2'] ) );
	if ( isset( $_POST['address_information_city'] ) )
		update_post_meta( $post_id, 'address_information_city', esc_attr( $_POST['address_information_city'] ) );
	if ( isset( $_POST['address_information_state_province'] ) )
		update_post_meta( $post_id, 'address_information_state_province', esc_attr( $_POST['address_information_state_province'] ) );
	if ( isset( $_POST['address_information_postal_code'] ) )
		update_post_meta( $post_id, 'address_information_postal_code', esc_attr( $_POST['address_information_postal_code'] ) );
}
add_action( 'save_post', 'address_information_save' );

/*
	Usage: address_information_get_meta( 'address_information_address_line_1' )
	Usage: address_information_get_meta( 'address_information_address_line_2' )
	Usage: address_information_get_meta( 'address_information_city' )
	Usage: address_information_get_meta( 'address_information_state_province' )
	Usage: address_information_get_meta( 'address_information_postal_code' )
*/

//Load the custom Raphael stuff

?>