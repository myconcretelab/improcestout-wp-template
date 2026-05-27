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

if ( ! function_exists( 'improcestout_enqueue_header_script' ) ) :
	/**
	 * Loads the animated sticky header behavior.
	 *
	 * @return void
	 */
	function improcestout_enqueue_header_script() {
		$script_path = get_theme_file_path( 'assets/js/header.js' );

		wp_enqueue_script(
			'improcestout-header',
			get_theme_file_uri( 'assets/js/header.js' ),
			array(),
			file_exists( $script_path ) ? filemtime( $script_path ) : wp_get_theme()->get( 'Version' ),
			true
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'improcestout_enqueue_header_script' );

if ( ! function_exists( 'improcestout_custom_logo_image_attributes' ) ) :
	/**
	 * Keeps the responsive image choice in sync with the enlarged sticky header logo.
	 *
	 * @param array $attr Custom logo image attributes.
	 *
	 * @return array
	 */
	function improcestout_custom_logo_image_attributes( $attr ) {
		$attr['sizes'] = '(max-width: 760px) 52px, 320px';

		return $attr;
	}
endif;
add_filter( 'get_custom_logo_image_attributes', 'improcestout_custom_logo_image_attributes' );

if ( ! function_exists( 'improcestout_register_intervenants' ) ) :
	/**
	 * Registers the intervenant content type and its page assignment taxonomy.
	 *
	 * @return void
	 */
	function improcestout_register_intervenants() {
		$labels = array(
			'name'                  => _x( 'Intervenants', 'Post type general name', 'improcestout' ),
			'singular_name'         => _x( 'Intervenant', 'Post type singular name', 'improcestout' ),
			'menu_name'             => _x( 'Intervenants', 'Admin Menu text', 'improcestout' ),
			'name_admin_bar'        => _x( 'Intervenant', 'Add New on Toolbar', 'improcestout' ),
			'add_new'               => __( 'Ajouter', 'improcestout' ),
			'add_new_item'          => __( 'Ajouter un intervenant', 'improcestout' ),
			'new_item'              => __( 'Nouvel intervenant', 'improcestout' ),
			'edit_item'             => __( 'Modifier l\'intervenant', 'improcestout' ),
			'view_item'             => __( 'Voir l\'intervenant', 'improcestout' ),
			'all_items'             => __( 'Tous les intervenants', 'improcestout' ),
			'search_items'          => __( 'Rechercher des intervenants', 'improcestout' ),
			'not_found'             => __( 'Aucun intervenant trouve.', 'improcestout' ),
			'not_found_in_trash'    => __( 'Aucun intervenant dans la corbeille.', 'improcestout' ),
			'featured_image'        => __( 'Photo', 'improcestout' ),
			'set_featured_image'    => __( 'Ajouter une photo', 'improcestout' ),
			'remove_featured_image' => __( 'Retirer la photo', 'improcestout' ),
			'use_featured_image'    => __( 'Utiliser comme photo', 'improcestout' ),
		);

		register_post_type(
			'intervenant',
			array(
				'labels'       => $labels,
				'public'       => true,
				'show_in_rest' => true,
				'menu_icon'    => 'dashicons-groups',
				'has_archive'  => false,
				'rewrite'      => array( 'slug' => 'intervenants' ),
				'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
			)
		);

			register_taxonomy_for_object_type( 'category', 'intervenant' );
			register_taxonomy_for_object_type( 'category', 'page' );

			if ( ! get_option( 'improcestout_intervenant_categories_migrated' ) ) {
				register_taxonomy(
					'categorie_intervenant',
					array( 'intervenant', 'page' ),
					array(
						'hierarchical'      => true,
						'public'            => false,
						'show_ui'           => false,
						'show_admin_column' => false,
						'show_in_rest'      => false,
						'rewrite'           => false,
					)
				);
			}

		foreach ( array( 'prenom', 'nom', 'email' ) as $meta_key ) {
			register_post_meta(
				'intervenant',
				'improcestout_intervenant_' . $meta_key,
				array(
					'type'              => 'string',
					'single'            => true,
					'show_in_rest'      => true,
					'sanitize_callback' => 'email' === $meta_key ? 'sanitize_email' : 'sanitize_text_field',
					'auth_callback'     => static function () {
						return current_user_can( 'edit_posts' );
					},
				)
			);
		}
	}
	endif;
	add_action( 'init', 'improcestout_register_intervenants' );

if ( ! function_exists( 'improcestout_migrate_intervenant_categories_to_core_categories' ) ) :
	/**
	 * Copies old intervenant/page category terms to WordPress native categories.
	 *
	 * @return void
	 */
	function improcestout_migrate_intervenant_categories_to_core_categories() {
		if ( get_option( 'improcestout_intervenant_categories_migrated' ) || ! taxonomy_exists( 'categorie_intervenant' ) ) {
			return;
		}

		$old_terms = get_terms(
			array(
				'taxonomy'   => 'categorie_intervenant',
				'hide_empty' => false,
			)
		);

		if ( is_wp_error( $old_terms ) ) {
			return;
		}

		foreach ( $old_terms as $old_term ) {
			$target_term = term_exists( $old_term->slug, 'category' );

			if ( ! $target_term ) {
				$target_term = wp_insert_term(
					$old_term->name,
					'category',
					array(
						'slug'        => $old_term->slug,
						'description' => $old_term->description,
					)
				);
			}

			if ( is_wp_error( $target_term ) || empty( $target_term['term_id'] ) ) {
				continue;
			}

			$object_ids = get_objects_in_term( $old_term->term_id, 'categorie_intervenant' );

			if ( is_wp_error( $object_ids ) || ! $object_ids ) {
				continue;
			}

			foreach ( $object_ids as $object_id ) {
				wp_set_object_terms( (int) $object_id, array( (int) $target_term['term_id'] ), 'category', true );
			}
		}

		update_option( 'improcestout_intervenant_categories_migrated', wp_get_theme()->get( 'Version' ), false );
	}
endif;
add_action( 'admin_init', 'improcestout_migrate_intervenant_categories_to_core_categories' );

	if ( ! function_exists( 'improcestout_add_intervenant_meta_boxes' ) ) :
	/**
	 * Adds editable intervenant fields.
	 *
	 * @return void
	 */
	function improcestout_add_intervenant_meta_boxes() {
		add_meta_box(
			'improcestout_intervenant_details',
			__( 'Informations intervenant', 'improcestout' ),
			'improcestout_render_intervenant_meta_box',
			'intervenant',
			'normal',
			'high'
		);
	}
endif;
add_action( 'add_meta_boxes', 'improcestout_add_intervenant_meta_boxes' );

if ( ! function_exists( 'improcestout_render_intervenant_meta_box' ) ) :
	/**
	 * Renders the intervenant fields metabox.
	 *
	 * @param WP_Post $post Current post object.
	 * @return void
	 */
	function improcestout_render_intervenant_meta_box( $post ) {
		$prenom = get_post_meta( $post->ID, 'improcestout_intervenant_prenom', true );
		$nom    = get_post_meta( $post->ID, 'improcestout_intervenant_nom', true );
		$email  = get_post_meta( $post->ID, 'improcestout_intervenant_email', true );

		wp_nonce_field( 'improcestout_save_intervenant_details', 'improcestout_intervenant_nonce' );
		?>
		<p>
			<label for="improcestout_intervenant_prenom"><strong><?php esc_html_e( 'Prenom', 'improcestout' ); ?></strong></label><br>
			<input type="text" id="improcestout_intervenant_prenom" name="improcestout_intervenant_prenom" value="<?php echo esc_attr( $prenom ); ?>" class="widefat">
		</p>
		<p>
			<label for="improcestout_intervenant_nom"><strong><?php esc_html_e( 'Nom', 'improcestout' ); ?></strong></label><br>
			<input type="text" id="improcestout_intervenant_nom" name="improcestout_intervenant_nom" value="<?php echo esc_attr( $nom ); ?>" class="widefat">
		</p>
		<p>
			<label for="improcestout_intervenant_email"><strong><?php esc_html_e( 'Email', 'improcestout' ); ?></strong></label><br>
			<input type="email" id="improcestout_intervenant_email" name="improcestout_intervenant_email" value="<?php echo esc_attr( $email ); ?>" class="widefat">
		</p>
		<p><?php esc_html_e( 'La photo se renseigne avec le bloc Photo de l\'intervenant dans la colonne laterale.', 'improcestout' ); ?></p>
		<?php
	}
endif;

if ( ! function_exists( 'improcestout_save_intervenant_meta' ) ) :
	/**
	 * Saves intervenant fields.
	 *
	 * @param int     $post_id Current post ID.
	 * @param WP_Post $post Current post object.
	 * @return void
	 */
	function improcestout_save_intervenant_meta( $post_id, $post ) {
		if ( ! isset( $_POST['improcestout_intervenant_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['improcestout_intervenant_nonce'] ), 'improcestout_save_intervenant_details' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$prenom = isset( $_POST['improcestout_intervenant_prenom'] ) ? sanitize_text_field( wp_unslash( $_POST['improcestout_intervenant_prenom'] ) ) : '';
		$nom    = isset( $_POST['improcestout_intervenant_nom'] ) ? sanitize_text_field( wp_unslash( $_POST['improcestout_intervenant_nom'] ) ) : '';
		$email  = isset( $_POST['improcestout_intervenant_email'] ) ? sanitize_email( wp_unslash( $_POST['improcestout_intervenant_email'] ) ) : '';

		update_post_meta( $post_id, 'improcestout_intervenant_prenom', $prenom );
		update_post_meta( $post_id, 'improcestout_intervenant_nom', $nom );
		update_post_meta( $post_id, 'improcestout_intervenant_email', $email );

		$generated_title = trim( $prenom . ' ' . $nom );

		if ( $generated_title && ( '' === trim( $post->post_title ) || __( 'Auto Draft' ) === $post->post_title ) ) {
			remove_action( 'save_post_intervenant', 'improcestout_save_intervenant_meta', 10 );
			wp_update_post(
				array(
					'ID'         => $post_id,
					'post_title' => $generated_title,
				)
			);
			add_action( 'save_post_intervenant', 'improcestout_save_intervenant_meta', 10, 2 );
		}
	}
endif;
add_action( 'save_post_intervenant', 'improcestout_save_intervenant_meta', 10, 2 );

if ( ! function_exists( 'improcestout_get_intervenant_name' ) ) :
	/**
	 * Returns the public display name for an intervenant.
	 *
	 * @param int $post_id Intervenant post ID.
	 * @return string
	 */
	function improcestout_get_intervenant_name( $post_id ) {
		$prenom = trim( (string) get_post_meta( $post_id, 'improcestout_intervenant_prenom', true ) );
		$nom    = trim( (string) get_post_meta( $post_id, 'improcestout_intervenant_nom', true ) );
		$name   = trim( $prenom . ' ' . $nom );

		return $name ? $name : get_the_title( $post_id );
	}
endif;

if ( ! function_exists( 'improcestout_normalize_intervenants_attributes' ) ) :
	/**
	 * Normalizes public settings for the intervenants listing.
	 *
	 * @param array $attributes Listing attributes.
	 * @return array
	 */
	function improcestout_normalize_intervenants_attributes( $attributes = array() ) {
		$attributes = wp_parse_args(
			$attributes,
			array(
				'categorySlug'     => '',
				'categories'       => array(),
				'inheritPageTerms' => false,
				'columns'          => 3,
				'showIntro'        => true,
				'introText'        => __( 'La troupe en mouvement', 'improcestout' ),
				'showPhoto'        => true,
				'showExcerpt'      => true,
				'showCategories'   => true,
				'showEmail'        => true,
				'emptyText'        => __( 'Les intervenants apparaitront ici des qu\'ils seront publies.', 'improcestout' ),
			)
		);

		$categories = array();

		if ( '' !== trim( (string) $attributes['categorySlug'] ) ) {
			$categories[] = sanitize_title( $attributes['categorySlug'] );
		} elseif ( ! empty( $attributes['categories'] ) ) {
			$categories = array_map( 'sanitize_title', wp_parse_list( $attributes['categories'] ) );
		}

		$columns = min( 4, max( 1, absint( $attributes['columns'] ) ) );

		return array(
			'categories'       => array_values( array_filter( array_unique( $categories ) ) ),
			'inheritPageTerms' => rest_sanitize_boolean( $attributes['inheritPageTerms'] ),
			'columns'          => $columns,
			'showIntro'        => rest_sanitize_boolean( $attributes['showIntro'] ),
			'introText'        => sanitize_text_field( $attributes['introText'] ),
			'showPhoto'        => rest_sanitize_boolean( $attributes['showPhoto'] ),
			'showExcerpt'      => rest_sanitize_boolean( $attributes['showExcerpt'] ),
			'showCategories'   => rest_sanitize_boolean( $attributes['showCategories'] ),
			'showEmail'        => rest_sanitize_boolean( $attributes['showEmail'] ),
			'emptyText'        => sanitize_text_field( $attributes['emptyText'] ),
		);
	}
endif;

if ( ! function_exists( 'improcestout_render_intervenants' ) ) :
	/**
	 * Renders the intervenants board.
	 *
	 * @param array $attributes Listing attributes.
	 * @param bool  $use_block_wrapper Whether to add block wrapper attributes.
	 * @return string
	 */
	function improcestout_render_intervenants( $attributes = array(), $use_block_wrapper = false ) {
		$settings = improcestout_normalize_intervenants_attributes( $attributes );

		$query_args = array(
			'post_type'      => 'intervenant',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
		);

		if ( $settings['categories'] ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'field'    => 'slug',
					'terms'    => $settings['categories'],
				),
			);
		} elseif ( $settings['inheritPageTerms'] && is_page() ) {
			$terms = get_the_terms( get_the_ID(), 'category' );

			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				$query_args['tax_query'] = array(
					array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => wp_list_pluck( $terms, 'term_id' ),
					),
				);
			}
		}

		$intervenants = new WP_Query( $query_args );
		$grid_classes = 'impro-intervenants-grid impro-intervenants-grid--columns-' . $settings['columns'];
		$wrapper      = array( 'class' => 'impro-intervenants-board' );

		ob_start();
		?>
		<section <?php echo $use_block_wrapper ? get_block_wrapper_attributes( $wrapper ) : 'class="' . esc_attr( $wrapper['class'] ) . '"'; ?>>
			<?php if ( $settings['showIntro'] && $settings['introText'] ) : ?>
				<div class="impro-intervenants-board__intro">
					<p><?php echo esc_html( $settings['introText'] ); ?></p>
				</div>
			<?php endif; ?>

			<?php if ( $intervenants->have_posts() ) : ?>
				<div class="<?php echo esc_attr( $grid_classes ); ?>">
					<?php
					$index = 0;
					while ( $intervenants->have_posts() ) :
						$intervenants->the_post();
						$index++;
						$post_id = get_the_ID();
						$email   = get_post_meta( $post_id, 'improcestout_intervenant_email', true );
						$classes = 'impro-intervenant-card impro-intervenant-card--' . ( $index % 6 );
						?>
						<article class="<?php echo esc_attr( $classes ); ?>">
							<?php if ( $settings['showPhoto'] ) : ?>
								<div class="impro-intervenant-card__photo">
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'medium_large' ); ?>
									<?php else : ?>
										<span aria-hidden="true"><?php echo esc_html( substr( improcestout_get_intervenant_name( $post_id ), 0, 1 ) ); ?></span>
									<?php endif; ?>
								</div>
							<?php endif; ?>
							<div class="impro-intervenant-card__content">
								<h2><?php echo esc_html( improcestout_get_intervenant_name( $post_id ) ); ?></h2>
								<?php if ( $settings['showExcerpt'] && has_excerpt() ) : ?>
									<p><?php echo esc_html( get_the_excerpt() ); ?></p>
								<?php endif; ?>
								<?php if ( $settings['showCategories'] ) : ?>
									<?php
										$term_list = get_the_term_list( $post_id, 'category', '<div class="impro-intervenant-card__terms">', '', '</div>' );
									if ( $term_list && ! is_wp_error( $term_list ) ) {
										echo $term_list; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									}
									?>
								<?php endif; ?>
								<?php if ( $settings['showEmail'] && $email ) : ?>
									<a class="impro-intervenant-card__email" href="<?php echo esc_url( 'mailto:' . antispambot( $email ) ); ?>"><?php echo esc_html( antispambot( $email ) ); ?></a>
								<?php endif; ?>
							</div>
						</article>
					<?php endwhile; ?>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php else : ?>
				<p class="impro-intervenants-empty"><?php echo esc_html( $settings['emptyText'] ); ?></p>
			<?php endif; ?>
		</section>
		<?php

		return ob_get_clean();
	}
