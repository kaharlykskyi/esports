<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

class SponsorTeam extends \yii\db\ActiveRecord
{

    public $img;
   
    public static function tableName()
    {
        return 'sponsor_team';
    }

    public function rules()
    {
        return [
            [['team_id'], 'integer'],
            [['name', 'site_url', 'img'], 'required'],
            [['name', 'site_url', 'logo'], 'string', 'max' => 250 ],
            [['img'],'file'],
            [['team_id'], 'exist', 
                'skipOnError' => true, 
                'targetClass' => Teams::className(), 
                'targetAttribute' => ['team_id' => 'id']
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'team_id' => 'Team ID',
            'name' => 'Name',
            'site_url' => 'Site Url',
            'logo' => 'Logo',
        ];
    }

    public function getTeam()
    {
        return $this->hasOne(Teams::className(), ['id' => 'team_id']);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->img = UploadedFile::getInstance($this,'img');
        if (is_object($this->img)) {
            $now_name = time();
            $path = \Yii::getAlias('@webroot').'/images/sponsor/'.$this->id.'/'; 
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }    
            $this->img->saveAs($path.$now_name.'.'.$this->img->extension);
            $this->resizeImg($path.$now_name.'.'.$this->img->extension);
            $this->logo = '/images/sponsor/'.$this->id.'/'.$now_name.'.'.$this->img->extension;
        }

        return true;
    }

    private function resizeImg ($pathFile)
    {
        $image = \Yii::$app->image->load($pathFile);
        $image->background('#fff', 0);
        $image->resize('300', '100', \yii\image\drivers\Image::INVERSE);
        $image->crop('300','100');
        $image->save($pathFile);
    }
}
