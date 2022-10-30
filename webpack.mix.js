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

mix.js('Modules/User/Resources/assets/js/app.js', 'js/userLogin.js')
    .css('Modules/User/Resources/assets/css/app.css', 'css/userLogin.css');

mix.css('resources/css/common_vue.css', 'css/common.css');

mix.copy('resources/images', 'public/images');

const { styles } = require('@ckeditor/ckeditor5-dev-utils');
const path = require('path');

module.exports = function (config) {
  // Your existing rules (example)
  config.module.rules.push(
    {
        test: /\.css$/,
        use: [
          {
            loader: 'style-loader',
            options: {
              // `style-loader` options here...
            }
          }
        ]
    }
  );
  
  // Exclude CKEditor files from all existing rules
  config.module.rules
    .filter((rule) => rule.test.test('.css') || rule.test.test('.svg'))
    .forEach((rule) => {
      rule.exclude = rule.exclude ?? [];
      rule.exclude.push(path.join(__dirname, 'node_modules', '@ckeditor'));
    });
  
  // CKEditor rules from the docs
  // https://ckeditor.com/docs/ckeditor5/latest/installation/getting-started/quick-start-other.html#building-the-editor-from-source
  config.module.rules.push(
    {
      test: /ckeditor5-[^/\\]+[/\\]theme[/\\]icons[/\\][^/\\]+\.svg$/,
      use: ['raw-loader'],
    },
    {
      test: /ckeditor5-[^/\\]+[/\\]theme[/\\].+\.css$/,
      use: [
        {
          loader: 'style-loader',
          options: {
            injectType: 'singletonStyleTag',
            attributes: {
              'data-cke': true,
            },
          },
        },
        'css-loader',
        {
          loader: 'postcss-loader',
          options: {
            postcssOptions: styles.getPostCssConfig({
              themeImporter: {
                themePath: require.resolve('@ckeditor/ckeditor5-theme-lark'),
              },
              minify: false,
            }),
          },
        },
      ],
    }
  );
};