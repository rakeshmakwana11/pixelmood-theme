<?php
/**
 * PixelMood Theme - footer.php
 * @package pixelmood
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>

	</div><!-- #main .pm-site-main -->

	<footer class="pm-site-footer" id="colophon">
		<div class="pm-footer-inner">

			<div class="pm-footer-top">

				<div class="pm-footer-brand">
					<?php if ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<a class="pm-footer-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
							Pixel<span>Mood</span>
						</a>
					<?php endif; ?>
					<p class="pm-footer-tagline"><?php esc_html_e( 'AI Image Prompt Library', 'pixelmood' ); ?></p>
				</div>

				<div class="pm-footer-nav">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'footer',
						'menu_id'        => 'footer-menu',
						'container'      => false,
						'depth'          => 1,
						'fallback_cb'    => '__return_false',
					) );
					?>
				</div>

				<div class="pm-footer-social">
					<?php
					$instagram = get_theme_mod( 'pm_social_instagram', '' );
					$twitter   = get_theme_mod( 'pm_social_twitter', '' );
					$youtube   = get_theme_mod( 'pm_social_youtube', '' );
					?>
					<?php if ( $instagram ) : ?>
						<a href="<?php echo esc_url( $instagram ); ?>" class="pm-social-link" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><circle cx="12" cy="12" r="3"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>
						</a>
					<?php endif; ?>
					<?php if ( $twitter ) : ?>
						<a href="<?php echo esc_url( $twitter ); ?>" class="pm-social-link" target="_blank" rel="noopener noreferrer" aria-label="Twitter / X">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.253 5.622 5.912-5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
						</a>
					<?php endif; ?>
					<?php if ( $youtube ) : ?>
						<a href="<?php echo esc_url( $youtube ); ?>" class="pm-social-link" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
						</a>
					<?php endif; ?>
				</div>

			</div>

			<div class="pm-footer-bottom">
				<p class="pm-footer-copy">
					&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>.
					<?php esc_html_e( 'All rights reserved.', 'pixelmood' ); ?>
				</p>
				<p class="pm-footer-made"><?php esc_html_e( 'Built for creators & dreamers.', 'pixelmood' ); ?></p>
			</div>

		</div>
	</footer>

</body>
<?php wp_footer(); ?>
</html>
