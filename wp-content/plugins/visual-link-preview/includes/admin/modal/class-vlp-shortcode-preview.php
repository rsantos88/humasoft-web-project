<?php
/**
 * Handle the display of the shortcode in the TinyMCE editor.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.0.0
 *
 * @package    Visual_Link_Preview
 * @subpackage Visual_Link_Preview/includes/admin/modal
 */

/**
 * Handle the display of the shortcode in the TinyMCE editor.
 *
 * @since      1.0.0
 * @package    Visual_Link_Preview
 * @subpackage Visual_Link_Preview/includes/admin/modal
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class VLP_Shortcode_Preview {

	/**
	 * Register actions and filters.
	 *
	 * @since    1.0.0
	 */
	public static function init() {
		add_filter( 'mce_external_plugins', array( __CLASS__, 'tinymce_shortcode_plugin' ) );
	}

	/**
	 * Load custom TinyMCE plugin for handling the recipe shortcode.
	 *
	 * @since    1.0.0
	 * @param    array $plugin_array Plugins to be used by TinyMCE.
	 */
	public static function tinymce_shortcode_plugin( $plugin_array ) {
		 $plugin_array['visuallinkpreview'] = VLP_URL . 'assets/js/other/shortcode-tinymce.js';
		 return $plugin_array;
	}
}

VLP_Shortcode_Preview::init();
