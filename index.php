<?php
/**
 * PixelMood Theme - index.php
 * Fallback template (Blog posts loop).
 * @package pixelmood
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<div class="pm-container pm-blog-page">

	<header class="pm-page-header">
		<h1 class="pm-page-title"><?php esc_html_e( 'Latest Posts', 'pixelmood' ); ?></h1>
	</header>

	<?php if ( have_posts() ) : ?>

		<div class="pm-blog-grid">
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'pm-blog-card' ); ?>>

					<?php if ( has_post_thumbnail() ) : ?>
						<a class="pm-blog-card-image" href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) ); ?>
						</a>
					<?php endif; ?>

					<div class="pm-blog-card-body">
						<div class="pm-blog-card-meta">
							<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
							<span class="pm-blog-card-author"><?php echo esc_html( get_the_author() ); ?></span>
						</div>
						<h2 class="pm-blog-card-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>
						<p class="pm-blog-card-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20, '...' ) ); ?></p>
						<a class="pm-btn pm-btn--ghost pm-btn--sm" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'pixelmood' ); ?> &rarr;</a>
					</div>

				</article>
			<?php endwhile; ?>
		</div>

		<div class="pm-pagination">
			<?php the_posts_pagination( array(
				'prev_text' => '&larr; ' . __( 'Prev', 'pixelmood' ),
				'next_text' => __( 'Next', 'pixelmood' ) . ' &rarr;',
			) ); ?>
		</div>

	<?php else : ?>

		<div class="pm-no-results">
			<p><?php esc_html_e( 'No posts found.', 'pixelmood' ); ?></p>
		</div>

	<?php endif; ?>

</div>

<?php get_footer(); ?>
