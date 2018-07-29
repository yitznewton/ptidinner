var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('web/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/js/base.js')
    //.autoProvidejQuery()
    .enableSourceMaps(!Encore.isProduction())
    .cleanupOutputBeforeBuild()

    // create hashed filenames (e.g. app.abc123.css)
    .enableVersioning()

    .enableSassLoader()
;

// export the final configuration
module.exports = Encore.getWebpackConfig();
