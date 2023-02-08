const { registerBlockType } = wp.blocks;
const { AlignmentToolbar, BlockControls, InnerBlocks, InspectorControls, RichText } = wp.blockEditor;
const { PanelBody, RadioControl, SelectControl } = wp.components;
import dropdownOptions from '../font-awesome-icons'; // All Font Awesome 4.7 icons (except Google+) as dropdown options

registerBlockType("stmu/icon-heading", {
    title: 'Icon Heading',
    icon: 'lightbulb',
    category: 'common',
    supports: {'anchor': true},
    attributes: {
        alignment: {
            type: 'string',
            default: 'left'
        },
        icon: {
            type: 'string',
            default: 'fa fa-flag',
            source: 'attribute',
            selector: 'i',
            attribute: 'class'
        },
        heading: {
            type: 'string',
            source: 'text',
            selector: '.ihtHeading',
            default: 'Heading'
        },
        level: {
            type: 'string',
            default: 'h2',
            selector: 'ihtHeading'
        }
    },
    edit: props => {
        const { attributes: { alignment, icon, heading, level }, className, setAttributes } = props;
        return (
            <div className={ 'ihtEditor text-' + alignment }>
                <BlockControls>
                    <AlignmentToolbar
                        value={ alignment }
                        onChange={ ( alignment ) => { setAttributes( { alignment } ) } }
                    />
                </BlockControls>
                <InspectorControls>
                    <PanelBody title="Heading options">
                        <RadioControl
                            label="Heading level"
                            selected={ level }
                            options={[
                                { label: 'h2', value: 'h2' },
                                { label: 'h3', value: 'h3' },
                                { label: 'h4', value: 'h4' }
                            ]}
                            onChange={ ( level ) => { setAttributes( { level } ) } }
                        />
                    </PanelBody>
                </InspectorControls>
                <SelectControl
                    label="Icon Name"
                    hideLabelFromVision="true"
                    className="iconSelecter"
                    value={ icon }
                    onChange={ ( icon ) => { setAttributes( { icon } ) } }
                    options={ dropdownOptions }
                />
                <div className="iconPreview">
                    <i className={icon}></i>
                </div>
                <RichText
                    tagName={ level }
                    className={ 'text-' + alignment }
                    value={ heading }
                    onChange={ ( heading ) => { setAttributes( { heading } ) } }
                    placeholder='Heading'
                    allowedFormats={ [] } // This removes bold, italic, strikethrough, and link options for the heading
                />
                <InnerBlocks
                />
            </div>
        );
    },
    save: props => {
        const { attributes: { alignment, icon, heading, level }, className, setAttributes } = props;
        const HeadingTag = `${ level }`;
        let alignClass = '';
        if( alignment == 'center' || alignment == 'right') {
            alignClass = 'text-' + alignment;
        }
        return (
            <div className={ alignClass }>
                <HeadingTag className='ihtHeading'>
                    <RichText.Content
                        tagName="i"
                        className={ icon }
                    />{ heading }
                </HeadingTag>
                <InnerBlocks.Content />
            </div>
        );
    }
});