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

mix.js('resources/js/app.js', 'public/vue/js')
    .vue({ __VUE_PROD_DEVTOOLS__: true});

mix.js('resources/js/bootstrap.js', 'public/js')
    .sass('resources/sass/bootstrap.scss', 'public/css');

mix.sass('resources/sass/bulma.scss', 'public/css');

mix.js('Modules/User/Resources/assets/js/app.js', 'js/userLogin.js')
    .css('Modules/User/Resources/assets/css/app.css', 'css/userLogin.css');

mix.css('resources/css/common_vue.css', 'css/common.css');

mix.copy('resources/images', 'public/images');