<?php
/**
 * Configuration file for the "yii asset" console command.
 * Note that in the console environment, some path aliases like '@webroot' and '@web' may not exist.
 * Please define these missing path aliases.
 */

Yii::setAlias('@webroot', realpath(__DIR__ . '/../web'));
Yii::setAlias('@web', '/');

return [
	// Adjust command/callback for JavaScript files compressing:
	'jsCompressor' => 'java -jar compiler.jar --js {from} --js_output_file {to} --warning_level QUIET',
	// Adjust command/callback for CSS files compressing:
	'cssCompressor' => 'java -jar yuicompressor.jar --type css {from} -o {to}',
	// The list of asset bundles to compress:
	'bundles' => [
		'frontend\assets\AppAsset',
		'yii\web\YiiAsset',
		'yii\web\JqueryAsset',
		'yii\bootstrap\BootstrapAsset',
		'yii\bootstrap\BootstrapPluginAsset'
	],
	// Asset bundle for compression output:
	'targets' => [
		'common\widgets\AllAsset' => [
			'basePath' => '@webroot',
			'baseUrl' => '@web',
			'js' => 'js/all-{hash}.js',
			'css' => 'css/all-{hash}.css',
		],
	],
	// Asset manager configuration:
	'assetManager' => [
		'basePath' => '@webroot/assets',
		'baseUrl' => '@web/assets',
		'bundles' => [
			'yii\bootstrap\BootstrapAsset' => [
				'basePath' => '@webroot',
				'baseUrl' => '@web',
				'sourcePath' => null,
			],
			'yii\bootstrap\BootstrapPluginAsset' => [
				'basePath' => '@webroot',
				'baseUrl' => '@web',
				'sourcePath' => null,
			]
		]
	],
];
