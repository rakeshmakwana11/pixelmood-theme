<?php
/**
 * PixelMood Theme — page.php
 * Template for static WordPress pages.
 *
 * @package pixelmood
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<main id="main" class="pm-main" role="main">
	<div class="pm-container pm-section">

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'pm-page' ); ?>>

				<header class="pm-page__header">
					<h1 class="pm-page__title"><?php the_title(); ?></h1>
				</header>

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="pm-page__featured-image">
						<?php the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) ); ?>
					</div>
				<?php endif; ?>

				<div class="pm-page__content pm-prose">
					<?php the_content(); ?>
				</div>

				<?php
				wp_link_pages( array(
					'before' => '<div class="pm-page-links">' . esc_html__( 'Pages:', 'pixelmood' ),
					'after'  => '</div>',
				) );
				?>

			</article>

			<?php if ( comments_open() || get_comments_number() ) : ?>
				<?php comments_template(); ?>
			<?php endif; ?>

		<?php endwhile; ?>

	</div>
</main>

<?php get_footer(); ?>
