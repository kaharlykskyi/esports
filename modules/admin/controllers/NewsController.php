<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\News;
use app\modules\admin\models\NewsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\admin\models\NewsCategory;

class NewsController extends Controller
{

    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionState($id)
    {
        $model = $this->findModel($id);
        if ($model->state == 1){
            $model->state = 0;
        } else {
            $model->state = 1;
        }
        $model->save();
        return Yii::$app->request->referrer ? 
            $this->redirect(Yii::$app->request->referrer) : $this->redirect(['index']);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new News();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create',compact('model'));
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect('/3kljs89s/news/index');
    }

    protected function findModel($id)
    {
        if (is_object($model = News::findOne($id))) {
            return $model;
        }
       throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCreateCategory ()
    {
        $model = new NewsCategory();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }   

        return $this->render('create-category',compact('model'));   
    }
}
