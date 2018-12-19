<?php

namespace app\models;

use Yii;

class SocialLinks extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'social_links';
    }

    private $array_link_type = [
        '<i class="fa fa-facebook-official" aria-hidden="true"></i>',
        '<i class="fa fa-instagram" aria-hidden="true" style="color:#a05095;"></i>',
        '<i class="fa fa-twitter" aria-hidden="true"></i>',
        '<i class="fa fa-youtube" aria-hidden="true"></i>',
    ];

    public function rules()
    {
        return [
            [['link'], 'required'],
            [['user_id', 'social_id'], 'integer'],
            [['link'],'string'],
            [['link'],'unique'],
            [['social_id'], 'exist', 
                'skipOnError' => true, 
                'targetClass' => User::className(), 
                'targetAttribute' => ['social_id' => 'id']
            ],
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->user->addBall(6);
        parent::afterSave($insert, $changedAttributes);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'social_id' => 'Social ID',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'social_id']);
    }

    public function getIcon() 
    {
        if(!empty($this->array_link_type[$this->social_id-1])) {
            return $this->array_link_type[$this->social_id-1];
        }

        return $this->link;
    }
}
