<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "stream".
 *
 * @property int $id
 * @property int $tournament_id
 * @property int $stream_chanal
 * @property string $stream_url
 *
 * @property Tournaments $tournament
 */
class Stream extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stream';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tournament_id', 'stream_chanal'], 'integer'],
            [['stream_url'], 'string', 'max' => 200],
            [['tournament_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tournaments::className(), 'targetAttribute' => ['tournament_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tournament_id' => 'Tournament ID',
            'stream_chanal' => 'Stream Chanal',
            'stream_url' => 'Stream Url',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTournament()
    {
        return $this->hasOne(Tournaments::className(), ['id' => 'tournament_id']);
    }
}
