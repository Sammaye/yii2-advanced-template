<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
    	'session' => [
    		'cookieParams' => [],
    		'name' => 'sess_cookie'
    	],
        'user' => [
            'enableTier2' => true,
            'tier2Timeout' => 3600 /* 10 mins */
        ],
        'request' => [
        	'class' => 'common\components\Request',
        	'enableCsrfValidation' => true,
        	'csrfRoutes' => [
		        'site/login',
		        'site/signup',
		        'site/request-password-reset',
		        'site/reset-password',
		        'site/confirm-login'
        	],
        	'cookieValidationKey' => $params['request.cookieValidationKey']
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
