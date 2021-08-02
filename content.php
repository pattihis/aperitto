<?php

$markup_opt = aperitto_get_theme_option( 'schema_mark' ); // false or 0
$markup = ( is_single() && ( $markup_opt || false === $markup_opt ) ) ? true : false;

?>

<?php do_action( 'aperitto_before_post_article' ); ?>
<article <?php post_class(); ?><?php echo ( $markup ) ? ' itemscope itemtype="http://schema.org/Article"' : ''; ?>><?php

	do_action( 'aperitto_before_post_title' );
	if ( is_single() ) :

		do_action( 'aperitto_single_before_title' ); ?>
		<h1<?php echo ( $markup ) ? ' itemprop="headline"' : ''; ?>><?php the_title(); ?></h1>
		<?php do_action( 'aperitto_single_after_title' );

	else:

		do_action( 'aperitto_postexcerpt_before_title' ); ?>
		<h2><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
		<?php do_action( 'aperitto_postexcerpt_after_title' );

	endif;
	do_action( 'aperitto_after_post_title' );

	/**
	 * @hooked aperitto_get_postmeta() - 10
	 */
	do_action( 'aperitto_before_content' ); ?>
	<div class="entry-box clearfix" <?php if ( $markup ) { echo "itemprop='articleBody'"; } ?>>

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

			/* see also /inc/html-blocks.php that is @hooked to `aperitto_after_post_excerpt` */

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

	</div> <?php
	do_action( 'aperitto_after_content' );


	if ( is_single() ) { ?>
		<aside class="meta"><?php the_tags(); ?></aside>
	<?php }

	if ( $markup ) {
		aperitto_markup_schemaorg();
	} ?>

	<?php do_action( 'aperitto_before_close_post_article' ); ?>
</article>
<?php do_action( 'aperitto_after_post_article' ); ?>

