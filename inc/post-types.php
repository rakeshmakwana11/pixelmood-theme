<?php
/**
 * Register Custom Post Types and Taxonomies for PixelMood
 *
 * @package PixelMood
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register 'prompts' Custom Post Type
 */
function pixelmood_register_post_types() {

	$labels = array(
		'name'                  => _x( 'Prompts', 'Post Type General Name', 'pixelmood' ),
		'singular_name'         => _x( 'Prompt', 'Post Type Singular Name', 'pixelmood' ),
		'menu_name'             => __( 'Prompts', 'pixelmood' ),
		'name_admin_bar'        => __( 'Prompt', 'pixelmood' ),
		'archives'              => __( 'Prompt Archives', 'pixelmood' ),
		'attributes'            => __( 'Prompt Attributes', 'pixelmood' ),
		'parent_item_colon'     => __( 'Parent Prompt:', 'pixelmood' ),
		'all_items'             => __( 'All Prompts', 'pixelmood' ),
		'add_new_item'          => __( 'Add New Prompt', 'pixelmood' ),
		'add_new'               => __( 'Add New', 'pixelmood' ),
		'new_item'              => __( 'New Prompt', 'pixelmood' ),
		'edit_item'             => __( 'Edit Prompt', 'pixelmood' ),
		'update_item'           => __( 'Update Prompt', 'pixelmood' ),
		'view_item'             => __( 'View Prompt', 'pixelmood' ),
		'view_items'            => __( 'View Prompts', 'pixelmood' ),
		'search_items'          => __( 'Search Prompt', 'pixelmood' ),
		'not_found'             => __( 'Not found', 'pixelmood' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'pixelmood' ),
		'featured_image'        => __( 'Featured Image', 'pixelmood' ),
		'set_featured_image'    => __( 'Set featured image', 'pixelmood' ),
		'remove_featured_image' => __( 'Remove featured image', 'pixelmood' ),
		'use_featured_image'    => __( 'Use as featured image', 'pixelmood' ),
		'insert_into_item'      => __( 'Insert into prompt', 'pixelmood' ),
		'uploaded_to_this_item' => __( 'Uploaded to this prompt', 'pixelmood' ),
		'items_list'            => __( 'Prompts list', 'pixelmood' ),
		'items_list_navigation' => __( 'Prompts list navigation', 'pixelmood' ),
		'filter_items_list'     => __( 'Filter prompts list', 'pixelmood' ),
	);

	$args = array(
		'label'               => __( 'Prompt', 'pixelmood' ),
		'description'         => __( 'AI Image Prompts for PixelMood', 'pixelmood' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
		'taxonomies'          => array( 'prompt_category', 'prompt_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-format-image',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => 'prompts',
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'show_in_rest'        => true,
		'rewrite'             => array(
			'slug'       => 'prompt',
			'with_front' => false,
		),
	);

	register_post_type( 'prompts', $args );
}
add_action( 'init', 'pixelmood_register_post_types', 0 );

/**
 * Register 'prompt_category' Taxonomy
 */
function pixelmood_register_taxonomies() {

	// Prompt Category
	$cat_labels = array(
		'name'              => _x( 'Prompt Categories', 'taxonomy general name', 'pixelmood' ),
		'singular_name'     => _x( 'Prompt Category', 'taxonomy singular name', 'pixelmood' ),
		'search_items'      => __( 'Search Prompt Categories', 'pixelmood' ),
		'all_items'         => __( 'All Prompt Categories', 'pixelmood' ),
		'parent_item'       => __( 'Parent Prompt Category', 'pixelmood' ),
		'parent_item_colon' => __( 'Parent Prompt Category:', 'pixelmood' ),
		'edit_item'         => __( 'Edit Prompt Category', 'pixelmood' ),
		'update_item'       => __( 'Update Prompt Category', 'pixelmood' ),
		'add_new_item'      => __( 'Add New Prompt Category', 'pixelmood' ),
		'new_item_name'     => __( 'New Prompt Category Name', 'pixelmood' ),
		'menu_name'         => __( 'Prompt Categories', 'pixelmood' ),
	);

	$cat_args = array(
		'hierarchical'      => true,
		'labels'            => $cat_labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'prompt-category' ),
	);

	register_taxonomy( 'prompt_category', array( 'prompts' ), $cat_args );

	// Prompt Tag
	$tag_labels = array(
		'name'              => _x( 'Prompt Tags', 'taxonomy general name', 'pixelmood' ),
		'singular_name'     => _x( 'Prompt Tag', 'taxonomy singular name', 'pixelmood' ),
		'search_items'      => __( 'Search Prompt Tags', 'pixelmood' ),
		'all_items'         => __( 'All Prompt Tags', 'pixelmood' ),
		'edit_item'         => __( 'Edit Prompt Tag', 'pixelmood' ),
		'update_item'       => __( 'Update Prompt Tag', 'pixelmood' ),
		'add_new_item'      => __( 'Add New Prompt Tag', 'pixelmood' ),
		'new_item_name'     => __( 'New Prompt Tag Name', 'pixelmood' ),
		'menu_name'         => __( 'Prompt Tags', 'pixelmood' ),
	);

	$tag_args = array(
		'hierarchical'      => false,
		'labels'            => $tag_labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'prompt-tag' ),
	);

	register_taxonomy( 'prompt_tag', array( 'prompts' ), $tag_args );
}
add_action( 'init', 'pixelmood_register_taxonomies', 0 );

