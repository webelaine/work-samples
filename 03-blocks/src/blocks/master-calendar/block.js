const { serverSideRender: ServerSideRender } = wp;
const { BlockControls, InspectorControls } = wp.blockEditor;
const { Button, Disabled, PanelBody, Placeholder, RadioControl, SelectControl, TextControl, Toolbar } = wp.components;
const { Component } = wp.element;

export default class Block extends Component {
	renderEditMode() {
		const { props } = this;
		const { attributes : { calendarId, level, numberEvents, rssUrl }, setAttributes } = this.props;
		const onDone = () => {
			setAttributes({ editMode: false });
		}
		return(
			<Placeholder>
				<InspectorControls>
					<PanelBody title="Event options">
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
					label='Which calendar?'
					value={ calendarId }
					options={ [
						{ label: 'Admission', value: '4' },
						{ label: 'Athletics', value: '3' },
						{ label: 'General', value: '5' },
						{ label: 'Law', value: '2' },
						{ label: 'Student Activities', value: '6' },
						{ label: 'RSS Feed', value: 'rss' }
					] }
					onChange={ ( calendarId ) => { setAttributes( { calendarId } ) } }
				/>
				<TextControl
					label='How many events?'
					value={ numberEvents }
					onChange={ ( numberEvents ) => { setAttributes( { numberEvents } ) } }
				/>
				{ calendarId == 'rss' ? (
					<TextControl
						label='RSS feed URL'
						value={ rssUrl }
						onChange={ ( rssUrl ) => { setAttributes( { rssUrl } ) } }
					/>
				) : (
					<Disabled />
				) }
				<Button isSecondary onClick={ onDone }>
					Done
				</Button>
			</Placeholder>
		);
	}
	render() {
		const { attributes, setAttributes } = this.props;
		const { editMode } = attributes;
		return (
			<div>
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
						<ServerSideRender block='stmu/master-calendar' attributes={ attributes } />
					</Disabled>
				) }
			</div>
		);
	}
}