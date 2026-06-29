<?php
/**
 * PixelMood Theme — taxonomy-prompt_category.php
 * Category archive for prompt_category taxonomy.
 *
 * @package pixelmood
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$term       = get_queried_object();
$term_name  = $term ? $term->name : esc_html__( 'Category', 'pixelmood' );
$term_desc  = $term ? $term->description : '';
$term_count = $term ? $term->count : 0;

// Sibling categories for filter nav
$all_categories = get_terms( array(
	'taxonomy'   => 'prompt_category',
	'hide_empty' => true,
	'number'     => 20,
) );
?>

<main id="main" class="pm-main" role="main">

	<!-- Taxonomy Hero -->
	<section class="pm-archive-hero">
		<div class="pm-container">
			<p class="pm-archive-hero__eyebrow"><?php esc_html_e( 'Category', 'pixelmood' ); ?></p>
			<h1 class="pm-archive-hero__title"><?php echo esc_html( $term_name ); ?></h1>
			<?php if ( $term_desc ) : ?>
				<p class="pm-archive-hero__desc"><?php echo esc_html( $term_desc ); ?></p>
			<?php else : ?>
				<p class="pm-archive-hero__desc">
					<?php
					/* translators: %1$s: count, %2$s: category name */
					printf( esc_html__( '%1$d prompts in %2$s.', 'pixelmood' ), (int) $term_count, esc_html( $term_name ) );
					?>
				</p>
			<?php endif; ?>
		</div>
	</section>

	<!-- Category Filter Nav -->
	<?php if ( ! empty( $all_categories ) && ! is_wp_error( $all_categories ) ) : ?>
	<div class="pm-filters-section">
		<div class="pm-container">
			<div class="pm-filters" role="list">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'prompt' ) ); ?>" class="pm-filter-btn" role="listitem">
					<?php esc_html_e( 'All', 'pixelmood' ); ?>
				</a>
				<?php foreach ( $all_categories as $cat ) : ?>
					<a
						href="<?php echo esc_url( get_term_link( $cat ) ); ?>"
						class="pm-filter-btn <?php echo ( $term && $cat->term_id === $term->term_id ) ? 'is-active' : ''; ?>"
						role="listitem"
					><?php echo esc_html( $cat->name ); ?></a>
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
					<h3><?php esc_html_e( 'No prompts in this category yet.', 'pixelmood' ); ?></h3>
					<a href="<?php echo esc_url( get_post_type_archive_link( 'prompt' ) ); ?>" class="pm-btn pm-btn--primary">
						<?php esc_html_e( 'Browse All Prompts', 'pixelmood' ); ?>
					</a>
				</div>

			<?php endif; ?>

		</div>
	</section>

</main>

<?php get_footer(); ?>
