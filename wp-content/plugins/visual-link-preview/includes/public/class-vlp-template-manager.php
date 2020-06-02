<?php
/**
 * Responsible for the link preview template.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.1.0
 *
 * @package    Visual_Link_Preview
 * @subpackage Visual_Link_Preview/includes/public
 */

/**
 * Responsible for the link preview template.
 *
 * @since      1.1.0
 * @package    Visual_Link_Preview
 * @subpackage Visual_Link_Preview/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class VLP_Template_Manager {
	/**
	 * Cached version of all the available templates.
	 *
	 * @since    1.1.0
	 * @access   private
	 * @var      array    $templates    Array containing all templates that have been loaded.
	 */
	private static $templates = array();

	/**
	 * Templates used in the output.
	 *
	 * @since    2.0.0
	 * @access   private
	 * @var      array    $used_templates    Array containing all templates that have been used in the output.
	 */
	private static $used_templates = array();

	/**
	 * Register actions and filters.
	 *
	 * @since    1.1.0
	 */
	public static function init() {
		add_action( 'wp_footer', array( __CLASS__, 'templates_css' ) );

		add_action( 'wp_ajax_vlp_get_template', array( __CLASS__, 'ajax_get_template' ) );
	}

	/**
	 * Add CSS to footer for all templates used on this page.
	 *
	 * @since	2.0.0
	 */
	public static function templates_css() {
		if ( count( self::$used_templates ) ) {
			$style = '';
			
			foreach ( self::$used_templates as $slug => $template ) {
				$style .= self::get_template_css( $template );
			}

			$style .= VLP_Template_Style::get_css();

			if ( $style ) {
				echo '<style type="text/css">' . $style . '</style>';
			}
		}
	}

	/**
	 * Get template for a specific link.
	 *
	 * @since    1.1.0
	 * @param	 object $link Link object to get the template for.
	 * @param    mixed  $slug Slug of the specific template we want.
	 */
	public static function get_template( $link, $slug ) {
		$template = self::get_template_by_slug( $slug );

		if ( ! $template ) {
			return '';
		}

		// Make sure we'll load CSS later.
		if ( ! array_key_exists( $template['slug'], self::$used_templates ) ) {
			self::$used_templates[ $template['slug'] ] = $template;
		}

		ob_start();
		require( $template['dir'] . '/' . $template['slug'] . '.php' );
		$template = ob_get_contents();
		ob_end_clean();

		$template = do_shortcode( $template );

		return apply_filters( 'vlp_get_template', $template, $link, $slug );
	}

	/**
	 * Get CSS for a specific template.
	 *
	 * @since	2.0.0
	 * @param	object $template Template to get the CSS for.
	 */
	public static function get_template_css( $template ) {
		$css = '';

		if ( ! $template ) {
			return $css;
		}

		// Get CSS from stylesheet.
		if ( $template['stylesheet'] ) {
			ob_start();
			include( $template['dir'] . '/' . $template['stylesheet'] );
			$css .= ob_get_contents();
			ob_end_clean();
		}

		return $css;
	}

	/**
	 * Search for posts by keyword.
	 *
	 * @since    1.0.0
	 */
	public static function ajax_get_template() {
		if ( check_ajax_referer( 'vlp', 'security', false ) ) {
			$encoded = isset( $_POST['encoded'] ) ? sanitize_text_field( wp_unslash( $_POST['encoded'] ) ) : ''; // Input var okay.
			$link = new VLP_Link( $encoded );

			$template = VLP_Template_Manager::get_template_by_slug( $link->template() );

			$output = '<style type="text/css">' . VLP_Template_Manager::get_template_css( $template ) . VLP_Template_Style::get_css() . '</style>';
			$output .= $link->output();

			wp_send_json_success( array(
				'template' => $output,
			) );
		}

		wp_die();
	}

	/**
	 * Get template by name.
	 *
	 * @since    1.1.0
	 * @param		 mixed $slug Slug of the template we want to get.
	 */
	public static function get_template_by_slug( $slug ) {
		$templates = self::get_templates();

		$template = isset( $templates[ $slug ] ) ? $templates[ $slug ] : false;

		// Use default template if none found.
		if ( ! $template ) {
			$slug = VLP_Settings::get( 'template_default' );
			$template = isset( $templates[ $slug ] ) ? $templates[ $slug ] : false;
		}

		// Use default for setting if none found.
		if ( ! $template ) {
			$slug = VLP_Settings::get_default( 'template_default' );
			$template = isset( $templates[ $slug ] ) ? $templates[ $slug ] : false;
		}

		return $template;
	}

	/**
	 * Get all available templates.
	 *
	 * @since    1.1.0
	 */
	public static function get_templates() {
		if ( empty( self::$templates ) ) {
			self::load_templates();
		}

		return self::$templates;
	}

	/**
	 * Load all available templates.
	 *
	 * @since    1.1.0
	 */
	private static function load_templates() {
		$templates = array();

		// Load included templates.
		$dirs = array_filter( glob( VLP_DIR . 'templates/link/*' ), 'is_dir' );
		$url = VLP_URL . 'templates/link/';

		foreach ( $dirs as $dir ) {
			$template = self::load_template( $dir, $url, false );
			$templates[ $template['slug'] ] = $template;
		}

		// Load custom templates from parent theme.
		$theme_dir = get_template_directory();

		if ( file_exists( $theme_dir . '/vlp-templates' ) && file_exists( $theme_dir . '/vlp-templates/link' ) ) {
			$url = get_template_directory_uri() . '/vlp-templates/link/';

			$dirs = array_filter( glob( $theme_dir . '/vlp-templates/link/*' ), 'is_dir' );

			foreach ( $dirs as $dir ) {
				$template = self::load_template( $dir, $url, true );
				$templates[ $template['slug'] ] = $template;
			}
		}

		// Load custom templates from child theme (if present).
		if ( get_stylesheet_directory() !== $theme_dir ) {
			$theme_dir = get_stylesheet_directory();

			if ( file_exists( $theme_dir . '/vlp-templates' ) && file_exists( $theme_dir . '/vlp-templates/link' ) ) {
				$url = get_stylesheet_directory_uri() . '/vlp-templates/link/';

				$dirs = array_filter( glob( $theme_dir . '/vlp-templates/link/*' ), 'is_dir' );

				foreach ( $dirs as $dir ) {
					$template = self::load_template( $dir, $url, true );
					$templates[ $template['slug'] ] = $template;
				}
			}
		}

		self::$templates = $templates;
	}

	/**
	 * Load template from directory.
	 *
	 * @since    1.1.0
	 * @param    mixed 	 $dir 	 Directory to load the template from.
	 * @param	 mixed 	 $url 	 URL to load the template from.
	 * @param	 boolean $custom Wether or not this is a custom template included by the user.
	 */
	private static function load_template( $dir, $url, $custom = false ) {
		$slug = basename( $dir );
		$name = ucwords( str_replace( '-', ' ', $slug ) );

		// Allow both .min.css and .css as extension.
		$stylesheet = file_exists( $dir . '/' . $slug . '.min.css' ) ? $slug . '.min.css' : $slug . '.css';

		return array(
			'custom' => $custom,
			'name' => $name,
			'slug' => $slug,
			'dir' => $dir,
			'url' => $url . $slug,
			'stylesheet' => $stylesheet,
		);
	}
}

VLP_Template_Manager::init();