endif;

if ( ! function_exists( 'improcestout_render_intervenants_shortcode' ) ) :
	/**
	 * Renders the intervenants board shortcode.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	function improcestout_render_intervenants_shortcode( $atts = array() ) {
		$atts = shortcode_atts(
			array(
				'category'        => '',
				'categories'      => '',
				'columns'         => 3,
				'show_intro'      => true,
				'intro_text'      => __( 'La troupe en mouvement', 'improcestout' ),
				'show_photo'      => true,
				'show_excerpt'    => true,
				'show_categories' => true,
				'show_email'      => true,
				'empty_text'      => __( 'Les intervenants apparaitront ici des qu\'ils seront publies.', 'improcestout' ),
			),
			$atts,
			'improcestout_intervenants'
		);

		return improcestout_render_intervenants(
			array(
				'categorySlug'     => $atts['category'],
				'categories'       => $atts['categories'],
				'inheritPageTerms' => '' === trim( (string) $atts['category'] ) && '' === trim( (string) $atts['categories'] ),
				'columns'          => $atts['columns'],
				'showIntro'        => $atts['show_intro'],
				'introText'        => $atts['intro_text'],
				'showPhoto'        => $atts['show_photo'],
				'showExcerpt'      => $atts['show_excerpt'],
				'showCategories'   => $atts['show_categories'],
				'showEmail'        => $atts['show_email'],
				'emptyText'        => $atts['empty_text'],
			)
		);
	}
endif;
add_shortcode( 'improcestout_intervenants', 'improcestout_render_intervenants_shortcode' );

if ( ! function_exists( 'improcestout_get_formation_icon_choices' ) ) :
	/**
	 * Returns the controlled icon library for formation info rows.
	 *
	 * @return array
	 */
	function improcestout_get_formation_icon_choices() {
		return array(
			'clock'     => __( 'Horloge', 'improcestout' ),
			'target'    => __( 'Cible', 'improcestout' ),
			'users'     => __( 'Groupe', 'improcestout' ),
			'suitcase'  => __( 'Mallette', 'improcestout' ),
			'clipboard' => __( 'Evaluation', 'improcestout' ),
			'building'  => __( 'Batiment', 'improcestout' ),
			'tag'       => __( 'Prix', 'improcestout' ),
			'funding'   => __( 'Financement', 'improcestout' ),
			'calendar'  => __( 'Calendrier', 'improcestout' ),
			'map-pin'   => __( 'Lieu', 'improcestout' ),
			'book'      => __( 'Livre', 'improcestout' ),
			'speech'    => __( 'Parole', 'improcestout' ),
			'handshake' => __( 'Accord', 'improcestout' ),
			'heart'     => __( 'Coeur', 'improcestout' ),
			'lightbulb' => __( 'Idee', 'improcestout' ),
			'star'      => __( 'Etoile', 'improcestout' ),
			'laptop'    => __( 'Ordinateur', 'improcestout' ),
			'award'     => __( 'Certification', 'improcestout' ),
			'puzzle'    => __( 'Puzzle', 'improcestout' ),
			'shield'    => __( 'Protection', 'improcestout' ),
			'mic'       => __( 'Micro', 'improcestout' ),
			'check'     => __( 'Validation', 'improcestout' ),
		);
	}
