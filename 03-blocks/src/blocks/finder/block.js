const { BlockControls } = wp.blockEditor;
const { serverSideRender: ServerSideRender } = wp;
const { Component } = wp.element;
const { Button, Disabled, Placeholder, SelectControl, Toolbar } = wp.components;

export default class Block extends Component {
	renderEditMode() {
		const { props } = this;
		const { attributes : { postType }, setAttributes } = this.props;
		const onDone = () => {
			setAttributes({ editMode: false });
		}
		return(
			<Placeholder
				label='Choose which posts to search for'
			>
				<SelectControl
					value={ postType }
					options={ [
						{ label: 'Residence Halls', value: 'hall' }
					] }
					onChange={ ( postType ) => { setAttributes( { postType } ) } }
				/>
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
			<div className="wp-block-stmu-finder">
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
						<ServerSideRender block='stmu/finder' attributes={ attributes } />
					</Disabled>
				) }
			</div>
		);
	}
}