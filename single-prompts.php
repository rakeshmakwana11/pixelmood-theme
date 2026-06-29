<?php
/**
 * PixelMood Theme — single-prompts.php
 * Single Prompt post template.
 *
 * @package pixelmood
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

while ( have_posts() ) :
	the_post();

	$post_id     = get_the_ID();
	$prompt_id   = get_post_meta( $post_id, '_prompt_id', true );
	$categories  = get_the_terms( $post_id, 'prompt_category' );
	$tags        = get_the_terms( $post_id, 'prompt_tag' );
	$content     = get_the_content();
	$plain_text  = wp_strip_all_tags( $content );

	// Prev / Next
	$prev_post = get_previous_post( false, '', 'prompt_category' );
	$next_post = get_next_post( false, '', 'prompt_category' );

	// Related prompts (same category)
	$related_args = array(
		'post_type'      => 'prompt',
		'posts_per_page' => 4,
		'post__not_in'   => array( $post_id ),
		'post_status'    => 'publish',
		'orderby'        => 'rand',
	);
	if ( $categories && ! is_wp_error( $categories ) ) {
		$related_args['tax_query'] = array(
			array(
				'taxonomy' => 'prompt_category',
				'field'    => 'term_id',
				'terms'    => wp_list_pluck( $categories, 'term_id' ),
			),
		);
	}
	$related_query = new WP_Query( $related_args );
?>

<main id="main" class="pm-main" role="main">
<article id="post-<?php the_ID(); ?>" <?php post_class( 'pm-single-prompt' ); ?>>

	<!-- Breadcrumb -->
	<nav class="pm-breadcrumb pm-container" aria-label="<?php esc_attr_e( 'Breadcrumb', 'pixelmood' ); ?>">
		<ol class="pm-breadcrumb__list">
			<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'pixelmood' ); ?></a></li>
			<li aria-hidden="true">&rsaquo;</li>
			<li><a href="<?php echo esc_url( get_post_type_archive_link( 'prompt' ) ); ?>"><?php esc_html_e( 'Prompts', 'pixelmood' ); ?></a></li>
			<li aria-hidden="true">&rsaquo;</li>
			<?php if ( $categories && ! is_wp_error( $categories ) ) : ?>
				<li><a href="<?php echo esc_url( get_term_link( $categories[0] ) ); ?>"><?php echo esc_html( $categories[0]->name ); ?></a></li>
				<li aria-hidden="true">&rsaquo;</li>
			<?php endif; ?>
			<li aria-current="page"><?php the_title(); ?></li>
		</ol>
	</nav>

	<!-- Featured Image -->
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="pm-single-prompt__hero">
			<?php the_post_thumbnail( 'prompt-single', array( 'class' => 'pm-single-prompt__hero-img', 'loading' => 'eager' ) ); ?>
		</div>
	<?php endif; ?>

	<div class="pm-container">
		<div class="pm-single-prompt__layout">

			<!-- MAIN CONTENT -->
			<div class="pm-single-prompt__content">

				<!-- Meta badges -->
				<div class="pm-single-prompt__meta">
					<?php if ( $prompt_id ) : ?>
						<span class="pm-id-badge"><?php echo esc_html( $prompt_id ); ?></span>
					<?php endif; ?>
					<?php if ( $categories && ! is_wp_error( $categories ) ) :
						foreach ( $categories as $cat ) : ?>
							<a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="pm-category-badge">
								<?php echo esc_html( $cat->name ); ?>
							</a>
						<?php endforeach; endif; ?>
				</div>

				<!-- Title -->
				<h1 class="pm-single-prompt__title"><?php the_title(); ?></h1>

				<!-- Tags -->
				<?php if ( $tags && ! is_wp_error( $tags ) ) : ?>
					<div class="pm-single-prompt__tags">
						<?php foreach ( $tags as $tag ) : ?>
							<a href="<?php echo esc_url( get_term_link( $tag ) ); ?>" class="pm-tag">#<?php echo esc_html( $tag->name ); ?></a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<!-- Prompt Content Box -->
				<div class="pm-prompt-box">
					<div class="pm-prompt-box__header">
						<span class="pm-prompt-box__label">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
							<?php esc_html_e( 'Prompt', 'pixelmood' ); ?>
						</span>
						<button
							class="pm-btn pm-btn--primary pm-btn--sm pm-copy-btn"
							data-content="<?php echo esc_attr( $plain_text ); ?>"
							aria-label="<?php esc_attr_e( 'Copy prompt to clipboard', 'pixelmood' ); ?>"
						>
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
							<?php esc_html_e( 'Copy Prompt', 'pixelmood' ); ?>
						</button>
					</div>
					<div class="pm-prompt-box__content" id="pm-prompt-text-<?php echo esc_attr( $post_id ); ?>">
						<?php echo wp_kses_post( wpautop( $content ) ); ?>
					</div>
				</div><!-- .pm-prompt-box -->

			</div><!-- .pm-single-prompt__content -->

			<!-- SIDEBAR -->
			<aside class="pm-single-prompt__sidebar">

				<!-- Quick Details -->
				<div class="pm-sidebar-card">
					<h3 class="pm-sidebar-card__title"><?php esc_html_e( 'Prompt Details', 'pixelmood' ); ?></h3>
					<dl class="pm-detail-list">
						<?php if ( $prompt_id ) : ?>
							<dt><?php esc_html_e( 'Prompt ID', 'pixelmood' ); ?></dt>
							<dd><code><?php echo esc_html( $prompt_id ); ?></code></dd>
						<?php endif; ?>
						<?php if ( $categories && ! is_wp_error( $categories ) ) : ?>
							<dt><?php esc_html_e( 'Category', 'pixelmood' ); ?></dt>
							<dd>
								<?php foreach ( $categories as $cat ) : ?>
									<a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"><?php echo esc_html( $cat->name ); ?></a>
								<?php endforeach; ?>
							</dd>
						<?php endif; ?>
						<dt><?php esc_html_e( 'Added', 'pixelmood' ); ?></dt>
						<dd><?php echo esc_html( get_the_date() ); ?></dd>
					</dl>
				</div>

				<!-- All Tags -->
				<?php if ( $tags && ! is_wp_error( $tags ) ) : ?>
					<div class="pm-sidebar-card">
						<h3 class="pm-sidebar-card__title"><?php esc_html_e( 'Tags', 'pixelmood' ); ?></h3>
						<div class="pm-tag-cloud">
							<?php foreach ( $tags as $tag ) : ?>
								<a href="<?php echo esc_url( get_term_link( $tag ) ); ?>" class="pm-tag">#<?php echo esc_html( $tag->name ); ?></a>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>

			</aside><!-- .pm-single-prompt__sidebar -->

		</div><!-- .pm-single-prompt__layout -->

		<!-- PREV / NEXT NAVIGATION -->
		<?php if ( $prev_post || $next_post ) : ?>
			<nav class="pm-post-nav" aria-label="<?php esc_attr_e( 'Prompt navigation', 'pixelmood' ); ?>">
				<?php if ( $prev_post ) : ?>
					<a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>" class="pm-post-nav__link pm-post-nav__link--prev">
						<span class="pm-post-nav__dir">&larr; <?php esc_html_e( 'Previous Prompt', 'pixelmood' ); ?></span>
						<span class="pm-post-nav__title"><?php echo esc_html( get_the_title( $prev_post ) ); ?></span>
					</a>
				<?php else : ?>
					<span></span>
				<?php endif; ?>
				<?php if ( $next_post ) : ?>
					<a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" class="pm-post-nav__link pm-post-nav__link--next">
						<span class="pm-post-nav__dir"><?php esc_html_e( 'Next Prompt', 'pixelmood' ); ?> &rarr;</span>
						<span class="pm-post-nav__title"><?php echo esc_html( get_the_title( $next_post ) ); ?></span>
					</a>
				<?php endif; ?>
			</nav>
		<?php endif; ?>

		<!-- RELATED PROMPTS -->
		<?php if ( $related_query->have_posts() ) : ?>
			<section class="pm-related" aria-label="<?php esc_attr_e( 'Related Prompts', 'pixelmood' ); ?>">
				<h2 class="pm-related__title"><?php esc_html_e( 'Related Prompts', 'pixelmood' ); ?></h2>
				<div class="pm-grid pm-grid--4">
					<?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
						<?php get_template_part( 'template-parts/prompt-card' ); ?>
					<?php endwhile; ?>
				</div>
			</section>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>

	</div><!-- .pm-container -->

</article>
</main>

<?php endwhile; ?>
<?php get_footer(); ?>
