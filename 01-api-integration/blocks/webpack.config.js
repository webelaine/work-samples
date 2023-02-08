const path = require( 'path' );
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
module.exports = {
	...defaultConfig,
	entry: {
		'all-regulations': './blocks/all-regulations/',
		'species-regulations': './blocks/species-regulations/',
	},
	output: {
		path: path.resolve( __dirname, './build' ), // packaged directory
	},
};
