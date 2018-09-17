const Encore = require('@symfony/webpack-encore')
const UglifyJsPlugin = require('uglifyjs-webpack-plugin')
const vueEnv = require('./vue_env')
const webpack = require('webpack')

Encore
// directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if you JavaScript imports CSS.
     */
    .addEntry('app', './assets/js/app.js')
    //.addEntry('page1', './assets/js/page1.js')
    //.addEntry('page2', './assets/js/page2.js')

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .configureBabel(babelConfig => {
        babelConfig.presets.push('stage-3')
        babelConfig.plugins.push('syntax-dynamic-import')
        babelConfig.plugins.push('transform-runtime')
    })
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables Sass/SCSS support
    .enableSassLoader()
    .enableVueLoader(options => {
        options.loaders['scss'] = ['vue-style-loader',
            {loader: 'css-loader', options: {sourceMap: !Encore.isProduction()}},
            {
                loader: 'sass-loader',
                options: {
                    sourceMap: !Encore.isProduction(),
                    data: `
                    @import "assets/scss/modules/_variables.scss";
                    `
                }
            }
        ];
        options.loaders['sass'] = options.loaders['scss'];
    })
    .addLoader({
        test: /\.(graphql|gql)$/,
        exclude: /node_modules/,
        loader: 'graphql-tag/loader'
    })

// uncomment if you use TypeScript
//.enableTypeScriptLoader()

// uncomment if you're having problems with a jQuery plugin
//.autoProvidejQuery()


const webpackConfig = Encore.getWebpackConfig()

webpackConfig.plugins.push(
    new webpack.EnvironmentPlugin(vueEnv)
)

if (Encore.isProduction()) {
    webpackConfig.plugins = webpackConfig.plugins.filter(
        plugin => !(plugin instanceof webpack.optimize.UglifyJsPlugin)
    )
    webpackConfig.plugins.push(new UglifyJsPlugin())
}

module.exports = webpackConfig
