<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Teams;
use app\models\Games;
use app\models\UserTeam;
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

    public function actionCreateTeam()
    {
		$id = Yii::$app->user->identity->id;
		$games = Games::find()->leftJoin('teams', '`teams`.`game_id` = `games`.`id`')
		->leftJoin('user_team', '`user_team`.`id_team` = `teams`.`id`')
		->where(['user_team.id_user' => $id])->asArray()->all();
		$not_gemes = [];
		foreach($games as $value){
			$not_gemes[] = $value['id'];
		}
		
		$not_gemes = Games::find()->where(['not in', 'id', $not_gemes])->all();;

        $model = new Teams();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                // form inputs are valid, do something here
                return;
            }
        }

        return $this->render('createteam', compact('model','not_gemes') );
    }


}
