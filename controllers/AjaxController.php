<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Teams;
use app\models\Games;
use app\models\UserTeam;
use Yii;
use app\models\User;
use yii\helpers\Url;
use yii\helpers\Html;

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
         // $post['search'] = 'v';
         // $post['team'] = 4;
        $post = Yii::$app->request->post();
         if (!empty($post['search'])) {
            $game = Teams::findOne($post['team'])->game->id;
            $team = UserTeam::find()->select(['id_user'])
            ->leftJoin('teams', '`teams`.`id` = `user_team`.`id_team`')
            ->leftJoin('games', '`games`.`id` = `teams`.`game_id`')
            ->where(['games.id'=> $game])
            ->asArray()->all();
            $not_users = [];
                foreach($team as $value){
                $not_users[] = $value['id_user'];
            }
            $user = User::find()->select(['id','name', 'username'])
            ->where(['not in', 'id', $not_users])
            ->andWhere(['LIKE', 'name', $post['search']])
            ->andWhere(['visible' => 1])->asArray()->all();

            $user_not_accept = (new \yii\db\Query())->select(['users.id' ,'name','status', 'username'])
            ->from('users')->leftJoin('user_team', 'user_team.id_user = users.id')
            ->where(['!=','status' , UserTeam::ACCEPTED])
            ->andWhere(['users.visible' => 1])
            ->andWhere(['LIKE', 'name', $post['search']])
            ->andWhere(['user_team.id_team' => $post['team']])->all();

            $all_user = array_merge($user_not_accept, $user);
            if (empty($all_user)) {
                $all_user = ['not'=>true];
            }
            // echo "<pre>";
            //     print_r($all_user);
            // echo "</pre>";exit;
            return $all_user;
       }
    }

    public function actionSentUsers()
    {
        $post = Yii::$app->request->post();
         if (!empty($post['id_user']) && !empty($post['id_team']) ) {
            $stringTokin = (string)bin2hex(random_bytes(24));
            $user_team = UserTeam::find()->where(['id_user' => $post['id_user']])->andWhere(['id_team' => $post['id_team'],])->one();
            if (!is_object($user_team)) {
                $user_team = new UserTeam();
                $user_team->id_user = $post['id_user'];
                $user_team->id_team = $post['id_team'];
            }        
            $user_team->status = UserTeam::SENT;
            $user_team->status_tokin = $stringTokin;
            if ($user_team->save()) {
                $user = User::findOne($post['id_user']);
                $team = Teams::findOne($post['id_team']);
                $capitanEmail = (User::findOne($team->capitan))->email;
                if (is_object($user)) {
                    $url = Url::toRoute(['profile/confirmation-team','confirmation_tokin'=> $stringTokin, 'email' => $user->email,], true);
                    $a = Html::a($url,$url);
                    $inviteHtml = Teams::getInviteEmailHtml($a, $user, $team, $capitanEmail);
                    Yii::$app->mailer->compose()
                        ->setFrom([Yii::$app->params['adminEmail'] => 'The organization'])
                        ->setTo([$user->email => $user->name])
                        ->setSubject("New invitation to the $team->name team")
                        ->setTextBody("New invitation to the $team->name team")
                        ->setHtmlBody($inviteHtml)
                        ->send();    
                }
            }
        }
    }

}
