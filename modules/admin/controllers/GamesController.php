<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use app\modules\admin\models\UserSearch;
use yii\web\HttpException;
use app\models\Games;
use Yii;
use app\modules\admin\models\UserMessageForm;
use app\modules\admin\models\BanMessageForm;

class GamesController extends Controller
{
    public function actionIndex()
    {
        $games = Games::find()->all();
        return $this->render('index', compact('games'));
    }

    public function actionCreate()
    {
        $game = new Games();
        if (Yii::$app->request->isPost) {
            $game->load(Yii::$app->request->post());
            $game->save(false);
            return $this->redirect(['/admin/games/update','id' => $game->id]);
        }
        return $this->render('create', ['model'=> $game]);
    }

    public function actionUpdate($id)
    {
        $game = Games::findOne($id);
        if (!is_object($game)) {
            throw new HttpException(404 ,'Page not found');
        }
        if (Yii::$app->request->isPost) {
            $game->load(Yii::$app->request->post());
            $game->save();
            return $this->redirect(['/admin/games/update','id' => $id]);
        }
        return $this->render('update',['model'=> $game]);
    }

    public function actionDelete($id)
    {
        $game = Games::findOne($id);
        if (!is_object($game)) {
            throw new HttpException(404 ,'Page not found');
        }
        $game->delete();
        return $this->redirect(['index']);
    }

    public function actionToglle ($id)
    {
        $game = Games::findOne($id);
        if (!is_object($game)) {
            throw new HttpException(404 ,'Page not found');
        }
        if ($game->status == 1){
            $game->status = 0;
        } else {
            $game->status = 1;
        }
        $game->save(false);
        $this->redirect(['index']);
    }

}