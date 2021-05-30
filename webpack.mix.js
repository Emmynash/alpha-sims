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

mix.react('resources/js/app.js', 'public/js')
   .react('resources/js/app1.js', 'public/js')
   .react('resources/js/appteachers.js', 'public/js')
   .react('resources/js/appmarks.js', 'public/js')
   .react('resources/js/appmanagestaff.js', 'public/js') 
   .react('resources/js/apppromotion.js', 'public/js')
   .react('resources/js/appfees.js', 'public/js')  
   .react('resources/js/appresult.js', 'public/js')
   .react('resources/js/appformmaster.js', 'public/js') 
   .react('resources/js/appaddstudent.js', 'public/js')  
   .sass('resources/sass/app.scss', 'public/css');
