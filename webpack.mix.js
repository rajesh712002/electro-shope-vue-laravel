const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .vue() // Enable Vue.js support
   .sass('resources/sass/app.scss', 'public/css');
