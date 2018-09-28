<?php

namespace app\modules\admin\models;

use Yii;

class News extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'news';
    }

    // public function beforeSave($insert)
    // {
    //     if (parent::beforeSave($insert)) {
    //         $this->created_at = date('dd-MM-Y');
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description','created_at','updated_at'], 'string'],
            [['state'], 'integer'],
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
}
