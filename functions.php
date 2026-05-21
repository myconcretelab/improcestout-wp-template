<?php
/**
 * Impro C'est Tout functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Improcestout
 * @since Impro C'est Tout 1.0
 */

// Adds theme support for post formats.
if ( ! function_exists( 'improcestout_post_format_setup' ) ) :
	/**
	 * Adds theme support for post formats.
	 *
	 * @since Impro C'est Tout 1.0
	 *
	 * @return void
	 */
	function improcestout_post_format_setup() {
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
	}
endif;
add_action( 'after_setup_theme', 'improcestout_post_format_setup' );

// Enqueues editor-style.css in the editors.
if ( ! function_exists( 'improcestout_editor_style' ) ) :
	/**
	 * Enqueues editor-style.css in the editors.
	 *
	 * @since Impro C'est Tout 1.0
	 *
	 * @return void
	 */
	function improcestout_editor_style() {
		add_editor_style( 'assets/css/editor-style.css' );
	}
endif;
add_action( 'after_setup_theme', 'improcestout_editor_style' );

// Enqueues the theme stylesheet on the front.
if ( ! function_exists( 'improcestout_enqueue_styles' ) ) :
	/**
	 * Enqueues the theme stylesheet on the front.
	 *
	 * @since Impro C'est Tout 1.0
	 *
	 * @return void
	 */
	function improcestout_enqueue_styles() {
		$suffix = SCRIPT_DEBUG ? '' : '.min';
		$src    = 'style' . $suffix . '.css';

		wp_enqueue_style(
			'improcestout-style',
			get_parent_theme_file_uri( $src ),
			array(),
			wp_get_theme()->get( 'Version' )
		);
		wp_style_add_data(
			'improcestout-style',
			'path',
			get_parent_theme_file_path( $src )
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'improcestout_enqueue_styles' );

// Registers custom block styles.
if ( ! function_exists( 'improcestout_block_styles' ) ) :
	/**
	 * Registers custom block styles.
	 *
	 * @since Impro C'est Tout 1.0
	 *
	 * @return void
	 */
	function improcestout_block_styles() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'improcestout' ),
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
	}
endif;
add_action( 'init', 'improcestout_block_styles' );

// Registers pattern categories.
if ( ! function_exists( 'improcestout_pattern_categories' ) ) :
	/**
	 * Registers pattern categories.
	 *
	 * @since Impro C'est Tout 1.0
	 *
	 * @return void
	 */
	function improcestout_pattern_categories() {

		register_block_pattern_category(
			'improcestout_page',
			array(
				'label'       => __( 'Pages', 'improcestout' ),
				'description' => __( 'A collection of full page layouts.', 'improcestout' ),
			)
		);

		register_block_pattern_category(
			'improcestout_post-format',
			array(
				'label'       => __( 'Post formats', 'improcestout' ),
				'description' => __( 'A collection of post format patterns.', 'improcestout' ),
			)
		);
	}
endif;
add_action( 'init', 'improcestout_pattern_categories' );

// Registers block binding sources.
if ( ! function_exists( 'improcestout_register_block_bindings' ) ) :
	/**
	 * Registers the post format block binding source.
	 *
	 * @since Impro C'est Tout 1.0
	 *
	 * @return void
	 */
	function improcestout_register_block_bindings() {
		register_block_bindings_source(
			'improcestout/format',
			array(
				'label'              => _x( 'Post format name', 'Label for the block binding placeholder in the editor', 'improcestout' ),
				'get_value_callback' => 'improcestout_format_binding',
			)
		);
	}
endif;
add_action( 'init', 'improcestout_register_block_bindings' );

// Registers block binding callback function for the post format name.
if ( ! function_exists( 'improcestout_format_binding' ) ) :
	/**
	 * Callback function for the post format name block binding source.
	 *
	 * @since Impro C'est Tout 1.0
	 *
	 * @return string|void Post format name, or nothing if the format is 'standard'.
	 */
	function improcestout_format_binding() {
		$post_format_slug = get_post_format();

		if ( $post_format_slug && 'standard' !== $post_format_slug ) {
			return get_post_format_string( $post_format_slug );
		}
	}
endif;

