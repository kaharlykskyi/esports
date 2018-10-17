<?php

namespace app\controllers;

use app\models\ResultsStatistics;
use app\models\servises\SearchResultsStatistics;
use app\models\Teams;
use Yii;

class StatisticController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new SearchResultsStatistics();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);     
        return $this->render('index',compact('dataProvider','searchModel'));
    }

}