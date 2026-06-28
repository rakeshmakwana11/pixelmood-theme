<?php
/**
 * PixelMood Child Theme — functions.php
 *
 * All custom functionality for the PixelMood AI Prompt Library.
 * This file is loaded AFTER the parent theme's functions.php.
 */

defined( 'ABSPATH' ) || exit;

// ============================================================
// 1. ENQUEUE STYLES & SCRIPTS
// ============================================================
add_action( 'wp_enqueue_scripts', 'pixelmood_enqueue' );
function pixelmood_enqueue() {
	// Parent theme stylesheet
	wp_enqueue_style(
		'parent-style',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( get_template() )->get( 'Version' )
	);

	// Child / PixelMood stylesheet
	wp_enqueue_style(
		'pixelmood-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'parent-style' ),
		wp_get_theme()->get( 'Version' )
	);

	// IBM Plex Mono from Google Fonts
	wp_enqueue_style(
		'pixelmood-fonts',
		'https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap',
		array(),
		null
	);

	// Main JS
	wp_enqueue_script(
		'pixelmood-main',
		get_stylesheet_directory_uri() . '/js/main.js',
		array( 'jquery' ),
		wp_get_theme()->get( 'Version' ),
		true
	);

	// Pass AJAX URL & nonce to JS
	wp_localize_script(
		'pixelmood-main',
		'PixelMood',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'pixelmood_nonce' ),
		)
	);
}

// ============================================================
// 2. BODY CLASS — add class to scope styles
// ============================================================
add_filter( 'body_class', 'pixelmood_body_class' );
function pixelmood_body_class( $classes ) {
	$classes[] = 'pixelmood-active';
	return $classes;
}

// ============================================================
// 3. CUSTOM POST TYPE — Prompts
// ============================================================
add_action( 'init', 'pixelmood_register_cpt', 0 );
function pixelmood_register_cpt() {
	$labels = array(
		'name'                  => _x( 'Prompts', 'Post type general name', 'pixelmood' ),
		'singular_name'         => _x( 'Prompt', 'Post type singular name', 'pixelmood' ),
		'menu_name'             => _x( 'Prompts', 'Admin Menu text', 'pixelmood' ),
		'name_admin_bar'        => _x( 'Prompt', 'Add New on Toolbar', 'pixelmood' ),
		'add_new'               => __( 'Add New', 'pixelmood' ),
		'add_new_item'          => __( 'Add New Prompt', 'pixelmood' ),
		'new_item'              => __( 'New Prompt', 'pixelmood' ),
		'edit_item'             => __( 'Edit Prompt', 'pixelmood' ),
		'view_item'             => __( 'View Prompt', 'pixelmood' ),
		'all_items'             => __( 'All Prompts', 'pixelmood' ),
		'search_items'          => __( 'Search Prompts', 'pixelmood' ),
		'not_found'             => __( 'No Prompts found.', 'pixelmood' ),
		'not_found_in_trash'    => __( 'No Prompts found in Trash.', 'pixelmood' ),
		'featured_image'        => _x( 'Prompt Cover Image', 'Overrides the "Featured Image" phrase', 'pixelmood' ),
		'set_featured_image'    => _x( 'Set cover image', 'Overrides the "Set featured image" phrase', 'pixelmood' ),
		'remove_featured_image' => _x( 'Remove cover image', 'Overrides the "Remove featured image" phrase', 'pixelmood' ),
		'use_featured_image'    => _x( 'Use as cover image', 'Overrides the "Use as featured image" phrase', 'pixelmood' ),
		'archives'              => _x( 'Prompt archives', 'The post type archive label used in nav menus', 'pixelmood' ),
		'insert_into_item'      => _x( 'Insert into prompt', 'Overrides the "Insert into post" phrase', 'pixelmood' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this prompt', 'Overrides the "Uploaded to this post" phrase', 'pixelmood' ),
		'items_list'            => _x( 'Prompts list', 'Screen reader text for the items list', 'pixelmood' ),
		'items_list_navigation' => _x( 'Prompts list navigation', 'Screen reader text for the items list navigation', 'pixelmood' ),
		'filter_items_list'     => _x( 'Filter prompts list', 'Screen reader text for the filter links heading on the post type listing screen', 'pixelmood' ),
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'AI Image Prompts for PixelMood.', 'pixelmood' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'prompt', 'with_front' => false ),
		'capability_type'    => 'post',
		'has_archive'        => 'prompts',
		'hierarchical'       => false,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-art',
		'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'revisions' ),
		'show_in_rest'       => true,
		'taxonomies'         => array( 'prompt_category', 'prompt_tag' ),
	);

	register_post_type( 'prompt', $args );
}

