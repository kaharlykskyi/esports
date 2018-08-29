<?php

namespace app\controllers;

use app\models\Tournaments;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Teams;
use app\models\Games;
use app\models\User;
use app\models\TournamentData;
use app\models\UserTeam;
use app\models\Stream;
use app\models\TournamentTeam;
use app\models\TournamentUser;
use Yii;
use yii\web\HttpException;

class TournamentsController extends \yii\web\Controller
{

    public function actionPublic($id)
    {
        $model = Tournaments::findOne($id);
        if (!is_object($model)) {
           throw new HttpException(404 ,'Page not found');
        }
        if(Yii::$app->request->isPost){

            if ($model->load(Yii::$app->request->post())) {
                    $post = Yii::$app->request->post();
                    $model->data = json_encode($post['Data']);

                if($model->save()) {
                   
                    foreach ($post['Data'] as $key => $value ) {
                        $tournament_data = new TournamentData();
                        $tournament_data->tournament_id = $model->id;
                        $tournament_data->name = $key;
                        $tournament_data->value = $value;
                        $tournament_data->save();
                    }
                    
                    Yii::$app->session->setFlash('success', 'Tournament settings updated');
                    return $this->redirect('/tournaments/public/'.$model->id.'#manage_tournament');
                }
            }
        }

        $teams = (new \yii\db\Query())->select(['*'])->from('teams')//Teams::find()
            ->leftJoin('tournament_team', 'tournament_team.team_id = teams.id')
            ->where(['tournament_team.status' => TournamentTeam::ACCEPTED,'tournament_team.tournament_id' => $model->id])->all();
        $users = (new \yii\db\Query())->select(['*'])->from('users')//User::find()
            ->leftJoin('tournament_user', 'tournament_user.user_id = users.id')
            ->where(['tournament_user.status' => TournamentUser::ACCEPTED,'tournament_user.tournament_id' => $model->id])->all();
        $players = array_merge($teams,$users);

        return $this->render('index',compact('model','players'));
    }

    public function actionCreate()
    {
    	$games = Games::find()->all();
    	$model = new Tournaments();
    	if (Yii::$app->request->isPost) {


    		if ($model->load(Yii::$app->request->post())) {
                $model->user_id = Yii::$app->user->identity->id;
    			if($model->save()) {
                    $post = Yii::$app->request->post();
                    if(!empty($post['stream_chanal'])) {
                       $i = count($post['stream_chanal']);
        
                       for ($a=0; $a < $i; $a++) { 
                            $stream = new Stream();
                            $stream->tournament_id = $model->id;
                            $stream->stream_chanal = $post['stream_chanal'][$a];
                            $stream->stream_url = $post['stream_url'][$a];
                            $stream->save();
                       }
                    } 
    				return $this->redirect('/tournaments/public/'.$model->id.'#manage_tournament');
    			}
    		}
    	}
        return $this->render('create-tournament',compact('model','games'));
    }


    public function actionInvitation ($tokin,$tournament,$team = false)
    {

        $tournament = Tournaments::findOne($tournament);
        $user = Yii::$app->user->identity;
        if (!is_object($tournament)) {
            throw new HttpException(404 ,'Page not found');
        }
        
        if ($team) {
            $model = TournamentTeam::find()
                ->where(['tournament_id'=> $tournament->id])
                ->andWhere(['tokin' => $tokin])
                ->andWhere(['team_id' => $team])
                ->andWhere(['status' => TournamentTeam::SENT])
                ->one();
            
        } else {
            $model = TournamentUser::find()
                ->where(['tournament_id'=> $tournament->id])
                ->andWhere(['tokin' => $tokin])
                ->andWhere(['user_id' => $user->id])
                ->andWhere(['status' => TournamentUser::SENT])
                ->one();
        }
        if (!is_object($model)) {
            throw new HttpException(404 ,'Page not found');
        }
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();

            if (isset($post['ACCEPT'])) {
                $model->status = 2;
                $model->tokin = 'ok';
                $model->save();
            }

            if (isset($post['DECLINE'])) {
                $model->status = 3;
                $model->tokin = 'ok';
                $model->save();
            }
            return $this->redirect('/profile#tournaments');

        }
            // echo "<pre>";
            // print_r($tournament);
            // echo "</pre>";exit;
        return $this->render('confirmation',compact('tournament','tokin','team'));
    }

}