/**
 * Add Prompt ID meta box in admin
 */
function pixelmood_add_prompt_id_metabox() {
	add_meta_box(
		'pixelmood_prompt_id',
		__( 'Prompt ID', 'pixelmood' ),
		'pixelmood_prompt_id_callback',
		'prompts',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'pixelmood_add_prompt_id_metabox' );

/**
 * Prompt ID metabox HTML
 */
function pixelmood_prompt_id_callback( $post ) {
	wp_nonce_field( 'pixelmood_prompt_id_nonce', 'pixelmood_prompt_id_nonce' );
	$value = get_post_meta( $post->ID, '_prompt_id', true );
	?>
	<div style="padding: 5px 0;">
		<label for="pixelmood_prompt_id" style="display:block; margin-bottom:5px; font-weight:600;">
			<?php esc_html_e( 'Prompt ID (e.g. PM1001)', 'pixelmood' ); ?>
		</label>
		<input
			type="text"
			id="pixelmood_prompt_id"
			name="pixelmood_prompt_id"
			value="<?php echo esc_attr( $value ); ?>"
			placeholder="PM1001"
			style="width:100%; text-transform:uppercase;"
		/>
		<p style="margin-top:5px; color:#666; font-size:12px;">
			<?php esc_html_e( 'This ID will appear on cards and single pages but NOT in URLs.', 'pixelmood' ); ?>
		</p>
	</div>
	<?php
}

/**
 * Save Prompt ID meta
 */
function pixelmood_save_prompt_id_meta( $post_id ) {
	if ( ! isset( $_POST['pixelmood_prompt_id_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pixelmood_prompt_id_nonce'] ) ), 'pixelmood_prompt_id_nonce' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( isset( $_POST['pixelmood_prompt_id'] ) ) {
		$prompt_id = sanitize_text_field( wp_unslash( $_POST['pixelmood_prompt_id'] ) );
		$prompt_id = strtoupper( $prompt_id );
		update_post_meta( $post_id, '_prompt_id', $prompt_id );
	}
}
add_action( 'save_post_prompts', 'pixelmood_save_prompt_id_meta' );

/**
 * Auto-generate Prompt ID if empty on publish
 */
function pixelmood_auto_generate_prompt_id( $post_id, $post ) {
	if ( 'prompts' !== $post->post_type ) {
		return;
	}
	$existing = get_post_meta( $post_id, '_prompt_id', true );
	if ( empty( $existing ) ) {
		$new_id = 'PM' . str_pad( $post_id, 4, '0', STR_PAD_LEFT );
		update_post_meta( $post_id, '_prompt_id', $new_id );
	}
}
add_action( 'wp_insert_post', 'pixelmood_auto_generate_prompt_id', 10, 2 );
