const { registerBlockStyle, registerBlockType } = wp.blocks;
const { RichText } = wp.blockEditor;
const { SelectControl } = wp.components;
import dropdownOptions from '../font-awesome-icons'; // All Font Awesome 4.7 icons (except Google+) as dropdown options
const allDropdownOptions = dropdownOptions.concat({ label: 'No Icon', value: ' ' }); // Also allow no icon - the very first item in the dropdown.

// Block Style Variations like Core Button block: select in the Inspector Panel and it adds an extra class to the wrapper div.
registerBlockStyle('stmu/stat', {
    name: 'plain',
    label: 'Plain',
});
registerBlockStyle('stmu/stat', {
    name: 'bordered',
    label: 'Bordered',
    isDefault: true
});
registerBlockStyle('stmu/stat', {
    name: 'gold',
    label: 'Gold'
});
registerBlockStyle('stmu/stat', {
    name: 'blue',
    label: 'Blue'
});
registerBlockType('stmu/stat', {
    title: 'Stat',
    icon: 'star-filled',
    category: 'widgets',
    supports: {'anchor': true},
    attributes: {
        icon: {
            type: 'string',
            default: ' ',
            source: 'attribute',
            selector: 'i',
            attribute: 'class'
        },
        largeText: {
            type: 'string',
            source: 'text',
            selector: '.large-stat',
            default: '100'
        },
        smallText: {
            type: 'string',
            source: 'text',
            selector: '.small-stat',
            default: 'Percent'
        }
    },
    edit: props => {
        const { attributes: { icon, largeText, smallText }, className, setAttributes } = props;
        return (
            <div className={ className }>
                <SelectControl
                    label="Optional Icon"
                    hideLabelFromVision="true"
                    className="iconSelecter"
                    value={ icon }
                    onChange={ ( icon ) => { setAttributes( { icon } ) } }
                    options={ allDropdownOptions }
                />
                <div className="iconPreview">
                    <i className={icon}></i>
                </div>
                <RichText
                    tagName='div'
                    className='large-stat'
                    value={ largeText }
                    onChange={ ( largeText ) => { setAttributes( { largeText } ) } }
                    placeholder='Large Text'
                    allowedFormats={ [] } // This removes bold, italic, strikethrough, and link options
                />
                <RichText
                    tagName='div'
                    className='small-stat'
                    value={ smallText }
                    onChange={ ( smallText ) => { setAttributes( { smallText } ) } }
                    placeholder='Small Text'
                    allowedFormats={ [] } // This removes bold, italic, strikethrough, and link options
                />
            </div>
        )
    },
    save: props => {
        const { attributes: { icon, largeText, smallText }, className } = props;
        let iconOutput = '';
        if(icon != ' ') {
            iconOutput = <i className={ icon }></i>;
        }
        return (
            <div className={ className }>
                { iconOutput }
                <RichText.Content tagName="div" className="large-stat" value={ largeText } />
                <RichText.Content tagName="div" className="small-stat" value={ smallText } />
            </div>
        );
    }
});