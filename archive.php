<?php get_header(); ?>
	<main id="content">
    <?php do_action( 'aperitto_main_archive_inner_begin' ); ?>

<?php if (have_posts()) :

	$post = $posts[0];
	$not_paged = get_query_var('paged');
	$not_paged = ( empty($not_paged) ) ? true : false;

	?>

	<header class="inform">
	<?php if (is_category()) : ?>
		<h1><?php _e( 'Category', 'aperitto' ); ?> &laquo;<?php single_cat_title(''); ?>&raquo;</h1>
		<?php if ( $not_paged ) echo '<div class="archive-desc">'. category_description() .'</div>'; ?>
	<?php elseif( is_tag() ) : ?>
		<h1><?php _e( 'Tag', 'aperitto' ); ?> &laquo;<?php single_tag_title(); ?>&raquo;</h1>
		<?php if ( $not_paged ) echo '<div class="archive-desc">'. tag_description() .'</div>'; ?>
	<?php elseif (is_day()) : ?>
		<h1><?php _e( 'Day archives:', 'aperitto' ); ?> <?php the_time('F jS, Y'); ?></h1>
	<?php elseif (is_month()) : ?>
		<h1><?php _e( 'Monthly archives:', 'aperitto' ); ?> <?php the_time('F, Y'); ?></h1>
	<?php elseif (is_year()) : ?>
		<h1><?php _e( 'Year archives:', 'aperitto' ); ?> <?php the_time('Y'); ?></h1>
	<?php elseif (is_author()) : ?>
		<h1><?php _e( 'Author archives', 'aperitto' ); ?></h1>
		<div class="archive-desc"><?php the_author_meta('description'); ?></div>
	<?php elseif (isset($_GET['paged']) && !empty($_GET['paged'])) : ?>
		<h1 class="arhivetitle"><?php _e( 'Archive', 'aperitto' ); ?></h1>
 	<?php endif; ?>
	</header>

	<?php do_action( 'aperitto_main_archive_after_before_loop' ); ?>

	<?php while (have_posts()) : the_post();

		get_template_part( 'content' );

	endwhile;

	the_posts_pagination( apply_filters( 'aperitto_archive_posts_pagination_args', array(
		'mid_size' => 2,
		'prev_text' => __( '&laquo; Prev', 'aperitto'),
		'next_text' => __( 'Next &raquo;', 'aperitto'),
	)) );


else: ?>

	<div class="post">
		<h1><?php _e( 'Posts not found', 'aperitto' ); ?></h1>
		<?php get_search_form(); ?>
	 </div>

<?php endif; ?>

    <?php do_action( 'aperitto_main_archive_inner_end' ); ?>
	</main> <!-- #content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
