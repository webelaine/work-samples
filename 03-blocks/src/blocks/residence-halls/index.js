const { registerBlockType } = wp.blocks;
const { serverSideRender: ServerSideRender } = wp;

registerBlockType('stmu/residence-halls', {
    title: 'Residence Halls',     
    category: 'widgets',
    icon: 'admin-home',
	edit( props ) {
		return <ServerSideRender block='stmu/residence-halls' />;
	},
    save() {
        // Rendering in PHP
        return null;
    },
} );