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

	function Edit( props ) {
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
						label: __( 'Afficher le surtitre', 'improcestout' ),
						checked: attributes.showIntro !== false,
						onChange: function ( value ) {
							setAttributes( { showIntro: value } );
						},
					} ),
					attributes.showIntro !== false ? el( TextControl, {
						label: __( 'Texte du surtitre', 'improcestout' ),
						value: attributes.introText || '',
						onChange: function ( value ) {
							setAttributes( { introText: value } );
						},
					} ) : null,
					el( ToggleControl, {
						label: __( 'Afficher les photos', 'improcestout' ),
						checked: attributes.showPhoto !== false,
						onChange: function ( value ) {
							setAttributes( { showPhoto: value } );
						},
					} ),
					el( ToggleControl, {
						label: __( 'Afficher les extraits', 'improcestout' ),
						checked: attributes.showExcerpt !== false,
						onChange: function ( value ) {
							setAttributes( { showExcerpt: value } );
						},
					} ),
					el( ToggleControl, {
						label: __( 'Afficher les categories', 'improcestout' ),
						checked: attributes.showCategories !== false,
						onChange: function ( value ) {
							setAttributes( { showCategories: value } );
						},
					} ),
					el( ToggleControl, {
						label: __( 'Afficher les emails', 'improcestout' ),
						checked: attributes.showEmail !== false,
						onChange: function ( value ) {
							setAttributes( { showEmail: value } );
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
				block: 'improcestout/intervenants-list',
				attributes: attributes,
			} ) : el( 'p', null, __( 'Apercu indisponible.', 'improcestout' ) )
		);
	}

	blocks.registerBlockType( 'improcestout/intervenants-list', {
		title: __( 'Intervenants', 'improcestout' ),
		description: __( 'Liste configurable des intervenants.', 'improcestout' ),
		icon: 'groups',
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
			showIntro: {
				type: 'boolean',
				default: true,
			},
			introText: {
				type: 'string',
				default: __( 'La troupe en mouvement', 'improcestout' ),
			},
			showPhoto: {
				type: 'boolean',
				default: true,
			},
			showExcerpt: {
				type: 'boolean',
				default: true,
			},
			showCategories: {
				type: 'boolean',
				default: true,
			},
			showEmail: {
				type: 'boolean',
				default: true,
			},
			emptyText: {
				type: 'string',
				default: __( 'Les intervenants apparaitront ici des qu ils seront publies.', 'improcestout' ),
			},
		},
		edit: Edit,
		save: function () {
			return null;
		},
	} );
} )( window.wp.blocks, window.wp.blockEditor, window.wp.components, window.wp.data, window.wp.element, window.wp.i18n, window.wp.serverSideRender );
