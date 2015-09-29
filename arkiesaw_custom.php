<?php
// Register Custom Post Type
function arkiesaw_locations_posts() {

	$labels = array(
		'name'                => _x( 'Locations', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Location', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Location', 'text_domain' ),
		'name_admin_bar'      => __( 'Location', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Location:', 'text_domain' ),
		'all_items'           => __( 'All Locations', 'text_domain' ),
		'add_new_item'        => __( 'Add New Location', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'new_item'            => __( 'New Location', 'text_domain' ),
		'edit_item'           => __( 'Edit Location', 'text_domain' ),
		'update_item'         => __( 'Update Location', 'text_domain' ),
		'view_item'           => __( 'View Location', 'text_domain' ),
		'search_items'        => __( 'Search Location', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'Location', 'text_domain' ),
		'description'         => __( 'Locations used with our plugin', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', ),
		'taxonomies'          => array( 'area' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-location-alt',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,		
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'location_post', $args );

}
add_action( 'init', 'arkiesaw_locations_posts', 0 );

// Register Custom Taxonomy
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
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'area', array( 'location_post' ), $args );

}
add_action( 'init', 'arkiesaw_taxonomy_register', 0 );

?>