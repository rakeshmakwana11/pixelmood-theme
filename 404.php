<?php
/**
 * PixelMood Theme — 404.php
 * Not Found page.
 *
 * @package pixelmood
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<main id="main" class="pm-main" role="main">
	<div class="pm-container pm-section">

		<div class="pm-404">

			<div class="pm-404__code" aria-hidden="true">404</div>

			<h1 class="pm-404__title"><?php esc_html_e( 'Page Not Found', 'pixelmood' ); ?></h1>
			<p class="pm-404__desc">
				<?php esc_html_e( "Oops! The page you're looking for doesn't exist or has been moved.", 'pixelmood' ); ?>
			</p>

			<!-- Inline Search -->
			<form class="pm-404__search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input
					type="search"
					name="s"
					class="pm-404__search-input"
					placeholder="<?php esc_attr_e( 'Search prompts...', 'pixelmood' ); ?>"
					aria-label="<?php esc_attr_e( 'Search', 'pixelmood' ); ?>"
				>
				<input type="hidden" name="post_type" value="prompt">
				<button type="submit" class="pm-btn pm-btn--primary">
					<?php esc_html_e( 'Search', 'pixelmood' ); ?>
				</button>
			</form>

			<!-- Quick Links -->
			<div class="pm-404__links">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="pm-btn pm-btn--outline">
					<?php esc_html_e( 'Go Home', 'pixelmood' ); ?>
				</a>
				<?php $archive = get_post_type_archive_link( 'prompt' ); if ( $archive ) : ?>
					<a href="<?php echo esc_url( $archive ); ?>" class="pm-btn pm-btn--primary">
						<?php esc_html_e( 'Browse All Prompts', 'pixelmood' ); ?>
					</a>
				<?php endif; ?>
			</div>

		</div>

	</div>
</main>

<?php get_footer(); ?>
