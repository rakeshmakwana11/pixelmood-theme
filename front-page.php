<?php
/**
 * PixelMood Theme - front-page.php
 * Homepage: Hero, Search, Category Filters, Latest Prompts Grid
 * @package pixelmood
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$hero_title    = get_theme_mod( 'pm_hero_title', 'PixelMood' );
$prompts_page  = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
$per_page      = 12;
$active_cat    = isset( $_GET['cat'] ) ? sanitize_text_field( $_GET['cat'] ) : '';

$args = array(
	'post_type'      => 'prompt',
	'posts_per_page' => $per_page,
	'paged'          => $prompts_page,
	'post_status'    => 'publish',
);

if ( $active_cat ) {
	$args['tax_query'] = array(
		array(
			'taxonomy' => 'prompt_category',
			'field'    => 'slug',
			'terms'    => $active_cat,
		),
	);
}

$prompts_query = new WP_Query( $args );

$all_cats = get_terms( array(
	'taxonomy'   => 'prompt_category',
	'hide_empty' => true,
) );

get_header();
?>

<section class="pm-hero">
	<div class="pm-hero-inner">
		<h1 class="pm-hero-title"><?php echo esc_html( $hero_title ); ?></h1>
		<p class="pm-hero-sub"><?php esc_html_e( 'Discover & copy AI image prompts for every mood.', 'pixelmood' ); ?></p>

		<form class="pm-search-form pm-hero-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<div class="pm-search-wrap">
				<svg class="pm-search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
				<input
					type="search"
					class="pm-search-input"
					name="s"
					placeholder="<?php esc_attr_e( 'Search prompts, tags, categories or Prompt ID...', 'pixelmood' ); ?>"
					value="<?php echo esc_attr( get_search_query() ); ?>"
					autocomplete="off"
				/>
				<input type="hidden" name="post_type" value="prompt">
				<button type="submit" class="pm-btn pm-btn--primary"><?php esc_html_e( 'Search', 'pixelmood' ); ?></button>
			</div>
		</form>
	</div>
</section>

<section class="pm-home-main">
	<div class="pm-container">

		<div class="pm-cat-filters" id="pm-cat-filters">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="pm-cat-pill <?php echo ( '' === $active_cat ) ? 'pm-cat-pill--active' : ''; ?>">
				<?php esc_html_e( 'All', 'pixelmood' ); ?>
			</a>
			<?php if ( ! empty( $all_cats ) && ! is_wp_error( $all_cats ) ) : ?>
				<?php foreach ( $all_cats as $cat ) : ?>
					<a href="<?php echo esc_url( add_query_arg( 'cat', $cat->slug, home_url( '/' ) ) ); ?>" class="pm-cat-pill <?php echo ( $active_cat === $cat->slug ) ? 'pm-cat-pill--active' : ''; ?>">
						<?php echo esc_html( $cat->name ); ?>
					</a>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>

		<div class="pm-section-header">
			<h2 class="pm-section-title">
				<?php echo $active_cat ? esc_html( ucfirst( $active_cat ) ) . ' ' . esc_html__( 'Prompts', 'pixelmood' ) : esc_html__( 'Latest Prompts', 'pixelmood' ); ?>
			</h2>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'prompt' ) ); ?>" class="pm-view-all">
				<?php esc_html_e( 'View All', 'pixelmood' ); ?> &rarr;
			</a>
		</div>

		<?php if ( $prompts_query->have_posts() ) : ?>
			<div class="pm-grid" id="pm-prompts-grid">
				<?php while ( $prompts_query->have_posts() ) : $prompts_query->the_post(); ?>
					<?php get_template_part( 'template-parts/prompt-card' ); ?>
				<?php endwhile; ?>
			</div>

			<div class="pm-pagination">
				<?php
				echo paginate_links( array(
					'base'    => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
					'format'  => '?paged=%#%',
					'current' => max( 1, $prompts_page ),
					'total'   => $prompts_query->max_num_pages,
					'prev_text' => '&larr; ' . __( 'Prev', 'pixelmood' ),
					'next_text' => __( 'Next', 'pixelmood' ) . ' &rarr;',
				) );
				?>
			</div>

		<?php else : ?>
			<div class="pm-no-results">
				<p><?php esc_html_e( 'No prompts found. Add your first prompt from the WordPress admin.', 'pixelmood' ); ?></p>
				<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=prompt' ) ); ?>" class="pm-btn pm-btn--primary"><?php esc_html_e( 'Add New Prompt', 'pixelmood' ); ?></a>
			</div>
		<?php endif; ?>

		<?php wp_reset_postdata(); ?>

	</div>
</section>

<?php get_footer(); ?>
