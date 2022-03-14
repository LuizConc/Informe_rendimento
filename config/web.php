<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => getenv('APP_ID'),
    'basePath' => dirname(__DIR__),
    'language' => 'pt-BR',
    'sourceLanguage' => 'pt-BR',
    'timezone' => 'America/Sao_Paulo',
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'OdZJ6v98b9gsJWtKRVP2re6sisY-NS17',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'webservice' => [
            'class' => 'app\components\WebserviceComponent',
            'user' => getenv('WS_USER'),
            'password' => getenv('WS_PASSWORD')
        ],
        'user' => [
            'identityClass' => 'app\models\Auth',
            'enableAutoLogin' => true,
            'loginUrl' => ['auth/index'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            'bundles' => [
                'yii\bootstrap4\BootstrapAsset' => [
                    'sourcePath' => '@npm/bootstrap/dist',
                    'css' => [],
                ],
                'yii\bootstrap4\BootstrapPluginAsset' => [
                    'sourcePath' => '@npm/bootstrap/dist',
                    'css' => [],
                ],
                'yii\bootstrap4\BootstrapThemeAsset' => [
                    'sourcePath' => '@npm/bootstrap/dist',
                    'css' => [],
                ],
            ],
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'pattern' => '/informe-rendimento',
                    'route' => 'site/reports',
                ],
                [
                    'pattern' => '/holerite',
                    'route' => 'site/holerite',
                ],
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
