( function ( blocks, blockEditor, components, data, element, i18n ) {
	var el = element.createElement;
	var __ = i18n.__;
	var InspectorControls = blockEditor.InspectorControls;
	var MediaUpload = blockEditor.MediaUpload;
	var MediaUploadCheck = blockEditor.MediaUploadCheck;
	var useBlockProps = blockEditor.useBlockProps;
	var Button = components.Button;
	var PanelBody = components.PanelBody;
	var RangeControl = components.RangeControl;
	var SelectControl = components.SelectControl;
	var TextControl = components.TextControl;
	var useSelect = data.useSelect;

	var DEFAULT_ITEMS = [
		{ pageId: 17, slug: 'evenementiel', title: 'Evenementiel', details: [ 'Restitution improvisee', 'Animation', 'Sur mesure' ], imageId: 11, angle: -135, radius: 43, cardRotation: -3 },
		{ pageId: 23, slug: 'theatre-forum', title: 'Theatre forum', details: [ 'Situation jouee', 'Debat', 'Issues a tester' ], imageId: 12, angle: -45, radius: 43, cardRotation: 3 },
		{ pageId: 15, slug: 'publics-fragilises', title: 'Publics fragilises', details: [ 'Atelier d\'impro', 'Cadre adapte' ], imageId: 13, angle: 0, radius: 43, cardRotation: -1 },
		{ pageId: 24, slug: 'pros-du-social-medico-social', title: 'Pros du social', details: [ 'Mises en situation', 'Cohesion', 'Forum' ], imageId: 10, angle: 42, radius: 45, cardRotation: 2 },
		{ pageId: 16, slug: 'entreprises', title: 'Entreprises', details: [ 'Prise de parole', 'Posture pro', 'Cohesion' ], imageId: 13, angle: 138, radius: 45, cardRotation: -2 },
		{ pageId: 14, slug: 'just-do-impro', title: 'Just do impro', details: [ 'Stages', 'Ateliers', 'Spectacles' ], imageId: 12, angle: 180, radius: 43, cardRotation: 1 },
	];
	var MIN_RADIUS = 20;
	var MAX_RADIUS = 70;

	function cloneItems( items ) {
		return ( items && items.length ? items : DEFAULT_ITEMS ).map( function ( item ) {
			return Object.assign( {}, item, {
				details: Array.isArray( item.details ) ? item.details.slice() : String( item.details || '' ).split( /\r?\n|\|/ ),
			} );
		} );
	}

	function getPageTitle( pages, pageId ) {
		var page = pages.find( function ( candidate ) {
			return Number( candidate.id ) === Number( pageId );
		} );

		if ( ! page || ! page.title ) {
			return '';
		}

		return String( page.title.rendered || '' ).replace( /<[^>]+>/g, '' );
	}

	function getPageById( pages, pageId ) {
		return pages.find( function ( page ) {
			return Number( page.id ) === Number( pageId );
		} );
	}

	function getPosition( item ) {
		var angle = Number( item.angle || 0 );
		var radius = Math.max( MIN_RADIUS, Math.min( MAX_RADIUS, Number( item.radius || 43 ) ) );
		var radians = angle * Math.PI / 180;

		return {
			x: Math.max( -8, Math.min( 108, 50 + Math.cos( radians ) * radius ) ),
			y: Math.max( -8, Math.min( 108, 50 + Math.sin( radians ) * radius ) ),
		};
	}

	function Edit( props ) {
		var attributes = props.attributes;
		var setAttributes = props.setAttributes;
		var items = cloneItems( attributes.items );
		var blockProps = useBlockProps( {
			className: 'impro-sun-block-editor',
		} );
		var pages = useSelect( function ( select ) {
			return select( 'core' ).getEntityRecords( 'postType', 'page', {
				per_page: -1,
				orderby: 'title',
				order: 'asc',
			} ) || [];
		}, [] );
		var mediaById = useSelect( function ( select ) {
			var core = select( 'core' );
			var media = {};

			items.forEach( function ( item ) {
				var imageId = Number( item.imageId || 0 );

				if ( imageId ) {
					media[ imageId ] = core.getMedia( imageId );
				}
			} );

			return media;
		}, [ items.map( function ( item ) { return item.imageId || 0; } ).join( ',' ) ] );
		var pageOptions = [
			{ label: __( 'Choisir une page', 'improcestout' ), value: 0 },
		].concat( pages.map( function ( page ) {
			return {
				label: getPageTitle( pages, page.id ) || __( 'Page sans titre', 'improcestout' ),
				value: page.id,
			};
		} ) );
		var globalRadius = items.length ? Math.round( items.reduce( function ( total, item ) {
			return total + Number( item.radius || 43 );
		}, 0 ) / items.length ) : 43;

		function getImageUrl( item ) {
			var imageId = Number( item.imageId || 0 );
			var media = imageId ? mediaById[ imageId ] : null;

			if ( item.imageUrl ) {
				return item.imageUrl;
			}

			if ( media && media.media_details && media.media_details.sizes && media.media_details.sizes.thumbnail ) {
				return media.media_details.sizes.thumbnail.source_url;
			}

			return media && media.source_url ? media.source_url : '';
		}

		function updateItem( index, changes ) {
			var next = cloneItems( items );
			next[ index ] = Object.assign( {}, next[ index ], changes );
			setAttributes( { items: next } );
		}

		function updateDetail( itemIndex, detailIndex, value ) {
			var details = Array.isArray( items[ itemIndex ].details ) ? items[ itemIndex ].details.slice() : [];
			details[ detailIndex ] = value;
			updateItem( itemIndex, { details: details } );
		}

		function addDetail( itemIndex ) {
			var details = Array.isArray( items[ itemIndex ].details ) ? items[ itemIndex ].details.slice() : [];
			details.push( __( 'Nouvel item', 'improcestout' ) );
			updateItem( itemIndex, { details: details } );
		}

		function removeDetail( itemIndex, detailIndex ) {
			var details = Array.isArray( items[ itemIndex ].details ) ? items[ itemIndex ].details.slice() : [];
			updateItem( itemIndex, {
				details: details.filter( function ( detail, index ) {
					return index !== detailIndex;
				} ),
			} );
		}

		function removeItem( index ) {
			setAttributes( {
				items: items.filter( function ( item, itemIndex ) {
					return itemIndex !== index;
				} ),
			} );
		}

		function updateGlobalRadius( value ) {
			setAttributes( {
				items: items.map( function ( item ) {
					return Object.assign( {}, item, { radius: value } );
				} ),
			} );
		}

		function addItem() {
			var angle = items.length ? Math.min( 180, -135 + items.length * 45 ) : 0;
			setAttributes( {
				items: items.concat( [
					{ pageId: 0, title: __( 'Nouvelle page', 'improcestout' ), details: [ __( 'Texte court', 'improcestout' ) ], imageId: 0, imageUrl: '', angle: angle, radius: globalRadius, cardRotation: 0 },
				] ),
			} );
		}

		function distributeItems() {
			var count = Math.max( 1, items.length );
			var start = -145;
			var end = 180;
			var step = count > 1 ? ( end - start ) / ( count - 1 ) : 0;

			setAttributes( {
				items: items.map( function ( item, index ) {
					return Object.assign( {}, item, {
						angle: Math.round( start + step * index ),
						radius: index === 0 || index === count - 1 ? 43 : 45,
					} );
				} ),
			} );
		}

		return el(
			element.Fragment,
			null,
			el(
				InspectorControls,
				null,
				el(
					PanelBody,
					{ title: __( 'Elements du soleil', 'improcestout' ), initialOpen: true },
					el( RangeControl, {
						label: __( 'Distance globale cartes/logo', 'improcestout' ),
						help: __( 'Regle la longueur des rayons et rapproche ou eloigne toutes les cartes du logo.', 'improcestout' ),
						value: globalRadius,
						min: MIN_RADIUS,
						max: MAX_RADIUS,
						onChange: updateGlobalRadius,
					} ),
					el(
						'div',
						{ className: 'impro-editor-actions' },
						el( Button, { variant: 'primary', onClick: addItem }, __( 'Ajouter une page', 'improcestout' ) ),
						el( Button, { variant: 'secondary', onClick: distributeItems }, __( 'Repartir automatiquement', 'improcestout' ) )
					),
					items.map( function ( item, index ) {
						var itemDetails = Array.isArray( item.details ) ? item.details : String( item.details || '' ).split( /\r?\n|\|/ );
						var imageUrl = getImageUrl( item );

						return el(
							PanelBody,
							{
								key: index,
								title: ( item.title || getPageTitle( pages, item.pageId ) || __( 'Element', 'improcestout' ) ) + ' #' + ( index + 1 ),
								initialOpen: false,
							},
							el( SelectControl, {
								label: __( 'Page liee', 'improcestout' ),
								value: Number( item.pageId || 0 ),
								options: pageOptions,
								onChange: function ( value ) {
									var page = getPageById( pages, value );
									updateItem( index, {
										pageId: Number( value ),
										slug: page ? page.slug : '',
									} );
								},
							} ),
							el( TextControl, {
								label: __( 'Titre affiche', 'improcestout' ),
								value: item.title || '',
								help: __( 'Laisser vide pour utiliser le titre de la page.', 'improcestout' ),
								onChange: function ( value ) {
									updateItem( index, { title: value } );
								},
							} ),
							el(
								'div',
								{ className: 'impro-editor-image-control' },
								el( 'p', { className: 'impro-editor-label' }, __( 'Image du rond', 'improcestout' ) ),
								imageUrl ? el( 'img', { className: 'impro-editor-image-preview', src: imageUrl, alt: '' } ) : null,
								el(
									'div',
									{ className: 'impro-editor-image-actions' },
									el(
										MediaUploadCheck,
										null,
										el( MediaUpload, {
											allowedTypes: [ 'image' ],
											value: item.imageId || 0,
											onSelect: function ( media ) {
												updateItem( index, {
													imageId: media.id,
													imageUrl: media.sizes && media.sizes.thumbnail ? media.sizes.thumbnail.url : media.url,
												} );
											},
											render: function ( renderProps ) {
												return el(
													Button,
													{ variant: 'secondary', onClick: renderProps.open },
													item.imageId ? __( 'Changer l image', 'improcestout' ) : __( 'Choisir une image', 'improcestout' )
												);
											},
										} )
									),
									item.imageId ? el(
										Button,
										{
											variant: 'secondary',
											isDestructive: true,
											className: 'impro-editor-trash-button',
											label: __( 'Retirer l image', 'improcestout' ),
											onClick: function () {
												updateItem( index, { imageId: 0, imageUrl: '' } );
											},
										},
										el( 'span', { className: 'dashicons dashicons-trash', 'aria-hidden': true } )
									) : null
								)
							),
							el(
								'div',
								{ className: 'impro-editor-detail-list' },
								el( 'p', { className: 'impro-editor-label' }, __( 'Petite liste dans la carte', 'improcestout' ) ),
								itemDetails.map( function ( detail, detailIndex ) {
									return el(
										'div',
										{ className: 'impro-editor-detail-row', key: detailIndex },
										el( TextControl, {
											label: __( 'Item', 'improcestout' ) + ' ' + ( detailIndex + 1 ),
											hideLabelFromVision: true,
											value: detail,
											onChange: function ( value ) {
												updateDetail( index, detailIndex, value );
											},
										} ),
										el(
											Button,
											{
												variant: 'secondary',
												isDestructive: true,
												className: 'impro-editor-trash-button',
												label: __( 'Retirer cet item', 'improcestout' ),
												onClick: function () {
													removeDetail( index, detailIndex );
												},
											},
											el( 'span', { className: 'dashicons dashicons-trash', 'aria-hidden': true } )
										)
									);
								} ),
								el(
									Button,
									{
										variant: 'secondary',
										className: 'impro-editor-add-detail',
										label: __( 'Ajouter un item de liste', 'improcestout' ),
										onClick: function () { addDetail( index ); },
									},
									'+'
								)
							),
							el( RangeControl, {
								label: __( 'Angle du rayon', 'improcestout' ),
								value: Number( item.angle || 0 ),
								min: -180,
								max: 180,
								onChange: function ( value ) {
									updateItem( index, { angle: value } );
								},
							} ),
							el( RangeControl, {
								label: __( 'Distance au logo', 'improcestout' ),
								value: Number( item.radius || 43 ),
								min: MIN_RADIUS,
								max: MAX_RADIUS,
								onChange: function ( value ) {
									updateItem( index, { radius: value } );
								},
							} ),
							el( RangeControl, {
								label: __( 'Inclinaison de la carte', 'improcestout' ),
								value: Number( item.cardRotation || 0 ),
								min: -8,
								max: 8,
								onChange: function ( value ) {
									updateItem( index, { cardRotation: value } );
									},
								} ),
							el(
								Button,
								{ variant: 'link', isDestructive: true, onClick: function () { removeItem( index ); } },
								__( 'Supprimer cet element', 'improcestout' )
							)
						);
					} )
				)
			),
			el(
				'div',
				blockProps,
				el(
					'div',
					{ className: 'impro-sun-stage impro-sun-stage--dynamic impro-sun-stage--editor' },
					el(
						'div',
						{ className: 'impro-sun-rays', 'aria-hidden': true },
						items.map( function ( item, index ) {
								return el( 'span', {
								key: index,
								className: 'impro-sun-ray',
								style: {
									'--ray-angle': Number( item.angle || 0 ) + 'deg',
									'--ray-length': Math.max( MIN_RADIUS, Math.min( MAX_RADIUS, Number( item.radius || 43 ) ) ) + '%',
								},
							} );
						} )
					),
					el(
						'div',
						{ className: 'impro-sun-logo' },
						el( 'span', { 'aria-label': 'Impro c est tout' }, el( 'img', { src: window.improcestoutSunNavigationBlock.logoUrl, alt: '' } ) )
					),
					el(
						'div',
						{ className: 'impro-ray-nav', 'aria-label': __( 'Navigation principale', 'improcestout' ) },
						items.map( function ( item, index ) {
						var position = getPosition( item );
						var details = Array.isArray( item.details ) ? item.details : String( item.details || '' ).split( /\r?\n|\|/ );
						var imageUrl = getImageUrl( item );

							return el(
								'div',
								{
									key: index,
									className: 'impro-ray-card impro-ray-card--dynamic impro-ray-card--item-' + ( index + 1 ),
									style: {
										'--card-x': position.x + '%',
										'--card-y': position.y + '%',
										'--card-rotation': Number( item.cardRotation || 0 ) + 'deg',
									},
								},
								el( 'span', { className: 'impro-ray-image' }, imageUrl ? el( 'img', { src: imageUrl, alt: '' } ) : null ),
								el(
									'span',
									{ className: 'impro-ray-copy' },
									el( 'strong', null, item.title || getPageTitle( pages, item.pageId ) || __( 'Page', 'improcestout' ) ),
									el(
										'span',
										{ className: 'impro-ray-details' },
										details.filter( Boolean ).map( function ( detail, detailIndex ) {
											return el( 'span', { key: detailIndex }, detail );
										} )
									)
								)
							);
						} )
					)
				)
			)
		);
	}

	blocks.registerBlockType( 'improcestout/sun-navigation', {
		title: __( 'Navigation soleil', 'improcestout' ),
		description: __( 'Navigation radiale configurable pour la page d accueil.', 'improcestout' ),
		icon: 'star-filled',
		category: 'design',
		attributes: {
			items: {
				type: 'array',
				default: DEFAULT_ITEMS,
			},
		},
		edit: Edit,
		save: function () {
			return null;
		},
	} );
} )( window.wp.blocks, window.wp.blockEditor, window.wp.components, window.wp.data, window.wp.element, window.wp.i18n );
