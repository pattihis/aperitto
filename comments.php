<?php
if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area">

<?php if ( have_comments() ) : ?>
	<h3 class="comments-title"><?php _e('Comments', 'aperitto'); ?> <span class="cnt"><i class="fa fa-comments-o"></i><?php comments_number('0', '1', '%' );?></span></h3>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :  ?>
		<div class="comment-navigation">
			<div class="nav-prev"><?php previous_comments_link( __('&larr; Older Comments', 'aperitto') ); ?></div>
			<div class="nav-next"><?php next_comments_link( __('Newer Comments &rarr;', 'aperitto') ); ?></div>
		</div>
		<?php endif; ?>

		<?php do_action( 'aperitto_before_comment_list' ); ?>
		<ul class="comment-list">
			<?php
				$comm_args = array(
					'avatar_size' => '60',
					'callback' => 'aperitto_html5_comment'
				);

				wp_list_comments( $comm_args );
			?>
		</ul><!-- .comment-list -->
		<?php do_action( 'aperitto_after_comment_list' ); ?>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :  ?>
		<div class="comment-navigation">
			<div class="nav-prev"><?php previous_comments_link( __('&larr; Older Comments', 'aperitto') ); ?></div>
			<div class="nav-next"><?php next_comments_link( __('Newer Comments &rarr;', 'aperitto') ); ?></div>
		</div>
		<?php endif; ?>

<?php endif; // have_comments()

	do_action( 'aperitto_before_comment_form' );
	comment_form();
	do_action( 'aperitto_after_comment_form' ); ?>

</div><!-- #comments -->
