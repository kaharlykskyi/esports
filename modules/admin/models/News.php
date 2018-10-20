<?php

namespace app\modules\admin\models;

use Yii;
use yii\web\UploadedFile;

class News extends \yii\db\ActiveRecord
{
    public $logo_file;
    
    public static function tableName()
    {
        return 'news';
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        } 

        $this->logo_file = UploadedFile::getInstance($this,'logo_file');
        if (is_object($this->logo_file)) {
            $now_name = time();
            $path = \Yii::getAlias('@webroot').'/images/news/'; 
            $this->logo_file->saveAs($path.$now_name.'.'.$this->logo_file->extension);
            $this->resizeImg($path.$now_name.'.'.$this->logo_file->extension);
            $this->logo = '/images/news/'.$now_name.'.'.$this->logo_file->extension;
        }
        return true;
    }

    public function rules()
    {
        return [
            [['title','category_id'], 'required'],
            [['description','created_at','updated_at','logo'], 'string'],
            [['state','category_id'], 'integer'],
            [['title'], 'string', 'max' => 200],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'state' => 'State',
            'created_at' => 'Created At',
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(NewsCategory::className(), ['id' => 'category_id']);
    }

    private function resizeImg ($pathFile)
    {
        $image = \Yii::$app->image->load($pathFile);
        $image->background('#fff', 0);
        $image->resize('400', '200', \yii\image\drivers\Image::INVERSE);
        $image->crop('400','200');
        $image->save($pathFile);
    }
}
