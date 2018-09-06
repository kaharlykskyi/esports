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

    public function getScheduleCup () 
    {

        if ($this->cup) {
            $json = json_decode($this->cup);
            
            $arr = $json->teams;
            $raspisanie = [];

            if(empty($json->results[0])) {
                 foreach ($arr as $key_t => $teams) {
                    $one_match =[];
                    $one_match['players1'] = $teams[0];
                    $one_match['players2'] = $teams[1];
                    $one_match['rezult1'] = 0;
                    $one_match['rezult2'] = 0;
                    $one_match['date'] = $this->start_date;
                    $raspisanie[] = $one_match;
                      
                }
                $raspisanie = [$raspisanie];
                  // echo "<pre>";
                  //   print_r($raspisanie);
                  //    echo "</pre>";exit;
                return $raspisanie;
            }

            foreach ($json->results[0] as $key_r => $value) {
                $mass = [];
                $mass_sort =[];
                $one_match =[];
                $raspisanie_tur = [];
                foreach ($arr as $key_t => $teams) {


                    if (empty($value[$key_t])) break;
                    if($value[$key_t][0] != $value[$key_t][1]) {

                        $one_match['players1'] = $teams[0];
                        $one_match['players2'] = $teams[1];
                        $one_match['rezult1'] = $value[$key_t][0]??0;
                        $one_match['rezult2'] = $value[$key_t][1]??0;
                        $one_match['date'] = $this->start_date;

                        if ($value[$key_t][0] > $value[$key_t][1]) {
                            $mass_sort[] = $teams[0];
                        }elseif ($value[$key_t][0] < $value[$key_t][1]) {
                            $mass_sort[] = $teams[1];
                        
                            
                            
                        }                    
                        $raspisanie_tur[] = $one_match;

                    } else {
                        $bye = new \stdClass(); 
                        $bye->name = 'bye';
                        $mass_sort[] = $bye;
                        $one_match['players1'] = $teams[0];
                        $one_match['players2'] = $teams[1];
                        $one_match['rezult1'] = 0;
                        $one_match['rezult2'] = 0;
                        $one_match['date'] = $this->start_date;
                        $raspisanie_tur[] = $one_match;

                    }
                }
                $count = count($mass_sort)/2;
                for ($i=0; $i < $count ; $i++) { 
                    $mass[]=[
                        array_pop($mass_sort),
                        array_pop($mass_sort)
                    ];
                }
                $arr =  $mass;
                $raspisanie[] = $raspisanie_tur;
            }
           
           return $raspisanie;
            echo "<pre>";
            print_r($json);
            echo "</pre>";exit;
       }
    }

    public function getScheduleCupDuble () 
    {

           
        
            $json = json_decode($this->cup);
            
            $arr = $json->teams;
            $raspisanie = [];
            $raspisanie_duble = [];
            $state_duble = [];

            if(count($json->results[0])<=1) {
                 foreach ($arr as $key_t => $teams) {
                    $one_match =[];
                    $one_match['players1'] = $teams[0];
                    $one_match['players2'] = $teams[1];
                    $one_match['rezult1'] = 0;
                    $one_match['rezult2'] = 0;
                    $one_match['date'] = $this->start_date;
                    $raspisanie[] = $one_match;
                      
                }
                $raspisanie = [$raspisanie];
                  // echo "<pre>";
                  //   print_r($raspisanie);
                  //    echo "</pre>";exit;
                return $raspisanie;
            }

            foreach ($json->results[0] as $key_r => $value) {
                $mass = [];
                $mass_sort =[];
                $mass_sort_duble =[];
                $one_match =[];
                $one_match_d =[];
                $raspisanie_tur = [];
                $mass_duble = [];
                foreach ($arr as $key_t => $teams) {


                    if (empty($value[$key_t])) break;
                    if($value[$key_t][0] != $value[$key_t][1]) {

                        $one_match['players1'] = $teams[0];
                        $one_match['players2'] = $teams[1];
                        $one_match['rezult1'] = $value[$key_t][0]??0;
                        $one_match['rezult2'] = $value[$key_t][1]??0;
                        $one_match['date'] = $this->start_date;

                        if ($value[$key_t][0] > $value[$key_t][1]) {
                            $mass_sort[] = $teams[0];
                            $mass_sort_duble[] = $teams[1];
                        }elseif ($value[$key_t][0] < $value[$key_t][1]) {
                            $mass_sort[] = $teams[1];
                            $mass_sort_duble[] = $teams[0];
                                                    
                            
                            
                        }    
                        //print_r($teams[0]);
                        //echo "<br>";                
                        $raspisanie_tur[] = $one_match;

                    } else {
                        $bye = new \stdClass(); 
                        $bye->name = 'bye';
                        $mass_sort[] = $bye;

                        $one_match['players1'] = $teams[0];
                        $one_match['players2'] = $teams[1];
                        $one_match['rezult1'] = 0;
                        $one_match['rezult2'] = 0;
                        $one_match['date'] = $this->start_date;
                        $raspisanie_duble[] = $one_match;

                    }
                }

                // print_r($mass_sort_duble);
                // echo "<br>";
                // echo "<br>";

                

                $count_d = count($mass_sort_duble)/2;

                if(empty($state_duble)){
                    for ($i=0; $i < $count_d ; $i++) { 
                        $mass_duble[]=[
                            array_pop($mass_sort_duble),
                            array_pop($mass_sort_duble)
                        ];
                    }

                }else{
                    for ($i=0; $i < $count_d ; $i++) { 
                        $mass_duble[]=[
                            array_pop($mass_sort_duble),
                            array_pop($state_duble)
                        ];
                    }   
                }
                

                $arr_d = $mass_duble;
                foreach ($arr_d as $key_t => $teams) {
                    $mass_sort_d = [];
                    if($value[$key_t][0] != $value[$key_t][1]) {

                        $one_match_d['players1'] = $teams[0];
                        $one_match_d['players2'] = $teams[1];
                        $one_match_d['rezult1'] = $value[$key_t][0]??0;
                        $one_match_d['rezult2'] = $value[$key_t][1]??0;
                        $one_match_d['date'] = $this->start_date;


                        if ($value[$key_t][0] > $value[$key_t][1]) {
                            $mass_sort_d[] = $teams[0];
                            
                        }elseif ($value[$key_t][0] < $value[$key_t][1]) {
                            $mass_sort_d[] = $teams[1];
                        }
                           
                    } else {
                        $bye = new \stdClass(); 
                        $bye->name = 'bye';
                        $mass_sort_d[] = $bye;

                        $one_match_d['players1'] = $teams[0];
                        $one_match_d['players2'] = $teams[1];
                        $one_match_d['rezult1'] = 0;
                        $one_match_d['rezult2'] = 0;
                        $one_match_d['date'] = $this->start_date;
                        

                    }
                    $state_duble[] = $mass_sort_d;
                    $raspisanie_duble[] = $one_match_d;
                }
                //break;









                $count = count($mass_sort)/2;
                for ($i=0; $i < $count ; $i++) { 
                    $mass[]=[
                        array_pop($mass_sort),
                        array_pop($mass_sort)
                    ];
                }
                $arr =  $mass;
                $raspisanie[] = $raspisanie_tur;
            }

            //return $raspisanie;
            echo "<pre>";
           //print_r($json);
            print_r($raspisanie_duble);
            echo "</pre>";exit;
        
    
    }

}

