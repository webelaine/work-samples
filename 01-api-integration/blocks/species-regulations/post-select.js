// WordPress dependencies.
import { SelectControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { decodeEntities } from '@wordpress/html-entities';
import { __ } from '@wordpress/i18n';

/**
 * Retrieve published `fish_species` and list
 * them as options in a `SelectControl` component.
 *
 * @param {Object} props Component properties.
 * @return {WPElement} SelectControl component.
 */
const PostSelect = ( props ) => {
	const { label, onChange, postType, value } = props;

	const { options } = useSelect( ( select ) => {
		const postOptions = [
			{
				label: __( 'Select', 'happyprime' ),
				value: 0,
			},
		];
		const posts = select( 'core' ).getEntityRecords( 'postType', postType, {
			per_page: -1,
			orderby: 'title',
			order: 'asc',
		} );

		if ( posts ) {
			posts.forEach( ( post ) => {
				postOptions.push( {
					label: decodeEntities( post.title.rendered ),
					value: post.id,
				} );
			} );
		}

		return {
			options: postOptions,
		};
	}, [] );

	return (
		<SelectControl
			label={ label }
			onChange={ onChange }
			options={ options }
			value={ value }
		/>
	);
};

export default PostSelect;
