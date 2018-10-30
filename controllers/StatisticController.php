<?php

namespace app\controllers;

use app\models\ResultsStatistics;
use app\models\ResultsStatisticUsers;
use app\models\servises\SearchResultsStatistics;
use app\models\servises\SearchResultsStatisticsUsers;
use app\models\Teams;
use app\models\Games;
use app\modules\admin\models\News;
use yii\web\HttpException;
use Yii;
use yii\data\Pagination;

class StatisticController extends \yii\web\Controller
{
    public function actionTeams($alias)
    {
        $this->hasGame($alias);
        $searchModel = new SearchResultsStatistics();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$alias);     
        return $this->render('teams_results',compact('dataProvider','searchModel'));
    }

    public function actionUsers($alias)
    {
        $this->hasGame($alias);
        $searchModel = new SearchResultsStatisticsUsers();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$alias);
        return $this->render('users_results', compact('dataProvider','searchModel'));
    }

    private function hasGame($alias) 
    {
        $game = Games::findOne(['alias' => $alias]);
        if (!is_object($game)) {
           throw new HttpException(404 ,'Page not found');
        }
    }

}