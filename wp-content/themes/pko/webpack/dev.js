// development config
const merge = require("webpack-merge");
const webpack = require("webpack");
const commonConfig = require("./common");
const BrowserSyncPlugin = require("browser-sync-webpack-plugin");
const path = require('path');

const THEME_NAME = 'pko';
const PROXY_TARGET = 'wp.pko.wecode.agency';
const HOST = 'localhost';
const PORT = 7070;

module.exports = merge(commonConfig, {
	mode: "development",
    watch: true,
    devServer: {
        watchOptions: {
            poll: true,
        },
    },
    output: {
        pathinfo: true,
        publicPath: PROXY_TARGET + "/wp-content/themes/pko/static",
    },
    // output: {
    //     publicPath: `//${HOST}:${PORT}/wp-content/themes/${THEME_NAME}/`,
    // },
	devtool: "cheap-module-eval-source-map",
    plugins: [
        // new webpack.HotModuleReplacementPlugin(),
        new BrowserSyncPlugin( {
            host: PROXY_TARGET,
            port: PORT,
            proxy: PROXY_TARGET,
            open: "external",
            files: [
                'src/library/**/*.twig'
            ],
            watch: true,
            delay: 500,
            // advanced: {
            //     browserSync: {
            //         logLevel: 'debug',
            //     },
            // },
        }),
    ]
});
