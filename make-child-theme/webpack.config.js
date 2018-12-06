module.exports = {
	entry: './js/index.js',
	output: {
		path: __dirname,
		filename: './js/dist/hack.js',
	},
	module: {
		loaders: [{
			test: /.js$/,
			loader: 'babel-loader',
			exclude: /node_modules/,
		}, ],
	},
};