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
use app\models\ScheduleTeams;
use app\models\UsetTeamTournament;
use app\models\servises\ApiString;
use app\models\servises\SerchTournaments;
use app\models\StatisticCardsHearthstone;
use yii\helpers\ArrayHelper;

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
                        'actions' => ['public','cup','index'],
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new SerchTournaments();
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);     
        return $this->render('all_tournaments',
            compact('dataProvider' ,'searchModel', 'params')
        );
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
                } else {
                    $model->data = "";
                }
                    
                if($model->save()) {                    
                    Yii::$app->session->setFlash('success', Yii::t('app','Tournament settings updated'));
                    return $this->redirect('/tournaments/public/'.$model->id.'#manage_tournament');
                }
            }
        }

        $players = $model->getPlayers();
        $users_id = self::gerUsers($model);

        if ($model->private) {
            $ids = ArrayHelper::getColumn($users_id, 'id');
            if (Yii::$app->user->isGuest ||
                !in_array(Yii::$app->user->identity->id, $ids)) {
                return $this->render('private',compact('model'));
            } 
        }
       
        return $this->render('index',compact('model','players','users_id'));
    }

    public function actionCreate()
    {
    	$games = Games::find()->where(['status' => Games::ACTIVE])->all();
    	$model = new Tournaments();
        if(Yii::$app->user->identity->isBaned()) {
            return $this->redirect('/profile');
        }
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
        $team_model = false;
        $tournament = Tournaments::findOne($tournament);
        $user = Yii::$app->user->identity;
        if (!is_object($tournament)) {
            throw new HttpException(404 ,'Page not found');
        }
        
        if ($team) {
            $model = TournamentTeam::find()
                ->where(['tournament_id'=> $tournament->id])
                ->andWhere(['tokin' => $tokin,'team_id' => $team,'status' => TournamentTeam::SENT])
                ->one();

            if (!is_object($model)) {
                throw new HttpException(404 ,'Page not found');
            }
            $team_model = Teams::find()->where(['id'=> $model->team_id])->one();
            if (!is_object($team_model)) {
                throw new HttpException(404 ,'Page not found');
            }
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

        if (!$team && $tournament->isUserInTournament($user->id)) {
                return $this->render('message', ['user' => true]);
        }

        if ($team && $tournament->isUserInTournamentTeam($team_model)) {
            return $this->render('message', ['user' => true ,'team' => true]);
        }

        if ($team && !$tournament->isUserCountInTeam($team_model)) {
            return $this->render('message', ['team' => true]);
        }

        if(Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            if(!$team && isset($post['ACCEPT'])) {
                $team_one_usr = new Teams();
                if ($team_one_usr->dummyTeam($tournament,$user)) {
                    $model->status = 2;
                    $model->tokin = 'ok';
                    $model->save(false);
                }

            } elseif (isset($post['ACCEPT'])) {
                $count = count($post['uset_team_tournament']);
                if ( $count == $tournament->max_players ) {
                    $model->status = 2;
                    $model->tokin = 'ok';
                    if ($model->save()) {
                        $uset_tournament = new UsetTeamTournament();
                        $uset_tournament->seveMembersTournament(
                            $post['uset_team_tournament'],
                            $tournament,$team_model
                        );    
                    }
                }
            }

            if (isset($post['DECLINE'])) {
                $model->status = 3;
                $model->tokin = 'ok';
                $model->save();
            }
            return $this->redirect('/profile#tournaments');
        }  
        return $this->render('confirmation',compact('tournament','tokin','team','team_model'));
    }

    public function actionStart($id)
    {
        $model = Tournaments::findOne($id);
        $user = Yii::$app->user->identity;
        if ( !is_object($model) || $user->id != $model->user_id ) {
           throw new HttpException(404 ,'Page not found');
        } 
        $model->system->start();
        return $this->redirect("/tournaments/public/{$model->id}#matches");
    }

    private function getTeams($id)
    {
        $model = Tournaments::findOne($id);
        if (!is_object($model)) {
           throw new HttpException(404 ,'Page not found');
        }
        $players = Teams::find()
            ->leftJoin('tournament_team', 'tournament_team.team_id = teams.id')
            ->where(['tournament_team.status' => TournamentTeam::ACCEPTED,'tournament_team.tournament_id' => $id])
            ->all();
        shuffle($players);
        return compact('players','model');
    }

    public function actionResults($id,$full = false) //cup
    {
        $model = Tournaments::findOne($id);
            if (!is_object($model)) {
            throw new HttpException(404 ,'Page not found');
        }

        if (!$full) {
            $this->layout = 'result-tournament';
            return $this->render('result',compact('model','full'));
        }
        return $this->render('result-full',compact('model','full'));
        
    }

    public function actionApiString($id) 
    {
        $model = Tournaments::findOne($id);
        if (!is_object($model)) {
           throw new HttpException(404 ,'Page not found');
        }
        
        $user_config = UsetTeamTournament::find()
            ->where(['user_id'=>Yii::$app->user->identity->id,'tournament_id'=>$id])->one();
        if (!is_object($user_config)) {
             throw new HttpException(404 ,'Page not found');
        }

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if (!empty($post['decstring'])) {
                $user_config->text = $post['decstring']; 
                $user_config->save(false);
                if ($model->game_id == 1) {
                    $json_array = json_decode($post['decstring'],true);
                    if (!empty($json_array[1])) {
                       StatisticCardsHearthstone::setCards($json_array[1]);
                    }
                }  
                return $this->redirect('/tournaments/public/'.$model->id);
            }         
        }
        
        if ($model->game_id == 2) {
            return $this->render('api_pokemon',compact('user_config','model'));
        }

        if ($model->game_id == 1) {
            return $this->render('api_hearthstone',compact('user_config','model'));
        }

        if ($model->game_id == 3) {
            return $this->render('api_wow',compact('user_config','model'));
        }
        
    }

    public function actionDelParticipant($tour, $pat) 
    {
        $user = Yii::$app->user->identity;
        if(is_numeric($tour) && is_numeric($pat)) {        
            $tour_team = TournamentTeam::find()->where([
                'and',
                ['team_id' => $pat],
                ['tournament_id' => $tour],
                ['status' =>  TournamentTeam::ACCEPTED]
            ])->one();

            if(is_object($tour_team) && ($tour_team->tournament->user_id == $user->id)) {
                if(!$tour_team->tournament->state) {

                    $transaction = Yii::$app->db->beginTransaction();
                    $delete = UsetTeamTournament::deleteAll([
                        'tournament_id' => $tour, 
                        'team_id' => $pat,
                    ]);
                    if ($tour_team->delete() && $delete) {
                        $transaction->commit();   
                    } else {
                        $transaction->rollback();
                    }
                }
            }
        }
        return $this->redirect('/tournaments/public/'.$tour);     
    }

    public function actionRequestPatric(int $tour, int $team = null) 
    {
        if ($team) {
            $connection = TournamentTeam::find()->where([
                'tournament_id' => $tour,
                'team_id' => $team,
            ])->one();
            if (!is_object($connection)) {
                $connection = new TournamentTeam();
                $connection->team_id = $team;
                $connection->tournament_id = $tour;
            }
        } else {
            $connection = TournamentUser::find()->where([
                'tournament_id' => $tour,
                'user_id' => Yii::$app->user->id,
            ])->one();
            if (!is_object($connection)) {
                $connection = new TournamentUser();
                $connection->user_id = Yii::$app->user->id;
                $connection->tournament_id = $tour;
            }
        }
        $connection->status = 4;
        $connection->save(false);

        return $this->redirect('/tournaments/public/'.$tour);
    }
}
