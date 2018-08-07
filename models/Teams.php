<?php

namespace app\models;

use Yii;
use  yii\behaviors\TimeStampBehavior;

/**
 * This is the model class for table "teams".
 *
 * @property int $id
 * @property string $name
 * @property string $logo
 * @property string $background
 * @property int $game_id
 * @property string $website
 * @property string $captain
 *
 * @property Games $game
 * @property UserTeam[] $userTeams
 */
class Teams extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $file;
    public $file1; 

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public static function tableName()
    {
        return 'teams';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'capitan'], 'required'],
            [['game_id','capitan'], 'integer'],
            [['file', 'file1'],'file','skipOnEmpty' => false,
                'when' => function($model) { return !isset($model->id);},
                'whenClient' => "function (attribute, value) {
                    return !$('#game_idf').val();
                }"
            ],
            [['name', 'website' ], 'string', 'max' => 200],
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
            'name' => 'Team name',
            'file' => 'Team logo',
            'file1' => 'Background',
            'game_id' => 'Game',
            'website' => 'Website URL',
            'capitan' => 'Capitan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(Games::className(), ['id' => 'game_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTeams()
    {
        return $this->hasMany(UserTeam::className(), ['id_team' => 'id']);
    }

    public function coutUsers()
    {
        $count = $this->userTeams;
        $i = 0;
        foreach ($count as $value) {
            $i++;
        }
        return $i;
    }

    public static function getTeamsThisUser(){
        $teams = [];
        $count_teams = 0;
        foreach (Yii::$app->user->identity->userteams as  $value) {
           $count_teams++; 
           $teams[] = $value['id_team'];
        }
        $teams = self::find()->where(['in', 'id', $teams])->all();
        $count_games = Games::find()->count();
        $btn = $count_games-$count_teams;
        return compact('teams','count_teams','btn');
    }
}