if ( ! function_exists( 'improcestout_get_default_sun_items' ) ) :
	/**
	 * Returns default items for the home sun navigation.
	 *
	 * @return array
	 */
	function improcestout_get_default_sun_items() {
		return array(
			array(
				'pageId'       => 17,
				'slug'         => 'evenementiel',
				'title'        => __( 'Evenementiel', 'improcestout' ),
				'details'      => array( __( 'Restitution improvisee', 'improcestout' ), __( 'Animation', 'improcestout' ), __( 'Sur mesure', 'improcestout' ) ),
				'imageId'      => 11,
				'angle'        => -135,
				'radius'       => 43,
				'cardRotation' => -3,
			),
			array(
				'pageId'       => 23,
				'slug'         => 'theatre-forum',
				'title'        => __( 'Theatre forum', 'improcestout' ),
				'details'      => array( __( 'Situation jouee', 'improcestout' ), __( 'Debat', 'improcestout' ), __( 'Issues a tester', 'improcestout' ) ),
				'imageId'      => 12,
				'angle'        => -45,
				'radius'       => 43,
				'cardRotation' => 3,
			),
			array(
				'pageId'       => 15,
				'slug'         => 'publics-fragilises',
				'title'        => __( 'Publics fragilises', 'improcestout' ),
				'details'      => array( __( 'Atelier d\'impro', 'improcestout' ), __( 'Cadre adapte', 'improcestout' ) ),
				'imageId'      => 13,
				'angle'        => 0,
				'radius'       => 43,
				'cardRotation' => -1,
			),
			array(
				'pageId'       => 24,
				'slug'         => 'pros-du-social-medico-social',
				'title'        => __( 'Pros du social', 'improcestout' ),
				'details'      => array( __( 'Mises en situation', 'improcestout' ), __( 'Cohesion', 'improcestout' ), __( 'Forum', 'improcestout' ) ),
				'imageId'      => 10,
				'angle'        => 42,
				'radius'       => 45,
				'cardRotation' => 2,
			),
			array(
				'pageId'       => 16,
				'slug'         => 'entreprises',
				'title'        => __( 'Entreprises', 'improcestout' ),
				'details'      => array( __( 'Prise de parole', 'improcestout' ), __( 'Posture pro', 'improcestout' ), __( 'Cohesion', 'improcestout' ) ),
				'imageId'      => 13,
				'angle'        => 138,
				'radius'       => 45,
				'cardRotation' => -2,
			),
			array(
				'pageId'       => 14,
				'slug'         => 'just-do-impro',
				'title'        => __( 'Just do impro', 'improcestout' ),
				'details'      => array( __( 'Stages', 'improcestout' ), __( 'Ateliers', 'improcestout' ), __( 'Spectacles', 'improcestout' ) ),
				'imageId'      => 12,
				'angle'        => 180,
				'radius'       => 43,
				'cardRotation' => 1,
			),
		);
	}
endif;

if ( ! function_exists( 'improcestout_get_default_sun_card_colors' ) ) :
	/**
	 * Returns default color controls for sun navigation cards.
	 *
	 * @return array
	 */
	function improcestout_get_default_sun_card_colors() {
		return array(
			'background' => '#fff8e8',
			'border'     => '#1e0507',
			'shadow'     => '#1e0507',
			'text'       => '#1e0507',
			'accent'     => '#e92c5a',
		);
	}
endif;

if ( ! function_exists( 'improcestout_normalize_sun_card_colors' ) ) :
	/**
	 * Sanitizes card color settings.
	 *
	 * @param mixed $colors Color data.
	 * @param bool  $with_defaults Whether to fill missing values with defaults.
	 * @return array
	 */
	function improcestout_normalize_sun_card_colors( $colors, $with_defaults = false ) {
		$defaults = improcestout_get_default_sun_card_colors();
		$colors   = is_array( $colors ) ? $colors : array();
		$output   = $with_defaults ? $defaults : array();

		foreach ( $defaults as $key => $default ) {
			if ( empty( $colors[ $key ] ) ) {
				continue;
			}

			$color = sanitize_hex_color( $colors[ $key ] );

			if ( $color ) {
				$output[ $key ] = $color;
			}
		}

		return $output;
	}
endif;

if ( ! function_exists( 'improcestout_get_sun_card_color_css' ) ) :
	/**
	 * Builds custom properties for sun navigation card colors.
	 *
	 * @param array $colors Sanitized color data.
	 * @return string
	 */
	function improcestout_get_sun_card_color_css( $colors ) {
		$properties = array(
			'background' => '--card-bg',
			'border'     => '--card-border',
			'shadow'     => '--card-shadow',
			'text'       => '--card-text',
			'accent'     => '--card-accent',
		);
		$css        = '';

		foreach ( $properties as $key => $property ) {
			if ( ! empty( $colors[ $key ] ) ) {
				$css .= $property . ':' . $colors[ $key ] . ';';
			}
		}

		return $css;
	}
endif;

