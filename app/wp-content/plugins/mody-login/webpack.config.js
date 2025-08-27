const path = require( 'path' );
const defaults = require( '@wordpress/scripts/config/webpack.config.js' );

module.exports = () => ( {
	...defaults,
	entry: {
		login: path.resolve( process.cwd(), 'resources', 'login.ts' ),
		orion: path.resolve( process.cwd(), 'resources', 'scripts.ts' ),
	},
	output: {
		filename: '[name].js',
		path: path.resolve( process.cwd(), 'dist' ),
	},
	module: {
		...defaults.module,
		rules: [
			...defaults.module.rules,
			{
				test: /\.(png|svg|jpg|jpeg|gif)$/i,
				type: 'asset/resource',
			},
			{
				test: /\.(js|jsx)$/,
				exclude: /node_modules/,
				use: {
					loader: 'babel-loader',
					options: {
						presets: [ '@babel/preset-react' ],
					},
				},
			},
		],
	},
} );
