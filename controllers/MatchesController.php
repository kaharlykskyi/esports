<?php

namespace app\controllers;

use app\models\Tournaments;
use yii\filters\AccessControl;
use app\models\Teams;
use app\models\Games;
use app\models\User;
use app\models\ResultsStatisticUsers;
use app\models\UserTeam;
use app\models\UsersMatch;
use app\models\TournamentTeam;
use app\models\TournamentUser;
use app\models\TournamentCupTeam;
use Yii;
use yii\web\HttpException;
use app\models\ScheduleTeams;
use app\models\UsetTeamTournament;
use app\models\servises\UserServis;


class MatchesController extends \yii\web\Controller
{
    use \app\models\traits\UserTournament;
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
                    [
                        'allow' => true,
                        'actions' => ['public'],
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    public function actionPublic($id)
    {
        $model = ScheduleTeams::find()->with('userMatch')->where(['id'=>$id])->one();
        if(is_null($model)){
            throw new HttpException(404 ,'Page not found');
        }
        if(Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $model->active_result = 1;
                if (!empty($model->results2)&&!empty($model->results1)) {
                    $model->save();
                }
            }   
            return $this->refresh();
        }
        return $this->render('index',compact('model'));
    }

    public function actionResultUser ()
    {
        if(Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            foreach ($post['user_match'] as $match) {
                if ((isset($match['results2'])) && (isset($match['results1']))) {
                    if(is_numeric($match['results2']) && is_numeric($match['results1'])) {
                        if ($match['results2'] != $match['results1']) {
                            $user_team = UsersMatch::find()->with(['matche','tournament'])
                                ->where(['id' => $match['id']])->one();
                            $user_team->results1 = $match['results1'];
                            $user_team->results2 = $match['results2'];
                            $user_team->save();
                        }
                    }
                }
            }
            UserServis::addTur($post['match'],$post['tournament'],$post['round']);
            return $this->redirect(['public','id'=> $post['match']]);
        }
    }

    public function actionBan ()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id_user = Yii::$app->user->identity->id;
        //$id_user =12;
        $post = Yii::$app->request->post();
        $user_match = UsersMatch::findOne($post['user_match']);
        if (!is_object($user_match)) {
            return ['result'=> false];
        }
        $data = json_decode($user_match->data,true);
        if ($user_match->user1 == $post['user']) {
            $i='user1';
        } elseif ($user_match->user2 == $post['user']) {
            $i='user2';
        }
        $data[2][$i] = $post['cart_class'];
        $user_match->data = json_encode($data);
        if(($id_user == $user_match->user2)||($id_user == $user_match->user1)){
            if ($user_match->save()) {
                return ['result'=> true];
            }
        }
        return ['result'=> false];
    }

}