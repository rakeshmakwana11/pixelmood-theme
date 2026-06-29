<?php
/**
 * Template part for displaying prompt content in loops
 *
 * @package PixelMood
 */

$prompt_id = get_post_meta( get_the_ID(), '_prompt_id', true );
$categories = get_the_terms( get_the_ID(), 'prompt_category' );
$tags       = get_the_terms( get_the_ID(), 'prompt_tag' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'prompt-card' ); ?>>
	<a href="<?php the_permalink(); ?>" class="prompt-card-link" aria-label="<?php echo esc_attr( get_the_title() ); ?>">

		<!-- Featured Image -->
		<div class="prompt-card-image">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy', 'alt' => get_the_title() ) ); ?>
			<?php else : ?>
				<div class="prompt-card-image-placeholder">
					<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
						<rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
						<circle cx="8.5" cy="8.5" r="1.5"/>
						<polyline points="21 15 16 10 5 21"/>
					</svg>
				</div>
			<?php endif; ?>

			<!-- Category Badge -->
			<?php if ( $categories && ! is_wp_error( $categories ) ) : ?>
			<div class="prompt-card-category">
				<?php echo esc_html( $categories[0]->name ); ?>
			</div>
			<?php endif; ?>
		</div>

		<!-- Card Body -->
		<div class="prompt-card-body">
			<?php if ( $prompt_id ) : ?>
			<span class="prompt-id-badge"><?php echo esc_html( $prompt_id ); ?></span>
			<?php endif; ?>

			<h3 class="prompt-card-title"><?php the_title(); ?></h3>

			<p class="prompt-card-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 15, '...' ) ); ?></p>

			<!-- Tags -->
			<?php if ( $tags && ! is_wp_error( $tags ) ) : ?>
			<div class="prompt-card-tags">
				<?php foreach ( array_slice( $tags, 0, 3 ) as $tag ) : ?>
					<span class="prompt-tag">#<?php echo esc_html( $tag->name ); ?></span>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>

	</a>

	<!-- Action Buttons (outside the main link) -->
	<div class="prompt-card-actions">
		<button
			class="pm-btn pm-btn-copy copy-prompt-btn"
			data-prompt="<?php echo esc_attr( get_the_content() ); ?>"
			aria-label="<?php esc_attr_e( 'Copy prompt', 'pixelmood' ); ?>"
		>
			<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
			<?php esc_html_e( 'Copy', 'pixelmood' ); ?>
		</button>
		<a href="<?php the_permalink(); ?>" class="pm-btn pm-btn-outline">
			<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
			<?php esc_html_e( 'View', 'pixelmood' ); ?>
		</a>
	</div>

</article><!-- .prompt-card -->
