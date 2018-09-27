<?php
/**
 * Example of how to create a custom component which accepts a config.
 *
 * @package   SeoThemes\DisplayRelatedPostsGenesis
 * @author    SEO Themes
 * @copyright Copyright © 2018 SEO Themes
 * @license   GPL-3.0-or-later
 */

namespace SeoThemes\DisplayRelatedPostsGenesis;

/**
 * Example of how to create a custom component.
 *
 * Example config (usually located at config/defaults.php):
 *
 * ```
 * $core_example = [
 *     Example::SUB_CONFIG => [
 *         Example::KEY => 'value',
 *     ],
 * ];
 *
 * return [
 *     Example::class => $core_example,
 * ];
 * ```
 */
class Customizer extends Component {

	const FIELDS               = 'fields';
	const PANEL                = 'panel';
	const SECTIONS             = 'sections';
	const SECTION_NAME         = 'section_name';
	const TITLE                = 'title';
	const CONTROL              = 'control';
	const SETTING_TYPE         = 'type';
	const CAPABILITY           = 'capability';
	const THEME_SUPPORTS       = 'theme_supports';
	const DEFAULT_VALUE        = 'default';
	const TRANSPORT            = 'transport';
	const VALIDATE_CALLBACK    = 'validate_callback';
	const SANITIZE_CALLBACK    = 'sanitize_callback';
	const SANITIZE_JS_CALLBACK = 'sanitize_js_callback';
	const DIRTY                = 'dirty';
	const SETTINGS             = 'settings';
	const SETTING              = 'setting';
	const PRIORITY             = 'priority';
	const SECTION              = 'section';
	const LABEL                = 'label';
	const DESCRIPTION          = 'description';
	const CHOICES              = 'choices';
	const INPUT_ATTRS          = 'input_attrs';
	const ALLOW_ADDITION       = 'allow_addition';
	const CONTROL_TYPE         = 'type';
	const ACTIVE_CALLBACK      = 'active_callback';

	/**
	 * @var
	 */
	protected $properties;

	/**
	 * Description of expected behavior.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init() {
		$this->properties = [
			self::SETTING => [
				self::THEME_SUPPORTS,
				self::TRANSPORT,
				self::VALIDATE_CALLBACK,
				self::SANITIZE_CALLBACK,
				self::SANITIZE_JS_CALLBACK,
				self::DIRTY,
			],
			self::CONTROL => [
				self::SETTINGS,
				self::SETTING,
				self::PRIORITY,
				self::SECTION,
				self::LABEL,
				self::DESCRIPTION,
				self::CHOICES,
				self::INPUT_ATTRS,
				self::ALLOW_ADDITION,
				self::CONTROL_TYPE,
				self::ACTIVE_CALLBACK,
			],
		];

		if ( array_key_exists( self::FIELDS, $this->config ) ) {
			$this->fields( $this->config[ self::FIELDS ] );
		}

		if ( array_key_exists( self::SECTIONS, $this->config ) ) {
			$this->sections( $this->config[ self::SECTIONS ] );
		}
	}

	/**
	 * Description of expected behavior.
	 *
	 * @since 1.0.0
	 *
	 * @param array $config
	 *
	 * @return void
	 */
	protected function fields( $config ) {
		add_action( 'customize_register', function () use ( $config ) {
			global $wp_customize;

			foreach ( $config as $sub_config => $args ) {
				$wp_customize->add_setting( $args[ self::SETTINGS ], $this->filter( $args, self::SETTING ) );
				$wp_customize->add_control( $args[ self::SETTINGS ], $this->filter( $args, self::CONTROL ) );
			}
		} );
	}

	/**
	 * Description of expected behavior.
	 *
	 * @since 1.0.0
	 *
	 * @param $config
	 *
	 * @return void
	 */
	protected function sections( $config ) {
		add_action( 'customize_register', function () use ( $config ) {
			global $wp_customize;

			foreach ( $config as $sub_config => $args ) {
				$wp_customize->add_section( $args[ self::SECTION_NAME ], $args );
			}
		} );
	}

	/**
	 * Description of expected behavior.
	 *
	 * @since 1.0.0
	 *
	 * @param $args
	 * @param $type
	 *
	 * @return array
	 */
	protected function filter( $args, $type ) {
		if ( self::SETTING === $type ) {
			foreach ( $this->properties[ self::CONTROL ] as $property ) {
				unset( $args[ $property ] );
			}
		} elseif ( self::CONTROL === $type ) {
			foreach ( $this->properties[ self::SETTING ] as $property ) {
				unset( $args[ $property ] );
			}
		}

		return $args;
	}
}
