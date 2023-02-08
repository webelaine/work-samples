const { registerBlockType } = wp.blocks;
 
registerBlockType( 'stmu/program-directors', {
    parent: ['stmu/program-info'], // only allow inside a Program Info block
    title: 'Program Director',
    icon: 'editor-ul',
    category: 'widgets',
    edit: props => {
        return(
            <div className="programDetails">
                <h2>Contact</h2>
                <ul><li>Update at the bottom of screen under "Program Director"</li></ul>
            </div>
        );
    },
    save: props => {
        return null;
    }
} );