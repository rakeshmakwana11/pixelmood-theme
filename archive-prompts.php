<?php
/**
 * PixelMood Theme — archive-prompts.php
 * The /prompts/ archive page.
 *
 * @package pixelmood
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$categories = get_terms( array(
	'taxonomy'   => 'prompt_category',
	'hide_empty' => true,
	'number'     => 20,
) );
?>

<main id="main" class="pm-main" role="main">

	<!-- Archive Hero -->
	<section class="pm-archive-hero">
		<div class="pm-container">
			<h1 class="pm-archive-hero__title"><?php esc_html_e( 'All Prompts', 'pixelmood' ); ?></h1>
			<p class="pm-archive-hero__desc">
				<?php
				$count = wp_count_posts( 'prompt' )->publish;
				/* translators: %d: number of prompts */
				printf( esc_html__( 'Explore %d curated AI image prompts.', 'pixelmood' ), (int) $count );
				?>
			</p>

			<!-- Archive Search -->
			<form class="pm-hero-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<div class="pm-hero-search__wrap">
					<svg class="pm-hero-search__icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
						<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
					</svg>
					<input
						type="search"
						name="s"
						class="pm-hero-search__input"
						placeholder="<?php esc_attr_e( 'Search prompts, tags, categories or Prompt ID…', 'pixelmood' ); ?>"
						value="<?php echo esc_attr( get_search_query() ); ?>"
						aria-label="<?php esc_attr_e( 'Search prompts', 'pixelmood' ); ?>"
					>
					<input type="hidden" name="post_type" value="prompt">
					<button type="submit" class="pm-hero-search__btn"><?php esc_html_e( 'Search', 'pixelmood' ); ?></button>
				</div>
			</form>
		</div>
	</section>

	<!-- Category Filters -->
	<?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
	<div class="pm-filters-section">
		<div class="pm-container">
			<div class="pm-filters" role="list">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'prompt' ) ); ?>" class="pm-filter-btn is-active" role="listitem">
					<?php esc_html_e( 'All', 'pixelmood' ); ?>
				</a>
				<?php foreach ( $categories as $cat ) : ?>
					<a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="pm-filter-btn" role="listitem">
						<?php echo esc_html( $cat->name ); ?>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<!-- Prompts Grid -->
	<section class="pm-section">
		<div class="pm-container">

			<?php if ( have_posts() ) : ?>

				<div class="pm-grid">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'template-parts/prompt-card' ); ?>
					<?php endwhile; ?>
				</div>

				<?php the_posts_pagination( array(
					'prev_text' => '&larr; ' . esc_html__( 'Previous', 'pixelmood' ),
					'next_text' => esc_html__( 'Next', 'pixelmood' ) . ' &rarr;',
					'class'     => 'pm-pagination',
				) ); ?>

			<?php else : ?>

				<div class="pm-empty">
					<div class="pm-empty__icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
							<path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
						</svg>
					</div>
					<h3><?php esc_html_e( 'No prompts found', 'pixelmood' ); ?></h3>
					<p><?php esc_html_e( 'Try a different search or browse all categories.', 'pixelmood' ); ?></p>
				</div>

			<?php endif; ?>

		</div>
	</section>

</main>

<?php get_footer(); ?>
