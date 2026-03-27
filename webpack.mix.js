const mix = require('laravel-mix');
const path = require('path');
require('laravel-mix-workbox');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/tender.scss', 'public/css/tender.css')
    .options({
        processCssUrls: false
    })
    .version();

mix.webpackConfig({ resolve: { alias: { '@': path.resolve('resources/js') } } });

// hide temporary to avoid large bundle size
mix.combine([
    'public/mix/js/datatables/pdfmake.min.js',
    'public/mix/js/datatables/vfs_fonts.js',
    'public/mix/js/datatables/datatables.min.js',
],
    'public/js/plugins/datatables/datatables.min.js'
).version();

// source : https://davidstutz.github.io/bootstrap-multiselect/
mix.combine([
    'public/mix/js/bootstrap-multiselect/bootstrap-multiselect.min.js',

],
    'public/js/plugins/bootstrap-multiselect/bootstrap-multiselect.min.js',
).version();

mix.combine([
    'public/mix/js/typeahead/jquery.typeahead.min.js',
],
    'public/js/plugins/typeahead/typeahead.min.js'
).version();


// use this to generate service worker laravel-mix-workbox
// mix.combine(['resources/js/app.js'], 'public/js/app.js')
// .generateSW({
// 	exclude: [/\.(?:png|jpg|jpeg|svg|pdf)$/],
// });

// toggle line dibawah untuk memilih bundle berdasarkan page yg diinginkan
// mix.react('resources/js/app.js', 'public/js/hse.js');
mix.react('resources/js/app.js', 'public/js/hse/safetyinduction/index2.js');
// mix.react('resources/js/app.js', 'public/js/hse/safetyinduction/create.js');
