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
use app\models\SponsorTeam;


class TeamController extends \yii\web\Controller
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

    public function actionDeleteTeam ($confirmation_tokin, $id_user_team) 
    {
  
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

    public function actionAddSponsor () 
    {
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $sponsor = new SponsorTeam();
            if ($sponsor->load($post)) {
                $team = Teams::findOne($sponsor->team_id);
                $id_user = Yii::$app->user->identity->id;
                if ($team->capitan == $id_user) {
                    $sponsor->save(false);
                }
            }
            return $this->redirect("/profile/update-team?id={$sponsor->team_id}");
        }
        throw new HttpException(404 ,'Page not found');
    }

    public function actionDeleteSponsor($id)
    {
        $sponsor = SponsorTeam::findOne($id);
        if (is_object($sponsor)) {
            $id_user = Yii::$app->user->identity->id;
            if ($sponsor->team->capitan == $id_user) {
                if($sponsor->delete()) {
                    return $this->redirect("/profile/update-team?id={$sponsor->team_id}");
                }
            }
        }
        throw new HttpException(404 ,'Page not found');
    }





}
