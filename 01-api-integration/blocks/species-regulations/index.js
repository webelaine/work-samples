/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, RadioControl } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import metadata from './block.json';
import PostSelect from './post-select';

// Register the block.
registerBlockType( metadata, {
	edit: ( props ) => {
		const {
			attributes: { species, type },
			setAttributes,
		} = props;

		return (
			<div { ...useBlockProps() }>
				<InspectorControls>
					<PanelBody>
						<RadioControl
							label={ __( 'Type' ) }
							selected={ type }
							options={ [
								{
									label: __( 'Recreational' ),
									value: 'recreational',
								},
								{
									label: __( 'Commercial' ),
									value: 'commercial',
								},
							] }
							onChange={ ( value ) =>
								setAttributes( { type: value } )
							}
						/>
						<PostSelect
							label={ __( 'Species', 'happyprime' ) }
							onChange={ ( value ) =>
								setAttributes( {
									species: parseInt( value ),
								} )
							}
							postType="fish_species"
							value={ species }
						/>
					</PanelBody>
				</InspectorControls>
				<ServerSideRender
					block={ metadata.name }
					attributes={ props.attributes }
				/>
			</div>
		);
	},
} );
