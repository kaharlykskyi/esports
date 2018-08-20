<?php

namespace app\controllers;

use app\models\Tournaments;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Teams;
use app\models\Games;
use app\models\UserTeam;
use Yii;
use yii\web\HttpException;

class TournamentsController extends \yii\web\Controller
{

    public function actionPublic($id)
    {
        $model = Tournaments::findOne($id);
        if (!is_object($model)) {
           throw new HttpException(404 ,'Page not found');
        }

        if(Yii::$app->request->isPost){
            if ($model->load(Yii::$app->request->post())) {
                if($model->save()) {
                    Yii::$app->session->setFlash('success', 'Tournament settings updated');
                    return $this->redirect('/tournaments/public/'.$model->id.'#manage_tournament');
                }
            }
        }

        return $this->render('index',compact('model'));
    }

    public function actionCreate()
    {
    	$games = Games::find()->all();
    	$model = new Tournaments();
    	if (Yii::$app->request->isPost) {
    		if ($model->load(Yii::$app->request->post())) {
                $model->user_id = Yii::$app->user->identity->id;
    			if($model->save()) {

    				return $this->redirect('/profile#tournaments');
    			}
    		}
    	}
        return $this->render('create-tournament',compact('model','games'));
    }

}
