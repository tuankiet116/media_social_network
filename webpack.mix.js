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
    .vue({ __VUE_PROD_DEVTOOLS__: true });

mix.js('resources/js/bootstrap.js', 'public/js')
    .sass('resources/sass/bootstrap.scss', 'public/css');

mix.sass('resources/sass/bulma.scss', 'public/css');

mix.js('Modules/User/Resources/assets/js/userAuth.js', 'js/userAuth.js')
    .css('Modules/User/Resources/assets/css/userAuth.css', 'css/userAuth.css');

mix.js('Modules/User/Resources/assets/js/particles.js', 'js/particles.js');

mix.js('Modules/User/Resources/assets/js/accountSetting.js', 'js/accountSetting.js')
    .css('Modules/User/Resources/assets/css/accountSetting.css', 'css/accountSetting.css');

mix.sass('resources/css/common_vue.scss', 'css/common.css');

mix.copy('resources/images', 'public/images');
