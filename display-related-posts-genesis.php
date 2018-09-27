<?php
/**
 * Plugin Name: Display Related Posts for Genesis
 * Plugin URI:  https://seothemes.com/plugins/display-related-posts-genesis
 * Description: Displays related posts for Genesis Framework powered sites.
 * Author:      SEO Themes
 * Author URI:  https://seothemes.com
 * Version:     1.0.0
 * Text Domain: display-related-posts-genesis
 * Domain Path: /languages
 * License:     GNU General Public License v3.0 (or later)
 * License URI: http://www.opensource.org/licenses/gpl-license.php
 *
 * @package     DisplayRelatedPostsGenesis
 * @link        https://seothemes.com/plugins/display-related-posts-genesis
 * @author      Seo Themes
 * @copyright   Copyright © 2018 Seo Themes
 * @license     GPL-3.0-or-later
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( version_compare( PHP_VERSION, '5.4', '<' ) ) {
	add_action( 'plugins_loaded', 'display_related_posts_genesis_init_deactivation' );
	/**
	 * Initialise deactivation functions.
	 */
	function display_related_posts_genesis_init_deactivation() {
		if ( current_user_can( 'activate_plugins' ) ) {
			add_action( 'admin_init', 'display_related_posts_genesis_deactivate' );
			add_action( 'admin_notices', 'display_related_posts_genesis_deactivation_notice' );
		}
	}
	/**
	 * Deactivate the plugin.
	 */
	function display_related_posts_genesis_deactivate() {
		deactivate_plugins( plugin_basename( __FILE__ ) );
	}
	/**
	 * Show deactivation admin notice.
	 */
	function display_related_posts_genesis_deactivation_notice() {
		$notice = sprintf(
		// Translators: 1: Required PHP version, 2: Current PHP version.
			'<strong>Display Related Posts for Genesis</strong> requires PHP %1$s to run. This site uses %2$s, so the plugin has been <strong>deactivated</strong>.',
			'5.4',
			PHP_VERSION
		);
		?>
		<div class="updated"><p><?php echo wp_kses_post( $notice ); ?></p></div>
		<?php
		if ( isset( $_GET['activate'] ) ) { // WPCS: input var okay, CSRF okay.
			unset( $_GET['activate'] ); // WPCS: input var okay.
		}
	}
	return false;
}

// Do nothing if Genesis is not activated.
if ( 'genesis' !== wp_get_theme()->get( 'Template' ) ) {
    return false;
}

/**
 * Load plugin initialisation file.
 */
require plugin_dir_path( __FILE__ ) . '/init.php';
