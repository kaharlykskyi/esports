<?php

namespace app\modules\forum\controllers;

use yii\web\Controller;
use app\models\Tournaments;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Teams;
use app\models\Games;
use app\models\User;
use app\models\TournamentTeam;
use app\models\UserTeam;
use app\models\TournamentUser;
use app\models\TournamentCupTeam;
use Yii;
use yii\web\HttpException;
use app\modules\forum\models\ForumTopic;
use app\modules\forum\models\ForumTopicSchedule;
/**
 * Default controller for the `forum` module
 */
class DefaultController extends Controller
{
	use \app\models\traits\UserTournament;
    /**
     * Renders the index view for the module
     * @return string
     */
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
		$topic_s = ForumTopicSchedule::find()->where(['tournament_id'=>$model->id])->all();
      
        return $this->render('index',compact('model','topics','topics_s'));
    }

    public function actionTopic($id) 
    {
    	echo "string";
    }


    public function actionCreateTopic($id) 
    {
    	$model = new ForumTopic();
    	return $this->render('create-topic',compact('model'));
    }
}
