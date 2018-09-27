<?php
/**
 * Related Posts component. Accepts config.
 *
 * @package   SeoThemes\DisplayRelatedPostsGenesis
 * @link      https://seothemes.com/limitless-pro
 * @author    SEO Themes
 * @copyright Copyright © 2018 SEO Themes
 * @license   GPL-3.0-or-later
 */

namespace SeoThemes\DisplayRelatedPostsGenesis;

/**
 * Class RelatedPosts
 *
 * @package SeoThemes\DisplayRelatedPostsGenesis
 */
class RelatedPosts extends Component {

	const ENABLE   = 'enable';
	const TITLE    = 'title';
	const AMOUNT   = 'amount';
	const COLUMNS  = 'columns';
	const IMAGE    = 'image';
	const STYLES   = 'styles';
	const LOCATION = 'location';
	const PRIORITY = 'priority';

	/**
	 * Initialize class.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init() {
		add_action( $this->config[ self::LOCATION ], [
			$this,
			'display'
		], $this->config[ self::PRIORITY ] );

		if ( true === $this->config[ self::STYLES ] ) {
			add_action( 'wp_enqueue_scripts', function () {
				wp_enqueue_style( 'display_related_posts_genesis', DISPLAY_RELATED_POSTS_GENESIS_URL . 'assets/css/front-end.css', [], PLUGIN_VERSION );
			} );
		}
	}

	/**
	 * Outputs related posts with thumbnail
	 *
	 * @author Nick the Geek
	 * @url http://designsbynickthegeek.com/tutorials/display-related-posts-genesis
	 * @global object $post
	 */
	public function display() {

		// If we are not on a single post page, abort.
		if ( ! is_singular( 'post' ) ) {
			return;
		}

		global $do_not_duplicate;
		global $count;

		$count            = 0;
		$related          = '';
		$do_not_duplicate = array();

		// Get the tags for the current post.
		$tags = get_the_terms( get_the_ID(), 'post_tag' );

		// Get the categories for the current post.
		$cats = get_the_terms( get_the_ID(), 'category' );

		// If we have some tags, run the tag query.
		if ( $tags ) {
			$query   = $this->related_tax_query( $tags, $count, 'tag' );
			$related .= $query['related'];
			$count   = $query['count'];
		}

		// If we have some categories, run the cat query.
		if ( $cats ) {
			$query   = $this->related_tax_query( $cats, $count, 'category' );
			$related .= $query['related'];
			$count   = $query['count'];
		}

		// End here if we don't have any related posts.
		if ( ! $related ) {
			return;
		}

		$title = $this->config[ self::TITLE ];

		// Display the related posts section.
		$html = '';
		$html .= '<section class="related clearfix">';
		$html .= '<h3 class="related-title">' . $title . '</h3>';
		$html .= '<div class="related-posts">' . $related . '</div>';
		$html .= '</section>';

		printf( apply_filters( 'display_related_posts_genesis_section_output', $html ), $title, $related );
	}

	/**
	 * The taxonomy query.
	 *
	 * @since  1.0.0
	 *
	 * @param  array  $terms Array of the taxonomy's objects.
	 * @param  int    $count The number of posts.
	 * @param  string $type  The type of taxonomy, e.g: `tag` or `category`.
	 *
	 * @return array
	 */
	protected function related_tax_query( $terms, $count, $type ) {
		global $do_not_duplicate;

		// If the current post does not have any terms of the specified taxonomy, abort.
		if ( ! $terms ) {
			return;
		}

		// Array variable to store the IDs of the posts.
		// Stores the current post ID to begin with.
		$post_ids = array_merge( array( get_the_ID() ), $do_not_duplicate );

		$term_ids = array();

		// Array variable to store the IDs of the specified taxonomy terms.
		foreach ( $terms as $term ) {
			$term_ids[] = $term->term_id;
		}

		$tax_query = array(
			array(
				'taxonomy' => 'post_format',
				'field'    => 'slug',
				'terms'    => array(
					'post-format-link',
					'post-format-status',
					'post-format-aside',
					'post-format-quote',
				),
				'operator' => 'NOT IN',
			),
		);

		$showposts = $this->config[ self::AMOUNT ] - $count;

		$args = array(
			$type . '__in'        => $term_ids,
			'post__not_in'        => $post_ids,
			'showposts'           => $showposts,
			'ignore_sticky_posts' => 1,
			'tax_query'           => $tax_query,
		);

		$related = '';

		$tax_query = new \WP_Query( $args );

		if ( $tax_query->have_posts() ) {
			while ( $tax_query->have_posts() ) {
				$tax_query->the_post();

				$do_not_duplicate[] = get_the_ID();

				$count ++;

				$title = get_the_title();
				$width = (int) $this->config[ self::COLUMNS ];

				$width_class = [
					1 => 'full-width',
					2 => 'one-half',
					3 => 'one-third',
					4 => 'one-fourth',
					5 => 'one-fifth',
					6 => 'one-sixth',
				];

				$related .= '<div class="entry ' . $width_class[ $width ] . ( ( 1 === $count % $width ) ? ' first' : '' ) . '">';

				if ( true === $this->config[ self::IMAGE ] ) {
					$img_args = apply_filters( 'display_related_posts_genesis_image_args', array(
						'size' => 'large',
						'attr' => array(
							'class' => 'alignleft',
						),
					) );

					$related .= '<div class="entry-content"><a class="entry-image-link" href="' . get_permalink() . '" rel="bookmark" title="Permanent Link to ' . $title . '">' . genesis_get_image( $img_args ) . '</a></div>';
				}

				$related .= '<h2 class="entry-title"><a class="entry-title-link" href="' . get_permalink() . '" rel="bookmark" title="Permanent Link to ' . $title . '">' . $title . '</a></h2>';

				$related .= '<p class="entry-meta">';

				$related .= '<span class="entry-tags">' . do_shortcode( '[post_tags before=""]' ) . '</span>';

				$related .= '<span class="entry-categories">' . do_shortcode( '[post_categories before=""]' ) . '</span>';

				$related .= do_shortcode( '[post_date]' );

				$related .= '</p>';

				$related .= '</div>';

				$related = sprintf( apply_filters( 'display_related_posts_genesis_entry_output', $related ), $width, $title );
			}
		}

		wp_reset_postdata();

		$output = array(
			'related' => $related,
			'count'   => $count,
		);

		return $output;
	}
}
