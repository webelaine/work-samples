const { registerBlockType } = wp.blocks;
const { Disabled } = wp.components;
const { serverSideRender: ServerSideRender } = wp;

registerBlockType( 'stmu/school-faculty', {
    title: 'School Faculty',
    icon: 'groups',
    category: 'widgets',
    edit: props => {
        return(
            <Disabled>
                <ServerSideRender block='stmu/school-faculty' />
            </Disabled>
        );
    },
    save: props => {
        return null;
    }
} );