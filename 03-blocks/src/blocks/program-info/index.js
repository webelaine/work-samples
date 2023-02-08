const { registerBlockType } = wp.blocks;
const { InnerBlocks } = wp.blockEditor;
const { CheckboxControl, Dashicon, TextControl } = wp.components;
const { select, subscribe } = wp.data;
const { serverSideRender: ServerSideRender } = wp;

const TEMPLATE = [
    ['stmu/program-degrees'],
    ['stmu/program-locations'],
    ['stmu/program-departments'],
    ['stmu/program-directors']
];

registerBlockType('stmu/program-info', {
    title: 'Program Info',
    icon: 'feedback',
    category: 'common',
    supports: {
        multiple: false // can't add more than 1 of this block to one URL
    },
    attributes: {
        statOneNumber: {
            type: 'string',
            source: 'text',
            selector: '#programStatOne .statNumber'
        },
        statOneText: {
            type: 'string',
            source: 'text',
            selector: '#programStatOne .statText'
        },
        statTwoNumber: {
            type: 'string',
            source: 'text',
            selector: '#programStatTwo .statNumber'
        },
        statTwoText: {
            type: 'string',
            source: 'text',
            selector: '#programStatTwo .statText'
        }
    },
    edit: props => {
        const posts = select("core").getEntityRecords('postType', 'post');
        const { attributes: { statOneNumber, statOneText, statTwoNumber, statTwoText }, className, setAttributes } = props;
        return (
            <div className="programInfo">
                <div class="max-width">
                    <div class="programStats" id="programStatOne">
                        <div class="statNumber">
                            <TextControl
                                value={ statOneNumber }
                                placeholder='120'
                                onChange={ ( statOneNumber ) => { setAttributes( { statOneNumber } ) } }
                            />
                        </div>
                        <div class="statText">
                            <TextControl
                                value={ statOneText }
                                placeholder='Credit Hours'
                                onChange={ ( statOneText ) => { setAttributes( { statOneText } ) } }
                            />
                        </div>
                    </div>
                    <div class="programStats" id="programStatTwo">
                        <div class="statNumber">
                            <TextControl
                                value={ statTwoNumber }
                                placeholder='18'
                                onChange={ ( statTwoNumber ) => { setAttributes( { statTwoNumber } ) } }
                            />
                        </div>
                        <div class="statText">
                            <TextControl
                                value={ statTwoText }
                                placeholder='Months (avg.)'
                                onChange={ ( statTwoText ) => { setAttributes( { statTwoText } ) } }
                            />
                        </div>
                    </div>
                    <InnerBlocks
                        template={ TEMPLATE }
                        templateLock='all'
                    />
                </div>
            </div>
        );
    },
    save: props => {
        const { attributes: { statOneNumber, statOneText, statTwoNumber, statTwoText }, className, setAttributes } = props;
        return (
            <div className="programInfo">
                <div class="max-width">
                    <div class="programStats" id="programStatOne">
                        <div class="statNumber">
                            { statOneNumber }
                        </div>
                        <div class="statText">
                            { statOneText }
                        </div>
                    </div>
                    <div class="programStats" id="programStatTwo">
                        <div class="statNumber">
                            { statTwoNumber }
                        </div>
                        <div class="statText">
                            { statTwoText }
                        </div>
                    </div>
                    <InnerBlocks.Content />
                </div>
            </div>
        );
    }
});