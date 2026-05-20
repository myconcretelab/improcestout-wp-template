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

if ( ! function_exists( 'improcestout_sun_navigation' ) ) :
	/**
	 * Outputs the home radial navigation.
	 *
	 * @return string
	 */
	function improcestout_sun_navigation() {
		$items = array(
			array(
				'slug'    => 'spectacles',
				'title'   => __( 'Spectacles', 'improcestout' ),
				'text'    => __( 'Des formats courts, nerveux et collectifs pour faire surgir l\'histoire en direct.', 'improcestout' ),
				'image'   => 13,
				'variant' => 'one',
			),
			array(
				'slug'    => 'ateliers',
				'title'   => __( 'Ateliers', 'improcestout' ),
				'text'    => __( 'Des exercices de jeu, d\'écoute et de lâcher prise pour entrer dans l\'impro.', 'improcestout' ),
				'image'   => 12,
				'variant' => 'two',
			),
			array(
				'slug'    => 'stages',
				'title'   => __( 'Stages', 'improcestout' ),
				'text'    => __( 'Des immersions plus longues pour travailler le personnage, le rythme et le groupe.', 'improcestout' ),
				'image'   => 10,
				'variant' => 'three',
			),
			array(
				'slug'    => 'agenda',
				'title'   => __( 'Agenda', 'improcestout' ),
				'text'    => __( 'Les prochaines dates, les rendez-vous publics et les occasions de nous rejoindre.', 'improcestout' ),
				'image'   => 11,
				'variant' => 'four',
			),
		);

		$output  = '<div class="impro-sun-stage">';
		$output .= '<div class="impro-sun-rays" aria-hidden="true"><span class="impro-sun-ray impro-sun-ray--one"></span><span class="impro-sun-ray impro-sun-ray--two"></span><span class="impro-sun-ray impro-sun-ray--three"></span><span class="impro-sun-ray impro-sun-ray--four"></span></div>';
		$output .= sprintf(
			'<div class="impro-sun-logo"><a href="%1$s" aria-label="%2$s"><img src="%3$s" alt="%2$s"></a></div>',
			esc_url( home_url( '/' ) ),
			esc_attr( get_bloginfo( 'name' ) ),
			esc_url( get_theme_file_uri( 'assets/images/impro-logo-transparent.png' ) )
		);
		$output .= '<nav class="impro-ray-nav" aria-label="' . esc_attr__( 'Navigation principale', 'improcestout' ) . '">';

		foreach ( $items as $item ) {
			$page = get_page_by_path( $item['slug'] );
			$url  = $page ? get_permalink( $page ) : home_url( '/' . $item['slug'] . '/' );

			$output .= sprintf(
				'<a class="impro-ray-card impro-ray-card--%1$s" href="%2$s"><span class="impro-ray-image">%3$s</span><span class="impro-ray-copy"><strong>%4$s</strong><em>%5$s</em></span></a>',
				esc_attr( $item['variant'] ),
				esc_url( $url ),
				wp_get_attachment_image( $item['image'], 'medium_large', false, array( 'loading' => 'eager' ) ),
				esc_html( $item['title'] ),
				esc_html( $item['text'] )
			);
		}

		$output .= '</nav></div>';

		return $output;
	}
endif;
add_shortcode( 'impro_sun_navigation', 'improcestout_sun_navigation' );

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
