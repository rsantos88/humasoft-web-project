<?php
/**
 * Represents a link.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.1.0
 *
 * @package    Visual_Link_Preview
 * @subpackage Visual_Link_Preview/includes/public
 */

/**
 * Represents a link.
 *
 * @since      1.1.0
 * @package    Visual_Link_Preview
 * @subpackage Visual_Link_Preview/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class VLP_Link {

	/**
	 * Properties for this link.
	 *
	 * @since    1.1.0
	 * @access   private
	 * @var      array $properties Link properties.
	 */
	private $properties = array();

	/**
	 * Get new link object.
	 *
	 * @since    1.1.0
	 * @param	 mixed $encoded Encoded link properties.
	 */
	public function __construct( $encoded ) {
		$unsanitized = json_decode( base64_decode( $encoded ) );
		$properties = array();

		// Sanitize properties.
		if ( $unsanitized && is_object( $unsanitized ) ) {
			$properties['type'] = in_array( $unsanitized->type, array( 'internal', 'external' ), true ) ? $unsanitized->type : false;

			if ( 'internal' === $properties['type'] ) {
				$properties['post_id'] = intval( $unsanitized->post );
				$unsanitized->url = $properties['post_id'] ? get_permalink( $properties['post_id'] ) : '';
			}

			$properties['url'] = trim( $unsanitized->url );
			$properties['image_id'] = isset( $unsanitized->image_id ) ? intval( $unsanitized->image_id ) : 0;
			$properties['image_url'] = isset( $unsanitized->image_url ) ? trim( $unsanitized->image_url ) : '';
			$properties['title'] = trim( $unsanitized->title );
			$properties['summary'] = nl2br( trim( $unsanitized->summary ) );
			$properties['template'] = trim( $unsanitized->template );
			$properties['custom_class'] = isset( $unsanitized->custom_class ) ? trim( $unsanitized->custom_class ) : '';

			// With backwards compatibility.
			if ( isset( $unsanitized->nofollow ) ) {
				$properties['nofollow'] = (bool) $unsanitized->nofollow;
			} else {
				$properties['nofollow'] = 'external' === $properties['type'] ? true : false;
			}
			if ( isset( $unsanitized->new_tab ) ) {
				$properties['new_tab'] = (bool) $unsanitized->new_tab;
			} else {
				$properties['new_tab'] = 'external' === $properties['type'] ? true : false;
			}
		}

		$this->properties = $properties;
	}

	/**
	 * Output a link.
	 *
	 * @since    1.1.0
	 */
	public function output() {
		$output = '';

		if ( $this->type() && ( $this->image_id() || $this->title() || $this->summary() ) ) {
			$output = VLP_Template_Manager::get_template( $this, $this->template() );
		}

		return $output;
	}

	/**
	 * Output the URL.
	 *
	 * @since    2.1.0
	 */
	public function output_url() {
		$output = '';

		if ( $this->url() ) {
			$link_attributes = array(
				'href' => $this->url(),
				'class' => 'vlp-link',
				'title' => $this->title(),
			);

			if ( $this->nofollow() ) {
				$link_attributes['rel'] = 'nofollow';
			}
			if ( $this->new_tab() ) {
				$link_attributes['target'] = '_blank';
			}

			$output = '<a';
			foreach ( $link_attributes as $key => $value ) {
				$output .= ' ' . $key . '="' . esc_attr( $value ) . '"';
			}
			$output .= '></a>';
		}

		return $output;
	}

	/**
	 * Get a link property.
	 *
	 * @since    1.1.0
	 * @param 	 mixed $property Name of the property to return.
	 * @param 	 mixed $default  Default to return if property is not set.
	 */
	public function property( $property, $default ) {
		return isset( $this->properties[ $property ] ) ? $this->properties[ $property ] : $default;
	}

	// Property methods.
	/**
	 * Get the link image HTML.
	 *
	 * @since    1.1.0
	 * @param	 mixed $size Thumbnail name or size array of the image we want.
	 */
	public function image( $size = 'thumbnail' ) {
		$image_id = $this->image_id();

		// Previewing external URL.
		if ( -1 === $image_id ) {
			$image_url = $this->image_url();

			if ( $image_url ) {
				// Get width and height.
				if ( ! is_array( $size ) ) {
					$sizes = get_intermediate_image_sizes();
					
					if ( in_array( $size, $sizes ) ) {
						$size = array(
							get_option( "{$size}_size_w" ),
							get_option( "{$size}_size_h" ),
						);
					} else {
						$size = array( 150, 150 );
					}
				}

				return '<img src="' . esc_attr( $image_url ) . '" style="max-width: ' . $size[0] . 'px; max-height: ' . $size[0] . 'px" />';
			}
		}

		$image = wp_get_attachment_image( $image_id, $size );

		// Prevent image stretching in Gutenberg.
		$thumb = wp_get_attachment_image_src( $image_id, $size );
		if ( $thumb[1] ) {
			$style = 'max-width: ' . $thumb[1] . 'px;';

			if ( false !== stripos( $image, ' style="' ) ) {
				$image = str_ireplace( ' style="', ' style="' . $style, $image );
			} else {
				$image = str_ireplace( '<img ', '<img style="' . $style . '" ', $image );
			}
		}

		return $image;
	}

	/**
	 * Get the link image ID.
	 *
	 * @since    1.1.0
	 */
	public function image_id() {
		return $this->property( 'image_id', 0 );
	}

	/**
	 * Get the link image URL.
	 *
	 * @since    1.3.0
	 */
	public function image_url() {
		return $this->property( 'image_url', '' );
	}

	/**
	 * Get the link summary.
	 *
	 * @since    1.1.0
	 */
	public function summary() {
		$summary = $this->property( 'summary', '' );

		// Fix version 1.3.1 problem.
		$summary = str_replace( '&lt;', '<', $summary );
		$summary = str_replace( '&gt;', '>', $summary );

		return $summary;
	}

	/**
	 * Get the link template.
	 *
	 * @since    1.1.0
	 */
	public function template() {
		$template = $this->property( 'template', 'use_default_from_settings' );
		$template = 'use_default_from_settings' === $template ? VLP_Settings::get( 'template_default' ) : $template;

		return $template;
	}

	/**
	 * Get the link title.
	 *
	 * @since    1.1.0
	 */
	public function title() {
		return $this->property( 'title', '' );
	}

	/**
	 * Get the link type.
	 *
	 * @since    1.2.0
	 */
	public function type() {
		return $this->property( 'type', false );
	}

	/**
	 * Get the link URL.
	 *
	 * @since    1.1.0
	 */
	public function url() {
		return $this->property( 'url', '' );
	}

	/**
	 * Get the link nofollow.
	 *
	 * @since    2.1.0
	 */
	public function nofollow() {
		return $this->property( 'nofollow', false );
	}

	/**
	 * Get the link new tab.
	 *
	 * @since    2.1.0
	 */
	public function new_tab() {
		return $this->property( 'new_tab', false );
	}

	/**
	 * Get the link custom classes.
	 *
	 * @since    2.1.0
	 */
	public function custom_class() {
		return $this->property( 'custom_class', '' );
	}
}
