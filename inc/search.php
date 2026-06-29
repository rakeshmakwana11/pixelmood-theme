<?php
/**
 * Extend WordPress Search for PixelMood
 * Searches: Prompt ID, Title, Categories, Tags
 *
 * @package PixelMood
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Include prompts in main search results
 */
function pixelmood_search_include_prompts( $query ) {
	if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {
		$query->set( 'post_type', array( 'post', 'prompts' ) );
	}
	return $query;
}
add_action( 'pre_get_posts', 'pixelmood_search_include_prompts' );

/**
 * Extend search to include Prompt ID (custom meta) and taxonomy terms
 */
function pixelmood_extend_search_query( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_search() ) {
		return;
	}

	$search_term = get_search_query();
	if ( empty( $search_term ) ) {
		return;
	}

	// Search by Prompt ID in meta
	$meta_query = array(
		array(
			'key'     => '_prompt_id',
			'value'   => $search_term,
			'compare' => 'LIKE',
		),
	);

	$query->set( 'meta_query', $meta_query );
	$query->set( 'meta_query_relation', 'OR' );
}
add_action( 'pre_get_posts', 'pixelmood_extend_search_query' );

/**
 * Extend search to include taxonomy terms (categories, tags)
 * Uses posts_search filter to modify the SQL WHERE clause
 */
function pixelmood_search_by_taxonomy( $search, $wp_query ) {
	global $wpdb;

	if ( ! $wp_query->is_search() || is_admin() ) {
		return $search;
	}

	$search_term = $wp_query->get( 's' );
	if ( empty( $search_term ) ) {
		return $search;
	}

	$like = '%' . $wpdb->esc_like( $search_term ) . '%';

	// Find post IDs where taxonomy terms match the search
	$tax_post_ids = $wpdb->get_col(
		$wpdb->prepare(
			"SELECT DISTINCT tr.object_id
			FROM {$wpdb->term_relationships} tr
			INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
			INNER JOIN {$wpdb->terms} t ON tt.term_id = t.term_id
			WHERE tt.taxonomy IN ('prompt_category', 'prompt_tag', 'category', 'post_tag')
			AND t.name LIKE %s",
			$like
		)
	);

	// Find post IDs where Prompt ID meta matches
	$meta_post_ids = $wpdb->get_col(
		$wpdb->prepare(
			"SELECT post_id FROM {$wpdb->postmeta}
			WHERE meta_key = '_prompt_id'
			AND meta_value LIKE %s",
			$like
		)
	);

	$extra_ids = array_unique( array_merge( $tax_post_ids, $meta_post_ids ) );

	if ( ! empty( $extra_ids ) ) {
		$ids_str = implode( ',', array_map( 'intval', $extra_ids ) );
		$search .= " OR {$wpdb->posts}.ID IN ({$ids_str}) ";
	}

	return $search;
}
add_filter( 'posts_search', 'pixelmood_search_by_taxonomy', 10, 2 );

/**
 * AJAX Live Search Handler
 */
function pixelmood_ajax_search() {
	check_ajax_referer( 'pixelmood_search_nonce', 'nonce' );

	$term = isset( $_POST['term'] ) ? sanitize_text_field( wp_unslash( $_POST['term'] ) ) : '';

	if ( strlen( $term ) < 2 ) {
		wp_send_json_success( array() );
		return;
	}

	$like = '%' . $term . '%';

	// Search by title
	$title_results = new WP_Query(
		array(
			'post_type'      => array( 'prompts', 'post' ),
			'posts_per_page' => 8,
			'post_status'    => 'publish',
			's'              => $term,
		)
	);

	// Search by Prompt ID
	$id_results = new WP_Query(
		array(
			'post_type'      => 'prompts',
			'posts_per_page' => 5,
			'post_status'    => 'publish',
			'meta_query'     => array(
				array(
					'key'     => '_prompt_id',
					'value'   => $term,
					'compare' => 'LIKE',
				),
			),
		)
	);

	$results = array();
	$seen_ids = array();

	foreach ( array( $title_results, $id_results ) as $q ) {
		if ( $q->have_posts() ) {
			while ( $q->have_posts() ) {
				$q->the_post();
				$post_id = get_the_ID();
				if ( in_array( $post_id, $seen_ids, true ) ) {
					continue;
				}
				$seen_ids[] = $post_id;
				$prompt_id  = get_post_meta( $post_id, '_prompt_id', true );
				$results[]  = array(
					'id'        => $post_id,
					'title'     => get_the_title(),
					'url'       => get_permalink(),
					'prompt_id' => $prompt_id,
					'type'      => get_post_type(),
					'thumb'     => get_the_post_thumbnail_url( $post_id, 'thumbnail' ),
				);
			}
		}
	}

	wp_reset_postdata();
	wp_send_json_success( $results );
}
add_action( 'wp_ajax_pixelmood_search', 'pixelmood_ajax_search' );
add_action( 'wp_ajax_nopriv_pixelmood_search', 'pixelmood_ajax_search' );
