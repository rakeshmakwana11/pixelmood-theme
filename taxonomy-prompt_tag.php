<?php
/**
 * PixelMood Theme - taxonomy-prompt_tag.php
 * Tag archive for prompt_tag taxonomy.
 * @package pixelmood
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$term      = get_queried_object();
$term_name = $term ? $term->name : esc_html__( 'Tag', 'pixelmood' );
$term_desc = $term ? $term->description : '';

get_header();
?>

<div class="pm-archive-header">
	<div class="pm-container">
		<p class="pm-archive-label"><?php esc_html_e( 'Prompt Tag', 'pixelmood' ); ?></p>
		<h1 class="pm-archive-title">#<?php echo esc_html( $term_name ); ?></h1>
		<?php if ( $term_desc ) : ?>
			<p class="pm-archive-desc"><?php echo esc_html( $term_desc ); ?></p>
		<?php endif; ?>
		<?php if ( $term ) : ?>
			<p class="pm-archive-count">
				<?php
				/* translators: %d: number of prompts */
				printf( esc_html__( '%d prompts', 'pixelmood' ), (int) $term->count );
				?>
			</p>
		<?php endif; ?>
	</div>
</div>

<div class="pm-container">

	<?php if ( have_posts() ) : ?>
		<div class="pm-grid">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/prompt-card' ); ?>
			<?php endwhile; ?>
		</div>

		<div class="pm-pagination">
			<?php the_posts_pagination( array(
				'prev_text' => '&larr; ' . __( 'Prev', 'pixelmood' ),
				'next_text' => __( 'Next', 'pixelmood' ) . ' &rarr;',
			) ); ?>
		</div>

	<?php else : ?>
		<div class="pm-no-results">
			<p><?php esc_html_e( 'No prompts found with this tag.', 'pixelmood' ); ?></p>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'prompt' ) ); ?>" class="pm-btn pm-btn--primary"><?php esc_html_e( 'Browse All Prompts', 'pixelmood' ); ?></a>
		</div>
	<?php endif; ?>

</div>

<?php get_footer(); ?>
