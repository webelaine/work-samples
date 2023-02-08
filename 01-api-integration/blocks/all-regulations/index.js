/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import {
	Disabled,
	PanelBody,
	RadioControl,
	ToggleControl,
} from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import metadata from './block.json';

// Register the block.
registerBlockType( metadata, {
	edit: ( props ) => {
		const {
			attributes: { details, type },
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
						<ToggleControl
							label={ __( 'Show regulation details' ) }
							checked={ details }
							onChange={ ( value ) =>
								setAttributes( { details: value } )
							}
						/>
					</PanelBody>
				</InspectorControls>
				<Disabled>
					<ServerSideRender
						block={ metadata.name }
						attributes={ props.attributes }
					/>
				</Disabled>
			</div>
		);
	},
} );
