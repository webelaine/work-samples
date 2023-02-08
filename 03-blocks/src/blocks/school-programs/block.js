const { BlockControls } = wp.blockEditor;
const { serverSideRender: ServerSideRender } = wp;
const { Component } = wp.element;
const { Button, Disabled, Placeholder, SelectControl, Toolbar } = wp.components;

export default class Block extends Component {
	renderEditMode() {
		const { props } = this;
		const { attributes : { editMode, levels }, setAttributes } = this.props;
		const onDone = () => {
			setAttributes({ editMode: false });
		}
		return(
			<Placeholder
				label='Choose which level of programs to show'
			>
				<SelectControl
					value={ levels }
					options={ [
						{ label: 'All', value: 'all' },
						{ label: 'Undergraduate', value: 'undergraduate' },
						{ label: 'Graduate', value: 'graduate' }
					] }
					onChange={ ( levels ) => { setAttributes( { levels } ) } }
				/>
				<Button isDefault onClick={ onDone }>
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
						<ServerSideRender block='stmu/school-programs' attributes={ attributes } />
					</Disabled>
				) }
			</div>
		);
	}
}