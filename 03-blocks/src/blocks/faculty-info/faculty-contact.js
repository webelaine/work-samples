const { registerBlockType } = wp.blocks;
const { InnerBlocks, RichText } = wp.blockEditor;
const { serverSideRender: ServerSideRender } = wp;

registerBlockType('stmu/faculty-contact', {
    parent: ['stmu/faculty-info'], // only allow inside a StMU Faculty Info block
    title: 'Faculty Contact', 
    category: 'widgets',
    icon: 'email-alt',
    attributes: {
        'email': {
            type: 'string',
            default: '@stmarytx.edu'
        },
        'phone': {
            type: 'string',
            default: 'N/A'
        }
    },
	edit( props ) {
        const { attributes: { email, phone }, className, setAttributes } = props;
        return (
            <div className="facultyContact">
                <InnerBlocks
                    allowedBlocks={ ['stmu/featured-image'] }
                    template={[
                        ['stmu/featured-image', {}],
                    ]}
                    templateLock='all'
                />
                <ul>
                    <li>
                        <i class="fa fa-envelope" aria-hidden="true"></i> 
                        <RichText
                            tagName='span'
                            value={ email }
                            onChange={ ( email ) => { setAttributes( { email } ) } }
                            placeholder='Email'
                            allowedFormats={ [] } // This removes bold, italic, strikethrough, and link options for the heading
                        />
                    </li>
                    <li>
                        <i class="fa fa-phone-square" aria-hidden="true"></i> 
                        <RichText
                            tagName='span'
                            value={ phone }
                            onChange={ ( phone ) => { setAttributes( { phone } ) } }
                            placeholder='Phone'
                            allowedFormats={ [] } // This removes bold, italic, strikethrough, and link options for the heading
                        />
                    </li>
                </ul>
            </div>
        );
	},
    save( props ) {
        const { attributes: { email, phone }, className } = props;
        const emailRegex = /(<([^>]+)>)/ig;
        const mailTo = 'mailto:' + email.replace(emailRegex, '');
        let phoneTo = '';
        if(phone != 'N/A') {
            phoneTo = 'tel:' + phone.replace(/\D/g,'');
        }
        return (
            <div className="facultyContact">
                <InnerBlocks.Content />
                <ul>
                    <li>
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        <a href={ mailTo } itemprop="email">
                            <RichText.Content
                                tagName="span"
                                value={ email }
                            />
                        </a>
                    </li>
                    <li>
                        <i class="fa fa-phone-square" aria-hidden="true"></i>
                        <a href={ phoneTo } itemprop="telephone">
                            { phone }
                        </a>
                    </li>
                </ul>
            </div>
        );
    },
});

registerBlockType('stmu/featured-image', {
    parent: ['stmu/faculty-contact'], // only allow inside a StMU Faculty Contact
    title: 'Featured Image', 
    category: 'widgets',
    icon: 'businessman',
    edit() {
        return <ServerSideRender block='stmu/featured-image' />;
    },
    save() {
        return null;
    }
});