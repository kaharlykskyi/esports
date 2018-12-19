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

class NewsController extends \yii\web\Controller
{
  
    public function actionSingle($id)
    {
    	$news = News::find()->where(['id' => $id,'state' => 1])->one();
    	if (!is_object($news)) {
            throw new HttpException(404 ,'Page not found');
        }
        return $this->render('single', compact('news'));
    }

}
