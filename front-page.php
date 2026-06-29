<?php
/**
 * PixelMood Theme — front-page.php
 * Homepage: Hero, Search, Category Filters, Latest Prompts Grid.
 *
 * @package pixelmood
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$hero_title   = get_theme_mod( 'pm_hero_title', 'PixelMood' );
$prompts_page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
$per_page     = 12;

$prompts_query = new WP_Query( array(
	'post_type'      => 'prompt',
	'posts_per_page' => $per_page,
	'paged'          => $prompts_page,
	'post_status'    => 'publish',
	'orderby'        => 'date',
	'order'          => 'DESC',
) );

$categories = get_terms( array(
	'taxonomy'   => 'prompt_category',
	'hide_empty' => true,
	'number'     => 10,
) );
?>

<main id="main" class="pm-main pm-home" role="main">

	<!-- ================================================
	     HERO SECTION
	================================================ -->
	<section class="pm-hero" aria-label="<?php esc_attr_e( 'PixelMood Hero', 'pixelmood' ); ?>">
		<div class="pm-hero__bg" aria-hidden="true"></div>
		<div class="pm-container">

			<h1 class="pm-hero__title">
				<?php
				$parts = explode( 'Mood', esc_html( $hero_title ) );
				if ( count( $parts ) === 2 ) {
					echo esc_html( $parts[0] ) . '<span>Mood</span>' . esc_html( $parts[1] );
				} else {
					echo esc_html( $hero_title );
				}
				?>
			</h1>
			<p class="pm-hero__sub"><?php esc_html_e( 'Discover &amp; copy AI image prompts — curated for every creative mood.', 'pixelmood' ); ?></p>

			<!-- Hero Search Bar -->
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
						autocomplete="off"
						aria-label="<?php esc_attr_e( 'Search prompts', 'pixelmood' ); ?>"
					>
					<input type="hidden" name="post_type" value="prompt">
					<button type="submit" class="pm-hero-search__btn">
						<?php esc_html_e( 'Search', 'pixelmood' ); ?>
					</button>
				</div>
			</form>

		</div>
	</section><!-- .pm-hero -->

	<!-- ================================================
	     CATEGORY FILTERS
	================================================ -->
	<?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
	<section class="pm-filters-section" aria-label="<?php esc_attr_e( 'Filter by category', 'pixelmood' ); ?>">
		<div class="pm-container">
			<div class="pm-filters" role="list">

				<a
					href="<?php echo esc_url( get_post_type_archive_link( 'prompt' ) ); ?>"
					class="pm-filter-btn <?php echo ! isset( $_GET['prompt_category'] ) ? 'is-active' : ''; ?>"
					role="listitem"
				><?php esc_html_e( 'All', 'pixelmood' ); ?></a>

				<?php foreach ( $categories as $cat ) : ?>
					<a
						href="<?php echo esc_url( get_term_link( $cat ) ); ?>"
						class="pm-filter-btn"
						role="listitem"
					><?php echo esc_html( $cat->name ); ?></a>
				<?php endforeach; ?>

			</div>
		</div>
	</section>
	<?php endif; ?>

	<!-- ================================================
	     LATEST PROMPTS GRID
	================================================ -->
	<section class="pm-section pm-prompts-section" aria-label="<?php esc_attr_e( 'Latest Prompts', 'pixelmood' ); ?>">
		<div class="pm-container">

			<div class="pm-section-header">
				<h2 class="pm-section-title"><?php esc_html_e( 'Latest Prompts', 'pixelmood' ); ?></h2>
				<?php $archive = get_post_type_archive_link( 'prompt' ); if ( $archive ) : ?>
					<a href="<?php echo esc_url( $archive ); ?>" class="pm-section-link">
						<?php esc_html_e( 'View all prompts', 'pixelmood' ); ?> &rarr;
					</a>
				<?php endif; ?>
			</div>

			<?php if ( $prompts_query->have_posts() ) : ?>

				<div class="pm-grid" id="pm-prompts-grid">
					<?php while ( $prompts_query->have_posts() ) : $prompts_query->the_post(); ?>
						<?php get_template_part( 'template-parts/prompt-card' ); ?>
					<?php endwhile; ?>
				</div>

				<?php if ( $archive ) : ?>
					<div class="pm-view-all-wrap">
						<a href="<?php echo esc_url( $archive ); ?>" class="pm-btn pm-btn--outline">
							<?php esc_html_e( 'Browse All Prompts', 'pixelmood' ); ?>
						</a>
					</div>
				<?php endif; ?>

			<?php else : ?>

				<div class="pm-empty">
					<div class="pm-empty__icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
							<path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
						</svg>
					</div>
					<h3><?php esc_html_e( 'No prompts yet', 'pixelmood' ); ?></h3>
					<p><?php esc_html_e( 'Start adding prompts from the WordPress admin.', 'pixelmood' ); ?></p>
				</div>

			<?php endif; ?>
			<?php wp_reset_postdata(); ?>

		</div>
	</section>

</main>

<?php get_footer(); ?>
