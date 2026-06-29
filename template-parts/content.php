<?php
/**
 * PixelMood Theme — template-parts/content.php
 * Blog post card for the posts loop.
 *
 * @package pixelmood
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'pm-post-card' ); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink(); ?>" class="pm-post-card__image-link" tabindex="-1" aria-hidden="true">
			<?php the_post_thumbnail( 'medium_large', array(
				'class'   => 'pm-post-card__image',
				'loading' => 'lazy',
			) ); ?>
		</a>
	<?php endif; ?>

	<div class="pm-post-card__body">

		<div class="pm-post-card__meta">
			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" class="pm-post-card__date">
				<?php echo esc_html( get_the_date() ); ?>
			</time>
			<?php
			$cats = get_the_category();
			if ( $cats ) :
			?>
				<a href="<?php echo esc_url( get_category_link( $cats[0]->term_id ) ); ?>" class="pm-post-card__cat">
					<?php echo esc_html( $cats[0]->name ); ?>
				</a>
			<?php endif; ?>
		</div>

		<h2 class="pm-post-card__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>

		<?php if ( get_the_excerpt() ) : ?>
			<p class="pm-post-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22, '&hellip;' ) ); ?></p>
		<?php endif; ?>

		<a href="<?php the_permalink(); ?>" class="pm-btn pm-btn--ghost pm-btn--sm pm-post-card__read-more">
			<?php esc_html_e( 'Read more', 'pixelmood' ); ?> &rarr;
		</a>

	</div><!-- .pm-post-card__body -->

</article>
