<?php
/**
 * PixelMood Theme — footer.php
 *
 * @package pixelmood
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<footer class="pm-site-footer" id="colophon" role="contentinfo">

	<div class="pm-footer-inner">

		<!-- Footer Brand -->
		<div class="pm-footer-brand">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="pm-footer-logo" rel="home">
					Pixel<span>Mood</span>
				</a>
			<?php endif; ?>
			<p class="pm-footer-tagline"><?php esc_html_e( 'AI Image Prompt Library — discover, copy and create.', 'pixelmood' ); ?></p>

			<!-- Social Links -->
			<div class="pm-social-links">
				<?php
				$socials = array(
					'pm_social_instagram' => array(
						'label' => 'Instagram',
						'icon'  => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>',
					),
					'pm_social_twitter'   => array(
						'label' => 'Twitter / X',
						'icon'  => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
					),
					'pm_social_youtube'   => array(
						'label' => 'YouTube',
						'icon'  => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46A2.78 2.78 0 0 0 1.46 6.42 29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58 2.78 2.78 0 0 0 1.95 1.95C5.12 20 12 20 12 20s6.88 0 8.59-.47a2.78 2.78 0 0 0 1.95-1.95A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02"/></svg>',
					),
				);
				foreach ( $socials as $mod_id => $data ) :
					$url = get_theme_mod( $mod_id );
					if ( $url ) :
				?>
					<a href="<?php echo esc_url( $url ); ?>" class="pm-social-link" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $data['label'] ); ?>">
						<?php echo $data['icon']; // phpcs:ignore WordPress.Security.EscapeOutput ?>
					</a>
				<?php
					endif;
				endforeach;
				?>
			</div>
		</div>

		<!-- Footer Nav -->
		<nav class="pm-footer-nav" aria-label="<?php esc_attr_e( 'Footer navigation', 'pixelmood' ); ?>">
			<?php if ( has_nav_menu( 'footer' ) ) : ?>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'menu_class'     => 'pm-footer-menu',
					'container'      => false,
					'depth'          => 1,
				) );
				?>
			<?php else : ?>
				<ul class="pm-footer-menu">
					<?php $archive = get_post_type_archive_link( 'prompt' ); ?>
					<?php if ( $archive ) : ?>
						<li><a href="<?php echo esc_url( $archive ); ?>"><?php esc_html_e( 'All Prompts', 'pixelmood' ); ?></a></li>
					<?php endif; ?>
					<li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Blog', 'pixelmood' ); ?></a></li>
				</ul>
			<?php endif; ?>
		</nav>

	</div><!-- .pm-footer-inner -->

	<!-- Copyright Bar -->
	<div class="pm-footer-bottom">
		<p>
			&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
			&mdash; <?php esc_html_e( 'AI Image Prompt Library', 'pixelmood' ); ?>
		</p>
	</div>

</footer><!-- #colophon -->

<!-- Toast Notification -->
<div id="pm-toast" class="pm-toast" role="status" aria-live="polite" aria-atomic="true">
	<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
	<span id="pm-toast-msg"><?php esc_html_e( 'Copied!', 'pixelmood' ); ?></span>
</div>

<?php wp_footer(); ?>

</body>
</html>
