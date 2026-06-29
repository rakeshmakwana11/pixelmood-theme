<?php
/**
 * PixelMood Theme - page.php
 * Template for static WordPress pages.
 * @package pixelmood
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<div class="pm-container pm-page">

	<?php while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'pm-page-article' ); ?>>

			<header class="pm-page-header">
				<h1 class="pm-page-title"><?php the_title(); ?></h1>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="pm-page-featured-image">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
			<?php endif; ?>

			<div class="pm-page-content entry-content">
				<?php
				the_content();
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'pixelmood' ),
					'after'  => '</div>',
				) );
				?>
			</div>

		</article>

		<?php if ( comments_open() || get_comments_number() ) : ?>
			<?php comments_template(); ?>
		<?php endif; ?>

	<?php endwhile; ?>

</div>

<?php get_footer(); ?>
