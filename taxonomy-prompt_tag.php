<?php
/**
 * PixelMood Theme — taxonomy-prompt_tag.php
 * Tag archive for prompt_tag taxonomy.
 *
 * @package pixelmood
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$term       = get_queried_object();
$term_name  = $term ? $term->name : esc_html__( 'Tag', 'pixelmood' );
$term_desc  = $term ? $term->description : '';
$term_count = $term ? $term->count : 0;

// Popular tags for sidebar discovery
$popular_tags = get_terms( array(
	'taxonomy'   => 'prompt_tag',
	'hide_empty' => true,
	'number'     => 30,
	'orderby'    => 'count',
	'order'      => 'DESC',
) );
?>

<main id="main" class="pm-main" role="main">

	<!-- Tag Hero -->
	<section class="pm-archive-hero">
		<div class="pm-container">
			<p class="pm-archive-hero__eyebrow"><?php esc_html_e( 'Tag', 'pixelmood' ); ?></p>
			<h1 class="pm-archive-hero__title">#<?php echo esc_html( $term_name ); ?></h1>
			<?php if ( $term_desc ) : ?>
				<p class="pm-archive-hero__desc"><?php echo esc_html( $term_desc ); ?></p>
			<?php else : ?>
				<p class="pm-archive-hero__desc">
					<?php
					/* translators: %1$d: count, %2$s: tag name */
					printf( esc_html__( '%1$d prompts tagged #%2$s.', 'pixelmood' ), (int) $term_count, esc_html( $term_name ) );
					?>
				</p>
			<?php endif; ?>
		</div>
	</section>

	<div class="pm-container pm-section">
		<div class="pm-tag-layout">

			<!-- Main Grid -->
			<div class="pm-tag-layout__main">
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
								<path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
								<line x1="7" y1="7" x2="7.01" y2="7"/>
							</svg>
						</div>
						<h3><?php esc_html_e( 'No prompts with this tag yet.', 'pixelmood' ); ?></h3>
						<a href="<?php echo esc_url( get_post_type_archive_link( 'prompt' ) ); ?>" class="pm-btn pm-btn--primary">
							<?php esc_html_e( 'Browse All Prompts', 'pixelmood' ); ?>
						</a>
					</div>

				<?php endif; ?>
			</div><!-- .pm-tag-layout__main -->

			<!-- Sidebar: Popular Tags -->
			<?php if ( ! empty( $popular_tags ) && ! is_wp_error( $popular_tags ) ) : ?>
				<aside class="pm-tag-layout__sidebar">
					<div class="pm-sidebar-card">
						<h3 class="pm-sidebar-card__title"><?php esc_html_e( 'Popular Tags', 'pixelmood' ); ?></h3>
						<div class="pm-tag-cloud">
							<?php foreach ( $popular_tags as $ptag ) : ?>
								<a
									href="<?php echo esc_url( get_term_link( $ptag ) ); ?>"
									class="pm-tag <?php echo ( $term && $ptag->term_id === $term->term_id ) ? 'is-active' : ''; ?>"
								>#<?php echo esc_html( $ptag->name ); ?> <sup><?php echo (int) $ptag->count; ?></sup>
								</a>
							<?php endforeach; ?>
						</div>
					</div>
				</aside>
			<?php endif; ?>

		</div><!-- .pm-tag-layout -->
	</div>

</main>

<?php get_footer(); ?>
