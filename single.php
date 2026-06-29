<?php
/**
 * The template for displaying all single posts (Blog)
 *
 * @package PixelMood
 */

get_header(); ?>

<main id="primary" class="site-main">
	<div class="container">
		<div class="blog-layout">
			<div class="blog-main">
				<?php
				while ( have_posts() ) :
					the_post();
				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post-article' ); ?>>

					<!-- Post Header -->
					<header class="entry-header">
						<?php
						$categories = get_the_category();
						if ( $categories ) :
						?>
						<div class="post-categories">
							<?php foreach ( $categories as $cat ) : ?>
								<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="post-category-badge">
									<?php echo esc_html( $cat->name ); ?>
								</a>
							<?php endforeach; ?>
						</div>
						<?php endif; ?>

						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

						<div class="entry-meta">
							<span class="post-author">
								<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
								<?php the_author(); ?>
							</span>
							<span class="post-date">
								<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
								<?php echo get_the_date(); ?>
							</span>
							<span class="post-read-time">
								<?php
								$content = get_the_content();
								$word_count = str_word_count( strip_tags( $content ) );
								$read_time = max( 1, ceil( $word_count / 200 ) );
								echo $read_time . ' min read';
								?>
							</span>
						</div>
					</header>

					<!-- Featured Image -->
					<?php if ( has_post_thumbnail() ) : ?>
					<div class="post-featured-image">
						<?php the_post_thumbnail( 'large', array( 'class' => 'rounded-image', 'loading' => 'lazy' ) ); ?>
					</div>
					<?php endif; ?>

					<!-- Post Content -->
					<div class="entry-content">
						<?php
						the_content(
							sprintf(
								wp_kses(
									/* translators: %s: Name of current post. Only visible to screen readers */
									__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'pixelmood' ),
									array(
										'span' => array(
											'class' => array(),
										),
									)
								),
								wp_kses_post( get_the_title() )
							)
						);

						wp_link_pages(
							array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'pixelmood' ),
								'after'  => '</div>',
							)
						);
						?>
					</div>

					<!-- Post Footer: Tags -->
					<footer class="entry-footer">
						<?php
						$tags = get_the_tags();
						if ( $tags ) :
						?>
						<div class="post-tags">
							<span class="tags-label"><?php esc_html_e( 'Tags:', 'pixelmood' ); ?></span>
							<?php foreach ( $tags as $tag ) : ?>
								<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="post-tag">#<?php echo esc_html( $tag->name ); ?></a>
							<?php endforeach; ?>
						</div>
						<?php endif; ?>
					</footer>

					<!-- Post Navigation -->
					<nav class="post-navigation" aria-label="<?php esc_attr_e( 'Post navigation', 'pixelmood' ); ?>">
						<div class="nav-links">
							<?php
							$prev_post = get_previous_post();
							$next_post = get_next_post();
							if ( $prev_post ) :
							?>
							<a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>" class="nav-previous">
								<span class="nav-label"><?php esc_html_e( '← Previous Post', 'pixelmood' ); ?></span>
								<span class="nav-title"><?php echo esc_html( get_the_title( $prev_post ) ); ?></span>
							</a>
							<?php endif; ?>
							<?php if ( $next_post ) : ?>
							<a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" class="nav-next">
								<span class="nav-label"><?php esc_html_e( 'Next Post →', 'pixelmood' ); ?></span>
								<span class="nav-title"><?php echo esc_html( get_the_title( $next_post ) ); ?></span>
							</a>
							<?php endif; ?>
						</div>
					</nav>

					<!-- Comments -->
					<?php if ( comments_open() || get_comments_number() ) : ?>
						<?php comments_template(); ?>
					<?php endif; ?>

				</article>

				<?php endwhile; ?>
			</div>

			<!-- Sidebar -->
			<?php get_sidebar(); ?>

		</div><!-- .blog-layout -->
	</div><!-- .container -->
</main>

<?php get_footer(); ?>
