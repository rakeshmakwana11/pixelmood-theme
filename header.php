<?php
/**
 * PixelMood Theme - header.php
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

<header class="pm-site-header" id="masthead">
	<div class="pm-header-inner">

		<div class="pm-site-logo">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a class="pm-logo-text" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					Pixel<span>Mood</span>
				</a>
			<?php endif; ?>
		</div>

		<nav class="pm-nav-primary" id="site-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'pixelmood' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'menu_id'        => 'primary-menu',
				'container'      => false,
				'fallback_cb'    => '__return_false',
			) );
			?>
		</nav>

		<div class="pm-header-actions">
			<a href="<?php echo esc_url( get_post_type_archive_link( 'prompt' ) ); ?>" class="pm-btn pm-btn--ghost pm-btn--sm">
				<?php esc_html_e( 'Browse Prompts', 'pixelmood' ); ?>
			</a>
			<button class="pm-nav-toggle" id="pm-nav-toggle" aria-controls="pm-mobile-nav" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle Menu', 'pixelmood' ); ?>">
				<span class="pm-hamburger">
					<span></span>
					<span></span>
					<span></span>
				</span>
			</button>
		</div>

	</div>
</header>

<div class="pm-mobile-nav" id="pm-mobile-nav" aria-hidden="true">
	<div class="pm-mobile-nav-inner">
		<?php
		wp_nav_menu( array(
			'theme_location' => 'mobile',
			'menu_id'        => 'mobile-menu',
			'container'      => false,
			'fallback_cb'    => '__return_false',
		) );
		?>
		<div class="pm-mobile-nav-footer">
			<a href="<?php echo esc_url( get_post_type_archive_link( 'prompt' ) ); ?>" class="pm-btn pm-btn--primary pm-btn--full">
				<?php esc_html_e( 'Browse All Prompts', 'pixelmood' ); ?>
			</a>
		</div>
	</div>
</div>
<div class="pm-mobile-overlay" id="pm-mobile-overlay"></div>

<div id="main" class="pm-site-main">