// ============================================================
// 4. CUSTOM TAXONOMIES — Prompt Category & Prompt Tag
// ============================================================
add_action( 'init', 'pixelmood_register_taxonomies', 0 );
function pixelmood_register_taxonomies() {

	// Prompt Category
	register_taxonomy(
		'prompt_category',
		'prompt',
		array(
			'hierarchical'      => true,
			'labels'            => array(
				'name'              => _x( 'Prompt Categories', 'taxonomy general name', 'pixelmood' ),
				'singular_name'     => _x( 'Prompt Category', 'taxonomy singular name', 'pixelmood' ),
				'search_items'      => __( 'Search Prompt Categories', 'pixelmood' ),
				'all_items'         => __( 'All Prompt Categories', 'pixelmood' ),
				'parent_item'       => __( 'Parent Category', 'pixelmood' ),
				'parent_item_colon' => __( 'Parent Category:', 'pixelmood' ),
				'edit_item'         => __( 'Edit Category', 'pixelmood' ),
				'update_item'       => __( 'Update Category', 'pixelmood' ),
				'add_new_item'      => __( 'Add New Category', 'pixelmood' ),
				'new_item_name'     => __( 'New Category Name', 'pixelmood' ),
				'menu_name'         => __( 'Categories', 'pixelmood' ),
			),
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'prompt-category' ),
			'show_in_rest'      => true,
		)
	);

	// Prompt Tag
	register_taxonomy(
		'prompt_tag',
		'prompt',
		array(
			'hierarchical'      => false,
			'labels'            => array(
				'name'              => _x( 'Prompt Tags', 'taxonomy general name', 'pixelmood' ),
				'singular_name'     => _x( 'Prompt Tag', 'taxonomy singular name', 'pixelmood' ),
				'search_items'      => __( 'Search Prompt Tags', 'pixelmood' ),
				'all_items'         => __( 'All Prompt Tags', 'pixelmood' ),
				'edit_item'         => __( 'Edit Tag', 'pixelmood' ),
				'update_item'       => __( 'Update Tag', 'pixelmood' ),
				'add_new_item'      => __( 'Add New Tag', 'pixelmood' ),
				'new_item_name'     => __( 'New Tag Name', 'pixelmood' ),
				'menu_name'         => __( 'Tags', 'pixelmood' ),
			),
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'prompt-tag' ),
			'show_in_rest'      => true,
		)
	);
}

// ============================================================
// 5. FLUSH REWRITE RULES ON ACTIVATION
// ============================================================
register_activation_hook( __FILE__, 'pixelmood_flush_rewrites' );
function pixelmood_flush_rewrites() {
	pixelmood_register_cpt();
	pixelmood_register_taxonomies();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'pixelmood_flush_rewrites' );

// ============================================================
// 6. CUSTOM META BOX — Prompt ID
// ============================================================
add_action( 'add_meta_boxes', 'pixelmood_meta_boxes' );
function pixelmood_meta_boxes() {
	add_meta_box(
		'pixelmood_prompt_id',
		__( 'Prompt ID', 'pixelmood' ),
		'pixelmood_prompt_id_cb',
		'prompt',
		'side',
		'high'
	);
}

function pixelmood_prompt_id_cb( $post ) {
	wp_nonce_field( 'pixelmood_save_prompt_id', 'pixelmood_nonce' );
	$value = get_post_meta( $post->ID, '_prompt_id', true );
	echo '<label for="pixelmood_prompt_id_field"><strong>' . esc_html__( 'Prompt ID (e.g. PM1001)', 'pixelmood' ) . '</strong></label>';
	echo '<input type="text" id="pixelmood_prompt_id_field" name="pixelmood_prompt_id" value="' . esc_attr( $value ) . '" class="widefat" placeholder="PM1001" style="margin-top:6px;" />';
	echo '<p class="description">' . esc_html__( 'Unique identifier shown on cards and single pages. Not used in URL.', 'pixelmood' ) . '</p>';
}

