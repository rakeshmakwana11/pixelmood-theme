<?php
/**
 * PixelMood — template-functions.php
 * Reusable template helpers.
 */
defined( 'ABSPATH' ) || exit;

/**
 * Render the PixelMood site header.
 */
function pixelmood_header() {
	$logo_id  = get_theme_mod( 'custom_logo' );
	$logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : '';
	$hero_title = get_theme_mod( 'pm_hero_title', 'PixelMood' );
	?>
	<header class="pm-site-header" role="banner">
		<div class="pm-site-logo">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php if ( $logo_url ) : ?>
					<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?>" height="36" loading="lazy" />
				<?php else : ?>
					<svg width="28" height="28" viewBox="0 0 28 28" fill="none" aria-hidden="true">
						<rect width="28" height="28" rx="6" fill="#FF6B01"/>
						<rect x="6" y="6" width="7" height="7" rx="1.5" fill="#fff"/>
						<rect x="15" y="6" width="7" height="7" rx="1.5" fill="#fff" opacity=".6"/>
						<rect x="6" y="15" width="7" height="7" rx="1.5" fill="#fff" opacity=".6"/>
						<rect x="15" y="15" width="7" height="7" rx="1.5" fill="#FF6B01" stroke="#fff" stroke-width="1.5"/>
					</svg>
					<span>Pixel<span>Mood</span></span>
				<?php endif; ?>
			</a>
		</div>

		<nav class="pm-nav-primary" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'pixelmood' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'fallback_cb'    => 'pixelmood_default_menu',
			) );
			?>
		</nav>

		<button
			class="pm-nav-toggle"
			aria-expanded="false"
			aria-controls="pm-mobile-nav"
			aria-label="<?php esc_attr_e( 'Toggle Menu', 'pixelmood' ); ?>"
		>&#9776;</button>
	</header>

	<nav class="pm-mobile-nav" id="pm-mobile-nav" aria-label="<?php esc_attr_e( 'Mobile Menu', 'pixelmood' ); ?>">
		<?php
		wp_nav_menu( array(
			'theme_location' => 'primary',
			'container'      => false,
			'fallback_cb'    => 'pixelmood_default_menu',
		) );
		?>
	</nav>
	<?php
}

/**
 * Fallback menu if no menu is assigned.
 */
function pixelmood_default_menu() {
	?>
	<ul>
		<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'pixelmood' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/prompts/' ) ); ?>"><?php esc_html_e( 'Prompts', 'pixelmood' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Blog', 'pixelmood' ); ?></a></li>
	</ul>
	<?php
}

/**
 * Render PixelMood site footer.
 */
function pixelmood_footer() {
	$year  = date( 'Y' );
	$name  = get_bloginfo( 'name' );
	$insta = get_theme_mod( 'pm_social_instagram', '' );
	$tw    = get_theme_mod( 'pm_social_twitter', '' );
	$yt    = get_theme_mod( 'pm_social_youtube', '' );
	?>
	<footer class="pm-site-footer" role="contentinfo">
		<div class="pm-footer-inner">
			<div>
				<a class="pm-footer-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">Pixel<span>Mood</span></a>
				<p class="pm-footer-tagline"><?php esc_html_e( 'AI Image Prompt Library', 'pixelmood' ); ?></p>

				<?php if ( $insta || $tw || $yt ) : ?>
					<div class="pm-social-links">
						<?php if ( $insta ) : ?><a href="<?php echo esc_url( $insta ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">&#x1F4F7;</a><?php endif; ?>
						<?php if ( $tw ) : ?><a href="<?php echo esc_url( $tw ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Twitter">&#x1D54F;</a><?php endif; ?>
						<?php if ( $yt ) : ?><a href="<?php echo esc_url( $yt ); ?>" target="_blank" rel="noopener noreferrer" aria-label="YouTube">&#x25B6;</a><?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

			<nav class="pm-footer-menu" aria-label="<?php esc_attr_e( 'Footer Menu', 'pixelmood' ); ?>">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'container'      => false,
					'fallback_cb'    => false,
					'depth'          => 1,
				) );
				?>
			</nav>
		</div>

		<div class="pm-footer-bottom">
			<p class="pm-copyright">&copy; <?php echo esc_html( $year ); ?> <?php echo esc_html( $name ); ?>. <?php esc_html_e( 'All rights reserved.', 'pixelmood' ); ?></p>
		</div>
	</footer>
	<?php
}

/**
 * Render category filter pills for prompts archive/home.
 */
function pixelmood_category_filters( $current_slug = '' ) {
	$cats = get_terms( array(
		'taxonomy'   => 'prompt_category',
		'hide_empty' => true,
	) );

	echo '<div class="pm-cat-filters">';
	echo '<a href="' . esc_url( get_post_type_archive_link( 'prompt' ) ) . '">' . esc_html__( 'All', 'pixelmood' ) . '</a>';

	if ( $cats && ! is_wp_error( $cats ) ) {
		foreach ( $cats as $cat ) {
			$active = ( $current_slug === $cat->slug ) ? ' is-active' : '';
			echo '<a class="' . esc_attr( trim( $active ) ) . '" href="' . esc_url( get_term_link( $cat ) ) . '">' . esc_html( $cat->name ) . '</a>';
		}
	}
	echo '</div>';
}

/**
 * Render a search bar for prompts.
 */
function pixelmood_search_bar( $placeholder = '' ) {
	if ( ! $placeholder ) $placeholder = __( 'Search prompts, tags, categories or Prompt ID...', 'pixelmood' );
	$s = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : '';
	?>
	<div class="pm-search-wrap">
		<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input
				type="search"
				name="s"
				value="<?php echo esc_attr( $s ); ?>"
				placeholder="<?php echo esc_attr( $placeholder ); ?>"
				aria-label="<?php echo esc_attr( $placeholder ); ?>"
				autocomplete="off"
			/>
			<input type="hidden" name="post_type" value="prompt" />
			<button type="submit"><?php esc_html_e( 'Search', 'pixelmood' ); ?></button>
		</form>
	</div>
	<?php
}

/**
 * Render related prompts section.
 */
function pixelmood_related_prompts( $post_id, $count = 6 ) {
	$cats = wp_get_post_terms( $post_id, 'prompt_category', array( 'fields' => 'ids' ) );
	$tags = wp_get_post_terms( $post_id, 'prompt_tag', array( 'fields' => 'ids' ) );

	if ( empty( $cats ) && empty( $tags ) ) return;

	$tax_query = array( 'relation' => 'OR' );
	if ( ! empty( $cats ) ) {
		$tax_query[] = array(
			'taxonomy' => 'prompt_category',
			'field'    => 'term_id',
			'terms'    => $cats,
		);
	}
	if ( ! empty( $tags ) ) {
		$tax_query[] = array(
			'taxonomy' => 'prompt_tag',
			'field'    => 'term_id',
			'terms'    => $tags,
		);
	}

	$related = new WP_Query( array(
		'post_type'      => 'prompt',
		'posts_per_page' => $count,
		'post__not_in'   => array( $post_id ),
		'tax_query'      => $tax_query,
		'orderby'        => 'rand',
		'no_found_rows'  => true,
	) );

	if ( ! $related->have_posts() ) return;

	echo '<section class="pm-related">';
	echo '<h2 class="pm-section-title">' . esc_html__( 'Related Prompts', 'pixelmood' ) . '</h2>';
	echo '<div class="pm-prompt-grid">';
	while ( $related->have_posts() ) {
		$related->the_post();
		pixelmood_render_card( get_the_ID() );
	}
	wp_reset_postdata();
	echo '</div></section>';
}
