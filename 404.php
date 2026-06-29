<?php
/**
 * PixelMood Theme - 404.php
 * Not Found page.
 * @package pixelmood
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<div class="pm-container pm-404-page">
	<div class="pm-404-inner">
		<div class="pm-404-code">404</div>
		<h1 class="pm-404-title"><?php esc_html_e( 'Page Not Found', 'pixelmood' ); ?></h1>
		<p class="pm-404-text"><?php esc_html_e( "Oops! The page you're looking for doesn't exist or has been moved.", 'pixelmood' ); ?></p>

		<form class="pm-search-form pm-404-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<div class="pm-search-wrap">
				<svg class="pm-search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
				<input type="search" class="pm-search-input" name="s" placeholder="<?php esc_attr_e( 'Search prompts...', 'pixelmood' ); ?>" autocomplete="off">
				<button type="submit" class="pm-btn pm-btn--primary"><?php esc_html_e( 'Search', 'pixelmood' ); ?></button>
			</div>
		</form>

		<div class="pm-404-links">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="pm-btn pm-btn--primary">
				<?php esc_html_e( 'Go Home', 'pixelmood' ); ?>
			</a>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'prompt' ) ); ?>" class="pm-btn pm-btn--ghost">
				<?php esc_html_e( 'Browse Prompts', 'pixelmood' ); ?>
			</a>
		</div>
	</div>
</div>

<?php get_footer(); ?>
