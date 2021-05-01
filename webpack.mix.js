const mix = require('laravel-mix');

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

const tailwindcss = require('tailwindcss');

mix.js('resources/js/app.js', 'public/js')
    .postCss("resources/css/app.css", "public/css", [
        require("tailwindcss"),
    ])
    .webpackConfig({
        externals: {
            'vue-server-renderer/basic': 'vue-server-renderer/basic'
        }
    });
