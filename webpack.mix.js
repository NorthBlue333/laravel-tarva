const mix = require('laravel-mix')
const tailwindcss = require('tailwindcss')

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
  .webpackConfig({
    node: {
      fs: 'empty',
    },
  })
  .js('resources/js/admin.js', 'assets/js')
  .js('resources/js/admin-alpine-editor.js', 'assets/js')
  .sass('resources/sass/admin.scss', 'assets/css', {}, [
    tailwindcss('./admin-tailwind.config.js'),
  ])
  .options({ processCssUrls: false })
