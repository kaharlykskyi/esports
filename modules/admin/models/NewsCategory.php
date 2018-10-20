<?php

namespace app\modules\admin\models;

use Yii;


class NewsCategory extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'news_category';
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 200],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Category name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    public function getNews()
    {
        return $this->hasMany(News::className(), ['category_id' => 'id']);
    }
}
