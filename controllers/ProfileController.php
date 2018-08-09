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

    /**
     * {@inheritdoc}
     */
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
                Yii::$app->session->setFlash('warning', 'Please confirm you email: '.$a_email);
            }
        }
 		return parent::beforeAction($action);
	}

    public function actionIndex()
    {   
        $teams = Teams::getTeamsThisUser();
        return $this->render('index',compact('teams'));
    }

    public function actionCreateTeam()
    {
  
		$id = Yii::$app->user->identity->id;
		$games = Games::find()->leftJoin('teams', '`teams`.`game_id` = `games`.`id`')
		->leftJoin('user_team', '`user_team`.`id_team` = `teams`.`id`')
		->where(['user_team.id_user' => $id])->asArray()->all();
		$not_gemes = [];
		foreach($games as $value){
			$not_gemes[] = $value['id'];
		}
		
		$not_gemes = Games::find()->where(['not in', 'id', $not_gemes])->all();;
        if (empty($not_gemes)) {
            return $this->redirect(['index']);
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
                        return $this->redirect(['index']);;
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
                
                if (Yii::$app->request->isPost) {
                    $user_id = Yii::$app->user->identity->id;
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
                        return $this->redirect(['index']);
                    }
                }
                
                $users_team = UserTeam::find()->where(['user_team.id_team' => $id])->all();
                $id_users = [];
                foreach($users_team as $value){
                    $id_users[] = $value['id_user'];
                }
                $users = \app\models\User::find()->where(['in', 'id', $id_users])->all();
                return $this->render('update-team', compact('model','users'));
            }
            return $this->redirect('/profile');
        }
        return $this->redirect('/profile');
    }

    public function actionSettings ()
    {
        if (Yii::$app->request->isPost) {

            $user = Yii::$app->user->identity;
            $post = Yii::$app->request->post();
                if (!is_null($post['visible'])) {
                $user->visible = 1;
                } else {
                    $user->visible = 0;
                }
                $user->save();
        }
        return $this->redirect('/profile');
    }

    public function actionConfirmationTeam ($confirmation_tokin, $status = false) {
        $id = Yii::$app->user->identity->id;
        $user_team = UserTeam::find()
        ->where(['id_user' => $id])
        ->andWhere(['status_tokin' => $confirmation_tokin])->one();
        if( is_object($user_team)) {
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
            return $this->render('confirmation-team',compact('confirmation_tokin'));
        }
        return $this->redirect('/profile');    
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
