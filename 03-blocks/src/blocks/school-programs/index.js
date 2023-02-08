const { registerBlockType } = wp.blocks;
import Block from './block';

registerBlockType( 'stmu/school-programs', {
    title: 'School Programs',
    icon: 'image-filter',
    category: 'widgets',
    attributes: {
        editMode: {
            type: 'boolean',
            default: true
        },
        levels: {
            type: 'string',
            default: 'all'
        },
    },
	edit( props ) {
		return <Block { ...props } />;
	},
    save: props => {
        return null;
    }
} );