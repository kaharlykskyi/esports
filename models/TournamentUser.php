<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tournament_user".
 *
 * @property int $id
 * @property int $tournament_id
 * @property int $user_id
 *
 * @property Tournaments $tournament
 * @property Users $user
 */
class TournamentUser extends \yii\db\ActiveRecord
{
    

    const SENT = 1;
    const ACCEPTED = 2;
    const DECLINED = 3;

    public static function tableName()
    {
        return 'tournament_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tournament_id', 'user_id','status'], 'integer'],
            [['tournament_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tournaments::className(), 'targetAttribute' => ['tournament_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTournament()
    {
        return $this->hasOne(Tournaments::className(), ['id' => 'tournament_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
