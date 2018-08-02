<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

class ProfileController extends \yii\web\Controller
{
	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action)
	{
        if (!Yii::$app->user->isGuest) {
            if (!Yii::$app->user->identity->is_verified) {
                $email = Yii::$app->user->identity->email;
                $a_email = '<a href="http://'.$email.'">'.$email.'</a>';
                Yii::$app->session->setFlash('error', 'Please confirm you email !   '.$a_email);
            }
        }
 		
 		return parent::beforeAction($action);
	}

    public function actionIndex()
    {
        return $this->render('index');
    }

}
