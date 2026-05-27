( function ( blocks, blockEditor, components, data, element, i18n, serverSideRender ) {
	var el = element.createElement;
	var __ = i18n.__;
	var InspectorControls = blockEditor.InspectorControls;
	var useBlockProps = blockEditor.useBlockProps;
	var PanelBody = components.PanelBody;
	var RangeControl = components.RangeControl;
	var SelectControl = components.SelectControl;
	var TextControl = components.TextControl;
	var ToggleControl = components.ToggleControl;
	var useSelect = data.useSelect;
	var ServerSideRender = serverSideRender && serverSideRender.default ? serverSideRender.default : serverSideRender;

	function getTermName( term ) {
		return String( ( term && term.name ) || '' ).replace( /<[^>]+>/g, '' );
	}

	function useCurrentPostId() {
		return useSelect( function ( select ) {
			var editor = select( 'core/editor' );
			return editor && editor.getCurrentPostId ? editor.getCurrentPostId() : 0;
		}, [] );
	}

	function DynamicPreview( props ) {
		var blockProps = useBlockProps();
		var postId = useCurrentPostId();
		var attributes = Object.assign( {}, props.attributes, {
			previewPostId: postId || 0,
		} );

		return el(
			'div',
			blockProps,
			ServerSideRender ? el( ServerSideRender, {
				block: props.name,
				attributes: attributes,
			} ) : el( 'p', null, __( 'Apercu indisponible.', 'improcestout' ) )
		);
	}

	function FormationsListEdit( props ) {
		var attributes = props.attributes;
		var setAttributes = props.setAttributes;
		var blockProps = useBlockProps();
		var terms = useSelect( function ( select ) {
			return select( 'core' ).getEntityRecords( 'taxonomy', 'category', {
				per_page: -1,
				orderby: 'name',
				order: 'asc',
			} ) || [];
		}, [] );
		var categoryOptions = [
			{ label: __( 'Toutes les categories', 'improcestout' ), value: '' },
		].concat( terms.map( function ( term ) {
			return {
				label: getTermName( term ),
				value: term.slug,
			};
		} ) );

		return el(
			'div',
			blockProps,
			el(
				InspectorControls,
				null,
				el(
					PanelBody,
					{ title: __( 'Contenu', 'improcestout' ), initialOpen: true },
					el( SelectControl, {
						label: __( 'Categorie', 'improcestout' ),
						value: attributes.categorySlug || '',
						options: categoryOptions,
						onChange: function ( value ) {
							setAttributes( { categorySlug: value } );
						},
					} ),
					el( ToggleControl, {
						label: __( 'Filtrer avec les categories de la page', 'improcestout' ),
						checked: !! attributes.inheritPageTerms,
						help: attributes.categorySlug ? __( 'Ignore tant qu une categorie est selectionnee.', 'improcestout' ) : undefined,
						onChange: function ( value ) {
							setAttributes( { inheritPageTerms: value } );
						},
					} ),
					el( RangeControl, {
						label: __( 'Colonnes', 'improcestout' ),
						value: attributes.columns || 3,
						min: 1,
						max: 4,
						onChange: function ( value ) {
							setAttributes( { columns: value } );
						},
					} )
				),
				el(
					PanelBody,
					{ title: __( 'Options', 'improcestout' ), initialOpen: false },
					el( ToggleControl, {
						label: __( 'Afficher les images', 'improcestout' ),
						checked: attributes.showImage !== false,
						onChange: function ( value ) {
							setAttributes( { showImage: value } );
						},
					} ),
					el( ToggleControl, {
						label: __( 'Afficher les sous-titres', 'improcestout' ),
						checked: attributes.showSubtitle !== false,
						onChange: function ( value ) {
							setAttributes( { showSubtitle: value } );
						},
					} ),
					el( ToggleControl, {
						label: __( 'Afficher les accroches', 'improcestout' ),
						checked: attributes.showHook !== false,
						onChange: function ( value ) {
							setAttributes( { showHook: value } );
						},
					} ),
					el( ToggleControl, {
						label: __( 'Afficher les categories', 'improcestout' ),
						checked: attributes.showCategories !== false,
						onChange: function ( value ) {
							setAttributes( { showCategories: value } );
						},
					} ),
					el( TextControl, {
						label: __( 'Texte si aucun resultat', 'improcestout' ),
						value: attributes.emptyText || '',
						onChange: function ( value ) {
							setAttributes( { emptyText: value } );
						},
					} )
				)
			),
			ServerSideRender ? el( ServerSideRender, {
				block: 'improcestout/formations-list',
				attributes: attributes,
			} ) : el( 'p', null, __( 'Apercu indisponible.', 'improcestout' ) )
		);
	}

	blocks.registerBlockType( 'improcestout/formation-hero', {
		title: __( 'Hero formation', 'improcestout' ),
		description: __( 'Titre, sous-titre et accroche de la formation.', 'improcestout' ),
		icon: 'welcome-learn-more',
		category: 'theme',
		attributes: {
			previewPostId: {
				type: 'number',
				default: 0,
			},
		},
		edit: function ( props ) {
			return el( DynamicPreview, {
				name: 'improcestout/formation-hero',
				attributes: props.attributes,
			} );
		},
		save: function () {
			return null;
		},
	} );

	blocks.registerBlockType( 'improcestout/formation-info-list', {
		title: __( 'Infos formation', 'improcestout' ),
		description: __( 'Liste des informations partagees avec pictos.', 'improcestout' ),
		icon: 'list-view',
		category: 'widgets',
		attributes: {
			previewPostId: {
				type: 'number',
				default: 0,
			},
		},
		edit: function ( props ) {
			return el( DynamicPreview, {
				name: 'improcestout/formation-info-list',
				attributes: props.attributes,
			} );
		},
		save: function () {
			return null;
		},
	} );

	blocks.registerBlockType( 'improcestout/formations-list', {
		title: __( 'Formations', 'improcestout' ),
		description: __( 'Liste configurable des formations.', 'improcestout' ),
		icon: 'welcome-learn-more',
		category: 'widgets',
		attributes: {
			categorySlug: {
				type: 'string',
				default: '',
			},
			inheritPageTerms: {
				type: 'boolean',
				default: false,
			},
			columns: {
				type: 'number',
				default: 3,
			},
			showImage: {
				type: 'boolean',
				default: true,
			},
			showSubtitle: {
				type: 'boolean',
				default: true,
			},
			showHook: {
				type: 'boolean',
				default: true,
			},
			showCategories: {
				type: 'boolean',
				default: true,
			},
			emptyText: {
				type: 'string',
				default: __( 'Les formations apparaitront ici des qu elles seront publiees.', 'improcestout' ),
			},
		},
		edit: FormationsListEdit,
		save: function () {
			return null;
		},
	} );
} )( window.wp.blocks, window.wp.blockEditor, window.wp.components, window.wp.data, window.wp.element, window.wp.i18n, window.wp.serverSideRender );
