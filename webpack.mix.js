let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
	.js('resources/assets/js/admin.js', 'public/admin/js')
	.less('resources/assets/less/app.less', 'public/css')
	.less('resources/assets/less/admin.less', 'public/admin/css')
	.copyDirectory('vendor/twbs/bootstrap/dist/css', 'public/vendor/bootstrap/css')
	.copyDirectory('vendor/twbs/bootstrap/dist/js', 'public/vendor/bootstrap/js')
	.copyDirectory('vendor/components/jquery', 'public/vendor/jquery');
