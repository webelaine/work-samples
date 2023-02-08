const { registerBlockType } = wp.blocks;
const { Disabled } = wp.components;
const { serverSideRender: ServerSideRender } = wp;

registerBlockType( 'stmu/school-departments', {
    title: 'School Departments',
    icon: 'networking',
    category: 'widgets',
    edit: props => {
        return(
            <Disabled>
                <ServerSideRender block='stmu/school-departments' />
            </Disabled>
        );
    },
    save: props => {
        return null;
    }
} );