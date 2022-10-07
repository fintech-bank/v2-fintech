const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js/app.js')
    .js('resources/js/enable-push.js', 'public/js/enable-push.js');

mix.disableNotifications()
mix.browserSync({
    proxy: 'v2.fintech.io',
});
