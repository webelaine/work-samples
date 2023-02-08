const { registerBlockType } = wp.blocks;
import Block from './block';

registerBlockType('stmu/post-connector', {
    title: 'Post Connector',
    icon: 'grid-view',
    category: 'widgets',
    supports: {'anchor': true},
    attributes: {
        category: {
            type: 'string',
            default: 'all'
        },
        display: {
            type: 'string',
            default: 'list'
        },
        editMode: {
            type: 'boolean',
            default: true
        },
        number: {
            type: 'string',
            default: '5'
        },
        school: {
            type: 'string',
            default: 'all'
        },
        tag: {
            type: 'string',
            default: 'all'
        }
    },
    edit: props => {
        return <Block { ...props } />;
    },
    save: props => {
        return null;
    }
} );