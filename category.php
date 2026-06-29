<?php
/**
 * The template for displaying category archive pages (Blog)
 *
 * @package PixelMood
 */

get_header(); ?>

<main id="primary" class="site-main">
	<div class="container">

		<header class="page-header archive-header">
			<?php
			$current_cat = get_queried_object();
			?>
			<h1 class="page-title">
				<?php echo esc_html( $current_cat->name ); ?>
			</h1>
			<?php if ( ! empty( $current_cat->description ) ) : ?>
			<div class="archive-description">
				<p><?php echo esc_html( $current_cat->description ); ?></p>
			</div>
			<?php endif; ?>
			<div class="archive-meta">
				<?php
				$count = $current_cat->count;
				echo '<span>' . sprintf( esc_html( _n( '%s post', '%s posts', $count, 'pixelmood' ) ), number_format_i18n( $count ) ) . '</span>';
				?>
			</div>
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
