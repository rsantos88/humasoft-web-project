<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Striker
 * @since Striker 1.0
 */
?>

	</div><!-- #main .site-main -->

	<footer id="colophon" class="site-footer" role="contentinfo">
        <div class="site-info">
            <a href="<?php $my_theme = wp_get_theme(); echo $my_theme->get( 'ThemeURI' ); ?>">
            <?php _e('Striker WordPress Starter Theme','striker'); ?></a>
            <?php echo __( 'Powered By WordPress ', 'striker' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon .site-footer -->
     <a href="#top" id="smoothup"></a>
</div><!-- #page .hfeed .site -->
</div><!-- end of wrapper -->
<?php wp_footer(); ?>

</body>
</html>