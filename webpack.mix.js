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
    .scripts([
        'resources/assets/js/external/notify.js',
        'resources/assets/js/external/summernote.js',
        'resources/assets/js/components/profile.js',
        'resources/assets/js/components/globshoppers.js',
        'resources/assets/js/components/requests.js',
        'resources/assets/js/components/complaints.js',
        'resources/assets/js/components/users.js'
    ], 'public/js/all.js')
   .sass('resources/assets/sass/app.scss', 'public/css');
