<?php
/**
 * The template for displaying the footer.
 *
 * @package Aperitto
 * @since 1.0.0
 */

do_action( 'aperitto_main_wrap_inner_end' );

?>
</div>
<!-- #main -->

<?php do_action( 'aperitto_before_footer' ); ?>

<footer id="footer" class="<?php echo aperitto_get_theme_option( 'copyright_enable' ) ? '' : 'no-copyright'; ?>">

	<?php do_action( 'aperitto_before_footer_menu' ); ?>

	<?php if ( has_nav_menu( 'bottom' ) ) : ?>
		<div class="<?php echo esc_html( apply_filters( 'aperitto_footer_menu_class', 'footer-menu maxwidth' ) ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'bottom',
					'menu_id'        => 'footer-menu',
					'depth'          => 1,
					'container'      => false,
					'items_wrap'     => '<ul class="footmenu clearfix">%3$s</ul>',
				)
			);
			?>
		</div>
	<?php endif; ?>

	<?php do_action( 'aperitto_before_footer_copyrights' ); ?>
	<?php $hide = aperitto_get_theme_option( 'copyright_enable' ) ? '' : ' hide'; ?>
		<div class="<?php echo esc_html( apply_filters( 'aperitto_footer_copyrights_class', 'copyrights maxwidth grid' ) . $hide ); ?>">
			<div class="<?php echo esc_html( apply_filters( 'aperitto_footer_copytext_class', 'copytext col6' ) ); ?>">
				<p id="copy">
					<?php $copyright_year = (bool) aperitto_get_theme_option( 'copyright_year' ); ?>
					<span class="copyright-year<?php echo esc_attr( $copyright_year ? '' : ' hide' ); ?>">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="nofollow"><?php bloginfo( 'name' ); ?></a> &copy; <?php echo esc_html( gmdate( 'Y', time() ) ); ?>
					</span>
					<span class="copyright-text"><?php echo esc_html( aperitto_get_theme_option( 'copyright_text' ) ); ?></span>
				</p>
			</div>

			<div class="<?php echo esc_html( apply_filters( 'aperitto_footer_themeby_class', 'themeby col6' ) ); ?>">
				<?php $powered_by = (bool) aperitto_get_theme_option( 'powered_by' ); ?>
				<p id="designedby" <?php echo esc_attr( $powered_by ? '' : ' class="hide"' ); ?>>
					<?php esc_html_e( 'Powered by', 'aperitto' ); ?>
					<a href="<?php echo esc_url( APERITTO_URI ); ?>" target="_blank" rel="external nofollow noindex"><?php esc_html_e( 'Aperitto Theme', 'aperitto' ); ?></a>
				</p>
			</div>
		</div>
	<?php do_action( 'aperitto_after_footer_copyrights' ); ?>

</footer>
<?php do_action( 'aperitto_after_footer' ); ?>


</div>
<!-- .wrapper -->

<a id="toTop">➜</a>

<?php wp_footer(); ?>

</body>

</html>
