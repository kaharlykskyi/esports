<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_team".
 *
 * @property int $id_user
 * @property int $id_team
 *
 * @property Teams $team
 * @property Users $user
 */
class UserTeam extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_team';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'id_team'], 'integer'],
            [['id_team'], 'exist', 'skipOnError' => true, 'targetClass' => Teams::className(), 'targetAttribute' => ['id_team' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_user' => 'Id User',
            'id_team' => 'Id Team',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Teams::className(), ['id' => 'id_team']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'id_user']);
    }
}
