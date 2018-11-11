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
   .sass('resources/assets/sass/app.scss', 'public/css');


mix.styles([
    /*'resources/assets/css/app/bootstrap.min.css', 
    'resources/assets/css/app/font-awesome.min.css', 
    'resources/assets/css/app/dashboard.css', 
    'resources/assets/css/app/style.css' 
    'resources/assets/css/app/custom.css'*/
    'resources/assets/css/app/font.css',
    'resources/assets/css/app/bootstrap.min.css',
    'resources/assets/css/app/bootstrap-datepicker.css',
    'resources/assets/css/app/jquery.timepicker.css',
    'resources/assets/css/app/style.css',
    'resources/assets/css/app/custom.css',
    'resources/assets/css/app/responsive-calendar.css'
], 'public/css/personalizado.css');

mix.scripts([
    'resources/assets/js/app/jquery.min.js',
    'resources/assets/js/app/jquery.blockUI.js',
    'resources/assets/js/app/popper.min.js',
    'resources/assets/js/app/bootstrap.min.js',
    'resources/assets/js/app/bootstrap-datepicker.js',
    'resources/assets/js/app/bootstrap-datepicker.pt-BR.js',
    'resources/assets/js/app/jquery.timepicker.min.js',
    'resources/assets/js/app/jquery.mask.min.js',
    'resources/assets/js/app/jquery.validate.min.js',
    'resources/assets/js/app/responsive-calendar.min.js',
    'resources/assets/js/app/jquery.shiftcheckbox.js',
    'resources/assets/js/app/notify.min.js',
    'resources/assets/js/app/pusher.min.js',
    'resources/assets/js/app/util.js',
    'resources/assets/js/app/base.js'
], 'public/js/personalizado.js');