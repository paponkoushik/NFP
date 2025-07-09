const { EnvironmentPlugin } = require('webpack');
const mix = require('laravel-mix');
const glob = require('glob');
const path = require('path');
const productionSourceMaps = false;

/*
 |--------------------------------------------------------------------------
 | Configure mix
 |--------------------------------------------------------------------------
 */

mix.options({
    resourceRoot: process.env.ASSET_URL || undefined,
    processCssUrls: false,
    postCss: [require('autoprefixer')]
});

/*
 |--------------------------------------------------------------------------
 | Configure Webpack
 |--------------------------------------------------------------------------
 */

mix.webpackConfig({
    output: {
        publicPath: process.env.ASSET_URL || undefined,
        libraryTarget: 'window'
    },
    plugins: [
        new EnvironmentPlugin({
            // Application's public url
            BASE_URL: process.env.ASSET_URL ? `${process.env.ASSET_URL}/` : '/'
        })
    ],
    module: {
        rules: [
            {
                test: /\.es6$|\.js$/,
                include: [
                    path.join(__dirname, 'node_modules/bootstrap/'),
                    path.join(__dirname, 'node_modules/popper.js/'),
                    path.join(__dirname, 'node_modules/shepherd.js/')
                ],
                loader: 'babel-loader',
                options: {
                    presets: [['@babel/preset-env', { targets: 'last 2 versions, ie >= 10' }]],
                    plugins: [
                        '@babel/plugin-transform-destructuring',
                        '@babel/plugin-proposal-object-rest-spread',
                        '@babel/plugin-transform-template-literals'
                    ],
                    babelrc: false
                }
            },
            {
                test: /\.vue$/,
                loader: 'vue-loader',
                // options: {
                //     reactivityTransform: true
                // }
            }
        ]
    },
    externals: {
        jquery: 'jQuery',
        hammer: 'Hammer',
        'popper.js': 'Popper'
    }
});

mix.alias({
    '@': path.join(__dirname, 'resources/js')
});

/*
 |--------------------------------------------------------------------------
 | Vendor assets
 |--------------------------------------------------------------------------
 */

function mixAssetsDir(query, cb) {
    (glob.sync('resources/theme/' + query) || []).forEach(f => {
        f = f.replace(/[\\\/]+/g, '/');
        cb(f, f.replace('resources/theme/', 'public/assets/'));
    });
}

/*
 |--------------------------------------------------------------------------
 | Configure sass
 |--------------------------------------------------------------------------
 */

const sassOptions = {
    precision: 5
};

// Core stylesheets
mixAssetsDir('vendor/scss/**/!(_)*.scss', (src, dest) =>
    mix.sass(src, dest.replace(/(\\|\/)scss(\\|\/)/, '$1css$2').replace(/\.scss$/, '.css'), { sassOptions })
);

// Core javascripts
mixAssetsDir('vendor/js/**/*.js', (src, dest) => mix.js(src, dest));

// Libs
mixAssetsDir('vendor/libs/**/*.js', (src, dest) => mix.js(src, dest));
// mixAssetsDir('vendor/libs/**/!(_)*.scss', (src, dest) =>
//     mix.sass(src, dest.replace(/\.scss$/, '.css'), { sassOptions })
// );
// mixAssetsDir('vendor/libs/**/*.{png,jpg,jpeg,gif}', (src, dest) => mix.copy(src, dest));

// Fonts
mixAssetsDir('vendor/fonts/*/*', (src, dest) => mix.copy(src, dest));
mixAssetsDir('vendor/fonts/!(_)*.scss', (src, dest) =>
    mix.sass(src, dest.replace(/(\\|\/)scss(\\|\/)/, '$1css$2').replace(/\.scss$/, '.css'), { sassOptions })
);

/*
 |--------------------------------------------------------------------------
 | Application assets
 |--------------------------------------------------------------------------
 */

mix.js('resources/js/app.js', 'public/assets/js/app.js')
   .js('resources/js/app.web.js', 'public/assets/js/app.web.js')
   .vue({
        version: 3,
        options: {
            compilerOptions: {
                isCustomElement: (tag) => ['trix-editor'].includes(tag),
            },
        },
    })
   .sass('resources/sass/app.scss', 'public/assets/css/app.css')
   .css('resources/sass/font-face.css', 'public/assets/css/fonts.css');

mixAssetsDir('js/**/*.js', (src, dest) => mix.scripts(src, dest));
mixAssetsDir('css/**/*.css', (src, dest) => mix.copy(src, dest));

mix.copy('node_modules/boxicons/fonts/*', 'public/assets/vendor/fonts/boxicons');
mix.copy('node_modules/@fortawesome/fontawesome-free/webfonts/*', 'public/assets/vendor/fonts/fontawesome');

mix.sourceMaps(productionSourceMaps, 'source-map')

// disabled notification
mix.disableNotifications();

if (mix.inProduction()) {
    mix.version();
}