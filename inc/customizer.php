<?php
/**
 * PixelMood Theme Customizer Settings
 *
 * @package PixelMood
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add Customizer settings and controls
 */
function pixelmood_customize_register( $wp_customize ) {

	// =========================================================
	// SECTION: Site Identity (extends default)
	// =========================================================
	$wp_customize->add_setting(
		'pixelmood_favicon',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'pixelmood_favicon',
			array(
				'label'    => __( 'Custom Favicon', 'pixelmood' ),
				'section'  => 'title_tagline',
				'settings' => 'pixelmood_favicon',
				'priority' => 15,
			)
		)
	);

	// =========================================================
	// SECTION: PixelMood Hero
	// =========================================================
	$wp_customize->add_section(
		'pixelmood_hero_section',
		array(
			'title'    => __( 'Hero Settings', 'pixelmood' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'pixelmood_hero_title',
		array(
			'default'           => 'PixelMood',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'pixelmood_hero_title',
		array(
			'label'   => __( 'Hero Title', 'pixelmood' ),
			'section' => 'pixelmood_hero_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'pixelmood_hero_subtitle',
		array(
			'default'           => 'Discover & Copy AI Image Prompts',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'pixelmood_hero_subtitle',
		array(
			'label'   => __( 'Hero Subtitle', 'pixelmood' ),
			'section' => 'pixelmood_hero_section',
			'type'    => 'text',
		)
	);

	// =========================================================
	// SECTION: PixelMood Colors
	// =========================================================
	$wp_customize->add_section(
		'pixelmood_colors_section',
		array(
			'title'    => __( 'PixelMood Colors', 'pixelmood' ),
			'priority' => 40,
		)
	);

	// Primary Color
	$wp_customize->add_setting(
		'pixelmood_primary_color',
		array(
			'default'           => '#FF6B01',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'pixelmood_primary_color',
			array(
				'label'   => __( 'Primary / Accent Color', 'pixelmood' ),
				'section' => 'pixelmood_colors_section',
			)
		)
	);

	// Background Color
	$wp_customize->add_setting(
		'pixelmood_bg_color',
		array(
			'default'           => '#212737',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'pixelmood_bg_color',
			array(
				'label'   => __( 'Background Color', 'pixelmood' ),
				'section' => 'pixelmood_colors_section',
			)
		)
	);

	// Text Color
	$wp_customize->add_setting(
		'pixelmood_text_color',
		array(
			'default'           => '#EAEDF3',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'pixelmood_text_color',
			array(
				'label'   => __( 'Text Color', 'pixelmood' ),
				'section' => 'pixelmood_colors_section',
			)
		)
	);

	// =========================================================
	// SECTION: PixelMood Typography
	// =========================================================
	$wp_customize->add_section(
		'pixelmood_typography_section',
		array(
			'title'    => __( 'PixelMood Typography', 'pixelmood' ),
			'priority' => 50,
		)
	);

	// Heading Font
	$wp_customize->add_setting(
		'pixelmood_heading_font',
		array(
			'default'           => 'IBM Plex Mono',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'pixelmood_heading_font',
		array(
			'label'       => __( 'Heading Font (Google Font name)', 'pixelmood' ),
			'description' => __( 'Enter exact Google Font name, e.g. "IBM Plex Mono"', 'pixelmood' ),
			'section'     => 'pixelmood_typography_section',
			'type'        => 'text',
		)
	);

	// Body Font
	$wp_customize->add_setting(
		'pixelmood_body_font',
		array(
			'default'           => 'IBM Plex Mono',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'pixelmood_body_font',
		array(
			'label'       => __( 'Body Font (Google Font name)', 'pixelmood' ),
			'description' => __( 'Enter exact Google Font name, e.g. "IBM Plex Mono"', 'pixelmood' ),
			'section'     => 'pixelmood_typography_section',
			'type'        => 'text',
		)
	);

	// =========================================================
	// SECTION: Footer
	// =========================================================
	$wp_customize->add_section(
		'pixelmood_footer_section',
		array(
			'title'    => __( 'Footer Settings', 'pixelmood' ),
			'priority' => 60,
		)
	);

	$wp_customize->add_setting(
		'pixelmood_footer_copyright',
		array(
			'default'           => '© ' . date( 'Y' ) . ' PixelMood. All rights reserved.',
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'pixelmood_footer_copyright',
		array(
			'label'   => __( 'Copyright Text', 'pixelmood' ),
			'section' => 'pixelmood_footer_section',
			'type'    => 'textarea',
		)
	);

	// Social Links
	$social_networks = array(
		'instagram' => 'Instagram URL',
		'twitter'   => 'Twitter / X URL',
		'pinterest' => 'Pinterest URL',
		'youtube'   => 'YouTube URL',
	);

	foreach ( $social_networks as $key => $label ) {
		$wp_customize->add_setting(
			'pixelmood_social_' . $key,
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			'pixelmood_social_' . $key,
			array(
				'label'   => __( $label, 'pixelmood' ),
				'section' => 'pixelmood_footer_section',
				'type'    => 'url',
			)
		);
	}
}
add_action( 'customize_register', 'pixelmood_customize_register' );

/**
 * Output dynamic CSS variables from Customizer settings
 */
function pixelmood_customizer_css() {
	$primary   = get_theme_mod( 'pixelmood_primary_color', '#FF6B01' );
	$bg        = get_theme_mod( 'pixelmood_bg_color', '#212737' );
	$text      = get_theme_mod( 'pixelmood_text_color', '#EAEDF3' );
	$head_font = get_theme_mod( 'pixelmood_heading_font', 'IBM Plex Mono' );
	$body_font = get_theme_mod( 'pixelmood_body_font', 'IBM Plex Mono' );

	// Enqueue Google Fonts dynamically if changed
	$fonts_to_load = array_unique( array( $head_font, $body_font ) );
	foreach ( $fonts_to_load as $font ) {
		$font_handle = 'pixelmood-custom-font-' . sanitize_title( $font );
		$font_url    = 'https://fonts.googleapis.com/css2?family=' . urlencode( $font ) . ':wght@300;400;500;600;700&display=swap';
		wp_enqueue_style( $font_handle, $font_url, array(), null );
	}

	?>
	<style id="pixelmood-customizer-css">
		:root {
			--pm-primary: <?php echo esc_attr( $primary ); ?>;
			--pm-bg: <?php echo esc_attr( $bg ); ?>;
			--pm-text: <?php echo esc_attr( $text ); ?>;
			--pm-font-heading: '<?php echo esc_attr( $head_font ); ?>', monospace, sans-serif;
			--pm-font-body: '<?php echo esc_attr( $body_font ); ?>', monospace, sans-serif;
		}
	</style>
	<?php
}
add_action( 'wp_head', 'pixelmood_customizer_css' );

/**
 * Output custom favicon from Customizer
 */
function pixelmood_custom_favicon() {
	$favicon = get_theme_mod( 'pixelmood_favicon', '' );
	if ( $favicon ) {
		echo '<link rel="shortcut icon" href="' . esc_url( $favicon ) . '" />\n';
	}
}
add_action( 'wp_head', 'pixelmood_custom_favicon' );
