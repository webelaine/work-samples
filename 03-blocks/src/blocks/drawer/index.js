const { registerBlockType } = wp.blocks;
const { InnerBlocks } = wp.blockEditor;
import Block from './block';

registerBlockType('stmu/drawer', {
    title: 'Drawer',
    icon: 'sort',
    category: 'common',
    supports: {'anchor': true},
    attributes: {
        editMode: {
            type: 'boolean',
            default: true
        },
        isOpen: {
            type: 'boolean',
            default: false
        },
        summary: {
            type: 'string',
            default: '',
            source: 'text',
            selector: 'details summary'
        }
    },
    edit: props => {
		return <Block { ...props } />;
    },
    save: props => {
        const { attributes: { isOpen, summary }, className, setAttributes } = props;
        return (
            <details open={ isOpen }>
                <InnerBlocks.Content />
                <summary>{ summary }</summary>
            </details>
        );
    }
});