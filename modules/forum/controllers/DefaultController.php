<?php

namespace app\modules\forum\controllers;

use yii\web\Controller;
use app\models\Tournaments;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use app\models\TournamentTeam;
use app\models\UserTeam;
use app\models\TournamentUser;
use Yii;
use yii\web\HttpException;
use app\modules\forum\models\ForumTopic;
use app\modules\forum\models\ForumPost;
use app\modules\forum\models\SchedulePost;
use app\models\ScheduleTeams;

class DefaultController extends Controller
{
    use \app\models\traits\UserTournament;
    
    public function actionIndex($id)
    {   
        $model = Tournaments::findOne($id);
        if (!is_object($model)) {
           throw new HttpException(404 ,'Page not found');
        }
        $users = self::gerUsers($model);
        if (!in_array(['id'=>Yii::$app->user->identity->id], $users)){
            throw new HttpException(404 ,'Page not found');
        }

        $topics = ForumTopic::find()->where(['tournament_id'=>$model->id])->all();
      
        return $this->render('index',compact('model','topics','topics_s'));
    }

    public function actionTopic($id) 
    {
        $new_post = new ForumPost();
        $topic = ForumTopic::findOne($id);
        if (is_null($topic)) {
            throw new HttpException(404 ,'Page not found');
        }

        $tour = Tournaments::findOne($topic->tournament_id);
        if (!is_object($tour)) {
           throw new HttpException(404 ,'Page not found');
        }
        $users = self::gerUsers($tour);
        if (!in_array(['id'=>Yii::$app->user->identity->id], $users)){
            throw new HttpException(404 ,'Page not found');
        }

        if (Yii::$app->request->isPost) {
            if ($new_post->load(Yii::$app->request->post())) {
                $new_post->user_id = Yii::$app->user->identity->id;
                $new_post->forum_topic_id = $topic->id;
                $new_post->save(false);
            }
            return $this->refresh();
        }
        $posts = ForumPost::find()->with()->where(['forum_topic_id' => $topic->id])->all();
        
        return $this->render('topic',compact('topic','posts','new_post'));
    }

    public function actionTopicSchedule($id) 
    {
        $new_post = new SchedulePost();
        $topic = ScheduleTeams::findOne($id);
        if (is_null($topic)) {
            throw new HttpException(404 ,'Page not found');
        }

        $tour = Tournaments::findOne($topic->tournament_id);
        if (!is_object($tour)) {
           throw new HttpException(404 ,'Page not found');
        }
        $users = self::gerUsers($tour);
        if (!in_array(['id'=>Yii::$app->user->identity->id], $users)){
            throw new HttpException(404 ,'Page not found');
        }

        if (Yii::$app->request->isPost) {
            if ($new_post->load(Yii::$app->request->post())) {
                $new_post->user_id = Yii::$app->user->identity->id;
                $new_post->schedule_teams_id = $topic->id;
                $new_post->save(false);
            }
            return $this->refresh();
        }
        $posts = SchedulePost::find()->with()->where(['schedule_teams_id' => $topic->id])->all();
        
        return $this->render('topic-schedule',compact('topic','posts','new_post'));
    }



    public function actionCreateTopic($id) 
    {   
        $tour = Tournaments::findOne($id);
        if (!is_object($tour)) {
           throw new HttpException(404 ,'Page not found');
        }
        $users = self::gerUsers($tour);
        if (!in_array(['id'=>Yii::$app->user->identity->id], $users)){
            throw new HttpException(404 ,'Page not found');
        }
        $model = new ForumTopic();
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $model->tournament_id = $id;
                $model->save(false);
                return $this->redirect(['index','id' => $id]);
            }
        }
        
        return $this->render('create-topic',compact('model','tour'));
    }

    public function actionUpdateForumText($id) 
    {
        if (Yii::$app->request->isPost) {
            $model = Tournaments::findOne($id);
            if (!is_object($model)) {
               throw new HttpException(404 ,'Page not found');
            }
            if ($model->user_id == \Yii::$app->user->identity->id) {
                if ($model->load(Yii::$app->request->post())) {
                    $model->save(false);
                }
            }
        }
        return $this->redirect(['index','id' => $id]);
    }

    public function actionDataUpdate($id) 
    {
        $model = ScheduleTeams::findOne($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->status = 1;
            $model->save(false);
        }
        return $this->redirect(['topic-schedule','id'=>$id]);
    }
}
