<?php
/**
 * PixelMood Theme — header.php
 *
 * @package pixelmood
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'pixelmood' ); ?></a>

<header class="pm-site-header" id="masthead" role="banner">

	<div class="pm-header-inner">

		<!-- Logo -->
		<div class="pm-site-logo">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="pm-logo-text" rel="home">
					Pixel<span>Mood</span>
				</a>
			<?php endif; ?>
		</div>

		<!-- Desktop Primary Navigation -->
		<nav class="pm-nav-primary" id="site-navigation" role="navigation"
			aria-label="<?php esc_attr_e( 'Primary navigation', 'pixelmood' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'menu_id'        => 'primary-menu',
				'menu_class'     => 'pm-nav-list',
				'container'      => false,
				'fallback_cb'    => 'pixelmood_primary_nav_fallback',
			) );
			?>
		</nav>

		<!-- Header Search -->
		<form class="pm-header-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input
				type="search"
				name="s"
				class="pm-header-search__input"
				placeholder="<?php esc_attr_e( 'Search prompts...', 'pixelmood' ); ?>"
				value="<?php echo esc_attr( get_search_query() ); ?>"
				aria-label="<?php esc_attr_e( 'Search', 'pixelmood' ); ?>"
			>
			<input type="hidden" name="post_type" value="prompt">
			<button type="submit" class="pm-header-search__btn" aria-label="<?php esc_attr_e( 'Search', 'pixelmood' ); ?>">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
					<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
				</svg>
			</button>
		</form>

		<!-- Mobile Toggle -->
		<button
			class="pm-nav-toggle"
			id="pm-nav-toggle"
			aria-controls="pm-mobile-nav"
			aria-expanded="false"
			aria-label="<?php esc_attr_e( 'Toggle menu', 'pixelmood' ); ?>"
		>
			<span class="pm-hamburger">
				<span></span><span></span><span></span>
			</span>
		</button>

	</div><!-- .pm-header-inner -->

</header><!-- #masthead -->

<!-- Mobile Navigation Drawer -->
<div class="pm-mobile-nav" id="pm-mobile-nav" aria-hidden="true" role="dialog" aria-label="<?php esc_attr_e( 'Mobile menu', 'pixelmood' ); ?>">
	<div class="pm-mobile-nav__inner">
		<button class="pm-mobile-nav__close" id="pm-mobile-nav-close" aria-label="<?php esc_attr_e( 'Close menu', 'pixelmood' ); ?>">
			<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
				<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
			</svg>
		</button>
		<?php
		wp_nav_menu( array(
			'theme_location' => 'mobile',
			'menu_id'        => 'mobile-menu',
			'menu_class'     => 'pm-mobile-nav__list',
			'container'      => false,
			'fallback_cb'    => 'pixelmood_primary_nav_fallback',
		) );
		?>
		<form class="pm-mobile-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="search" name="s" placeholder="<?php esc_attr_e( 'Search prompts...', 'pixelmood' ); ?>" aria-label="<?php esc_attr_e( 'Search', 'pixelmood' ); ?>">
			<input type="hidden" name="post_type" value="prompt">
			<button type="submit" aria-label="<?php esc_attr_e( 'Search', 'pixelmood' ); ?>">&#x2315;</button>
		</form>
	</div>
</div>
<div class="pm-mobile-overlay" id="pm-mobile-overlay" aria-hidden="true"></div>

<?php
if ( ! function_exists( 'pixelmood_primary_nav_fallback' ) ) {
	function pixelmood_primary_nav_fallback() {
		$archive = get_post_type_archive_link( 'prompt' );
		echo '<ul class="pm-nav-list">';
		echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'pixelmood' ) . '</a></li>';
		if ( $archive ) {
			echo '<li><a href="' . esc_url( $archive ) . '">' . esc_html__( 'Prompts', 'pixelmood' ) . '</a></li>';
		}
		echo '<li><a href="' . esc_url( home_url( '/blog/' ) ) . '">' . esc_html__( 'Blog', 'pixelmood' ) . '</a></li>';
		echo '</ul>';
	}
}
?>
