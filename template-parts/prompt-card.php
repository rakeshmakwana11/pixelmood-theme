<?php
/**
 * PixelMood Theme - template-parts/prompt-card.php
 * Reusable prompt card. Uses current post in The Loop.
 * @package pixelmood
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$post_id    = get_the_ID();
$permalink  = get_permalink();
$title      = get_the_title();
$prompt_id  = get_post_meta( $post_id, '_prompt_id', true );
$excerpt    = get_the_excerpt();
$content    = get_the_content();
$categories = get_the_terms( $post_id, 'prompt_category' );
$tags       = get_the_terms( $post_id, 'prompt_tag' );
?>

<article class="pm-card" id="prompt-<?php echo esc_attr( $post_id ); ?>" data-post-id="<?php echo esc_attr( $post_id ); ?>">

	<a class="pm-card-link" href="<?php echo esc_url( $permalink ); ?>" tabindex="-1" aria-hidden="true"></a>

	<div class="pm-card-image">
		<?php if ( has_post_thumbnail() ) : ?>
			<a href="<?php echo esc_url( $permalink ); ?>" tabindex="-1">
				<?php the_post_thumbnail( 'prompt-card', array( 'alt' => esc_attr( $title ), 'loading' => 'lazy' ) ); ?>
			</a>
		<?php else : ?>
			<a href="<?php echo esc_url( $permalink ); ?>" tabindex="-1">
				<div class="pm-card-image-placeholder">
					<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
				</div>
			</a>
		<?php endif; ?>

		<?php if ( $prompt_id ) : ?>
			<span class="pm-card-id-badge"><?php echo esc_html( $prompt_id ); ?></span>
		<?php endif; ?>
	</div>

	<div class="pm-card-body">

		<?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
			<div class="pm-card-cats">
				<?php foreach ( $categories as $cat ) : ?>
					<a class="pm-cat-badge" href="<?php echo esc_url( get_term_link( $cat ) ); ?>">
						<?php echo esc_html( $cat->name ); ?>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<h3 class="pm-card-title">
			<a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a>
		</h3>

		<?php if ( $excerpt ) : ?>
			<p class="pm-card-excerpt"><?php echo esc_html( wp_trim_words( $excerpt, 18, '...' ) ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) : ?>
			<div class="pm-card-tags">
				<?php foreach ( array_slice( $tags, 0, 4 ) as $tag ) : ?>
					<a class="pm-tag" href="<?php echo esc_url( get_term_link( $tag ) ); ?>">
						#<?php echo esc_html( $tag->name ); ?>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="pm-card-footer">
			<button
				class="pm-btn pm-btn--ghost pm-btn--sm pm-copy-btn"
				data-prompt="<?php echo esc_attr( wp_strip_all_tags( $content ) ); ?>"
				aria-label="<?php esc_attr_e( 'Copy Prompt', 'pixelmood' ); ?>"
			>
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
				<?php esc_html_e( 'Copy', 'pixelmood' ); ?>
			</button>
			<a class="pm-btn pm-btn--primary pm-btn--sm" href="<?php echo esc_url( $permalink ); ?>">
				<?php esc_html_e( 'View Prompt', 'pixelmood' ); ?> &rarr;
			</a>
		</div>

	</div>

</article>
