var webpack = require('webpack');

module.exports = {
    entry: {
        admin: ['./resources/assets/admin/js/admin.js']
    },
    output: {
        path: __dirname + '/public/build',
        filename: '[name].bundles.js',
        publicPath: '/build/'
    },
    plugins: [
        new webpack.ProvidePlugin({
            'window.$': 'jquery',
            'window.jQuery': 'jquery'
        })
    ],
    module: {
        loaders: [{
                test: /\.js$/,
                exclude: /(node_modules)/,
                loader: 'babel'
            },
            {
                test: /\.vue$/,
                loader: 'vue'
            }
        ]
    }
};