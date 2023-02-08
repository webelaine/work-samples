import { ToggleControl } from '@wordpress/components';
import { useEntityProp } from '@wordpress/core-data';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { __ } from '@wordpress/i18n';
import { registerPlugin } from '@wordpress/plugins';

const SpeciesMetaBox = () => {
	const postType = wp.data.select( 'core/editor' ).getCurrentPostType();
	const [ meta, setMeta ] = useEntityProp( 'postType', postType, 'meta' );
	const { hide_table: hideFromTable } = meta;

	return (
		<PluginDocumentSettingPanel name="hide" title={ __( 'Exclude from regulations table' ) }>
			<ToggleControl
				label={ __( 'Hide' ) }
				checked={ hideFromTable }
				onChange={ ( value ) =>
					setMeta( {
						...meta,
						hide_table: value,
					} )
				}
			/>
		</PluginDocumentSettingPanel>
	);
};

registerPlugin( 'species-meta-box', {
	render: SpeciesMetaBox,
	icon: 'admin-post',
} );