endif;

if ( ! function_exists( 'improcestout_get_formation_icon_svg' ) ) :
	/**
	 * Returns an SVG icon from the controlled icon library.
	 *
	 * @param string $icon Icon slug.
	 * @return string
	 */
	function improcestout_get_formation_icon_svg( $icon ) {
		$icon = sanitize_key( $icon );
		$svg  = array(
			'clock'     => '<circle cx="12" cy="12" r="9"></circle><path d="M12 6v6l4-3"></path>',
			'target'    => '<circle cx="12" cy="12" r="9"></circle><circle cx="12" cy="12" r="5"></circle><circle cx="12" cy="12" r="2"></circle><path d="M12 1v3M12 20v3M1 12h3M20 12h3"></path>',
			'users'     => '<path d="M16 20v-2a4 4 0 0 0-8 0v2"></path><circle cx="12" cy="8" r="4"></circle><path d="M4 20v-1a4 4 0 0 1 3-3.8M20 20v-1a4 4 0 0 0-3-3.8"></path>',
			'suitcase'  => '<rect x="3" y="7" width="18" height="13" rx="2"></rect><path d="M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2M3 13h18"></path>',
			'clipboard' => '<path d="M8 4h8v3H8z"></path><rect x="5" y="5" width="14" height="17" rx="2"></rect><path d="M9 12h6M9 17h6"></path>',
			'building'  => '<path d="M4 21h16"></path><path d="M6 21V7l8-4v18"></path><path d="M14 9h4v12"></path><path d="M9 10h2M9 14h2M9 18h2"></path>',
			'tag'       => '<path d="M20 13 13 20 4 11V4h7z"></path><circle cx="8.5" cy="8.5" r="1.5"></circle><path d="M13 8h5"></path>',
			'funding'   => '<circle cx="10" cy="10" r="7"></circle><path d="m15 15 6 6"></path><path d="M10 6v8M7 10h6"></path>',
			'calendar'  => '<rect x="3" y="5" width="18" height="16" rx="2"></rect><path d="M16 3v4M8 3v4M3 10h18"></path>',
			'map-pin'   => '<path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle>',
			'book'      => '<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M4 4.5A2.5 2.5 0 0 1 6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5z"></path><path d="M8 6h8"></path>',
			'speech'    => '<path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4z"></path><path d="M8 9h8M8 13h5"></path>',
			'handshake' => '<path d="m11 17 2 2a3 3 0 0 0 4.2 0l3.8-3.8"></path><path d="m3 12 5.5-5.5a3 3 0 0 1 4.2 0L14 7.8"></path><path d="m9 12 2-2 3 3a2 2 0 1 0 2.8-2.8L14 7.4"></path><path d="m2 15 4 4M22 11l-4-4"></path>',
			'heart'     => '<path d="M20.8 5.6a5.5 5.5 0 0 0-7.8 0L12 6.6l-1-1a5.5 5.5 0 1 0-7.8 7.8l1 1L12 22l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8Z"></path>',
			'lightbulb' => '<path d="M9 18h6"></path><path d="M10 22h4"></path><path d="M8 14a6 6 0 1 1 8 0c-1 1-1 2-1 4H9c0-2 0-3-1-4Z"></path>',
			'star'      => '<path d="m12 2 3.1 6.4 6.9 1-5 4.9 1.2 6.9L12 18l-6.2 3.2L7 14.3 2 9.4l6.9-1z"></path>',
			'laptop'    => '<rect x="5" y="4" width="14" height="11" rx="2"></rect><path d="M2 20h20l-3-5H5z"></path>',
			'award'     => '<circle cx="12" cy="8" r="5"></circle><path d="m8.5 12.5-2 8 5.5-3 5.5 3-2-8"></path>',
			'puzzle'    => '<path d="M9 3h6v4a2 2 0 1 0 0 4v4h-4a2 2 0 1 1-4 0H3V9h4a2 2 0 1 0 2-2z"></path>',
			'shield'    => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"></path><path d="m9 12 2 2 4-5"></path>',
			'mic'       => '<path d="M12 14a3 3 0 0 0 3-3V5a3 3 0 0 0-6 0v6a3 3 0 0 0 3 3Z"></path><path d="M19 11a7 7 0 0 1-14 0M12 18v4M8 22h8"></path>',
			'check'     => '<path d="M20 6 9 17l-5-5"></path><path d="M4 21h16"></path>',
		);

		if ( empty( $svg[ $icon ] ) ) {
			$icon = 'check';
		}

		return '<svg class="impro-formation-info__svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round">' . $svg[ $icon ] . '</svg>';
	}
endif;

if ( ! function_exists( 'improcestout_get_default_formation_info_items' ) ) :
	/**
	 * Returns the default shared information rows for formations.
	 *
	 * @return array
	 */
	function improcestout_get_default_formation_info_items() {
		return array(
			array( 'id' => 'duree', 'title' => __( 'Duree', 'improcestout' ), 'icon' => 'clock', 'default' => '', 'order' => 10, 'active' => true ),
			array( 'id' => 'publics', 'title' => __( 'Cibles / publics vises', 'improcestout' ), 'icon' => 'target', 'default' => '', 'order' => 20, 'active' => true ),
			array( 'id' => 'participants', 'title' => __( 'Nombre de participants', 'improcestout' ), 'icon' => 'users', 'default' => '', 'order' => 30, 'active' => true ),
			array( 'id' => 'prerequis', 'title' => __( 'Prerequis', 'improcestout' ), 'icon' => 'suitcase', 'default' => '', 'order' => 40, 'active' => true ),
			array( 'id' => 'evaluation', 'title' => __( 'Modalites d\'evaluation', 'improcestout' ), 'icon' => 'clipboard', 'default' => '', 'order' => 50, 'active' => true ),
			array( 'id' => 'format', 'title' => __( 'Format', 'improcestout' ), 'icon' => 'building', 'default' => '', 'order' => 60, 'active' => true ),
			array( 'id' => 'prix', 'title' => __( 'Prix', 'improcestout' ), 'icon' => 'tag', 'default' => '', 'order' => 70, 'active' => true ),
			array( 'id' => 'financement', 'title' => __( 'Financement', 'improcestout' ), 'icon' => 'funding', 'default' => '', 'order' => 80, 'active' => true ),
		);
	}
endif;

if ( ! function_exists( 'improcestout_normalize_formation_info_item' ) ) :
	/**
	 * Sanitizes a shared formation information row.
	 *
	 * @param array  $item Formation info item.
	 * @param string $fallback_id Fallback item ID.
	 * @return array|null
	 */
	function improcestout_normalize_formation_info_item( $item, $fallback_id = '' ) {
		$item    = is_array( $item ) ? $item : array();
		$choices = improcestout_get_formation_icon_choices();
		$id      = sanitize_key( $item['id'] ?? $fallback_id );
		$title   = sanitize_text_field( $item['title'] ?? '' );

		if ( ! $id && $title ) {
			$id = sanitize_key( sanitize_title( $title ) );
		}

		if ( ! $id || ! $title ) {
			return null;
		}

		$icon = sanitize_key( $item['icon'] ?? 'check' );
		if ( ! isset( $choices[ $icon ] ) ) {
			$icon = 'check';
		}

		return array(
			'id'      => $id,
			'title'   => $title,
			'icon'    => $icon,
			'default' => sanitize_textarea_field( $item['default'] ?? '' ),
			'order'   => isset( $item['order'] ) ? (int) $item['order'] : 0,
			'active'  => rest_sanitize_boolean( $item['active'] ?? false ),
		);
	}
endif;

if ( ! function_exists( 'improcestout_get_formation_info_items' ) ) :
	/**
	 * Returns shared formation information rows.
	 *
	 * @param bool $include_inactive Whether inactive rows should be returned.
	 * @return array
	 */
	function improcestout_get_formation_info_items( $include_inactive = false ) {
		$stored = get_option( 'improcestout_formation_info_items', null );
		$raw    = is_array( $stored ) ? $stored : improcestout_get_default_formation_info_items();
		$items  = array();

		foreach ( $raw as $item ) {
			$normalized = improcestout_normalize_formation_info_item( $item );

			if ( $normalized && ( $include_inactive || $normalized['active'] ) ) {
				$items[] = $normalized;
			}
		}

		usort(
			$items,
			static function ( $a, $b ) {
				if ( $a['order'] === $b['order'] ) {
					return strnatcasecmp( $a['title'], $b['title'] );
				}

				return $a['order'] <=> $b['order'];
			}
		);

		return $items;
	}
endif;

