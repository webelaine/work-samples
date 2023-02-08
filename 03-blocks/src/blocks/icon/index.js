const { registerBlockType } = wp.blocks;
const { SelectControl } = wp.components;
import dropdownOptions from '../font-awesome-icons'; // All Font Awesome 4.7 icons (except Google+) as dropdown options

registerBlockType('stmu/icon', {
    title: 'Icon',
    icon: 'star-empty',
    category: 'widgets',
    attributes: {
        icon: {
            type: 'string',
            default: 'fa fa-flag',
            source: 'attribute',
            selector: 'i',
            attribute: 'class'
        }
    },
    edit: props => {
        const { attributes: { icon }, className, setAttributes } = props;
        return (
            <div className={ className }>
                <SelectControl
                    label="Icon"
                    hideLabelFromVision="true"
                    className="iconSelecter"
                    value={ icon }
                    onChange={ ( icon ) => { setAttributes( { icon } ) } }
                    options={ dropdownOptions }
                />
                <div className="iconPreview">
                    <i className={ icon }></i>
                </div>
            </div>
        )
    },
    save: props => {
        const { attributes: { icon }, className } = props;
        return (
            <i className={ icon }></i>
        );
    }
});