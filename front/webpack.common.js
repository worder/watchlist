const path = require('path');

const __curdir = path.join(__dirname, '.');
const __root = path.join(__dirname, '../');

module.exports = {
    context: __curdir,
    entry: {
        bundle: path.join(__curdir, 'src', 'index.js'),
    },
    resolve: {
        modules: [
            'node_modules',
            path.join(__curdir, 'src'),
        ]
    },
    output: {
        path: path.join(__root, 'assets/js'),
        // publicPath: ('/js/rivChat/'),
        filename: '[name].js',
        library: '[name]',
        libraryTarget: 'umd'
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                loader: 'babel-loader',
                options: {
                    presets: [
                        '@babel/preset-env',
                        '@babel/preset-react',
                    ],
                    plugins: [
                        'react-hot-loader/babel',
                        'babel-plugin-styled-components',
                    ],
                }
            },
            // {
            //     test: /\.svg$/,
            //     loader: "svg-inline-loader",
            //     options: {
            //         removeTags: true,
            //         removingTagAttrs: ['id', 'fill', 'enable-background']
            //     }
            // }
        ]
    }
}