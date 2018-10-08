<?php

namespace app\modules\admin;


class AdminModule extends \yii\base\Module
{

    public $controllerNamespace = 'app\modules\admin\controllers';


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
                    'path' => '/admin',
                ],
                'loginUrl' => ['admin/site/login'],
            ],
            'session' => [
                'class' => 'yii\web\Session',
                'name' => 'admin-panel',
            ],
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
        
    }
}
