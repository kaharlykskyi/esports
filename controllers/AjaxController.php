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
        // $post['search'] = 'a';
        // $post['team'] = 1;
        $post = Yii::$app->request->post();
         if (!empty($post['search'])) {
            $team = UserTeam::find()->select(['id_user'])
            ->where(['id_team'=> $post['team']])->asArray()->all();
            $not_users = [];
                foreach($team as $value){
                $not_users[] = $value['id_user'];
            }
            $user = User::find()->select(['id','name'])
            ->where(['not in', 'id', $not_users])
            ->andWhere(['LIKE', 'name', $post['search']])
            ->andWhere(['visible' => 1])->asArray()->all();

            $user_not_accept = (new \yii\db\Query())->select(['users.id' ,'name','status'])
            ->from('users')->leftJoin('user_team', 'user_team.id_user = users.id')
            ->where(['!=','status' , UserTeam::ACCEPTED])
            ->andWhere(['users.visible' => 1])
            ->andWhere(['LIKE', 'name', $post['search']])
            ->andWhere(['user_team.id_team' => $post['team']])->all();

            $all_user = array_merge($user_not_accept, $user);
            if (empty($all_user)) {
                $all_user = ['not'=>true];
            }
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
                if (is_object($user)) {
                    $url = Url::toRoute(['profile/confirmation-team','confirmation_tokin'=> $stringTokin,'email' => $email,], true);
                    $a = Html::a($url,$url);
                    Yii::$app->mailer->compose()
                        ->setFrom(Yii::$app->params['adminEmail'])
                        ->setTo($user->email)
                        ->setSubject('Invitation to the team')
                        ->setTextBody('Invitation to the team '.$team->name)
                        ->setHtmlBody('<p>You are invited to join the team <b>'.$team->name.'</b> for confirmation or for rejection click on the link '.$a.'</p>')
                        ->send();    
                }
            }
        }
    }

}
