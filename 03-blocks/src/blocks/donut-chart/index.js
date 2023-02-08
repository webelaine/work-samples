const { registerBlockType } = wp.blocks;
const { InspectorControls } = wp.blockEditor;
const { PanelBody, RangeControl, TextControl } = wp.components;

registerBlockType('stmu/donut-chart', {
    title: 'Donut Chart',
    icon: 'marker',
    category: 'widgets',
    supports: {'anchor': true},
    attributes: {
        description: {
            type: 'string',
            source: 'text',
            selector: '.donut desc',
            default: 'Describe the data this chart contains.'
        },
        largeText: {
            type: 'string',
            source: 'text',
            selector: '.large-text',
            default: '1'
        },
        percent: {
            type: 'number',
            default: '50'
        },
        progressLabel: {
            type: 'string',
            source: 'text',
            selector: '.donut-progress',
            default: 'Progress'
        },
        smallText: {
            type: 'string',
            source: 'text',
            selector: '.small-text',
            default: 'Million Raised'
        },
        title: {
            type: 'string',
            source: 'text',
            selector: '.donut title',
            default: 'Chart'
        },
        totalLabel: {
            type: 'string',
            source: 'text',
            selector: '.donut-total',
            default: 'Total'
        }
    },
    edit: props => {
        const { attributes: { description, largeText, percent, progressLabel, smallText, title, totalLabel }, setAttributes } = props;
        return (
            <figure className="donut">
                <InspectorControls>
                    <PanelBody title="Donut Chart options">
                        <TextControl
                            label='Title'
                            value={ title }
                            onChange={ ( title ) => { setAttributes( { title } ) } }
                        />
                        <TextControl
                            label='Description'
                            value={ description }
                            onChange={ ( description ) => { setAttributes( { description } ) } }
                        />
                        <RangeControl
                            label='Percent'
                            value={ percent }
                            onChange={ ( percent ) => { setAttributes( { percent } ) } }
                            min={ 0 }
                            max={ 100 }
                        />
                        <TextControl
                            className="large-ctr"
                            label='Large Text'
                            value={ largeText }
                            onChange={ ( largeText ) => { setAttributes( { largeText } ) } }
                        />
                        <TextControl
                            className="small-ctr"
                            label='Small Text'
                            value={ smallText }
                            onChange={ ( smallText ) => { setAttributes( { smallText } ) } }
                        />
                        <TextControl
                            label='Progress (Blue) Label'
                            value={ progressLabel }
                            onChange={ ( progressLabel ) => { setAttributes( { progressLabel } ) } }
                        />
                        <TextControl
                            label='Total (Gold) Label'
                            value={ totalLabel }
                            onChange={ ( totalLabel ) => { setAttributes( { totalLabel } ) } }
                        />
                    </PanelBody>
                </InspectorControls>
                <div className="figure-content">
                    <svg viewBox="0 0 42 42">
                        <title>{ title }</title>
                        <desc>{ description }</desc>
                        <circle class="donut-hole" cx="21" cy="21" r="15.91549430918954" fill="#fff"></circle>
                        <circle class="donut-ring" cx="21" cy="21" r="15.91549430918954" fill="transparent" stroke="#f2bf49" stroke-width="3"></circle>
                        <circle
                            style={{strokeDasharray: `${percent}, ${100 - percent}`}}
                            class="donut-segment" cx="21" cy="21" r="15.91549430918954" fill="transparent" stroke="#036" stroke-width="3" />
                        <g class="chart-text">
                            <text x="50%" y="50%" class="large-text">{ largeText }</text>
                            <text x="50%" y="50%" class="small-text">{ smallText }</text>
                        </g>
                    </svg>
                </div>
                <figcaption>
                    <ul className="figure-key-list" aria-hidden="true" role="presentation">
                        <li class="donut-progress">
                            <span class="shape-circle shape-blue"></span>
                            { progressLabel }
                        </li>
                        <li class="donut-total">
                            <span class="shape-circle shape-gold"></span>
                            { totalLabel }
                        </li>
                    </ul>
                </figcaption>
            </figure>
        )
    },
    save: props => {
        const { attributes: { description, largeText, percent, progressLabel, smallText, title, totalLabel }, className } = props;
        return (
            <figure className="donut">
                <div className="figure-content">
                    <svg viewBox="0 0 42 42">
                        <title>{ title }</title>
                        <desc>{ description }</desc>
                        <circle class="donut-hole" cx="21" cy="21" r="15.91549430918954" fill="#fff"></circle>
                        <circle class="donut-ring" cx="21" cy="21" r="15.91549430918954" fill="transparent" stroke="#f2bf49" stroke-width="3"></circle>
                        <circle class="donut-segment" cx="21" cy="21" r="15.91549430918954" fill="transparent" stroke="#036" stroke-width="3"></circle>
                        <g class="chart-text">
                            <text x="50%" y="50%" class="large-text">{ largeText }</text>
                            <text x="50%" y="50%" class="small-text">{ smallText }</text>
                        </g>
                    </svg>
                </div>
                <figcaption>
                    <ul class="figure-key-list" aria-hidden="true" role="presentation">
                        <li class="donut-progress">
                            <span class="shape-circle shape-blue"></span>
                            { progressLabel }
                        </li>
                        <li class="donut-total">
                            <span class="shape-circle shape-gold"></span>
                            { totalLabel }
                        </li>
                    </ul>
                </figcaption>
            </figure>
        );
    }
});