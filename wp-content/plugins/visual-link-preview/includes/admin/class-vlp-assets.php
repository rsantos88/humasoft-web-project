<?php
/**
 * Handle the admin assets.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.2.0
 *
 * @package    Visual_Link_Preview
 * @subpackage Visual_Link_Preview/includes/admin
 */

/**
 * Handle the admin assets.
 *
 * @since      1.2.0
 * @package    Visual_Link_Preview
 * @subpackage Visual_Link_Preview/includes/admin
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class VLP_Assets {

	/**
	 * Register actions and filters.
	 *
	 * @since    1.2.0
	 */
	public static function init() {
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue' ) );
		add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'enqueue_blocks' ) );
	}

	/**
	 * Enqueue stylesheets and scripts.
	 *
	 * @since    1.2.0
	 */
	public static function enqueue() {
		wp_enqueue_style( 'vlp-admin', VLP_URL . 'dist/admin.css', array(), VLP_VERSION, 'all' );
		wp_enqueue_script( 'vlp-admin', VLP_URL . 'dist/admin.js', array( 'jquery' ), VLP_VERSION, true );

		wp_localize_script( 'vlp-admin', 'vlp_admin', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'vlp' ),
			'templates' => VLP_Template_Manager::get_templates(),
			'text' => array(
				'media_title' => __( 'Select or Upload Image', 'visual-link-preview' ),
				'media_button' => __( 'Use Image', 'visual-link-preview' ),
			),
			'settings_link' => admin_url( 'options-general.php?page=bv_settings_vlp' ),
		));
	}

	/**
	 * Enqueue assets for Gutenberg blocks.
	 *
	 * @since    1.2.0
	 */
	public static function enqueue_blocks() {
		wp_enqueue_script( 'vlp-blocks', VLP_URL . 'dist/blocks.js', array( 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-data', 'wp-edit-post' ), VLP_VERSION );
		wp_enqueue_style( 'vlp-blocks', VLP_URL . 'dist/blocks.css', array( 'wp-edit-blocks' ), VLP_VERSION );

		wp_localize_script( 'vlp-blocks', 'vlp_blocks', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'vlp' ),
			'templates' => VLP_Template_Manager::get_templates(),
			'edit_link' => admin_url( 'post.php?action=edit&post='),
			'settings_link' => admin_url( 'options-general.php?page=bv_settings_vlp' ),
		));
	}
}

VLP_Assets::init();
