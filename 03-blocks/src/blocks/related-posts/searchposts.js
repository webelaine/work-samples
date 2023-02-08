const { Button, MenuGroup, MenuItem, SelectControl, TextControl } = wp.components;
const { Component } = wp.element;
const axios = require('axios');

export class SearchPostsControl extends Component {
	constructor(props) {
		super(props);
		this.state = {
////////// "Selected" section
			selectedButtons: [],	// Array of React Elements - a button with title for each of the IDs in postIds attribute
////////// "Results" section
			resultObjects: [],		// Array of Post Objects - the ones that are currently being shown, either by default or by search
			resultButtons: []		// Array of React Elements - a MenuItem button with checkbox and title for each of the objects in resultObjects
		};
		this.buildSelectedButtons = this.buildSelectedButtons.bind(this);
		this.buildResultButtons = this.buildResultButtons.bind(this);
		this.changePostType = this.changePostType.bind(this);
		this.getStartingData = this.getStartingData.bind(this);
		this.searchFor = this.searchFor.bind(this);
		this.updateSelectedIds = this.updateSelectedIds.bind(this);
	}

	componentDidMount() {
		this.getStartingData();
	}

	getStartingData() {
		this.buildSelectedButtons();
		this.searchFor('');
	}

	buildSelectedButtons() {
		let { attributes: { postIds, postType }, setAttributes } = this.props;
		// If post IDs are saved in state, get their titles and show buttons
		if(postIds.length > 0) {
			let selectionButtons = [];
			// Get all the post info in a single REST API call
			let path = '/wp/v2/' + postType + '?include=' + postIds;
			wp.apiFetch({ path: path })
				.then( (posts) => {
					selectionButtons = postIds.map((item) => {
						// If this post ID was found in the REST API CALL
						let match;
						for(let i=0; i < posts.length; i++) {
							if(posts[i].id == item) {
								match = i;
								break;
							}
						}
						if(match >= 0) {
							return(
								<Button
									isDefault
									isDestructive
									onClick={ () => this.updateSelectedIds(item, false) }
								>
									{ posts[match].title.rendered }
								</Button>
							);
						} else {
							// If the post ID was not found, remove it from selectedIds
							let idIndex = postIds.indexOf(item);
							postIds.splice(idIndex, 1);
							setAttributes({ postIds, postIds });
							return(
								<p>A previously selected item was removed because it no longer exists.</p>
							);
						}
					})
				})
				.catch( (error) => {
					console.log('Related Posts error',error);
				})
				.then(() =>
					this.setState({ selectedButtons: selectionButtons })
				);
		}
		// If no post IDs, show paragraph
		else {
			this.setState({ selectedButtons: <p>None selected</p> });
		}
	}

	buildResultButtons() {
		let { setAttributes } = this.props;
		let resultButtons = this.state.resultObjects.map(function(item) {
			let isChecked = item.checked;
			// Save the opposite value for onClick
			// Must have default true, because if nothing is selected, it's false, and true is what it should change to
			let toCheck = true;
			if(isChecked == true) {
				toCheck = false;
			}
			return(
				<MenuItem
					id={ item.id }
					data-ischecked={ isChecked }
					onClick={ () => this.updateSelectedIds(parseInt(event.target.id), toCheck) }
				>
					{ item.title.rendered }
				</MenuItem>
			);
		}, this);
		// Save timestamp in milliseconds - this forces the setAttributes call for postIds to work
		let timeNow = Date.now();
		this.setState({ resultButtons: resultButtons }, setAttributes({ updated: timeNow }));
	}

	changePostType(newType) {
		// Clear postIds, update postType Attribute
		let { setAttributes } = this.props;
		setAttributes({ postIds: [], postType: newType });
		// Clear state and run a new search
		this.setState({ selectedButtons: [], resultObjects: [], resultButtons: []}, this.searchFor(newType, ''));
	}

	searchFor(searchPostType = '', keyword = '') {
		let { attributes: { postIds, postType } } = this.props;
		let finalPostType = postType;
		// If a post type was explicitly passed to the function, use that instead
		if(searchPostType != '') {
			finalPostType = searchPostType;
		}
		// Make REST API call to get post objects - excluding current ID, but including the postType and keyword if present
		let currentId = wp.data.select('core/editor').getCurrentPostId();
		let path;
		if(keyword != '') {
			path = '/wp-json/wp/v2/' + finalPostType + '?search=' + keyword + '&exclude=' + currentId;

		} else {
			path = '/wp-json/wp/v2/' + finalPostType + '?exclude=' + currentId;
		}

		axios.get(path)
			.then( ( posts ) => {
				for(var i = 0; i < posts.data.length; i++) {
					// if this post ID is in selectedIds state, set checked to true
					posts.data[i].checked = false;
					for(var j = 0; j < postIds.length; j++) {
						if(posts.data[i].id === postIds[j]) {
							posts.data[i].checked = true;
							break;
						}
					}
				}
				this.setState({ resultObjects: posts.data }, () => this.buildResultButtons());
			})
			.catch( (error) => {
				// Silence errors
			})
	}

	updateSelectedIds(id, val) {
		let { attributes: { postIds }, setAttributes } = this.props;
		// Update copy of selectedIds
		let stateSelected = JSON.parse(JSON.stringify(postIds));
		if(val == true) {
			stateSelected.push(id);
		} else {
			let idIndex = stateSelected.indexOf(id);
			stateSelected.splice(idIndex, 1);
		}
		setAttributes({ postIds: stateSelected });
		// Update copy of resultObjects
		let posts = this.state.resultObjects;
		for(var i = 0; i < posts.length; i++) {
			// if this post ID is in attributes, set checked to true
			posts[i].checked = false;
			for(var j = 0; j < stateSelected.length; j++) {
				if(posts[i].id === stateSelected[j]) {
					posts[i].checked = true;
					break;
				}
			}
		}
		// Save resultObjects to state, and then rebuild selected buttons and result buttons
		this.setState({ resultObjects: posts }, function() {
			this.buildSelectedButtons();
			this.buildResultButtons();
		});
	}
	
	render() {
		let { attributes: { postType } } = this.props;
		// Posts are plural; all others are singular
		let displayType = postType;
		if(postType != 'posts' && postType != 'faculty') {
			displayType += 's';
		}
		let label = 'Search for ' + displayType + ' to display';
		return(
			<div className='search-posts-control'>
				<div className='posts-selected'>
					<h2>Currently selected:</h2>
					<SelectControl
						label='Post Type'
						value={ postType }
						options={ [
							{ label: 'Faculty', value: 'faculty' },
							{ label: 'Post - News or Magazine', value: 'posts' },
							{ label: 'Program', value: 'program' },
							{ label: 'Special Program', value: 'specialprogram' }
						] }
						onChange={ (val) => { this.changePostType(val) } }
					/>
					{ this.state.selectedButtons }
				</div>
				<div className='posts-search'>
					<h2>Add to selections:</h2>
					<TextControl
						label={ label }
						type='search'
						onChange={ (val) => this.searchFor('', val) }
					/>
					<MenuGroup
						label='Search Results'
						className='posts-list'
					>
						{ this.state.resultButtons }
					</MenuGroup>
				</div>
			</div>
		);
	}
}