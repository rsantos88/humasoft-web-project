<?php
/**
 * Add the "Visual Link Preview" button to posts and pages.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.0.0
 *
 * @package    Visual_Link_Preview
 * @subpackage Visual_Link_Preview/includes/admin/modal
 */

/**
 * Add the "Visual Link Preview" button to posts and pages.
 *
 * @since      1.0.0
 * @package    Visual_Link_Preview
 * @subpackage Visual_Link_Preview/includes/admin/modal
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class VLP_Button {

	/**
	 * Register actions and filters.
	 *
	 * @since    1.0.0
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'add_shortcode_button' ) );
	}

	/**
	 * Add the "Visual Link Preview" button to the TinyMCE editor.
	 *
	 * @since    1.0.0
	 */
	public static function add_shortcode_button() {
		add_filter( 'mce_external_plugins', array( __CLASS__, 'add_button' ) );
		add_filter( 'mce_buttons', array( __CLASS__, 'register_button' ) );
	}

	/**
	 * Add the "Visual Link Preview" button to the TinyMCE editor.
	 *
	 * @since    1.0.0
	 * @param    mixed $plugin_array TinyMCE plugins.
	 */
	public static function add_button( $plugin_array ) {
		$plugin_array['visual_link_preview'] = VLP_URL . 'assets/js/other/shortcode-button-tinymce.js';
		return $plugin_array;
	}

	/**
	 * Register the "Visual Link Preview" button for the TinyMCE editor.
	 *
	 * @since    1.0.0
	 * @param    mixed $buttons TinyMCE buttons.
	 */
	public static function register_button( $buttons ) {
		array_push( $buttons, 'visual_link_preview' );
		return $buttons;
	}
}

VLP_Button::init();
