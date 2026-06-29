<?php
/**
 * PixelMood Theme - archive-prompts.php
 * The /prompts/ archive page.
 * @package pixelmood
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$all_cats   = get_terms( array( 'taxonomy' => 'prompt_category', 'hide_empty' => true ) );
$active_cat = isset( $_GET['cat'] ) ? sanitize_text_field( $_GET['cat'] ) : '';
$search_q   = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : '';
$paged      = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

$args = array(
	'post_type'      => 'prompt',
	'posts_per_page' => 12,
	'paged'          => $paged,
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

if ( $search_q ) {
	$args['s'] = $search_q;
}

$prompts_query = new WP_Query( $args );

get_header();
?>

<div class="pm-archive-header">
	<div class="pm-container">
		<h1 class="pm-archive-title"><?php esc_html_e( 'All Prompts', 'pixelmood' ); ?></h1>
		<p class="pm-archive-count">
			<?php
			$total = $prompts_query->found_posts;
			/* translators: %d: number of prompts */
			printf( esc_html__( '%d prompts available', 'pixelmood' ), $total );
			?>
		</p>
	</div>
</div>

<div class="pm-archive-toolbar pm-container">

	<form class="pm-search-form" role="search" method="get" action="<?php echo esc_url( get_post_type_archive_link( 'prompt' ) ); ?>">
		<div class="pm-search-wrap">
			<svg class="pm-search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
			<input type="search" class="pm-search-input" name="s" placeholder="<?php esc_attr_e( 'Search prompts, tags, categories or Prompt ID...', 'pixelmood' ); ?>" value="<?php echo esc_attr( $search_q ); ?>" autocomplete="off">
			<button type="submit" class="pm-btn pm-btn--primary"><?php esc_html_e( 'Search', 'pixelmood' ); ?></button>
		</div>
	</form>

	<div class="pm-cat-filters">
		<a href="<?php echo esc_url( get_post_type_archive_link( 'prompt' ) ); ?>" class="pm-cat-pill <?php echo ( '' === $active_cat ) ? 'pm-cat-pill--active' : ''; ?>">
			<?php esc_html_e( 'All', 'pixelmood' ); ?>
		</a>
		<?php if ( ! empty( $all_cats ) && ! is_wp_error( $all_cats ) ) : ?>
			<?php foreach ( $all_cats as $cat ) : ?>
				<a href="<?php echo esc_url( add_query_arg( 'cat', $cat->slug, get_post_type_archive_link( 'prompt' ) ) ); ?>" class="pm-cat-pill <?php echo ( $active_cat === $cat->slug ) ? 'pm-cat-pill--active' : ''; ?>">
					<?php echo esc_html( $cat->name ); ?>
				</a>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>

</div>

<div class="pm-container">

	<?php if ( $prompts_query->have_posts() ) : ?>
		<div class="pm-grid" id="pm-prompts-grid">
			<?php while ( $prompts_query->have_posts() ) : $prompts_query->the_post(); ?>
				<?php get_template_part( 'template-parts/prompt-card' ); ?>
			<?php endwhile; ?>
		</div>

		<div class="pm-pagination">
			<?php
			echo paginate_links( array(
				'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
				'format'    => '?paged=%#%',
				'current'   => max( 1, $paged ),
				'total'     => $prompts_query->max_num_pages,
				'prev_text' => '&larr; ' . __( 'Prev', 'pixelmood' ),
				'next_text' => __( 'Next', 'pixelmood' ) . ' &rarr;',
			) );
			?>
		</div>

	<?php else : ?>
		<div class="pm-no-results">
			<h2><?php esc_html_e( 'No Prompts Found', 'pixelmood' ); ?></h2>
			<p><?php esc_html_e( 'Try a different search term or browse all categories.', 'pixelmood' ); ?></p>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'prompt' ) ); ?>" class="pm-btn pm-btn--primary">
				<?php esc_html_e( 'View All Prompts', 'pixelmood' ); ?>
			</a>
		</div>
	<?php endif; ?>

	<?php wp_reset_postdata(); ?>

</div>

<?php get_footer(); ?>