if ( ! function_exists( 'improcestout_parse_sun_details' ) ) :
	/**
	 * Parses card details from block attributes.
	 *
	 * @param mixed $details Detail data.
	 * @return array
	 */
	function improcestout_parse_sun_details( $details ) {
		if ( is_array( $details ) ) {
			$items = $details;
		} else {
			$items = preg_split( '/[\r\n|]+/', (string) $details );
		}

		return array_values(
			array_filter(
				array_map( 'sanitize_text_field', $items ),
				static function ( $item ) {
					return '' !== $item;
				}
			)
		);
	}
endif;

if ( ! function_exists( 'improcestout_render_sun_navigation_block' ) ) :
	/**
	 * Renders the configurable home sun navigation block.
	 *
	 * @param array $attributes Block attributes.
	 * @return string
	 */
	function improcestout_render_sun_navigation_block( $attributes = array() ) {
		$items        = $attributes['items'] ?? array();
		$card_colors  = improcestout_normalize_sun_card_colors( $attributes['cardColors'] ?? array(), true );
		$stage_styles = improcestout_get_sun_card_color_css( $card_colors );

		if ( ! is_array( $items ) || empty( $items ) ) {
			$items = improcestout_get_default_sun_items();
		}

		$output  = '<div class="impro-sun-stage impro-sun-stage--dynamic" style="' . esc_attr( $stage_styles ) . '">';
		$output .= '<div class="impro-sun-rays" aria-hidden="true">';

		foreach ( $items as $index => $item ) {
			$angle  = isset( $item['angle'] ) ? (float) $item['angle'] : ( -135 + ( $index * 54 ) );
			$radius = isset( $item['radius'] ) ? max( 20, min( 70, (float) $item['radius'] ) ) : 43;

			$output .= sprintf(
				'<span class="impro-sun-ray" style="%1$s"></span>',
				esc_attr( '--ray-angle:' . $angle . 'deg;--ray-length:' . $radius . '%;' )
			);
		}

		$output .= '</div>';
		$output .= sprintf(
			'<div class="impro-sun-logo"><a href="%1$s" aria-label="%2$s"><img src="%3$s" alt="%2$s"></a></div>',
			esc_url( home_url( '/' ) ),
			esc_attr( get_bloginfo( 'name' ) ),
			esc_url( get_theme_file_uri( 'assets/images/impro-logo-transparent.png' ) )
		);
		$output .= '<nav class="impro-ray-nav" aria-label="' . esc_attr__( 'Navigation principale', 'improcestout' ) . '">';

		foreach ( $items as $index => $item ) {
			$page_id = absint( $item['pageId'] ?? 0 );
			$page    = $page_id ? get_post( $page_id ) : null;
			$slug    = ! empty( $item['slug'] ) ? sanitize_title( $item['slug'] ) : '';

			if ( $page && ( 'page' !== $page->post_type || ( $slug && $slug !== $page->post_name ) ) ) {
				$page = null;
			}

			if ( ! $page && $slug ) {
				$page = get_page_by_path( $slug );
			}

			$url       = $page ? get_permalink( $page ) : home_url( '/' );
			$title     = ! empty( $item['title'] ) ? sanitize_text_field( $item['title'] ) : ( $page ? get_the_title( $page ) : __( 'Page', 'improcestout' ) );
			$details   = improcestout_parse_sun_details( $item['details'] ?? ( $item['text'] ?? '' ) );
			$image_id  = absint( $item['imageId'] ?? ( $item['image'] ?? 0 ) );
			$image_id  = $image_id ? $image_id : ( $page ? get_post_thumbnail_id( $page ) : 0 );
			$angle     = isset( $item['angle'] ) ? (float) $item['angle'] : ( -135 + ( $index * 54 ) );
			$radius    = isset( $item['radius'] ) ? max( 20, min( 70, (float) $item['radius'] ) ) : 43;
			$rotation  = isset( $item['cardRotation'] ) ? (float) $item['cardRotation'] : 0;
			$radians   = deg2rad( $angle );
			$card_x    = 50 + ( cos( $radians ) * $radius );
			$card_y    = 50 + ( sin( $radians ) * $radius );
			$card_x    = max( -8, min( 108, $card_x ) );
			$card_y    = max( -8, min( 108, $card_y ) );
			$card_css  = sprintf( '--card-x:%.3F%%;--card-y:%.3F%%;--card-rotation:%.3Fdeg;', $card_x, $card_y, $rotation );
			$card_css .= improcestout_get_sun_card_color_css( improcestout_normalize_sun_card_colors( $item['colors'] ?? array() ) );
			$image     = $image_id ? wp_get_attachment_image( $image_id, 'medium_large', false, array( 'loading' => 0 === $index ? 'eager' : 'lazy' ) ) : '';
			$detail_html = '';

			foreach ( $details as $detail ) {
				$detail_html .= '<span>' . esc_html( $detail ) . '</span>';
			}

			$output .= sprintf(
				'<a class="impro-ray-card impro-ray-card--dynamic impro-ray-card--item-%1$d" style="%2$s" href="%3$s"><span class="impro-ray-image">%4$s</span><span class="impro-ray-copy"><strong>%5$s</strong><span class="impro-ray-details">%6$s</span></span></a>',
				(int) $index + 1,
				esc_attr( $card_css ),
				esc_url( $url ),
				$image,
				esc_html( $title ),
				$detail_html
			);
		}

		$output .= '</nav></div>';

		return $output;
	}
