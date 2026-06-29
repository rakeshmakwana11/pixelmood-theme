<?php
/**
 * PixelMood Theme - search.php
 * Search results page for prompts and blog posts.
 * @package pixelmood
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<div class="pm-container pm-search-results-page">

	<div class="pm-search-results-header">
		<h1 class="pm-search-results-title">
			<?php
			$search_query = get_search_query();
			if ( $search_query ) {
				/* translators: %s: search term */
				printf( esc_html__( 'Search Results for: %s', 'pixelmood' ), '<span class="pm-search-term">' . esc_html( $search_query ) . '</span>' );
			} else {
				esc_html_e( 'Search Results', 'pixelmood' );
			}
			?>
		</h1>
		<?php if ( have_posts() ) : ?>
			<p class="pm-search-result-count">
				<?php
				global $wp_query;
				/* translators: %d: number of results */
				printf( esc_html__( '%d result(s) found', 'pixelmood' ), (int) $wp_query->found_posts );
				?>
			</p>
		<?php endif; ?>
	</div>

	<form class="pm-search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<div class="pm-search-wrap">
			<svg class="pm-search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
			<input type="search" class="pm-search-input" name="s" placeholder="<?php esc_attr_e( 'Search prompts, tags, categories or Prompt ID...', 'pixelmood' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" autocomplete="off">
			<button type="submit" class="pm-btn pm-btn--primary"><?php esc_html_e( 'Search', 'pixelmood' ); ?></button>
		</div>
	</form>

	<?php if ( have_posts() ) : ?>

		<?php
		// Separate prompts and posts
		$prompts = array();
		$posts   = array();
		while ( have_posts() ) :
			the_post();
			if ( 'prompt' === get_post_type() ) {
				$prompts[] = get_the_ID();
			} else {
				$posts[] = get_the_ID();
			}
		endwhile;
		rewind_posts();
		?>

		<?php if ( ! empty( $prompts ) ) : ?>
			<div class="pm-search-section">
				<h2 class="pm-section-title"><?php esc_html_e( 'Prompts', 'pixelmood' ); ?></h2>
				<div class="pm-grid">
					<?php foreach ( $prompts as $pid ) : ?>
						<?php
						$GLOBALS['post'] = get_post( $pid );
						setup_postdata( $GLOBALS['post'] );
						?>
						<?php get_template_part( 'template-parts/prompt-card' ); ?>
					<?php endforeach; ?>
					<?php wp_reset_postdata(); ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $posts ) ) : ?>
			<div class="pm-search-section pm-search-section--blog">
				<h2 class="pm-section-title"><?php esc_html_e( 'Blog Posts', 'pixelmood' ); ?></h2>
				<div class="pm-blog-list">
					<?php foreach ( $posts as $pid ) : ?>
						<?php
						$GLOBALS['post'] = get_post( $pid );
						setup_postdata( $GLOBALS['post'] );
						?>
						<article class="pm-blog-list-item">
							<div class="pm-blog-list-meta">
								<span class="pm-blog-date"><?php echo esc_html( get_the_date() ); ?></span>
							</div>
							<h3 class="pm-blog-list-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p class="pm-blog-list-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20, '...' ) ); ?></p>
						</article>
					<?php endforeach; ?>
					<?php wp_reset_postdata(); ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="pm-pagination">
			<?php the_posts_pagination( array(
				'prev_text' => '&larr; ' . __( 'Prev', 'pixelmood' ),
				'next_text' => __( 'Next', 'pixelmood' ) . ' &rarr;',
			) ); ?>
		</div>

	<?php else : ?>

		<div class="pm-no-results">
			<h2><?php esc_html_e( 'Nothing Found', 'pixelmood' ); ?></h2>
			<p><?php esc_html_e( 'Sorry, no results matched your search. Try different keywords.', 'pixelmood' ); ?></p>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="pm-btn pm-btn--primary"><?php esc_html_e( 'Back to Home', 'pixelmood' ); ?></a>
		</div>

	<?php endif; ?>

</div>

<?php get_footer(); ?>
