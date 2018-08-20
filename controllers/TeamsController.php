<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Teams;
use app\models\Games;
use app\models\UserTeam;
use yii\web\HttpException;
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

    public function actionPublic($id)
    {
        $team = Teams::findOne($id);
        if (!is_object($team)) {
           throw new HttpException(404 ,'Page not found');
        }
        $members = $team->getMembers();
        return $this->render('team', compact(['team', 'members']));
    }


    public function actionContact($id)
    {
        if (Yii::$app->request->isPost) {
            $user = User::find()->leftJoin('teams', '`teams`.`capitan` = `users`.`id`')->where(['teams.id'=> $id])->one();
            $post = Yii::$app->request->post();
            
            Yii::$app->mailer->compose()
                ->setFrom([Yii::$app->params['adminEmail'] => 'The organization'])
                ->setTo([$user->email => $user->name])
                ->setSubject("Message from the user  ".$post['name'])
                ->setTextBody("Message from the user ".$post['name'])
                ->setHtmlBody('<p>'.$post["message"].'</p><p>Mail of the user '.$post["email"].'</p>')
                ->send(); 
            Yii::$app->session->setFlash('success', '<p> Email sent </p>'); 
        }
        return $this->redirect(['public','id'=>$id]);
    }

    public function actionDeleteTeam ($confirmation_tokin, $id_user_team) {
  
        $user_team = UserTeam::find()
        ->where(['id' => $id_user_team])
        ->andWhere(['status_tokin' => $confirmation_tokin])->one();
        if (is_object($user_team)) {
            $team = Teams::findOne($user_team->id_team);
            if (is_object($team)) {
                if (Yii::$app->request->isPost) {
                    $team_name = $team->name;
                    if ($team->delete()) {
                        $delete = 1;
                        Yii::$app->session->setFlash('warning', 'The team of the <b>'.$team_name.'</b> is remote');
                        return $this->render('delete-team',compact('delete'));
                    }
                }
                return $this->render('delete-team',compact('confirmation_tokin','team','id_user_team'));
            }
            throw new HttpException(404 ,'Page not found');
        }
        throw new HttpException(404 ,'Page not found');

        
    }


}
