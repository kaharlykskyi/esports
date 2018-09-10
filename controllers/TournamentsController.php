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

        $teams = (new \yii\db\Query())->select(['*'])->from('teams')
            ->leftJoin('tournament_team', 'tournament_team.team_id = teams.id')
            ->where(['tournament_team.status' => TournamentTeam::ACCEPTED,'tournament_team.tournament_id' => $model->id])
            ->all();
        $users = (new \yii\db\Query())->select(['*'])->from('users')
            ->leftJoin('tournament_user', 'tournament_user.user_id = users.id')
            ->where(['tournament_user.status' => TournamentUser::ACCEPTED,'tournament_user.tournament_id' => $model->id])
            ->all();
        $players = array_merge($teams,$users);
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
        if (!empty($tournament->cup) || !empty($tournament->league)) {
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
            
        return $this->render('confirmation',compact('tournament','tokin','team'));
    }

    public function actionAddSchedule($id)
    {

        $mass = $this->getUsetTeams($id);
        list('players' => $players, 'model' => $model) = $mass;

        $a = count($players)/2;
        $cup["teams"] = [];
        for ($i=0; $i < $a; $i++) { 
            $player_1 = array_pop($players);
            $player_2 = array_pop($players);
            $cup["teams"][] = [$player_1,$player_2];
        }

        $cup["results"][] = [];
        if($model->format ==2){
            $cup["results"] = [[[[]]], [], []];
        }
        $model->cup = json_encode($cup);
        if($model->save(false)){
            if ($model->format == Tournaments::SINGLE_E) {
                $model->getScheduleCupSingle();
            }
            if ($model->format == Tournaments::DUBLE_E) {
                $model->getScheduleCupDuble();
            }
            $model->save(false);
        }
        return $this->redirect('/tournaments/public/'.$model->id.'#tournamentgrid');  
        
    }

    public function actionAddLeague($id)
    {
        
        $mass = $this->getUsetTeams($id);
        list('players' => $players, 'model' => $model) = $mass;
        $c = count($players);
        $ch = $c%2 == 0 ? 1 : 0;
        $c_block = [];
        $players_turs = [];

        if ( $model->format == Tournaments::LEAGUE_G ) {
            if (!$ch) {
                return $this->redirect('/tournaments/public/'.$id.'#matches');
            }

            $group = $c/$model->league_g;
            for ($d=0; $d < $group; $d++) {
                $group_mas = []; 
                for ($dc=0; $dc < $model->league_g; $dc++) { 
                    $group_mas[] = array_pop($players);
                }
                $c_block[] = $group_mas;
            }
            $model->league_table = json_encode($c_block);
            for ($i=0; $i < $group; $i++) { 
                $players_turs[] = $this->generateLeague($c_block[$i],$ch,$model);
            }
        }
        
        if (($model->format == Tournaments::LEAGUE_P) || ($model->format == Tournaments::LEAGUE)) {
            $players_turs = $this->generateLeague($players,$ch,$model);
            $model->league_table = json_encode($players);
        }   

        if ((Yii::$app->user->identity->id == $model->user_id) && empty($model->league)) {
            $model->league = json_encode($players_turs);
            if ( isset($model->league_p) && (($model->format == Tournaments::LEAGUE_P) || ($model->format == Tournaments::LEAGUE_G))) {
                $cup["teams"] = [];
                $count_p = $model->league_p/2;
                for ($i=0; $i < $count_p; $i++) { 
                    $cup["teams"][] = [['BYE'],['BYE']];
                }
                $cup["results"][] = [];
                $model->cup = json_encode($cup);
            }
            $model->save(false);
        }
        return $this->redirect('/tournaments/public/'.$id.'#matches');
    }

    private function getUsetTeams($id)
    {

        $model = Tournaments::findOne($id);
        if (!is_object($model)) {
           throw new HttpException(404 ,'Page not found');
        }
        $teams = (new \yii\db\Query())->select(['teams.name','teams.id','teams.logo'])->from('teams')
            ->leftJoin('tournament_team', 'tournament_team.team_id = teams.id')
            ->where(['tournament_team.status' => TournamentTeam::ACCEPTED,'tournament_team.tournament_id' => $id])
            ->all();
        $users = (new \yii\db\Query())->select(['users.name','users.id'])->from('users')
            ->leftJoin('tournament_user', 'tournament_user.user_id = users.id')
            ->where(['tournament_user.status' => TournamentUser::ACCEPTED,'tournament_user.tournament_id' => $id])
            ->all();
        $players = array_merge($teams,$users);
        shuffle($players);
        return compact('players','model');
    }

    private function generateLeague($players,$ch,$model)
    {
            $c = count($players);
            $players_turs = [];
            if (!$ch) {
                array_unshift($players, ['name'=>'bolvan']);
            }
            $a =$c/2;
            $mass_temp = [];
            for ($int=1; $int <= $c; $int++) { 
                $mass_temp[] = $int;
            }
            $b =$c-1;
            
            for ($c=0; $c < $b; $c++) { 
                $turs = [];
                for ($i=0; $i < $a; $i++) { 
                    $date = new \DateTime($model->start_date);
                    $date->add(new \DateInterval('P'.($c*$model->match_schedule).'D'));
                    $date = $date->format('Y-m-d H:i'); 
                   $turs[] = [
                        'players1' => $players[$mass_temp[$i]-1],
                        'players2' => $players[$mass_temp[$i+$a]-1],
                        'result1'  => 0,
                        'result2'  => 0,
                        'date' => $date,
                    ];
                }
                $players_turs[] = $turs;
                $output1 = array_slice($mass_temp, $a);
                $output2 = array_slice($mass_temp, 1,$a-1);
                $output3 = array_merge($output1,$output2);
                array_unshift($output3, $mass_temp[0]);
                $mass_temp = $output3;
            }
            if(!$ch){
                foreach ($players_turs as &$value) {
                   unset($value[0]);
                }
            }
        return $players_turs;
    }


    public function actionQwert($id)
    {
        $model = Tournaments::findOne($id);
        $model->getScheduleCupDudle();
    }
}
