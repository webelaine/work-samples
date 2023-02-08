const { registerBlockStyle, registerBlockType } = wp.blocks;
const { AlignmentToolbar, BlockControls, InnerBlocks } = wp.blockEditor;
const { Fragment } = wp.element;

// Block Style Variations like Core Button block: select in the Inspector Panel and it adds an extra class to the wrapper ul.
registerBlockStyle('stmu/bordered-box-item', {
    name: 'bordered',
    label: 'Bordered',
    isDefault: true
});
registerBlockStyle('stmu/bordered-box-item', {
    name: 'gold',
    label: 'Gold'
});
registerBlockStyle('stmu/bordered-box-item', {
    name: 'blue',
    label: 'Blue'
});
registerBlockType('stmu/bordered-boxes', {
    title: 'Bordered Boxes',
    icon: 'grid-view',
    category: 'common',
    edit: props => {
        const { attributes: { alignment }, className, setAttributes } = props;
		return(
            <ul className='bordered-box'>
                <InnerBlocks
                    allowedBlocks={ ['stmu/bordered-box-item'] }
                    template={[
                        ['stmu/bordered-box-item', {} ],
                    ]}
                />
            </ul>
        );
    },
    save: props => {
        const { attributes: { alignment }, className } = props;
        return (
            <ul className='bordered-box'>
                <InnerBlocks.Content />
            </ul>
        );
    }
});

registerBlockType('stmu/bordered-box-item', {
    parent: ['stmu/bordered-boxes'], // only allow inside a Bordered Boxes block
    title: 'Bordered Box Item',
    icon: 'grid-view',
    category: 'layout',
    attributes: {
        alignment: {
            type: 'string',
            default: 'left'
        },
    },
    edit: props => {
        const { attributes: { alignment }, className, setAttributes } = props;
        let alignClass = className;
        if( alignment == 'center' || alignment == 'right') {
            alignClass = `${ className } text-${ alignment }`;
        }
        return (
            <Fragment>
                <BlockControls>
                    <AlignmentToolbar
                        value={ alignment }
                        onChange={ ( alignment ) => { setAttributes( { alignment } ) } }
                    />
                </BlockControls>
                <li className={ alignClass }>
                    <InnerBlocks />
                </li>
            </Fragment>
        );
    },
    save: props => {
        const { attributes: { alignment }, className } = props;
        let alignClass = className;
        if( alignment == 'center' || alignment == 'right') {
            alignClass = `${ className } text-${ alignment }`;
        }
        return (
            <li className={ alignClass }>
                <InnerBlocks.Content />
            </li>
        );
    }
});