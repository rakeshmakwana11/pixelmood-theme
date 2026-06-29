<?php
/**
 * PixelMood Theme - template-parts/content-search.php
 * Search result item for blog posts.
 * @package pixelmood
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'pm-search-result' ); ?>>
	<div class="pm-search-result-inner">

		<?php if ( has_post_thumbnail() ) : ?>
			<a class="pm-search-result-thumb" href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'thumbnail', array( 'loading' => 'lazy' ) ); ?>
			</a>
		<?php endif; ?>

		<div class="pm-search-result-body">
			<div class="pm-search-result-meta">
				<span class="pm-search-result-type"><?php esc_html_e( 'Blog Post', 'pixelmood' ); ?></span>
				<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
			</div>
			<h3 class="pm-search-result-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h3>
			<p class="pm-search-result-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18, '...' ) ); ?></p>
			<a class="pm-btn pm-btn--ghost pm-btn--sm" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'pixelmood' ); ?> &rarr;</a>
		</div>

	</div>
</article>
