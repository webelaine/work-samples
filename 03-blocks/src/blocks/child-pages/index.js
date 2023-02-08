const { registerBlockType } = wp.blocks;
const { serverSideRender: ServerSideRender } = wp;

registerBlockType('stmu/child-pages', {
    title: 'Child Pages',     
    category: 'widgets',
    supports: {'multiple': false}, // only 1 per page
    icon: 'yes-alt',
	edit( props ) {
		return <ServerSideRender block='stmu/child-pages' />;
	},
    save() {
        // Rendering in PHP
        return null;
    },
} );