add_action( 'save_post_prompt', 'pixelmood_save_prompt_id' );
function pixelmood_save_prompt_id( $post_id ) {
	if ( ! isset( $_POST['pixelmood_nonce'] ) ) return;
	if ( ! wp_verify_nonce( $_POST['pixelmood_nonce'], 'pixelmood_save_prompt_id' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	if ( isset( $_POST['pixelmood_prompt_id'] ) ) {
		$val = sanitize_text_field( strtoupper( $_POST['pixelmood_prompt_id'] ) );
		update_post_meta( $post_id, '_prompt_id', $val );
	}
}

// ============================================================
// 7. EXTEND SEARCH: Prompt ID, categories, tags
// ============================================================
add_filter( 'posts_search', 'pixelmood_extend_search', 10, 2 );
function pixelmood_extend_search( $search, $query ) {
	if ( ! $query->is_search() || is_admin() ) return $search;

	global $wpdb;
	$term = $query->get( 's' );
	if ( empty( $term ) ) return $search;

	$like = '%' . $wpdb->esc_like( $term ) . '%';

	// Check if any prompts have this as a Prompt ID
	$meta_ids = $wpdb->get_col(
		$wpdb->prepare(
			"SELECT post_id FROM {$wpdb->postmeta}
			WHERE meta_key = '_prompt_id'
			AND meta_value LIKE %s",
			$like
		)
	);

	if ( ! empty( $meta_ids ) ) {
		$ids_in = implode( ',', array_map( 'intval', $meta_ids ) );
		$search .= " OR {$wpdb->posts}.ID IN ({$ids_in})";
	}

	return $search;
}

add_action( 'pre_get_posts', 'pixelmood_search_query' );
function pixelmood_search_query( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) return;

	// Include prompts in front-end search
	if ( $query->is_search() ) {
		$post_types = $query->get( 'post_type' );
		if ( empty( $post_types ) || 'post' === $post_types ) {
			$query->set( 'post_type', array( 'post', 'prompt' ) );
		}
	}
}

// ============================================================
// 8. REGISTER NAV MENUS
// ============================================================
add_action( 'after_setup_theme', 'pixelmood_register_menus' );
function pixelmood_register_menus() {
	register_nav_menus(
		array(
			'primary'  => __( 'Primary Menu', 'pixelmood' ),
			'mobile'   => __( 'Mobile Menu', 'pixelmood' ),
			'footer'   => __( 'Footer Menu', 'pixelmood' ),
		)
	);
}

// ============================================================
// 9. THEME SUPPORTS
// ============================================================
add_action( 'after_setup_theme', 'pixelmood_theme_setup' );
function pixelmood_theme_setup() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array(
		'height'      => 60,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'custom-header' );
	add_theme_support( 'custom-background' );
	add_theme_support( 'align-wide' );
	add_image_size( 'prompt-card', 600, 340, true );
	add_image_size( 'prompt-single', 1200, 675, true );
}

