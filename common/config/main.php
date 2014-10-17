<?php
return [
	'timeZone' => 'Europe/London',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'extensions' => require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
    'components' => [
    	'user' => [
			'class' => 'common\components\User',
			'identityClass' => 'common\models\User',
			'enableAutoLogin' => true,
		],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
	        'viewPath' => '@common/mails',
        ],
        'assetManager' => [
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
	        ],
        ],
        'authManager' => [
	        'class' => 'common\components\PhpManager',
	        'defaultRoles' => ['guest'],
	        'ruleFile' => '@common/rbac/rules.php',
	        'itemFile' => '@common/rbac/items.php'
        ],
        'urlManager' => [
	        'enablePrettyUrl' => true,
	        'showScriptName' => false,
	        'cache' => null,
	        'rules' => [
		        '<controller:[\w-]+>/<id:\d+>'=>'<controller>/view',
		        '<controller:[\w-]+>/<action:[\w-]+>/<id:\d+>'=>'<controller>/<action>',
		        '<controller:[\w-]+>/<action:[\w-]+>'=>'<controller>/<action>',
		        // your rules go here
	        ]
        ],
    ],
];