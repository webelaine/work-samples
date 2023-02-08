const { registerBlockType } = wp.blocks;
 
registerBlockType( 'stmu/faculty-departments', {
    parent: ['stmu/faculty-info'], // only allow inside a StMU Faculty Info block
    title: 'Faculty Departments',
    icon: 'editor-ul',
    category: 'widgets',
    edit: props => {
        return(
            <div>
                <h2><i class="fa fa-user" aria-hidden="true"></i> Departments</h2>
                <ul><li>Update at the bottom of screen under "Relationship - Faculty / Department"</li></ul>
            </div>
        );
    },
    save: props => {
        return null;
    }
} );