// ============================================================
// 10. THEME CUSTOMIZER
// ============================================================
add_action( 'customize_register', 'pixelmood_customize_register' );
function pixelmood_customize_register( $wp_customize ) {

	/* ---- Panel ---- */
	$wp_customize->add_panel( 'pixelmood_panel', array(
		'title'    => __( 'PixelMood Settings', 'pixelmood' ),
		'priority' => 10,
	) );

	/* ---- Section: Branding ---- */
	$wp_customize->add_section( 'pixelmood_branding', array(
		'title'    => __( 'Branding', 'pixelmood' ),
		'panel'    => 'pixelmood_panel',
		'priority' => 10,
	) );

	// Hero Title
	$wp_customize->add_setting( 'pm_hero_title', array(
		'default'           => 'PixelMood',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'pm_hero_title', array(
		'label'   => __( 'Hero Title', 'pixelmood' ),
		'section' => 'pixelmood_branding',
		'type'    => 'text',
	) );

	/* ---- Section: Colors ---- */
	$wp_customize->add_section( 'pixelmood_colors', array(
		'title'    => __( 'Colors', 'pixelmood' ),
		'panel'    => 'pixelmood_panel',
		'priority' => 20,
	) );

	$color_settings = array(
		'pm_color_bg'      => array( 'default' => '#212737', 'label' => __( 'Background Color', 'pixelmood' ) ),
		'pm_color_primary' => array( 'default' => '#FF6B01', 'label' => __( 'Primary Accent Color', 'pixelmood' ) ),
		'pm_color_text'    => array( 'default' => '#EAEDF3', 'label' => __( 'Text Color', 'pixelmood' ) ),
	);

	foreach ( $color_settings as $id => $args ) {
		$wp_customize->add_setting( $id, array(
			'default'           => $args['default'],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			$id,
			array(
				'label'   => $args['label'],
				'section' => 'pixelmood_colors',
			)
		) );
	}

	/* ---- Section: Typography ---- */
	$wp_customize->add_section( 'pixelmood_typography', array(
		'title'    => __( 'Typography', 'pixelmood' ),
		'panel'    => 'pixelmood_panel',
		'priority' => 30,
	) );

	$font_choices = array(
		'IBM Plex Mono'    => 'IBM Plex Mono',
		'Inter'            => 'Inter',
		'JetBrains Mono'   => 'JetBrains Mono',
		'Space Mono'       => 'Space Mono',
		'Fira Code'        => 'Fira Code',
		'Source Code Pro'  => 'Source Code Pro',
		'Roboto Mono'      => 'Roboto Mono',
	);

	$wp_customize->add_setting( 'pm_font_heading', array(
		'default'           => 'IBM Plex Mono',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'pm_font_heading', array(
		'label'   => __( 'Heading Font', 'pixelmood' ),
		'section' => 'pixelmood_typography',
		'type'    => 'select',
		'choices' => $font_choices,
	) );

	$wp_customize->add_setting( 'pm_font_body', array(
		'default'           => 'IBM Plex Mono',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'pm_font_body', array(
		'label'   => __( 'Body Font', 'pixelmood' ),
		'section' => 'pixelmood_typography',
		'type'    => 'select',
		'choices' => $font_choices,
	) );

	/* ---- Section: Social Links ---- */
	$wp_customize->add_section( 'pixelmood_social', array(
		'title'    => __( 'Social Links', 'pixelmood' ),
		'panel'    => 'pixelmood_panel',
		'priority' => 40,
	) );

	$socials = array(
		'pm_social_instagram' => 'Instagram URL',
		'pm_social_twitter'   => 'Twitter / X URL',
		'pm_social_youtube'   => 'YouTube URL',
	);

	foreach ( $socials as $id => $label ) {
		$wp_customize->add_setting( $id, array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( $id, array(
			'label'   => __( $label, 'pixelmood' ),
			'section' => 'pixelmood_social',
			'type'    => 'url',
		) );
	}
}

// ============================================================
// 11. OUTPUT CUSTOMIZER CSS (dynamic)
// ============================================================
add_action( 'wp_head', 'pixelmood_customizer_css', 99 );
function pixelmood_customizer_css() {
	$bg      = get_theme_mod( 'pm_color_bg',      '#212737' );
	$primary = get_theme_mod( 'pm_color_primary', '#FF6B01' );
	$text    = get_theme_mod( 'pm_color_text',    '#EAEDF3' );
	$font_h  = get_theme_mod( 'pm_font_heading',  'IBM Plex Mono' );
	$font_b  = get_theme_mod( 'pm_font_body',     'IBM Plex Mono' );

	// Build font URL for non-default fonts
	$google_fonts = array( 'Inter', 'JetBrains Mono', 'Space Mono', 'Fira Code', 'Source Code Pro', 'Roboto Mono' );
	$fonts_to_load = array_unique( array_filter( array( $font_h, $font_b ) ) );
	$gf_load = array_intersect( $fonts_to_load, $google_fonts );
	if ( ! empty( $gf_load ) ) {
		$font_query = implode( '|', array_map( function( $f ) { return urlencode( $f ) . ':wght@400;700'; }, $gf_load ) );
		echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
		echo '<link href="https://fonts.googleapis.com/css2?family=' . esc_attr( $font_query ) . '&display=swap" rel="stylesheet">';
	}

	echo '<style id="pixelmood-customizer-css">';
	echo ':root {';
	echo '--pm-bg: ' . sanitize_hex_color( $bg ) . ';';
	echo '--pm-primary: ' . sanitize_hex_color( $primary ) . ';';
	echo '--pm-text: ' . sanitize_hex_color( $text ) . ';';
	echo '--pm-font-body: "' . esc_attr( $font_b ) . '", monospace;';
	echo '--pm-font-heading: "' . esc_attr( $font_h ) . '", monospace;';
	echo '}';
	echo '</style>';
}

// ============================================================
// 12. HELPER: Get Prompt ID
// ============================================================
function pixelmood_get_prompt_id( $post_id = null ) {
	if ( ! $post_id ) $post_id = get_the_ID();
	return get_post_meta( $post_id, '_prompt_id', true );
}

// ============================================================
// 13. HELPER: Render Prompt Card
// ============================================================
function pixelmood_render_card( $post_id ) {
	$post = get_post( $post_id );
	if ( ! $post ) return;

	$prompt_id   = pixelmood_get_prompt_id( $post_id );
	$permalink   = get_permalink( $post_id );
	$title       = get_the_title( $post_id );
	$excerpt     = get_the_excerpt( $post_id );
	$content     = apply_filters( 'the_content', $post->post_content );
	$categories  = get_the_terms( $post_id, 'prompt_category' );
	$tags        = get_the_terms( $post_id, 'prompt_tag' );
	$thumb_id    = get_post_thumbnail_id( $post_id );

	?>
	<article class="pm-card" data-post-id="<?php echo esc_attr( $post_id ); ?>">
		<a href="<?php echo esc_url( $permalink ); ?>" class="pm-card__link" aria-label="<?php echo esc_attr( $title ); ?>"></a>

		<?php if ( $thumb_id ) : ?>
			<img
				class="pm-card__image"
				src="<?php echo esc_url( wp_get_attachment_image_url( $thumb_id, 'prompt-card' ) ); ?>"
				alt="<?php echo esc_attr( $title ); ?>"
				loading="lazy"
				width="600" height="340"
			/>
		<?php else : ?>
			<div class="pm-card__image-placeholder" aria-hidden="true">&#9787;</div>
		<?php endif; ?>

		<div class="pm-card__body">
			<div class="pm-card__meta">
				<?php if ( $prompt_id ) : ?>
					<span class="pm-card__id"><?php echo esc_html( $prompt_id ); ?></span>
				<?php endif; ?>
				<?php if ( $categories && ! is_wp_error( $categories ) ) : ?>
					<a
						class="pm-card__category"
						href="<?php echo esc_url( get_term_link( $categories[0] ) ); ?>"
					><?php echo esc_html( $categories[0]->name ); ?></a>
				<?php endif; ?>
			</div>

			<h3 class="pm-card__title"><?php echo esc_html( $title ); ?></h3>

			<?php if ( $excerpt ) : ?>
				<p class="pm-card__excerpt"><?php echo esc_html( $excerpt ); ?></p>
			<?php endif; ?>

			<?php if ( $tags && ! is_wp_error( $tags ) ) : ?>
				<div class="pm-card__tags">
					<?php foreach ( array_slice( $tags, 0, 4 ) as $tag ) : ?>
						<a
							class="pm-card__tag"
							href="<?php echo esc_url( get_term_link( $tag ) ); ?>"
						>#<?php echo esc_html( $tag->name ); ?></a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<div class="pm-card__actions">
				<button
					class="pm-btn pm-btn--ghost pm-btn--sm pm-copy-btn"
					data-content="<?php echo esc_attr( wp_strip_all_tags( $post->post_content ) ); ?>"
					aria-label="<?php esc_attr_e( 'Copy Prompt', 'pixelmood' ); ?>"
				>&#x2398; <?php esc_html_e( 'Copy', 'pixelmood' ); ?></button>
				<a
					class="pm-btn pm-btn--primary pm-btn--sm"
					href="<?php echo esc_url( $permalink ); ?>"
				><?php esc_html_e( 'View Prompt', 'pixelmood' ); ?> &rarr;</a>
			</div>
		</div>
	</article>
	<?php
}

// ============================================================
// 14. WIDGET AREA
// ============================================================
add_action( 'widgets_init', 'pixelmood_widgets_init' );
function pixelmood_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'PixelMood Sidebar', 'pixelmood' ),
		'id'            => 'pixelmood-sidebar',
		'description'   => __( 'Add widgets here.', 'pixelmood' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}

// ============================================================
// 15. SEO — custom meta for prompts
// ============================================================
add_action( 'wp_head', 'pixelmood_seo_meta', 5 );
function pixelmood_seo_meta() {
	if ( ! is_singular( 'prompt' ) ) return;
	$post      = get_post();
	$prompt_id = pixelmood_get_prompt_id();
	$cats      = get_the_terms( $post->ID, 'prompt_category' );
	$tags      = get_the_terms( $post->ID, 'prompt_tag' );

	$desc = $post->post_excerpt ? $post->post_excerpt : wp_trim_words( $post->post_content, 25 );
	$kw_parts = array();
	if ( $prompt_id ) $kw_parts[] = $prompt_id;
	if ( $cats && ! is_wp_error( $cats ) ) $kw_parts = array_merge( $kw_parts, wp_list_pluck( $cats, 'name' ) );
	if ( $tags && ! is_wp_error( $tags ) ) $kw_parts = array_merge( $kw_parts, wp_list_pluck( $tags, 'name' ) );

	echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
	echo '<meta name="keywords" content="' . esc_attr( implode( ', ', $kw_parts ) ) . '">' . "\n";

	// Open Graph
	$thumb = get_the_post_thumbnail_url( $post->ID, 'large' );
	if ( $thumb ) {
		echo '<meta property="og:image" content="' . esc_url( $thumb ) . '">' . "\n";
	}
	echo '<meta property="og:title" content="' . esc_attr( get_the_title() ) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
	echo '<meta property="og:type" content="article">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( get_permalink() ) . '">' . "\n";
}

// ============================================================
// 16. AJAX: Auto-generate Prompt ID for new posts
// ============================================================
add_action( 'wp_ajax_pixelmood_generate_id', 'pixelmood_ajax_generate_id' );
function pixelmood_ajax_generate_id() {
	check_ajax_referer( 'pixelmood_nonce', 'nonce' );
	if ( ! current_user_can( 'edit_posts' ) ) wp_die( '-1' );

	global $wpdb;
	$max = $wpdb->get_var(
		"SELECT meta_value FROM {$wpdb->postmeta}
		WHERE meta_key = '_prompt_id'
		ORDER BY CAST(SUBSTRING(meta_value, 3) AS UNSIGNED) DESC
		LIMIT 1"
	);

	$next_num = 1001;
	if ( $max && preg_match( '/PM(\d+)/', $max, $m ) ) {
		$next_num = (int) $m[1] + 1;
	}

	wp_send_json_success( array( 'id' => 'PM' . $next_num ) );
}

// ============================================================
// 17. ADMIN: Auto-suggest Prompt ID on post edit screen
// ============================================================
add_action( 'admin_footer-post.php', 'pixelmood_admin_js' );
add_action( 'admin_footer-post-new.php', 'pixelmood_admin_js' );
function pixelmood_admin_js() {
	$screen = get_current_screen();
	if ( ! $screen || 'prompt' !== $screen->post_type ) return;
	?>
	<script>
	(function($){
		$(function(){
			var $field = $('#pixelmood_prompt_id_field');
			if ( $field.length && ! $field.val() ) {
				$.post( ajaxurl, {
					action: 'pixelmood_generate_id',
					nonce: '<?php echo wp_create_nonce( 'pixelmood_nonce' ); ?>'
				}, function(r){ if(r.success) $field.val(r.data.id); });
			}
		});
	})(jQuery);
	</script>
	<?php
}
