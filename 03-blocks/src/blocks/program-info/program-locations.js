const { registerBlockType } = wp.blocks;
 
registerBlockType( 'stmu/program-locations', {
    parent: ['stmu/program-info'], // only allow inside a Program Info block
    title: 'Program Location',
    icon: 'editor-ul',
    category: 'widgets',
    attributes: {
        locCampus: {
            type: 'boolean',
            default: true
        },
        locCombo: {
            type: 'boolean',
            default: false
        },
        locOnline: {
            type: 'boolean',
            default: false
		}
    },
    edit: props => {
        const { attributes: { locCampus, locCombo, locOnline }, setAttributes } = props;
        return(
			<div class="programDetails">
				<h2>Location</h2>
                <p><em>If this is an undergraduate program, School will show instead.</em></p>
				<label>
					<input
						type='checkbox'
						checked={ locCampus }
						onChange={ function(evt) {
							props.setAttributes({ locCampus: evt.target.checked });
						}}
					/>
					On Campus
				</label>
				<label>
					<input
						type='checkbox'
						checked={ locOnline }
						onChange={ function(evt) {
							props.setAttributes({ locOnline: evt.target.checked });
						}}
					/>
					Online
				</label>
				<label>
					<input
						type='checkbox'
						id='locCombo'
						checked={ locCombo }
						onChange={ function(evt) {
							props.setAttributes({ locCombo: evt.target.checked });
						}}
					/>
					Combination
				</label>
			</div>
        );
    },
    save() {
        // Rendering in PHP
        return null;
    }
} );