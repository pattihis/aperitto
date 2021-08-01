<?php get_header(); ?>
	<main id="content" class="content">
	<?php do_action( 'aperitto_main_content_inner_begin' ); ?>

    <?php if ( is_home() && 'customtitle' == get_theme_mod( 'home_h1_type', 'sitetitle' )  ) { ?>
        <div class="blog-home-header">
            <h1><?php echo esc_html( get_theme_mod( 'custom_home_h1', get_bloginfo('sitetitle') ) ); ?></h1>
        </div>
    <?php } ?>

<?php if (have_posts()) :
	while (have_posts()) : the_post();

		get_template_part( 'content' );

	endwhile; ?>

	<?php

	the_posts_pagination( apply_filters( 'aperitto_posts_pagination_args', array(
		'mid_size' => 2,
		'prev_text' => __( '&laquo; Prev', 'aperitto'),
		'next_text' => __( 'Next &raquo;', 'aperitto'),
	) ) );


else: ?>

	<div class="post clearfix">
	    <h2><?php _e( 'Posts not found', 'aperitto' ); ?></h2>
	    <?php get_search_form(); ?>
	</div>

<?php endif; ?>

	<?php do_action( 'aperitto_main_content_inner_end' ); ?>
	</main>
	<!-- END #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
