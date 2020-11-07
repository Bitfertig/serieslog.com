const webpack = require('webpack');
const path = require('path');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
//const HtmlWebpackPlugin = require('html-webpack-plugin');
const VueLoaderPlugin = require('vue-loader/lib/plugin');


const config = {
    entry: {
        main: './src/index.js'
    },
    output: {
        path: path.resolve(__dirname, 'dist'),
        filename: 'bundle.js',
    },
    module: {
        rules: [
			{
				test: /\.js$/,
				exclude: /node_modules/,
				use: 'babel-loader',
            },
            {
                test: /.vue$/,
                use: [
                    'vue-loader'
                ]
            },
            {
                test: /\.s[ac]ss$/,
                use: [
                    'style-loader',
                    'css-loader',
                    'sass-loader'
                ]
            },
            {
                test: /\.css$/,
                use: [
                    'style-loader',
                    'css-loader'
                ]
            },
            {
                test: /\.(png|svg|jpg|gif)$/,
                exclude: path.resolve(__dirname, './src/fonts'),
                use: [
                    'file-loader',
                ], 
            },
            {
                test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '[name].[ext]',
                            outputPath: '/fonts/', // where it will be copied
                            publicPath: '/dist/fonts/', // path from browser
                        }
                    }
                ]
            },
        ]
    },
    plugins: [
        new CleanWebpackPlugin(),
        /* new HtmlWebpackPlugin({
            cache: false,
            template: './src/index.php',
            filename: '../index.php',
        }), */
        new VueLoaderPlugin(),
    ]
};

module.exports = config;