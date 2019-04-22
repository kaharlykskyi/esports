<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use app\modules\admin\models\UserSearch;
use yii\web\HttpException;
use app\models\User;
use Yii;
use app\modules\admin\models\UserMessageForm;
use app\modules\admin\models\BanMessageForm;

class UserController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSingle ($id)
    {
       $user = User::findOne($id);
        if (is_object($user)) {
            $forma = new UserMessageForm();
            $banform = new BanMessageForm();
            return $this->render('user', compact('user', 'forma', 'banform'));
        }
        throw new HttpException(404 ,'Page not found');
    }

    public function actionSendMessage ()
    {
        $model = new UserMessageForm();
        if ($model->load(Yii::$app->request->post())
            && $model->sendMessage()) {
            
            Yii::$app->session->setFlash(
                'success', 
                'Letter successfully delivered'
            );
        } else {
            Yii::$app->session->setFlash(
                'error', 
                'An error occurred while sending the letter.'
            );
        }
        return $this->redirect(['/admin/user/single', 'id' => $model->user_id]);
    }

    public function actionSetBan ()
    {
        $model = new BanMessageForm();
        if ($model->load(Yii::$app->request->post()) && $model->setBan()) {
            Yii::$app->session->setFlash(
                'success', 
                'The player was banned'
            );
        } else {
            Yii::$app->session->setFlash(
                'error', 
                'An error with the player\'s bath'
            );
        }
        return $this->redirect(['/admin/user/single', 'id' => $model->user_id]);
    }

    public function actionStreamer ()
    {
        if ($user_id = Yii::$app->request->post('user_id')) {
            $model = User::findOne($user_id);
            $post = Yii::$app->request->post();
            if (is_object($model)&&isset($post['User']['role'])) {
                $model->role = $post['User']['role'];
               $model->save(false);
            } 
        }

        return $this->redirect(['/admin/user/single', 'id' => $user_id]);
    }
}