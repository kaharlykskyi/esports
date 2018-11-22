<?php

namespace app\models;

use Yii;


class Games extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'games';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 200],
            [['alias'], 'string', 'max' => 30],
            [['name'], 'unique'],
            [['alias'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app','Name'),
        ];
    }

    public function getTeams()
    {
        return $this->hasMany(Teams::className(), ['game_id' => 'id']);
    }
}