if ( ! function_exists( 'improcestout_get_formation_info_items_by_id' ) ) :
	/**
	 * Returns shared formation information rows keyed by ID.
	 *
	 * @param bool $include_inactive Whether inactive rows should be returned.
	 * @return array
	 */
	function improcestout_get_formation_info_items_by_id( $include_inactive = false ) {
		$items = array();

		foreach ( improcestout_get_formation_info_items( $include_inactive ) as $item ) {
			$items[ $item['id'] ] = $item;
		}

		return $items;
	}
endif;

if ( ! function_exists( 'improcestout_register_formations' ) ) :
	/**
	 * Registers the formation content type and public metas.
	 *
	 * @return void
	 */
	function improcestout_register_formations() {
		register_post_type(
			'formation',
			array(
				'labels'       => array(
					'name'                  => _x( 'Formations', 'Post type general name', 'improcestout' ),
					'singular_name'         => _x( 'Formation', 'Post type singular name', 'improcestout' ),
					'menu_name'             => _x( 'Formations', 'Admin Menu text', 'improcestout' ),
					'name_admin_bar'        => _x( 'Formation', 'Add New on Toolbar', 'improcestout' ),
					'add_new'               => __( 'Ajouter', 'improcestout' ),
					'add_new_item'          => __( 'Ajouter une formation', 'improcestout' ),
					'new_item'              => __( 'Nouvelle formation', 'improcestout' ),
					'edit_item'             => __( 'Modifier la formation', 'improcestout' ),
					'view_item'             => __( 'Voir la formation', 'improcestout' ),
					'all_items'             => __( 'Toutes les formations', 'improcestout' ),
					'search_items'          => __( 'Rechercher des formations', 'improcestout' ),
					'not_found'             => __( 'Aucune formation trouvee.', 'improcestout' ),
					'not_found_in_trash'    => __( 'Aucune formation dans la corbeille.', 'improcestout' ),
					'featured_image'        => __( 'Image de la formation', 'improcestout' ),
					'set_featured_image'    => __( 'Ajouter une image', 'improcestout' ),
					'remove_featured_image' => __( 'Retirer l\'image', 'improcestout' ),
					'use_featured_image'    => __( 'Utiliser comme image', 'improcestout' ),
				),
				'public'       => true,
				'show_in_rest' => true,
				'menu_icon'    => 'dashicons-welcome-learn-more',
				'has_archive'  => true,
				'rewrite'      => array( 'slug' => 'formations' ),
				'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'page-attributes', 'custom-fields' ),
			)
		);

		register_taxonomy_for_object_type( 'category', 'formation' );
		register_taxonomy_for_object_type( 'category', 'page' );

		if ( ! get_option( 'improcestout_formation_categories_migrated' ) ) {
			register_taxonomy(
				'categorie_formation',
				array( 'formation', 'page' ),
				array(
					'hierarchical'      => true,
					'public'            => false,
					'show_ui'           => false,
					'show_admin_column' => false,
					'show_in_rest'      => false,
					'rewrite'           => false,
				)
			);
		}

		foreach ( array( 'subtitle', 'hook' ) as $meta_key ) {
			register_post_meta(
				'formation',
				'improcestout_formation_' . $meta_key,
				array(
					'type'              => 'string',
					'single'            => true,
					'show_in_rest'      => true,
					'sanitize_callback' => 'hook' === $meta_key ? 'sanitize_textarea_field' : 'sanitize_text_field',
					'auth_callback'     => static function () {
						return current_user_can( 'edit_posts' );
					},
				)
			);
		}

		register_post_meta(
			'formation',
			'improcestout_formation_info_values',
			array(
				'type'              => 'object',
				'single'            => true,
				'show_in_rest'      => array(
					'schema' => array(
						'type'                 => 'object',
						'additionalProperties' => array(
							'type'       => 'object',
							'properties' => array(
								'enabled'     => array(
									'type' => 'boolean',
								),
								'use_default' => array(
									'type' => 'boolean',
								),
								'text'        => array(
									'type' => 'string',
								),
							),
						),
					),
				),
				'sanitize_callback' => 'improcestout_sanitize_formation_info_values',
				'auth_callback'     => static function () {
					return current_user_can( 'edit_posts' );
				},
			)
		);
	}
endif;
add_action( 'init', 'improcestout_register_formations' );

if ( ! function_exists( 'improcestout_migrate_formation_categories_to_core_categories' ) ) :
	/**
	 * Copies old formation/page category terms to WordPress native categories.
	 *
	 * @return void
	 */
	function improcestout_migrate_formation_categories_to_core_categories() {
		if ( get_option( 'improcestout_formation_categories_migrated' ) || ! taxonomy_exists( 'categorie_formation' ) ) {
			return;
		}

		$old_terms = get_terms(
			array(
				'taxonomy'   => 'categorie_formation',
				'hide_empty' => false,
			)
		);

		if ( is_wp_error( $old_terms ) ) {
			return;
		}

		foreach ( $old_terms as $old_term ) {
			$target_term = term_exists( $old_term->slug, 'category' );

			if ( ! $target_term ) {
				$target_term = wp_insert_term(
					$old_term->name,
					'category',
					array(
						'slug'        => $old_term->slug,
						'description' => $old_term->description,
					)
				);
			}

			if ( is_wp_error( $target_term ) || empty( $target_term['term_id'] ) ) {
				continue;
			}

			$object_ids = get_objects_in_term( $old_term->term_id, 'categorie_formation' );

			if ( is_wp_error( $object_ids ) || ! $object_ids ) {
				continue;
			}

			foreach ( $object_ids as $object_id ) {
				wp_set_object_terms( (int) $object_id, array( (int) $target_term['term_id'] ), 'category', true );
			}
		}

		update_option( 'improcestout_formation_categories_migrated', wp_get_theme()->get( 'Version' ), false );
	}
endif;
add_action( 'admin_init', 'improcestout_migrate_formation_categories_to_core_categories' );

if ( ! function_exists( 'improcestout_flush_formations_rewrite_rules_once' ) ) :
	/**
	 * Flushes rewrite rules once after introducing the formations archive.
	 *
	 * @return void
	 */
	function improcestout_flush_formations_rewrite_rules_once() {
		if ( get_option( 'improcestout_formations_rewrite_flushed' ) ) {
			return;
		}

		flush_rewrite_rules( false );
		update_option( 'improcestout_formations_rewrite_flushed', wp_get_theme()->get( 'Version' ), false );
	}
endif;
add_action( 'admin_init', 'improcestout_flush_formations_rewrite_rules_once' );

if ( ! function_exists( 'improcestout_sanitize_formation_info_values' ) ) :
	/**
	 * Sanitizes formation-specific information values.
	 *
	 * @param mixed $values Raw meta values.
	 * @return array
	 */
	function improcestout_sanitize_formation_info_values( $values ) {
		if ( is_object( $values ) ) {
			$values = get_object_vars( $values );
		}

		$values = is_array( $values ) ? $values : array();
		$items  = improcestout_get_formation_info_items_by_id( true );
		$output = array();

		foreach ( $values as $id => $value ) {
			$id = sanitize_key( $id );

			if ( is_object( $value ) ) {
				$value = get_object_vars( $value );
			}

			if ( ! isset( $items[ $id ] ) || ! is_array( $value ) ) {
				continue;
			}

			$output[ $id ] = array(
				'enabled'     => rest_sanitize_boolean( $value['enabled'] ?? false ),
				'use_default' => rest_sanitize_boolean( $value['use_default'] ?? false ),
				'text'        => sanitize_textarea_field( $value['text'] ?? '' ),
			);
		}

		return $output;
	}
endif;

if ( ! function_exists( 'improcestout_add_formation_admin_menu' ) ) :
	/**
	 * Adds the shared formation info settings page.
	 *
	 * @return void
	 */
	function improcestout_add_formation_admin_menu() {
		add_submenu_page(
			'edit.php?post_type=formation',
			__( 'Rubriques d\'infos', 'improcestout' ),
			__( 'Rubriques d\'infos', 'improcestout' ),
			'edit_posts',
			'improcestout-formation-info',
			'improcestout_render_formation_info_admin_page'
		);
	}
endif;
add_action( 'admin_menu', 'improcestout_add_formation_admin_menu' );

