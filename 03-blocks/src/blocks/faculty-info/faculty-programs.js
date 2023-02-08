const { registerBlockType } = wp.blocks;
 
registerBlockType( 'stmu/faculty-programs', {
    parent: ['stmu/faculty-info'], // only allow inside a StMU Faculty Info block
    title: 'Faculty Programs',
    icon: 'editor-ul',
    category: 'widgets',
    edit: props => {
        return(
            <div>
                <h2><i class="fa fa-user" aria-hidden="true"></i> Programs</h2>
                <ul><li>Update at the bottom of screen under "Program Director"</li></ul>
            </div>
        );
    },
    save: props => {
        return null;
    }
} );