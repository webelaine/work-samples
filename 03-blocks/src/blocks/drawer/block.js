const { Button, Disabled, PanelBody, RadioControl, TextControl, Toolbar } = wp.components;
const { BlockControls, InnerBlocks, InspectorControls } = wp.blockEditor;
const { Component, Fragment } = wp.element;

export default class Block extends Component {
	renderEditMode() {
		const { props } = this;
		const { attributes: { isOpen, summary }, setAttributes } = this.props;
		const onDone = () => {
			setAttributes({ editMode: false });
		}
		return(
            <Fragment>
                <InspectorControls>
                    <PanelBody title="Open by default?">
                        <RadioControl
                            label="Open on load"
                            selected={ isOpen }
                            options={[
                                { label: 'Open', value: true },
                                { label: 'Closed', value: false }
							]}
                            onChange={ () => { setAttributes( { isOpen: !isOpen } ) } }
                        />
                    </PanelBody>
                </InspectorControls>
                <details open>
                    <summary>
                        <TextControl
                            value={ summary }
                            placeholder='Summary text'
                            onChange={ ( summary ) => { setAttributes( { summary } ) } }
                        />
                    </summary>
                    <InnerBlocks />
                </details>
                <Button isSecondary onClick={ onDone }>
                    Done
                </Button>
            </Fragment>
		);
	}
	render() {
		const { attributes: { editMode, isOpen, summary }, setAttributes } = this.props;
		return (
			<Fragment>
				<BlockControls>
					<Toolbar
						controls={ [
							{
								icon: 'edit',
								title: 'Edit',
								onClick: () => setAttributes({ editMode: !editMode }),
								isActive: editMode
							}
						] }
					/>
				</BlockControls>
				{ editMode ? (
					this.renderEditMode()
				) : (
					<Disabled>
                        <details open={ isOpen }>
                            <summary>{ summary }</summary>
							<InnerBlocks />
                        </details>
					</Disabled>
				) }
			</Fragment>
		);
	}
}