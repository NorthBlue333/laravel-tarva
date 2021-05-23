/* eslint-disable @typescript-eslint/no-var-requires */
const mix = require('laravel-mix')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.setPublicPath('assets')
    .webpackConfig({
        output: {
            publicPath: '/vendor/laravel-admin/',
        },
    })
    .ts('resources/js/admin.ts', 'assets/js')
    .options({
        processCssUrls: true,
    })
    .vue()
    .postCss('resources/css/admin.css', 'assets/css', [require('tailwindcss')])
    .version()
