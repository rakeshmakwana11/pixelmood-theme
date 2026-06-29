<?php
/**
 * The template for displaying archive pages (Blog)
 *
 * @package PixelMood
 */

get_header(); ?>

<main id="primary" class="site-main">
	<div class="container">

		<header class="page-header archive-header">
			<?php
			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="archive-description">', '</div>' );
			?>
		</header>

		<div class="blog-layout">
			<div class="blog-main">
				<?php if ( have_posts() ) : ?>

					<div class="posts-grid">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'template-parts/content', get_post_type() ); ?>
						<?php endwhile; ?>
					</div>

					<?php
					the_posts_pagination(
						array(
							'mid_size'  => 2,
							'prev_text' => __( '&larr; Prev', 'pixelmood' ),
							'next_text' => __( 'Next &rarr;', 'pixelmood' ),
						)
					);
					?>

				<?php else : ?>
					<?php get_template_part( 'template-parts/content', 'none' ); ?>
				<?php endif; ?>
			</div>

			<?php get_sidebar(); ?>
		</div>

	</div><!-- .container -->
</main>

<?php get_footer(); ?>
