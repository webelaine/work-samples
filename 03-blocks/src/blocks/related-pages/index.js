const { registerBlockType } = wp.blocks;
 
registerBlockType( 'stmu/related-pages', {
    parent: ['core/column'], // only allow inside a Core Column block
    title: 'Related Pages',
    icon: 'editor-ul',
    category: 'widgets',
    edit: props => {
        return(
            <div>
                <h2>Related Pages</h2>
                <ul><li>Update at the bottom of screen under "Related Pages"</li></ul>
            </div>
        );
    },
    save: props => {
        return null;
    }
} );