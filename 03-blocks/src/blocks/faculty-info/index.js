const { registerBlockType } = wp.blocks;
const { InnerBlocks, RichText } = wp.blockEditor;
const { serverSideRender: ServerSideRender } = wp;

registerBlockType('stmu/faculty-info', {
    parent: ['core/column'], // only allow inside a Column block
    title: 'Faculty Info', 
    category: 'widgets',
    supports: {'multiple': false}, // only 1 per page
    icon: 'info',
	edit( props ) {
        const { setAttributes } = props;
        return (
            <InnerBlocks
                allowedBlocks={ ['stmu/faculty-contact'], ['stmu/faculty-departments'], ['stmu/faculty-programs'] }
                template={[
                    ['stmu/faculty-contact', {}],
                    ['stmu/faculty-departments', {}],
                    ['stmu/faculty-programs', {}]
                ]}
                templateLock='all'
            />
        );
	},
    save( props ) {
        return (
            <InnerBlocks.Content />
        );
    },
});