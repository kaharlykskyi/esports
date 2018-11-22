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
use app\models\UsetTeamTournament;


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

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex($slug)
    {
        $team = Teams::find()->where(['slug'=>$slug])->one();
        if (!is_object($team)) {
           throw new HttpException(404 ,'Page not found');
        }
        $members = $team->getMembers();
        return $this->render('team', compact(['team', 'members']));
    }


    public function actionContact($id)
    {
        if (Yii::$app->request->isPost) {
            $user = User::find()
                ->leftJoin('teams', '`teams`.`capitan` = `users`.`id`')
                ->where(['teams.id'=> $id])->one();
            $post = Yii::$app->request->post();
            $team = Teams::findOne($id);
            Yii::$app->mailer->compose()
                ->setFrom([Yii::$app->params['adminEmail'] => Yii::t('app','The organization')])
                ->setTo([$user->email => $user->name])
                ->setSubject(Yii::t('app','Message from the user') ." ".$post['name'])
                ->setTextBody(Yii::t('app','Message from the user') ." ".$post['name'])
                ->setHtmlBody('<p>'.$post["message"].'</p><p>'.Yii::t('app','Mail of the user').' '.$post["email"].'</p>')
                ->send(); 
            Yii::$app->session->setFlash('success', '<p>'.Yii::t('app','Email sent').' </p>'); 
        }
        return $this->redirect("/teams/{$team->slug}");
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
                        Yii::$app->session->setFlash('warning', 
                            Yii::t('The team of the {name} is remote',['name' => '<b>'.$team_name.'</b>']));
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
