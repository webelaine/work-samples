const { registerBlockType } = wp.blocks;
import Block from './block';

registerBlockType('stmu/finder', {
    title: 'Finder',
    category: 'widgets',
    icon: 'search',
    attributes: {
        'editMode': {
            type: 'boolean',
            default: true
        },
        'postType': {
            type: 'string',
            default: 'hall'
        }
    },
	edit( props ) {
		return <Block { ...props } />;
	},
    save() {
        // Rendering in PHP
        return null;
    },
} );