const { registerBlockType } = wp.blocks;
 
registerBlockType( 'stmu/program-departments', {
    parent: ['stmu/program-info'], // only allow inside a Program Info block
    title: 'Program Department',
    icon: 'editor-ul',
    category: 'widgets',
    edit: props => {
        return(
            <div className="programDetails">
                <h2>Department</h2>
                <ul><li>Update at the bottom of screen under "Program Department"</li></ul>
            </div>
        );
    },
    save: props => {
        return null;
    }
} );