const path = require('path');

const __curdir = path.join(__dirname, '.');
const __root = path.join(__dirname, '../');

module.exports = {
    context: __curdir,
    entry: {
        bundle: [
            'react-hot-loader/patch',
            path.join(__curdir, 'src', 'App.js'),
        ],
    },
    resolve: {
        modules: ['node_modules', path.join(__curdir, 'src')],
        extensions: ['.ts', '.tsx', '.js', '.json']
    },
    output: {
        path: path.join(__root, 'assets/js'),
        filename: '[name].js',
        library: '[name]',
        libraryTarget: 'umd',
    },
    module: {
        rules: [
            {
                test: /\.(j|t)s(x?)$/,
                loader: 'babel-loader',
                options: {
                    presets: [
                        '@babel/preset-env',
                        '@babel/preset-react',
                        '@babel/preset-typescript',
                    ],
                    plugins: [
                        'react-hot-loader/babel',
                        'babel-plugin-styled-components',
                    ],
                },
            },
            // {
            //     test: /\.svg$/,
            //     loader: "svg-inline-loader",
            //     options: {
            //         removeTags: true,
            //         removingTagAttrs: ['id', 'fill', 'enable-background']
            //     }
            // }
        ],
    },
};
