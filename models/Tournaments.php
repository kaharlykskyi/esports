<?php

namespace app\models;

use yii\helpers\Html;
use Yii;
use yii\behaviors\TimestampBehavior;

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
    use \app\models\traits\ScheduleCup;
    
    const SINGLE_E = 1;
    const DUBLE_E = 2;
    const LEAGUE = 3;
    const LEAGUE_P = 4;
    const LEAGUE_G = 5;

    const USERS = 1;
    const TEAMS = 2;
    const MIXED = 3;


    public function behaviors()
    {
        return [
             TimeStampBehavior::className(),
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
            [['game_id', 'format','flag','time_limit','match_schedule','user_id','league_p','league_g'], 'integer'],
            [['format', 'rules', 'prizes', 'start_date','name','game_id'], 'required'],
            [['rules', 'prizes','name'], 'string'],
            [['start_date','region','data','cup','league','league_table'], 'safe'],
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

    public function generateForm () 
    {

        if (!empty($this->id)) {

            $fileds = json_decode($this->game->filed);
            $data = $this->data !== '' ? json_decode($this->data) : [];
            if(!is_null($this->game->filed)){
                $result="";

                foreach ($fileds as $filed) {
                    $class = "";
                    if (!empty($filed->class)){
                        $class = $filed->class;
                    }
                    $value = !empty($data->{$filed->name}) ? $data->{$filed->name} : null;

                    if ($filed->type =='number') {
                        
                        $result .= '<div class="conteiner_filed '.$class.'" ><label class="col-sm-12" >'
                        . $filed->title .'</label>'. Html::input('number', "Data[{$filed->name}]",$value, ['class' => false,'min'=>"1" ,'max'=>"30"]) .'</div>';

                    } elseif ($filed->type === 'select') {

                        $options = [];
                        foreach($filed->options as $option){
                            $options[$option] = $option;
                        }

                        $result .= '<div class="conteiner_filed '.$class.'" >
                             <label class="control-label col-md-12" >'. $filed->title .
                            '</label><div class="item select-show"><select name="Data['.$filed->name.']" class="basic" >'
                            . Html::renderSelectOptions($value, $options) .'</select></div></div>';

                    } elseif ($filed->type === 'checkbox') {
                        $options = '';
                        $i = 0;
                        foreach($filed->options as $option) {
                            $i++;
                            $checked = $value && in_array($option, $value);
                            $options .= Html::checkbox("Data[{$filed->name}][]", $checked, ['id' => $filed->name.$i,'value' => $option ,'class' =>'filter-check'])
                            .'<label for="'.$filed->name.$i.'">
                                <span style="font-size: 18px;position: relative;bottom: 5px;">'.$filed->title.'</span>
                            </label>';
                        }
                        $result .= '<div class="checkbox conteiner_filed" >'. $options .'</div>';
                    }
                }
                return $result;
            }
        }
    }

}

