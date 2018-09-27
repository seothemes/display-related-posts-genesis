<?php
/**
 * Initialise the plugin
 *
 * This file can use syntax from the required level of PHP or later.
 *
 * @package      SeoThemes\DisplayRelatedPostsGenesis
 * @author       Lee Anthony
 * @copyright    2018 SEO Themes
 * @license      GPL-3.0-or-later
 */

namespace SeoThemes\DisplayRelatedPostsGenesis;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'DISPLAY_RELATED_POSTS_GENESIS_DIR' ) ) {
	// phpcs:ignore NeutronStandard.Constants.DisallowDefine.Define
	define( 'DISPLAY_RELATED_POSTS_GENESIS_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'DISPLAY_RELATED_POSTS_GENESIS_URL' ) ) {
	// phpcs:ignore NeutronStandard.Constants.DisallowDefine.Define
	define( 'DISPLAY_RELATED_POSTS_GENESIS_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'PLUGIN_VERSION' ) ) {
	// phpcs:ignore NeutronStandard.Constants.DisallowDefine.Define
	define( 'PLUGIN_VERSION', '1.0.0' );
}

// Load Composer autoloader.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

add_action( 'genesis_setup', __NAMESPACE__ . '\init' );
/**
 * Initialize plugin after Genesis has loaded.
 *
 * @since 0.1.0
 *
 * @return void
 */
function init() {
	$config = require_once __DIR__ . '/config/defaults.php';
	$plugin = new Plugin();

	$plugin::run( $config );
}
