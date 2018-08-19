<?php

namespace app\models;

use Yii;
use  yii\behaviors\TimeStampBehavior;

/**
 * This is the model class for table "tournaments".
 *
 * @property int $id
 * @property int $game_id
 * @property int $format
 * @property string $rules
 * @property string $prizes
 * @property string $start_date
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Games $game
 */
class Tournaments extends \yii\db\ActiveRecord
{
    

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public static function tableName()
    {
        return 'tournaments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['game_id', 'format'], 'integer'],
            [['format', 'rules', 'prizes', 'start_date','name','game_id'], 'required'],
            [['rules', 'prizes','name'], 'string'],
            [['start_date'], 'safe'],
            [['name'], 'unique'],
            [['game_id'], 'exist', 'skipOnError' => true, 'targetClass' => Games::className(), 'targetAttribute' => ['game_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name of the tournament',
            'game_id' => 'Select the tournament game',
            'format' => 'Tournament format',
            'rules' => 'Rules of the tournament',
            'prizes' => 'Tournament prizes',
            'start_date' => 'Tournament start date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(Games::className(), ['id' => 'game_id']);
    }
}