endif;

if ( ! function_exists( 'improcestout_register_sun_navigation_block' ) ) :
	/**
	 * Registers the configurable sun navigation block.
	 *
	 * @return void
	 */
	function improcestout_register_sun_navigation_block() {
		$script_path = get_theme_file_path( 'assets/js/sun-navigation-block.js' );

		wp_register_script(
			'improcestout-sun-navigation-block',
			get_theme_file_uri( 'assets/js/sun-navigation-block.js' ),
			array( 'wp-blocks', 'wp-block-editor', 'wp-components', 'wp-compose', 'wp-data', 'wp-element', 'wp-i18n' ),
			file_exists( $script_path ) ? filemtime( $script_path ) : wp_get_theme()->get( 'Version' ),
			true
		);
		wp_localize_script(
			'improcestout-sun-navigation-block',
			'improcestoutSunNavigationBlock',
			array(
				'logoUrl' => get_theme_file_uri( 'assets/images/impro-logo-transparent.png' ),
			)
		);

		register_block_type(
			'improcestout/sun-navigation',
			array(
				'api_version'     => 3,
				'title'           => __( 'Navigation soleil', 'improcestout' ),
				'category'        => 'design',
				'icon'            => 'star-filled',
				'editor_script'   => 'improcestout-sun-navigation-block',
				'render_callback' => 'improcestout_render_sun_navigation_block',
				'attributes'      => array(
					'items' => array(
						'type'    => 'array',
						'default' => improcestout_get_default_sun_items(),
					),
					'cardColors' => array(
						'type'    => 'object',
						'default' => improcestout_get_default_sun_card_colors(),
					),
				),
				'supports'        => array(
					'align' => false,
					'html'  => false,
				),
			)
		);
	}
endif;
add_action( 'init', 'improcestout_register_sun_navigation_block' );

if ( ! function_exists( 'improcestout_enqueue_block_editor_assets' ) ) :
	/**
	 * Loads the theme visual rules in the block editor.
	 *
	 * @return void
	 */
	function improcestout_enqueue_block_editor_assets() {
		$src = SCRIPT_DEBUG ? 'style.css' : 'style.min.css';

		wp_enqueue_style(
			'improcestout-editor-block-style',
			get_theme_file_uri( $src ),
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}
endif;
add_action( 'enqueue_block_editor_assets', 'improcestout_enqueue_block_editor_assets' );

if ( ! function_exists( 'improcestout_mark_current_navigation_link' ) ) :
	/**
	 * Adds an active class to static navigation links matching the current URL.
	 *
	 * @param string $block_content Rendered block HTML.
	 * @param array  $block         Parsed block data.
	 * @return string
	 */
	function improcestout_mark_current_navigation_link( $block_content, $block ) {
		if ( 'core/navigation-link' !== ( $block['blockName'] ?? '' ) || empty( $block['attrs']['url'] ) ) {
			return $block_content;
		}

		$current_path = wp_parse_url( home_url( wp_unslash( $_SERVER['REQUEST_URI'] ?? '/' ) ), PHP_URL_PATH );
		$target_path  = wp_parse_url( home_url( $block['attrs']['url'] ), PHP_URL_PATH );

		$current_path = untrailingslashit( $current_path ?: '/' );
		$target_path  = untrailingslashit( $target_path ?: '/' );

		if ( '' === $current_path ) {
			$current_path = '/';
		}

		if ( '' === $target_path ) {
			$target_path = '/';
		}

		if ( $current_path !== $target_path ) {
			return $block_content;
		}

		$processor = new WP_HTML_Tag_Processor( $block_content );

		if ( $processor->next_tag( 'a' ) ) {
			$processor->add_class( 'is-current-path' );
			$processor->set_attribute( 'aria-current', 'page' );
			return $processor->get_updated_html();
		}

		return $block_content;
	}
endif;
add_filter( 'render_block', 'improcestout_mark_current_navigation_link', 10, 2 );
