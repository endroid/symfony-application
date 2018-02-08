let Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('../application/public/build/')
    .setPublicPath('/build')
    .setManifestKeyPrefix('build')
    .cleanupOutputBeforeBuild()
    .createSharedEntry('base', './js/base.js')
    .autoProvidejQuery()
    .enableReactPreset()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
;

module.exports = Encore.getWebpackConfig();
