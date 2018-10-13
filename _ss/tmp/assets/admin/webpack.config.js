let Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('../public/build/admin')
    .setPublicPath('/build/admin')
    .setManifestKeyPrefix('')
	.enableSassLoader()
    .cleanupOutputBeforeBuild()
    .createSharedEntry('base', './js/base.js')
	.addEntry('admin', './js/admin.js')
    .autoProvidejQuery()
    .enableReactPreset()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
;

module.exports = Encore.getWebpackConfig();
