<?php

namespace app\models;

use Yii;
use app\models\points\TeamPoint;


class UserTeam extends \yii\db\ActiveRecord
{
    const SENT = 1;
    const ACCEPTED = 2;
    const DECLINED = 3;
    const DUMMY = 4;

    public static function tableName()
    {
        return 'user_team';
    }

    public function rules()
    {
        return [
            [['id_user', 'id_team','status'], 'integer'],
            [
                ['id_team'], 'exist', 
                'skipOnError' => true, 
                'targetClass' => Teams::className(), 
                'targetAttribute' => ['id_team' => 'id']
            ],
            [
                ['id_user'], 'exist', 
                'skipOnError' => true, 
                'targetClass' => User::className(), 
                'targetAttribute' => ['id_user' => 'id']
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_user' => 'Id User',
            'id_team' => 'Id Team',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($this->status == self::ACCEPTED) {
            
            $team = $this->team;
            if (is_object($team) && $team->capitan != $this->id_user) {
                TeamHistory::setHistory('textAddUser', $this, $this->id_team);
                TeamPoint::invitePlayer($team);
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function beforeDelete()
    {
        TeamHistory::setHistory('textDeletedUser',$this, $this->id_team);
        return parent::beforeDelete();
    }

    public function getTeam()
    {
        return $this->hasOne(Teams::className(), ['id' => 'id_team']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

}
