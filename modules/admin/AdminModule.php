<?php

namespace app\modules\admin;


class AdminModule extends \yii\base\Module
{

    public $controllerNamespace = 'app\modules\admin\controllers';
    public $defaultRoute = 'user';

    public function init()
    {
        parent::init();

        $components = [
            'user' => [
                'class' => 'yii\web\User',
                'identityClass' => 'app\modules\admin\models\Admin',
                'enableAutoLogin' => true,
                'idParam' => '_admin_id',
                'identityCookie' => [
                    'name' => '_tidentity-admin', 
                    'httpOnly' => true,
                    'path' => '/3kljs89s',
                ],
                'loginUrl' => ['admin/site/login'],
            ],

            'errorHandler' => [
                'class' => 'yii\web\ErrorHandler',
                'errorAction' => '/admin/site/error',
            ],

            // 'session' => [
            //     'class' => 'yii\web\Session',
            //     'name' => 'admin-panel',
            // ],
        ];
        $params = [
            'layout' => 'main',
            'as access'=> [
                'class' => 'yii\filters\AccessControl',
                'except' => ['site/login'],
                'rules' => [
                    [
                            'allow' => true,
                            'roles' => ['@'],
                    ],
                ],
            ],
        ];

        \Yii::$app->setComponents($components);
        \Yii::configure($this, $params);

        $handler = $this->get('errorHandler');
        \Yii::$app->set('errorHandler', $handler);
        $handler->register();
        
    }
}
