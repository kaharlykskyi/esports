<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Teams;
use app\models\Games;
use app\models\UserTeam;
use Yii;
use app\models\User;

class AjaxController extends \yii\web\Controller
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
    public function beforeAction($action)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    public function actionGetUsers()
    {
        $post = Yii::$app->request->post();
         if (!empty($post['search'])) {
            $team = UserTeam::find()->where(['!=', 'id_team',$post['team']])->all();
            $not_users = [];
                foreach($team as $value){
                $not_users = $value['id_user'];
            }
            $user = User::find()->select(['id','name'])
            ->where(['not in', 'id', $not_users])
            ->andWhere(['LIKE', 'name', $post['search']])
            ->andWhere(['visible' => 1])->all();
            
            return $user;
        }
    }

}
