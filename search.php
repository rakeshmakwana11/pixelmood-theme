<?php
/**
 * PixelMood Theme — search.php
 * Search results page for prompts and blog posts.
 *
 * @package pixelmood
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$search_query = get_search_query();
?>

<main id="main" class="pm-main" role="main">

	<section class="pm-archive-hero">
		<div class="pm-container">
			<h1 class="pm-archive-hero__title">
				<?php if ( $search_query ) : ?>
					<?php
					/* translators: %s: search query */
					printf( esc_html__( 'Results for: %s', 'pixelmood' ), '<span class="pm-search-term">' . esc_html( $search_query ) . '</span>' );
					// phpcs:ignore WordPress.Security.EscapeOutput
					?>
				<?php else : ?>
					<?php esc_html_e( 'Search', 'pixelmood' ); ?>
				<?php endif; ?>
			</h1>
			<?php if ( have_posts() ) : ?>
				<p class="pm-archive-hero__desc">
					<?php
					/* translators: %d: number of results */
					printf( esc_html__( '%d results found.', 'pixelmood' ), (int) $GLOBALS['wp_query']->found_posts );
					?>
				</p>
			<?php endif; ?>

			<!-- Search Refinement -->
			<form class="pm-hero-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<div class="pm-hero-search__wrap">
					<svg class="pm-hero-search__icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
						<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
					</svg>
					<input
						type="search"
						name="s"
						class="pm-hero-search__input"
						value="<?php echo esc_attr( $search_query ); ?>"
						placeholder="<?php esc_attr_e( 'Search prompts, ID, tags…', 'pixelmood' ); ?>"
						aria-label="<?php esc_attr_e( 'Refine search', 'pixelmood' ); ?>"
					>
					<button type="submit" class="pm-hero-search__btn"><?php esc_html_e( 'Search', 'pixelmood' ); ?></button>
				</div>
			</form>
		</div>
	</section>

	<div class="pm-container pm-section">

		<?php if ( have_posts() ) : ?>

			<?php
			// Split results by type
			$prompt_posts = array();
			$blog_posts   = array();
			while ( have_posts() ) :
				the_post();
				if ( get_post_type() === 'prompt' ) {
					$prompt_posts[] = get_the_ID();
				} else {
					$blog_posts[] = get_the_ID();
				}
			endwhile;
			?>

			<?php if ( ! empty( $prompt_posts ) ) : ?>
				<div class="pm-search-section">
					<h2 class="pm-search-section__title">
						<?php
						/* translators: %d: number of prompts */
						printf( esc_html__( 'Prompts (%d)', 'pixelmood' ), count( $prompt_posts ) );
						?>
					</h2>
					<div class="pm-grid">
						<?php foreach ( $prompt_posts as $pid ) :
							$GLOBALS['post'] = get_post( $pid );
							setup_postdata( $GLOBALS['post'] );
							get_template_part( 'template-parts/prompt-card' );
							wp_reset_postdata();
						endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $blog_posts ) ) : ?>
				<div class="pm-search-section">
					<h2 class="pm-search-section__title">
						<?php
						/* translators: %d: number of blog posts */
						printf( esc_html__( 'Blog Posts (%d)', 'pixelmood' ), count( $blog_posts ) );
						?>
					</h2>
					<div class="pm-post-grid">
						<?php foreach ( $blog_posts as $pid ) :
							$GLOBALS['post'] = get_post( $pid );
							setup_postdata( $GLOBALS['post'] );
							get_template_part( 'template-parts/content-search' );
							wp_reset_postdata();
						endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<?php the_posts_pagination( array(
				'prev_text' => '&larr; ' . esc_html__( 'Previous', 'pixelmood' ),
				'next_text' => esc_html__( 'Next', 'pixelmood' ) . ' &rarr;',
				'class'     => 'pm-pagination',
			) ); ?>

		<?php else : ?>

			<div class="pm-empty">
				<div class="pm-empty__icon" aria-hidden="true">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
						<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
					</svg>
				</div>
				<h3><?php esc_html_e( 'No results found', 'pixelmood' ); ?></h3>
				<p>
					<?php
					/* translators: %s: search term */
					printf( esc_html__( 'Nothing matched “%s”. Try a different keyword or browse all prompts.', 'pixelmood' ), esc_html( $search_query ) );
					?>
				</p>
				<div style="display:flex;gap:12px;flex-wrap:wrap;justify-content:center;margin-top:24px;">
					<a href="<?php echo esc_url( get_post_type_archive_link( 'prompt' ) ); ?>" class="pm-btn pm-btn--primary">
						<?php esc_html_e( 'Browse All Prompts', 'pixelmood' ); ?>
					</a>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="pm-btn pm-btn--outline">
						<?php esc_html_e( 'Go Home', 'pixelmood' ); ?>
					</a>
				</div>
			</div>

		<?php endif; ?>

	</div>

</main>

<?php get_footer(); ?>
