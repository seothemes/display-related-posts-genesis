<?php
/**
 * Display Related Posts for Genesis config.
 *
 * @package   SeoThemes\DisplayRelatedPostsGenesis
 * @author    SEO Themes
 * @copyright Copyright © 2018 SEO Themes
 * @license   GPL-3.0-or-later
 */

namespace SeoThemes\DisplayRelatedPostsGenesis;

$drpg_customizer_settings = [
	Customizer::SECTIONS => [
		[
			Customizer::SECTION_NAME => 'related_posts',
			Customizer::TITLE        => __( 'Related Posts', 'display-related-posts-genesis' ),
			Customizer::PANEL        => 'genesis',
		],
	],
	Customizer::FIELDS   => [
		[
			Customizer::CONTROL_TYPE  => 'checkbox',
			Customizer::SETTINGS      => 'related_posts_styles',
			Customizer::LABEL         => __( 'Load CSS', 'display-related-posts-genesis' ),
			Customizer::DESCRIPTION   => __( 'Load plugin CSS styles on the front end of the site.', 'display-related-posts-genesis' ),
			Customizer::SECTION       => 'related_posts',
			Customizer::DEFAULT_VALUE => true,
		],
		[
			Customizer::CONTROL_TYPE  => 'checkbox',
			Customizer::SETTINGS      => 'related_posts_image',
			Customizer::LABEL         => __( 'Display Featured Image', 'display-related-posts-genesis' ),
			Customizer::DESCRIPTION   => __( 'Display a featured image if one is set.', 'display-related-posts-genesis' ),
			Customizer::SECTION       => 'related_posts',
			Customizer::DEFAULT_VALUE => true,
		],
		[
			Customizer::CONTROL_TYPE  => 'text',
			Customizer::SETTINGS      => 'related_posts_title',
			Customizer::LABEL         => __( 'Related Posts Title', 'display-related-posts-genesis' ),
			Customizer::DESCRIPTION   => __( 'Choose the title to display above the latest posts. Leave empty for no title.', 'display-related-posts-genesis' ),
			Customizer::SECTION       => 'related_posts',
			Customizer::DEFAULT_VALUE => __( 'Related posts', 'display-related-posts-genesis' ),
		],
		[
			Customizer::CONTROL_TYPE      => 'number',
			Customizer::SETTINGS          => 'related_posts_amount',
			Customizer::LABEL             => __( 'Amount of Posts', 'display-related-posts-genesis' ),
			Customizer::DESCRIPTION       => __( 'Choose the amount of posts to display. Default is 3.', 'display-related-posts-genesis' ),
			Customizer::SECTION           => 'related_posts',
			Customizer::DEFAULT_VALUE     => 3,
			Customizer::SANITIZE_CALLBACK => 'absint',
		],
		[
			Customizer::CONTROL_TYPE  => 'number',
			Customizer::SETTINGS      => 'related_posts_columns',
			Customizer::LABEL         => __( 'Columns', 'display-related-posts-genesis' ),
			Customizer::DESCRIPTION   => __( 'Choose the number of related posts columns. Please note that your theme will need to include the <a href="https://gist.github.com/studiopress/5700003" target="_blank">Genesis column classes CSS</a> for column widths if you have chosen not to load the plugin\'s CSS. Default width is 3, or "one-third".', 'display-related-posts-genesis' ),
			Customizer::SECTION       => 'related_posts',
			Customizer::DEFAULT_VALUE => 3,
		],
		[
			Customizer::CONTROL_TYPE  => 'select',
			Customizer::SETTINGS      => 'related_posts_location',
			Customizer::LABEL         => __( 'Hook Location', 'display-related-posts-genesis' ),
			Customizer::DESCRIPTION   => __( 'Choose where to display the related posts. Default is "genesis_before_comments". Developers: The list of hooks can be modified using the filter `display_related_posts_genesis_locations`.', 'display-related-posts-genesis' ),
			Customizer::SECTION       => 'related_posts',
			Customizer::DEFAULT_VALUE => 'genesis_before_comments',
			Customizer::CHOICES       => apply_filters( 'display_related_posts_genesis_locations', [
				'genesis_before_content_sidebar_wrap' => 'genesis_before_content_sidebar_wrap',
				'genesis_before_content'              => 'genesis_before_content',
				'genesis_before_entry'                => 'genesis_before_entry',
				'genesis_entry_header'                => 'genesis_entry_header',
				'genesis_entry_content'               => 'genesis_entry_content',
				'genesis_entry_footer'                => 'genesis_entry_footer',
				'genesis_after_entry'                 => 'genesis_after_entry',
				'genesis_before_comments'             => 'genesis_before_comments',
				'genesis_after_comments'              => 'genesis_after_comments',
				'genesis_after_comment_form'          => 'genesis_after_comment_form',
				'genesis_before_sidebar_widget_area'  => 'genesis_before_sidebar_widget_area',
				'genesis_after_sidebar_widget_area'   => 'genesis_after_sidebar_widget_area',
				'genesis_after_content'               => 'genesis_after_content',
				'genesis_after_content_sidebar_wrap'  => 'genesis_after_content_sidebar_wrap',

			] ),
		],
		[
			Customizer::CONTROL_TYPE      => 'number',
			Customizer::SETTINGS          => 'related_posts_priority',
			Customizer::LABEL             => __( 'Hook Priority', 'display-related-posts-genesis' ),
			Customizer::DESCRIPTION       => __( 'Choose the priority that the hook should be loaded. Default is 12', 'display-related-posts-genesis' ),
			Customizer::SECTION           => 'related_posts',
			Customizer::DEFAULT_VALUE     => 12,
			Customizer::SANITIZE_CALLBACK => 'absint',
		],
	],
];

$drpg_default_settings = [
	RelatedPosts::TITLE    => get_theme_mod( 'related_posts_title', __( 'Related posts', 'display-related-posts-genesis' ) ),
	RelatedPosts::AMOUNT   => get_theme_mod( 'related_posts_amount', 3 ),
	RelatedPosts::COLUMNS  => get_theme_mod( 'related_posts_columns', 'one-third' ),
	RelatedPosts::IMAGE    => get_theme_mod( 'related_posts_image', true ),
	RelatedPosts::STYLES   => get_theme_mod( 'related_posts_styles', true ),
	RelatedPosts::LOCATION => get_theme_mod( 'related_posts_location', 'genesis_before_comments' ),
	RelatedPosts::PRIORITY => get_theme_mod( 'related_posts_priority', 12 ),
];

return [
	Customizer::class   => apply_filters( 'display_related_posts_genesis_customizer', $drpg_customizer_settings ),
	RelatedPosts::class => apply_filters( 'display_related_posts_genesis_defaults', $drpg_default_settings ),
];