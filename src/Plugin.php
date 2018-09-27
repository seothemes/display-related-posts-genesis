<?php
/**
 * Plugin class.
 *
 * Loads other core-compatible components.
 *
 * @package   SeoThemes\DisplayRelatedPostsGenesis
 * @author    Lee Anthony <seothemeswp@gmail.com>
 * @license   GPL-3.0-or-later
 */

namespace SeoThemes\DisplayRelatedPostsGenesis;

/**
 * Class Theme
 *
 * Used to load other components.
 *
 * @package SeoThemes\DisplayRelatedPostsGenesis
 */
final class Plugin {

	/**
	 * The setup function will iterate through the plugin configuration array,
	 * check for the existence of a customization-specific class (the array
	 * key), then instantiate the class and call the init() method.
	 *
	 * Use it:
	 * ```
	 * add_action( 'after_setup_theme', function() {
	 *     $config = include_once __DIR__ . '/config/defaults.php';
	 *     SeoThemes\DisplayRelatedPostsGenesis\Plugin::setup( $config );
	 * } );
	 * ```
	 *
	 * @param array $config All theme-specific configuration.
	 *
	 * @return void
	 *
	 * @since 0.0.1
	 */
	public static function run( array $config ) {
		foreach ( $config as $class_name => $class_specific_config ) {
			if ( class_exists( $class_name ) ) {
				$class = new $class_name( $class_specific_config );
				$class->init();
			}
		}
	}
}
