<?php

namespace app\controllers;

use app\models\Tournaments;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Teams;
use app\models\Games;
use app\models\UserTeam;
use Yii;

class TournamentsController extends \yii\web\Controller
{
    public function actionCreate()
    {
    	$games = Games::find()->all();
    	$model = new Tournaments();
    	if (Yii::$app->request->isPost) {
    		if ($model->load(Yii::$app->request->post())) {
    			if($model->save()) {

    				return $this->redirect('/profile#tournaments');
    			}
    		}
    	}
        return $this->render('create-tournament',compact('model','games'));
    }

}
