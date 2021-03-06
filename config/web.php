<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],

    'modules' => [

            'forum' => [
                'class' => 'app\modules\forum\ForumModule',
            ],

            'admin' => [
                'class' => 'app\modules\admin\AdminModule',
            ],
    
    ],
    'on beforeAction' => function ($event) {
        \Yii::$app->params['domains'] = (explode(".",\Yii::$app->request->hostName))[0];
        $cookies = \Yii::$app->request->cookies;
        if ($cookies->has('language')) {
            $language = $cookies->getValue('language', 'en-EN');
            \Yii::$app->language = $language;
        }
    },

    'components' => [

        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/translations',
                    'sourceLanguage' => 'en',
                ],
            ],
        ],
        
        'image' => [
            'class' => 'yii\image\ImageDriver',
            'driver' => 'GD',  //GD or Imagick
        ],

        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'wYkq3YwVx2nPc2fVPFRhacC9YcTbJcNe',
            'baseUrl' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity-site', 
                'httpOnly' => true,
                'path' => '/',
            ],

        ],
        'session' => [
                'class' => 'yii\web\Session',
                'name' => 'esports',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'gemer.bumeen.group@gmail.com',
                'password' => $params['emailPass'],
                'port' => '587',
                'encryption' => 'tls',
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
                '<module:forum>/<id:\d+>' => '<module>/default/index',
                '<module:forum>/<action:[A-Z,a-z,-]+>/<id:\d+>' => '<module>/default/<action>',
                '3kljs89s' => 'admin/user/index',
                '3kljs89s/<action:[A-Za-z0-9,-]+>' => 'admin/site/<action>',
                '3kljs89s/<controller>/<action:[A-Z,a-z,-]+>' => 'admin/<controller>/<action>',
                '<controller:(profile|teams|tournaments)>' => '<controller>/index',
                
                '<action:[A-Z,a-z,-]+>' => 'site/<action>',
                '<controller>/<action:[A-Z,a-z,-]+>/<id:\d+>' => '<controller>/<action>',
                '<controller>/<action:[A-Z,a-z,-]+>/<alias:\w+>' => '<controller>/<action>',
                '<controller:(teams)>/<slug:[A-Z,a-z,-]+>' => '<controller>/index',
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

    $config['components']['assetManager']['forceCopy'] = true;

}

return $config;

