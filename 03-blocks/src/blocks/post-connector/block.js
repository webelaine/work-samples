const { serverSideRender: ServerSideRender } = wp;
const { BlockControls } = wp.blockEditor;
const { Button, Disabled, Placeholder, SelectControl, TextControl, Toolbar } = wp.components;
const { Component } = wp.element;

export default class Block extends Component {
	renderEditMode() {
		const { attributes : { category, display, number, school, tag }, className, setAttributes } = this.props;
		const onDone = () => {
			setAttributes({ editMode: false });
		}
		// Tags: have an "all" option, and also get all active Tags on the site
		var tagOptions = [ { label: 'All', value: 'all' } ];
		let actualTags = wp.data.select('core').getEntityRecords('taxonomy', 'post_tag' );
		let nextOption;
		actualTags.forEach(function(element) {
			nextOption = { label: element['name'], value: element['slug']};
			tagOptions.push(nextOption);
		})
		return(
			<Placeholder
				label='Post display options:'
				className={ className }
			>
				<TextControl
					label='Number'
					value={ number }
					onChange={ ( number ) => { setAttributes( { number } ) } }
				/>
				<SelectControl
					label='Categories'
					value={ category }
					options={ [
						{ label: 'All', value: 'all' },
						{ label: 'Magazine', value: 'magazine' },
						{ label: 'News', value: 'news' }
					] }
					onChange={ ( category ) => { setAttributes( { category } ) } }
				/>
				<SelectControl
					label='Display'
					value={ display }
					options={ [
						{ label: 'Text list', value: 'list' },
						{ label: 'Images', value: 'images' }
					] }
					onChange={ ( display ) => { setAttributes( { display } ) } }
				/>
				<SelectControl
					label='School'
					value={ school }
					options={ [
						{ label: 'All', value: 'all' },
						{ label: 'CAHSS', value: 'school-humanities' },
						{ label: 'GSB', value: 'school-business' },
						{ label: 'SET', value: 'school-set' },
					] }
					onChange={ ( school ) => { setAttributes( { school } ) } }
				/>
				<SelectControl
					label='Tag'
					value={ tag }
					options={ tagOptions }
					onChange={ ( tag ) => { setAttributes( { tag } ) } }
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
						<ServerSideRender block='stmu/post-connector' attributes={ attributes } />
					</Disabled>
				) }
			</div>
		);
	}
}