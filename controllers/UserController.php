<?php

namespace app\controllers;

use app\models\User;
use yii\web\HttpException;
use app\models\ResultsStatistics;
use app\models\Teams;
use app\models\UserTeam;

class UserController extends \yii\web\Controller
{
    public function actionPublic($id)
    {
    	$model = User::findOne($id);
    	if (!is_object($model)) {
           throw new HttpException(404 ,'Page not found');
        }
        $teams = (new \yii\db\Query())->select('teams.id')->from('teams')
        	->innerJoin('user_team', '`user_team`.`id_team` = `teams`.`id`')
        	->where(['user_team.status' => UserTeam::ACCEPTED,'user_team.id_user' => $model->id]);
        $statistic_team = ResultsStatistics::find()
        	->where(['in','team_id',$teams])->all();

        return $this->render('index',compact('model','statistic_team'));
    }

}
