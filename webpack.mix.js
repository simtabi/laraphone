const mix = require('laravel-mix');

mix
    .js('resources/assets/js/laraphone.js', 'public/js')
    .js('resources/assets/js/intl-tel-input-utils.js', 'public/js')
    .postCss("resources/assets/css/laraphone.css", "public/css", [
        // require("tailwindcss"),
    ]);