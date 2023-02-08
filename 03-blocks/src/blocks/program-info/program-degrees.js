const { registerBlockType } = wp.blocks;
 
registerBlockType( 'stmu/program-degrees', {
    parent: ['stmu/program-info'], // only allow inside a Program Info block
    title: 'Program Degree',
    icon: 'editor-ul',
    category: 'widgets',
    edit: props => {
        return(
            <div className="programDetails">
                <h2>Degree</h2>
                <ul><li>Update in the sidebar when all blocks are deselected</li></ul>
            </div>
        );
    },
    save: props => {
        return null;
    }
} );