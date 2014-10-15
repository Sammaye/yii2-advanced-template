<?php
return [
	'timeZone' => 'Europe/London',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'extensions' => require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'request' => [
        	'enableCsrfValidation' => false
        ],
        'mailer' => [
	        'viewPath' => '@common/mails',
        ],
    ],
];