if ( ! function_exists( 'improcestout_enqueue_formation_info_admin_assets' ) ) :
	/**
	 * Loads admin assets for the shared formation info settings page.
	 *
	 * @return void
	 */
	function improcestout_enqueue_formation_info_admin_assets() {
		if ( 'improcestout-formation-info' !== ( $_GET['page'] ?? '' ) || 'formation' !== ( $_GET['post_type'] ?? '' ) ) {
			return;
		}

		$script_path = get_theme_file_path( 'assets/js/formation-info-admin.js' );

		wp_enqueue_script(
			'improcestout-formation-info-admin',
			get_theme_file_uri( 'assets/js/formation-info-admin.js' ),
			array(),
			file_exists( $script_path ) ? filemtime( $script_path ) : wp_get_theme()->get( 'Version' ),
			true
		);

		wp_add_inline_style(
			'common',
			'
			.impro-formation-info-settings .widefat td { vertical-align: top; }
			.impro-formation-info-settings th:nth-child(4),
			.impro-formation-info-settings td:nth-child(4) { width: 130px; }
			.impro-formation-info-settings__drag { width: 38px; text-align: center; }
			.impro-formation-info-settings__handle { display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border: 1px solid #c3c4c7; border-radius: 4px; background: #fff; color: #50575e; cursor: grab; }
			.impro-formation-info-settings__row.is-dragging { opacity: .48; }
			.impro-formation-info-settings__row.is-delete-pending { display: none; }
			.impro-formation-icon-picker { position: relative; display: inline-block; }
			.impro-formation-icon-picker__toggle { display: inline-flex; align-items: center; gap: 7px; min-width: 112px; height: 34px; padding: 0 9px; border: 1px solid #8c8f94; border-radius: 4px; background: #fff; color: #1d2327; cursor: pointer; }
			.impro-formation-icon-picker__toggle svg { width: 17px; height: 17px; flex: 0 0 auto; }
			.impro-formation-icon-picker__toggle-label { overflow: hidden; font-size: 12px; line-height: 1.2; text-overflow: ellipsis; white-space: nowrap; }
			.impro-formation-icon-picker__popover { position: absolute; z-index: 100000; top: calc(100% + 6px); left: 0; display: none; width: min(360px, calc(100vw - 80px)); padding: 10px; border: 1px solid #c3c4c7; border-radius: 6px; background: #fff; box-shadow: 0 10px 30px rgba(0,0,0,.16); }
			.impro-formation-icon-picker.is-open .impro-formation-icon-picker__popover { display: block; }
			.impro-formation-icon-picker__options { display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 6px; max-height: 238px; overflow: auto; padding: 2px; }
			.impro-formation-icon-picker input { position: absolute; opacity: 0; pointer-events: none; }
			.impro-formation-icon-picker__option { position: relative; display: grid; gap: 3px; min-height: 50px; padding: 6px 4px; border: 1px solid #c3c4c7; border-radius: 5px; background: #fff; color: #1d2327; text-align: center; cursor: pointer; place-items: center; }
			.impro-formation-icon-picker__option svg { width: 18px; height: 18px; }
			.impro-formation-icon-picker__label { font-size: 11px; line-height: 1.15; }
			.impro-formation-icon-picker input:checked + .impro-formation-icon-picker__option { border-color: #1d2327; box-shadow: inset 0 0 0 1px #1d2327; }
			.impro-formation-icon-picker input:focus-visible + .impro-formation-icon-picker__option { outline: 2px solid #2271b1; outline-offset: 2px; }
			.impro-formation-icon-picker__close { position: absolute; top: 6px; right: 6px; width: 24px; height: 24px; min-height: 24px; padding: 0; }
			.impro-formation-icon-picker__popover-title { margin: 0 30px 8px 2px; font-size: 12px; font-weight: 600; }
			.impro-formation-info-settings__delete { color: #b32d2e; }
			.impro-formation-info-settings__new-row td { background: #f6f7f7; }
			'
		);
	}
endif;
add_action( 'admin_enqueue_scripts', 'improcestout_enqueue_formation_info_admin_assets' );

if ( ! function_exists( 'improcestout_save_formation_info_admin_page' ) ) :
	/**
	 * Saves the shared formation info settings page.
	 *
	 * @return void
	 */
	function improcestout_save_formation_info_admin_page() {
		if ( empty( $_POST['improcestout_formation_info_settings_nonce'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( sanitize_key( $_POST['improcestout_formation_info_settings_nonce'] ), 'improcestout_save_formation_info_settings' ) || ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		$raw_items = isset( $_POST['formation_info_items'] ) && is_array( $_POST['formation_info_items'] ) ? wp_unslash( $_POST['formation_info_items'] ) : array();
		$items     = array();

		foreach ( $raw_items as $fallback_id => $raw_item ) {
			if ( ! empty( $raw_item['delete'] ) ) {
				continue;
			}

			$raw_item['id']     = sanitize_key( $raw_item['id'] ?? $fallback_id );
			$raw_item['active'] = ! empty( $raw_item['active'] );
			$item               = improcestout_normalize_formation_info_item( $raw_item, $fallback_id );

			if ( ! $item ) {
				continue;
			}

			$base_id = $item['id'];
			$suffix  = 2;

			while ( isset( $items[ $item['id'] ] ) ) {
				$item['id'] = $base_id . '-' . $suffix;
				$suffix++;
			}

			$items[ $item['id'] ] = $item;
		}

		$new_item = isset( $_POST['formation_info_new_item'] ) && is_array( $_POST['formation_info_new_item'] ) ? wp_unslash( $_POST['formation_info_new_item'] ) : array();
		if ( ! empty( $new_item['title'] ) ) {
			$new_item['active'] = ! empty( $new_item['active'] );
			$item               = improcestout_normalize_formation_info_item( $new_item );

			if ( $item ) {
				$base_id = $item['id'];
				$suffix  = 2;

				while ( isset( $items[ $item['id'] ] ) ) {
					$item['id'] = $base_id . '-' . $suffix;
					$suffix++;
				}

				$items[ $item['id'] ] = $item;
			}
		}

		update_option( 'improcestout_formation_info_items', array_values( $items ), false );

		wp_safe_redirect(
			add_query_arg(
				array(
					'post_type' => 'formation',
					'page'      => 'improcestout-formation-info',
					'updated'   => 'true',
				),
				admin_url( 'edit.php' )
			)
		);
		exit;
	}
endif;
add_action( 'admin_init', 'improcestout_save_formation_info_admin_page' );

if ( ! function_exists( 'improcestout_render_formation_icon_picker' ) ) :
	/**
	 * Renders a visual formation icon picker.
	 *
	 * @param string $name Field name.
	 * @param string $selected Selected icon.
	 * @return void
	 */
	function improcestout_render_formation_icon_picker( $name, $selected ) {
		$picker_id = 'impro-formation-icon-picker-' . wp_unique_id();
		$choices   = improcestout_get_formation_icon_choices();
		$selected  = isset( $choices[ $selected ] ) ? $selected : 'check';
		?>
		<div class="impro-formation-icon-picker" data-formation-icon-picker>
			<button type="button" class="impro-formation-icon-picker__toggle" data-formation-icon-toggle aria-expanded="false" aria-controls="<?php echo esc_attr( $picker_id ); ?>">
				<span data-formation-icon-current-svg><?php echo improcestout_get_formation_icon_svg( $selected ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				<span class="impro-formation-icon-picker__toggle-label" data-formation-icon-current-label><?php echo esc_html( $choices[ $selected ] ); ?></span>
			</button>
			<div id="<?php echo esc_attr( $picker_id ); ?>" class="impro-formation-icon-picker__popover" data-formation-icon-popover>
				<button type="button" class="button impro-formation-icon-picker__close" data-formation-icon-close aria-label="<?php esc_attr_e( 'Fermer le choix du picto', 'improcestout' ); ?>"><span aria-hidden="true">&times;</span></button>
				<p class="impro-formation-icon-picker__popover-title"><?php esc_html_e( 'Choisir un picto', 'improcestout' ); ?></p>
				<div class="impro-formation-icon-picker__options" role="radiogroup" aria-label="<?php esc_attr_e( 'Choix du picto', 'improcestout' ); ?>">
					<?php foreach ( $choices as $icon => $label ) : ?>
						<?php $field_id = $picker_id . '-' . $icon; ?>
						<span>
							<input id="<?php echo esc_attr( $field_id ); ?>" type="radio" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $icon ); ?>" <?php checked( $selected, $icon ); ?> data-icon-label="<?php echo esc_attr( $label ); ?>">
							<label class="impro-formation-icon-picker__option" for="<?php echo esc_attr( $field_id ); ?>">
								<?php echo improcestout_get_formation_icon_svg( $icon ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<span class="impro-formation-icon-picker__label"><?php echo esc_html( $label ); ?></span>
							</label>
						</span>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'improcestout_render_formation_info_admin_page' ) ) :
	/**
	 * Renders the shared formation info settings page.
	 *
	 * @return void
	 */
	function improcestout_render_formation_info_admin_page() {
		$items = improcestout_get_formation_info_items( true );
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Rubriques d\'infos des formations', 'improcestout' ); ?></h1>
			<?php if ( ! empty( $_GET['updated'] ) ) : ?>
				<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Rubriques mises a jour.', 'improcestout' ); ?></p></div>
			<?php endif; ?>
			<form method="post">
				<?php wp_nonce_field( 'improcestout_save_formation_info_settings', 'improcestout_formation_info_settings_nonce' ); ?>
				<table class="widefat striped impro-formation-info-settings">
					<thead>
						<tr>
							<th class="impro-formation-info-settings__drag"><span class="screen-reader-text"><?php esc_html_e( 'Reordonner', 'improcestout' ); ?></span></th>
							<th><?php esc_html_e( 'ID', 'improcestout' ); ?></th>
							<th><?php esc_html_e( 'Titre', 'improcestout' ); ?></th>
							<th><?php esc_html_e( 'Picto', 'improcestout' ); ?></th>
							<th><?php esc_html_e( 'Texte par defaut', 'improcestout' ); ?></th>
							<th><?php esc_html_e( 'Actif', 'improcestout' ); ?></th>
							<th><?php esc_html_e( 'Supprimer', 'improcestout' ); ?></th>
						</tr>
					</thead>
					<tbody data-formation-info-sortable>
						<?php foreach ( $items as $item ) : ?>
							<tr class="impro-formation-info-settings__row" draggable="true" data-formation-info-row>
								<td class="impro-formation-info-settings__drag">
									<button type="button" class="impro-formation-info-settings__handle" aria-label="<?php esc_attr_e( 'Deplacer cette rubrique', 'improcestout' ); ?>" title="<?php esc_attr_e( 'Glisser pour reordonner', 'improcestout' ); ?>">
										<span class="dashicons dashicons-menu" aria-hidden="true"></span>
									</button>
								</td>
								<td>
									<code><?php echo esc_html( $item['id'] ); ?></code>
									<input type="hidden" name="formation_info_items[<?php echo esc_attr( $item['id'] ); ?>][id]" value="<?php echo esc_attr( $item['id'] ); ?>">
									<input type="hidden" name="formation_info_items[<?php echo esc_attr( $item['id'] ); ?>][order]" value="<?php echo esc_attr( $item['order'] ); ?>" data-formation-info-order>
									<input type="hidden" name="formation_info_items[<?php echo esc_attr( $item['id'] ); ?>][delete]" value="0" data-formation-info-delete>
								</td>
								<td><input class="regular-text" type="text" name="formation_info_items[<?php echo esc_attr( $item['id'] ); ?>][title]" value="<?php echo esc_attr( $item['title'] ); ?>"></td>
								<td><?php improcestout_render_formation_icon_picker( 'formation_info_items[' . $item['id'] . '][icon]', $item['icon'] ); ?></td>
								<td><textarea class="large-text" rows="2" name="formation_info_items[<?php echo esc_attr( $item['id'] ); ?>][default]"><?php echo esc_textarea( $item['default'] ); ?></textarea></td>
								<td><input type="checkbox" name="formation_info_items[<?php echo esc_attr( $item['id'] ); ?>][active]" value="1" <?php checked( $item['active'] ); ?>></td>
								<td>
									<button type="button" class="button impro-formation-info-settings__delete" data-formation-info-delete-button>
										<span class="dashicons dashicons-trash" aria-hidden="true"></span>
										<span class="screen-reader-text"><?php esc_html_e( 'Supprimer cette rubrique', 'improcestout' ); ?></span>
									</button>
								</td>
							</tr>
						<?php endforeach; ?>
						<tr class="impro-formation-info-settings__new-row">
							<td><input type="hidden" name="formation_info_new_item[order]" value="<?php echo esc_attr( count( $items ) * 10 + 10 ); ?>"></td>
							<td><input type="text" name="formation_info_new_item[id]" placeholder="<?php esc_attr_e( 'nouvelle-rubrique', 'improcestout' ); ?>"></td>
							<td><input class="regular-text" type="text" name="formation_info_new_item[title]" placeholder="<?php esc_attr_e( 'Nouvelle rubrique', 'improcestout' ); ?>"></td>
							<td><?php improcestout_render_formation_icon_picker( 'formation_info_new_item[icon]', 'check' ); ?></td>
							<td><textarea class="large-text" rows="2" name="formation_info_new_item[default]"></textarea></td>
							<td><input type="checkbox" name="formation_info_new_item[active]" value="1" checked></td>
							<td></td>
						</tr>
					</tbody>
				</table>
				<?php submit_button( __( 'Enregistrer les rubriques', 'improcestout' ) ); ?>
			</form>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'improcestout_add_formation_meta_boxes' ) ) :
	/**
	 * Adds editable formation fields.
	 *
	 * @return void
	 */
	function improcestout_add_formation_meta_boxes() {
		add_meta_box(
			'improcestout_formation_intro',
			__( 'Introduction formation', 'improcestout' ),
			'improcestout_render_formation_intro_meta_box',
			'formation',
			'normal',
			'high'
		);

		add_meta_box(
			'improcestout_formation_info',
			__( 'Infos avec pictos', 'improcestout' ),
			'improcestout_render_formation_info_meta_box',
			'formation',
			'normal',
			'high'
		);
	}
endif;

if ( ! function_exists( 'improcestout_render_formation_intro_meta_box' ) ) :
	/**
	 * Renders formation intro fields.
	 *
	 * @param WP_Post $post Current post.
	 * @return void
	 */
	function improcestout_render_formation_intro_meta_box( $post ) {
		$subtitle = get_post_meta( $post->ID, 'improcestout_formation_subtitle', true );
		$hook     = get_post_meta( $post->ID, 'improcestout_formation_hook', true );

		wp_nonce_field( 'improcestout_save_formation_intro', 'improcestout_formation_intro_nonce' );
		?>
		<p>
			<label for="improcestout_formation_subtitle"><strong><?php esc_html_e( 'Sous-titre', 'improcestout' ); ?></strong></label><br>
			<input type="text" id="improcestout_formation_subtitle" name="improcestout_formation_subtitle" value="<?php echo esc_attr( $subtitle ); ?>" class="widefat">
		</p>
		<p>
			<label for="improcestout_formation_hook"><strong><?php esc_html_e( 'Accroche', 'improcestout' ); ?></strong></label><br>
			<textarea id="improcestout_formation_hook" name="improcestout_formation_hook" rows="4" class="widefat"><?php echo esc_textarea( $hook ); ?></textarea>
		</p>
		<?php
	}
endif;

if ( ! function_exists( 'improcestout_render_formation_info_meta_box' ) ) :
	/**
	 * Renders formation-specific information rows.
	 *
	 * @param WP_Post $post Current post.
	 * @return void
	 */
	function improcestout_render_formation_info_meta_box( $post ) {
		$items  = improcestout_get_formation_info_items();
		$values = get_post_meta( $post->ID, 'improcestout_formation_info_values', true );
		$values = is_array( $values ) ? $values : array();

		wp_nonce_field( 'improcestout_save_formation_info_values', 'improcestout_formation_info_nonce' );

		if ( ! $items ) {
			echo '<p>' . esc_html__( 'Aucune rubrique active. Ajoutez-en dans Formations > Rubriques d\'infos.', 'improcestout' ) . '</p>';
			return;
		}
		?>
		<div class="impro-formation-admin-info">
			<?php foreach ( $items as $item ) : ?>
				<?php
				$value       = $values[ $item['id'] ] ?? array();
				$has_value   = is_array( $value );
				$enabled     = $has_value ? rest_sanitize_boolean( $value['enabled'] ?? false ) : true;
				$use_default = $has_value ? rest_sanitize_boolean( $value['use_default'] ?? false ) : false;
				$text        = $has_value ? (string) ( $value['text'] ?? '' ) : '';
				?>
				<div class="impro-formation-admin-info__item" style="border:1px solid #dcdcde;margin:0 0 12px;padding:12px;background:#fff;">
					<p style="margin-top:0;">
						<label>
							<input type="checkbox" name="improcestout_formation_info_values[<?php echo esc_attr( $item['id'] ); ?>][enabled]" value="1" <?php checked( $enabled ); ?>>
							<strong><?php echo esc_html( $item['title'] ); ?></strong>
						</label>
						<code style="margin-left:8px;"><?php echo esc_html( $item['id'] ); ?></code>
					</p>
					<?php if ( $item['default'] ) : ?>
						<p>
							<label>
								<input type="checkbox" name="improcestout_formation_info_values[<?php echo esc_attr( $item['id'] ); ?>][use_default]" value="1" <?php checked( $use_default ); ?>>
								<?php esc_html_e( 'Utiliser le texte par defaut', 'improcestout' ); ?>
							</label><br>
							<em><?php echo esc_html( $item['default'] ); ?></em>
						</p>
					<?php endif; ?>
					<p>
						<label for="improcestout_formation_info_<?php echo esc_attr( $item['id'] ); ?>"><?php esc_html_e( 'Texte specifique', 'improcestout' ); ?></label><br>
						<textarea id="improcestout_formation_info_<?php echo esc_attr( $item['id'] ); ?>" name="improcestout_formation_info_values[<?php echo esc_attr( $item['id'] ); ?>][text]" rows="3" class="widefat"><?php echo esc_textarea( $text ); ?></textarea>
					</p>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'improcestout_save_formation_meta' ) ) :
	/**
	 * Saves formation fields.
	 *
	 * @param int $post_id Current post ID.
	 * @return void
	 */
	function improcestout_save_formation_meta( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( isset( $_POST['improcestout_formation_intro_nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['improcestout_formation_intro_nonce'] ), 'improcestout_save_formation_intro' ) ) {
			$subtitle = isset( $_POST['improcestout_formation_subtitle'] ) ? sanitize_text_field( wp_unslash( $_POST['improcestout_formation_subtitle'] ) ) : '';
			$hook     = isset( $_POST['improcestout_formation_hook'] ) ? sanitize_textarea_field( wp_unslash( $_POST['improcestout_formation_hook'] ) ) : '';

			update_post_meta( $post_id, 'improcestout_formation_subtitle', $subtitle );
			update_post_meta( $post_id, 'improcestout_formation_hook', $hook );
		}

		if ( isset( $_POST['improcestout_formation_info_nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['improcestout_formation_info_nonce'] ), 'improcestout_save_formation_info_values' ) ) {
			$raw_values = isset( $_POST['improcestout_formation_info_values'] ) && is_array( $_POST['improcestout_formation_info_values'] ) ? wp_unslash( $_POST['improcestout_formation_info_values'] ) : array();
			$items      = improcestout_get_formation_info_items();
			$values     = get_post_meta( $post_id, 'improcestout_formation_info_values', true );
			$values     = is_array( $values ) ? $values : array();

			foreach ( $items as $item ) {
				$id  = $item['id'];
				$row = isset( $raw_values[ $id ] ) && is_array( $raw_values[ $id ] ) ? $raw_values[ $id ] : array();

				$values[ $id ] = array(
					'enabled'     => ! empty( $row['enabled'] ),
					'use_default' => ! empty( $row['use_default'] ),
					'text'        => sanitize_textarea_field( $row['text'] ?? '' ),
				);
			}

			update_post_meta( $post_id, 'improcestout_formation_info_values', $values );
		}
	}
endif;
add_action( 'save_post_formation', 'improcestout_save_formation_meta' );

if ( ! function_exists( 'improcestout_get_formation_info_rows' ) ) :
	/**
	 * Returns display-ready formation info rows.
	 *
	 * @param int $post_id Formation post ID.
	 * @return array
	 */
	function improcestout_get_formation_info_rows( $post_id ) {
		$items  = improcestout_get_formation_info_items();
		$values = get_post_meta( $post_id, 'improcestout_formation_info_values', true );
		$values = is_array( $values ) ? $values : array();
		$rows   = array();

		foreach ( $items as $item ) {
			$value   = isset( $values[ $item['id'] ] ) && is_array( $values[ $item['id'] ] ) ? $values[ $item['id'] ] : array();
			$enabled = $value ? rest_sanitize_boolean( $value['enabled'] ?? false ) : false;

			if ( ! $enabled ) {
				continue;
			}

			$text = ! empty( $value['use_default'] ) ? $item['default'] : (string) ( $value['text'] ?? '' );
			$text = trim( $text );

			if ( '' === $text ) {
				continue;
			}

			$rows[] = array(
				'id'    => $item['id'],
				'title' => $item['title'],
				'icon'  => $item['icon'],
				'text'  => $text,
			);
		}

		return $rows;
	}
endif;

if ( ! function_exists( 'improcestout_render_formation_info_list' ) ) :
	/**
	 * Renders formation information rows.
	 *
	 * @param array $attributes Block attributes.
	 * @param bool  $use_block_wrapper Whether to add block wrapper attributes.
	 * @return string
	 */
	function improcestout_render_formation_info_list( $attributes = array(), $use_block_wrapper = false ) {
		$post_id = get_the_ID();

		if ( ( defined( 'REST_REQUEST' ) && REST_REQUEST ) && ! empty( $attributes['previewPostId'] ) ) {
			$post_id = absint( $attributes['previewPostId'] );
		}

		if ( ! $post_id ) {
			return '';
		}

		$rows = improcestout_get_formation_info_rows( $post_id );

		if ( ! $rows ) {
			return $use_block_wrapper ? '<div ' . get_block_wrapper_attributes( array( 'class' => 'impro-formation-info impro-formation-info--empty' ) ) . '></div>' : '';
		}

		ob_start();
		?>
		<section <?php echo $use_block_wrapper ? get_block_wrapper_attributes( array( 'class' => 'impro-formation-info' ) ) : 'class="impro-formation-info"'; ?>>
			<?php foreach ( $rows as $row ) : ?>
				<article class="impro-formation-info__row">
					<div class="impro-formation-info__icon"><?php echo improcestout_get_formation_icon_svg( $row['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
					<div class="impro-formation-info__content">
						<h2><?php echo esc_html( $row['title'] ); ?></h2>
						<p><?php echo nl2br( esc_html( $row['text'] ) ); ?></p>
					</div>
				</article>
			<?php endforeach; ?>
		</section>
		<?php

		return ob_get_clean();
	}
endif;

if ( ! function_exists( 'improcestout_render_formation_hero' ) ) :
	/**
	 * Renders the formation hero block.
	 *
	 * @param array $attributes Block attributes.
	 * @return string
	 */
	function improcestout_render_formation_hero( $attributes = array() ) {
		$post_id = get_the_ID();

		if ( ( defined( 'REST_REQUEST' ) && REST_REQUEST ) && ! empty( $attributes['previewPostId'] ) ) {
			$post_id = absint( $attributes['previewPostId'] );
		}

		if ( ! $post_id ) {
			return '';
		}

		$subtitle = get_post_meta( $post_id, 'improcestout_formation_subtitle', true );
		$hook     = get_post_meta( $post_id, 'improcestout_formation_hook', true );
		$image    = get_the_post_thumbnail( $post_id, 'large', array( 'class' => 'impro-formation-hero__image' ) );

		ob_start();
		?>
		<section <?php echo get_block_wrapper_attributes( array( 'class' => 'impro-formation-hero alignfull' ) ); ?>>
			<div class="impro-formation-hero__inner">
				<div class="impro-formation-hero__copy">
					<?php if ( $subtitle ) : ?>
						<p class="impro-formation-hero__subtitle"><?php echo esc_html( $subtitle ); ?></p>
					<?php endif; ?>
					<h1><?php echo esc_html( get_the_title( $post_id ) ); ?></h1>
					<?php if ( $hook ) : ?>
						<p class="impro-formation-hero__hook"><?php echo nl2br( esc_html( $hook ) ); ?></p>
					<?php endif; ?>
				</div>
				<?php if ( $image ) : ?>
					<figure class="impro-formation-hero__media"><?php echo $image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></figure>
				<?php endif; ?>
			</div>
		</section>
		<?php

		return ob_get_clean();
	}
endif;

if ( ! function_exists( 'improcestout_normalize_formations_list_attributes' ) ) :
	/**
	 * Normalizes public settings for the formations listing.
	 *
	 * @param array $attributes Listing attributes.
	 * @return array
	 */
	function improcestout_normalize_formations_list_attributes( $attributes = array() ) {
		$attributes = wp_parse_args(
			$attributes,
			array(
				'categorySlug'     => '',
				'categories'       => array(),
				'inheritPageTerms' => false,
				'columns'          => 3,
				'showImage'        => true,
				'showSubtitle'     => true,
				'showHook'         => true,
				'showCategories'   => true,
				'emptyText'        => __( 'Les formations apparaitront ici des qu\'elles seront publiees.', 'improcestout' ),
			)
		);

		$categories = array();

		if ( '' !== trim( (string) $attributes['categorySlug'] ) ) {
			$categories[] = sanitize_title( $attributes['categorySlug'] );
		} elseif ( ! empty( $attributes['categories'] ) ) {
			$categories = array_map( 'sanitize_title', wp_parse_list( $attributes['categories'] ) );
		}

		return array(
			'categories'       => array_values( array_filter( array_unique( $categories ) ) ),
			'inheritPageTerms' => rest_sanitize_boolean( $attributes['inheritPageTerms'] ),
			'columns'          => min( 4, max( 1, absint( $attributes['columns'] ) ) ),
			'showImage'        => rest_sanitize_boolean( $attributes['showImage'] ),
			'showSubtitle'     => rest_sanitize_boolean( $attributes['showSubtitle'] ),
			'showHook'         => rest_sanitize_boolean( $attributes['showHook'] ),
			'showCategories'   => rest_sanitize_boolean( $attributes['showCategories'] ),
			'emptyText'        => sanitize_text_field( $attributes['emptyText'] ),
		);
	}
endif;

if ( ! function_exists( 'improcestout_render_formations_list' ) ) :
	/**
	 * Renders the formations listing block.
	 *
	 * @param array $attributes Listing attributes.
	 * @param bool  $use_block_wrapper Whether to add block wrapper attributes.
	 * @return string
	 */
	function improcestout_render_formations_list( $attributes = array(), $use_block_wrapper = false ) {
		$settings = improcestout_normalize_formations_list_attributes( $attributes );

		$query_args = array(
			'post_type'      => 'formation',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
		);

		if ( $settings['categories'] ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'field'    => 'slug',
					'terms'    => $settings['categories'],
				),
			);
		} elseif ( $settings['inheritPageTerms'] && is_page() ) {
			$terms = get_the_terms( get_the_ID(), 'category' );

			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				$query_args['tax_query'] = array(
					array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => wp_list_pluck( $terms, 'term_id' ),
					),
				);
			}
		}

		$formations = new WP_Query( $query_args );
		$classes    = 'impro-formations-list impro-formations-list--columns-' . $settings['columns'];

		ob_start();
		?>
		<section <?php echo $use_block_wrapper ? get_block_wrapper_attributes( array( 'class' => $classes ) ) : 'class="' . esc_attr( $classes ) . '"'; ?>>
			<?php if ( $formations->have_posts() ) : ?>
				<div class="impro-formations-list__grid">
					<?php while ( $formations->have_posts() ) : ?>
						<?php
						$formations->the_post();
						$post_id  = get_the_ID();
						$subtitle = get_post_meta( $post_id, 'improcestout_formation_subtitle', true );
						$hook     = get_post_meta( $post_id, 'improcestout_formation_hook', true );
						?>
						<article class="impro-formation-card">
							<?php if ( $settings['showImage'] && has_post_thumbnail() ) : ?>
								<a class="impro-formation-card__image" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium_large' ); ?></a>
							<?php endif; ?>
							<div class="impro-formation-card__content">
								<?php if ( $settings['showCategories'] ) : ?>
									<?php
									$term_list = get_the_term_list( $post_id, 'category', '<div class="impro-formation-card__terms">', '', '</div>' );
									if ( $term_list && ! is_wp_error( $term_list ) ) {
										echo $term_list; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									}
									?>
								<?php endif; ?>
								<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<?php if ( $settings['showSubtitle'] && $subtitle ) : ?>
									<p class="impro-formation-card__subtitle"><?php echo esc_html( $subtitle ); ?></p>
								<?php endif; ?>
								<?php if ( $settings['showHook'] && $hook ) : ?>
									<p><?php echo esc_html( $hook ); ?></p>
								<?php endif; ?>
							</div>
						</article>
					<?php endwhile; ?>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php else : ?>
				<p class="impro-formations-list__empty"><?php echo esc_html( $settings['emptyText'] ); ?></p>
			<?php endif; ?>
		</section>
		<?php

		return ob_get_clean();
	}
endif;

if ( ! function_exists( 'improcestout_render_formations_shortcode' ) ) :
	/**
	 * Renders the formations listing shortcode.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	function improcestout_render_formations_shortcode( $atts = array() ) {
		$atts = shortcode_atts(
			array(
				'category'        => '',
				'categories'      => '',
				'columns'         => 3,
				'show_image'      => true,
				'show_subtitle'   => true,
				'show_hook'       => true,
				'show_categories' => true,
				'empty_text'      => __( 'Les formations apparaitront ici des qu\'elles seront publiees.', 'improcestout' ),
			),
			$atts,
			'improcestout_formations'
		);

		return improcestout_render_formations_list(
			array(
				'categorySlug'     => $atts['category'],
				'categories'       => $atts['categories'],
				'inheritPageTerms' => '' === trim( (string) $atts['category'] ) && '' === trim( (string) $atts['categories'] ),
				'columns'          => $atts['columns'],
				'showImage'        => $atts['show_image'],
				'showSubtitle'     => $atts['show_subtitle'],
				'showHook'         => $atts['show_hook'],
				'showCategories'   => $atts['show_categories'],
				'emptyText'        => $atts['empty_text'],
			)
		);
	}
endif;
add_shortcode( 'improcestout_formations', 'improcestout_render_formations_shortcode' );

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
			$paragraph = isset( $item['paragraph'] ) ? trim( sanitize_textarea_field( $item['paragraph'] ) ) : '';
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

			$paragraph_html = $paragraph ? '<span class="impro-ray-paragraph">' . nl2br( esc_html( $paragraph ) ) . '</span>' : '';

			$output .= sprintf(
				'<a class="impro-ray-card impro-ray-card--dynamic impro-ray-card--item-%1$d" style="%2$s" href="%3$s"><span class="impro-ray-image">%4$s</span><span class="impro-ray-copy"><strong>%5$s</strong><span class="impro-ray-details">%6$s</span>%7$s</span></a>',
				(int) $index + 1,
				esc_attr( $card_css ),
				esc_url( $url ),
				$image,
				esc_html( $title ),
				$detail_html,
				$paragraph_html
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

if ( ! function_exists( 'improcestout_register_intervenants_block' ) ) :
	/**
	 * Registers the configurable intervenants listing block.
	 *
	 * @return void
	 */
	function improcestout_register_intervenants_block() {
		$script_path = get_theme_file_path( 'assets/js/intervenants-block.js' );

		wp_register_script(
			'improcestout-intervenants-block',
			get_theme_file_uri( 'assets/js/intervenants-block.js' ),
			array( 'wp-blocks', 'wp-block-editor', 'wp-components', 'wp-data', 'wp-element', 'wp-i18n', 'wp-server-side-render' ),
			file_exists( $script_path ) ? filemtime( $script_path ) : wp_get_theme()->get( 'Version' ),
			true
		);

		register_block_type(
			'improcestout/intervenants-list',
			array(
				'api_version'     => 3,
				'title'           => __( 'Intervenants', 'improcestout' ),
				'description'     => __( 'Liste configurable des intervenants.', 'improcestout' ),
				'category'        => 'widgets',
				'icon'            => 'groups',
				'editor_script'   => 'improcestout-intervenants-block',
				'render_callback' => static function ( $attributes ) {
					return improcestout_render_intervenants( $attributes, true );
				},
				'attributes'      => array(
					'categorySlug'     => array(
						'type'    => 'string',
						'default' => '',
					),
					'inheritPageTerms' => array(
						'type'    => 'boolean',
						'default' => false,
					),
					'columns'          => array(
						'type'    => 'number',
						'default' => 3,
					),
					'showIntro'        => array(
						'type'    => 'boolean',
						'default' => true,
					),
					'introText'        => array(
						'type'    => 'string',
						'default' => __( 'La troupe en mouvement', 'improcestout' ),
					),
					'showPhoto'        => array(
						'type'    => 'boolean',
						'default' => true,
					),
					'showExcerpt'      => array(
						'type'    => 'boolean',
						'default' => true,
					),
					'showCategories'   => array(
						'type'    => 'boolean',
						'default' => true,
					),
					'showEmail'        => array(
						'type'    => 'boolean',
						'default' => true,
					),
					'emptyText'        => array(
						'type'    => 'string',
						'default' => __( 'Les intervenants apparaitront ici des qu\'ils seront publies.', 'improcestout' ),
					),
				),
				'supports'        => array(
					'align' => array( 'wide', 'full' ),
					'html'  => false,
				),
			)
		);
	}
endif;
add_action( 'init', 'improcestout_register_intervenants_block' );

if ( ! function_exists( 'improcestout_register_formations_blocks' ) ) :
	/**
	 * Registers formation blocks.
	 *
	 * @return void
	 */
	function improcestout_register_formations_blocks() {
		$script_path = get_theme_file_path( 'assets/js/formations-blocks.js' );

		wp_register_script(
			'improcestout-formations-blocks',
			get_theme_file_uri( 'assets/js/formations-blocks.js' ),
			array( 'wp-blocks', 'wp-block-editor', 'wp-components', 'wp-data', 'wp-element', 'wp-i18n', 'wp-server-side-render' ),
			file_exists( $script_path ) ? filemtime( $script_path ) : wp_get_theme()->get( 'Version' ),
			true
		);

		register_block_type(
			'improcestout/formation-hero',
			array(
				'api_version'     => 3,
				'title'           => __( 'Hero formation', 'improcestout' ),
				'description'     => __( 'Titre, sous-titre et accroche de la formation.', 'improcestout' ),
				'category'        => 'theme',
				'icon'            => 'welcome-learn-more',
				'editor_script'   => 'improcestout-formations-blocks',
				'render_callback' => 'improcestout_render_formation_hero',
				'attributes'      => array(
					'previewPostId' => array(
						'type'    => 'number',
						'default' => 0,
					),
				),
				'supports'        => array(
					'align' => array( 'wide', 'full' ),
					'html'  => false,
				),
			)
		);

		register_block_type(
			'improcestout/formation-info-list',
			array(
				'api_version'     => 3,
				'title'           => __( 'Infos formation', 'improcestout' ),
				'description'     => __( 'Liste des informations partagees avec pictos.', 'improcestout' ),
				'category'        => 'widgets',
				'icon'            => 'list-view',
				'editor_script'   => 'improcestout-formations-blocks',
				'render_callback' => static function ( $attributes ) {
					return improcestout_render_formation_info_list( $attributes, true );
				},
				'attributes'      => array(
					'previewPostId' => array(
						'type'    => 'number',
						'default' => 0,
					),
				),
				'supports'        => array(
					'align' => array( 'wide', 'full' ),
					'html'  => false,
				),
			)
		);

		register_block_type(
			'improcestout/formations-list',
			array(
				'api_version'     => 3,
				'title'           => __( 'Formations', 'improcestout' ),
				'description'     => __( 'Liste configurable des formations.', 'improcestout' ),
				'category'        => 'widgets',
				'icon'            => 'welcome-learn-more',
				'editor_script'   => 'improcestout-formations-blocks',
				'render_callback' => static function ( $attributes ) {
					return improcestout_render_formations_list( $attributes, true );
				},
				'attributes'      => array(
					'categorySlug'     => array(
						'type'    => 'string',
						'default' => '',
					),
					'inheritPageTerms' => array(
						'type'    => 'boolean',
						'default' => false,
					),
					'columns'          => array(
						'type'    => 'number',
						'default' => 3,
					),
					'showImage'        => array(
						'type'    => 'boolean',
						'default' => true,
					),
					'showSubtitle'     => array(
						'type'    => 'boolean',
						'default' => true,
					),
					'showHook'         => array(
						'type'    => 'boolean',
						'default' => true,
					),
					'showCategories'   => array(
						'type'    => 'boolean',
						'default' => true,
					),
					'emptyText'        => array(
						'type'    => 'string',
						'default' => __( 'Les formations apparaitront ici des qu\'elles seront publiees.', 'improcestout' ),
					),
				),
				'supports'        => array(
					'align' => array( 'wide', 'full' ),
					'html'  => false,
				),
			)
		);
	}
endif;
add_action( 'init', 'improcestout_register_formations_blocks' );

if ( ! function_exists( 'improcestout_enqueue_formation_editor_sidebar' ) ) :
	/**
	 * Loads the formation fields in the Gutenberg document sidebar.
	 *
	 * @return void
	 */
	function improcestout_enqueue_formation_editor_sidebar() {
		$screen = get_current_screen();

		if ( ! $screen || 'formation' !== $screen->post_type ) {
			return;
		}

		$script_path = get_theme_file_path( 'assets/js/formation-editor-sidebar.js' );
		$style_path  = get_theme_file_path( 'assets/css/formation-editor-sidebar.css' );
		$info_items  = array_map(
			static function ( $item ) {
				$item['iconSvg'] = improcestout_get_formation_icon_svg( $item['icon'] );
				return $item;
			},
			improcestout_get_formation_info_items()
		);

		wp_enqueue_style(
			'improcestout-formation-editor-sidebar',
			get_theme_file_uri( 'assets/css/formation-editor-sidebar.css' ),
			array(),
			file_exists( $style_path ) ? filemtime( $style_path ) : wp_get_theme()->get( 'Version' )
		);

		wp_enqueue_script(
			'improcestout-formation-editor-sidebar',
			get_theme_file_uri( 'assets/js/formation-editor-sidebar.js' ),
			array( 'wp-components', 'wp-data', 'wp-edit-post', 'wp-element', 'wp-i18n', 'wp-plugins' ),
			file_exists( $script_path ) ? filemtime( $script_path ) : wp_get_theme()->get( 'Version' ),
			true
		);

		wp_localize_script(
			'improcestout-formation-editor-sidebar',
			'improcestoutFormationEditor',
			array(
				'infoItems' => $info_items,
			)
		);
	}
endif;
add_action( 'enqueue_block_editor_assets', 'improcestout_enqueue_formation_editor_sidebar' );

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
