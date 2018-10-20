<?php
namespace app\modules\admin\controllers;

use yii\helpers\Url;
use yii\helpers\Html;
use Yii;
use \yii\base\DynamicModel;
use yii\web\UploadedFile;
use app\modules\admin\models\News;

class AjaxController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (in_array($action->id, ['file-upload'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionFileUpload()
    {
        $model = new DynamicModel(['file']);
        $model->addRule(['file'],'image',['extensions' => ['png', 'jpg','jpeg','gif'],]);
        $model->file = UploadedFile::getInstanceByName('file');
        if (is_object($model->file) && $model->validate()) {
            $time = time();
            $model->file->saveAs(\Yii::getAlias('@app').'/web/images/news/'.$time.$model->file->baseName.'.'.$model->file->extension);
            return array('location' => '/images/news/'.$time.$model->file->baseName.'.'.$model->file->extension); 
        }
    }
}