const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js/app.js')
    .js('resources/js/enable-push.js', 'public/js/enable-push.js');

mix.sass('resources/scss/pdf.scss', 'public/css/pdf.css')

mix.disableNotifications()
mix.browserSync({
    proxy: {
        target: "https://v2.fintech.ovh",
        ws: true
    }
});
