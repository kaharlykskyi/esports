<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Teams;
use app\models\Games;
use app\models\UserTeam;
use Yii;
use app\models\User;

class TeamsController extends \yii\web\Controller
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

   
    // public function actionIndex()
    // {   
    //     return $this->render('index');
    // }

    public function actionPublic($id)
    {
        $team = Teams::findOne($id);
        $members = $team->getMembers();
        return $this->render('team', compact(['team', 'members']));
    }


    public function actionContact($id)
    {
        if (Yii::$app->request->isPost) {
            //Yii::$app->user->identity
            $user = User::find()->leftJoin('teams', '`teams`.`capitan` = `users`.`id`')->where(['teams.id'=> $id])->one();
            $post = Yii::$app->request->post();
            
            Yii::$app->mailer->compose()
                ->setFrom([Yii::$app->params['adminEmail'] => 'The organization'])
                ->setTo([$user->email => $user->name])
                ->setSubject("Message from the user <b>".$post['name'].'</b>')
                ->setTextBody("Message from the user <b>".$post['name'].'</b>')
                ->setHtmlBody('<p>'.$post["message"].'</p><p>Mail of the user '.$post["email"].'</p>')
                ->send(); 
            Yii::$app->session->setFlash('success', '<p> Email sent </p>'); 
        }
        return $this->redirect(['public','id'=>$id]);
    }




}
