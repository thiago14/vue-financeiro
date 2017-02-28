const gulp = require('gulp');
const elixir = require('laravel-elixir');
const webpack = require('webpack');
const webpackDevServer = require('webpack-dev-server');
const webpackConfig = require('./webpack.config');
const webpackDevConfig = require('./webpack.dev.config');

require('laravel-elixir-vue');
require('laravel-elixir-webpack-official');

Elixir.webpack.config.module.loaders = [];

Elixir.webpack.mergeConfig(webpackConfig);
Elixir.webpack.mergeConfig(webpackDevConfig);

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

gulp.task('webpack-dev-server', () => {
    var inlineHot = [
        'webpack/hot/dev-server',
        'webpack-dev-server/client?http://192.168.10.10:8080'
    ];
    Elixir.webpack.config.entry.admin.concat(inlineHot);

    new webpackDevServer(webpack(Elixir.webpack.config), {
        hot: true,
        proxy: {
            '*': 'http://192.168.10.10:8080'
        },
        watchOptions: {
            poll: true,
            aggregateTimeout: 300
        },
        publicPath: Elixir.webpack.config.output.publicPath,
        stats: { colors: true }
    }).listen(8080, "localhost", function() {
        console.log("Bundling project...");
    })
});

elixir(mix => {
    mix.sass('./resources/assets/admin/sass/admin.scss')
        .copy('./node_modules/materialize-css/fonts/roboto', './public/fonts/roboto');

    mix.browserSync({
        host: '0.0.0.0',
        proxy: 'http://192.168.10.10:8000'
    });
    gulp.start('webpack-dev-server');
});