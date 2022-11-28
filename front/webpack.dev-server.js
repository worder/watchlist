const { merge } = require('webpack-merge');
const common = require('./webpack.common');
const webpack = require('webpack');

const outPath = process.env.npm_config_output;

module.exports = merge(common, {
    watch: false,
    output: {
        path: outPath,
        publicPath: 'https://localhost:8081/',
    },
    devServer: {
        host: 'localhost',
        port: 8081,
        hot: 'only',
        liveReload: false,
        static: false,
        server: {
            type: 'https',
            options: {
                key: './cert/private/private.key',
                cert: './cert/private/private.pem',
            },
        },
        headers: {
            'Access-Control-Allow-Origin': '*',
        },
        devMiddleware: {
            writeToDisk: true,
        },
        allowedHosts: 'all',
        webSocketServer: 'sockjs',
    },
    resolve: {
        alias: {
            'react-dom': '@hot-loader/react-dom',
        },
    },
    // plugins: [new webpack.SourceMapDevToolPlugin()],
    // plugins: [new CleanWebpackPlugin()]
});
