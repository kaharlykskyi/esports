<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

class Games extends \yii\db\ActiveRecord
{

    public $logo_file;
    const ACTIVE = 1;
    const DISABLED = 0;

    public static function tableName()
    {
        return 'games';
    }

    public function rules()
    {
        return [
            [['name', 'alias'], 'required'],
            [['status'], 'integer'],
            [['name','logo'], 'string', 'max' => 200],
            [['alias'], 'string', 'max' => 30],
            [['filed'], 'string'],
            [['name'], 'unique'],
            ['logo_file', 'file','skipOnEmpty' => false,
                'when' => function($model) { return !isset($model->id);},
                'whenClient' => "function (attribute, value) {
                    return !$('#update').val();
                }"
            ],
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

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->logo_file = UploadedFile::getInstance($this,'logo_file');
        if (is_object($this->logo_file)) {
            $path = Yii::getAlias('@webroot').'/images/game/'; 
            if (!$insert && $this->logo) {
                if (file_exists($path.$this->logo)) {
                    unlink($path.$this->logo);
                }
            }
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }    
            $name_file = $this->logo_file->baseName;
            $file = $path.$name_file.'.'.$this->logo_file->extension;

            if (file_exists($file)) {
                $name_file = $name_file.(string)time(); 
                $file = $path.$name_file.'.'.$this->logo_file->extension;
            }
            $this->logo_file->saveAs($file);
            $this->resizeImg($file);
            $this->logo = $name_file.'.'.$this->logo_file->extension;
        }

        return true;
    }

    public function getTeams()
    {
        return $this->hasMany(Teams::className(), ['game_id' => 'id']);
    }

    private function resizeImg ($pathFile)
    {
        $image = \Yii::$app->image->load($pathFile);
        $image->background('#fff', 0);
        $image->resize('160', '160', \yii\image\drivers\Image::INVERSE);
        $image->crop('160','160');
        $image->save($pathFile);
    }
}
