<?php
/**
 * PixelMood Theme - template-parts/content.php
 * Blog post card for the posts loop.
 * @package pixelmood
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'pm-blog-card' ); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
		<a class="pm-blog-card-image" href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy', 'alt' => esc_attr( get_the_title() ) ) ); ?>
		</a>
	<?php endif; ?>

	<div class="pm-blog-card-body">

		<div class="pm-blog-card-meta">
			<time class="pm-blog-card-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
				<?php echo esc_html( get_the_date() ); ?>
			</time>
			<span class="pm-blog-card-author"><?php echo esc_html( get_the_author() ); ?></span>
		</div>

		<h2 class="pm-blog-card-title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>

		<?php $cats = get_the_category(); ?>
		<?php if ( ! empty( $cats ) ) : ?>
			<div class="pm-blog-card-cats">
				<?php foreach ( array_slice( $cats, 0, 2 ) as $cat ) : ?>
					<a class="pm-cat-badge" href="<?php echo esc_url( get_category_link( $cat ) ); ?>"><?php echo esc_html( $cat->name ); ?></a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<p class="pm-blog-card-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20, '...' ) ); ?></p>

		<a class="pm-btn pm-btn--ghost pm-btn--sm" href="<?php the_permalink(); ?>">
			<?php esc_html_e( 'Read More', 'pixelmood' ); ?> &rarr;
		</a>

	</div>

</article>
