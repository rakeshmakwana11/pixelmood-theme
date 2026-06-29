<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package PixelMood
 */
?>

<section class="no-results not-found">
	<div class="page-content empty-state">
		<div class="empty-state-icon">
			<svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
				<circle cx="11" cy="11" r="8"/>
				<line x1="21" y1="21" x2="16.65" y2="16.65"/>
				<line x1="8" y1="11" x2="14" y2="11"/>
			</svg>
		</div>

		<?php if ( is_search() ) : ?>
			<h2 class="page-title"><?php esc_html_e( 'Nothing Found', 'pixelmood' ); ?></h2>
			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'pixelmood' ); ?></p>
			<div class="search-form-wrap">
				<?php get_search_form(); ?>
			</div>

		<?php elseif ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
			<h2 class="page-title"><?php esc_html_e( 'Ready to publish your first post?', 'pixelmood' ); ?></h2>
			<p>
				<?php
				printf(
					/* translators: 1: link to WP admin new post page. */
					wp_kses(
						__( '<a href="%1$s">Get started here</a>.', 'pixelmood' ),
						array(
							'a' => array(
								'href' => array(),
							),
						)
					),
					esc_url( admin_url( 'post-new.php' ) )
				);
				?>
			</p>

		<?php else : ?>
			<h2 class="page-title"><?php esc_html_e( 'Nothing Found', 'pixelmood' ); ?></h2>
			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'pixelmood' ); ?></p>
			<div class="search-form-wrap">
				<?php get_search_form(); ?>
			</div>
		<?php endif; ?>
	</div>
</section><!-- .no-results -->
