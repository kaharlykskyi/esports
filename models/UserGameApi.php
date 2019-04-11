<?php

namespace app\models;

use Yii;

class UserGameApi extends \yii\db\ActiveRecord
{
 
    private $platform_array = ['pc', 'etc'];
    private $region_array = ['eu', 'us', 'asia'];
    private $data_array;

    public static function tableName()
    {
        return 'user_game_api';
    }

    public function rules()
    {
        return [
            [['user_id', 'platform', 'battletag'], 'required'],
            [['user_id', 'platform', 'region', 'rating'], 'integer'],
            [['battletag'], 'string', 'max' => 200],
            [['data'], 'string'],
            [
                ['user_id'], 'exist', 
                'skipOnError' => true, 
                'targetClass' => User::className(), 
                'targetAttribute' => ['user_id' => 'id']
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'platform' => 'Platform',
            'region' => 'Region',
            'battletag' => 'Battletag',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function platform () 
    {
        if($this->platform&&!empty($this->platform_array[$this->platform-1])) {
            return $this->platform_array[$this->platform-1];
        }
        return false;
    }

    public function region () 
    {
        if($this->region&&!empty($this->region_array[$this->region-1])) {
            return $this->region_array[$this->region-1];
        }
        return false;
    }

    public function is_data () 
    {
        $this->data_array = json_decode($this->data, true);
        if ( json_last_error() === JSON_ERROR_NONE ) {
            return true;
        }
        return false;
    }

    public function data ($key) 
    {
        if (!is_array($this->data_array)) {
            $this->data_array = json_decode($this->data, true);
            if ( json_last_error() !== JSON_ERROR_NONE ) {
                return '';
            }
        }

        if(!empty($this->data_array[$key])) {
            return $this->data_array[$key];
        }
        return '---';
    }
}
