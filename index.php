<?php
/**
 * PixelMood Theme — index.php
 * Fallback template for blog posts.
 *
 * @package pixelmood
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<main id="main" class="pm-main" role="main">
	<div class="pm-container pm-section">

		<?php if ( is_home() && ! is_front_page() ) : ?>
			<header class="pm-archive-hero">
				<h1 class="pm-archive-hero__title"><?php esc_html_e( 'Blog', 'pixelmood' ); ?></h1>
				<p class="pm-archive-hero__desc"><?php esc_html_e( 'News, tips and inspiration from PixelMood.', 'pixelmood' ); ?></p>
			</header>
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>

			<div class="pm-post-grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/content', get_post_type() ); ?>
				<?php endwhile; ?>
			</div>

			<?php the_posts_pagination( array(
				'prev_text' => '&larr; ' . esc_html__( 'Older posts', 'pixelmood' ),
				'next_text' => esc_html__( 'Newer posts', 'pixelmood' ) . ' &rarr;',
				'class'     => 'pm-pagination',
			) ); ?>

		<?php else : ?>

			<div class="pm-empty">
				<div class="pm-empty__icon" aria-hidden="true">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
						<circle cx="12" cy="12" r="10"/>
						<line x1="12" y1="8" x2="12" y2="12"/>
						<line x1="12" y1="16" x2="12.01" y2="16"/>
					</svg>
				</div>
				<h3><?php esc_html_e( 'Nothing here yet', 'pixelmood' ); ?></h3>
				<p><?php esc_html_e( 'No posts were found. Check back soon!', 'pixelmood' ); ?></p>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="pm-btn pm-btn--primary">
					<?php esc_html_e( 'Go Home', 'pixelmood' ); ?>
				</a>
			</div>

		<?php endif; ?>

	</div>
</main>

<?php get_footer(); ?>
