<?php get_header(); ?>
    <main id="content" class="content">
		<?php do_action( 'aperitto_main_content_inner_begin' ); ?>

		<?php woocommerce_content(); ?>

		<?php do_action( 'aperitto_main_content_inner_end' ); ?>
    </main>
    <!-- END #content -->

    <?php get_sidebar(); ?>
<?php get_footer(); ?>
