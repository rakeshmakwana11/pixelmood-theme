<?php
/**
 * PixelMood Theme — template-parts/prompt-card.php
 * Reusable prompt card component. Uses current post in the Loop.
 *
 * @package pixelmood
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$post_id    = get_the_ID();
$prompt_id  = get_post_meta( $post_id, '_prompt_id', true );
$permalink  = get_permalink();
$title      = get_the_title();
$excerpt    = get_the_excerpt();
$content    = get_the_content();
$plain_text = wp_strip_all_tags( $content );
$categories = get_the_terms( $post_id, 'prompt_category' );
$tags       = get_the_terms( $post_id, 'prompt_tag' );
$thumb_id   = get_post_thumbnail_id();
?>
<article class="pm-card" data-post-id="<?php echo esc_attr( $post_id ); ?>">

	<!-- Invisible full-card link -->
	<a href="<?php echo esc_url( $permalink ); ?>" class="pm-card__overlay-link" tabindex="-1" aria-hidden="true"></a>

	<!-- Image -->
	<div class="pm-card__image-wrap">
		<?php if ( $thumb_id ) : ?>
			<img
				class="pm-card__image"
				src="<?php echo esc_url( wp_get_attachment_image_url( $thumb_id, 'prompt-card' ) ); ?>"
				alt="<?php echo esc_attr( $title ); ?>"
				loading="lazy"
				width="600"
				height="340"
			/>
		<?php else : ?>
			<div class="pm-card__image-placeholder" aria-hidden="true">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" aria-hidden="true" width="40" height="40">
					<rect x="3" y="3" width="18" height="18" rx="2"/>
					<circle cx="8.5" cy="8.5" r="1.5"/>
					<polyline points="21 15 16 10 5 21"/>
				</svg>
			</div>
		<?php endif; ?>

		<!-- Category badge overlay -->
		<?php if ( $categories && ! is_wp_error( $categories ) ) : ?>
			<a
				href="<?php echo esc_url( get_term_link( $categories[0] ) ); ?>"
				class="pm-card__cat-badge"
			><?php echo esc_html( $categories[0]->name ); ?></a>
		<?php endif; ?>
	</div><!-- .pm-card__image-wrap -->

	<!-- Body -->
	<div class="pm-card__body">

		<!-- Meta: ID -->
		<div class="pm-card__meta">
			<?php if ( $prompt_id ) : ?>
				<span class="pm-card__id"><?php echo esc_html( $prompt_id ); ?></span>
			<?php endif; ?>
			<time class="pm-card__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
				<?php echo esc_html( get_the_date( 'M j, Y' ) ); ?>
			</time>
		</div>

		<!-- Title -->
		<h3 class="pm-card__title">
			<a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a>
		</h3>

		<!-- Excerpt -->
		<?php if ( $excerpt ) : ?>
			<p class="pm-card__excerpt"><?php echo esc_html( wp_trim_words( $excerpt, 18, '&hellip;' ) ); ?></p>
		<?php endif; ?>

		<!-- Tags -->
		<?php if ( $tags && ! is_wp_error( $tags ) ) : ?>
			<div class="pm-card__tags">
				<?php foreach ( array_slice( $tags, 0, 4 ) as $tag ) : ?>
					<a href="<?php echo esc_url( get_term_link( $tag ) ); ?>" class="pm-tag">
						#<?php echo esc_html( $tag->name ); ?>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<!-- Actions -->
		<div class="pm-card__actions">
			<button
				class="pm-btn pm-btn--ghost pm-btn--sm pm-copy-btn"
				data-content="<?php echo esc_attr( $plain_text ); ?>"
				aria-label="<?php esc_attr_e( 'Copy prompt to clipboard', 'pixelmood' ); ?>"
			>
				<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
				<?php esc_html_e( 'Copy', 'pixelmood' ); ?>
			</button>
			<a href="<?php echo esc_url( $permalink ); ?>" class="pm-btn pm-btn--primary pm-btn--sm">
				<?php esc_html_e( 'View', 'pixelmood' ); ?> &rarr;
			</a>
		</div>

	</div><!-- .pm-card__body -->

</article><!-- .pm-card -->
