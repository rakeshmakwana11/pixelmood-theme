<?php
/**
 * PixelMood Theme — template-parts/content-search.php
 * Blog post row for search results page.
 *
 * @package pixelmood
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'pm-search-result' ); ?>>

	<div class="pm-search-result__inner">

		<?php if ( has_post_thumbnail() ) : ?>
			<a href="<?php the_permalink(); ?>" class="pm-search-result__thumb" tabindex="-1" aria-hidden="true">
				<?php the_post_thumbnail( 'thumbnail', array(
					'class'   => 'pm-search-result__img',
					'loading' => 'lazy',
				) ); ?>
			</a>
		<?php endif; ?>

		<div class="pm-search-result__body">
			<div class="pm-search-result__meta">
				<span class="pm-search-result__type"><?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?></span>
				<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" class="pm-search-result__date">
					<?php echo esc_html( get_the_date() ); ?>
				</time>
			</div>
			<h3 class="pm-search-result__title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h3>
			<?php if ( get_the_excerpt() ) : ?>
				<p class="pm-search-result__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18, '&hellip;' ) ); ?></p>
			<?php endif; ?>
		</div>

	</div><!-- .pm-search-result__inner -->

</article>
