const { serverSideRender: ServerSideRender } = wp;
const { BlockControls } = wp.blockEditor;
const { Button, Disabled, Placeholder, Toolbar } = wp.components;
const { Component, Fragment } = wp.element;
import { SearchPostsControl } from './searchposts.js';

export default class Block extends Component {
	renderEditMode() {
		const { props } = this;
		const { attributes, setAttributes } = this.props;
		const onDone = () => {
			setAttributes({ editMode: false });
		}
		return(
			<Placeholder
				label='Choose the posts you want to display'
			>
				<SearchPostsControl { ...props } />
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
						<ServerSideRender block='stmu/related-posts' attributes={ attributes } />
					</Disabled>
				) }
			</Fragment>
		);
	}
}