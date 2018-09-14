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
use app\models\TournamentCupTeam;
use Yii;
use yii\web\HttpException;

class TournamentsController extends \yii\web\Controller
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
        $model = Tournaments::findOne($id);
        if (!is_object($model)) {
           throw new HttpException(404 ,'Page not found');
        }
        if(Yii::$app->request->isPost){

            if ($model->load(Yii::$app->request->post())) {
                    $post = Yii::$app->request->post();
                    if (!empty($post['Data'])) {
                        $model->data = json_encode($post['Data']);
                    }
                    
                if($model->save()) {
                   
                    // foreach ($post['Data'] as $key => $value ) {
                    //     $tournament_data = new TournamentData();
                    //     $tournament_data->tournament_id = $model->id;
                    //     $tournament_data->name = $key;
                    //     $tournament_data->value = $value;
                    //     $tournament_data->save();
                    // }
                    
                    Yii::$app->session->setFlash('success', 'Tournament settings updated');
                    return $this->redirect('/tournaments/public/'.$model->id.'#manage_tournament');
                }
            }
        }

 
        $players = $model->getPlayers();
        $users_id = self::gerUsers($model);
       
        return $this->render('index',compact('model','players','users_id'));
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
        if (!is_null($tournament->state)) {
            throw new HttpException(404 ,'Page not found');
        }
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();

            if(!$team && isset($post['ACCEPT'])){
                $team_one_usr = new Teams();
               // $team_one_usr->name = 
            }

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
        return $this->render('confirmation',compact('tournament','tokin','team'));
    }

    public function actionAddSchedule($id)
    {

        $mass = $this->getTeams($id);
        list('players' => $players, 'model' => $model) = $mass;

        $a = count($players)/2;
        $cup["teams"] = [];
        for ($i=0; $i < $a; $i++) { 
            $player_1 = array_pop($players);
            $player_2 = array_pop($players);
            $cup["teams"][] = [$player_1,$player_2];
        }
        $result = $model->createSchedule($cup["teams"],1);
        $cup["results"][] = $result;
        if($model->format == Tournaments::DUBLE_E){
            $cup["results"] = [[[[]]], [], []];
        }

        $model->cup = json_encode($cup);
        $model->state = 1;
        $model->save(false);
            
        return $this->redirect('/tournaments/public/'.$model->id.'#tournamentgrid');  
        
    }

    public function actionAddLeague($id)
    {
        $model = Tournaments::findOne($id);
        if (!is_object($model)) {
           throw new HttpException(404 ,'Page not found');
        }
        $model->state = 1;

        $model->createLeague();
        return $this->redirect('/tournaments/public/'.$id.'#matches');
    }

    private function getTeams($id)
    {

        $model = Tournaments::findOne($id);
        if (!is_object($model)) {
           throw new HttpException(404 ,'Page not found');
        }
        $teams = (new \yii\db\Query())->select(['teams.name','teams.id','teams.logo'])->from('teams')
            ->leftJoin('tournament_team', 'tournament_team.team_id = teams.id')
            ->where(['tournament_team.status' => TournamentTeam::ACCEPTED,'tournament_team.tournament_id' => $id])
            ->all();
        $players = $teams;
        shuffle($players);
        return compact('players','model');
    }


    // public function actionQwert($id)
    // {
    //     $model = Tournaments::findOne($id);
    //     $model->createLeague();
    // }
}
