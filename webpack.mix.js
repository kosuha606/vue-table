
const mix = require('laravel-mix');

mix
    .setPublicPath('dist')
    .js('src/app.js', '')
    .version()
;

