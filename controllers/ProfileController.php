<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Teams;
use app\models\Games;
use app\models\UserTeam;
use Yii;
use yii\web\UploadedFile;
use app\models\User;
use app\models\Tournaments;
use app\models\TournamentTeam;
use yii\helpers\ArrayHelper;

class ProfileController extends \yii\web\Controller
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

    public function beforeAction($action)
	{
        if (!Yii::$app->user->isGuest) {
            if (!Yii::$app->user->identity->is_verified) {
                $email = Yii::$app->user->identity->email;
                $a_email = '<a href="http://'.$email.'">'.$email.'</a>';
                $resend = '<a href="/resend">&nbsp;&nbsp;&nbsp;Resend</a>';
                Yii::$app->session->setFlash('warning', 'Please confirm you email: '.$a_email.$resend);
            }
        }
 		return parent::beforeAction($action);
	}

    public function actionIndex()
    {   
        $teams = Teams::getTeamsThisUser();
        $userteams =Yii::$app->user->identity->getUserteams()
        ->where(['user_team.status'=> UserTeam::ACCEPTED])
        ->orWhere(['user_team.status'=> UserTeam::DUMMY])->all();
        $ids = ArrayHelper::getColumn($userteams, 'id_team');
        $tournaments = Tournaments::find()
            ->leftJoin('tournament_team', '`tournament_team`.`tournament_id` = `tournaments`.`id`')
            ->where(['in', 'tournament_team.team_id', $ids])
            ->andWhere(['tournament_team.status'=>TournamentTeam::ACCEPTED])
            ->orWhere(['tournaments.user_id'=>Yii::$app->user->identity->id])
            ->all();
        $games = Games::find()->all();
        $not_games = $this->games();
        return $this->render('index',compact('teams','games','not_games','tournaments'));
    }

    public function actionCreateTeam()
    {
  
		$id = Yii::$app->user->identity->id;
		
		$not_gemes = $this->games();
        if (empty($not_gemes)) {
            return $this->redirect('/profile#teams');
        }
        $model = new Teams();
        
        if (Yii::$app->request->isPost) {
           
            $model->capitan = $id;
            if ($model->load(Yii::$app->request->post())) {
                    $model->file = UploadedFile::getInstance($model, 'file');
                    $model->file1 = UploadedFile::getInstance($model,'file1');
               
                if (is_object($model->file1) && is_object($model->file) && $model->validate()) {

                    $pathBackground = \Yii::getAlias('@webroot').'/images/background/'.$id.'/';   
                    if (!is_dir($pathBackground)) {
                        mkdir($pathBackground, 0777, true);
                    }
                    $model->file1->saveAs($pathBackground.$model->file1->baseName.'.'.$model->file1->extension);

                    $pathLogo = \Yii::getAlias('@webroot').'/images/logo/'.$id.'/';
                    if (!is_dir($pathLogo)) {
                        mkdir($pathLogo, 0777, true);
                    }
                    $pathFile = $pathLogo.$model->file->baseName.'.'.$model->file->extension;
                    $model->file->saveAs($pathFile);
                    $this->resizeImg($pathFile);
                     
                    $model->logo = '/images/logo/'.$id.'/'.$model->file->baseName.'.'.$model->file->extension;
                    $model->background = '/images/background/'.$id.'/'.$model->file1->baseName.'.'.$model->file1->extension;
                    if($model->save()){
                        $user_team = new UserTeam();
                        $user_team->id_user = $id;
                        $user_team->status = UserTeam::ACCEPTED;
                        $user_team->id_team = $model->id;
                        $user_team->save();
                        return $this->redirect('/profile#teams');;
                    }
                }
            }
        }
        return $this->render('createteam', compact('model','not_gemes') );
    }

    public function actionUpdateTeam($id = false)
    {
        if ($id) {
            if ($model = Teams::findOne($id)) {
                $user_id = Yii::$app->user->identity->id;
                $user_team = UserTeam::findOne([ 'id_user' => $user_id,'id_team' => $model->id ]);
                if (!is_object($user_team)) {
                   return $this->redirect('/profile#teams');
                }
                if (Yii::$app->request->isPost) {
                    
                    if ($model->load(Yii::$app->request->post())) {
                        $model->file = UploadedFile::getInstance($model, 'file');
                        $model->file1 = UploadedFile::getInstance($model,'file1');
                        if (is_object($model->file)) { 
                            $pathLogo = \Yii::getAlias('@webroot').'/images/logo/'.$user_id.'/';
                            if (!is_dir($pathLogo)) {
                                mkdir($pathLogo, 0777, true);
                            } 
                            $pathFile = $pathLogo.$model->file->baseName.'.'.$model->file->extension;
                            $model->file->saveAs($pathFile);
                            $model->logo = '/images/logo/'.$user_id.'/'.$model->file->baseName.'.'.$model->file->extension;
                            $this->resizeImg($pathFile);
                           
                        }
                        if (is_object($model->file1)) { 
                            $pathLogo = \Yii::getAlias('@webroot').'/images/background/'.$user_id.'/';
                            if (!is_dir($pathLogo)) {
                                mkdir($pathLogo, 0777, true);
                            }
                            $model->file1->saveAs($pathLogo.$model->file1->baseName.'.'.$model->file1->extension);
                            $model->background = '/images/background/'.$user_id.'/'.$model->file1->baseName.'.'.$model->file1->extension;
                        }
                        $model->save();
                        return $this->redirect('/profile#teams');
                    }
                }
                
                $users_team = UserTeam::find()->where(['user_team.id_team' => $id])
                    ->andWhere(['status' => UserTeam::ACCEPTED])
                    ->all();
                $id_users = [];
                foreach($users_team as $value){
                    $id_users[] = $value['id_user'];
                }
                $users = \app\models\User::find()->where(['in', 'id', $id_users])->all();
                return $this->render('update-team', compact('model','users'));
            }
            return $this->redirect('/profile#teams');
        }
        return $this->redirect('/profile#teams');
    }

    public function actionSettings ()
    {
        if (Yii::$app->request->isPost) {
            $user = Yii::$app->user->identity;
            $post = Yii::$app->request->post();
            $user->load($post);
            $user->save();
            return $this->redirect('/profile#settings');
        }       
    }

    public function actionConfirmationTeam ($confirmation_tokin, $status = false) {
        
        $id = Yii::$app->user->identity->id;
        $user_team = UserTeam::find()
        ->where(['id_user' => $id])
        ->andWhere(['status' => UserTeam::SENT])
        ->andWhere(['status_tokin' => $confirmation_tokin])
        ->one();

        $team = Teams::findOne($user_team->id_team);
        $game_pred = $team->game->id;

        $team_my = Teams::find()
        ->leftJoin('games', '`games`.`id` = `teams`.`game_id`')
        ->leftJoin('user_team', '`user_team`.`id_team` = `teams`.`id`')
        ->where(['user_team.id_user' => $id])
        ->andWhere(['user_team.status' => UserTeam::ACCEPTED])
        ->andWhere(['games.id' => $game_pred])->one();

        if( is_object($user_team) && !is_object($team_my)) {
            if (($status == UserTeam::ACCEPTED) || ($status == UserTeam::DECLINED) ) {
                if ($status == UserTeam::ACCEPTED) {
                    $user_team->status = UserTeam::ACCEPTED;
                }
                if ($status == UserTeam::DECLINED) {
                     $user_team->status = UserTeam::DECLINED;
                }
                $user_team->status_tokin = 'OK';
                $user_team->save();
                return $this->redirect('/profile');
            }
            return $this->render('confirmation-team',compact('confirmation_tokin','team'));
        }
        return $this->redirect('/profile');    
    }

    public function actionExitTeam ($id) 
    {
        $team = Teams::findOne($id);
        if (is_object($team)) {
            $id_user = Yii::$app->user->identity->id;
            if ($team->capitan != $id_user) {
                $user_team = UserTeam::findOne(['id_user' => $id_user,'id_team' => $team->id]);
                $user_team->delete();
            }  
        }
        return $this->redirect('/profile#teams');
    }


    private function games()
    {
        $id = Yii::$app->user->identity->id;
        $games = Games::find()->leftJoin('teams', '`teams`.`game_id` = `games`.`id`')
        ->leftJoin('user_team', '`user_team`.`id_team` = `teams`.`id`')
        ->where(['user_team.id_user' => $id])
        ->andWhere(['user_team.status' => UserTeam::ACCEPTED])
        ->asArray()->all();
        $not_gemes = [];
        foreach($games as $value){
            $not_gemes[] = $value['id'];
        }
        
        $games = Games::find()->where(['not in', 'id', $not_gemes])->all();
        return  $games;
    }
        
    private function resizeImg ($pathFile)
    {
        $image = Yii::$app->image->load($pathFile);
        $image->background('#fff', 0);
        $image->resize('80', '80', \yii\image\drivers\Image::INVERSE);
        $image->crop('80','80');
        $image->save($pathFile);
    }

}
