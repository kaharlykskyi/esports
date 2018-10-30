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
    public function actionIndex($alias)
    {
        $this->hasGame($alias);
        $searchModel = new SearchResultsStatisticsUsers();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$alias);
        $query = News::find()->where(['state' => 1]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 6]);
        $pages->pageSizeParam = false;
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)->orderBy("created_at DESC")->all();
        
        return $this->render(
            'index',
            compact('dataProvider','searchModel','models','pages','alias')
        );
    }

    public function actionSingle($id)
    {
    	$news = News::find()->where(['id' => $id,'state' => 1])->one();
    	if (!is_object($news)) {
            throw new HttpException(404 ,'Page not found');
        }
        return $this->render('single', compact('news'));
    }

    private function hasGame($alias) 
    {
        $game = Games::findOne(['alias' => $alias]);
        if (!is_object($game)) {
           throw new HttpException(404 ,'Page not found');
        }
    }

}
