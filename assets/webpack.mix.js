let mix = require('laravel-mix');
let JavaScriptObfuscator = require('webpack-obfuscator');
let fs = require( 'fs' );
let path = require( 'path' );
let process = require( "process" );

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */
if(process.env.NODE_ENV == 'production'){
    mix.webpackConfig({
        plugins:[
            new JavaScriptObfuscator({
                rotateUnicodeArray:true,
            })
        ]
    });
}

mix.setResourceRoot('/assets');

mix.js('src/app/app.js','dist/app/')
    .sass('src/app/app.scss','dist/app/app.min.css');

mix.js('src/vendor/vendor.js','dist/vendor/')
    .sass('src/vendor/vendor.scss','dist/vendor/vendor.min.css');

mix.js('src/install/install.js','dist/install/')
    .sass('src/install/install.scss','dist/install/install.min.css');


let arrayOfPath = [
    {
        from : 'src/page/guest/',
        to : 'dist/page/guest/'
    }
];

function buildWay(from,to){
    var files = fs.readdirSync(from);
    files.forEach( function( file, index ) {
        if(path.extname(file) === '.scss'){
            mix.sass(from + file, to);
        }else if(path.extname(file) === '.js'){
            mix.js(from + file, to);
        }else{
            if(path.extname(file) === '')
            {
                buildWay(from+file +"/",to + file + "/")
            }
        }
    });
}

arrayOfPath.forEach(function (pathway) {
    buildWay(pathway.from,pathway.to);
});



    // .extract(['vue','jquery','jquery-ui-bundle','bootstrap','popper.js','toastr','datatables','block-ui','bootstrap-select'])

// Full API
// mix.js(src, output);
// mix.react(src, output); <-- Identical to mix.js(), but registers React Babel compilation.
// mix.preact(src, output); <-- Identical to mix.js(), but registers Preact compilation.
// mix.coffee(src, output); <-- Identical to mix.js(), but registers CoffeeScript compilation.
// mix.ts(src, output); <-- TypeScript support. Requires tsconfig.json to exist in the same folder as webpack.mix.js
// mix.extract(vendorLibs);
// mix.sass(src, output);
// mix.less(src, output);
// mix.stylus(src, output);
// mix.postCss(src, output, [require('postcss-some-plugin')()]);
// mix.browserSync('my-site.test');
// mix.combine(files, destination);
// mix.babel(files, destination); <-- Identical to mix.combine(), but also includes Babel compilation.
// mix.copy(from, to);
// mix.copyDirectory(fromDir, toDir);
// mix.minify(file);
// mix.sourceMaps(); // Enable sourcemaps
// mix.version(); // Enable versioning.
// mix.disableNotifications();
// mix.setPublicPath('path/to/public');
// mix.setResourceRoot('prefix/for/resource/locators');
// mix.autoload({}); <-- Will be passed to Webpack's ProvidePlugin.
// mix.webpackConfig({}); <-- Override webpack.config.js, without editing the file directly.
// mix.babelConfig({}); <-- Merge extra Babel configuration (plugins, etc.) with Mix's default.
// mix.then(function () {}) <-- Will be triggered each time Webpack finishes building.
// mix.dump(); <-- Dump the generated webpack config object t the console.
// mix.extend(name, handler) <-- Extend Mix's API with your own components.
// mix.options({
//   extractVueStyles: false, // Extract .vue component styling to file, rather than inline.
//   globalVueStyles: file, // Variables file to be imported in every component.
//   processCssUrls: true, // Process/optimize relative stylesheet url()'s. Set to false, if you don't want them touched.
//   purifyCss: false, // Remove unused CSS selectors.
//   terser: {}, // Terser-specific options. https://github.com/webpack-contrib/terser-webpack-plugin#options
//   postCss: [] // Post-CSS options: https://github.com/postcss/postcss/blob/master/docs/plugins.md
// });
