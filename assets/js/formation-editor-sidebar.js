( function ( plugins, editPost, element, components, data, i18n ) {
	if ( ! plugins || ! editPost || ! element || ! components || ! data ) {
		return;
	}

	var registerPlugin = plugins.registerPlugin;
	var PluginDocumentSettingPanel = editPost.PluginDocumentSettingPanel;
	var el = element.createElement;
	var Fragment = element.Fragment;
	var __ = i18n.__;
	var BaseControl = components.BaseControl;
	var CheckboxControl = components.CheckboxControl;
	var TextareaControl = components.TextareaControl;
	var TextControl = components.TextControl;
	var useDispatch = data.useDispatch;
	var useSelect = data.useSelect;
	var settings = window.improcestoutFormationEditor || {};
	var infoItems = Array.isArray( settings.infoItems ) ? settings.infoItems : [];

	if ( ! registerPlugin || ! PluginDocumentSettingPanel ) {
		return;
	}

	function getInfoRow( infoValues, id ) {
		var row = infoValues && infoValues[ id ] && 'object' === typeof infoValues[ id ] ? infoValues[ id ] : {};

		return {
			enabled: Object.prototype.hasOwnProperty.call( row, 'enabled' ) ? !! row.enabled : false,
			use_default: !! row.use_default,
			text: row.text || '',
		};
	}

	function FormationInfoIcon( props ) {
		return el( 'span', {
			className: 'impro-formation-editor-info__icon',
			dangerouslySetInnerHTML: {
				__html: props.svg || '',
			},
		} );
	}

	function FormationEditorSidebar() {
		var postType = useSelect( function ( select ) {
			var editor = select( 'core/editor' );

			if ( editor.getCurrentPostType ) {
				return editor.getCurrentPostType();
			}

			return editor.getEditedPostAttribute( 'type' );
		}, [] );
		var meta = useSelect( function ( select ) {
			return select( 'core/editor' ).getEditedPostAttribute( 'meta' ) || {};
		}, [] );
		var editorDispatch = useDispatch( 'core/editor' );
		var infoValues = meta.improcestout_formation_info_values && 'object' === typeof meta.improcestout_formation_info_values ? meta.improcestout_formation_info_values : {};

		if ( 'formation' !== postType ) {
			return null;
		}

		function updateMeta( key, value ) {
			editorDispatch.editPost( {
				meta: Object.assign( {}, meta, {
					[ key ]: value,
				} ),
			} );
		}

		function updateInfoRow( id, changes ) {
			var currentRow = getInfoRow( infoValues, id );
			var nextValues = Object.assign( {}, infoValues, {
				[ id ]: Object.assign( {}, currentRow, changes ),
			} );

			updateMeta( 'improcestout_formation_info_values', nextValues );
		}

		return el(
			Fragment,
			null,
			el(
				PluginDocumentSettingPanel,
				{
					name: 'improcestout-formation-intro',
					title: __( 'Introduction formation', 'improcestout' ),
					className: 'improcestout-formation-intro-panel',
					initialOpen: true,
				},
				el( TextControl, {
					label: __( 'Sous-titre', 'improcestout' ),
					value: meta.improcestout_formation_subtitle || '',
					onChange: function ( value ) {
						updateMeta( 'improcestout_formation_subtitle', value );
					},
				} ),
				el( TextareaControl, {
					label: __( 'Accroche', 'improcestout' ),
					value: meta.improcestout_formation_hook || '',
					rows: 4,
					onChange: function ( value ) {
						updateMeta( 'improcestout_formation_hook', value );
					},
				} )
			),
			el(
				PluginDocumentSettingPanel,
				{
					name: 'improcestout-formation-info',
					title: __( 'Infos avec pictos', 'improcestout' ),
					className: 'improcestout-formation-info-panel',
					initialOpen: true,
				},
				infoItems.length
					? infoItems.map( function ( item ) {
						var row = getInfoRow( infoValues, item.id );

						return el(
							'div',
							{
								key: item.id,
								className: row.enabled ? 'impro-formation-editor-info is-enabled' : 'impro-formation-editor-info',
							},
							el(
								'label',
								{
									className: 'impro-formation-editor-info__header',
								},
								el( 'input', {
									type: 'checkbox',
									checked: row.enabled,
									onChange: function ( event ) {
										updateInfoRow( item.id, { enabled: event.target.checked } );
									},
								} ),
								el( FormationInfoIcon, {
									svg: item.iconSvg,
								} ),
								el( 'span', {
									className: 'impro-formation-editor-info__title',
								}, item.title )
							),
							item.default
								? el( CheckboxControl, {
									label: __( 'Utiliser le texte par defaut', 'improcestout' ),
									help: item.default,
									className: 'impro-formation-editor-info__default',
									checked: row.use_default,
									disabled: ! row.enabled,
									onChange: function ( checked ) {
										updateInfoRow( item.id, { use_default: checked } );
									},
								} )
								: null,
							el( TextareaControl, {
								label: __( 'Texte', 'improcestout' ),
								hideLabelFromVision: true,
								value: row.text,
								rows: 3,
								className: 'impro-formation-editor-info__textarea',
								placeholder: row.enabled ? __( 'Texte a afficher sur la page formation', 'improcestout' ) : __( 'Activez cette rubrique pour la remplir', 'improcestout' ),
								disabled: ! row.enabled || row.use_default,
								onChange: function ( value ) {
									updateInfoRow( item.id, { text: value } );
								},
							} )
						);
					} )
					: el(
						BaseControl,
						{
							help: __( 'Aucune rubrique active. Ajoutez-en dans Formations > Rubriques d infos.', 'improcestout' ),
						},
						null
					)
			)
		);
	}

	registerPlugin( 'improcestout-formation-editor-sidebar', {
		render: FormationEditorSidebar,
	} );
} )( window.wp.plugins, window.wp.editPost, window.wp.element, window.wp.components, window.wp.data, window.wp.i18n );
