<?php
/**
 * The template for displaying comments
 *
 * @package PixelMood
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$pixelmood_comment_count = get_comments_number();
			if ( '1' === $pixelmood_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'pixelmood' ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			} else {
				printf(
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $pixelmood_comment_count, 'comments title', 'pixelmood' ) ),
					number_format_i18n( $pixelmood_comment_count ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			}
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 48,
					'callback'    => 'pixelmood_comment_template',
				)
			);
			?>
		</ol>

		<?php
		the_comments_navigation(
			array(
				'prev_text' => esc_html__( '&larr; Older comments', 'pixelmood' ),
				'next_text' => esc_html__( 'Newer comments &rarr;', 'pixelmood' ),
			)
		);
		?>

	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'pixelmood' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'title_reply'          => esc_html__( 'Leave a Reply', 'pixelmood' ),
			'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'pixelmood' ),
			'cancel_reply_link'    => esc_html__( 'Cancel reply', 'pixelmood' ),
			'label_submit'         => esc_html__( 'Post Comment', 'pixelmood' ),
			'class_submit'         => 'pm-btn pm-btn-primary',
			'comment_notes_before' => '',
		)
	);
	?>

</div><!-- #comments -->
