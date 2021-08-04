<?php do_action( 'aperitto_before_post_article' ); ?>
<article <?php post_class(); ?>><?php

	do_action( 'aperitto_before_post_title' );
	if ( is_single() ) :

		do_action( 'aperitto_single_before_title' ); ?>
		<h1><?php the_title(); ?></h1>
		<?php do_action( 'aperitto_single_after_title' );

	else:

		do_action( 'aperitto_postexcerpt_before_title' ); ?>
		<h2><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
		<?php do_action( 'aperitto_postexcerpt_after_title' );

	endif;
	do_action( 'aperitto_after_post_title' );
	?>

	<div class="entry-box clearfix">

		<?php
		if ( ! is_single() ) {

			$thumbnail_size = apply_filters( 'aperitto_singular_thumbnail_size', 'medium' );
			$attributes     = apply_filters( 'aperitto_singular_thumbnail_attr', array('class'=>'thumbnail') );

			if ( has_post_thumbnail() ) {
				$show_thumb = ( get_theme_mod('show_mobile_thumb') ) ? ' show' : '';
				do_action( 'aperitto_before_post_thumbnail' ); ?>
				<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" class="anons-thumbnail<?php echo $show_thumb; ?>">
					<?php the_post_thumbnail( $thumbnail_size, $attributes ); ?>
				</a>
				<?php do_action( 'aperitto_after_post_thumbnail' );
			}

			do_action( 'aperitto_before_post_excerpt' );
			the_excerpt();
			do_action( 'aperitto_after_post_excerpt' );

		} else {

			do_action( 'aperitto_before_single_content' );
			the_content( '' );
			do_action( 'aperitto_after_single_content' );

			wp_link_pages(
				array(
					'before'   => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'aperitto' ) . '">',
					'after'    => '</nav>',
					/* translators: %: Page number. */
					'pagelink' => esc_html__( 'Page %', 'aperitto' ),
				)
			);

		} ?>

	</div>
	<div class="clearfix"></div>
	<?php

	if ( is_single() ) { ?>
		<aside class="meta"><?php the_tags(); ?></aside>
	<?php }

	do_action( 'aperitto_before_close_post_article' ); ?>

</article>

<?php do_action( 'aperitto_after_post_article' ); ?>

