<?php get_header(); ?>
	<main id="content" class="content">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php do_action( 'aperitto_before_page_article' ); ?>
			<article class="post page" id="pageid-<?php the_ID(); ?>">

				<?php do_action( 'aperitto_before_page_title' );  ?>
				<h1><?php the_title(); ?></h1>
				<?php do_action( 'aperitto_after_page_title' );  ?>

				<?php do_action( 'aperitto_before_page_content_box' );  ?>
				<div class="entry-box clearfix">
					<?php do_action( 'aperitto_before_page_content' );  ?>
					<?php the_content(); ?>
					<?php do_action( 'aperitto_after_page_content' );  ?>
				</div>
				<?php do_action( 'aperitto_after_page_content_box' );  ?>

				<?php wp_link_pages(
						array(
							'before'   => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'aperitto' ) . '">',
							'after'    => '</nav>',
							/* translators: %: Page number. */
							'pagelink' => esc_html__( 'Page %', 'aperitto' ),
						)
					); ?>

			</article>
			<?php do_action( 'aperitto_after_page_article' ); ?>


			<?php

			if ( comments_open() || get_comments_number() ) {
				do_action( 'aperitto_before_page_comments_area' );
				comments_template();
				do_action( 'aperitto_after_page_comments_area' );
			}

		endwhile; ?>

	</main> <!-- #content -->
	<?php get_sidebar(); ?>
<?php get_footer(); ?>
