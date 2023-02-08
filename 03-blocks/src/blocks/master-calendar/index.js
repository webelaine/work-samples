const { registerBlockType } = wp.blocks;
import Block from './block';

registerBlockType('stmu/master-calendar', {
    title: 'Master Calendar',
    category: 'widgets',
    icon: 'calendar-alt',
    attributes: {
        editMode: {
            type: 'boolean',
            default: true
        },
        calendarId: {
            type: 'string',
            default: '5'
        },
        level: {
            type: 'string',
            default: 'h2'
        },
        numberEvents: {
            type: 'string',
            default: '6'
        },
        rssUrl: {
            type: 'string'
        }
    },
	edit( props ) {
		return <Block { ...props } />;
	},
    save( props ) {
        // Rendering in PHP
        return null;
    },
} );