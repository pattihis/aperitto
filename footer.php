<?php do_action( 'aperitto_main_wrap_inner_end' ); ?>
</div>
<!-- #main -->

<?php do_action( 'aperitto_before_footer' ); ?>

<footer id="footer" class="<?php echo apply_filters( 'aperitto_footer_class', '' );?>">

	<?php do_action( 'aperitto_before_footer_menu' ); ?>

	<?php if (has_nav_menu('bottom')) : ?>
	<div class="<?php echo apply_filters( 'aperitto_footer_menu_class', 'footer-menu maxwidth' );?>">
		<?php
		wp_nav_menu( array(
				'theme_location' => 'bottom',
				'menu_id' => 'footer-menu',
				'depth' => 1,
				'container' => false,
				'items_wrap' => '<ul class="footmenu clearfix">%3$s</ul>'
			));
		?>
	</div>
	<?php endif; ?>

	<?php do_action( 'aperitto_before_footer_copyrights' ); ?>
    <?php if ( apply_filters( 'aperitto_footer_copyrights_enabled', true ) ) : ?>
	<div class="<?php echo apply_filters( 'aperitto_footer_copyrights_class', 'copyrights maxwidth grid' );?>">
		<div class="<?php echo apply_filters( 'aperitto_footer_copytext_class', 'copytext col6' );?>">
			<p id="copy">
				<?php $copyright_year = (bool)aperitto_get_theme_option( 'copyright_year' ); ?>
				<span class="copyright-year<?php echo $copyright_year ? '' : ' hide';?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="nofollow"><?php bloginfo('name'); ?></a> &copy; <?php echo date("Y",time()); ?>
				</span>
				<span class="copyright-text"><?php echo aperitto_get_theme_option('copyright_text'); ?></span>
			</p>
		</div>

		<div class="<?php echo apply_filters( 'aperitto_footer_themeby_class', 'themeby col6 tr' );?>">
			<?php $powered_by = (bool)aperitto_get_theme_option( 'powered_by' );?>
			<p id="designedby"<?php echo $powered_by ? '' : ' class="hide"';?>>
				<?php _e('Powered by', 'aperitto'); ?>
				<a href="<?php echo APERITTO_URI; ?>" target="_blank" rel="external nofollow noindex"><?php _e('Aperitto Theme', 'aperitto'); ?></a>
			</p>
		</div>
	</div>
    <?php endif; ?>
	<?php do_action( 'aperitto_after_footer_copyrights' ); ?>

</footer>
<?php do_action( 'aperitto_after_footer' ); ?>


</div>
<!-- .wrapper -->

<a id="toTop">➜</a>

<?php wp_footer(); ?>

</body>
</html>
