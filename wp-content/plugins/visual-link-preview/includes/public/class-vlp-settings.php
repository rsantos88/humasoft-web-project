<?php
/**
 * Responsible for the settings.
 *
 * @link       http://bootstrapped.ventures
 * @since      2.0.0
 *
 * @package    Visual_Link_Preview
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class VLP_Settings {
	private static $bvs;

	/**
	 * Register actions and filters.
	 *
	 * @since	2.0.0
	 */
	public static function init() {
		require_once( VLP_DIR . 'templates/settings/settings.php' );
		require_once( VLP_DIR . 'vendor/bv-settings/bv-settings.php' );

        self::$bvs = new BV_Settings( array(
            'uid' => 'vlp',
            'menu_title' => 'Visual Link Preview',
            'settings' => $settings_structure,
		) );
		
		add_action( 'admin_footer-settings_page_bv_settings_vlp', array( __CLASS__, 'add_support_widget' ) );
		add_filter( 'plugin_action_links_visual-link-preview/visual-link-preview.php', array( __CLASS__, 'plugin_action_links' ) );
		add_action( 'admin_notices', array( __CLASS__, 'activation_notice' ) );
	}

	/**
	 * Add support tab to the settings page.
	 *
	 * @since	2.0.0
	 */
	public static function add_support_widget() {
		require_once( VLP_DIR . 'templates/admin/support-widget.php' );
	}

	/**
	 * Add plugin action links.
	 *
	 * @since	2.0.0
	 */
	public static function plugin_action_links( $links ) {
        $links[] = '<a href="'. admin_url( 'options-general.php?page=bv_settings_vlp') .'">' . __( 'Settings', 'visual-link-preview' ) . '</a>';
        $links[] = '<a href="https://help.bootstrapped.ventures/collection/164-visual-link-preview" target="_blank">' . __( 'Documentation', 'visual-link-preview' ) . '</a>';

        return $links;
	}
	
	/**
	 * Show notice upon activation.
	 *
	 * @since	2.0.0
	 */
	public static function activation_notice() {
        if ( get_transient( 'vlp_activated' ) ) {
			?>
			<div class="updated crp_notice">
				<h3>Welcome to Visual Link Preview!</h3>
				<p><strong>New here?</strong> Please check out our <a href="https://help.bootstrapped.ventures/category/167-getting-started" target="_blank">Getting Started documentation</a>!</p>
			</div>
			<?php
			delete_transient( 'vlp_activated' );
		}
    }

	/**
	 * Get the value for a specific setting.
	 *
	 * @since	2.0.0
	 * @param	mixed $setting Setting to get the value for.
	 */
	public static function get( $setting ) {
		return self::$bvs->get( $setting );
	}

	/**
	 * Get the default value for a specific setting.
	 *
	 * @since	2.0.0
	 * @param	mixed $setting Setting to get the default for.
	 */
	public static function get_default( $setting ) {
		return self::$bvs->get_default( $setting );
	}
}
VLP_Settings::init();
