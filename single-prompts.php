<?php
/**
 * PixelMood Theme - single-prompts.php
 * Single Prompt post template.
 * @package pixelmood
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

if ( have_posts() ) :
	the_post();

	$post_id    = get_the_ID();
	$prompt_id  = get_post_meta( $post_id, '_prompt_id', true );
	$categories = get_the_terms( $post_id, 'prompt_category' );
	$tags       = get_the_terms( $post_id, 'prompt_tag' );
	$content    = get_the_content();
	$title      = get_the_title();

	// Related prompts
	$related_args = array(
		'post_type'      => 'prompt',
		'posts_per_page' => 3,
		'post__not_in'   => array( $post_id ),
		'orderby'        => 'rand',
	);
	if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
		$cat_ids = wp_list_pluck( $categories, 'term_id' );
		$related_args['tax_query'] = array(
			array(
				'taxonomy' => 'prompt_category',
				'field'    => 'term_id',
				'terms'    => $cat_ids,
			),
		);
	}
	$related_query = new WP_Query( $related_args );

	// Prev / Next
	$prev_prompt = get_previous_post( false, '', 'prompt_category' );
	$next_prompt = get_next_post( false, '', 'prompt_category' );
?>

<div class="pm-single-prompt pm-container">

	<div class="pm-single-prompt-inner">

		<!-- Featured Image -->
		<?php if ( has_post_thumbnail() ) : ?>
		<div class="pm-single-image">
			<?php the_post_thumbnail( 'prompt-single', array( 'alt' => esc_attr( $title ) ) ); ?>
		</div>
		<?php endif; ?>

		<div class="pm-single-content">

			<!-- Meta: ID + Cats + Tags -->
			<div class="pm-single-meta">
				<?php if ( $prompt_id ) : ?>
					<span class="pm-single-id"><?php echo esc_html( $prompt_id ); ?></span>
				<?php endif; ?>

				<?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
					<div class="pm-single-cats">
						<?php foreach ( $categories as $cat ) : ?>
							<a class="pm-cat-badge" href="<?php echo esc_url( get_term_link( $cat ) ); ?>"><?php echo esc_html( $cat->name ); ?></a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>

			<!-- Title -->
			<h1 class="pm-single-title"><?php the_title(); ?></h1>

			<!-- Tags -->
			<?php if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) : ?>
				<div class="pm-single-tags">
					<?php foreach ( $tags as $tag ) : ?>
						<a class="pm-tag" href="<?php echo esc_url( get_term_link( $tag ) ); ?>">#<?php echo esc_html( $tag->name ); ?></a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<!-- Full Prompt Content -->
			<div class="pm-single-prompt-box">
				<div class="pm-prompt-box-header">
					<span><?php esc_html_e( 'Prompt', 'pixelmood' ); ?></span>
					<button
						class="pm-btn pm-btn--ghost pm-btn--sm pm-copy-btn"
						data-prompt="<?php echo esc_attr( wp_strip_all_tags( $content ) ); ?>"
						aria-label="<?php esc_attr_e( 'Copy Prompt', 'pixelmood' ); ?>"
					>
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
						<?php esc_html_e( 'Copy Prompt', 'pixelmood' ); ?>
					</button>
				</div>
				<div class="pm-prompt-box-content entry-content">
					<?php the_content(); ?>
				</div>
			</div>

			<!-- Prev / Next Navigation -->
			<nav class="pm-single-prevnext" aria-label="<?php esc_attr_e( 'Prompt navigation', 'pixelmood' ); ?>">
				<?php if ( $prev_prompt ) : ?>
					<a class="pm-prevnext-link pm-prevnext-link--prev" href="<?php echo esc_url( get_permalink( $prev_prompt ) ); ?>">
						<span class="pm-prevnext-label">&larr; <?php esc_html_e( 'Previous', 'pixelmood' ); ?></span>
						<span class="pm-prevnext-title"><?php echo esc_html( get_the_title( $prev_prompt ) ); ?></span>
					</a>
				<?php endif; ?>
				<?php if ( $next_prompt ) : ?>
					<a class="pm-prevnext-link pm-prevnext-link--next" href="<?php echo esc_url( get_permalink( $next_prompt ) ); ?>">
						<span class="pm-prevnext-label"><?php esc_html_e( 'Next', 'pixelmood' ); ?> &rarr;</span>
						<span class="pm-prevnext-title"><?php echo esc_html( get_the_title( $next_prompt ) ); ?></span>
					</a>
				<?php endif; ?>
			</nav>

		</div>
	</div>

	<!-- Related Prompts -->
	<?php if ( $related_query->have_posts() ) : ?>
		<section class="pm-related-prompts">
			<h2 class="pm-section-title"><?php esc_html_e( 'Related Prompts', 'pixelmood' ); ?></h2>
			<div class="pm-grid">
				<?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
					<?php get_template_part( 'template-parts/prompt-card' ); ?>
				<?php endwhile; ?>
			</div>
			<?php wp_reset_postdata(); ?>
		</section>
	<?php endif; ?>

</div>

<?php endif; ?>

<?php get_footer(); ?>
