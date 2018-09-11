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
use app\models\Tournaments;
use app\models\TournamentUser;
use app\models\TournamentTeam;
use app\models\TournamentCupTeam;

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
                    [
                        'allow' => true,
                        'actions' => ['search-bar'],
                        'roles' => ['?'],
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

    public function actionDeliteTeam()
    {
        $post = Yii::$app->request->post();
        if (isset($post['id'])) {
            $team = Teams::findOne($post['id']);
            $user_team = UserTeam::find()
                ->where(['id_user' => $team->capitan])
                ->andWhere(['id_team' => $post['id']])->one();
            if (is_object($user_team)) {
                $stringTokin = 'del'.(string)bin2hex(random_bytes(24));
                $user_team->status_tokin = $stringTokin;
                if ($user_team->save()) {
                    $user = Yii::$app->user->identity;
                    $url = Url::toRoute(
                        ['teams/delete-team','confirmation_tokin'=> $stringTokin,
                        'id_user_team' => $user_team->id], true);
                    $a = Html::a($url,$url);
                    $deleteHtml = Teams::sentDeleteHtml($a,$user, $team);
                    Yii::$app->mailer->compose()
                        ->setFrom([Yii::$app->params['adminEmail'] => 'Captain of the team '.$team->name])
                        ->setTo([Yii::$app->params['EmailModerator']])
                        ->setSubject("Request for deletion $team->name team")
                        ->setTextBody("Request for deletion $team->name team")
                        ->setHtmlBody($deleteHtml)
                        ->send();    
                    return ['del'=>true];
                }
            } 
        }
        
    }

    public function actionGetTeams () 
    {
        $post = Yii::$app->request->post();
        //$post['search'] = 's';
        $id = Yii::$app->user->identity->id;
        
        $not_games = (new \yii\db\Query())->select(['games.id'])->from('games')
            ->leftJoin('teams', '`teams`.`game_id` = `games`.`id`')
            ->leftJoin('user_team', '`user_team`.`id_team` = `teams`.`id`')
            ->where(['user_team.id_user' => $id])
            ->andWhere(['user_team.status' => UserTeam::ACCEPTED ]);

        $teams = (new \yii\db\Query())
            ->select(['teams.*' ,'games.name as g_name','tournaments.name as turname','tournaments.id as turid',
            '(select count(*) from user_team where id_team = teams.id and status = '.UserTeam::ACCEPTED.' ) as c_user'])
            ->from('teams')->leftJoin('games', 'games.id = teams.game_id')
            ->leftJoin('tournament_team', 'tournament_team.team_id = teams.id')
            ->leftJoin('tournaments', 'tournaments.id = tournament_team.tournament_id')
            ->where(['not in', 'games.id', $not_games])
            ->andWhere(['LIKE', 'teams.name', $post['search']]);
            if((int)$post['game']){

                $teams->andWhere(['games.id' => (int)$post['game']]);
            }
        $teams = $teams->limit(50)
            ->orderBy(['tournaments.id' => SORT_DESC])
            ->all();

        $teams_sort = [];
        foreach ($teams as $team) {
            if (!array_key_exists($team['id'], $teams_sort)) {
                $teami['id'] = $team['id'];
                $teami['logo'] = $team['logo'];
                $teami['name'] = $team['name'];
                $teami['g_name'] = $team['g_name'];
                $teami['turname'] = $team['turname'];
                $teami['c_user'] = $team['c_user'];
                $teami['turid'] = $team['turid'];
                $teams_sort[$team['id']] = $teami;
            } 
        }
        

        if (empty($teams_sort)) {
            $teams_sort = ['not'=> true];
        }
        
        return $teams_sort;
    }

    public function actionSearchBar () 
    {
        $post = Yii::$app->request->post();
        $users = (new \yii\db\Query())->select(['id'])->from('users')
            ->where(['LIKE', 'name', $post['input']]);
       
        $teams = (new \yii\db\Query())
            ->select(['teams.name','teams.logo','teams.id','teams.created_at', 'games.name as g_name',
            '(select count(*) from user_team where id_team = teams.id and status = '.UserTeam::ACCEPTED.' ) as c_user'])
            ->from('teams')->leftJoin('games','games.id = teams.game_id')
            ->leftJoin('user_team', '`user_team`.`id_team` = `teams`.`id`')
            ->where(['LIKE', 'teams.name', $post['input']])
            ->orWhere(['in', 'user_team.id_user', $users])
            ->groupBy(['teams.name'])
            ->limit(18)
            ->all();

        $users_m = (new \yii\db\Query())
            ->select(['users.id','users.name','users.created_at','teams.name as t_name','teams.id as t_id'])
            ->from('users')
            ->leftJoin('user_team', '`user_team`.`id_user` = `users`.`id`')
            ->leftJoin('teams', '`teams`.`id` = `user_team`.`id_team`')
            ->where(['LIKE', 'users.name', $post['input']])
            ->limit(18)
            ->all();

        $tournaments = (new \yii\db\Query())->select(['tournaments.*','games.name as g_name',
            '(select count(*) from tournament_team where tournament_id = tournaments.id and status ="2" ) as c_teams'])
            ->from('tournaments')
            ->leftJoin('tournament_user', '`tournament_user`.`tournament_id` = `tournaments`.`id`')
            ->leftJoin('games', '`games`.`id` = `tournaments`.`game_id`')
            //->leftJoin('tournament_team', '`tournament_team`.`tournament_id` = `tournaments`.`id`')
            ->where(['LIKE', 'tournaments.name', $post['input']])
            ->orWhere(['in', 'tournament_user.user_id', $users])
            ->orWhere(['in', 'tournaments.user_id', $users])
            ->groupBy(['tournaments.name'])
            ->limit(18)
            ->all();

        $user_mass = [];
        foreach ($users_m as $user) {
            if (array_key_exists($user['id'], $user_mass)) {
                if (isset($user['t_id'])) {
                    $user_mass[$user['id']]['teams'][] = ['name'=>$user['t_name'],'id'=>$user['t_id'],];
                }
            } else {
                $user_mass[$user['id']] = ['name'=>$user['name'],'id'=>$user['id'],'created_at'=>substr($user['created_at'],0,10),];
                if (isset($user['t_id'])) {
                    $user_mass[$user['id']]['teams'][] = ['name'=>$user['t_name'],'id'=>$user['t_id'],];
                } 
            } 
        }

        $arry_search['users'] = $user_mass;
        $arry_search['teams'] = $teams;
        $arry_search['tournaments'] = $tournaments;
        if (empty($arry_search['users']) && empty($arry_search['teams']) && empty($arry_search['tournaments'])) {
            $arry_search = ['not' => true];
        }
           
        return $arry_search;
    }

    public function actionGetTeamsPlayers() {
        $post = Yii::$app->request->post();

        $tournament = Tournaments::findOne($post['tournament_id']);
        $id_game  = $tournament->game_id;
        $flag = (int)$post['flag'];
        $teams = [];
        $users = [];

        if((Tournaments::USERS == $flag) || (Tournaments::MIXED == $flag)) {
            $users = (new \yii\db\Query())->select(['users.id','users.name','users.username'])->from('users')
                ->leftJoin('tournament_user', '`tournament_user`.`user_id` = `users`.`id`')
                ->where(['LIKE', 'name', $post['search']])
                ->andWhere(['!=', 'users.id', $tournament->user_id])
                ->andWhere(['tournament_user.status' => null])
                //->andWhere(['!=','tournament_user.status', UserTeam::ACCEPTED])
                ->limit(50)->all();
        } 

        if((Tournaments::TEAMS == $flag) || (Tournaments::MIXED == $flag)) {
            $teams = (new \yii\db\Query())->select(['teams.id','teams.name','games.name as g_name','teams.logo','teams.capitan',
               '(select count(*) from user_team where id_team = teams.id and status = '.UserTeam::ACCEPTED.' ) as c_user'])
            ->from('teams')->leftJoin('games', '`games`.`id` = `teams`.`game_id`')
            ->leftJoin('tournament_team', '`tournament_team`.`team_id` = `teams`.`id`')
            ->where(['games.id'=> $id_game])
            ->andWhere(['LIKE', 'teams.name', $post['search']])
            ->andWhere(['tournament_team.status' => null])
            ->limit(50)->all();
                
        } 
       
        $response['users'] = $users;
        $response['teams'] = $teams;

        if (empty($response['teams']) && empty($response['users'])) {
            $response = ['not' => true];
        }
        return $response;

    }

    public function actionInviteTournament () {

        $post = Yii::$app->request->post();
        $user = User::findOne($post['user_id']); 
        $tournament = Tournaments::findOne($post['tournament_id']);
        if (is_object($user) && is_object($tournament)) {
            $tokin = (string)bin2hex(random_bytes(24));
            if(!empty($post['team_id'])) {
                $team = Teams::findOne($post['team_id']); 
                if (is_object($team)) {
                    $tournament_team = new TournamentTeam();
                    $tournament_team->status = TournamentTeam::SENT;
                    $tournament_team->tokin = $tokin;
                    $tournament_team->tournament_id = $tournament->id; 
                    $tournament_team->team_id = $team->id;
                    $tournament_team->save();

                    $url = Url::toRoute(['tournaments/invitation','tokin'=> $tokin,
                        'tournament' => $tournament->id, 'team' => $team->id], true);
                    $a = Html::a($url,$url);
                    $message = '<p>The invitation to join the tournament for the team '.$team->name.' 
                               for confirmation or rejection click on the link<br> '.$a.'</p>';

                }  
            } else {
                $tournament_user = new TournamentUser();
                $tournament_user->status = TournamentUser::SENT;
                $tournament_user->tokin = $tokin;
                $tournament_user->tournament_id = $tournament->id; 
                $tournament_user->user_id = $user->id;
                $tournament_user->save();

                $url = Url::toRoute(['tournaments/invitation','tokin'=> $tokin,
                    'tournament' => $tournament->id], true);
                $a = Html::a($url,$url);
                $message = '<p>Invitation to enter the tournament for the player '.$user->name.'
                            to confirm or reject the move click on the link<br> '.$a.'</p>';
            }
            $a = Html::a($url,$url);
            Yii::$app->mailer->compose()
                ->setFrom([Yii::$app->params['adminEmail'] => 'Invitation to join the tournament '.$tournament->name])
                ->setTo([$user->email])
                ->setSubject("Invitation to join the tournament")
                ->setTextBody("Invitation to join the tournament")
                ->setHtmlBody($message)
                ->send();    
            return ['sent' => true];
        }
        return ['sent' => false];
    }

    public function actionSetCup() 
    {
        $post = Yii::$app->request->post();
        $user = Yii::$app->user->identity;
        $json = json_decode($post['data']);
        $model = Tournaments::findOne($json->toutrament);
        $model->cup = $post['data'];
        if ($model->user_id == $user->id) {
           if ($model->save(false)) {
                if ($model->format == Tournaments::SINGLE_E) {
                $model->getScheduleCupSingle();
                }
                if ($model->format == Tournaments::DUBLE_E) {
                    $model->getScheduleCupDuble();
                }
                $model->save(false);
           }
        }
        
    }

}
